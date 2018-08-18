/*! < ())) > HTMLDB.js - v1.0.0 | https://github.com/htmldbjs/htmldbjs/ | MIT license */
var HTMLDB = {
	"readQueue": [],
	"readingQueue": [],
	"readQueueCallbacks": [],
	"activeFormFields": [],
	"indexedDB": null,
	"indexedDBConnection": null,
	"indexedDBTables": [],
	"initialize": function () {
		HTMLDB.initializeHTMLDBIndexedDB(function () {
			HTMLDB.initializeHTMLDBTables();
			HTMLDB.initializeHTMLDBFormTables();
			HTMLDB.initializeHTMLDBTemplates();
			HTMLDB.initializeHTMLDBButtons();
			HTMLDB.initializeHTMLDBInputs();
			HTMLDB.initializeHTMLDBPaginations();
			HTMLDB.initializeHTMLDBSections();
			HTMLDB.initializeHTMLDBForms();
			HTMLDB.initializeHTMLDBSelects();
			HTMLDB.initializeHTMLDBToggles();
			HTMLDB.initializeHTMLDBUpdaters();
			HTMLDB.initializeReadQueue();
			HTMLDB.resetWriterLoop();
		});
	},
	"stop": function (tableElementId) {
		var tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
			return;
		}
		tableElement.setAttribute("data-htmldb-loading", 0);
		HTMLDB.hideLoaders();
	},
	"read": function (tableElementId, functionDone) {
		var tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " will be readed, but not found."));
			return false;
		}

		var loading = parseInt(
				tableElement.getAttribute("data-htmldb-loading"));

		if (loading > 0) {
			return true;
		}

		var parentTable = HTMLDB.getHTMLDBParameter(tableElement, "table");

		if (parentTable != "") {
			return HTMLDB.readChildTable(tableElementId, functionDone);
		}

		var parentForm = HTMLDB.getHTMLDBParameter(tableElement, "form");

		var readURL = HTMLDB.getHTMLDBParameter(tableElement, "read-url");
		readURL = HTMLDB.evaluateHTMLDBExpression(readURL, parentForm);

		if ("" == readURL) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " read URL attribute is empty."));
			return false;
		}

		var tbodyHTMLDB = document.getElementById(
				tableElementId
				+ "_reader_tbody");

		if (!HTMLDB.isHTMLDBParameter(tableElement, "read-incremental")) {
			tbodyHTMLDB.innerHTML = "";
		}

		var iframeFormGUID = document.getElementById(
				tableElementId
				+ "_iframe_container").children.length;
		HTMLDB.createNewIframeAndForm(tableElementId, iframeFormGUID);

		var target = (tableElementId + "_iframe_" + iframeFormGUID);
		
		if (!document.getElementById(target)) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " target iframe not found."));
			return false;
		}

		var iframeHTMLDB = document.getElementById(target);
		var iframeNewElement = iframeHTMLDB.cloneNode(true);
		iframeHTMLDB.parentNode.replaceChild(iframeNewElement, iframeHTMLDB);
		iframeHTMLDB = iframeNewElement;
		tableElement.setAttribute("data-htmldb-loading", 1);
		HTMLDB.showLoader(tableElementId, "read");

		var funcIframeLoadCallback = HTMLDB.doReaderIframeLoad;

		if (functionDone) {
			funcIframeLoadCallback = function (evEvent) {
				tableElement.setAttribute("data-htmldb-loading", 0);
				HTMLDB.hideLoader(tableElementId, "read");
				HTMLDB.doReaderIframeDefaultLoad(evEvent, true);
				functionDone(tableElementId);
			}
		}

		if (iframeHTMLDB.addEventListener) {
			iframeHTMLDB.addEventListener("load", funcIframeLoadCallback, true);
		} else if (iframeHTMLDB.attachEvent) {
            iframeHTMLDB.attachEvent("onload", funcIframeLoadCallback);
        }

        try {
			var dtNow = new Date();
			if (-1 == readURL.indexOf("?")) {
				readURL += ("?nocache=" + dtNow.getTime());
			} else {
				readURL += ("&nocache=" + dtNow.getTime());
			}
			iframeHTMLDB.src = readURL;
		} catch(e) {
        	throw(new Error("An error occured while reading HTMLDB table "
        			+ tableElementId
        			+ "."));
			return false;
		}
	},
	"updateTableFilterFunction": function(tableElement) {
		tableElement.filterFunction = null;
		if (HTMLDB.hasHTMLDBParameter(tableElement, "filter")) {
			var functionBody = HTMLDB.generateTableFilterFunctionString(
					tableElement);

			try {
				tableElement.filterFunction
						= new Function(
						"object",
						functionBody);
			} catch (e) {
	        	throw(new Error("HTMLDB table "
	        			+ tableElementId
	        			+ " filter function could not be created."));
				return false;
			}
		}
	},
	"validate": function (tableElementId, object, functionDone) {
		var tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " will be readed, but not found."));
			return false;
		}

		var loading = parseInt(tableElement.getAttribute("data-htmldb-loading"));

		if (loading > 0) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is loading right now."));
			return false;
		}

		if (object["id"] == undefined) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " rows must have unique id field."));
			return false;
		}

		HTMLDB.validateLocal(tableElementId, object, function(tableElementId, responseText) {
			var responseObject = null;
			try {
				responseObject = JSON.parse(String(decodeURIComponent(responseText)).trim());
			} catch(e) {
	        	throw(new Error("HTMLDB table "
	        			+ tableElementId
	        			+ " could not be validated: Not valid JSON format"));
				return false;
			}

			if (responseObject.errorCount > 0) {
				if (functionDone) {
					functionDone(tableElementId, responseText);
				} else {
					HTMLDB.showError(tableElementId, responseObject.lastError);
				}
			} else {
				var validateURL = HTMLDB.getHTMLDBParameter(tableElement, "validate-url");
				validateURL = HTMLDB.evaluateHTMLDBExpression(validateURL);

				if (validateURL != "") {
					HTMLDB.validateRemote(tableElementId, object, functionDone);
				} else if (functionDone) {
					functionDone(tableElementId, responseText);
				}
			}
		});
	},
	"validateLocal": function (tableElementId, object, functionDone) {
		var tableElement = document.getElementById(tableElementId);
        var validations = document.body.querySelectorAll(".htmldb-table-validation");
        var validationCount = validations.length;
        var validation = null;
        var validationResponse = {
        	"errorCount": 0,
        	"messageCount": 0,
        	"lastError": "",
        	"lastMessage": ""
        };
        var currentResponse = {
        	"errorCount": 0,
        	"messageCount": 0,
        	"lastError": "",
        	"lastMessage": ""	
        }
        for (var i = 0; i < validationCount; i++) {
            validation = validations[i];
            if (HTMLDB.getHTMLDBParameter(validation, "table")
            		== tableElement.getAttribute("id")) {
            	currentResponse = checkTableValidation(
            			tableElement,
            			object,
            			validation);
            	validationResponse.errorCount += currentResponse.errorCount;
            	validationResponse.messageCount += currentResponse.messageCount;
            	validationResponse.lastError += currentResponse.lastError;
            	validationResponse.lastMessage += currentResponse.lastMessage;
            }
        }

        if (functionDone) {
        	functionDone(tableElementId, JSON.stringify(validationResponse));
        }

        return;
	},
	"checkTableValidation": function (tableElement, object, validationElement) {
		var validationItems = validationElement.children;
		var validationItemCount = validationItems.length;
		var validationItem = null;
		var filter = "";
		var functionBody = "";
		var filterFunction = null;
		var currentResponse = {
        	"errorCount": 0,
        	"messageCount": 0,
        	"lastError": "",
        	"lastMessage": ""
        }

		for (var i = 0; i < validationItemCount; i++) {
			validationItem = validationItems[i];
			filter = HTMLDB.getHTMLDBParameter(validationItem, "validation");

			if ("" == filter) {
				continue;
			}

			functionBody = "success=false;";
			functionBody += HTMLDB.generateFilterFunctionBlock(
					filter,
					tableElement);
			functionBody += "return success;";

			try {
				filterFunction = new Function("object", functionBody);
				if (!filterFunction(object)) {
					currentResponse.errorCount += 1;
					currentResponse.lastError += validationItem.innerHTML;
				}
			} catch (e) {
	        	throw(new Error("HTMLDB table "
	        			+ tableElement.getAttribute("id")
	        			+ " validation function could not be created."));
				return currentResponse;
			}

		}

		return currentResponse;
	},
	"validateRemote": function (tableElementId, object, functionDone) {
		var tableElement = document.getElementById(tableElementId);
		var validateURL = HTMLDB.getHTMLDBParameter(tableElement, "validate-url");
		validateURL = HTMLDB.evaluateHTMLDBExpression(validateURL);

		if ("" == validateURL) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " validate URL attribute is empty."));
			return false;
		}

		var iframeFormGUID = document.getElementById(
				tableElementId
				+ "_iframe_container").children.length;
		HTMLDB.createNewIframeAndForm(tableElementId, iframeFormGUID);

		var target = (tableElementId + "_iframe_" + iframeFormGUID);
		if (!document.getElementById(target)) {
			return false;
		}

		var formHTMLDB
				= document.getElementById(
				tableElementId
				+ "_form_"
				+ iframeFormGUID);
		var iframeHTMLDB = document.getElementById(target);
		var iframeNewElement = iframeHTMLDB.cloneNode(true);
		iframeHTMLDB.parentNode.replaceChild(iframeNewElement, iframeHTMLDB);
		iframeHTMLDB = iframeNewElement;

		tableElement.setAttribute("data-htmldb-loading", 1);
		HTMLDB.showLoader(tableElementId, "validate");

		var funcIframeLoadCallback = HTMLDB.doValidatorIframeLoad;

		if (functionDone) {
			funcIframeLoadCallback = function () {
				tableElement.setAttribute("data-htmldb-loading", 0);
				HTMLDB.hideLoader(tableElementId, "validate");
				iframeWindow = top.frames[
						tableElementId
						+ "_iframe_"
						+ iframeFormGUID];
				var strResponse = "";
				if (iframeWindow.document) {
					strResponse = String(
							iframeWindow.document.body.innerHTML).trim();
				}
				HTMLDB.removeIframeAndForm(tableElementId, iframeFormGUID);
				functionDone(tableElementId, strResponse);
			}
		}

		if (iframeHTMLDB.addEventListener) {
			iframeHTMLDB.addEventListener("load", funcIframeLoadCallback, true);
		} else if (iframeHTMLDB.attachEvent) {
            iframeHTMLDB.attachEvent("onload", funcIframeLoadCallback);
        }

        formHTMLDB.innerHTML = "";

		var formContent = "<input class=\"htmldb_action\""
				+ " type=\"hidden\" name=\""
				+ "htmldb_action0"
				+ "\" value=\""
				+ ((0 == object["id"]) ? "inserted" : "updated")
				+ "\" />";

		var propertyName = "";

		for (var propertyName in object) {
        	if (object.hasOwnProperty(propertyName)) {
				formContent += "<input class=\"htmldb_row\""
						+ " type=\"hidden\" name=\""
						+ "htmldb_row0_" + propertyName
				 		+ "\" value='"
						+ HTMLDB.addSingleQuoteSlashes(object[propertyName])
						+ "' />";
        	}
    	}

		formHTMLDB.innerHTML = formContent;
        formHTMLDB.action = validateURL;

        try {
			formHTMLDB.submit();
		} catch(e) {
		}
	},
	"write": function (tableElementId, delayed, functionDone) {
		var tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " will be readed, but not found."));
			return false;
		}

		var loading = parseInt(
				tableElement.getAttribute("data-htmldb-loading"));

		if (loading > 0) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is loading right now."));
			return false;
		}

		if (true === delayed) {
			// Delayed Write
			clearTimeout(tableElement.tmWriteTimer);
			lWriteDelay = parseInt(
					tableElement.getAttribute("data-write-delay"));
			if (isNaN(lWriteDelay)) {
				lWriteDelay = 2000;
			}
			tableElement.tmWriteTimer = setTimeout(function () {
				clearTimeout(tableElement.tmWriteTimer);
				HTMLDB.write(tableElementId, false, functionDone);
			}, lWriteDelay);
			return;
		}

		var writeURL = HTMLDB.getHTMLDBParameter(tableElement, "write-url");
		writeURL = HTMLDB.evaluateHTMLDBExpression(writeURL);

		if ("" == writeURL) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " write URL attribute is empty."));
			return false;
		}

		var iframeFormGUID
				= document.getElementById(
				tableElementId
				+ "_iframe_container").children.length;
		HTMLDB.createNewIframeAndForm(tableElementId, iframeFormGUID);

		var strTarget = (tableElementId + "_iframe_" + iframeFormGUID);
		if (!document.getElementById(strTarget)) {
			return;
		}

		var tbodyHTMLDB = document.getElementById(
				tableElementId + "_writer_tbody");
		var arrTR = tbodyHTMLDB.children;
		var arrTD = null;
		var elTR = null;
		var lTRCount = arrTR.length;
		var formHTMLDB = document.getElementById(
				tableElementId + "_form_" + iframeFormGUID);
		var iframeHTMLDB = document.getElementById(strTarget);
		var iframeNewElement = iframeHTMLDB.cloneNode(true);
		iframeHTMLDB.parentNode.replaceChild(iframeNewElement, iframeHTMLDB);
		iframeHTMLDB = iframeNewElement;

		tableElement.setAttribute("data-htmldb-loading", 1);
		HTMLDB.showLoader(tableElementId, "write");

		var funcIframeLoadCallback = HTMLDB.doWriterIframeLoad;

		if (functionDone) {
			funcIframeLoadCallback = function () {
				tableElement.setAttribute("data-htmldb-loading", 0);
				HTMLDB.hideLoader(tableElementId, "write");
				iframeWindow = top.frames[
						tableElementId + "_iframe_" + iframeFormGUID];
				var strResponse = "";
				if (iframeWindow.document) {
					strResponse = String(
							iframeWindow.document.body.innerHTML).trim();
				}
				HTMLDB.removeIframeAndForm(tableElementId, iframeFormGUID);
				functionDone(tableElementId, strResponse);
				var redirectURL = HTMLDB.getHTMLDBParameter(
						tableElement,
						"redirect");
				redirectURL = HTMLDB.evaluateHTMLDBExpression(redirectURL);
				if (redirectURL != "") {
					window.location = redirectURL;
				}
			}
		}

		if (iframeHTMLDB.addEventListener) {
			iframeHTMLDB.addEventListener("load", funcIframeLoadCallback, true);
		} else if (iframeHTMLDB.attachEvent) {
            iframeHTMLDB.attachEvent("onload", funcIframeLoadCallback);
        }

        formHTMLDB.innerHTML = "";

        for (var lCurrentTRIndex = 0;
        		lCurrentTRIndex < lTRCount;
        		lCurrentTRIndex++) {
        	elTR = arrTR[lCurrentTRIndex];
        	
        	if (!elTR) {
        		continue;
        	}

        	if ((elTR.className.indexOf("updated") != -1)
        			|| (elTR.className.indexOf("inserted") != -1)
        			|| (elTR.className.indexOf("deleted") != -1)) {
	        	HTMLDB.generateFormHTML(tableElement, iframeFormGUID, elTR);
	        	
	        	if (!functionDone) {
	        		elTR.parentNode.removeChild(elTR);
	        		lCurrentTRIndex--;
	        	}
        	}
        }

        formHTMLDB.action = writeURL;

        try {
			formHTMLDB.submit();
		} catch(e) {
		}
	},
	"readLocal": function (tableElementId, functionDone) {
		var tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " will be readed, but not found."));
			return false;
		}

		var loading = parseInt(tableElement.getAttribute("data-htmldb-loading"));

		if (loading > 0) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is loading right now."));
			return false;
		}

		tableElement.setAttribute("data-htmldb-loading", 1);
		HTMLDB.showLoader(tableElementId, "read");
		tableElement.setAttribute("data-htmldb-loading", 0);
		HTMLDB.hideLoader(tableElementId, "read");
		HTMLDB.initializeLocalTable(tableElement);

		tableElement.dispatchEvent(
				new CustomEvent(
				"htmldbread",
				{detail: {}}));

		setTimeout(function () {
			HTMLDB.callReadQueueCallbacks(tableElement);
			HTMLDB.removeFromReadingQueue(tableElement.getAttribute("id"));
			HTMLDB.processReadQueue();
		}, 150);

		if (functionDone) {
			functionDone(tableElementId);
		}
	},
	"get": function (tableElementId, id) {
		var elDIV = document.getElementById(tableElementId);

		if (!elDIV) {
			return {};
		}

		var elTR = document.getElementById(tableElementId
					+ "_reader_tr"
					+ id);
		var prefixLength = String(tableElementId + "_reader_td" + id).length;

		if (!elTR) {
			return {};
		}

		var elTDList = elTR.children;
		var elTD = null;
		var elTDCount = elTDList.length;
		var JSONString = "";

		for (var i = 0; i < elTDCount; i++) {
			elTD = elTDList[i];

			if (JSONString != "") {
				JSONString += ",";
			}

			JSONString += "\""
					+ String(elTD.getAttribute("id")).substring(prefixLength)
					+ "\":\""
					+ HTMLDB.ejs(elTD.innerHTML)
					+ "\"";
		}

		JSONString = "{" + JSONString + "}";

		return JSON.parse(JSONString);
	},
	"insert": function (tableElementId, object, className) {
		var tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
			return;
		}

		if (undefined === className) {
			className = "";
		}

		if (!HTMLDB.isNewObject(object)) {
			return HTMLDB.update(tableElementId, object["id"], object, className);			
		}

		var tbodyHTMLDB = document.getElementById(
				tableElementId
				+ "_writer_tbody");

		var newId = HTMLDB.generateDateTimeGUID();

		var strTRContent = "<tr class=\"inserted"
				+ ((className!="") ? (" " + className) : "")
				+ "\" data-row-id=\"n"
				+ newId
				+ "\" id=\""
				+ tableElement.getAttribute("id")
				+"_writer_trn"
				+ newId
				+"\">";
		strTRContent += HTMLDB.generateTDHTML(
				tableElement,
				"_writer",
				object,
				("n" + newId));
    	strTRContent += "</tr>";

    	tbodyHTMLDB.innerHTML += strTRContent;

    	if (HTMLDB.isHTMLDBParameter(tableElement, "local")) {
    		tbodyHTMLDB = document.getElementById(
    				tableElementId
    				+ "_reader_tbody");

    		object["id"] = ("n" + newId);

			strTRContent = "<tr class=\"inserted"
					+ ((className!="") ? (" " + className) : "")
					+ "\" data-row-id=\"n"
					+ newId
					+ "\" id=\""
					+ tableElement.getAttribute("id")
					+"_reader_trn"
					+ newId
					+"\">";
			strTRContent += HTMLDB.generateTDHTML(
					tableElement,
					"_reader",
					object,
					("n" + newId));
    		strTRContent += "</tr>";

    		tbodyHTMLDB.innerHTML += strTRContent;
    		HTMLDB.updateLocal(tableElement, object["id"], object);
    		HTMLDB.render(tableElement);
    	}
	},
	"update": function (tableElementId, id, object, className) {
		var tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
			return;
		}

		if (undefined === className) {
			className = "";
		}

		object["id"] = id;

		if (HTMLDB.isNewObject(object)) {
			return HTMLDB.insert(tableElementId, object, className);
		}

		var elTR = document.getElementById(tableElementId + "_writer_tr" + id);

		var tbodyHTMLDB = document.getElementById(
				tableElementId
				+ "_writer_tbody");

		var innerContent = HTMLDB.generateTDHTML(
				tableElement,
				"_writer",
				object,
				id);
		var outerContentHeader = "";
		var outerContentFooter = "";

		if (!elTR) {
			outerContentHeader = "<tr class=\"updated"
					+ ((className!="") ? (" " + className) : "")
					+ "\" data-row-id=\""
					+ id
					+ "\" id=\""
					+ tableElement.getAttribute("id")
					+"_writer_tr"
					+ id
					+"\">";
    		outerContentFooter = "</tr>";
    		tbodyHTMLDB.innerHTML += (outerContentHeader + innerContent + outerContentFooter);
		} else {
			elTR.innerHTML = innerContent;
			if (-1 == elTR.className.indexOf("inserted")) {
				elTR.className = "updated"
						+ ((className!="")
						? (" " + className)
						: "");
			}
		}

    	if (HTMLDB.isHTMLDBParameter(tableElement, "local")) {
    		elTR = document.getElementById(tableElementId + "_reader_tr" + id);
    		if (!elTR) {
    			return;
    		}
			tbodyHTMLDB = document.getElementById(
					tableElementId
					+ "_reader_tbody");
			innerContent = HTMLDB.generateTDHTML(
					tableElement,
					"_reader",
					object, id);
			elTR.innerHTML = innerContent;
    		HTMLDB.updateLocal(tableElement, id, object);
    		HTMLDB.render(tableElement);
    	}
	},
	"updateLocal": function (tableElement, id, object, updateOnlyReaderTable) {
		if (null == HTMLDB.indexedDBConnection) {
        	throw(new Error("HTMLDB IndexedDB not initialized."));
			return false;
		}
		var database = HTMLDB.indexedDBConnection.result;
		var readerTransaction = database.transaction(
				("htmldb_" + tableElement.getAttribute("id") + "_reader"),
				"readwrite");
		var writerTransaction = database.transaction(
				("htmldb_" + tableElement.getAttribute("id") + "_writer"),
				"readwrite");
		var readerStore = readerTransaction.objectStore(
				"htmldb_" + tableElement.getAttribute("id") + "_reader");
		var writerStore = writerTransaction.objectStore(
				"htmldb_" + tableElement.getAttribute("id") + "_writer");

		object["id"] = id;

		readerStore.put(object, HTMLDB.addLeadingZeros(id, 20));

		if (true !== updateOnlyReaderTable) {
			writerStore.put(object, HTMLDB.addLeadingZeros(id, 20));
		}
	},
	"delete": function (tableElementId, p2, p3) {
		var elDIV = document.getElementById(tableElementId);
		if (!elDIV) {
			return;
		}

		if (undefined === p3) {
			p3 = "";
		}

		var trDeleted = document.getElementById(
				tableElementId
				+ "_writer_tr"
				+ p2);
		if (trDeleted) {
			trDeleted.className = "deleted" + ((p3!="") ? (" " + p3) : "");
		}
	},
	"render": function (tableElement, functionDone) {
		var activeId = (HTMLDB.getActiveId(tableElement));

		HTMLDB.renderTemplates(tableElement);

		if (activeId != "") {
			HTMLDB.renderPaginations(tableElement);
			HTMLDB.renderSections(tableElement);
			HTMLDB.renderForms(tableElement);
			HTMLDB.renderSelects(tableElement);
			HTMLDB.renderCheckboxGroups(tableElement);
		}

		if (functionDone) {
			functionDone();
		} else if (tableElement.doHTMLDBRender) {
			tableElement.doHTMLDBRender(tableElement);
		}
	},
	"isLoading": function () {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	if (1 == parseInt(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"loading"))) {
        		return true;
        	}
        }
        return false;
	},
	"isIdle": function () {
		if (HTMLDB.isLoading()) {
			return false;
		}
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];

        	if (HTMLDB.isHTMLDBParameter(tableElement, "local")) {
        		continue;
        	}

        	if (document.getElementById(
        			tableElement.getAttribute("id")
        			+ "_writer_tbody").children.length > 0) {
        		return false;
        	}
        }
        return true;
	},
	"getColumnNames": function (tableElementId, sortColumns) {
		var elTHead = document.getElementById(tableElementId + "_reader_thead");
		var arrTH = elTHead.children[0].children;
		var elTH = null;
		var lTHCount = arrTH.length;
		var arrReturn = new Array();

		for (var j = 0; j < lTHCount; j++) {
			elTH = arrTH[j];			
			arrReturn.push(elTH.innerHTML);
		}

		if (true === sortColumns) {
			arrReturn.sort();
		}

		return arrReturn;
	},
	"setColumnNames": function (tableElementId, object) {

		columnContent = "<tr>";

		for (var key in object){
		    if (object.hasOwnProperty(key)) {
		    	columnContent += ("<th>" + key + "</th>");
		    }
		}

		columnContent += "</tr>";

		document.getElementById(tableElementId + "_reader_thead").innerHTML = columnContent;
		document.getElementById(tableElementId + "_writer_thead").innerHTML = columnContent;
	},
	"getTableFieldActiveValue": function (tableElementId, column) {
		var tableElement = document.getElementById(tableElementId);

		if (!tableElement) {
        	throw(new Error("HTMLDB table/form "
        			+ tableElementId
        			+ " is referenced, but not found."));
			return false;
		}

		if (tableElement.className.indexOf("htmldb-form") != -1) {
			return HTMLDB.getFormFieldActiveValue(tableElementId, column);
		}

		var activeId = (
				HTMLDB.getHTMLDBParameter(
				tableElement,
				"active-id"));

		if (activeId == "") {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is not active, or has no records."));
			return false;
		}

		columnElementId = (tableElementId + "_reader_td" + activeId + column);

		var value = "";

		if (document.getElementById(columnElementId)) {
			value = document.getElementById(
					tableElementId
					+ "_reader_td"
					+ activeId + column).innerHTML;

		} else {
			value = "";
		}

		return value;
	},
	"getFormFieldActiveValue": function (formElementId, field) {
		var formElement = document.getElementById(formElementId);
		var object = HTMLDB.convertFormToObject(formElement);

		if (undefined === object[field]) {
        	throw(new Error("HTMLDB form "
        			+ formElementId
        			+ " field "
        			+ field
        			+ " not found."));
			return false;
		}

		return object[field];
	},
	"setActiveId": function (tableElement, id, silent) {
		tableElement.setAttribute("data-htmldb-active-id", id);
		if (silent !== true) {
			HTMLDB.render(tableElement);
			HTMLDB.updateReadQueueByParentTable(tableElement);
		}
	},
	"updateReadQueueByParentTable": function (tableElement) {
		var childTableIds = HTMLDB.extractChildTables();
		var childTableIdCount = 0;
		var childTableElement = null;
		if (childTableIds[tableElement.getAttribute("id")] !== undefined) {
			childTableIds = childTableIds[tableElement.getAttribute("id")];
			childTableIdCount = childTableIds.length;
			for (var i = 0; i < childTableIdCount; i++) {
				childTableElement = document.getElementById(childTableIds[i]);
				HTMLDB.updateReadQueue(childTableElement);
			}
		}
	},
	"getActiveId": function (tableElement) {
		return tableElement.getAttribute("data-htmldb-active-id");
	},
	"resetWriterLoop": function () {
	    var HTMLDBWriterTimer = document.body.HTMLDBWriterTimer;
	    clearTimeout(HTMLDBWriterTimer);
	    HTMLDBWriterTimer = setTimeout(function () {
	    	HTMLDB.writeTables();
			HTMLDB.resetWriterLoop();
	    }, 2000);
	    document.body.HTMLDBWriterTimer = HTMLDBWriterTimer;
	},
	"writeTables": function () {
    	var elements = document.body.querySelectorAll(".htmldb-table");
    	var elementCount = elements.length;
    	var element = null;
    	var loading = false;
    	var rows = null;
    	var writerTable = null;
    	for (var i = 0; i < elementCount; i++) {
    		element = elements[i];
    		if (HTMLDB.isHTMLDBParameter(element, "read-only")) {
    			continue;
    		}
    		if (!document.getElementById(element.getAttribute("id") + "_writer_tbody")) {
    			continue;
    		}
    		if (HTMLDB.isHTMLDBParameter(element, "local")) {
    			continue;
    		}
    		loading = parseInt(HTMLDB.getHTMLDBParameter(element, "loading"));
    		if (loading > 0) {
    			continue;
    		}
    		writerTable = document.getElementById(element.getAttribute("id") + "_writer_tbody");
    		if (0 == writerTable.children.length) {
    			continue;
    		}
    		rows = writerTable.querySelectorAll("tr.updating");
    		if (rows.length > 0) {
    			continue;
    		}
    		HTMLDB.markRows(writerTable, "updating");
    		HTMLDB.write(element.getAttribute("id"),
    				false,
    				function (tableElementId, responseText) {
	    		var writerTable = document.getElementById(
	    				tableElementId
	    				+ "_writer_tbody");
    			HTMLDB.deleteMarkedRows(writerTable, "updating");
    			// If there is a record to be written, write them first...
    			if (0 == writerTable.children.length) {
    				HTMLDB.doTableWrite(
    						document.getElementById(
    						tableElementId));
    			} else {
    				HTMLDB.writeTables();
    			}
    		});
    	}
	},
	"canWriteTable": function (tableElementId) {
		var writerTable = document.getElementById(tableElementId + "_writer_tbody");

		if (!writerTable) {
			return false;
		}

    	if (0 == writerTable.children.length) {
    		return false;
		}

		return true;
	},
	"doTableWrite": function (tableElement) {
		if (HTMLDB.isHTMLDBParameter(tableElement, "write-only")) {
			return true;
		}
		var redirectURL = HTMLDB.getHTMLDBParameter(tableElement, "redirect");
		if (redirectURL != "") {
			window.location.href = redirectURL;
		}
		document.getElementById(
				tableElement.getAttribute("id")
				+ "_reader_tbody").innerHTML
				= "";
		HTMLDB.updateReadQueue(tableElement);
	},
	"updateReadQueue": function (tableElement) {
		var tableIds = [];
		var tableId = "";
		var tableIdCount = 0;
		var priority = 0;

		tableIds.push(tableElement.getAttribute("id"));

		var childTableIds = HTMLDB.extractChildTables();
		if (childTableIds[tableElement.getAttribute("id")] !== undefined) {
			tableIds = tableIds.concat(childTableIds[tableElement.getAttribute("id")]);
		}

		tableIdCount = tableIds.length;

		for (var i = 0; i < tableIdCount; i++) {
			tableId = tableIds[i];
			priority = parseInt(
					HTMLDB.getHTMLDBParameter(
					document.getElementById(tableId),
					"priority"));

			if (undefined === HTMLDB.readQueue[priority]) {
				HTMLDB.readQueue[priority] = [];
			}

			HTMLDB.readQueue[priority].push(tableId);
		}

		HTMLDB.processReadQueue();
	},
	"updateReadQueueCallbacks": function (tableElement, callbackFunction) {
		if (undefined === HTMLDB.readQueueCallbacks[tableElement.getAttribute("id")]) {
			HTMLDB.readQueueCallbacks[tableElement.getAttribute("id")] = [];
		}
		var functionCount = HTMLDB.readQueueCallbacks[tableElement.getAttribute("id")].length;
		HTMLDB.readQueueCallbacks[tableElement.getAttribute("id")][functionCount]
				= callbackFunction;
	},
	"isInReadQueue": function (tableElement) {
		for (var priority in HTMLDB.readQueue){
		    if (HTMLDB.readQueue[priority].indexOf(tableElement.getAttribute("id")) != -1) {
		    	return true;
		    }
		}
		return false;
	},
	"markRows": function (parent, className) {
		var rows = parent.children;
		var rowCount = rows.length;
		var row = null;
		for (var i = 0; i < rowCount; i++) {
			row = rows[i];
			if (-1 == row.className.indexOf(className)) {
				if (row.className != "") {
					row.className += " ";
				}
				row.className += className;
			}
		}
	},
	"deleteMarkedRows": function (parent, className) {
		var elements = parent.getElementsByClassName(className);
		while (elements.length > 0) {
			parent.removeChild(elements[0]);
		}
	},
	"renderTemplates": function (tableElement) {
		var rows = document.getElementById(
				tableElement.getAttribute("id")
				+ "_reader_tbody").children;
        var templateElements
        		= document.body.querySelectorAll(".htmldb-template");
        var templateElementCount = templateElements.length;
        var templateElement = null;
        var targetElementId = "";
        var targetElement = null;

        // Clear Template Target Contents
        var targetCount = tableElement.HTMLDBTemplateTargets.length;
        var targetId = "";

        for (var i = 0; i < targetCount; i++) {
        	targetId = tableElement.HTMLDBTemplateTargets[i];
        	if (document.getElementById(targetId)) {
        		document.getElementById(targetId).innerHTML = "";
        	}
        } // for (var i = 0; i < targetCount; i++) {

		for (var i = 0; i < templateElementCount; i++) {
			templateElement = templateElements[i];
			if (tableElement.getAttribute("id")
					!= HTMLDB.getHTMLDBParameter(templateElement, "table")) {
				continue;
			}

			/*
			targetElement = null;
			targetElementId
					= HTMLDB.getHTMLDBParameter(
					templateElement,
					"template-target");

			if ("" == targetElementId) {
	        	throw(new Error("HTMLDB template (index: " + i + ") "
	        			+ " target element not specified."));
				return false;
			}

	        if (targetElementId != "") {
	        	targetElement = document.getElementById(targetElementId);
	        }

	        if (!targetElement) {
	        	throw(new Error("HTMLDB template (index: " + i + ") "
	        			+ " target element "
	        			+ targetElementId
	        			+ " not found."));
				return false;
	        }
	        */

			if (templateElement.renderFunction) {
				templateElement.renderFunction(tableElement, rows);
				HTMLDB.initializeHTMLDBButtons(targetElement);
				templateElement.dispatchEvent(
						new CustomEvent(
						"htmldbrender",
						{detail: {"targets": tableElement.HTMLDBTemplateTargets}}));
			}
		}
	},
	"renderSections": function (tableElement) {
        var sections = document.body.querySelectorAll(".htmldb-section");
        var sectionCount = sections.length;
        var section = null;
        for (var i = 0; i < sectionCount; i++) {
            section = sections[i];
            if (HTMLDB.getHTMLDBParameter(section, "table") == tableElement.getAttribute("id")) {
            	HTMLDB.renderSectionElement(section);
            	HTMLDB.doParentElementToggle(section);
            }
        }
	},
	"renderForms": function (tableElement) {
        var forms = document.body.querySelectorAll(".htmldb-form");
        var formCount = forms.length;
        var form = null;
        for (var i = 0; i < formCount; i++) {
            form = forms[i];
            if (HTMLDB.getHTMLDBParameter(form, "table") == tableElement.getAttribute("id")) {
            	HTMLDB.renderFormElement(form);
            	HTMLDB.doParentElementToggle(form);
            }
        }
        HTMLDB.initializeHTMLDBEditButtons(null, tableElement);
		HTMLDB.initializeHTMLDBInputs();
	},
	"renderSelects": function (tableElement) {
        var selects = document.body.querySelectorAll("select.htmldb-field");
        var selectCount = selects.length;
        var select = null;
        for (var i = 0; i < selectCount; i++) {
            select = selects[i];
            if (HTMLDB.getHTMLDBParameter(
            		select,
            		"option-table")
            		== tableElement.getAttribute("id")) {
            	HTMLDB.renderSelectElement(select);
            }
        }
	},
	"renderPaginations": function (tableElement) {
        var paginations = document.body.querySelectorAll(".htmldb-pagination");
        var paginationCount = paginations.length;
        var pagination = null;
        for (var i = 0; i < paginationCount; i++) {
            pagination = paginations[i];
            if (HTMLDB.getHTMLDBParameter(
            		pagination,
            		"table")
            		== tableElement.getAttribute("id")) {
            	HTMLDB.renderPaginationElement(pagination);
            }
        }
	},
	"renderCheckboxGroups": function (tableElement) {
        var checkboxGroups = document.body.querySelectorAll(".htmldb-checkbox-group");
        var checkboxGroupCount = checkboxGroups.length;
        var checkboxGroup = null;
        for (var i = 0; i < checkboxGroupCount; i++) {
            checkboxGroup = checkboxGroups[i];
            if (HTMLDB.getHTMLDBParameter(
            		checkboxGroup,
            		"table")
            		== tableElement.getAttribute("id")) {
            	HTMLDB.renderCheckboxGroup(checkboxGroup);
            }
        }
	},
	"renderCheckboxGroup": function (checkboxGroup) {
		var checkboxes = checkboxGroup.querySelectorAll(".htmldb-checkbox,.htmldb-checkbox-all");
		var checkboxCount = checkboxes.length;
		var checkbox = null;
		for (var i = 0; i < checkboxCount; i++) {
			checkbox = checkboxes[i];
			checkbox.checked = false;
			if (checkbox.addEventListener) {
				checkbox.addEventListener(
						"click",
						HTMLDB.doCheckboxClick,
						true);
			} else if (checkbox.attachEvent) {
	            checkbox.attachEvent(
	            		"onclick",
	            		HTMLDB.doCheckboxClick);
	        }
		}
	},
	"doCheckboxClick": function (event) {
		var checkbox = HTMLDB.getEventTarget(event);
		var checked = checkbox.checked;
		var checkboxGroup = HTMLDB.exploreHTMLDBCheckboxGroup(checkbox);
		var checkboxes = checkboxGroup.querySelectorAll(
				".htmldb-checkbox,.htmldb-checkbox-all");
		var checkboxCount = checkboxes.length;
		var checkedCheckboxes = checkboxGroup.querySelectorAll(
				".htmldb-checkbox:checked");
		var checkedCheckboxCount = checkedCheckboxes.length;
		var checkboxesAll = checkboxGroup.querySelectorAll(
				".htmldb-checkbox-all");
		var checkboxesAllCount = checkboxesAll.length;
		var checkboxesAllChecked = false;
		if (checkbox.className.indexOf("htmldb-checkbox-all") != -1) {
			for (var i = 0; i < checkboxCount; i++) {
				checkbox = checkboxes[i];
				checkbox.checked = checked;
			}
		} else {
			if (checkboxCount == (checkedCheckboxCount + 1)) {
				checkboxesAllChecked = true;
			} else {
				checkboxesAllChecked = false;
			}

			for (var i = 0; i < checkboxesAllCount; i++) {
				checkbox = checkboxesAll[i];
				checkbox.checked = checkboxesAllChecked;
			}
		}
		checkbox.dispatchEvent(
				new CustomEvent(
				"htmldbclick",
				{detail: {}}));
	},
	"initializeHTMLDBIndexedDB": function (functionDone) {
		HTMLDB.indexedDB = (window.indexedDB
				|| window.mozIndexedDB
				|| window.webkitIndexedDB
				|| window.msIndexedDB
				|| window.shimIndexedDB);

		if (!HTMLDB.hasLocalTable()) {
			if (functionDone) {
				functionDone();
			}
			return;
		}

		HTMLDB.indexedDBConnection = indexedDB.open("htmldb", 1);
		HTMLDB.indexedDBConnection.onupgradeneeded
				= HTMLDB.doIndexedDBUpgradeNeeded;
		HTMLDB.indexedDBConnection.onsuccess = functionDone;
	},
	"initializeHTMLDBTables": function () {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        var priority = 0;

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	HTMLDB.validateHTMLDBTableDefinition(tableElement);
        }

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	HTMLDB.createHelperElements(tableElement);
        	tableElement.style.display = "none";
        	tableElement.setAttribute("data-htmldb-loading", 0);
			tableElement.HTMLDBTemplateTargets = [];
        	priority = parseInt(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"priority"));
        	if (isNaN(priority)) {
        		priority = 0;
        		tableElement.setAttribute("data-htmldb-priority", priority);
        	}
        }

        var parents = HTMLDB.extractParentTables();

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];

        	if (0 == parents[tableElement.getAttribute("id")]) {
        		continue;
        	}

        	if (HTMLDB.getHTMLDBParameter(tableElement, "priority")
        			> HTMLDB.getMaxPriority(parents[tableElement.getAttribute("id")])) {
        		continue;
        	}

        	priority = HTMLDB.getMaxPriority(parents[tableElement.getAttribute("id")]) + 1;
        	tableElement.setAttribute("data-htmldb-priority", priority);
        }
	},
	"hasLocalTable": function () {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        var local = false;

        HTMLDB.indexedDBTables = [];

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	if (HTMLDB.isHTMLDBParameter(tableElement, "local")) {
        		HTMLDB.indexedDBTables.push(tableElement.getAttribute("id"));
        		local = true;
        	}
        }

        return local;
	},
	"initializeHTMLDBFormTables": function () {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        var formElementId = "";
        var formElement = null;
        var object = null;
        var expression = "";

        HTMLDB.activeFormFields = [];

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];

        	formElementId = HTMLDB.getHTMLDBParameter(tableElement, "form");

        	if ("" == formElementId) {
        		continue;
        	}

        	formElement = document.getElementById(formElementId);

        	if (!formElement) {
	        	throw(new Error("HTMLDB form "
	        			+ formElementId
	        			+ " referenced by "
	        			+ tableElement.getAttribute("id")
	        			+ ", but not found."));
				return false;
        	}

        	if (undefined === HTMLDB.activeFormFields[formElementId]) {
        		HTMLDB.activeFormFields[formElementId] = [];
        	}

        	expression = HTMLDB.getHTMLDBParameter(tableElement, "read-url")
        			+ HTMLDB.getHTMLDBParameter(tableElement, "filter");

        	object = HTMLDB.convertFormToObject(formElement);

			for(var column in object) {
				if (expression.indexOf("{{" + column + "}}") != -1) {
					if (undefined === HTMLDB.activeFormFields[formElementId][column]) {
						HTMLDB.activeFormFields[formElementId][column] = [];
					}
					HTMLDB.activeFormFields[
							formElementId][
							column].push(
							tableElement.getAttribute("id"));
				}
			}
        }
	},
	"initializeHTMLDBTemplates": function () {
        var templateElements
        		= document.body.querySelectorAll(
        		".htmldb-template");
        var templateElementCount = templateElements.length;
        var templateElement = null;
        var tableElementId = "";
        var targetElementId = "";
		var functionBody = "";

        for (var i = 0; i < templateElementCount; i++) {
        	templateElement = templateElements[i];
        	templateElement.HTMLDBGUID = HTMLDB.generateGUID();
        	HTMLDB.validateHTMLDBTemplateDefinition(templateElement);
        	tableElementId = HTMLDB.getHTMLDBParameter(
        			templateElement,
        			"table");
        	targetElementId = HTMLDB.getHTMLDBParameter(
        			templateElement,
        			"template-target");
			functionBody = HTMLDB.generateTemplateRenderFunctionString(
					templateElement,
					tableElementId,
					targetElementId);

			try {
				templateElement.renderFunction
						= new Function(
						"tableElement",
						"rows",
						functionBody);

			} catch(e) {
	        	throw(new Error("HTMLDB template (index:"
	        			+ i
	        			+ ") render function could not be created."));
				return false;
			}
        }
	},
	"initializeHTMLDBButtons": function (parent) {
		HTMLDB.initializeHTMLDBRefreshButtons(parent);
		HTMLDB.initializeHTMLDBAddButtons(parent);
		HTMLDB.initializeHTMLDBEditButtons(parent);
		HTMLDB.initializeHTMLDBSaveButtons(parent);
		HTMLDB.initializeHTMLDBSortButtons(parent);
	},
	"initializeHTMLDBInputs": function (parent) {
		HTMLDB.initializeHTMLDBSaveInputs(parent);
	},
	"initializeHTMLDBPaginations": function (parent) {
        var paginationElements
        		= document.body.querySelectorAll(
        		".htmldb-pagination");
        var paginationElementCount = paginationElements.length;
        var paginationElement = null;
        for (var i = 0; i < paginationElementCount; i++) {
        	paginationElement = paginationElements[i];
        	HTMLDB.validateHTMLDBPaginationDefinition(paginationElement);
        }
	},
	"initializeHTMLDBUpdaters": function (parent) {

	},
	"initializeLocalTable": function (tableElement) {
		if (null == HTMLDB.indexedDBConnection) {
        	throw(new Error("HTMLDB IndexedDB not initialized."));
			return false;
		}

		var database = HTMLDB.indexedDBConnection.result;
		var readerTransaction = database.transaction(
				("htmldb_" + tableElement.getAttribute("id") + "_reader"),
				"readwrite");
		var writerTransaction = database.transaction(
				("htmldb_" + tableElement.getAttribute("id") + "_writer"),
				"readwrite");
		var readerStore = readerTransaction.objectStore(
				"htmldb_" + tableElement.getAttribute("id") + "_reader");
		var writerStore = writerTransaction.objectStore(
				"htmldb_" + tableElement.getAttribute("id") + "_writer");
		var readerRequest = readerStore.getAll();
		readerRequest.onsuccess = function() {
			HTMLDB.initializeLocalTableRows(
					tableElement,
					"reader",
					readerRequest.result);
			HTMLDB.render(tableElement);
		}

		var writerRequest = writerStore.getAll();
		writerRequest.onsuccess = function() {
			HTMLDB.initializeLocalTableRows(
					tableElement,
					"writer",
					writerRequest.result);
		}
	},
	"initializeLocalTableRows": function (tableElement, tablePrefix, result) {
		var resultCount = result.length;
		var object = null;
		var id = 0;
		var content = "";
		var activeId = 0;
		var columnsExtracted = false;
		var writerTable = ((tablePrefix == "writer") ? true : false);
		var newObject = false;
		var className = "";

		HTMLDB.updateTableFilterFunction(tableElement);

		for (var i = 0; i < resultCount; i++) {
			object = result[i];
			id = object["id"];

			if (tableElement.filterFunction &&
					!tableElement.filterFunction(object)) {
				continue;
			}

			newObject = HTMLDB.isNewObject(object);

			if (writerTable) {
				className = ((newObject) ? "inserted" : "updated");
			} else {
				className = "refreshed";
			}

			content += "<tr class=\""
					+ className
					+ "\" data-row-id=\""
					+ id
					+ "\" id=\""
					+ (tableElement.getAttribute("id")
					+ "_" + tablePrefix + "_tr"
					+ id)
					+ "\">";
			content += HTMLDB.generateTDHTML(
					tableElement,
					("_"
					+ tablePrefix),
					object,
					id);
			content += "</tr>";

			if (!columnsExtracted) {
				activeId = id;
				HTMLDB.setColumnNames(tableElement.getAttribute("id"), object);
				columnsExtracted = true;
			}
		}

		document.getElementById(
				tableElement.getAttribute("id")
				+ "_"
				+ tablePrefix
				+ "_tbody").innerHTML
				= content;

		if ("reader" == tablePrefix) {
			tableElement.setAttribute("data-htmldb-active-id", activeId);			
		}
	},
	"resetForm": function (form) {
		var elements = form.elements;
		var elementCount = elements.length;
		var fieldType = "";
		form.reset();
		for (var i = 0; i < elementCount; i++) {
			fieldType = elements[i].type.toLowerCase();
			switch(fieldType) {
				case "text":
				case "password":
				case "hidden":
					elements[i].value = "";
				break;
				case "textarea":
					elements[i].innerHTML = "";
				break;
				case "radio":
				case "checkbox":
					if (elements[i].checked) {
						elements[i].checked = false;
					}
				break;
				case "select-one":
				case "select-multi":
					elements[i].selectedIndex = -1;
					elements[i].HTMLDBInitials.previousOptionValueCSV = undefined;
					elements[i].HTMLDBInitials.selectNewOption = undefined;
				break;
				default:
				break;
			}

			elements[i].dispatchEvent(new CustomEvent("htmldbreset", {detail: {}}));

			if (HTMLDB.hasHTMLDBParameter(elements[i], "reset-value")) {
				HTMLDB.setInputValue(elements[i],
						HTMLDB.evaluateHTMLDBExpression(
						HTMLDB.getHTMLDBParameter(elements[i], "reset-value")));
			}
		}
		form.dispatchEvent(new CustomEvent("htmldbreset", {detail: {}}));
	},
	"initializeHTMLDBSections": function () {
        var sections = document.body.querySelectorAll(".htmldb-section");
        var sectionCount = sections.length;
        for (var i = 0; i < sectionCount; i++) {
            HTMLDB.storeSectionElementTemplates(sections[i]);
        }
	},
    "storeSectionElementTemplates": function (element) {
        if (!element) {
            return false;
        }

        element.HTMLDBInitials = {
            "attributes":[],
            "content":""
        };

        var attributeCount = element.attributes.length;
        var attribute = null;

        for (var i = 0; i < attributeCount; i++) {

            attribute = element.attributes[i];
            if (attribute.value.indexOf("{{") != -1) {
                element.HTMLDBInitials.attributes.push(
                        {"name":attribute.name, "value":attribute.value});
            }

        }

        if (0 == element.HTMLDBInitials.attributes.length) {
            element.HTMLDBInitials.attributes = undefined;
        }

        var childrenCount = element.children.length;
        var children = null;

        for (var i = 0; i < childrenCount; i++) {
            children = element.children[i];
            HTMLDB.storeSectionElementTemplates(children);
        }

        if (0 == childrenCount) {
            if (element.innerHTML.indexOf("{{") != -1) {
                element.HTMLDBInitials.content = element.innerHTML;
            } else {
                element.HTMLDBInitials.content = undefined;
            }
        }

        if ((undefined === element.HTMLDBInitials.attributes)
                && (undefined === element.HTMLDBInitials.content)) {
            element.HTMLDBInitials = undefined;
        }
    },
	"initializeHTMLDBForms": function () {
        var forms = document.body.querySelectorAll(".htmldb-form");
        var formCount = forms.length;
        var form = null;

        for (var i = 0; i < formCount; i++) {
        	form = forms[i];
        	HTMLDB.initializeHTMLDBFormFields(form);
        }
	},
	"initializeHTMLDBFormFields": function (formElement) {
		var inputs = formElement.querySelectorAll(".htmldb-field");
		var inputCount = inputs.length;
		var input = null;
		var field = "";
		var formElementId = formElement.getAttribute("id");

		for (var i = 0; i < inputCount; i++) {
			input = inputs[i];
			field = HTMLDB.getHTMLDBParameter(input, "field");
			if (undefined !== HTMLDB.activeFormFields[formElementId]) {
				if (undefined !== HTMLDB.activeFormFields[formElementId][field]) {
					if (HTMLDB.activeFormFields[formElementId][field].length > 0) {
						HTMLDB.registerFormElementEvent(input, function () {
							HTMLDB.doActiveFormFieldUpdate(input, field);
						});
					}
				}
			}
		}
	},
	"initializeHTMLDBSelects": function () {
	},
	"initializeHTMLDBToggles": function () {
        var toggles = document.body.querySelectorAll(".htmldb-toggle");
        var toggleCount = toggles.length;
        var toggle = null;
        var parent = null;
        var parents = [];
        var parentCount = 0;
        var filter = "";
        var fields = [];
        var tableElementId = "";
        var tableElement = null;
        var functionHeader = "";
        var functionBody = "";
        var functionFooter = "";

        functionFooter = "return success;"

        for (var i = 0; i < toggleCount; i++) {
        	toggle = toggles[i];
        	parent = HTMLDB.extractToggleParentElement(toggle);

        	if (parent.className.indexOf("htmldb-form") != -1) {
	        	functionHeader = "var success=false;"
	        			+ "var object=HTMLDB.convertFormToObject("
	        			+ "document.getElementById(\""
	        			+ parent.getAttribute("id")
	        			+ "\"));";
        	} else {
        		tableElementId = HTMLDB.getHTMLDBParameter(parent, "table");
        		tableElement = document.getElementById(tableElementId);

        		if (!tableElement) {
		        	throw(new Error("HTMLDB section "
		        			+ "table "
		        			+ tableElementId
		        			+ " not found."));
					return false;
        		}

        		functionHeader = "var success=false;"
        				+ "var object=HTMLDB.get(\""
        				+ tableElementId
        				+ "\", HTMLDB.getActiveId(document.getElementById(\""
        				+ tableElementId
        				+ "\")));";
        	}

            if (null == parent) {
	        	throw(new Error("HTMLDB toggle (index: " + i + ") "
	        			+ " parent form/section "
	        			+ " not found."));
				return false;
            }

            filter = HTMLDB.getHTMLDBParameter(toggle, "filter");

            if ("" == filter) {
            	continue;
            }

            functionBody = HTMLDB.generateFilterFunctionBlock(filter, parent);
        	fields = HTMLDB.extractFormToggleFields(filter, parent);

        	try {
	        	toggle.toggleFunction = new Function(
						functionHeader
						+ functionBody
						+ functionFooter);
        	} catch(e) {
	        	throw(new Error("HTMLDB toggle (index: " + i + ") "
	        			+ " toggle function could not be created."));
				return false;
        	}

        	parents.push(parent);

        	if (undefined === parent.toggleFields) {
        		parent.toggleFields = [];
        	}

        	parent.toggleFields = parent.toggleFields.concat(fields);
        }

        parentCount = parents.length;

        for (var i = 0; i < parentCount; i++) {
        	parent = parents[i];
			if (parent.className.indexOf("htmldb-form") != -1) {
				HTMLDB.registerFormToggleEvents(parent);
			}
        }
	},
	"extractFormToggleFields": function (filter, parent) {
		var tokens = String(filter).split("/");
		var tokenCount = tokens.length;
		var fields = [];
		if ("" == filter) {
			return [];
		}
		for (var i = 0; i < tokenCount; i+=3) {
			property = HTMLDB.evaluateHTMLDBExpression(tokens[i]);
			if (property != "") {
				fields.push(property);
			}
		}
		return fields;
	},
	"registerFormToggleEvents": function (form) {
		var elements = form.elements;
		var elementCount = elements.length;
		var element = null;
		var field = "";
		if (undefined === form.toggleFields) {
			return;
		}
		if (0 == form.toggleFields.length) {
			return;
		}
		for (var i = 0; i < elementCount; i++) {
			element = elements[i];
			field = HTMLDB.getHTMLDBParameter(element, "field");
			if ("" == field) {
				continue;
			}
			if (-1 == form.toggleFields.indexOf(field)) {
				continue;
			}
			HTMLDB.registerFormElementEvent(element, function () {
				HTMLDB.doParentElementToggle(form);
			});
		}
	},
	"registerFormElementEvent": function (element, functionEvent) {
		var tagName = element.tagName.toLowerCase();
		var type = element.type.toLowerCase();
		if (tagName == "input") {
			if ((type == "checkbox") || (type == "radio")) {
				if (element.addEventListener) {
					element.addEventListener("click", functionEvent, true);
				} else if (element.attachEvent) {
		            element.attachEvent("onclick", functionEvent);
		        }
			}
		} else if (tagName == "select") {
			if (element.addEventListener) {
				element.addEventListener("change", functionEvent, true);
			} else if (element.attachEvent) {
	            element.attachEvent("onchange", functionEvent);
	        }
		}
	},
	"doParentElementToggle": function (parent) {
        var toggles = parent.querySelectorAll(".htmldb-toggle");
        var toggleCount = toggles.length;
        var toggle = null;
        for (var i = 0; i < toggleCount; i++) {
        	toggle = toggles[i];
        	if (toggle.toggleFunction) {
        		if (toggle.toggleFunction()) {
        			toggle.style.display = "block";
        		} else {
        			toggle.style.display = "none";        			
        		}
        	}
        }
	},
	"extractToggleParentElement": function (element) {
		var exit = false;
		var parent = element.parentNode;
		while (!exit && ("html" != parent.tagName.toLowerCase())) {
			if (parent.className.indexOf("htmldb-section") != -1) {
				exit = true;
			} else if (parent.className.indexOf("htmldb-form") != -1) {
				exit = true;
			}
			if (!exit) {
				parent = parent.parentNode;
			}
		}
		if (exit) {
			return parent;
		} else {
			return null;
		}
	},
    "renderSectionElement": function (element) {
        if (!element) {
            return false;
        }

        var tableElement = HTMLDB.exploreHTMLDBTable(element);
        var activeId = HTMLDB.getActiveId(tableElement);

        if ("0" == activeId) {
        	return false;
        }

        if ((element.HTMLDBInitials !== undefined)
        		&& (element.HTMLDBInitials.attributes !== undefined)) {
            var attributeCount = element.HTMLDBInitials.attributes.length;
            var attributeName = "";
            var attributeValue = "";
            var content = "";
            for (var i = 0; i < attributeCount; i++) {
                attributeName = element.HTMLDBInitials.attributes[i].name;
                attributeValue = element.HTMLDBInitials.attributes[i].value;
                content = HTMLDB.evaluateHTMLDBExpression(
                		attributeValue,
                		tableElement.getAttribute("id"));
                element.setAttribute(attributeName, content);
            }
        }

        var childrenCount = element.children.length;
        var children = null;

        for (var i = 0; i < childrenCount; i++) {
            children = element.children[i];
            HTMLDB.renderSectionElement(children);
        }

        if (0 == childrenCount) {
            if ((element.HTMLDBInitials !== undefined)
            		&& (element.HTMLDBInitials.content !== undefined)) {
                content = HTMLDB.evaluateHTMLDBExpression(
                		element.HTMLDBInitials.content,
                		tableElement.getAttribute("id"));
                element.innerHTML = content;
            } else {
            	if (HTMLDB.hasHTMLDBParameter(element, "content")) {
            		element.innerHTML
            				= HTMLDB.getHTMLDBParameter(
            				element,
            				"content");
            	} else if (HTMLDB.hasHTMLDBParameter(element, "value")) {
            		HTMLDB.setInputValue(
            				element,
            				HTMLDB.getHTMLDBParameter(
            				element,
            				"value"));
            	}
            }
        }
    },
    "renderFormElement": function (form, object) {
    	var inputs = form.querySelectorAll(".htmldb-field");
    	var inputCount = inputs.length;
    	var input = null;
    	var field = "";
    	var valueTemplate = "";
    	var tableElement = null;
    	var value = "";
    	var inputValues = [];

    	for (var i = 0; i < inputCount; i++) {
    		input = inputs[i];
    		field = HTMLDB.getHTMLDBParameter(input, "field");
    		valueTemplate = HTMLDB.getHTMLDBParameter(input, "value");
    		value = "";

    		if (undefined == object) {
    			tableElement = HTMLDB.exploreHTMLDBTable(form);
	    		value = HTMLDB.evaluateHTMLDBExpression(
	    				valueTemplate,
	    				tableElement.getAttribute("id"));
    		} else {
	    		value = HTMLDB.evaluateHTMLDBExpressionWithObject(
	    				valueTemplate,
	    				object);
    		}

    		if (undefined == input.HTMLDBInitials) {
    			input.HTMLDBInitials = {
    				"renderValue": value
    			}
    		} else {
    			input.HTMLDBInitials.renderValue = value;
    		}

			HTMLDB.setInputValue(input, value);
			inputValues[i] = value;
    	}

    	for (var i = 0; i < inputCount; i++) {
			input = inputs[i];
			input.dispatchEvent(new CustomEvent(
					"htmldbsetvalue",
					{detail: {"value": inputValues[i]}}));
    	}
    },
    "renderPaginationElement": function (element) {
		var tableElementId = HTMLDB.getHTMLDBParameter(element, "table");
		var tableElement = document.getElementById(tableElementId);
		var activeId = (HTMLDB.getActiveId(tableElement));
		var refreshTableElementIds = "";
		var refreshTables = [];
		var refreshTableCount = 0;
		var pageField = "";
		var pageFieldId = "";
		var pageCountField = "";
		var pageCountFieldId = "";
		var page = 0;
		var pageCount = 0;

		if ("" == tableElementId) {
			throw(new Error("HTMLDB pagination table not specified."));
	        return false;
		}

		if (!document.getElementById(tableElementId)) {
			throw(new Error("HTMLDB pagination table "
					+ tableElementId
					+ " not found."));
	        return false;
		}

		refreshTableElementIds
				= HTMLDB.getHTMLDBParameter(
				element,
				"refresh-table");
		refreshTables = refreshTableElementIds.split(",");
		refreshTableCount = refreshTables;
		refreshTable = null;

		if ("" == refreshTableElementIds) {
			throw(new Error("HTMLDB pagination refresh table not specified."));
	        return false;	
		}

		for (var i = 0; i < refreshTableCount; i++) {
			refreshTable = document.getElementById(refreshTables[i]);
			if (!refreshTable) {
				throw(new Error("HTMLDB table "
						+ refreshTables[i]
						+ " referenced as pagination refresh table, "
						+ "but not found."));
	        	return false;
			}
		}

		pageField = HTMLDB.getHTMLDBParameter(element, "page-field");

		if ("" == pageField) {
			throw(new Error("HTMLDB pagination data-htmldb-page-field "
					+ "attribute not specified."));
	        return false;
		}

		pageCountField = HTMLDB.getHTMLDBParameter(element, "page-count-field");

		if ("" == pageCountField) {
			throw(new Error("HTMLDB pagination data-htmldb-page-count-field "
					+ "attribute not specified."));
	        return false;	
		}

		if ("" == activeId) {
        	throw(new Error("HTMLDB pagination table "
        			+ tableElementId
        			+ " is not active, or has no records."));
			return false;
		}

		var pageFieldId = (tableElementId
				+ "_reader_td"
				+ activeId
				+ pageField);

		if (!document.getElementById(pageFieldId)) {
        	throw(new Error("HTMLDB pagination page field "
        			+ tableElementId
        			+ "."
        			+ pageField
        			+ " not found."));
			return false;
		}

		pageCountFieldId = (tableElementId
				+ "_reader_td"
				+ activeId
				+ pageCountField);

		if (!document.getElementById(pageCountFieldId)) {
        	throw(new Error("HTMLDB pagination page count field "
        			+ tableElementId
        			+ "."
        			+ pageCountField
        			+ " not found."));
			return false;
		}

		page = parseInt(document.getElementById(pageFieldId).innerHTML);

		if (isNaN(page)) {
			throw(new Error("HTMLDB pagination page value "
        			+ tableElementId
        			+ "."
        			+ pageField
        			+ " is not valid."));
			return false;
		}

		pageCount = parseInt(
				document.getElementById(
				pageCountFieldId).innerHTML);

		if (isNaN(pageCount)) {
			throw(new Error("HTMLDB pagination page count value "
        			+ tableElementId
        			+ "."
        			+ pageCountField
        			+ " is not valid."));
			return false;
		}

		element.setAttribute("data-htmldb-page", page);
		element.setAttribute("data-htmldb-page-count", pageCount);

		element.classList.remove("htmldb-loading");

		HTMLDB.removePaginationElements(element);
		HTMLDB.createPaginationElements(element);

		element.dispatchEvent(new CustomEvent("htmldbrender", {detail: {}}));
    },
    "removePaginationElements": function (element) {
		var pageElements
				= element.getElementsByClassName(
				"htmldb-pagination-element");
		while (pageElements.length > 0) {
			element.removeChild(pageElements[0]);
		}
    },
    "createPaginationElements": function (element) {
    	var page = HTMLDB.getHTMLDBParameter(element, "page");
    	var pageCount = HTMLDB.getHTMLDBParameter(element, "page-count");
		var previousTemplate = null;
		var nextTemplate = null;
		var defaultTemplate = null;
		var activeTemplate = null;
		var hiddenTemplate = null;
		var childTemplates = element.children;
		var childTemplateCount = childTemplates.length;
		var childTemplate = null;
		var pageButtons = [];

		for (var i = 0; i < childTemplateCount; i++) {
			childTemplate = childTemplates[i];
			if (-1 == childTemplate.className.indexOf(
					"htmldb-pagination-template")) {
				continue;
			}

			if (childTemplate.className.indexOf(
					"htmldb-pagination-previous")
					!= -1) {
				previousTemplate = childTemplate;
			}

			if (childTemplate.className.indexOf(
					"htmldb-pagination-next")
					!= -1) {
				nextTemplate = childTemplate;
			}

			if (childTemplate.className.indexOf(
					"htmldb-pagination-default")
					!= -1) {
				defaultTemplate = childTemplate;
			}

			if (childTemplate.className.indexOf(
					"htmldb-pagination-active")
					!= -1) {
				activeTemplate = childTemplate;
			}

			if (childTemplate.className.indexOf(
					"htmldb-pagination-hidden")
					!= -1) {
				hiddenTemplate = childTemplate;
			}

			pageButtons = childTemplate.querySelectorAll(".htmldb-button-page");

			if (0 == pageButtons.length) {
				throw(new Error("HTMLDB pagination templates must have page "
						+ "buttons specified with htmldb-button-page class."));
	        	return false;
			}
		}

		if ((null == previousTemplate)
				&& (null == nextTemplate)
				&& (null == defaultTemplate)) {
			throw(new Error("HTMLDB pagination previous-next or default"
					+ " page template(s) not specified."));
	        return false;
		}

		if ((previousTemplate != null)
				&& (null == nextTemplate)
				&& (null == defaultTemplate)) {
			throw(new Error("HTMLDB pagination previous page template "
					+ "defined but next or default page "
					+ "template not specified."));
	        return false;
		}

		if ((nextTemplate != null)
				&& (null == previousTemplate)
				&& (null == defaultTemplate)) {
			throw(new Error("HTMLDB pagination next page template defined but "
					+ "previous or default page template not specified."));
	        return false;
		}

		if (null == activeTemplate) {
			throw(new Error("HTMLDB pagination active template "
					+ "not specified."));
	        return false;	
		}

		page = parseInt(page);
		pageCount = parseInt(pageCount);
		previousPage = (page - 1);

		if (previousPage < 0) {
			previousPage = 0;
		}

		nextPage = (page + 1);

		if (nextPage >= pageCount) {
			nextPage = (pageCount - 1);
		}

		if (previousTemplate != null) {
			HTMLDB.clonePaginationElement(previousTemplate, (previousPage + 1));
		}

		if (pageCount < 7) {
			for (var i = 0; i < pageCount; i++) {
				if (i == page) {
					HTMLDB.clonePaginationElement(activeTemplate, (i + 1));
				} else {
					HTMLDB.clonePaginationElement(defaultTemplate, (i + 1));
				}
			}
		} else {

			var start = 0
			var end = (pageCount - 1);
			var leftHidden = true;
			var rightHidden = true;

			if (page < 4) {
				leftHidden = false;
				start = 0;
				end = 4;
			} else if (page > (pageCount - 5)) {
				rightHidden = false;
				start = (pageCount - 5);
				end = (pageCount - 1);
			} else {
				start = (page - 1);
				end = (page + 1);
			}

			if (leftHidden) {
				HTMLDB.clonePaginationElement(defaultTemplate, 1);
				if (hiddenTemplate != null) {
					HTMLDB.clonePaginationElement(hiddenTemplate, 0);
				}
			}

			for (var i = start; i <= end; i++) {
				if (i == page) {
					HTMLDB.clonePaginationElement(activeTemplate, (i + 1));
				} else {
					HTMLDB.clonePaginationElement(defaultTemplate, (i + 1));
				}
			}

			if (rightHidden) {
				if (hiddenTemplate != null) {
					HTMLDB.clonePaginationElement(hiddenTemplate, 0);
				}
				HTMLDB.clonePaginationElement(defaultTemplate, pageCount);
			}

		}

		if (nextTemplate != null) {
			HTMLDB.clonePaginationElement(nextTemplate, (nextPage + 1));
		}
    },
    "clonePaginationElement": function (element, page) {
		var newElement = element.cloneNode(true);
		newElement.classList.remove("htmldb-pagination-template");
		newElement.classList.add("htmldb-pagination-element");
		
		element.parentNode.appendChild(newElement);
		HTMLDB.storeSectionElementTemplates(newElement);
		HTMLDB.renderElementWithObject(newElement, {"page":page});

		var newButtons = newElement.querySelectorAll(".htmldb-button-page");
		var newButtonCount = newButtons.length;
		var newButton = null;

		for (var i = 0; i < newButtonCount; i++) {
			newButton = newButtons[i];
			newButton.setAttribute("data-htmldb-page", page);

			if (newButton.addEventListener) {
				newButton.addEventListener(
						"click",
						HTMLDB.doPaginationButtonClick,
						true);
			} else if (newButton.attachEvent) {
	            newButton.attachEvent(
	            		"onclick",
	            		HTMLDB.doPaginationButtonClick);
	        }
		}
    },
    "doPaginationButtonClick": function (event) {
    	var page = (parseInt(
    			HTMLDB.getEventTarget(event).getAttribute(
    			"data-htmldb-page"))
    			- 1);

    	if (isNaN(page)) {
			throw(new Error("HTMLDB pagination button has no valid "
					+ "data-htmldb-page attribute."));
	        return false;
    	}

    	var paginationElement = HTMLDB.exploreHTMLDBPagination(
    			HTMLDB.getEventTarget(event));
    	var tableElement = HTMLDB.exploreHTMLDBTable(
    			HTMLDB.getEventTarget(event));

    	if (!tableElement) {
			throw(new Error("HTMLDB pagination table not found."));
	        return false;
    	}

    	var className = (" " + paginationElement.className + " ");

    	if (className.indexOf(" htmldb-loading ") != -1) {
    		return false;
    	}

		paginationElement.classList.add("htmldb-loading");

		var activeId = (HTMLDB.getActiveId(tableElement));
		var sessionObject = HTMLDB.get(tableElement.getAttribute("id"), activeId);

		if (undefined === sessionObject["page"]) {
			throw(new Error("HTMLDB pagination table "
					+ tableElement.getAttribute("id")
					+ " has no page column."));
	        return false;
		}

		var defaults = HTMLDB.getHTMLDBParameter(
				paginationElement,
				"table-defaults");

		sessionObject = HTMLDB.parseObjectDefaults(sessionObject, defaults);

		sessionObject["page"] = page;

		document.getElementById(
				tableElement.getAttribute("id")
				+ "_reader_td"
				+ activeId
				+ "page").innerHTML
				= page;

		HTMLDB.insert(tableElement.getAttribute("id"), sessionObject);
		HTMLDB.updateReadQueueWithParameter(
				paginationElement,
				"refresh-table");
		paginationElement.dispatchEvent(new CustomEvent(
				"htmldbpageclick",
				{detail: {"page":page}}));
    },
    "parseObjectDefaults": function (object, defaults) {
		if ("" == defaults) {
			return object;
		}

		defaults = HTMLDB.evaluateHTMLDBExpression(defaults);

		try {
			defaultsObject = JSON.parse(String(defaults).trim());
		} catch(e) {
        	throw(new Error("HTMLDB defaults attribute value "
        			+ "has no valid JSON format"));
			return false;
		}

		for (var key in defaultsObject) {
			object[key] = defaultsObject[key];
		}

		return object;
    },
    "renderElementWithObject": function (element, object) {
        if (!element) {
            return false;
        }

        if (!object) {
            return false;
        }

        if ((element.HTMLDBInitials !== undefined)
        		&& (element.HTMLDBInitials.attributes !== undefined)) {
            var attributeCount = element.HTMLDBInitials.attributes.length;
            var attributeName = "";
            var attributeValue = "";
            var content = "";
            for (var i = 0; i < attributeCount; i++) {
                attributeName = element.HTMLDBInitials.attributes[i].name;
                attributeValue = element.HTMLDBInitials.attributes[i].value;
                content = HTMLDB.evaluateHTMLDBExpressionWithObject(
                		attributeValue,
                		object);
                element.setAttribute(attributeName, content);
            }
        }

        var childrenCount = element.children.length;
        var children = null;

        for (var i = 0; i < childrenCount; i++) {
            children = element.children[i];
            HTMLDB.renderElementWithObject(children, object);
        }

        if (0 == childrenCount) {
            if ((element.HTMLDBInitials !== undefined)
            		&& (element.HTMLDBInitials.content !== undefined)) {
                content = HTMLDB.evaluateHTMLDBExpressionWithObject(
                		element.HTMLDBInitials.content,
                		object);
                element.innerHTML = content;
            } else {
            	if (HTMLDB.hasHTMLDBParameter(element, "content")) {
            		element.innerHTML = HTMLDB.getHTMLDBParameter(
            				element,
            				"content");
            	}
            }
        }
    },
    "doActiveFormFieldUpdate": function (input, field) {
    	var tables = [];
    	var tableCount = 0;

    	var form = HTMLDB.exploreHTMLDBForm(input);
    	var formId = form.getAttribute("id");
    	var tableElement = null;
    	if (undefined === HTMLDB.activeFormFields[formId]) {
    		return;
    	}
    	if (undefined === HTMLDB.activeFormFields[formId][field]) {
    		return;
    	}
    	tables = HTMLDB.activeFormFields[formId][field];
    	if (0 == tables.length) {
    		return;
    	}
    	tableCount = tables.length;
    	for (var i = 0; i < tableCount; i++) {
			tableElement = document.getElementById(tables[i]);
			if (!tableElement) {
				throw(new Error("HTMLDB table "
						+ tables[i]
						+ " referenced by " + field
						+ " in " + formId + " but not found."));
	        	return false;
			}
			HTMLDB.updateReadQueue(tableElement);
    	}
    },
    "renderSelectElement": function (select) {
    	var tableElementId = HTMLDB.getHTMLDBParameter(select, "option-table");

    	if ("" == tableElementId) {  
			return;
    	}

    	if (!document.getElementById(tableElementId)) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " not found. Referenced by "
        			+ "data-htmldb-option-table attribute "
        			+ "of select element "
        			+ select.getAttribute("id")));
			return false;
    	}

    	var tableElement = document.getElementById(tableElementId);
    	var initialActiveId = tableElement.getAttribute(
    			"data-htmldb-active-id");
		var rows = document.getElementById(
				tableElementId
				+ "_reader_tbody").children;
		var rowCount = rows.length;
		var row = null;
		var object = null;
		var id = 0;
		var content = "";
		var title = "";
		var value = "";
		var hasRenderValue = false;
		var renderValue = "";
		var selectNewOption = false;
		var newValue = null;
		var optionValueCSV = "";
		var previousOptionValueCSV = "";
		var addNewCaption = HTMLDB.getHTMLDBParameter(select, "add-option-caption");
		var addNewFormId = HTMLDB.getHTMLDBParameter(select, "add-option-form");

		if ((addNewCaption != "") && ("" == addNewFormId)) {
        	throw(new Error("HTMLDB select element "
        			+ select.getAttribute("id")
        			+ " data-htmldb-add-option-caption attribute value"
        			+ " is specified, but data-htmldb-add-option-form"
        			+ " attribute value is not specified."));
			return false;
		}

		select.innerHTML = "";

		if (addNewCaption != "") {
			select.options[0]
 					= new Option((" " + addNewCaption), addNewCaption);

			if (select.addEventListener) {
				select.addEventListener(
						"change",
						HTMLDB.doSelectChange,
						true);
			} else if (select.attachEvent) {
	            select.attachEvent(
	            		"onchange",
	            		HTMLDB.doSelectChange);
	        }
		}

		optionValueCSV = "";

		for (var i = 0; i < rowCount; i++) {
			row = rows[i];
			id = HTMLDB.getHTMLDBParameter(row, "data-row-id");
			object = HTMLDB.convertRowToObject(tableElementId, row);
			tableElement.setAttribute("data-htmldb-active-id", id);
			title = HTMLDB.evaluateHTMLDBExpression(
					HTMLDB.getHTMLDBParameter(
					select,
					"option-title"),
					tableElementId);
			value = HTMLDB.evaluateHTMLDBExpression(
					HTMLDB.getHTMLDBParameter(
					select,
					"option-value"),
					tableElementId);
 			select.options[select.options.length]
 					= new Option(title, value);

 			if (optionValueCSV != "") {
 				optionValueCSV += ",";
 			}

 			optionValueCSV += value;
		}

		if (undefined !== select.HTMLDBInitials) {
			if (undefined !== select.HTMLDBInitials.renderValue) {
				hasRenderValue = true;
				renderValue = select.HTMLDBInitials.renderValue;
			}

			if (undefined !== select.HTMLDBInitials.selectNewOption) {
				selectNewOption = select.HTMLDBInitials.selectNewOption;
			}

			if (undefined !== select.HTMLDBInitials.optionValueCSV) {
				previousOptionValueCSV = select.HTMLDBInitials.optionValueCSV;
			}
		}

        select.HTMLDBInitials = {
            "content":select.innerHTML,
            "optionValueCSV": optionValueCSV,
            "previousOptionValueCSV": previousOptionValueCSV
        };

		tableElement.setAttribute("data-htmldb-active-id", initialActiveId);
		select.dispatchEvent(new CustomEvent("htmldbsetoptions", {detail: {}}));

		if (selectNewOption) {
			newValue = HTMLDB.getSelectNewOptionValue(select);
			if (newValue != null) {
				HTMLDB.setInputValue(select, newValue);
				select.dispatchEvent(new CustomEvent(
						"htmldbsetvalue",
						{detail: {"value": newValue}}));
			}
		} else if (hasRenderValue) {
			HTMLDB.setInputValue(select, renderValue);
			select.dispatchEvent(new CustomEvent(
					"htmldbsetvalue",
					{detail: {"value": renderValue}}));
		}
    },
    "getSelectNewOptionValue": function (select) {
    	var optionValueCSV = "";
    	var previousOptionValueCSV = "";

    	if (undefined !== select.HTMLDBInitials) {
    		if (undefined !== select.HTMLDBInitials.previousOptionValueCSV) {
    			previousOptionValueCSV = select.HTMLDBInitials.previousOptionValueCSV;
    		}
    		if (undefined !== select.HTMLDBInitials.optionValueCSV) {
    			optionValueCSV = select.HTMLDBInitials.optionValueCSV;
    		}
    	}

    	var previousOptionValues = previousOptionValueCSV.split(",");
    	var optionValues = optionValueCSV.split(",");
    	var optionValueCount = optionValues.length;

    	for (var i = 0; i < optionValueCount; i++) {
    		if (-1 == previousOptionValues.indexOf(optionValues[i])) {
    			return optionValues[i];
    		}
    	}

		return null;
    },
	"initializeHTMLDBRefreshButtons": function (parent) {
		if ((undefined === parent) || (null === parent)) {
			parent = document.body;
		}
        var buttonElements = parent.querySelectorAll(".htmldb-button-refresh");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener(
						"click",
						HTMLDB.doRefreshButtonClick,
						true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent(
	            		"onclick",
	            		HTMLDB.doRefreshButtonClick);
	        }
	    }
	},
	"initializeHTMLDBAddButtons": function (parent) {
		if ((undefined === parent) || (null === parent)) {
			parent = document.body;
		}
        var buttonElements = parent.querySelectorAll(".htmldb-button-add");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener(
						"click",
						HTMLDB.doAddButtonClick,
						true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent(
	            		"onclick",
	            		HTMLDB.doAddButtonClick);
	        }
	    }
	},
	"initializeHTMLDBSaveButtons": function (parent) {
		if ((undefined === parent) || (null === parent)) {
			parent = document.body;
		}
        var buttonElements = parent.querySelectorAll(".htmldb-button-save");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener(
						"click",
						HTMLDB.doSaveButtonClick,
						true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent(
	            		"onclick",
	            		HTMLDB.doSaveButtonClick);
	        }
	    }
	},
	"initializeHTMLDBSortButtons": function (parent) {
		if ((undefined === parent) || (null === parent)) {
			parent = document.body;
		}
        var buttonElements = parent.querySelectorAll(".htmldb-button-sort");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener(
						"click",
						HTMLDB.doSortButtonClick,
						true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent(
	            		"onclick",
	            		HTMLDB.doSortButtonClick);
	        }
	    }
	},
	"initializeHTMLDBEditButtons": function (parent, tableElement) {
		if ((undefined === parent) || (null === parent)) {
			parent = document.body;
		}
        var buttons = parent.querySelectorAll(".htmldb-button-edit");
        var buttonCount = buttons.length;
        var button = null;

        for (var i = 0; i < buttonCount; i++) {
        	button = buttons[i];

        	if (tableElement) {
	            if (HTMLDB.getHTMLDBParameter(button, "table")
	            		!= tableElement.getAttribute("id")) {
	            	continue;
	            }
        	}

			if (button.addEventListener) {
				button.addEventListener(
						"click",
						HTMLDB.doEditButtonClick,
						true);
			} else if (button.attachEvent) {
	            button.attachEvent("onclick", HTMLDB.doEditButtonClick);
	        }
	    }
	},
	"initializeHTMLDBSaveInputs": function (parent) {
		if ((undefined === parent) || (null === parent)) {
			parent = document.body;
		}
        var inputElements = parent.querySelectorAll(".htmldb-input-save");
        var inputElementCount = inputElements.length;
        var inputElement = null;
        var tagName = "";
        var inputType = "";

        for (var i = 0; i < inputElementCount; i++) {
        	inputElement = inputElements[i];

			tagName = String(inputElement.tagName).toLowerCase();
			inputType = String(inputElement.getAttribute("type")).toLowerCase();

			switch (tagName) {
				case "input":
					if (("checkbox" == inputType) || ("radio" == inputType)) {
						if (inputElement.addEventListener) {
							inputElement.addEventListener(
									"click",
									HTMLDB.doSaveInputEvent,
									true);
						} else if (inputElement.attachEvent) {
				            inputElement.attachEvent(
				            		"onclick",
				            		HTMLDB.doSaveInputEvent);
				        }
					} else {
						if (inputElement.addEventListener) {
							inputElement.addEventListener(
									"input",
									HTMLDB.doSaveInputEvent,
									true);
							inputElement.addEventListener(
									"keyup",
									HTMLDB.doSaveInputKeyUp,
									true);
						} else if (inputElement.attachEvent) {
				            inputElement.attachEvent(
				            		"oninput",
				            		HTMLDB.doSaveInputEvent);
				            inputElement.attachEvent(
				            		"onkeyup",
				            		HTMLDB.doSaveInputKeyUp);
				        }
					}
				break;
				case "textarea":
					if (inputElement.addEventListener) {
						inputElement.addEventListener(
								"input",
								HTMLDB.doSaveInputEvent,
								true);
					} else if (inputElement.attachEvent) {
			            inputElement.attachEvent(
			            		"oninput",
			            		HTMLDB.doSaveInputEvent);
			        }
				break;
				case "select":
					if (inputElement.addEventListener) {
						inputElement.addEventListener(
								"change",
								HTMLDB.doSaveInputEvent,
								true);
					} else if (inputElement.attachEvent) {
			            inputElement.attachEvent(
			            		"onchange",
			            		HTMLDB.doSaveInputEvent);
			        }
				break;
				case "button":
					if (inputElement.addEventListener) {
						inputElement.addEventListener(
								"click",
								HTMLDB.doSaveInputEvent,
								true);
					} else if (inputElement.attachEvent) {
			            inputElement.attachEvent(
			            		"onclick",
			            		HTMLDB.doSaveInputEvent);
			        }
				break;
			}
	    }
	},
	"doSaveInputEvent": function (event) {
		var element = HTMLDB.getEventTarget(event);
		var delay = parseInt(HTMLDB.getHTMLDBParameter(element, "save-delay"));
		if (isNaN(delay)) {
			delay = 500;
		}
		if (delay > 0) {
			clearTimeout(element.tmSaveDelay);
			element.tmSaveDelay = setTimeout(function () {
				clearTimeout(element.tmSaveDelay);
				HTMLDB.doSaveInputEventNow(event);
			}, delay);
		} else {
			HTMLDB.doSaveInputEventNow(event);
		}
	},
	"doSaveInputKeyUp": function (event) {
		var element = HTMLDB.getEventTarget(event);
		if (13 == event.keyCode) {
        	// Trigger Save Event On Enter
        	HTMLDB.doSaveInputEventNow(event);
        }
	},
	"doSaveInputEventNow": function (event) {
		var input = HTMLDB.getEventTarget(event);
		clearTimeout(input.tmSaveDelay);

    	var inputValue = HTMLDB.getInputValue(input);

    	var tableElementId = HTMLDB.getHTMLDBParameter(input, "table");
    	var tableElement = document.getElementById(tableElementId);
    	var inputField = HTMLDB.getHTMLDBParameter(input, "input-field");

    	if (!tableElement) {
			throw(new Error(
					"HTMLDB input table "
					+ tableElementId
					+ " not found."));
	        return false;
    	}

    	var className = (" " + input.className + " ");

    	if (className.indexOf(" htmldb-loading ") != -1) {
    		return false;
    	}

		input.classList.add("htmldb-loading");

		var activeId = HTMLDB.getHTMLDBParameter(input, "edit-id");

		if ("" == String(activeId).trim()) {
			activeId = (HTMLDB.getActiveId(tableElement));
		}

		var sessionObject = HTMLDB.get(tableElement.getAttribute("id"), activeId);

		if (undefined === sessionObject[inputField]) {
			throw(new Error("HTMLDB input table "
					+ tableElement.getAttribute("id")
					+ " has no "
					+ inputField
					+ " column."));
	        return false;
		}

		var defaults = HTMLDB.getHTMLDBParameter(input, "table-defaults");

		sessionObject = HTMLDB.parseObjectDefaults(sessionObject, defaults);

		sessionObject[inputField] = inputValue;

		document.getElementById(tableElement.getAttribute("id")
				+ "_reader_td"
				+ activeId
				+ inputField).innerHTML
				= inputValue;

		HTMLDB.updateReadQueueCallbacks(tableElement, function () {
			input.classList.remove("htmldb-loading");
		});

		HTMLDB.insert(tableElement.getAttribute("id"), sessionObject);
		HTMLDB.updateReadQueueWithParameter(input, "refresh-table");
		input.dispatchEvent(new CustomEvent("htmldbsave", {detail: {}}));
	},
	"doSortButtonClick": function (event) {
		var button = HTMLDB.getEventTarget(event);

    	var tableElementId = HTMLDB.getHTMLDBParameter(button, "table");
    	var tableElement = document.getElementById(tableElementId);
    	var sortField = HTMLDB.getHTMLDBParameter(button, "sort-field");
    	var sortValue = HTMLDB.getHTMLDBParameter(button, "sort-value");
    	var directionField = HTMLDB.getHTMLDBParameter(
    			button,
    			"direction-field");
    	var sortingASC = false;

    	if (!tableElement) {
			throw(new Error("HTMLDB button table "
					+ tableElementId
					+ " not found."));
	        return false;
    	}

    	var className = (" " + button.className + " ");

    	if (className.indexOf(" htmldb-loading ") != -1) {
    		return false;
    	}

    	if (className.indexOf(" htmldb-sorting-asc ") != -1) {
    		sortingASC = true;
    	} else {
    		sortingASC = false;
    	}

		var activeId = (HTMLDB.getActiveId(tableElement));
		var sessionObject = HTMLDB.get(tableElement.getAttribute("id"), activeId);

		if (undefined === sessionObject[sortField]) {
			throw(new Error("HTMLDB button table "
					+ tableElement.getAttribute("id")
					+ " has no "
					+ sortField
					+ " column."));
	        return false;
		}

		if (undefined === sessionObject[directionField]) {
			throw(new Error("HTMLDB button table "
					+ tableElement.getAttribute("id")
					+ " has no "
					+ directionField
					+ " column."));
	        return false;
		}

		button.classList.add("htmldb-loading");

		if (sortingASC) {
			button.classList.remove("htmldb-sorting-asc");
			button.classList.add("htmldb-sorting-desc");
			button.setAttribute("data-htmldb-sorting-asc", 0);
		} else {
			button.classList.add("htmldb-sorting-asc");
			button.classList.remove("htmldb-sorting-desc");
			button.setAttribute("data-htmldb-sorting-asc", 1);
		}

		var defaults = HTMLDB.getHTMLDBParameter(button, "table-defaults");

		sessionObject = HTMLDB.parseObjectDefaults(sessionObject, defaults);

		sessionObject[sortField] = sortValue;
		sessionObject[directionField] = ((sortingASC) ? 2 : 1);

		document.getElementById(tableElement.getAttribute("id")
				+ "_reader_td"
				+ activeId
				+ sortField).innerHTML
				= sortValue;

		document.getElementById(tableElement.getAttribute("id")
				+ "_reader_td"
				+ activeId
				+ directionField).innerHTML
				= sessionObject[directionField];

		HTMLDB.updateReadQueueCallbacks(tableElement, function () {
			button.classList.remove("htmldb-loading");
		});

		HTMLDB.insert(tableElement.getAttribute("id"), sessionObject);
		HTMLDB.updateReadQueueWithParameter(button, "refresh-table");
		button.dispatchEvent(new CustomEvent("htmldbsort", {detail: {}}));
	},
	"updateReadQueueWithParameter": function (element, parameter) {
		var refreshTableCSV = HTMLDB.getHTMLDBParameter(element, parameter);
		var refreshTables = refreshTableCSV.split(",");
		var refreshTableCount = refreshTables.length;
		var refreshTableId = "";
		var refreshTable = null;
		for (var i = 0; i < refreshTableCount; i++) {
			refreshTableId = refreshTables[i];

			if ("" == String(refreshTableId).trim()) {
				continue;
			}

			refreshTable = document.getElementById(refreshTableId);
			if (!refreshTable) {
				throw(new Error("HTMLDB table "
						+ refreshTableId
						+ " referenced in " + parameter
						+ " attribute but not found."));
	        	return false;
			}
			HTMLDB.updateReadQueue(refreshTable);
		}
	},
	"initializeReadQueue": function () {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        var indices = [];
       	var priorities = [];
       	var index = 0;
       	var priority = 0;

        HTMLDB.readQueue = null;

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	priority = parseInt(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"priority"));
        	if (-1 == indices.indexOf(priority)) {
			    indices.push(priority);
        	}
        }

		indices.sort();

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	if (HTMLDB.getHTMLDBParameter(tableElement, "form") != "") {
        		continue;
        	}
        	priority = parseInt(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"priority"));
        	index = indices.indexOf(priority);
			if (undefined === priorities[index]) {
				priorities[index] = [];
			}
        	priorities[index].push(tableElement.getAttribute("id"));
        }

        HTMLDB.readQueue = priorities;

        HTMLDB.processReadQueue();
	},
	"readChildTable": function (tableElementId, functionDone) {
		var tableElement = document.getElementById(tableElementId);

		if (!tableElement) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " will be readed, but not found."));
			return false;
		}

		var loading = parseInt(
				tableElement.getAttribute(
				"data-htmldb-loading"));

		if (loading > 0) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is loading right now."));
			return false;
		}

		var parentTableId = HTMLDB.getHTMLDBParameter(tableElement, "table");

		if ("" == parentTableId) {
        	throw(new Error("HTMLDB child table "
        			+ tableElementId
        			+ " has no table attribute."));
			return false;
		}

		var parentTableElement = document.getElementById(parentTableId);

		if (!parentTableElement) {
        	throw(new Error("HTMLDB table "
        			+ parentTableId
        			+ " is referenced by "
        			+ tableElementId + ", but not found."));
			return false;
		}

		document.getElementById(tableElementId
				+ "_reader_thead").innerHTML = 
				document.getElementById(parentTableId
				+ "_reader_thead").innerHTML;

		document.getElementById(tableElementId
				+ "_writer_thead").innerHTML = 
				document.getElementById(parentTableId
				+ "_reader_thead").innerHTML;

		var rows = document.getElementById(
				parentTableId
				+ "_reader_tbody").children;
		var rowCount = rows.length;
		var row = null;
		var object = null;
		var id = 0;
		var content = "";
		var activeId = "";

		HTMLDB.updateTableFilterFunction(tableElement);

		for (var i = 0; i < rowCount; i++) {
			row = rows[i];
			id = HTMLDB.getHTMLDBParameter(row, "data-row-id");
			object = HTMLDB.convertRowToObject(parentTableId, row);
			if (tableElement.filterFunction
					&& !tableElement.filterFunction(object)) {
				continue;
			}

			content += "<tr class=\"refreshed\" data-row-id=\""
					+ id
					+ "\" id=\""
					+ (tableElementId
					+ "_reader_tr"
					+ id)
					+ "\">";

			content += HTMLDB.generateTDHTML(
					tableElement,
					"_reader",
					object,
					id);

			content += "</tr>";

			if ("" == activeId) {
				activeId = id;
			}
		}

		document.getElementById(tableElementId
				+ "_reader_tbody").innerHTML
				= content;
		tableElement.setAttribute("data-htmldb-active-id", activeId);
		HTMLDB.render(tableElement);
	},
	"convertRowToObject": function (tableElementId, row) {
		var object = {};
		var columns = row.children;
		var columnCount = columns.length;
		var column = null;
		var id = row.getAttribute("data-row-id");
		var property = "";
		for (var i = 0; i < columnCount; i++) {
			column = columns[i];
			property = column.getAttribute("id").replace(
					(tableElementId
					+ "_reader_td"
					+ id),
					"");
			object[property] = column.innerHTML;
		}
		return object;
	},
	"convertListRowToObject": function (listRow, columns) {
		var object = {};
		var columnCount = columns.length;
		for (var i = 0; i < columnCount; i++) {
			object[columns[i]] = listRow[i];
		}
		return object;
	},
	"getMaxPriority": function (tableIds) {
		var tableIdCount = tableIds.length;
		var tableElement = null;
		var maxPriority = 0;
		var priority = 0;

		for (var i = 0; i < tableIdCount; i++) {
			if (!document.getElementById(tableIds[i])) {
	        	throw(new Error("HTMLDB table "
	        			+ tableIds[i]
	        			+ " is referenced, but not found."));
				return false;
			}
			tableElement = document.getElementById(tableIds[i]);
			priority = parseInt(
					HTMLDB.getHTMLDBParameter(
					tableElement,
					"priority"));
			if (priority > maxPriority) {
				maxPriority = priority;
			}
		}
		return maxPriority;
	},
	"processReadQueue": function () {
		if (undefined === HTMLDB.readQueue) {
			return;
		}

		if (0 == HTMLDB.readQueue.length) {
			return;
		}

		if (!HTMLDB.isIdle()) {
			return;
		}

		HTMLDB.readingQueue = undefined;

		while ((HTMLDB.readingQueue === undefined)
				&& (HTMLDB.readQueue.length > 0)) {
			HTMLDB.readingQueue = HTMLDB.readQueue.shift();
		}

		readingQueueCount = 0;
		if (HTMLDB.readingQueue) {
			readingQueueCount = HTMLDB.readingQueue.length;
		}

		tableElementId = "";
		tableElement = null;

		for (var i = 0; i < readingQueueCount; i++) {
			tableElementId = HTMLDB.readingQueue[i];
			tableElement = document.getElementById(tableElementId);

			if (HTMLDB.isInReadQueue(tableElement)) {
				continue;
			}

			if (HTMLDB.isHTMLDBParameter(tableElement, "local")) {
				HTMLDB.readLocal(tableElementId);
			} else {
				HTMLDB.read(tableElementId);
			}
		}
	},
	"removeFromReadingQueue": function (tableElementId) {
		var index = HTMLDB.readingQueue.indexOf(tableElementId);
		if (index > -1) {
			HTMLDB.readingQueue.splice(index, 1);
		}
	},
	"extractParentTables": function () {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        var parents = [];
        var parentTable = "";
        var expressionTables = "";

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	parents[tableElement.getAttribute("id")] = [];
        	parentTable = HTMLDB.getHTMLDBParameter(tableElement, "table");

        	if (parentTable) {
        		parents[tableElement.getAttribute("id")]
        				= parents[tableElement.getAttribute("id")].concat(Array(parentTable));
        	}

        	expressionTables = HTMLDB.extractHTMLDBExpressionTables(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"read-url"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.getAttribute("id")]
        				= parents[tableElement.getAttribute("id")].concat(expressionTables);
        	}

        	expressionTables = HTMLDB.extractHTMLDBExpressionTables(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"write-url"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.getAttribute("id")]
        				= parents[tableElement.getAttribute("id")].concat(expressionTables);
        	}

        	expressionTables = HTMLDB.extractHTMLDBExpressionTables(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"validate-url"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.getAttribute("id")]
        				= parents[tableElement.getAttribute("id")].concat(expressionTables);
        	}

        	expressionTables = HTMLDB.extractHTMLDBExpressionTables(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"filter"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.getAttribute("id")]
        				= parents[tableElement.getAttribute("id")].concat(expressionTables);
        	}
        }

        return parents;
	},
	"extractChildTables": function () {
		var parentTables = HTMLDB.extractParentTables();
		var childTables = [];
		var parentTableCount = 0;
		var i = 0;
		var parent = "";
		var child = "";
		for (parent in parentTables) {
			parentTableCount = parentTables[parent].length;
			for (i = 0; i < parentTableCount; i++) {
				if (undefined === childTables[parentTables[parent][i]]) {
					childTables[parentTables[parent][i]] = [];
				}
				childTables[parentTables[parent][i]].push(parent);
			}
		}

		return childTables;
	},
	"extractHTMLDBExpressionTables": function (expression) {
		var tokens = String(expression).split("{{");
		var subTokens = null;
		var content = "";
		var tokenCount = 0;
		var foreignTableId = "";
		var text = "";
		var position = 0;

		if (tokens.length <= 1) {
			return [];
		}

		tokenCount = tokens.length;
		tables = [];

		for (var i = 1; (i < tokenCount); i++) {
			content = tokens[i];
			position = 1;

			while (("}" != content[position - 1])
					&& ("}" != content[position])) {
				position++;
			}

			subTokens = (String(content).substr(0, (position))).split(".");

			if (subTokens.length > 1) {
				foreignTableId = subTokens[0];
			} else {
				foreignTableId = "";
			}

			if ("$" == foreignTableId[0]) {
				continue;
			}

			if (":" == foreignTableId[0]) {
				continue;
			}

			if (foreignTableId != "") {
				tables.push(foreignTableId);
			}
		}

		return tables;
	},
	"getHTMLDBParameter": function (element, parameter) {
		if (element.getAttribute("data-htmldb-" + parameter)) {
			return element.getAttribute("data-htmldb-" + parameter);
		} else if (element.getAttribute("htmldb-" + parameter)) {
			return element.getAttribute("htmldb-" + parameter);
		} else if (element.getAttribute(parameter)) {
			return element.getAttribute(parameter);
		} else {
			return "";
		}
	},
	"isHTMLDBParameter": function (element, parameter) {
		var value = HTMLDB.getHTMLDBParameter(element, parameter);
		if (("true" == value) || ("1" == value)) {
			return true;
		} else {
			return false;
		}
	},
	"hasHTMLDBParameter": function (element, parameter) {
		if (element.getAttribute("data-htmldb-" + parameter)) {
			return true;
		} else if (element.getAttribute("htmldb-" + parameter)) {
			return true;
		} else if (element.getAttribute(parameter)) {
			return true;
		} else {
			return false;
		}
	},
	"getURLParameter": function (index) {
		if (isNaN(index)) {
			return "";
		}

		var path = window.location.href;
		path = path.replace(window.location.origin, "");
		var paths = path.split("/");

		if (index < 0) {
			index = paths.length + index;
		}

		if (paths[index] !== undefined) {
			return paths[index];
		} else {
			return "";
		}
	},
	"validateHTMLDBTableDefinition": function (element) {
        var reservedIds = ["_reader_table",
        		"_writer_table",
        		"_reader_thead",
        		"_writer_thead",
        		"_reader_tbody",
        		"_writer_tbody",
        		"_iframe_container",
        		"_form_container"];
        var reservedIdCount = reservedIds.length;

        if ("" == element.getAttribute("id")) {
        	throw(new Error("All HTMLDB table element must "
        			+ "have a unique id attribute."));
        	return false;
        }

        for (var i = 0; i < reservedIdCount; i++) {
        	if (document.getElementById(element.getAttribute("id") + reservedIds[i])) {
	        	throw(new Error(element.getAttribute("id")
	        			+ reservedIds[i]
	        			+ " has been used."));
	        	return false;
        	}
        }

        var tableFormId = HTMLDB.getHTMLDBParameter(element, "form");

        if (tableFormId != "") {
        	if (!document.getElementById(tableFormId)) {
	        	throw(new Error("HTMLDB table "
	        			+ element.getAttribute("id")
	        			+ " referencing unknown form "
	        			+ tableFormId));
	        	return false;	
        	}
        }
	},
	"validateHTMLDBTemplateDefinition": function (element) {
		var tableElementId = HTMLDB.getHTMLDBParameter(element, "table");
		var targetElementId = HTMLDB.getHTMLDBParameter(
				element,
				"template-target");

    	if (("" == tableElementId)
    			|| (!document.getElementById(tableElementId))) {
        	throw(new Error(tableElementId + " HTMLDB table not found."));
    		return;
    	}
	},
	"validateHTMLDBPaginationDefinition": function (element) {
		var tableElementId = HTMLDB.getHTMLDBParameter(element, "table");

    	if (("" == tableElementId)
    			|| (!document.getElementById(tableElementId))) {
        	throw(new Error(tableElementId + " HTMLDB table referenced in "
        			+ "htmldb-pagination element, but not found."));
    		return;
    	}
	},
	"createHelperElements": function (element) {
        var tableHTML = "";
        var iframeHTML = "";
        var formHTML = "";

		tableHTML = "<table id=\""
				+ element.getAttribute("id") + "_reader"
				+ "_table\">"
				+ "<thead id=\""
				+ element.getAttribute("id") + "_reader"
				+ "_thead\"></thead>"
				+ "<tbody id=\""
				+ element.getAttribute("id") + "_reader"
				+ "_tbody\"></tbody></table>";

		tableHTML += "<table id=\""
				+ element.getAttribute("id") + "_writer"
				+ "_table\">"
				+ "<thead id=\""
				+ element.getAttribute("id") + "_writer"
				+ "_thead\"></thead>"
				+ "<tbody id=\""
				+ element.getAttribute("id") + "_writer"
				+ "_tbody\"></tbody></table>";

		iframeHTML = "<div id=\""
				+ element.getAttribute("id")
				+ "_iframe_container\"></div>";

		formHTML = "<div id=\""
				+ element.getAttribute("id")
				+ "_form_container\"></div>";

		element.innerHTML = tableHTML + iframeHTML + formHTML;
	},
	"isLetter": function (text) {
		if (undefined == text) {
			return false;
		} else {
  			return ((text.length === 1) && text.match(/[a-z_]/i));
  		}
	},
	"isNumeric": function (text) {
  		if (undefined == text) {
  			return false;
  		} else {
  			return ((text.length === 1) && text.match(/[0-9]/));
  		}
	},
	"as": function (text) {
		return (text + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
	},
	"generateTemplateRenderFunctionString": function (templateElement, tableElementId, targetElementId) {
		var tableElement = document.getElementById(tableElementId);
		var templateContent = templateElement.innerHTML;
		var tokens = String(templateContent).split("{{");
		var subTokens = null;
		var content = "";
		var tokenCount = 0;
		var functionBody = "";
		var foreignTableId = "";
		var column = "";
		var text = "";
		var position = 0;
		var columnHistory="";

		if (tokens.length <= 1) {
			return "";
		}

		functionHeader = "if(tableElement.getAttribute(\"id\")!=\""
				+ tableElementId
				+ "\")return;var generatedCode"
				+ "=\"\";"
				+ "var rowCount=rows.length;"
				+ "var rowId=0;"
				+ "var object=null;"
				+ "var generatedIdList=[];"
				+ "var generatedId=\"\";"
				+ "var generatedIdListIndex=0;"
				+ "var generatedIdListCount=0;"
				+ "var generatedCodeList=[];"
				+ "var success=false;"
				+ "for(var currentRow=0;currentRow<rowCount;currentRow++){"
				+ "rowId=rows[currentRow].getAttribute(\"data-row-id\");"
				+ "object=HTMLDB.get(\"" + tableElementId + "\", rowId);";

		if (HTMLDB.getHTMLDBParameter(templateElement, "filter") != "") {
			functionHeader += "success=false;"
			functionHeader += HTMLDB.generateFilterFunctionBlock(
					HTMLDB.getHTMLDBParameter(templateElement, "filter"),
					templateElement);
			functionHeader += "if(!success){continue;}";
		}

		functionBody = "generatedCode"
				+ "=\"\"";

		tokenCount = tokens.length;

		if (tokenCount > 1) {
			content = tokens[0];
			text = content;
			text = String(text).replace(/(?:\r\n|\r|\n)/g, "");
			functionBody += "+\"" + HTMLDB.as(text) + "\"";
		}

		for (var i = 1; (i < tokenCount); i++) {
			content = tokens[i];
			position = 1;

			while (("}" != content[position - 1])
					&& ("}" != content[position])) {
				position++;
			}

			subTokens = (String(content).substr(0, (position))).split(".");

			if (subTokens.length > 1) {
				foreignTableId = subTokens[0];
				column = subTokens[1];
			} else {
				foreignTableId = "";
				column = subTokens[0];
			}

			if (foreignTableId == tableElementId) {
				foreignTableId = "";
			}

			if (foreignTableId != "") {
				functionBody += "+HTMLDB.getTableFieldActiveValue(\""
						+ foreignTableId
						+ "\",\""
						+ column
						+ "\")";
			} else {
				/*
				functionBody += "+document.getElementById(\""
						+ tableElementId
						+ "_reader_td\"+rows[currentRow].getAttribute(\""
						+ "data-row-id\")+\""
						+ column
						+ "\").innerHTML";
				*/

				functionBody += "+object[\""
						+ column
						+ "\"]";

				if (-1 == columnHistory.indexOf("," + tableElementId
						+ "."
						+ column
						+ ",")) {
					functionHeader += "if(undefined===object[\""
							+ column
							+ "\"]){"
							+ "throw(new Error(\"An unknown field "
							+ tableElementId
							+ "."
							+ column
							+ " is used in template."
							+ "\"));return;}";
					columnHistory += (","
							+ tableElementId
							+ "."
							+ column
							+ ",");
				}
			}

			text = String(content).substr(position + 2);
			text = String(text).replace(/(?:\r\n|\r|\n)/g, "");

			functionBody += "+\"" + HTMLDB.as(text) + "\"";
		}

		functionBody += ";generatedId=HTMLDB.evaluateHTMLDBExpression("
				+ "HTMLDB.evaluateHTMLDBExpressionWithObject(\""
				+ targetElementId
				+ "\",object));"
				+ "generatedIdListIndex=generatedIdList.indexOf(generatedId);"
				+ "if(-1==generatedIdListIndex){"
				+ "generatedIdListIndex=generatedIdList.length;"
				+ "generatedIdList[generatedIdListIndex]=generatedId;"
				+ "generatedCodeList[generatedIdListIndex]=\"\";"
				+ "}generatedCodeList[generatedIdListIndex]+=generatedCode;}"
				+ "generatedIdListCount=generatedIdList.length;"
				+ "for(var i=0;i<generatedIdListCount;i++){"
				+ "if(!document.getElementById(generatedIdList[i])){"
				+ "throw(new Error(\"An element with the id=\"+generatedIdList[i]+\""
				+ " is referenced in template, but not found.\"));"
				+ "return;"
				+ "}"
				+ "if(-1==tableElement.HTMLDBTemplateTargets.indexOf(generatedIdList[i])){"
				+ "tableElement.HTMLDBTemplateTargets.push(generatedIdList[i]);"
				+ "}"
				+ "document.getElementById(generatedIdList[i]).innerHTML=generatedCodeList[i];"
				+ "}";

		return (functionHeader + functionBody);
	},
	"generateTableFilterFunctionString": function (tableElement) {
		var filter = HTMLDB.getHTMLDBParameter(tableElement, "filter");
		var functionBody = "";

		functionBody = "success=false;";

		if (filter != "") {
			functionBody += HTMLDB.generateFilterFunctionBlock(
					filter,
					tableElement);
		} else {
			functionBody += "success=true;";
		}

		functionBody += "return success;";
		return functionBody;
	},
	"generateFilterFunctionBlock": function (filter, parent) {
		var isForm = (parent.className.indexOf("htmldb-form") != -1);
		var tokens = String(filter).split("/");
		var tokenCount = tokens.length;
		var functionBlock = "";
		var index = 0;
		var property = "";
		var operator = "";
		var constant = "";
		var andor = "||";
		var tableFormId = "";
		var invalidErrorText = "HTMLDB"
				+ (isForm ? " form " : " table ")
				+ parent.getAttribute("id")
				+ " has invalid filter attribute.";

		if ("" == filter) {
			return functionBlock;
		}

		tableFormId = HTMLDB.getHTMLDBParameter(parent, "form");

		while (index < tokenCount) {
			property = HTMLDB.evaluateHTMLDBExpression(
					tokens[index],
					tableFormId);

			functionBlock += "if(undefined===object[\"" + property + "\"]){"
					+ "throw(new Error(\"HTMLDB"
					+ (isForm ? " form " : " table ")
					+ parent.getAttribute("id")
					+ " has unknown filter field:"
					+ property
					+ "\"));return;}";

			functionBlock += ("success=(success" + andor);

			index++;
			if (index >= tokenCount) {
	        	throw(new Error(invalidErrorText));
	    		return;
			}

			operator = String(tokens[index]).toLowerCase();

			index++;
			if (index >= tokenCount) {
	        	throw(new Error(invalidErrorText));
	    		return;
			}

			constant = HTMLDB.evaluateHTMLDBExpression(
					tokens[index],
					tableFormId);

			if ("" == constant) {
				constant = 0;
			}

			switch (operator) {
				case "is":
				case "eq":
					functionBlock += "(object[\""
							+ property
							+ "\"]"
							+ "=="
							+ constant
							+ ")";
				break;
				case "isnot":
				case "neq":
					functionBlock += "(object[\""
							+ property
							+ "\"]"
							+ "!="
							+ constant
							+ ")";
				break;
				case "gt":
					functionBlock += "(object[\""
							+ property
							+ "\"]"
							+ ">"
							+ constant
							+ ")";
				break;
				case "gte":
					functionBlock += "(object[\""
							+ property
							+ "\"]"
							+ ">="
							+ constant
							+ ")";
				break;
				case "lt":
					functionBlock += "(object[\""
							+ property
							+ "\"]"
							+ "<"
							+ constant
							+ ")";
				break;
				case "lte":
					functionBlock += "(object[\""
							+ property
							+ "\"]"
							+ "<="
							+ constant
							+ ")";
				break;
				case "in":
					functionBlock += "(-1!=String(\","
							+ constant
							+ ",\").indexOf(\",\"+object[\""
							+ property
							+ "\"]+\",\"))";
				break;
				case "notin":
					functionBlock += "(-1==String(\","
							+ constant
							+ ",\").indexOf(\",\"+object[\""
							+ property
							+ "\"]+\",\"))";
				break;
				default:
	        		throw(new Error("HTMLDB"
							+ (isForm ? " form " : " table ")
	        				+ parent.getAttribute("id")
	        				+ " has invalid filter operator:" + operator));
	    			return;
				break;
			}

			functionBlock += ");";

			index++;
			if (index < tokenCount) {

				if ((index + 3) >= tokenCount) {
		        	throw(new Error(invalidErrorText));
		    		return;
				}

				andor = String(tokens[index]).toLowerCase();

				if ("or" == andor) {
					andor = "||";
				} else {
					andor = "&&";
				}
			}

			index++;
		}

		return functionBlock;
	},
	"ss": function (p1) {
		return (p1 + '').replace(/\\(.?)/g, function(s, n1) {
	        switch (n1) {
	            case '\\':
	                return '\\';
	            case '0':
	                return '\u0000';
	            case '':
	                return '';
	            default:
	                return n1;
			}
    	});
	},
	"ejs": function (p1) {
		return p1.replace(/\n/g, "\\n")
				.replace(/\"/g, '&quot;')
				.replace(/\r/g, "\\r")
				.replace(/\t/g, "\\t")
				.replace(/\f/g, "\\f")
				.replace(/\f/g, "\\f")
				.replace(/\\/g, "\\");
	},
	"createNewIframeAndForm": function (htmldbId, guid) {
		var iframeContainer = document.getElementById(
				htmldbId
				+ "_iframe_container");
		var formContainer = document.getElementById(
				htmldbId
				+ "_form_container");
		var iframe = null;
		var form = null;

		iframe = document.createElement("iframe");
		iframe.src = "";
		iframe.style.display = "none";
		iframe.id = (htmldbId + "_iframe_" + guid);
		iframe.name = (htmldbId + "_iframe_" + guid);
		iframe.setAttribute("data-htmldb-id", htmldbId);
		iframeContainer.appendChild(iframe);

		form = document.createElement("form");
		form.src = "";
		form.style.display = "none";
		form.id = (htmldbId + "_form_" + guid);
		form.name = (htmldbId + "_form_" + guid);
		form.method = "post";
		form.target = (htmldbId + "_iframe_" + guid);
		form.setAttribute("data-htmldb-id", htmldbId);
		formContainer.appendChild(form);
	},
	"removeIframeAndForm": function (htmldbId, guid) {
		var elDIV = document.getElementById(htmldbId);
		var iframeContainer = document.getElementById(
				htmldbId
				+ "_iframe_container");
		var formContainer = document.getElementById(
				htmldbId
				+ "_form_container");
		var iframe = document.getElementById(htmldbId + "_iframe_" + guid);
		var form = document.getElementById(htmldbId + "_form_" + guid);

		iframe.className = "deleted";
		form.className = "deleted";

		clearTimeout(elDIV.tmRemoveIframeFormTimer);
		elDIV.tmRemoveIframeFormTimer = setTimeout(function () {
			clearTimeout(elDIV.tmRemoveIframeFormTimer);
			var iframeList = iframeContainer.getElementsByClassName("deleted");
			while (iframeList.length > 0) {
			    iframeContainer.removeChild(iframeList[0]);
			}

			var formList = formContainer.getElementsByClassName("deleted");
			while (formList.length > 0) {
			    formContainer.removeChild(formList[0]);
			}
		}, 10000);
	},
	"generateTDHTML": function (tableElement, prefix, object, id) {
		var strReturn = "";
		for (var strPropertyName in object) {
        	if (object.hasOwnProperty(strPropertyName)) {
        		strReturn += ("<td id=\""
        				+ tableElement.getAttribute("id")
        				+ prefix
        				+ "_td"
        				+ id
        				+ strPropertyName
        				+ "\">"
        				+ object[strPropertyName]
        				+ "</td>");
        	}
    	}
    	return strReturn;
	},
	"generateFormHTML": function (tableElement, iframeFormGUID, row) {
		var form = document.getElementById(
				tableElement.getAttribute("id")
				+ "_form_"
				+ iframeFormGUID);
		var index = 0;
		var inputAction = "";

		if (row.className.indexOf("deleted") != -1) {
			inputAction = "deleted";
		} else if (row.className.indexOf("updated") != -1) {
			inputAction = "updated";
		} else {
			inputAction = "inserted";
		}

		index = form.getElementsByClassName("htmldb_action").length;

		var formContent = "<input class=\"htmldb_action\""
				+ " type=\"hidden\" name=\""
				+ "htmldb_action" + index
				+ "\" value=\""
				+ inputAction
				+ "\" />";

		var columns = HTMLDB.getColumnNames(tableElement.getAttribute("id"), false);
		var columnCount = columns.length;
		var rowId = row.getAttribute("data-row-id");
		var prefix = (tableElement.getAttribute("id") + "_writer_td" + rowId);
		var fieldCount = row.children.length;
		var values = {};
		var value = "";

		for (var i = 0; i < fieldCount; i++) {
			values[row.children[i].getAttribute("id")] = row.children[i].innerHTML;
		}

		for (i = 0; i < columnCount; i++) {
			if (!values.hasOwnProperty(prefix + columns[i])) {
				continue;
			}

			value = values[prefix + columns[i]];

			formContent += "<input class=\"htmldb_row\" type=\"hidden\" name=\""
					+ "htmldb_row" + index + "_" + columns[i]
 					+ "\" value=\""
					+ HTMLDB.ejs(value)
					+ "\" />";
		}

		form.innerHTML += formContent;
	},
    "generateGUID": function (prefix) {
        var now = new Date();
        var token0 = String(now.getUTCFullYear())
                + String((now.getUTCMonth() + 1))
                + String(now.getUTCDate())
                + String(now.getHours())
                + String(now.getMinutes())
                + String(now.getSeconds());
        var token1 = 'xxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;
            return v.toString(16);
        });
        var token2 = 'xxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;
            return v.toString(16);
        });  
        
        if (!prefix) {
        	prefix = "";
        }

        return prefix + token0 + token1 + token2;
    },
    "generateDateTimeGUID": function (prefix) {
        var now = new Date();
        var token0 = String(now.getTime());
        var token1 = String(Math.floor(100 + Math.random() * 900));
        
        if (!prefix) {
        	prefix = "";
        }

        return prefix + token0 + token1;
    },
    "evaluateHTMLDBExpression": function (expression, tableElementId) {
    	var expressionLength = String(expression).length;
    	var currentCharacter = "";
    	var previousCharacter = "";
    	var index = 0;
    	var inMustacheText = false;
    	var mustacheExpression = "";
    	var mustacheTokens = [];
    	var returnValue = "";
		var foreignTableId = "";
		var column = "";

    	while (index < expressionLength) {
    		currentCharacter = expression[index];

    		if (("{" == previousCharacter)
    				&& ("{" == currentCharacter)) {
    			inMustacheText = true;
    			returnValue = String(returnValue).substr(0,
    					(String(returnValue).length - 1));
    		} else if (("}" == previousCharacter)
    				&& ("}" == currentCharacter)) {
    			inMustacheText = false;
    			mustacheExpression = String(mustacheExpression).substr(0,
    					(String(mustacheExpression).length - 1));
    			mustacheTokens = String(mustacheExpression).split(".");

				if (mustacheTokens.length > 1) {
					foreignTableId = mustacheTokens[0];
					column = mustacheTokens[1];
				} else {
					foreignTableId = "";
					column = mustacheTokens[0];
				}

				if ((tableElementId !== undefined)
						&& ("" == foreignTableId)) {
					foreignTableId = tableElementId;
				}

				if ("$" == foreignTableId[0]) {
					returnValue += HTMLDB.evaluateHTMLDBGlobalObject(
							foreignTableId,
							column);
				} else if (":" == mustacheExpression[0]) {
					returnValue += HTMLDB.evaluateHTMLDBJSCode(
							mustacheExpression);
				} else if (foreignTableId != "") {
					returnValue += HTMLDB.getTableFieldActiveValue(
							foreignTableId,
							column);
				} else {
					returnValue += ("{{" + mustacheExpression + "}}");
				}

				mustacheExpression = "";

    		} else {
    			if (inMustacheText) {
    				mustacheExpression += currentCharacter;
    			} else {
    				returnValue += currentCharacter;
    			}
    		}

    		index++;

    		previousCharacter = currentCharacter;
    	}

    	if (mustacheExpression.length > 0) {
    		returnValue += mustacheExpression;
    	}

    	return returnValue;
    },
    "evaluateHTMLDBJSCode": function (code) {
    	code = String(code).substring(1);
    	var functionBody = ("return " + code + ";");
		var codeFunction = null;

		try {
			codeFunction = new Function(functionBody);
			return codeFunction();
		} catch (e) {
        	throw(new Error(code + " could not be evaluated."));
			return false;
		}
    },
    "evaluateHTMLDBGlobalObject": function (globalObject, parameter) {
    	globalObject = globalObject.toLowerCase();
    	switch (globalObject) {
    		case "$url":
    			return HTMLDB.getURLParameter(parseInt(parameter));
    		break;
    	}
    },
    "evaluateHTMLDBExpressionWithObject": function (expression, object) {
		var tokens = String(expression).split("{{");
		var subTokens = null;
		var content = "";
		var tokenCount = 0;
		var foreignTableId = "";
		var column = "";
		var text = "";
		var position = 0;

		if (tokens.length <= 1) {
			return expression;
		}

		tokenCount = tokens.length;
		var value = "";

		for (var i = 1; (i < tokenCount); i++) {
			content = tokens[i];
			position = 1;

			while (("}" != content[position - 1])
					&& ("}" != content[position])) {
				position++;
			}

			subTokens = (String(content).substr(0, (position))).split(".");

			if (subTokens.length > 1) {
				foreignTableId = subTokens[0];
				column = subTokens[1];
			} else {
				foreignTableId = "";
				column = subTokens[0];
			}

			if (object[column] !== undefined) {
				value = object[column];
			} else {
				value = ("{{" + content);
			}

			text = String(content).substr(position + 2);
			text = String(text).replace(/(?:\r\n|\r|\n)/g, "");

			content = value + HTMLDB.as(text);

			tokens[i] = content;
		}

		if (tokens.length > 1) {
			returnValue = tokens.join("");
		}

		return returnValue;
    },
    "exploreHTMLDBTable": function (element) {
    	var exit = false;
    	var parent = HTMLDB.getHTMLDBParameter(element, "table");
    	while (!exit && ("" == parent)) {
    		element = element.parentNode;
    		parent = HTMLDB.getHTMLDBParameter(element, "table");
    		if ("body" == element.tagName.toLowerCase()) {
    			exit = true;
    		}
    	}

    	parentElement = document.getElementById(parent);

    	if (!parentElement) {
        	throw(new Error("HTMLDB table " + parent + " not found."));
			return false;
    	}

    	return parentElement;
    },
    "exploreHTMLDBForm": function (element) {
    	var exit = false;

    	if (element.className.indexOf("htmldb-form") != -1) {
    		return element;
    	}
    	var element = element.parentNode;
    	while (!exit && (-1 == element.className.indexOf("htmldb-form"))) {
    		element = element.parentNode;
    		if ("body" == element.tagName.toLowerCase()) {
    			exit = true;
    		}
    	}
    	if (exit) {
        	throw(new Error("HTMLDB form not found."));
			return false;
    	} else {
    		return element;
    	}
    },
    "exploreHTMLDBPagination": function (element) {
    	var exit = false;

    	var className = (" " + element.className + " ");
    	if (className.indexOf(" htmldb-pagination ") != -1) {
    		return element;
    	}
    	var element = element.parentNode;
    	className = (" " + element.className + " ");
    	while (!exit && (-1 == className.indexOf(" htmldb-pagination "))) {
    		element = element.parentNode;
    		className = (" " + element.className + " ");
    		if ("body" == element.tagName.toLowerCase()) {
    			exit = true;
    		}
    	}
    	if (exit) {
        	throw(new Error("HTMLDB pagination not found."));
			return false;
    	} else {
    		return element;
    	}
    },
    "exploreHTMLDBCheckboxGroup": function (element) {
    	var exit = false;
    	if (element.className.indexOf("htmldb-checkbox-group") != -1) {
    		return element;
    	}
    	var element = element.parentNode;
    	while (!exit && (-1 == element.className.indexOf("htmldb-checkbox-group"))) {
    		element = element.parentNode;
    		if ("body" == element.tagName.toLowerCase()) {
    			exit = true;
    		}
    	}
    	if (exit) {
        	throw(new Error("HTMLDB checkbox group element not found."));
			return false;
    	} else {
    		return element;
    	}
    },
	"doReaderIframeLoad":function (p1) {
		HTMLDB.doReaderIframeDefaultLoad(p1, false);
		HTMLDB.render(HTMLDB.getEventTarget(p1).parentNode.parentNode);
	},
	"doRefreshButtonClick": function () {
		HTMLDB.initializeReadQueue();
	},
	"doIndexedDBUpgradeNeeded": function () {
		if (null == HTMLDB.indexedDBConnection) {
        	throw(new Error("HTMLDB IndexedDB not initialized."));
			return false;
		}

		var database = HTMLDB.indexedDBConnection.result;
		var indexedDBTableCount = HTMLDB.indexedDBTables.length;

		for (var i = 0; i < indexedDBTableCount; i++) {
			if (!database.objectStoreNames.contains(
					"htmldb_"
					+ HTMLDB.indexedDBTables[i]
					+ "_reader")) {
				database.createObjectStore(
						("htmldb_" + HTMLDB.indexedDBTables[i] + "_reader"));
			}
			if (!database.objectStoreNames.contains(
					"htmldb_"
					+ HTMLDB.indexedDBTables[i]
					+ "_writer")) {
				database.createObjectStore(
						("htmldb_" + HTMLDB.indexedDBTables[i] + "_writer"));
			}
		}
	},
	"checkIfIndexedDBTableExists": function (tableName) {
		if (null == HTMLDB.indexedDBConnection) {
        	throw(new Error("HTMLDB IndexedDB not initialized."));
			return false;
		}

		var database = HTMLDB.indexedDBConnection.result;
		var hasReaderTable = false;
		var hasWriterTable = false;

		hasReaderTable = database.objectStoreNames.contains(
				"htmldb_"
				+ tableName
				+ "_reader");
		hasWriterTable = database.objectStoreNames.contains(
				"htmldb_"
				+ tableName
				+ "_writer");

		return (hasReaderTable && hasWriterTable);
	},
	"doAddButtonClick": function (event) {
		var eventTarget = HTMLDB.getEventTarget(event);
		var formElement = document.getElementById(
				HTMLDB.getHTMLDBParameter(
				eventTarget,
				"form"));
		if (!formElement) {
        	throw(new Error("Add button HTMLDB form not found."));
			return false;
		}
		HTMLDB.resetForm(formElement);
		var formObject = HTMLDB.convertFormToObject(formElement);
		var defaults = HTMLDB.getHTMLDBParameter(eventTarget, "form-defaults");
		formObject = HTMLDB.parseObjectDefaults(formObject, defaults);
		HTMLDB.renderFormElement(formElement, formObject);
		HTMLDB.doParentElementToggle(formElement);
		formElement.dispatchEvent(new CustomEvent("htmldbadd", {detail: {}}));
	},
	"doAddOptionClick": function (event) {
		var eventTarget = HTMLDB.getEventTarget(event);
		var formElement = document.getElementById(
				HTMLDB.getHTMLDBParameter(
				eventTarget,
				"add-option-form"));
		if (!formElement) {
        	throw(new Error("Add option HTMLDB form not found."));
			return false;
		}
		HTMLDB.resetForm(formElement);
		var formObject = HTMLDB.convertFormToObject(formElement);
		var defaults = HTMLDB.getHTMLDBParameter(eventTarget, "add-option-form-defaults");

		formObject = HTMLDB.parseObjectDefaults(formObject, defaults);
		HTMLDB.renderFormElement(formElement, formObject);
		HTMLDB.doParentElementToggle(formElement);

		formElement.dispatchEvent(new CustomEvent("htmldbadd", {detail: {}}));
		eventTarget.dispatchEvent(new CustomEvent("htmldbaddoptionclick", {detail: {}}));

		if (undefined !== eventTarget.HTMLDBInitials) {
			eventTarget.HTMLDBInitials.renderValue = undefined;
		}

		eventTarget.HTMLDBInitials.selectNewOption = true;
	},
	"doSaveButtonClick": function (event) {
		var eventTarget = HTMLDB.getEventTarget(event);

		if (!eventTarget) {
			eventTarget = event.target;
		}

		var formId = HTMLDB.getHTMLDBParameter(eventTarget, "form");
		var form = null;

		if (formId != "") {
			form = document.getElementById(formId);
			if (!form) {
	        	throw(new Error("Save button HTMLDB form not found."));
				return false;
			}
		} else {
			form = HTMLDB.exploreHTMLDBForm(eventTarget);			
		}

		var tableElementId = HTMLDB.getHTMLDBParameter(form, "table");

		if (!document.getElementById(tableElementId)) {
	        throw(new Error(formId + " form HTMLDB table not found."));
			return false;			
		}

		var object = {};
		var defaults = HTMLDB.getHTMLDBParameter(eventTarget, "form-defaults");

		object = HTMLDB.parseObjectDefaults(object, defaults);
		object = HTMLDB.convertFormToObject(form, object);

		HTMLDB.validate(tableElementId, object, function (tableElementId, responseText) {
			var responseObject = null;
			try {
				responseObject = JSON.parse(String(decodeURIComponent(responseText)).trim());
			} catch(e) {
	        	throw(new Error("HTMLDB table "
	        			+ tableElementId
	        			+ " could not be validated: Not valid JSON format"));
				return false;
			}
			if (responseObject.errorCount > 0) {
				HTMLDB.showError(tableElementId, responseObject.lastError);
			} else {
				HTMLDB.showMessage(tableElementId, responseObject.lastMessage);
				HTMLDB.insert(tableElementId, object);
				eventTarget.dispatchEvent(new CustomEvent(
						"htmldbsave",
						{detail: {}}));
			}
		});
	},
	"convertFormToObject": function (form, defaultObject) {
		var elements = form.querySelectorAll(".htmldb-field");
		var elementCount = elements.length;
		var element = null;
		var object = {};

		if (defaultObject !== undefined) {
			object = defaultObject;
		}

		for (var i = 0; i < elementCount; i++) {
			element = elements[i];
			element.dispatchEvent(new CustomEvent(
					"htmldbgetvalue",
					{detail: {}}));
		}

		for (var i = 0; i < elementCount; i++) {
			element = elements[i];
			object[element.getAttribute("data-htmldb-field")]
					= HTMLDB.getInputValue(element);	
		}

		return object;
	},
	"showLoader": function (tableElementId, type) {
		var tableElement = document.getElementById(tableElementId);
		var loader = HTMLDB.getHTMLDBParameter(
				tableElement,
				(type + "-loader"));

		if ("" == loader) {
			loader = HTMLDB.getHTMLDBParameter(tableElement, "loader");
		}
		if ("" == loader) {
			return;
		}

		var loaderElement = document.getElementById(loader);
		if (loaderElement.depth === undefined) {
			loaderElement.depth = 0;
		}
		loaderElement.depth += 1;
		var className = "";
		if (1 == loaderElement.depth) {
			className = loaderElement.className;
			className = (" " + className + " ");
			if (-1 == className.indexOf(" active ")) {
				loaderElement.className += " active";
			}
		}
	},
	"hideLoader": function (tableElementId, type) {
		var tableElement = document.getElementById(tableElementId);
		var loader = HTMLDB.getHTMLDBParameter(
				tableElement,
				(type + "-loader"));

		if ("" == loader) {
			loader = HTMLDB.getHTMLDBParameter(tableElement, "loader");
		}
		if ("" == loader) {
			return;
		}

		var loaderElement = document.getElementById(loader);
		if (loaderElement.depth === undefined) {
			loaderElement.depth = 0;
		} else {
			loaderElement.depth -= 1;
		}
		if (loaderElement.depth < 0) {
			loaderElement.depth = 0;
			return;
		}

		if (0 == loaderElement.depth) {
    		loaderElement.className = String(
    				loaderElement.className.replace(
    				/\bactive\b/g,
    				"")).trim();
		}
	},
	"hideLoaders": function () {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        var loader = "";
        var loaderElement = null;
        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	loader = HTMLDB.getHTMLDBParameter(tableElement, ("read-loader"));
        	if (loader != "") {
        		loaderElement = document.getElementById(loader);
        		loaderElement.depth = 0;
        		HTMLDB.hideLoader(tableElement.getAttribute("id"), "read");
        	}
			loader = HTMLDB.getHTMLDBParameter(tableElement, ("write-loader"));
        	if (loader != "") {
        		loaderElement = document.getElementById(loader);
        		loaderElement.depth = 0;
        		HTMLDB.hideLoader(tableElement.getAttribute("id"), "write");
        	}
			loader = HTMLDB.getHTMLDBParameter(
					tableElement,
					("validate-loader"));
        	if (loader != "") {
        		loaderElement = document.getElementById(loader);
        		loaderElement.depth = 0;
        		HTMLDB.hideLoader(tableElement.getAttribute("id"), "validate");
        	}
			loader = HTMLDB.getHTMLDBParameter(tableElement, ("loader"));
        	if (loader != "") {
        		loaderElement = document.getElementById(loader);
        		loaderElement.depth = 0;
        		HTMLDB.hideLoader(tableElement.getAttribute("id"), "");
        	}
		}
	},
	"showError": function (tableElementId, errorText) {
		if ("" == errorText) {
			return;
		}
		var tableElement = document.getElementById(tableElementId);
		var containers = document.body.querySelectorAll(".htmldb-error");
		var containerCount = containers.length;
		var container = null;
		for (var i = 0; i < containerCount; i++) {
			container = containers[i];
			if (HTMLDB.getHTMLDBParameter(
					container,
					"table")
					== tableElementId) {
				container.innerHTML = errorText;
				container.dispatchEvent(new CustomEvent(
						"htmldberror", {
						detail: {
							"tableElementId":tableElementId,
							"errorText":errorText
						}}));
			}
		}
		tableElement.dispatchEvent(new CustomEvent("htmldberror",
				{detail:{"errorText":errorText}}));
	},
	"showMessage": function (tableElementId, messageText) {
		if ("" == messageText) {
			return;
		}
		var tableElement = document.getElementById(tableElementId);
		var containers = document.body.querySelectorAll(".htmldb-message");
		var containerCount = containers.length;
		var container = null;
		for (var i = 0; i < containerCount; i++) {
			container = containers[i];
			if (HTMLDB.getHTMLDBParameter(
					container,
					"table")
					== tableElementId) {
				container.innerHTML = messageText;
				container.dispatchEvent(new CustomEvent(
						"htmldbmessage", {
						detail: {
							"tableElementId":tableElementId,
							"messageText":messageText
						}}));
			}
		}
		tableElement.dispatchEvent(new CustomEvent("htmldbmessage",
				{detail:{"messageText":messageText}}));
	},
	"doEditButtonClick": function (event) {
		var tableElement = null;
		var formElement = null;
		var eventTarget = HTMLDB.getEventTarget(event);
		var tableElementId = HTMLDB.getHTMLDBParameter(eventTarget, "table");
		var formElementId = HTMLDB.getHTMLDBParameter(eventTarget, "form");

		if ((tableElementId == "") && (formElementId != "")) {
			formElement = document.getElementById(formElementId);
			if (!formElement) {
	        	throw(new Error("Edit button HTMLDB form "
	        			+ formElementId
	        			+ " not found."));
				return false;
			}
			tableElementId = HTMLDB.getHTMLDBParameter(formElement, "table");
		}

		tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
        	throw(new Error("Edit button HTMLDB table "
        			+ tableElementId
        			+ " not found."));
			return false;
		}

		HTMLDB.setActiveId(
				tableElement,
				HTMLDB.getHTMLDBParameter(
				eventTarget,
				"edit-id"));
	},
	"doSelectChange": function (event) {
		var select = HTMLDB.getEventTarget(event);
		var addOptionCaption = HTMLDB.getHTMLDBParameter(select, "add-option-caption");
		if (addOptionCaption != "") {
			if (addOptionCaption == HTMLDB.getInputValue(select)) {
				HTMLDB.doAddOptionClick(event);
			}
		}
	},
	"doWriterIframeLoad": function (p1) {
		var eventTarget = HTMLDB.getEventTarget(p1);
		elDIV = HTMLDB.getEventTarget(p1).parentNode.parentNode;
		elDIV.setAttribute("data-htmldb-loading", 0);
		HTMLDB.hideLoader(elDIV.getAttribute("id"), "write");
		iframeWindow = top.frames[eventTarget.getAttribute("id")];
		var strResponse = "";
		if (iframeWindow.document) {
			strResponse = String(iframeWindow.document.body.innerHTML).trim();
		}

		var iframeFormDefaultName = (elDIV.getAttribute("id") + "_iframe_");
		var iframeFormGUID
				= eventTarget.getAttribute("id").substr(
				iframeFormDefaultName.length);
		HTMLDB.removeIframeAndForm(elDIV.getAttribute("id"), iframeFormGUID);

		if (elDIV.doHTMLDBWrite) {
			elDIV.doHTMLDBWrite(elDIV, strResponse);
		}
	},
	"doValidatorIframeLoad": function (p1) {
		var eventTarget = HTMLDB.getEventTarget(p1);
		elDIV = eventTarget.parentNode.parentNode;
		elDIV.setAttribute("data-htmldb-loading", 0);
		HTMLDB.hideLoader(elDIV.getAttribute("id"), "validate");
		iframeWindow = top.frames[eventTarget.getAttribute("id")];
		var strResponse = "";
		if (iframeWindow.document) {
			strResponse = String(iframeWindow.document.body.innerHTML).trim();
		}

		var iframeFormDefaultName = (elDIV.getAttribute("id") + "_iframe_");
		var iframeFormGUID
				= iframeHTMLDB.getAttribute("id").substr(
				iframeFormDefaultName.length);
		HTMLDB.removeIframeAndForm(elDIV.getAttribute("id"), iframeFormGUID);

		if (elDIV.doHTMLDBValidate) {
			elDIV.doHTMLDBValidate(p1, strResponse);
		}
	},
	"getInputValue": function (input) {
		var inputs = null;
		var inputCount = 0;
		var tagName = "";
		var inputType = "";
		var selections = null;
		var selectionCount = 0;
		var selection = "";
		var selectionCSV = "";
		var inputDate = 0;

		tagName = String(input.tagName).toLowerCase();
		inputType = String(input.getAttribute("type")).toLowerCase();

		switch (tagName) {
			case "input":
				if ("checkbox" == inputType) {
					return (input.checked ? 1 : 0);
				} else if ("radio" == inputType) {
					return ((input.checked) ? input.value : "");
				} else if ("date" == inputType) {
					inputDate = new Date(input.value);
					return inputDate.getTime();
				} else {
					return input.value;
				}
			break;

			case "button":
				return input.value;
			break;

			case "textarea":
				return input.value;
			break;

			case "select":
				if (-1 == input.selectedIndex) {
					return "";
				} else {
					selectionCSV = "";
					selections = input.querySelectorAll("option:checked");
					selectionCount = selections.length;
					for (var i = 0; i < selectionCount; i++) {
						selection = selections[i];
						if (selectionCSV != "") {
							selectionCSV += ",";
						}
						selectionCSV += selection.value;
					}
					return selectionCSV;
				}
			break;
		}

		return "";
	},
	"setInputValue": function (input, value) {
		var tagName = String(input.tagName).toLowerCase();
		var inputType = String(input.getAttribute("type")).toLowerCase();
		var inputDate = 0;
		var inputDateText = "";
		switch (tagName) {
			case "input":
				if ("checkbox" == inputType) {
					input.checked = ("1" == value);
				} else if ("radio" == inputType) {
					if (input.value == value) {
						input.checked = true;
					}
				} else if ("date" == inputType) {
					inputDate = new Date(parseInt(value));
					inputDateText = inputDate.getFullYear()
							+ "-"
							+ (("0"
							+ (inputDate.getMonth() + 1)).slice(-2))
							+ "-"
							+ (("0" + inputDate.getDate()).slice(-2));
					input.defaultValue = inputDateText;
				} else {
					input.value = value;
				}
			break;
			case "textarea":
				input.innerHTML = value;
				input.value = value;
			break;
			case "select":
				input.HTMLDBInitials.previousValue = input.value;
				input.value = value;
			break;
		}
	},
	"removeReadQueueCallbacks": function () {
		HTMLDB.readQueueCallbacks = [];
	},
	"callReadQueueCallbacks": function (tableElement) {
		if (undefined === HTMLDB.readQueueCallbacks[tableElement.getAttribute("id")]) {
			return;
		}
		var callbackFunction = null;
		while (HTMLDB.readQueueCallbacks[tableElement.getAttribute("id")].length > 0) {
			callbackFunction
					= HTMLDB.readQueueCallbacks[tableElement.getAttribute("id")].shift();
			callbackFunction();
		}
	},
	"getEventTarget": function (event) {
		var eventTarget = event.currentTarget;
		if (!eventTarget) {
			eventTarget = event.target;
		}
		return eventTarget;
	},
	"addSingleQuoteSlashes": function (text) {
	    return String(text).replace(/'/g, "\'");
	},
	"doReaderIframeDefaultLoad": function (event, readAll) {
		var iframeHTMLDB = HTMLDB.getEventTarget(event);
		var tableElement = iframeHTMLDB.parentNode.parentNode;
		var tableElementId = iframeHTMLDB.parentNode.parentNode.getAttribute("id");
		var tbodyHTMLDB = document.getElementById(
				tableElementId
				+ "_reader_tbody");
		var theadHTMLDB = document.getElementById(
				tableElementId
				+ "_reader_thead");
		var eventTarget = HTMLDB.getEventTarget(event);
		iframeWindow = top.frames[iframeHTMLDB.getAttribute("id")];
		var strResponse = "";
		if (iframeWindow.document) {
			strResponse = String(iframeWindow.document.body.innerHTML).trim();
		}

		if (strResponse != "") {

			var arrList = [];

			try {
				arrList = JSON.parse(String(decodeURIComponent(strResponse)).trim());
			} catch(e) {
	        	throw(new Error("HTMLDB table "
	        			+ tableElement.getAttribute("id")
	        			+ " could not be read: Not valid JSON format from URL "
	        			+ eventTarget.src));
				return false;
			}

			if (HTMLDB.isHTMLDBParameter(tableElement, "local")) {
				HTMLDB.clearLocalTable(tableElement);
			}

			var arrColumns = arrList.c;
			var lRowCount = arrList.r.length;
			var lColumnCount = arrList.c.length;
			var strRowContent = "";
			var columnContent = "";
			var strPropertyName = "";
			var elTR = null;
			var rowObject = {};

			columnContent = "<tr>";

			for (j = 0; j < lColumnCount; j++) {
				columnContent += ("<th>" + arrColumns[j] + "</th>");
			}

			columnContent += "</tr>";

			var activeId = "";
			var activeIdAssigned = false;

			HTMLDB.updateTableFilterFunction(tableElement);

			for (var i = 0; i < lRowCount; i++) {

				rowObject = HTMLDB.convertListRowToObject(arrList.r[i], arrList.c);

				if (tableElement.filterFunction
						&& !tableElement.filterFunction(rowObject)) {
					continue;
				}

				elTR = document.getElementById(
						tableElementId
						+ "_reader_tr"
						+ arrList.r[i][0]);
				if (elTR) {
					elTR.parentNode.removeChild(elTR);
				}

				if (!activeIdAssigned) {
					activeId = arrList.r[i][0];
					activeIdAssigned = true;
				}

				strRowContent += "<tr class=\"refreshed\" data-row-id=\""
						+ arrList.r[i][0]
						+ "\" id=\""
						+ (tableElementId
						+ "_reader_tr"
						+ arrList.r[i][0])
						+ "\">";

				strRowContent += HTMLDB.generateTDHTML(
						tableElement,
						"_reader",
						rowObject,
						arrList.r[i][0]);

				strRowContent += "</tr>";

				if (HTMLDB.isHTMLDBParameter(tableElement, "local")) {
					HTMLDB.updateLocal(tableElement, arrList.r[i][0], rowObject, true);
				}
			}

			theadHTMLDB.innerHTML = columnContent;
			tbodyHTMLDB.innerHTML += strRowContent;
			document.getElementById(tableElement.getAttribute("id") + "_writer_thead").innerHTML
					= columnContent;
			tableElement.setAttribute("data-htmldb-active-id", activeId);
		}

		var iframeFormDefaultName = (tableElement.getAttribute("id") + "_iframe_");
		var iframeFormGUID = iframeHTMLDB.getAttribute("id").substr(
				iframeFormDefaultName.length);
		HTMLDB.removeIframeAndForm(tableElement.getAttribute("id"), iframeFormGUID);

		if ((readAll === false) && tableElement.doHTMLDBRead) {
			tableElement.doHTMLDBRead(tableElement);
		} else if ((readAll === true) && tableElement.doHTMLDBReadAll) {
			tableElement.doHTMLDBReadAll(tableElement);
		}

		tableElement.setAttribute("data-htmldb-loading", 0);
		HTMLDB.hideLoader(tableElementId, "read");

		tableElement.dispatchEvent(
				new CustomEvent(
				"htmldbread",
				{detail: {}}));

		setTimeout(function () {
			HTMLDB.callReadQueueCallbacks(tableElement);
			HTMLDB.removeFromReadingQueue(tableElement.getAttribute("id"));
			HTMLDB.processReadQueue();
		}, 150);
	},
	"clearLocalTable": function (tableElement) {
		if (null == HTMLDB.indexedDBConnection) {
        	throw(new Error("HTMLDB IndexedDB not initialized."));
			return false;
		}

		if (HTMLDB.checkIfIndexedDBTableExists(tableElement.getAttribute("id"))) {
			var database = HTMLDB.indexedDBConnection.result;
			var readerTransaction = database.transaction(
					("htmldb_" + tableElement.getAttribute("id") + "_reader"),
					"readwrite");
			var writerTransaction = database.transaction(
					("htmldb_" + tableElement.getAttribute("id") + "_writer"),
					"readwrite");
			var readerStore = readerTransaction.objectStore(
					"htmldb_" + tableElement.getAttribute("id") + "_reader");
			var writerStore = writerTransaction.objectStore(
					"htmldb_" + tableElement.getAttribute("id") + "_writer");

			readerStore.clear();
			writerStore.clear();
		}
	},
	"isNewObject": function (object) {
		if (object["id"] === undefined) {
			return true;
		}

		if ("" == object["id"]) {
			return true;
		}

		if (0 == parseInt(object["id"])) {
			return true;
		}

		if ("n" == object["id"][0]) {
			return true;
		}

		return false;
	},
	"addLeadingZeros": function (text, digitCount) {
  		var s = String(text);
  		while (s.length < (digitCount || 2)) {s = "0" + s;}
  		return s;
	}
}
HTMLDB.initialize();
(function () {
	if (typeof window.CustomEvent === "function") {
		return false;
	}
	function CustomEvent(event, params) {
		params = (params
				|| { bubbles: false, cancelable: false, detail:  undefined });
		var evt = document.createEvent("CustomEvent");
		evt.initCustomEvent(event,
				params.bubbles,
				params.cancelable,
				params.detail);
		return evt;
	}
	CustomEvent.prototype = window.Event.prototype;
	window.CustomEvent = CustomEvent;
})();