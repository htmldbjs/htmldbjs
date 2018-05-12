/*! < ())) > HTMLDB.js - v1.0.0 | https://github.com/htmldbjs/htmldbjs/ | MIT license */
var HTMLDB = {
	"readQueue": [],
	"readingQueue": [],
	"initialize": function () {
		HTMLDB.initializeHTMLDBTables();
		HTMLDB.initializeHTMLDBTemplates();
		HTMLDB.initializeHTMLDBButtons();
		HTMLDB.initializeHTMLDBSections();
		HTMLDB.initializeHTMLDBForms();
		HTMLDB.initializeHTMLDBSelects();
		HTMLDB.initializeHTMLDBToggles();
		HTMLDB.initializeReadQueue();

		HTMLDB.resetWriterLoop();
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

		var loading = parseInt(tableElement.getAttribute("data-htmldb-loading"));

		if (loading > 0) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is loading right now."));
			return false;
		}

		var parentTable = HTMLDB.getHTMLDBParameter(tableElement, "table");

		if (parentTable != "") {
			return HTMLDB.readChildTable(tableElementId, functionDone);
		}

		var readURL = HTMLDB.getHTMLDBParameter(tableElement, "read-url");
		readURL = HTMLDB.evaluateHTMLDBExpression(readURL);

		if ("" == readURL) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " read URL attribute is empty."));
			return false;
		}

		var tbodyHTMLDB = document.getElementById(tableElementId + "_reader_tbody");

		var iframeFormGUID = document.getElementById(tableElementId + "_iframe_container").children.length;
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
				HTMLDB.doirlc(evEvent, true);
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

		if (object.id == undefined) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " rows must have unique id field."));
			return false;
		}

		var validateURL = HTMLDB.getHTMLDBParameter(tableElement, "validate-url");
		validateURL = HTMLDB.evaluateHTMLDBExpression(validateURL);

		if ("" == validateURL) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " validate URL attribute is empty."));
			return false;
		}

		var iframeFormGUID = document.getElementById(tableElementId + "_iframe_container").children.length;
		HTMLDB.createNewIframeAndForm(tableElementId, iframeFormGUID);

		var target = (tableElementId + "_iframe_" + iframeFormGUID);
		if (!document.getElementById(target)) {
			return false;
		}

		var formHTMLDB = document.getElementById(tableElementId + "_form_" + iframeFormGUID);
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
				iframeWindow = top.frames[tableElementId + "_iframe_" + iframeFormGUID];
				var strResponse = "";
				if (iframeWindow.document) {
					strResponse = String(iframeWindow.document.body.innerHTML).trim();
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

		var formContent = "<input class=\"htmldb_action\" type=\"hidden\" name=\""
				+ "htmldb_action0"
				+ "\" value=\""
				+ ((0 == object.id) ? "inserted" : "updated")
				+ "\" />";

		var propertyName = "";

		for (var propertyName in object) {
        	if (object.hasOwnProperty(propertyName)) {
				formContent += "<input class=\"htmldb_row\" type=\"hidden\" name=\""
						+ "htmldb_row0_" + propertyName
				 		+ "\" value=\""
						+ object[propertyName]
						+ "\" />";
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

		var loading = parseInt(tableElement.getAttribute("data-htmldb-loading"));

		if (loading > 0) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is loading right now."));
			return false;
		}

		if (true === delayed) {
			// Delayed Write
			clearTimeout(tableElement.tmWriteTimer);
			lWriteDelay = parseInt(tableElement.getAttribute("data-write-delay"));
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

		var iframeFormGUID = document.getElementById(tableElementId + "_iframe_container").children.length;
		HTMLDB.createNewIframeAndForm(tableElementId, iframeFormGUID);

		var strTarget = (tableElementId + "_iframe_" + iframeFormGUID);
		if (!document.getElementById(strTarget)) {
			return;
		}

		var tbodyHTMLDB = document.getElementById(tableElementId + "_writer_tbody");
		var arrTR = tbodyHTMLDB.children;
		var arrTD = null;
		var elTR = null;
		var lTRCount = arrTR.length;
		var formHTMLDB = document.getElementById(tableElementId + "_form_" + iframeFormGUID);
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
				iframeWindow = top.frames[tableElementId + "_iframe_" + iframeFormGUID];
				var strResponse = "";
				if (iframeWindow.document) {
					strResponse = String(iframeWindow.document.body.innerHTML).trim();
				}
				HTMLDB.removeIframeAndForm(tableElementId, iframeFormGUID);
				functionDone(tableElementId, strResponse);
				var redirectURL = HTMLDB.getHTMLDBParameter(tableElement, "redirect");
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

        for (var lCurrentTRIndex = 0; lCurrentTRIndex < lTRCount; lCurrentTRIndex++) {
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
	"get": function (p1, p2) {
		var elDIV = document.getElementById(p1);
		if (!elDIV) {
			return;
		}

		var elTD = null;

		var arrColumns = HTMLDB.getColumnNames(elDIV.id);
		var lColumnCount = arrColumns.length;
		var strJSON = "";
		for (var i = 0; i < lColumnCount; i++) {
			elTD = document.getElementById(p1 + "_reader_td" + p2 + arrColumns[i]);

			if (!elTD) {
				continue;
			}

			if (strJSON != "") {
				strJSON += ",";
			}

			strJSON += "\""
					+ arrColumns[i]
					+ "\":\""
					+ HTMLDB.ejs(elTD.innerHTML)
					+ "\"";
		}
		strJSON = "{" + strJSON + "}";

		return JSON.parse(strJSON);
	},
	"insert": function (tableElementId, object, className) {
		var elDIV = document.getElementById(tableElementId);
		if (!elDIV) {
			return;
		}

		if (undefined === className) {
			className = "";
		}

		var tbodyHTMLDB = document.getElementById(tableElementId + "_writer_tbody");
		var lTRCount = tbodyHTMLDB.children.length;

		var strTRContent = "<tr class=\"inserted"
				+ ((className!="") ? (" " + className) : "")
				+ "\" data-row-id=\"n"
				+ lTRCount
				+ "\" id=\""
				+ elDIV.id
				+"_trn"
				+ lTRCount
				+"\">";
		strTRContent += HTMLDB.generateTDHTML(elDIV, "_writer", object, ("n" + lTRCount));
    	strTRContent += "</tr>";

    	tbodyHTMLDB.innerHTML += strTRContent;
	},
	"update": function (p1, p2, p3, p4) {
		var elDIV = document.getElementById(p1);
		if (!elDIV) {
			return;
		}

		if (undefined === p4) {
			p4 = "";
		}

		if (0 == p2) {
			return HTMLDB.insert(p1, p3, p4);
		}

		var elTR = document.getElementById(p1 + "_writer_tr" + p2);

		if (!elTR) {
			return;
		}

		var tbodyHTMLDB = document.getElementById(p1 + "_writer_tbody");
		strTRContent = HTMLDB.generateTDHTML(elDIV, "_writer", p3, p2);

		elTR.innerHTML = strTRContent;
		if (-1 == elTR.className.indexOf("inserted")) {
			elTR.className = "updated" + ((p4!="") ? (" " + p4) : "");
		}
	},
	"delete": function (p1, p2, p3) {
		var elDIV = document.getElementById(p1);
		if (!elDIV) {
			return;
		}

		if (undefined === p3) {
			p3 = "";
		}

		var trDeleted = document.getElementById(p1 + "_writer_tr" + p2);
		if (trDeleted) {
			trDeleted.className = "deleted" + ((p3!="") ? (" " + p3) : "");
		}
	},
	"render": function (tableElement, functionDone) {
		HTMLDB.renderTemplates(tableElement);
		HTMLDB.renderSections(tableElement);
		HTMLDB.renderForms(tableElement);
		HTMLDB.renderSelects(tableElement);

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
        	if (1 == parseInt(HTMLDB.getHTMLDBParameter(tableElement, "loading"))) {
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
        	if (document.getElementById(tableElement.id + "_writer_tbody").children.length > 0) {
        		return false;
        	}
        }
        return true;
	},
	"getColumnNames": function (p1, p2) {
		var elTHead = document.getElementById(p1 + "_reader_thead");
		var arrTH = elTHead.children[0].children;
		var elTH = null;
		var lTHCount = arrTH.length;
		var arrReturn = new Array();

		for (var j = 0; j < lTHCount; j++) {
			elTH = arrTH[j];			
			arrReturn.push(elTH.innerHTML);
		}

		if (true === p2) {
			arrReturn.sort();
		}

		return arrReturn;
	},
	"getTableFieldActiveValue": function (tableElementId, column) {
		var tableElement = document.getElementById(tableElementId);

		if (!tableElement) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is referenced, but not found."));
			return false;
		}
		var activeId = parseInt(HTMLDB.getHTMLDBParameter(tableElement, "active-id"));

		if (isNaN(activeId) || (activeId < 1)) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is not active, or has no records."));
			return false;
		}
		columnElementId = (tableElementId + "_reader_td" + activeId + column);
		if (!document.getElementById(columnElementId)) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " column "
        			+ column
        			+ " not found."));
			return false;
		}
		return document.getElementById(tableElementId + "_reader_td" + activeId + column).innerHTML;
	},
	"setActiveId": function (tableElement, id) {
		tableElement.setAttribute("data-htmldb-active-id", id);
		HTMLDB.render(tableElement);
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
    		if (1 == parseInt(HTMLDB.getHTMLDBParameter(element, "read-only"))) {
    			continue;
    		}
    		if (!document.getElementById(element.id + "_writer_tbody")) {
    			continue;
    		}
    		loading = parseInt(HTMLDB.getHTMLDBParameter(element, "loading"));
    		if (loading > 0) {
    			continue;
    		}
    		writerTable = document.getElementById(element.id + "_writer_tbody");
    		if (0 == writerTable.children.length) {
    			continue;
    		}
    		rows = writerTable.querySelectorAll("tr.updating");
    		if (rows.length > 0) {
    			continue;
    		}
    		HTMLDB.markRows(writerTable, "updating");
    		HTMLDB.write(element.id, false, function (tableElementId, response) {
	    		var writerTable = document.getElementById(tableElementId + "_writer_tbody");
    			HTMLDB.deleteMarkedRows(writerTable, "updating");
    			// If there is a record to be written, write them first...
    			if (0 == writerTable.children.length) {
    				HTMLDB.doTableWrite(document.getElementById(tableElementId));
    			} else {
    				HTMLDB.writeTables();
    			}
    		});
    	}
	},
	"doTableWrite": function (tableElement) {
		if (1 == parseInt(HTMLDB.getHTMLDBParameter(tableElement, "write-only"))) {
			return true;
		}
		var redirectURL = HTMLDB.getHTMLDBParameter(tableElement, "redirect");
		if (redirectURL != "") {
			window.location.href = redirectURL;
		}
		document.getElementById(tableElement.id + "_reader_tbody").innerHTML = "";
		HTMLDB.updateReadQueue(tableElement);
	},
	"updateReadQueue": function (tableElement) {
		if (HTMLDB.isInReadQueue(tableElement)) {
			return;
		}
		var tableIds = [];
		var tableId = "";
		var tableIdCount = 0;
		var priority = 0;

		tableIds.push(tableElement.id);

		var childTableIds = HTMLDB.extractChildTables();
		if (childTableIds[tableElement.id] !== undefined) {
			tableIds = tableIds.concat(childTableIds[tableElement.id]);
		}

		tableIdCount = tableIds.length;

		for (var i = 0; i < tableIdCount; i++) {
			tableId = tableIds[i];
			priority = parseInt(HTMLDB.getHTMLDBParameter(tableElement, "priority"));
			if (undefined === HTMLDB.readQueue[priority]) {
				HTMLDB.readQueue[priority] = [];
			}
			HTMLDB.readQueue[priority][HTMLDB.readQueue[priority].length] = tableId;
		}
		
		HTMLDB.processReadQueue();
	},
	"isInReadQueue": function (tableElement) {
		for (var tables in HTMLDB.readQueue){
		    if (tables.indexOf(tableElement.id) != -1) {
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
		var rows = document.getElementById(tableElement.id + "_reader_tbody").children;
        var templateElements = document.body.querySelectorAll(".htmldb-template");
        var templateElementCount = templateElements.length;
        var templateElement = null;

		for (var i = 0; i < templateElementCount; i++) {
			templateElement = templateElements[i];
			if (tableElement.id
					!= HTMLDB.getHTMLDBParameter(templateElement, "table")) {
				continue;
			}

			if (templateElement.renderFunction) {
				templateElement.renderFunction(tableElement, rows);
			}
		}

		if (tableElement.renderFunction) {
			elDIV.renderFunction(newRow);
		}
	},
	"renderSections": function (tableElement) {
        var sections = document.body.querySelectorAll(".htmldb-section");
        var sectionCount = sections.length;
        var section = null;
        for (var i = 0; i < sectionCount; i++) {
            section = sections[i];
            if (HTMLDB.getHTMLDBParameter(section, "table") == tableElement.id) {
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
            if (HTMLDB.getHTMLDBParameter(form, "table") == tableElement.id) {
            	HTMLDB.renderFormElement(form);
            	HTMLDB.doParentElementToggle(form);
            }
        }
        HTMLDB.initializeHTMLDBEditButtons(tableElement);
	},
	"renderSelects": function (tableElement) {
        var selects = document.body.querySelectorAll("select.htmldb-field");
        var selectCount = selects.length;
        var select = null;
        for (var i = 0; i < selectCount; i++) {
            select = selects[i];
            if (HTMLDB.getHTMLDBParameter(select, "option-table") == tableElement.id) {
            	HTMLDB.renderSelectElement(select);
            }
        }
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
        	priority = parseInt(HTMLDB.getHTMLDBParameter(tableElement, "priority"));
        	if (isNaN(priority)) {
        		priority = 0;
        		tableElement.setAttribute("data-htmldb-priority", priority);
        	}
        }

        var parents = HTMLDB.extractParentTables();

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];

        	if (0 == parents[tableElement.id]) {
        		continue;
        	}

        	if (HTMLDB.getHTMLDBParameter(tableElement, "priority")
        			> HTMLDB.getMaxPriority(parents[tableElement.id])) {
        		continue;
        	}

        	priority = HTMLDB.getMaxPriority(parents[tableElement.id]) + 1;
        	tableElement.setAttribute("data-htmldb-priority", priority);
        }
	},
	"initializeHTMLDBTemplates": function () {
        var templateElements = document.body.querySelectorAll(".htmldb-template");
        var templateElementCount = templateElements.length;
        var templateElement = null;
        var tableElementId = "";
        var targetElementId = "";
		var functionBody = "";

        for (var i = 0; i < templateElementCount; i++) {
        	templateElement = templateElements[i];
        	templateElement.HTMLDBGUID = HTMLDB.generateGUID();
        	HTMLDB.validateHTMLDBTemplateDefinition(templateElement);
        	tableElementId = HTMLDB.getHTMLDBParameter(templateElement, "table");
        	targetElementId = HTMLDB.getHTMLDBParameter(templateElement, "template-target");
			functionBody = HTMLDB.generateTemplateRenderFunctionString(
					templateElement,
					tableElementId,
					targetElementId);
			templateElement.renderFunction = new Function("tableElement", "rows", functionBody);
        }
	},
	"initializeHTMLDBButtons": function () {
		HTMLDB.initializeHTMLDBRefreshButtons();
		HTMLDB.initializeHTMLDBAddButtons();
		HTMLDB.initializeHTMLDBEditButtons();
		HTMLDB.initializeHTMLDBSaveButtons();
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
					if (elements[i].selectize) {
						elements[i].selectize.clear(true);
					}
				break;
				default:
				break;
			}
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
	        			+ "var object=HTMLDB.convertFormToObject(document.getElementById(\""
	        			+ parent.id
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

        	toggle.toggleFunction = new Function(
					functionHeader
					+ functionBody
					+ functionFooter);

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
		var type = "";
		var tagName = "";
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
			tagName = element.tagName.toLowerCase();
			type = element.type.toLowerCase();
			if (tagName == "input") {
				if ((type == "checkbox") || (type == "radio")) {
					if (element.addEventListener) {
						element.addEventListener("click", function () {
							HTMLDB.doParentElementToggle(form);
						}, true);
					} else if (element.attachEvent) {
			            element.attachEvent("onclick", function () {
							HTMLDB.doParentElementToggle(form);
						});
			        }
				}
			} else if (tagName == "select") {
				if (element.addEventListener) {
					element.addEventListener("change", function () {
						HTMLDB.doParentElementToggle(form);
					}, true);
				} else if (element.attachEvent) {
		            element.attachEvent("onchange", function () {
						HTMLDB.doParentElementToggle(form);
					});
		        }
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

        if ((element.HTMLDBInitials !== undefined)
        		&& (element.HTMLDBInitials.attributes !== undefined)) {
            var attributeCount = element.HTMLDBInitials.attributes.length;
            var attributeName = "";
            var attributeValue = "";
            var content = "";
            for (var i = 0; i < attributeCount; i++) {
                attributeName = element.HTMLDBInitials.attributes[i].name;
                attributeValue = element.HTMLDBInitials.attributes[i].value;
                content = HTMLDB.evaluateHTMLDBExpression(attributeValue, tableElement.id);
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
                content = HTMLDB.evaluateHTMLDBExpression(element.HTMLDBInitials.content, tableElement.id);
                element.innerHTML = content;
            } else {
            	if (HTMLDB.hasHTMLDBParameter(element, "content")) {
            		element.innerHTML = HTMLDB.getHTMLDBParameter(element, "content");
            	}
            }
        }
    },
    "renderFormElement": function (form) {
    	var inputs = form.querySelectorAll(".htmldb-field");
    	var inputCount = inputs.length;
    	var input = null;
    	var valueTemplate = "";
    	var tableElement = HTMLDB.exploreHTMLDBTable(form);
    	for (var i = 0; i < inputCount; i++) {
    		input = inputs[i];
    		valueTemplate = HTMLDB.getHTMLDBParameter(input, "value");
			HTMLDB.setInputValue(input,
					HTMLDB.evaluateHTMLDBExpression(valueTemplate, tableElement.id));
			input.dispatchEvent(new CustomEvent("htmldbsetvalue", {detail: {}}));
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
        			+ " not found. Referenced by data-htmldb-option-table attribute "
        			+ "of select element " + select.id));
			return false;
    	}

    	var tableElement = document.getElementById(tableElementId);
    	var initialActiveId = tableElement.getAttribute("data-htmldb-active-id");
		var rows = document.getElementById(tableElementId + "_reader_tbody").children;
		var rowCount = rows.length;
		var row = null;
		var object = null;
		var id = 0;
		var content = "";
		var title = "";
		var value = "";

		select.innerHTML = "";

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
 			select.options[select.options.length] = new Option(title, value);
		}
		
		tableElement.setAttribute("data-htmldb-active-id", initialActiveId);
		select.dispatchEvent(new CustomEvent("htmldbsetoptions", {detail: {}}));
    },
	"initializeHTMLDBRefreshButtons": function () {
        var buttonElements = document.body.querySelectorAll(".htmldb-button-refresh");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener("click", HTMLDB.doRefreshButtonClick, true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent("onclick", HTMLDB.doRefreshButtonClick);
	        }
	    }
	},
	"initializeHTMLDBAddButtons": function () {
        var buttonElements = document.body.querySelectorAll(".htmldb-button-add");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener("click", HTMLDB.doAddButtonClick, true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent("onclick", HTMLDB.doAddButtonClick);
	        }
	    }
	},
	"initializeHTMLDBSaveButtons": function () {
        var buttonElements = document.body.querySelectorAll(".htmldb-button-save");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener("click", HTMLDB.doSaveButtonClick, true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent("onclick", HTMLDB.doSaveButtonClick);
	        }
	    }
	},
	"initializeHTMLDBEditButtons": function (tableElement) {
        var buttons = document.body.querySelectorAll(".htmldb-button-edit");
        var buttonCount = buttons.length;
        var button = null;

        for (var i = 0; i < buttonCount; i++) {
        	button = buttons[i];

        	if (tableElement) {
	            if (HTMLDB.getHTMLDBParameter(button, "table") != tableElement.id) {
	            	continue;
	            }
        	}

			if (button.addEventListener) {
				button.addEventListener("click", HTMLDB.doEditButtonClick, true);
			} else if (button.attachEvent) {
	            button.attachEvent("onclick", HTMLDB.doEditButtonClick);
	        }
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
        	priority = parseInt(HTMLDB.getHTMLDBParameter(tableElement, "priority"));
        	if (-1 == indices.indexOf(priority)) {
			    indices.push(priority);
        	}
        }

		indices.sort();

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	priority = parseInt(HTMLDB.getHTMLDBParameter(tableElement, "priority"));
        	index = indices.indexOf(priority);
			if (undefined === priorities[index]) {
				priorities[index] = [];
			}
        	priorities[index].push(tableElement.id);
        }

        HTMLDB.readQueue = priorities;
        HTMLDB.processReadQueue();
	},
	"readChildTable": function (tableElementId, functionDone) {
		var tableElement = document.getElementById(tableElementId);
		var functionBody = "";

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

		document.getElementById(tableElementId + "_reader_thead").innerHTML = 
				document.getElementById(parentTableId + "_reader_thead").innerHTML;
		document.getElementById(tableElementId + "_writer_thead").innerHTML = 
				document.getElementById(parentTableId + "_reader_thead").innerHTML;

		functionBody = HTMLDB.generateChildTableFilterFunctionString(tableElement);

		try {
			tableElement.filterFunction = new Function('object', functionBody);
		} catch (e) {
        	throw(new Error("HTMLDB child table "
        			+ tableElementId
        			+ " filter function could not be created."));
			return false;			
		}

		var rows = document.getElementById(parentTableId + "_reader_tbody").children;
		var rowCount = rows.length;
		var row = null;
		var object = null;
		var id = 0;
		var content = "";
		var activeId = 0;

		for (var i = 0; i < rowCount; i++) {
			row = rows[i];
			id = HTMLDB.getHTMLDBParameter(row, "data-row-id");
			object = HTMLDB.convertRowToObject(parentTableId, row);
			if (!tableElement.filterFunction(object)) {
				continue;
			}

			content += "<tr class=\"refreshed\" data-row-id=\""
					+ id
					+ "\" id=\""
					+ (tableElementId
					+ "_reader_tr"
					+ id)
					+ "\">";
			content += HTMLDB.generateTDHTML(tableElement, "_reader", object, id);
			content += "</tr>";

			if (0 == activeId) {
				activeId = id;
			}
		}

		document.getElementById(tableElementId + "_reader_tbody").innerHTML = content;
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
			property = column.id.replace((tableElementId + "_reader_td" + id), "");
			object[property] = column.innerHTML;
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
			priority = parseInt(HTMLDB.getHTMLDBParameter(tableElement, "priority"));
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

		HTMLDB.readingQueue = HTMLDB.readQueue.shift();
		readingQueueCount = 0;
		if (HTMLDB.readingQueue) {
			readingQueueCount = HTMLDB.readingQueue.length;
		}

		tableElementId = "";

		for (var i = 0; i < readingQueueCount; i++) {
			tableElementId = HTMLDB.readingQueue[i];
			HTMLDB.read(tableElementId);
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
        	parents[tableElement.id] = [];
        	parentTable = HTMLDB.getHTMLDBParameter(tableElement, "table");

        	if (parentTable) {
        		parents[tableElement.id]
        				= parents[tableElement.id].concat(Array(parentTable));
        	}

        	expressionTables = HTMLDB.extractHTMLDBExpressionTables(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"read-url"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.id]
        				= parents[tableElement.id].concat(expressionTables);
        	}

        	expressionTables = HTMLDB.extractHTMLDBExpressionTables(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"write-url"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.id]
        				= parents[tableElement.id].concat(expressionTables);
        	}

        	expressionTables = HTMLDB.extractHTMLDBExpressionTables(
        			HTMLDB.getHTMLDBParameter(
        			tableElement,
        			"validate-url"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.id]
        				= parents[tableElement.id].concat(expressionTables);
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

        if ("" == element.id) {
        	throw(new Error("All HTMLDB table element must have a unique id attribute."));
        	return false;
        }

        for (var i = 0; i < reservedIdCount; i++) {
        	if (document.getElementById(element.id + reservedIds[i])) {
	        	throw(new Error(element.id + reservedIds[i] + " has been used."));
	        	return false;
        	}
        }
	},
	"validateHTMLDBTemplateDefinition": function (element) {
		var tableElementId = HTMLDB.getHTMLDBParameter(element, "table");
		var targetElementId = HTMLDB.getHTMLDBParameter(element, "template-target");

    	if (("" == tableElementId) || (!document.getElementById(tableElementId))) {
        	throw(new Error(tableElementId + " HTMLDB table not found."));
    		return;
    	}

    	if (("" == targetElementId) || (!document.getElementById(targetElementId))) {
        	throw(new Error("Template target element " + targetElementId + " not found."));
    		return;
    	}
	},
	"createHelperElements": function (element) {
        var tableHTML = "";
        var iframeHTML = "";
        var formHTML = "";

		tableHTML = "<table id=\""
				+ element.id + "_reader"
				+ "_table\">"
				+ "<thead id=\""
				+ element.id + "_reader"
				+ "_thead\"></thead>"
				+ "<tbody id=\""
				+ element.id + "_reader"
				+ "_tbody\"></tbody></table>";

		tableHTML += "<table id=\""
				+ element.id + "_writer"
				+ "_table\">"
				+ "<thead id=\""
				+ element.id + "_writer"
				+ "_thead\"></thead>"
				+ "<tbody id=\""
				+ element.id + "_writer"
				+ "_tbody\"></tbody></table>";

		iframeHTML = "<div id=\""
				+ element.id
				+ "_iframe_container\"></div>";

		formHTML = "<div id=\""
				+ element.id
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

		functionHeader = "if(tableElement.id!=\""
				+ tableElementId
				+ "\")return;var generatedCode"
				+ templateElement.HTMLDBGUID
				+ "=\"\";"
				+ "var rowCount=rows.length;"
				+ "for(var currentRow=0;currentRow<rowCount;currentRow++){";

		functionBody = "generatedCode"
				+ templateElement.HTMLDBGUID
				+ "="
				+ "generatedCode"
				+ templateElement.HTMLDBGUID;

		tokenCount = tokens.length;

		if (tokenCount > 1) {
			content = tokens[0];
			text = content;
			text = String(text).replace(/(?:\r\n|\r|\n)/g, "");
			functionBody += "+\"" + HTMLDB.as((String(text).trim())) + "\"";
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
				functionBody += "+document.getElementById(\""
						+ tableElementId
						+ "_reader_td\"+rows[currentRow].getAttribute(\"data-row-id\")+\""
						+ column
						+ "\").innerHTML";

				if (-1 == columnHistory.indexOf("," + tableElementId + "." + column + ",")) {
					functionHeader += "if(!document.getElementById(\""
							+ tableElementId
							+ "_reader_td\"+rows[currentRow].getAttribute(\"data-row-id\")+\""
							+ column
							+ "\")){"
							+ "throw(new Error(\"An unknown field "
							+ tableElementId
							+ "."
							+ column
							+ " is used in template."
							+ "\"));return;}";
					columnHistory += ("," + tableElementId + "." + column + ",");
				}
			}

			text = String(content).substr(position + 2);
			text = String(text).replace(/(?:\r\n|\r|\n)/g, "");

			functionBody += "+\"" + HTMLDB.as((String(text).trim())) + "\"";
		}

		functionBody += ";}"
				+ "document.getElementById(\""
				+ targetElementId
				+ "\").innerHTML=generatedCode"
				+ templateElement.HTMLDBGUID
				+ ";";

		return (functionHeader + functionBody);
	},
	"generateChildTableFilterFunctionString": function (tableElement) {
		var filter = HTMLDB.getHTMLDBParameter(tableElement, "filter");
		var functionBody = "";

		functionBody = "success=false;";

		if (filter != "") {
			functionBody = generateFilterFunctionBlock(filter, tableElement);
		} else {
			functionBody += "success=true;";
		}

		functionBody += "return success;"
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
		var invalidErrorText = "HTMLDB"
				+ (isForm ? " form " : " table ")
				+ parent.id
				+ " has invalid filter attribute.";

		if ("" == filter) {
			return functionBlock;
		}

		while (index < tokenCount) {
			property = HTMLDB.evaluateHTMLDBExpression(tokens[index]);

			functionBlock += "if(undefined===object[\"" + property + "\"]){"
					+ "throw(new Error(\"HTMLDB"
					+ (isForm ? " form " : " table ")
					+ parent.id
					+ " has unknown filter field:"
					+ property
					+ "\"));return;}";
			functionBlock += ("success=success" + andor + "(object[\"" + property + "\"]");

			index++;
			if (index >= tokenCount) {
	        	throw(new Error(invalidErrorText));
	    		return;
			}

			operator = String(tokens[index]).toLowerCase();

			switch (operator) {
				case "is":
				case "eq":
					functionBlock += "==";
				break;
				case "isnot":
				case "neq":
					functionBlock += "!=";
				break;
				case "gt":
					functionBlock += ">";
				break;
				case "gte":
					functionBlock += ">=";
				break;
				case "lt":
					functionBlock += "<";
				break;
				case "lte":
					functionBlock += "<=";
				break;
				default:
	        		throw(new Error("HTMLDB"
							+ (isForm ? " form " : " table ")
	        				+ parent.id
	        				+ " has invalid filter operator:" + operator));
	    			return;
				break;
			}

			index++;
			if (index >= tokenCount) {
	        	throw(new Error(invalidErrorText));
	    		return;
			}

			constant = HTMLDB.evaluateHTMLDBExpression(tokens[index]);

			functionBlock += constant + ");";

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
		var iframeContainer = document.getElementById(htmldbId + "_iframe_container");
		var formContainer = document.getElementById(htmldbId + "_form_container");
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
		var iframeContainer = document.getElementById(htmldbId + "_iframe_container");
		var formContainer = document.getElementById(htmldbId + "_form_container");
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
        				+ tableElement.id
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
		var form = document.getElementById(tableElement.id + "_form_" + iframeFormGUID);
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

		var formContent = "<input class=\"htmldb_action\" type=\"hidden\" name=\""
				+ "htmldb_action" + index
				+ "\" value=\""
				+ inputAction
				+ "\" />";

		var columns = HTMLDB.getColumnNames(tableElement.id, false);
		var columnCount = columns.length;
		var rowId = row.getAttribute("data-row-id");
		var prefix = (tableElement.id + "_writer_td" + rowId);
		var fieldCount = row.children.length;
		var values = {};
		var value = "";

		for (var i = 0; i < fieldCount; i++) {
			values[row.children[i].id] = row.children[i].innerHTML;
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
            var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;return v.toString(16);
        });
        var token2 = 'xxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;return v.toString(16);
        });  
        
        if (!prefix) {
        	prefix = "";
        }

        return prefix + token0 + token1 + token2;
    },
    "evaluateHTMLDBExpression": function (expression, tableElementId) {
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

			if ((tableElementId !== undefined)
					&& ("" == foreignTableId)) {
				foreignTableId = tableElementId;
			}

			if ("$" == foreignTableId[0]) {
				value = HTMLDB.evaluateHTMLDBGlobalObject(foreignTableId, column);
			} else if (foreignTableId != "") {
				value = HTMLDB.getTableFieldActiveValue(foreignTableId, column);
			} else {
				value = ("{{" + content);
			}

			text = String(content).substr(position + 2);
			text = String(text).replace(/(?:\r\n|\r|\n)/g, "");

			content = value + HTMLDB.as((String(text).trim()));

			tokens[i] = content;
		}

		if (tokens.length > 1) {
			returnValue = tokens.join("");
		}

		return returnValue;
    },
    "evaluateHTMLDBGlobalObject": function (globalObject, parameter) {
    	globalObject = globalObject.toLowerCase();
    	switch (globalObject) {
    		case "$url":
    			return HTMLDB.getURLParameter(parseInt(parameter));
    		break;
    	}
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
	"doReaderIframeLoad":function (p1) {
		HTMLDB.doirlc(p1, false);
		HTMLDB.render(p1.target.parentNode.parentNode);
	},
	"doRefreshButtonClick": function () {
		HTMLDB.initializeReadQueue();
	},
	"doAddButtonClick": function (event) {
		var formElement = document.getElementById(HTMLDB.getHTMLDBParameter(event.target, "form"));
		if (!formElement) {
        	throw(new Error("Add button HTMLDB form not found."));
			return false;
		}
		HTMLDB.resetForm(formElement);
		formElement.dispatchEvent(new CustomEvent("htmldbadd", {detail: {}}));
	},
	"doSaveButtonClick": function (event) {
		var formId = HTMLDB.getHTMLDBParameter(event.target, "form");
		var form = null;

		if (formId != "") {
			form = document.getElementById(formId);
			if (!form) {
	        	throw(new Error("Save button HTMLDB form not found."));
				return false;
			}
		} else {
			form = HTMLDB.exploreHTMLDBForm(event.target);			
		}

		var tableElementId = HTMLDB.getHTMLDBParameter(form, "table");

		if (!document.getElementById(tableElementId)) {
	        throw(new Error(formId + " form HTMLDB table not found."));
			return false;			
		}

		var object = HTMLDB.convertFormToObject(form);

		HTMLDB.validate(tableElementId, object, function (DIVId, response) {
			var responseObject = null;
			try {
				responseObject = JSON.parse(response);
			} catch(e) {
	        	throw(new Error("HTMLDB table "
	        			+ DIVId
	        			+ " could not be validated: Not valid JSON format"));
				return false;
			}
			if (responseObject.errorCount > 0) {
				HTMLDB.showError(tableElementId, responseObject.lastError);
			} else {
				HTMLDB.showMessage(tableElementId, responseObject.lastMessage);
				HTMLDB.insert(tableElementId, object);
				event.target.dispatchEvent(new CustomEvent("htmldbsave", {detail: {}}));
			}
		});
	},
	"convertFormToObject": function (form) {
		var elements = form.querySelectorAll(".htmldb-field");
		var elementCount = elements.length;
		var element = null;
		var object = {};

		for (var i = 0; i < elementCount; i++) {
			element = elements[i];
			object[element.getAttribute("data-htmldb-field")]
					= HTMLDB.getInputValue(element);
		}

		return object;
	},
	"showLoader": function (tableElementId, type) {
		var tableElement = document.getElementById(tableElementId);
		var loader = HTMLDB.getHTMLDBParameter(tableElement, (type + "-loader"));
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
		var loader = HTMLDB.getHTMLDBParameter(tableElement, (type + "-loader"));
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
    		loaderElement.className = String(loaderElement.className.replace(/\bactive\b/g, "")).trim();
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
        		HTMLDB.hideLoader(tableElement.id, "read");
        	}
			loader = HTMLDB.getHTMLDBParameter(tableElement, ("write-loader"));
        	if (loader != "") {
        		loaderElement = document.getElementById(loader);
        		loaderElement.depth = 0;
        		HTMLDB.hideLoader(tableElement.id, "write");
        	}
			loader = HTMLDB.getHTMLDBParameter(tableElement, ("validate-loader"));
        	if (loader != "") {
        		loaderElement = document.getElementById(loader);
        		loaderElement.depth = 0;
        		HTMLDB.hideLoader(tableElement.id, "validate");
        	}
			loader = HTMLDB.getHTMLDBParameter(tableElement, ("loader"));
        	if (loader != "") {
        		loaderElement = document.getElementById(loader);
        		loaderElement.depth = 0;
        		HTMLDB.hideLoader(tableElement.id, "");
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
			if (HTMLDB.getHTMLDBParameter(container, "table") == tableElementId) {
				container.innerHTML = errorText;
				container.dispatchEvent(new CustomEvent("htmldberror", {
					detail: {"tableElementId":tableElementId,"errorText":errorText}
				}));
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
			if (HTMLDB.getHTMLDBParameter(container, "table") == tableElementId) {
				container.innerHTML = messageText;
				container.dispatchEvent(new CustomEvent("htmldbmessage", {
					detail: {"tableElementId":tableElementId,"messageText":messageText}
				}));
			}
		}
		tableElement.dispatchEvent(new CustomEvent("htmldbmessage",
				{detail:{"messageText":messageText}}));
	},
	"doEditButtonClick": function (event) {
		var tableElement = null;
		var formElement = null;
		var tableElementId = HTMLDB.getHTMLDBParameter(event.target, "table");
		var formElementId = HTMLDB.getHTMLDBParameter(event.target, "form");

		if ((tableElementId == "") && (formElementId != "")) {
			formElement = document.getElementById(formElementId);
			if (!formElement) {
	        	throw(new Error("Edit button HTMLDB form " + formElementId + " not found."));
				return false;
			}
			tableElementId = HTMLDB.getHTMLDBParameter(formElement, "table");
		}

		tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
        	throw(new Error("Edit button HTMLDB table " + tableElementId + " not found."));
			return false;
		}

		HTMLDB.setActiveId(
				tableElement,
				HTMLDB.getHTMLDBParameter(event.target, "edit-id"));
	},
	"doWriterIframeLoad": function (p1) {
		elDIV = p1.target.parentNode.parentNode;
		elDIV.setAttribute("data-htmldb-loading", 0);
		HTMLDB.hideLoader(elDIV.id, "write");
		iframeWindow = top.frames[p1.target.id];
		var strResponse = "";
		if (iframeWindow.document) {
			strResponse = String(iframeWindow.document.body.innerHTML).trim();
		}

		var iframeFormDefaultName = (elDIV.id + "_iframe_");
		var iframeFormGUID = p1.target.id.substr(iframeFormDefaultName.length);
		HTMLDB.removeIframeAndForm(elDIV.id, iframeFormGUID);

		if (elDIV.doHTMLDBWrite) {
			elDIV.doHTMLDBWrite(elDIV, strResponse);
		}
	},
	"doValidatorIframeLoad": function (p1) {
		elDIV = p1.target.parentNode.parentNode;
		elDIV.setAttribute("data-htmldb-loading", 0);
		HTMLDB.hideLoader(elDIV.id, "validate");
		iframeWindow = top.frames[p1.target.id];
		var strResponse = "";
		if (iframeWindow.document) {
			strResponse = String(iframeWindow.document.body.innerHTML).trim();
		}

		var iframeFormDefaultName = (elDIV.id + "_iframe_");
		var iframeFormGUID = iframeHTMLDB.id.substr(iframeFormDefaultName.length);
		HTMLDB.removeIframeAndForm(elDIV.id, iframeFormGUID);

		if (elDIV.doHTMLDBValidate) {
			elDIV.doHTMLDBValidate(p1, strResponse);
		}
	},
	"getInputValue": function (input) {
		var inputs = null;
		var inputCount = 0;
		var tagName = "";
		var inputType = "";

		tagName = String(input.tagName).toLowerCase();
		inputType = String(input.getAttribute("type")).toLowerCase();

		switch (tagName) {
			case "input":
				if ("checkbox" == inputType) {
					return (input.checked ? 1 : 0);
				} else if ("radio" == inputType) {
					return ((input.checked) ? input.value : "");
				} else {
					return input.value;
				}
			break;

			case "textarea":
				return input.value;
			break;
			case "select":
				if (-1 == input.selectedIndex) {
					return "";
				} else {
					return (input.value || input.options[input.selectedIndex].value);
				}
			break;
		}

		return "";
	},
	"setInputValue": function (input, value) {
		var tagName = String(input.tagName).toLowerCase();
		var inputType = String(input.getAttribute("type")).toLowerCase();

		switch (tagName) {
			case "input":
				if ("checkbox" == inputType) {
					input.checked = ("1" == value);
				} else if ("radio" == inputType) {
					if (input.value == value) {
						input.checked = true;
					}
				} else {
					input.value = value;
				}
			break;
			case "textarea":
				input.innerHTML = value;
			break;
			case "select":
				input.value = value;
			break;
		}
	},
	"doirlc": function (p1, p2) {
		var iframeHTMLDB = p1.target;
		var elDIV = iframeHTMLDB.parentNode.parentNode;
		var strHTMLDBDIVID = iframeHTMLDB.parentNode.parentNode.id;
		var tbodyHTMLDB = document.getElementById(strHTMLDBDIVID + "_reader_tbody");
		var theadHTMLDB = document.getElementById(strHTMLDBDIVID + "_reader_thead");
		iframeWindow = top.frames[iframeHTMLDB.id];
		var strResponse = "";
		if (iframeWindow.document) {
			strResponse = String(iframeWindow.document.body.innerHTML).trim();
		}

		if (strResponse != "") {

			var arrList = [];

			try {
				arrList = JSON.parse(strResponse);
			} catch(e) {
	        	throw(new Error("HTMLDB table "
	        			+ elDIV.id
	        			+ " could not be read: Not valid JSON format from URL "
	        			+ p1.target.src));
				return false;
			}

			var arrColumns = arrList.c;
			var lRowCount = arrList.r.length;
			var lColumnCount = arrList.c.length;
			var strRowContent = "";
			var strColumnContent = "";
			var strPropertyName = "";
			var elTR = null;

			strColumnContent = "<tr>";

			for (j = 0; j < lColumnCount; j++) {
				strColumnContent += ("<th>" + arrColumns[j] + "</th>");
			}

			strColumnContent += "</tr>";

			var activeId = 0;

			for (var i = 0; i < lRowCount; i++) {
				elTR = document.getElementById(strHTMLDBDIVID + "_reader_tr" + arrList.r[i][0]);
				if (elTR) {
					elTR.parentNode.removeChild(elTR);
				}

				if (0 == i) {
					activeId = arrList.r[i][0];
				}

				strRowContent += "<tr class=\"refreshed\" data-row-id=\""
						+ arrList.r[i][0]
						+ "\" id=\"" + (strHTMLDBDIVID + "_reader_tr" + arrList.r[i][0]) + "\">";
				for (j = 0; j < lColumnCount; j++) {
				    strRowContent += ("<td id=\""
				    		+ (strHTMLDBDIVID + "_reader_td" + arrList.r[i][0])
				    		+ (arrColumns[j])
				    		+ "\">"
				    		+ arrList.r[i][j]
				    		+ "</td>");
				}

				strRowContent += "</tr>";
			}

			theadHTMLDB.innerHTML = strColumnContent;
			tbodyHTMLDB.innerHTML += strRowContent;
			document.getElementById(elDIV.id + "_writer_thead").innerHTML = strColumnContent;
			elDIV.setAttribute("data-htmldb-active-id", activeId);
		}

		var iframeFormDefaultName = (elDIV.id + "_iframe_");
		var iframeFormGUID = iframeHTMLDB.id.substr(iframeFormDefaultName.length);
		HTMLDB.removeIframeAndForm(elDIV.id, iframeFormGUID);

		if ((p2 === false) && elDIV.doHTMLDBRead) {
			elDIV.doHTMLDBRead(elDIV);
		} else if ((p2 === true) && elDIV.doHTMLDBReadAll) {
			elDIV.doHTMLDBReadAll(elDIV);
		}

		elDIV.setAttribute("data-htmldb-loading", 0);
		HTMLDB.hideLoader(tableElementId, "read");

		setTimeout(function () {
			HTMLDB.removeFromReadingQueue(elDIV.id);
			HTMLDB.processReadQueue();
		}, 150);
	}
}
HTMLDB.initialize();
(function () {
	if (typeof window.CustomEvent === "function") {
		return false;
	}
	function CustomEvent(event, params) {
		params = (params || { bubbles: false, cancelable: false, detail:  undefined });
		var evt = document.createEvent("CustomEvent");
		evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
		return evt;
	}
	CustomEvent.prototype = window.Event.prototype;
	window.CustomEvent = CustomEvent;
})();