/*! < ())) > HTMLDB.js - v1.0.0 | https://github.com/htmldbjs/htmldbjs/ | MIT license */
var HTMLDB = {
	"__readQueue": [],
	"__readingQueue": [],
	"initialize": function() {
		HTMLDB.__initializeHTMLDBTables();
		HTMLDB.__initializeHTMLDBTemplates();
		HTMLDB.__initializeHTMLDBButtons();
		HTMLDB.__initializeHTMLDBSections();
		HTMLDB.__initializeHTMLDBForms();
		HTMLDB.__initializeReadQueue();
	},
	"stop":function(tableElementId) {
		var tableElement = document.getElementById(tableElementId);
		if (!tableElement) {
			return;
		}
		tableElement.setAttribute("data-htmldb-loading", 0);
	},
	"read":function(tableElementId, functionDone) {
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

		var parentTable = HTMLDB.__getHTMLDBParameter(tableElement, "table");

		if (parentTable != "") {
			return HTMLDB.__readChildTable(tableElementId, functionDone);
		}

		var readURL = HTMLDB.__getHTMLDBParameter(tableElement, "read-url");
		readURL = HTMLDB.__evaluateHTMLDBExpression(readURL);

		if ("" == readURL) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " read URL attribute is empty."));
			return false;
		}

		var tbodyHTMLDB = document.getElementById(tableElementId + "_reader_tbody");

		var iframeFormGUID = document.getElementById(tableElementId + "_iframe_container").children.length;
		HTMLDB.__createNewIframeAndForm(tableElementId, iframeFormGUID);

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

		var funcIframeLoadCallback = HTMLDB.__doReaderIframeLoad;

		if (functionDone) {
			funcIframeLoadCallback = function (evEvent) {
				tableElement.setAttribute("data-htmldb-loading", 0);
				HTMLDB.__doirlc(evEvent, true);
				/*
				HTMLDB.__removeIframeAndForm(tableElementId, iframeFormGUID);
				HTMLDB.__removeFromReadingQueue(tableElementId);
				HTMLDB.__processReadQueue();
				*/
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
	"validate":function(tableElementId, object, functionDone) {
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

		var validateURL = HTMLDB.__getHTMLDBParameter(tableElement, "validate-url");
		validateURL = HTMLDB.__evaluateHTMLDBExpression(validateURL);

		if ("" == validateURL) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " validate URL attribute is empty."));
			return false;
		}

		var iframeFormGUID = document.getElementById(tableElementId + "_iframe_container").children.length;
		HTMLDB.__createNewIframeAndForm(tableElementId, iframeFormGUID);

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

		var funcIframeLoadCallback = HTMLDB.__doValidatorIframeLoad;

		if (functionDone) {
			funcIframeLoadCallback = function () {
				tableElement.setAttribute("data-htmldb-loading", 0);
				iframeWindow = top.frames[tableElementId + "_iframe_" + iframeFormGUID];
				var strResponse = "";
				if (iframeWindow.document) {
					strResponse = String(iframeWindow.document.body.innerHTML).trim();
				}
				HTMLDB.__removeIframeAndForm(tableElementId, iframeFormGUID);
				functionDone(tableElementId, strResponse);
			}
		}

		if (iframeHTMLDB.addEventListener) {
			iframeHTMLDB.addEventListener("load", funcIframeLoadCallback, true);
		} else if (iframeHTMLDB.attachEvent) {
            iframeHTMLDB.attachEvent("onload", funcIframeLoadCallback);
        }

        formHTMLDB.innerHTML = "";

		var formContent = "<input class=\"htmldbaction\" type=\"hidden\" name=\""
				+ "htmldbaction0"
				+ "\" value=\""
				+ ((0 == object.id) ? "inserted" : "updated")
				+ "\" />";

		var propertyName = "";

		for (var propertyName in object) {
        	if (object.hasOwnProperty(propertyName)) {
				formContent += "<input class=\"htmldbfield\" type=\"hidden\" name=\""
						+ "htmldbfield0_" + propertyName
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
	"write":function(p1, p2, functionDone) {
		var elDIV = document.getElementById(p1);
		if (!elDIV) {
			return;
		}

		if (true === p2) {
			// Delayed Write
			clearTimeout(elDIV.tmWriteTimer);
			lWriteDelay = parseInt(elDIV.getAttribute("data-write-delay"));
			if (isNaN(lWriteDelay)) {
				lWriteDelay = 2000;
			}
			elDIV.tmWriteTimer = setTimeout(function () {
				clearTimeout(elDIV.tmWriteTimer);
				HTMLDB.write(p1, false, functionDone);
			}, lWriteDelay);
			return;
		}

		var bLoading = parseInt(elDIV.getAttribute("data-htmldb-loading"));

		if (bLoading > 0) {
			return;
		}

		var strWriteURL = "";
		strWriteURL = elDIV.getAttribute("data-htmldb-write-url");

		if ("" == strWriteURL) {
			return;
		}

		var iframeFormGUID = document.getElementById(p1 + "_iframe_container").children.length;
		HTMLDB.__createNewIframeAndForm(p1, iframeFormGUID);

		var strTarget = (p1 + "_iframe_" + iframeFormGUID);
		if (!document.getElementById(strTarget)) {
			return;
		}

		var tbodyHTMLDB = document.getElementById(p1 + "_reader_tbody");
		var arrTR = tbodyHTMLDB.children;
		var arrTD = null;
		var elTR = null;
		var lTRCount = arrTR.length;
		var formHTMLDB = document.getElementById(p1 + "_form_" + iframeFormGUID);
		var iframeHTMLDB = document.getElementById(strTarget);
		var iframeNewElement = iframeHTMLDB.cloneNode(true);
		iframeHTMLDB.parentNode.replaceChild(iframeNewElement, iframeHTMLDB);
		iframeHTMLDB = iframeNewElement;

		elDIV.setAttribute("data-htmldb-loading", 1);

		var funcIframeLoadCallback = HTMLDB.__doWriterIframeLoad;

		if (functionDone) {
			funcIframeLoadCallback = function () {
				elDIV.setAttribute("data-htmldb-loading", 0);
				iframeWindow = top.frames[p1 + "_iframe_" + iframeFormGUID];
				var strResponse = "";
				if (iframeWindow.document) {
					strResponse = String(iframeWindow.document.body.innerHTML).trim();
				}
				HTMLDB.__removeIframeAndForm(p1, iframeFormGUID);
				functionDone(p1, strResponse);
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
	        	HTMLDB.__generateFormHTML(elDIV, iframeFormGUID, elTR);
	        	
	        	if (!functionDone) {
	        		elTR.parentNode.removeChild(elTR);
	        		lCurrentTRIndex--;
	        	}
        	}
        }

        formHTMLDB.action = strWriteURL;

        try {
			formHTMLDB.submit();
		} catch(e) {
		}
	},
	"get":function(p1, p2) {
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
					+ HTMLDB.__ejs(elTD.innerHTML)
					+ "\"";
		}
		strJSON = "{" + strJSON + "}";

		return JSON.parse(strJSON);
	},
	"insert":function(p1, p2, p3) {
		var elDIV = document.getElementById(p1);
		if (!elDIV) {
			return;
		}

		if (undefined === p3) {
			p3 = "";
		}

		var tbodyHTMLDB = document.getElementById(p1 + "_reader_tbody");
		var lTRCount = tbodyHTMLDB.children.length;

		var strTRContent = "<tr class=\"inserted"
				+ ((p3!="") ? (" " + p3) : "")
				+ "\" data-row-id=\"n"
				+ lTRCount
				+ "\" id=\""
				+ elDIV.id
				+"_trn"
				+ lTRCount
				+"\">";
		strTRContent += HTMLDB.__generateTDHTML(elDIV, "_writer", p2, ("n" + lTRCount));
    	strTRContent += "</tr>";

    	tbodyHTMLDB.innerHTML += strTRContent;
	},
	"update":function(p1, p2, p3, p4) {
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

		var tbodyHTMLDB = document.getElementById(p1 + "_reader_tbody");
		strTRContent = HTMLDB.__generateTDHTML(elDIV, "_writer", p3, p2);

		elTR.innerHTML = strTRContent;
		if (-1 == elTR.className.indexOf("inserted")) {
			elTR.className = "updated" + ((p4!="") ? (" " + p4) : "");
		}
	},
	"delete":function(p1, p2, p3) {
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
	"render":function(tableElement, functionDone) {
		HTMLDB.__renderTemplates(tableElement);
		HTMLDB.__renderSections(tableElement);
		HTMLDB.__renderForms(tableElement);

		if (functionDone) {
			functionDone();
		} else if (tableElement.doHTMLDBRender) {
			tableElement.doHTMLDBRender(tableElement);
		}
	},
	"__renderTemplates": function (tableElement) {
		var rows = document.getElementById(tableElement.id + "_reader_tbody").children;
        var templateElements = document.body.querySelectorAll(".htmldb-template");
        var templateElementCount = templateElements.length;
        var templateElement = null;

		for (var i = 0; i < templateElementCount; i++) {
			templateElement = templateElements[i];
			if (tableElement.id
					!= HTMLDB.__getHTMLDBParameter(templateElement, "table")) {
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
	"__renderSections": function (tableElement) {
        var sections = document.body.querySelectorAll(".htmldb-section");
        var sectionCount = sections.length;
        var section = null;
        for (var i = 0; i < sectionCount; i++) {
            section = sections[i];
            if (HTMLDB.__getHTMLDBParameter(section, "table") == tableElement.id) {
            	HTMLDB.__renderSectionElement(section);
            }
        }
	},
	"__renderForms": function (tableElement) {
        var forms = document.body.querySelectorAll(".htmldb-form");
        var formCount = forms.length;
        var form = null;
        for (var i = 0; i < formCount; i++) {
            form = forms[i];
            if (HTMLDB.__getHTMLDBParameter(form, "table") == tableElement.id) {
            	HTMLDB.__renderFormElement(form);
            }
        }
        HTMLDB.__initializeHTMLDBEditButtons(tableElement);
	},
	"getColumnNames":function(p1, p2) {
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
	"getTableFieldActiveValue":function(tableElementId, column) {
		var tableElement = document.getElementById(tableElementId);

		if (!tableElement) {
        	throw(new Error("HTMLDB table "
        			+ tableElementId
        			+ " is referenced, but not found."));
			return false;
		}
		var activeId = parseInt(HTMLDB.__getHTMLDBParameter(tableElement, "active-id"));

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
	"setActiveId":function(tableElement, id) {
		tableElement.setAttribute("data-htmldb-active-id", id);
		HTMLDB.render(tableElement);
	},
	"__initializeHTMLDBTables": function() {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        var priority = 0;

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	HTMLDB.__validateHTMLDBTableDefinition(tableElement);
        	HTMLDB.__createHelperElements(tableElement);
        	tableElement.style.display = "none";
        	tableElement.setAttribute("data-htmldb-loading", 0);
        	priority = parseInt(HTMLDB.__getHTMLDBParameter(tableElement, "priority"));
        	if (isNaN(priority)) {
        		priority = 0;
        		tableElement.setAttribute("data-htmldb-priority", priority);
        	}
        }

        var parents = HTMLDB.__extractParentTables();

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];

        	if (0 == parents[tableElement.id]) {
        		continue;
        	}

        	if (HTMLDB.__getHTMLDBParameter(tableElement, "priority")
        			> HTMLDB.__getMaxPriority(parents[tableElement.id])) {
        		continue;
        	}

        	priority = HTMLDB.__getMaxPriority(parents[tableElement.id]) + 1;
        	tableElement.setAttribute("data-htmldb-priority", priority);
        }
	},
	"__initializeHTMLDBTemplates": function() {
        var templateElements = document.body.querySelectorAll(".htmldb-template");
        var templateElementCount = templateElements.length;
        var templateElement = null;
        var tableElementId = "";
        var targetElementId = "";
		var functionBody = "";

        for (var i = 0; i < templateElementCount; i++) {
        	templateElement = templateElements[i];
        	templateElement.HTMLDBGUID = HTMLDB.__generateGUID();
        	HTMLDB.__validateHTMLDBTemplateDefinition(templateElement);
        	tableElementId = HTMLDB.__getHTMLDBParameter(templateElement, "table");
        	targetElementId = HTMLDB.__getHTMLDBParameter(templateElement, "template-target");
			functionBody = HTMLDB.__generateTemplateRenderFunctionString(
					templateElement,
					tableElementId,
					targetElementId);
			templateElement.renderFunction = new Function("tableElement", "rows", functionBody);
        }
	},
	"__initializeHTMLDBButtons": function() {
		HTMLDB.__initializeHTMLDBRefreshButtons();
		HTMLDB.__initializeHTMLDBAddButtons();
		HTMLDB.__initializeHTMLDBSaveButtons();
	},
	"__resetForm": function (form) {
		var elements = form.elements;
		var elementCount = elements.length;
		var fieldType = "";
		form.reset();
		for(var i = 0; i < elementCount; i++) {
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
			if (HTMLDB.__hasHTMLDBParameter(elements[i], "reset-value")) {
				HTMLDB.__setInputValue(elements[i],
						HTMLDB.__getHTMLDBParameter(elements[i], "reset-value"));
			}
		}
	},
	"__initializeHTMLDBSections": function() {
        var sections = document.body.querySelectorAll(".htmldb-section");
        var sectionCount = sections.length;
        for (var i = 0; i < sectionCount; i++) {
            HTMLDB.__storeSectionElementTemplates(sections[i]);
        }
	},
    "__storeSectionElementTemplates": function(element) {
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
            HTMLDB.__storeSectionElementTemplates(children);
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
	"__initializeHTMLDBForms": function() {

	},
    "__renderSectionElement": function(element) {
        if (!element) {
            return false;
        }

        var tableElement = HTMLDB.__exploreHTMLDBTable(element);

        if ((element.HTMLDBInitials !== undefined)
        		&& (element.HTMLDBInitials.attributes !== undefined)) {
            var attributeCount = element.HTMLDBInitials.attributes.length;
            var attributeName = "";
            var attributeValue = "";
            var content = "";
            for (var i = 0; i < attributeCount; i++) {
                attributeName = element.HTMLDBInitials.attributes[i].name;
                attributeValue = element.HTMLDBInitials.attributes[i].value;
                content = HTMLDB.__evaluateHTMLDBExpression(attributeValue, tableElement.id);
                element.setAttribute(attributeName, content);
            }
        }

        var childrenCount = element.children.length;
        var children = null;

        for (var i = 0; i < childrenCount; i++) {
            children = element.children[i];
            HTMLDB.__renderSectionElement(children);
        }

        if (0 == childrenCount) {
            if ((element.HTMLDBInitials !== undefined)
            		&& (element.HTMLDBInitials.content !== undefined)) {
                content = HTMLDB.__evaluateHTMLDBExpression(element.HTMLDBInitials.content, tableElement.id);
                element.innerHTML = content;
            } else {
            	if (HTMLDB.__hasHTMLDBParameter(element, "content")) {
            		element.innerHTML = HTMLDB.__getHTMLDBParameter(element, "content");
            	}
            }
        }
    },
    "__renderFormElement": function(form) {
    	var inputs = form.querySelectorAll(".htmldb-field");
    	var inputCount = inputs.length;
    	var input = null;
    	var valueTemplate = "";
    	var tableElement = HTMLDB.__exploreHTMLDBTable(form);
    	for (var i = 0; i < inputCount; i++) {
    		input = inputs[i];
    		valueTemplate = HTMLDB.__getHTMLDBParameter(input, "value");
			HTMLDB.__setInputValue(input,
					HTMLDB.__evaluateHTMLDBExpression(valueTemplate, tableElement.id));
    	}
    },
	"__initializeHTMLDBRefreshButtons": function () {
        var buttonElements = document.body.querySelectorAll(".htmldb-button-refresh");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener("click", HTMLDB.__doRefreshButtonClick, true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent("onclick", HTMLDB.__doRefreshButtonClick);
	        }
	    }
	},
	"__initializeHTMLDBAddButtons": function () {
        var buttonElements = document.body.querySelectorAll(".htmldb-button-add");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener("click", HTMLDB.__doAddButtonClick, true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent("onclick", HTMLDB.__doAddButtonClick);
	        }
	    }
	},
	"__initializeHTMLDBSaveButtons": function () {
        var buttonElements = document.body.querySelectorAll(".htmldb-button-save");
        var buttonElementCount = buttonElements.length;
        var buttonElement = null;

        for (var i = 0; i < buttonElementCount; i++) {
        	buttonElement = buttonElements[i];
			if (buttonElement.addEventListener) {
				buttonElement.addEventListener("click", HTMLDB.__doSaveButtonClick, true);
			} else if (buttonElement.attachEvent) {
	            buttonElement.attachEvent("onclick", HTMLDB.__doSaveButtonClick);
	        }
	    }
	},
	"__initializeHTMLDBEditButtons": function(tableElement) {
        var buttons = document.body.querySelectorAll(".htmldb-button-edit");
        var buttonCount = buttons.length;
        var button = null;

        for (var i = 0; i < buttonCount; i++) {
        	button = buttons[i];
            if (HTMLDB.__getHTMLDBParameter(button, "table") == tableElement.id) {
				if (button.addEventListener) {
					button.addEventListener("click", HTMLDB.__doEditButtonClick, true);
				} else if (button.attachEvent) {
		            button.attachEvent("onclick", HTMLDB.__doEditButtonClick);
		        }
            }
	    }
	},
	"__initializeReadQueue": function() {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
       	var priorities = [];
       	var priority = 0;

        HTMLDB.__readQueue = [];

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	priority = parseInt(HTMLDB.__getHTMLDBParameter(tableElement, "priority"));
        	if (undefined === priorities[priority]) {
			    priorities[priority] = [];
        	}
        }

		priorities.sort();

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	priority = parseInt(HTMLDB.__getHTMLDBParameter(tableElement, "priority"));
        	priorities[priority][priorities[priority].length] = tableElement.id;
        }

        HTMLDB.__readQueue = priorities;
        HTMLDB.__processReadQueue();
	},
	"__readChildTable": function (tableElementId, functionDone) {
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

		var parentTableId = HTMLDB.__getHTMLDBParameter(tableElement, "table");

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

		functionBody = HTMLDB.__generateChildTableFilterFunctionString(tableElement);

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
			id = HTMLDB.__getHTMLDBParameter(row, "data-row-id");
			object = HTMLDB.__convertRowToObject(parentTableId, row);
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
			content += HTMLDB.__generateTDHTML(tableElement, "_reader", object, id);
			content += "</tr>";

			if (0 == activeId) {
				activeId = id;
			}
		}

		document.getElementById(tableElementId + "_reader_tbody").innerHTML = content;
		tableElement.setAttribute("data-htmldb-active-id", activeId);
		HTMLDB.render(tableElement);
	},
	"__convertRowToObject": function(tableElementId, row) {
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
	"__getMaxPriority": function (tableIds) {
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
			priority = parseInt(HTMLDB.__getHTMLDBParameter(tableElement, "priority"));
			if (priority > maxPriority) {
				maxPriority = priority;
			}
		}
		return maxPriority;
	},
	"__processReadQueue": function() {
		if (undefined === HTMLDB.__readQueue) {
			return;
		}

		if (0 == HTMLDB.__readQueue.length) {
			return;
		}

		HTMLDB.__readingQueue = HTMLDB.__readQueue.shift();
		readingQueueCount = HTMLDB.__readingQueue.length;
		tableElementId = "";

		for (var i = 0; i < readingQueueCount; i++) {
			tableElementId = HTMLDB.__readingQueue[i];
			HTMLDB.read(tableElementId);
		}
	},
	"__removeFromReadingQueue": function (tableElementId) {
		var index = HTMLDB.__readingQueue.indexOf(tableElementId);
		if (index > -1) {
			HTMLDB.__readingQueue.splice(index, 1);
		}
	},
	"__extractParentTables": function () {
        var tableElements = document.body.querySelectorAll(".htmldb-table");
        var tableElementCount = tableElements.length;
        var tableElement = null;
        var parents = [];
        var parentTable = "";
        var expressionTables = "";

        for (var i = 0; i < tableElementCount; i++) {
        	tableElement = tableElements[i];
        	parents[tableElement.id] = [];
        	parentTable = HTMLDB.__getHTMLDBParameter(tableElement, "table");

        	if (parentTable) {
        		parents[tableElement.id]
        				= parents[tableElement.id].concat(Array(parentTable));
        	}

        	expressionTables = HTMLDB.__extractHTMLDBExpressionTables(
        			HTMLDB.__getHTMLDBParameter(
        			tableElement,
        			"read-url"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.id]
        				= parents[tableElement.id].concat(expressionTables);
        	}

        	expressionTables = HTMLDB.__extractHTMLDBExpressionTables(
        			HTMLDB.__getHTMLDBParameter(
        			tableElement,
        			"write-url"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.id]
        				= parents[tableElement.id].concat(expressionTables);
        	}

        	expressionTables = HTMLDB.__extractHTMLDBExpressionTables(
        			HTMLDB.__getHTMLDBParameter(
        			tableElement,
        			"validate-url"));
        	if (expressionTables.length > 0) {
        		parents[tableElement.id]
        				= parents[tableElement.id].concat(expressionTables);
        	}
        }

        return parents;
	},
	"__extractChildTables": function () {
	},
	"__extractHTMLDBExpressionTables": function (expression) {
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

			if (foreignTableId != "") {
				tables.push(foreignTableId);
			}
		}

		return tables;
	},
	"__getHTMLDBParameter": function (element, parameter) {
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
	"__hasHTMLDBParameter": function (element, parameter) {
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
	"__validateHTMLDBTableDefinition": function (element) {
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
	"__validateHTMLDBTemplateDefinition": function (element) {
		var tableElementId = HTMLDB.__getHTMLDBParameter(element, "table");
		var targetElementId = HTMLDB.__getHTMLDBParameter(element, "template-target");

    	if (!document.getElementById(tableElementId)) {
        	throw(new Error(tableElementId + " HTMLDB table not found."));
    		return;
    	}

    	if (!document.getElementById(targetElementId)) {
        	throw(new Error("Template target element " + targetElementId + " not found."));
    		return;
    	}
	},
	"__createHelperElements": function (element) {
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
	"__isLetter":function(text) {
		if (undefined == text) {
			return false;
		} else {
  			return ((text.length === 1) && text.match(/[a-z_]/i));
  		}
	},
	"__isNumeric":function(text) {
  		if (undefined == text) {
  			return false;
  		} else {
  			return ((text.length === 1) && text.match(/[0-9]/));
  		}
	},
	"__as":function(text) {
		return (text + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
	},
	"__generateTemplateRenderFunctionString": function(templateElement, tableElementId, targetElementId) {
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
			functionBody += "+\"" + HTMLDB.__as((String(text).trim())) + "\"";
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

			functionBody += "+\"" + HTMLDB.__as((String(text).trim())) + "\"";
		}

		functionBody += ";}"
				+ "document.getElementById(\""
				+ targetElementId
				+ "\").innerHTML=generatedCode"
				+ templateElement.HTMLDBGUID
				+ ";";

		return (functionHeader + functionBody);
	},
	"__generateChildTableFilterFunctionString": function(tableElement) {
		var filter = HTMLDB.__getHTMLDBParameter(tableElement, "filter");
		var tokens = String(filter).split("/");
		var tokenCount = tokens.length;
		var functionBody = "";
		var index = 0;
		var property = "";
		var operator = "";
		var constant = "";
		var andor = "||";
		var invalidErrorText = "HTMLDB table " + tableElement.id + " has invalid filter attribute.";

		functionBody = "success=false;";

		if (filter != "") {
			while (index < tokenCount) {

				property = HTMLDB.__evaluateHTMLDBExpression(tokens[index]);

				functionBody += "if(undefined===object[\"" + property + "\"]){"
						+ "throw(new Error(\"HTMLDB table "
						+ tableElement.id
						+ " has unknown filter field:"
						+ property
						+ "\"));return;}";
				functionBody += ("success=success" + andor + "(object[\"" + property + "\"]");

				index++;
				if (index >= tokenCount) {
		        	throw(new Error(invalidErrorText));
		    		return;
				}

				operator = String(tokens[index]).toLowerCase();

				switch (operator) {
					case "eq":
						functionBody += "==";
					break;
					case "neq":
						functionBody += "!=";
					break;
					case "gt":
						functionBody += ">";
					break;
					case "gte":
						functionBody += ">=";
					break;
					case "lt":
						functionBody += "<";
					break;
					case "lte":
						functionBody += "<=";
					break;
					default:
		        		throw(new Error("HTMLDB table "
		        				+ tableElement.id
		        				+ " has invalid filter operator:" + operator));
		    			return;
					break;
				}

				index++;
				if (index >= tokenCount) {
		        	throw(new Error(invalidErrorText));
		    		return;
				}

				constant = HTMLDB.__evaluateHTMLDBExpression(tokens[index]);

				functionBody += constant + ");";

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
		} else {
			functionBody += "success=true;";
		}

		functionBody += "return success;"
		return functionBody;
	},
	"__ss":function(p1) {
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
	"__ejs":function(p1) {
		return p1.replace(/\n/g, "\\n")
				.replace(/\"/g, '&quot;')
				.replace(/\r/g, "\\r")
				.replace(/\t/g, "\\t")
				.replace(/\f/g, "\\f")
				.replace(/\f/g, "\\f")
				.replace(/\\/g, "\\");
	},
	"__createNewIframeAndForm":function(htmldbId, guid) {
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
	"__removeIframeAndForm":function(htmldbId, guid) {
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
	"__generateTDHTML":function(tableElement, prefix, object, id) {
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
	"__generateFormHTML":function(tableElement, iframeFormGUID, row) {
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

		index = form.getElementsByClassName("inputaction").length;

		var formContent = "<input class=\"inputaction\" type=\"hidden\" name=\""
				+ "inputaction" + index
				+ "\" value=\""
				+ inputAction
				+ "\" />";

		var columns = HTMLDB.getColumnNames(tableElement.id, false);
		var columnCount = columns.length;
		var rowId = row.getAttribute("data-row-id");
		var prefix = (tableElement.id + "_td" + rowId);
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

			formContent += "<input class=\"inputfield\" type=\"hidden\" name=\""
					+ "inputfield" + index + columns[i]
 					+ "\" value=\""
					+ HTMLDB.__ejs(value)
					+ "\" />";
		}

		form.innerHTML += formContent;
	},
    "__generateGUID": function(prefix) {
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
    "__evaluateHTMLDBExpression": function(expression, tableElementId) {
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

			if (foreignTableId != "") {
				value = HTMLDB.getTableFieldActiveValue(foreignTableId, column);
			} else {
				value = ("{{" + content);
			}

			text = String(content).substr(position + 2);
			text = String(text).replace(/(?:\r\n|\r|\n)/g, "");

			content = value + HTMLDB.__as((String(text).trim()));

			tokens[i] = content;
		}

		if (tokens.length > 1) {
			returnValue = tokens.join("");
		}

		return returnValue;
    },
    "__exploreHTMLDBTable": function(element) {
    	var exit = false;
    	var parent = HTMLDB.__getHTMLDBParameter(element, "table");
    	while (!exit && ("" == parent)) {
    		element = element.parentNode;
    		parent = HTMLDB.__getHTMLDBParameter(element, "table");
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
    "__exploreHTMLDBForm": function(element) {
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
	"__doReaderIframeLoad":function(p1) {
		HTMLDB.__doirlc(p1, false);
		HTMLDB.render(p1.target.parentNode.parentNode);
	},
	"__doRefreshButtonClick":function() {
		HTMLDB.__initializeReadQueue();
	},
	"__doAddButtonClick": function(event) {
		var formElement = document.getElementById(HTMLDB.__getHTMLDBParameter(event.target, "form"));
		if (!formElement) {
        	throw(new Error("Add button HTMLDB form not found."));
			return false;
		}
		HTMLDB.__resetForm(formElement);
	},
	"__doSaveButtonClick":function(event) {
		var formId = HTMLDB.__getHTMLDBParameter(event.target, "form");
		var form = null;

		if (formId != "") {
			form = document.getElementById(formId);
			if (!form) {
	        	throw(new Error("Save button HTMLDB form not found."));
				return false;
			}
		} else {
			form = HTMLDB.__exploreHTMLDBForm(event.target);			
		}

		var tableElementId = HTMLDB.__getHTMLDBParameter(form, "table");

		if (!document.getElementById(tableElementId)) {
	        throw(new Error(formId + " form HTMLDB table not found."));
			return false;			
		}

		var elements = form.querySelectorAll(".htmldb-field");
		var elementCount = elements.length;
		var element = null;
		var object = {};

		for (var i = 0; i < elementCount; i++) {
			element = elements[i];
			object[element.getAttribute("data-htmldb-field")]
					= HTMLDB.__getInputValue(element);
		}

		HTMLDB.validate(tableElementId, object, function (DIVId, response) {
			var responseObject = JSON.parse(String(response).trim());
			if (responseObject.errorCount > 0) {
				HTMLDB.__showError(tableElementId, responseObject.lastError);
			} else {
				HTMLDB.insert(tableElementId + "_writer", object);
			}
		});
	},
	"__showError":function(tableElementId, errorText) {
		var containers = document.body.querySelectorAll(".htmldb-error");
		var containerCount = containers.length;
		var container = null;
		for (var i = 0; i < containerCount; i++) {
			container = containers[i];
			if (HTMLDB.__getHTMLDBParameter(container, "table") == tableElementId) {
				container.innerHTML = errorText;
			}
		}
	},
	"__doEditButtonClick":function(event) {
		var tableElement = document.getElementById(HTMLDB.__getHTMLDBParameter(event.target, "table"));

		if (!tableElement) {
        	throw(new Error("Edit button HTMLDB table not found."));
			return false;
		}

		HTMLDB.setActiveId(
				tableElement,
				HTMLDB.__getHTMLDBParameter(event.target, "edit-id"));
	},
	"__doWriterIframeLoad":function(p1) {
		elDIV = p1.target.parentNode.parentNode;
		elDIV.setAttribute("data-htmldb-loading", 0);
		iframeWindow = top.frames[p1.target.id];
		var strResponse = "";
		if (iframeWindow.document) {
			strResponse = String(iframeWindow.document.body.innerHTML).trim();
		}

		var iframeFormDefaultName = (elDIV.id + "_iframe_");
		var iframeFormGUID = p1.target.id.substr(iframeFormDefaultName.length);
		HTMLDB.__removeIframeAndForm(elDIV.id, iframeFormGUID);

		if (elDIV.doHTMLDBWrite) {
			elDIV.doHTMLDBWrite(elDIV, strResponse);
		}
	},
	"__doValidatorIframeLoad":function(p1) {
		elDIV = p1.target.parentNode.parentNode;
		elDIV.setAttribute("data-htmldb-loading", 0);
		iframeWindow = top.frames[p1.target.id];
		var strResponse = "";
		if (iframeWindow.document) {
			strResponse = String(iframeWindow.document.body.innerHTML).trim();
		}

		var iframeFormDefaultName = (elDIV.id + "_iframe_");
		var iframeFormGUID = iframeHTMLDB.id.substr(iframeFormDefaultName.length);
		HTMLDB.__removeIframeAndForm(elDIV.id, iframeFormGUID);

		if (elDIV.doHTMLDBValidate) {
			elDIV.doHTMLDBValidate(p1, strResponse);
		}
	},
	"__getInputValue":function(input) {
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
	"__setInputValue": function(input, value) {
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
	"__doirlc":function(p1, p2) {
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
		HTMLDB.__removeIframeAndForm(elDIV.id, iframeFormGUID);

		if ((p2 === false) && elDIV.doHTMLDBRead) {
			elDIV.doHTMLDBRead(elDIV);
		} else if ((p2 === true) && elDIV.doHTMLDBReadAll) {
			elDIV.doHTMLDBReadAll(elDIV);
		}

		elDIV.setAttribute("data-htmldb-loading", 0);

		setTimeout(function () {
			HTMLDB.__removeFromReadingQueue(elDIV.id);
			HTMLDB.__processReadQueue();
		}, 150);
	}
}
HTMLDB.initialize();