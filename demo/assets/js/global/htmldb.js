var HTMLDB={
	"initialize":function(p1) {
		var elDIV = document.getElementById(p1.elementID);
		if (!elDIV) {
			return;
		}

		elDIV.style.display="none";
		var strClassName = p1.elementID;
		var strTableHTML = "<table id=\""
				+ strClassName
				+ "_table\">"
				+ "<thead id=\""
				+ strClassName
				+ "_thead\"></thead>"
				+ "<tbody id=\""
				+ strClassName
				+ "_tbody\"></tbody></table>";
		var strIframeHTML = "<div id=\""
				+ strClassName
				+ "_iframe_container\"></div>";
		var strFormHTML = "<div id=\""
				+ strClassName
				+ "_form_container\"></div>";

		elDIV.innerHTML = strTableHTML + strIframeHTML + strFormHTML;
		if (p1.onRead) {
			elDIV.doHTMLDBRead=p1.onRead;
		}
		if (p1.onReadAll) {
			elDIV.doHTMLDBReadAll=p1.onReadAll;
		}
		if (p1.onWrite) {
			elDIV.doHTMLDBWrite=p1.onWrite;
		}
		if (p1.onValidate) {
			elDIV.doHTMLDBValidate=p1.onValidate;
		}
		if (p1.onRender) {
			elDIV.doHTMLDBRender=p1.onRender;
		}
		if (p1.onRenderAll) {
			elDIV.doHTMLDBRenderAll=p1.onRenderAll;
		}
		if (!p1.autoRefresh) {
			p1.autoRefresh = 0;
		} 
		if (!p1.startupDelay) {
			p1.startupDelay = 0;
		} 
		if (!p1.renderElements) {
			p1.renderElements = new Array();
		}
		if (!p1.readURL) {
			p1.readURL = "";
		}
		if (!p1.readAllURL) {
			p1.readAllURL = "";
		}
		if (!p1.writeURL) {
			p1.writeURL = "";
		}
		if (!p1.validateURL) {
			p1.validateURL = "";
		}
		if (!p1.CSVSeparator) {
			p1.CSVSeparator = ",";
		}
		if (!p1.writeDelay) {
			p1.writeDelay = 2000;
		}

		lRenderElementCount = p1.renderElements.length;
		var objRenderElement = null;
		var strRenderElementTemplateIDs = "";
		var strRenderElementTargetIDs = "";
		for (var i = 0; i < lRenderElementCount; i++) {
			objRenderElement = p1.renderElements[i];

			if (!objRenderElement.templateElementID
					|| !objRenderElement.targetElementID) {
				continue;
			}

			if (!objRenderElement.lookupElementIDs) {
				objRenderElement.lookupElementIDs = "";
			}

			if (strRenderElementTemplateIDs != "") {
				strRenderElementTemplateIDs += ",";
				strRenderElementTargetIDs += ",";
			}

			strRenderElementTemplateIDs += objRenderElement.templateElementID;
			strRenderElementTargetIDs += objRenderElement.targetElementID;
		}

		elDIV.setAttribute("data-template-element-id-csv", strRenderElementTemplateIDs);
		elDIV.setAttribute("data-target-element-id-csv", strRenderElementTargetIDs);
		elDIV.setAttribute("data-htmldb-read-all-url", p1.readAllURL);
		elDIV.setAttribute("data-htmldb-read-url", p1.readURL);
		elDIV.setAttribute("data-htmldb-write-url", p1.writeURL);
		elDIV.setAttribute("data-htmldb-validate-url", p1.validateURL);
		elDIV.setAttribute("data-auto-refresh", p1.autoRefresh);
		elDIV.setAttribute("data-startup-delay", p1.startupDelay);
		elDIV.setAttribute("data-csv-separator", p1.CSVSeparator);
		elDIV.setAttribute("data-write-delay", p1.writeDelay);
		elDIV.setAttribute("data-loading", 0);

		HTMLDB.__grf(elDIV.id);

		if (p1.startupDelay > 0) {
			elDIV.tmTimer = setTimeout(function() {
				HTMLDB.read(p1.elementID, true);
			}, (p1.startupDelay));
		} else {
			HTMLDB.read(p1.elementID, true);			
		}
	},
	"stop":function(p1) {
		var elDIV = document.getElementById(p1);
		if (!elDIV) {
			return;
		}

		elDIV.setAttribute("data-loading", 0);
	},
	"read":function(p1, p2, functionDone) {
		var elDIV = document.getElementById(p1);
		if (!elDIV) {
			return;
		}

		var bLoading = parseInt(elDIV.getAttribute("data-loading"));

		if (bLoading > 0) {
			return;
		}

		var tbodyHTMLDB = document.getElementById(p1 + "_tbody");

		var iframeFormGUID = document.getElementById(p1 + "_iframe_container").children.length;
		HTMLDB.__createNewIframeAndForm(p1, iframeFormGUID);

		var strTarget = (p1 + "_iframe_" + iframeFormGUID);
		var strReadURL = "";
		if (p2) {
			strReadURL = elDIV.getAttribute("data-htmldb-read-all-url");
		} else {
			strReadURL = elDIV.getAttribute("data-htmldb-read-url");
		}

		if ("" == strReadURL) {
			return;
		}
		
		if (!document.getElementById(strTarget)) {
			return;
		}
		var iframeHTMLDB = document.getElementById(strTarget);
		var iframeNewElement = iframeHTMLDB.cloneNode(true);
		iframeHTMLDB.parentNode.replaceChild(iframeNewElement, iframeHTMLDB);
		iframeHTMLDB = iframeNewElement;
		elDIV.setAttribute("data-loading", 1);

		var funcIframeLoadCallback = (p2)
				? HTMLDB.__doiral
				: HTMLDB.__doirl;

		if (functionDone) {
			funcIframeLoadCallback = function (evEvent) {
				elDIV.setAttribute("data-loading", 0);
				HTMLDB.__doirlc(evEvent, true);
				HTMLDB.__removeIframeAndForm(p1, iframeFormGUID);
				functionDone(p1);
			}
		}

		if (iframeHTMLDB.addEventListener) {
			iframeHTMLDB.addEventListener("load", funcIframeLoadCallback, true);
		} else if (iframeHTMLDB.attachEvent) {
            iframeHTMLDB.attachEvent("onload", funcIframeLoadCallback);
        }

        try {
			var dtNow = new Date();
			iframeHTMLDB.src = strReadURL
					+ ("/nocache=" + dtNow.getTime());
		} catch(e) {
		}
	},
	"validate":function(p1, p2, functionDone) {
		var elDIV = document.getElementById(p1);
		if (!elDIV) {
			return false;
		}

		if (p2.id == undefined) {
			return false;
		}

		var bLoading = parseInt(elDIV.getAttribute("data-loading"));

		if (bLoading > 0) {
			return false;
		}

		var strValidateURL = "";
		strValidateURL = elDIV.getAttribute("data-htmldb-validate-url");

		if ("" == strValidateURL) {
			return false;
		}

		var iframeFormGUID = document.getElementById(p1 + "_iframe_container").children.length;
		HTMLDB.__createNewIframeAndForm(p1, iframeFormGUID);

		var strTarget = (p1 + "_iframe_" + iframeFormGUID);
		if (!document.getElementById(strTarget)) {
			return false;
		}

		var formHTMLDB = document.getElementById(p1 + "_form_" + iframeFormGUID);
		var iframeHTMLDB = document.getElementById(strTarget);
		var iframeNewElement = iframeHTMLDB.cloneNode(true);
		iframeHTMLDB.parentNode.replaceChild(iframeNewElement, iframeHTMLDB);
		iframeHTMLDB = iframeNewElement;

		elDIV.setAttribute("data-loading", 1);

		var funcIframeLoadCallback = HTMLDB.__doivl;

		if (functionDone) {
			funcIframeLoadCallback = function () {
				elDIV.setAttribute("data-loading", 0);
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

		var strFormContent = "<input class=\"inputaction\" type=\"hidden\" name=\""
				+ "inputaction0"
				+ "\" value=\""
				+ ((0 == p2.id) ? "inserted" : "updated")
				+ "\" />";

		var strPropertyName = "";

		for (var strPropertyName in p2) {
        	if (p2.hasOwnProperty(strPropertyName)) {
				strFormContent += "<input class=\"inputfield\" type=\"hidden\" name=\""
						+ "inputfield0" + strPropertyName
				 		+ "\" value=\""
						+ p2[strPropertyName]
						+ "\" />";
        	}
    	}

		formHTMLDB.innerHTML = strFormContent;
        formHTMLDB.action = strValidateURL;

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

		var bLoading = parseInt(elDIV.getAttribute("data-loading"));

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

		var tbodyHTMLDB = document.getElementById(p1 + "_tbody");
		var arrTR = tbodyHTMLDB.children;
		var arrTD = null;
		var elTR = null;
		var lTRCount = arrTR.length;
		var formHTMLDB = document.getElementById(p1 + "_form_" + iframeFormGUID);
		var iframeHTMLDB = document.getElementById(strTarget);
		var iframeNewElement = iframeHTMLDB.cloneNode(true);
		iframeHTMLDB.parentNode.replaceChild(iframeNewElement, iframeHTMLDB);
		iframeHTMLDB = iframeNewElement;

		elDIV.setAttribute("data-loading", 1);

		var funcIframeLoadCallback = HTMLDB.__doiwl;

		if (functionDone) {
			funcIframeLoadCallback = function () {
				elDIV.setAttribute("data-loading", 0);
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
	        	HTMLDB.__gfih(elDIV, iframeFormGUID, elTR);
	        	
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
			elTD = document.getElementById(p1 + "_td" + p2 + arrColumns[i]);

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

		var tbodyHTMLDB = document.getElementById(p1 + "_tbody");
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
		strTRContent += HTMLDB.__gtdc(elDIV, p2, ("n" + lTRCount));
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

		var elTR = document.getElementById(p1 + "_tr" + p2);

		if (!elTR) {
			return;
		}

		var tbodyHTMLDB = document.getElementById(p1 + "_tbody");
		strTRContent = HTMLDB.__gtdc(elDIV, p3, p2);

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

		var trDeleted = document.getElementById(p1 + "_tr" + p2);
		if (trDeleted) {
			trDeleted.className = "deleted" + ((p3!="") ? (" " + p3) : "");
		}
	},
	"render":function(p1, functionDone) {
		var elDIV = document.getElementById(p1);
		var arrAllTR = document.getElementById(p1 + "_tbody").children;
		var lTRCount = arrAllTR.length;
		var arrNewTR = new Array();
		var elTR = null;

		for (var i = 0; i < lTRCount; i++) {
			elTR = arrAllTR[i];
			if ("refreshed"==elTR.className) {
				arrNewTR.push(elTR);
			}
		}

		if (elDIV.renderFunction) {
			elDIV.renderFunction(arrNewTR);
		}

		if (functionDone) {
			functionDone();
		} else if (elDIV.doHTMLDBRender) {
			elDIV.doHTMLDBRender(elDIV);
		}
	},
	"renderAll":function(p1, functionDone) {
		var elDIV = document.getElementById(p1);
		var tbodyHTMLDB = document.getElementById(p1 + "_tbody");
		var arrTR = tbodyHTMLDB.children;
		var lTRCount = arrTR.length;

		if (elDIV.renderFunction) {
			elDIV.renderFunction(arrTR);
		}

		if (functionDone) {
			functionDone();
		} else if (elDIV.doHTMLDBRenderAll) {
			elDIV.doHTMLDBRenderAll(elDIV);
		}
	},
	"getColumnNames":function(p1, p2) {
		var elTHead = document.getElementById(p1 + "_thead");
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
	"__doirlc":function(p1, p2) {
		var iframeHTMLDB = p1.target;
		var elDIV = iframeHTMLDB.parentNode.parentNode;
		var strHTMLDBDIVID = iframeHTMLDB.parentNode.parentNode.id;
		var tbodyHTMLDB = document.getElementById(strHTMLDBDIVID + "_tbody");
		var theadHTMLDB = document.getElementById(strHTMLDBDIVID + "_thead");
		elDIV.setAttribute("data-loading", 0);
		iframeWindow = top.frames[iframeHTMLDB.id];
		var strGZResponse = "";
		if (iframeWindow.document) {
			strGZResponse = String(iframeWindow.document.body.innerHTML).trim();
		}

		if (strGZResponse != "") {
			try {
				strResponse = (JXG.decompress(strGZResponse));
				strResponse = (decodeURIComponent(escape(strResponse)));
			} catch(e) {}

			var arrList = JSON.parse(strResponse);
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

			for (var i = 0; i < lRowCount; i++) {
				elTR = document.getElementById(strHTMLDBDIVID + "_tr" + arrList.r[i][0]);
				if (elTR) {
					elTR.parentNode.removeChild(elTR);
				}
				strRowContent += "<tr class=\"refreshed\" data-row-id=\""
						+ arrList.r[i][0]
						+ "\" id=\"" + (strHTMLDBDIVID + "_tr" + arrList.r[i][0]) + "\">";
				for (j = 0; j < lColumnCount; j++) {
				    strRowContent += ("<td id=\""
				    		+ (strHTMLDBDIVID + "_td" + arrList.r[i][0])
				    		+ (arrColumns[j])
				    		+ "\">"
				    		+ arrList.r[i][j]
				    		+ "</td>");
				}

				strRowContent += "</tr>";
			}
			theadHTMLDB.innerHTML = strColumnContent;
			tbodyHTMLDB.innerHTML += strRowContent;
		}

		var iframeFormDefaultName = (elDIV.id + "_iframe_");
		var iframeFormGUID = iframeHTMLDB.id.substr(iframeFormDefaultName.length);
		HTMLDB.__removeIframeAndForm(elDIV.id, iframeFormGUID);

		if ((p2 === false) && elDIV.doHTMLDBRead) {
			elDIV.doHTMLDBRead(elDIV);
		} else if ((p2 === true) && elDIV.doHTMLDBReadAll) {
			elDIV.doHTMLDBReadAll(elDIV);
		}

		clearTimeout(elDIV.tmTimer);

		var lAutoRefreshTime = parseInt(elDIV.getAttribute("data-auto-refresh"));
		if (lAutoRefreshTime > 0) {
			elDIV.tmTimer = setTimeout(function() {
				HTMLDB.read(strHTMLDBDIVID, false);
			}, lAutoRefreshTime);
		}
	},
	"__doirl":function(p1) {
		HTMLDB.__doirlc(p1, false);
		HTMLDB.render(p1.target.parentNode.parentNode.id);
	},
	"__doiral":function(p1) {
		HTMLDB.__doirlc(p1, true);
		HTMLDB.renderAll(p1.target.getAttribute("data-htmldb-id"));
	},
	"__doiwl":function(p1) {
		elDIV = p1.target.parentNode.parentNode;
		elDIV.setAttribute("data-loading", 0);
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
	"__doivl":function(p1) {
		elDIV = p1.target.parentNode.parentNode;
		elDIV.setAttribute("data-loading", 0);
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
	"__gtdc":function(p1, p2, p3) {
		var strReturn = "";
		for (var strPropertyName in p2) {
        	if (p2.hasOwnProperty(strPropertyName)) {
        		strReturn += ("<td id=\""
        				+ p1.id
        				+ "_td"
        				+ p3
        				+ strPropertyName
        				+ "\">"
        				+ p2[strPropertyName]
        				+ "</td>");
        	}
    	}
    	return strReturn;
	},
	"__gfih":function(p1, p2, p3) {
		var elForm = document.getElementById(p1.id + "_form_" + p2);
		var lIndex = 0;
		var strInputAction = "";

		if (p3.className.indexOf("deleted") != -1) {
			strInputAction = "deleted";
		} else if (p3.className.indexOf("updated") != -1) {
			strInputAction = "updated";
		} else {
			strInputAction = "inserted";
		}

		lIndex = elForm.getElementsByClassName("inputaction").length;

		var strFormContent = "<input class=\"inputaction\" type=\"hidden\" name=\""
				+ "inputaction" + lIndex
				+ "\" value=\""
				+ strInputAction
				+ "\" />";

		var arrColumns = HTMLDB.getColumnNames(p1.id, false);
		var lColumnCount = arrColumns.length;
		var elTD = null;
		var strRowID = p3.getAttribute("data-row-id");
		var strTDPrefix = (p1.id + "_td" + strRowID);
		var lTDCount = p3.children.length;
		var objTDValues = [];
		var strTDValue = "";

		for (var lCurrentTD = 0; lCurrentTD < lTDCount; lCurrentTD++) {
			objTDValues[p3.children[lCurrentTD].id] = p3.children[lCurrentTD].innerHTML;
		}

		for (var lCurrentColumn = 0; lCurrentColumn < lColumnCount; lCurrentColumn++) {
			if (!objTDValues.hasOwnProperty(strTDPrefix + arrColumns[lCurrentColumn])) {
				continue;
			}

			strTDValue = objTDValues[strTDPrefix + arrColumns[lCurrentColumn]];

			strFormContent += "<input class=\"inputfield\" type=\"hidden\" name=\""
					+ "inputfield" + lIndex + arrColumns[lCurrentColumn]
 					+ "\" value=\""
					+ HTMLDB.__ejs(strTDValue)
					+ "\" />";
		}

		elForm.innerHTML += strFormContent;
	},
	"__grf":function(p1) {
		// Generate Render Functions
		var elDIV = document.getElementById(p1);
		var strTemplateIDCSV = elDIV.getAttribute("data-template-element-id-csv");
		var strTargetIDCSV = elDIV.getAttribute("data-target-element-id-csv");
		var arrTemplateIDs = String(strTemplateIDCSV).split(",");
		var arrTargetIDs = String(strTargetIDCSV).split(",");

		var lTemplateIDCount = arrTemplateIDs.length;
		var lTargetIDCount = arrTargetIDs.length;

		if (lTemplateIDCount != lTargetIDCount) {
			return;
		}

		elDIV.renderFunction = null;
		var strFunctionHeader  = "";
		var strFunctionBody = "";
		var strFunctionFooter  = "";

		strFunctionBody = "var lTRCount=arrTR.length;"
				+ "for(var lCurrentTR=0;lCurrentTR<lTRCount;lCurrentTR++){";

		for (var lCurrentTemplate = 0;
				lCurrentTemplate < lTemplateIDCount;
				lCurrentTemplate++) {

			if (!document.getElementById(arrTemplateIDs[lCurrentTemplate])) {
				continue;
			}

			if (!document.getElementById(arrTargetIDs[lCurrentTemplate])) {
				continue;
			}

			strFunctionHeader += "var str" + arrTemplateIDs[lCurrentTemplate] + "Generated=\"\";"

			strFunctionBody += HTMLDB.__grfs(p1,
					arrTemplateIDs[lCurrentTemplate],
					arrTargetIDs[lCurrentTemplate]);

			strFunctionBody += ";";

			strFunctionFooter += "document.getElementById(\""
					+ arrTargetIDs[lCurrentTemplate]
					+ "\").innerHTML=str" + arrTemplateIDs[lCurrentTemplate] + "Generated;";
		}

		strFunctionBody += "if(\"refreshed\"==arrTR[lCurrentTR].className){arrTR[lCurrentTR].className=\"\"};";
		strFunctionBody += "}"

		elDIV.renderFunction
				= new Function('arrTR', 
				(strFunctionHeader + strFunctionBody + strFunctionFooter));
	},
	"__il":function(p1) {
		if (undefined == p1) {
			return false;
		} else {
  			return ((p1.length === 1) && p1.match(/[a-z_]/i));
  		}
	},
	"__in":function(p1) {
  		if (undefined == p1) {
  			return false;
  		} else {
  			return ((p1.length === 1) && p1.match(/[0-9]/));
  		}
	},
	"__grfs":function(p1, p2, p3) {
		var elDIV = document.getElementById(p1);
		var elTemplate = document.getElementById(p2);
		var strTemplateContent = elTemplate.innerHTML;
		var arrTemplateContent = String(strTemplateContent).split("#");
		var lTemplateContentCount = arrTemplateContent.length;
		var strCurrentContent = "";
		var lCurrentTemplateContentCount = 0;
		var lCurrentTemplateContent = 0;
		var strFunctionBody = "";
		var strHTMLDBDIVID = "";
		var strHTMLDBItemID = "";
		var lHTMLDBItemID = 0;
		var strHTMLDBColumnName = "";
		var strText = "";
		var lCharacterPosition = 0;
		var lTemplateExpressionLength = 0;

		if (arrTemplateContent.length <= 1) {
			return "";
		}

		strFunctionBody = "str" + p2 + "Generated=str" + p2 + "Generated";

		lCurrentTemplateContentCount = arrTemplateContent.length;

		if (lCurrentTemplateContentCount > 1) {
			strCurrentContent = arrTemplateContent[0];
			strText = strCurrentContent;
			strText = String(strText).replace(/(?:\r\n|\r|\n)/g, "");
			strFunctionBody += "+\"" + HTMLDB.__as((String(strText).trim())) + "\"";
		}

		for (lCurrentTemplateContent = 1;
				(lCurrentTemplateContent < lCurrentTemplateContentCount);
				lCurrentTemplateContent++) {
			strCurrentContent = arrTemplateContent[lCurrentTemplateContent];
			lCharacterPosition = 1;

			while (HTMLDB.__il(strCurrentContent[lCharacterPosition])
					|| HTMLDB.__in(strCurrentContent[lCharacterPosition])) {
				lCharacterPosition++;
			}

			if ((strCurrentContent[lCharacterPosition] != ":")
					&& (strCurrentContent[lCharacterPosition] != ".")) {
				strText = strCurrentContent;
				strText = String(strText).replace(/(?:\r\n|\r|\n)/g, "");
				strFunctionBody += "+\"#" + HTMLDB.__as((String(strText).trim())) + "\"";
				continue;
			} else if (":" == strCurrentContent[lCharacterPosition]) {
				strHTMLDBDIVID = String(strCurrentContent).substr(0, (lCharacterPosition));
				strHTMLDBItemID = "";
				strHTMLDBColumnName = "";
				lHTMLDBItemID = 0;
				strText = "";

				lCharacterPosition++;

				while (HTMLDB.__in(strCurrentContent[lCharacterPosition])) {
					strHTMLDBItemID += strCurrentContent[lCharacterPosition];
					lCharacterPosition++;
				}

				if (strHTMLDBItemID != "") {
					lHTMLDBItemID = parseInt(strHTMLDBItemID);
				}

				if (("" == strHTMLDBItemID)
						|| isNaN(lHTMLDBItemID)
						|| (strCurrentContent[lCharacterPosition] != ".")) {
					strText = strCurrentContent;
					strText = String(strText).replace(/(?:\r\n|\r|\n)/g, "");
					strFunctionBody += "+\"#" + HTMLDB.__as((String(strText).trim())) + "\"";
					continue;
				}

				lCharacterPosition++;

				if (!HTMLDB.__il(strCurrentContent[lCharacterPosition])) {
					strText = strCurrentContent;
					strText = String(strText).replace(/(?:\r\n|\r|\n)/g, "");
					strFunctionBody += "+\"#" + HTMLDB.__as((String(strText).trim())) + "\"";
					continue;					
				}

				strHTMLDBColumnName += strCurrentContent[lCharacterPosition];

				lCharacterPosition++;

				while (HTMLDB.__il(strCurrentContent[lCharacterPosition])
						|| HTMLDB.__in(strCurrentContent[lCharacterPosition])) {
					strHTMLDBColumnName += strCurrentContent[lCharacterPosition];
					lCharacterPosition++;
				}

				if (!document.getElementById(strHTMLDBDIVID
						+ "_td"
						+ lHTMLDBItemID
						+ strHTMLDBColumnName)) {
					strText = strCurrentContent;
					strText = String(strText).replace(/(?:\r\n|\r|\n)/g, "");
					strFunctionBody += "+\"#" + HTMLDB.__as((String(strText).trim())) + "\"";
					continue;
				} else {
					strFunctionBody += "+document.getElementById(\""
							+ strHTMLDBDIVID
							+ "_td"
							+ lHTMLDBItemID
							+ strHTMLDBColumnName
							+ "\").innerHTML";

					lTemplateExpressionLength = strHTMLDBDIVID.length
							+ 1
							+ strHTMLDBItemID.length
							+ 1
							+ strHTMLDBColumnName.length;

					strText = String(strCurrentContent).substr(lTemplateExpressionLength);

					strText = String(strText).replace(/(?:\r\n|\r|\n)/g, "");

					strFunctionBody += "+\"" + HTMLDB.__as((String(strText).trim())) + "\"";
				}
			} else if ("." == strCurrentContent[lCharacterPosition]) {
				strHTMLDBDIVID = String(strCurrentContent).substr(0, (lCharacterPosition));
				strHTMLDBItemID = "";
				strHTMLDBColumnName = "";
				strText = "";

				lCharacterPosition++;

				if (!HTMLDB.__il(strCurrentContent[lCharacterPosition])) {
					strText = strCurrentContent;
					strText = String(strText).replace(/(?:\r\n|\r|\n)/g, "");
					strFunctionBody += "+\"#" + HTMLDB.__as((String(strText).trim())) + "\"";
					continue;					
				}

				strHTMLDBColumnName += strCurrentContent[lCharacterPosition];

				lCharacterPosition++;

				while (HTMLDB.__il(strCurrentContent[lCharacterPosition])
						|| HTMLDB.__in(strCurrentContent[lCharacterPosition])) {
					strHTMLDBColumnName += strCurrentContent[lCharacterPosition];
					lCharacterPosition++;
				}

				if (!document.getElementById(strHTMLDBDIVID)) {
					strText = strCurrentContent;
					strText = String(strText).replace(/(?:\r\n|\r|\n)/g, "");
					strFunctionBody += "+\"#" + HTMLDB.__as((String(strText).trim())) + "\"";
					continue;					
				} else {
					strFunctionBody += "+document.getElementById(\""
							+ strHTMLDBDIVID
							+ "_td\"+arrTR[lCurrentTR].getAttribute(\"data-row-id\")+\""
							+ strHTMLDBColumnName
							+ "\").innerHTML";

					lTemplateExpressionLength = strHTMLDBDIVID.length
							+ 1
							+ strHTMLDBColumnName.length;

					strText = String(strCurrentContent).substr(lTemplateExpressionLength);

					strText = String(strText).replace(/(?:\r\n|\r|\n)/g, "");

					strFunctionBody += "+\"" + HTMLDB.__as((String(strText).trim())) + "\"";
				}
			}
		}

		return strFunctionBody;
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
	"__as":function(p1) {
	  return (p1 + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
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
	}
}