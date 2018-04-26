// ----------------------
// Initialize Application
// ----------------------
function initializeApplication() {
	initializeSideMenu();
	initializeShowHideByElement();
	initializeButtonOpenDialog();
	initializeTopMenu();
	enableTransitions();
}

// ------------------------
// Initialization Functions
// ------------------------
function initializeSideMenu() {
	if (!(document.body.getAttribute("data-page-url"))) {
		return;
	}
	
	var strPageURL = document.body.getAttribute("data-page-url");
	var elLI = document.getElementById("pageurl" + strPageURL);
	var strParentPageURL = "";

	if (elLI.getAttribute("data-parent-url")) {
		strParentPageURL = elLI.getAttribute("data-parent-url");
	}

	if ("" != strParentPageURL) {
		$(".pageurl" + strParentPageURL).click();
	}

	if ("" == strParentPageURL) {
		$(elLI).addClass("activeparent");
	} else {
		$(elLI).addClass("active");
	}
}
function initializeTopMenu() {
	$("#buttonTopMenuSideNav").sideNav();
	
	$("#ulSideNav").collapsible();
}
function initializeShowHideByElement(elContainer) {
	var arrDIV = new Array();
	if (elContainer !== undefined) {
		arrDIV = $(".sh-element", elContainer);
	} else {
		arrDIV = $(".sh-element");
	}
	var lDIVCount = arrDIV.length;
	var elDIV = null;
	var elMainElement = null;
	var arrShowHideElementHistory = new Array();
	var arrCurrentElements = new Array();
	var arrCurrentValues = new Array();
	var strFunctionBody = "";
	var lCurrentElementCount = 0;
	var lCurrentElementValueCount = 0;
	var arrClassNames = new Array();
	var lClassNameCount = 0;
	var strCurrentClassName = "";
	var arrCurrentClassName = new Array();
	var lCurrentClassNameCount = 0;
	var strCurrentMainElementID = "";

	for (var i = 0; i < lDIVCount; i++) {
		elDIV = arrDIV[i];

		arrClassNames = elDIV.className.split(" ");
		lClassNameCount = arrClassNames.length;

		arrCurrentElements = new Array();
		arrCurrentValues = new Array();

		lCurrentElementCount = 0;

		for (var j = 0; j < lClassNameCount; j++) {
			arrCurrentClassName = String(arrClassNames[j]).split("-");
			if (arrCurrentClassName.length < 3) {
				continue;
			} else if ("sh" != arrCurrentClassName[0]) {
				continue;
			} else {
				lCurrentClassNameCount = arrCurrentClassName.length;
				strCurrentMainElementID = "";
				for (var k = 1; k < (lCurrentClassNameCount - 1); k++) {
					strCurrentMainElementID += arrCurrentClassName[k];
				}

				arrCurrentElements[strCurrentMainElementID] = 1;

				if (arrCurrentValues[strCurrentMainElementID]) {
					(arrCurrentValues[strCurrentMainElementID]).push(arrCurrentClassName[lCurrentClassNameCount - 1]);
				} else {
					arrCurrentValues[strCurrentMainElementID] = new Array();
					(arrCurrentValues[strCurrentMainElementID]).push(arrCurrentClassName[lCurrentClassNameCount - 1]);
					lCurrentElementCount++;
				}
			}
		}

		if (0 == lCurrentElementCount) {
			continue;
		}

		strFunctionBody = "var lScore=0;";

		for (var strArrayElementID in arrCurrentElements) {
			elMainElement = document.getElementById(strArrayElementID);

			lCurrentElementValueCount = (arrCurrentValues[strArrayElementID]).length;

			if (!elMainElement) {
				continue;
			}

			if ("INPUT" == elMainElement.tagName) {
				if (("radio" == elMainElement.getAttribute("type"))
					|| ("checkbox" == elMainElement.getAttribute("type"))) {
					
					if (!arrShowHideElementHistory[strArrayElementID]) {
						$(elMainElement).off("click").on("click", function() {
							doShowHideByElementMainElementChange(this);
						});
					}

					for (var j = 0; j < lCurrentElementValueCount; j++) {
						strFunctionBody += "if("
						+ arrCurrentValues[strArrayElementID][j]
						+ "==document.getElementById(\""
						+ elMainElement.id
						+ "\").checked){lScore++}";
					}
				}
			} else if ("SELECT" == elMainElement.tagName) {
				if (!arrShowHideElementHistory[strArrayElementID]) {
					$(elMainElement).off("change").on("change", function() {
						doShowHideByElementMainElementChange(this);
					});
				}

				for (var j = 0; j < lCurrentElementValueCount; j++) {
					strFunctionBody += "if("
					+ arrCurrentValues[strArrayElementID][j]
					+ "==$(\"#"
					+ elMainElement.id
					+ "\").val()){lScore++}";
				}
			}

			arrShowHideElementHistory[strArrayElementID] = 1;
		}

		strFunctionBody += "if(lScore=="
		+ lCurrentElementCount
		+ "){return true}else{return false}";

		elDIV.isShowHideStatusVisible
		= new Function(strFunctionBody);
	}
}
function initializeButtonOpenDialog() {
	$(".buttonOpenDialog").off("click").on("click", function () {
		doOpenDialogButtonClick(this);
	});
}

// ----------------
// Helper Functions
// ----------------

function enableTransitions() {
	$(".notransition").removeClass("notransition");
}
function generateGUID(strPrefix) {
	var dtNow = new Date();
	var strToken0 = String(dtNow.getUTCFullYear())
	+ String((dtNow.getUTCMonth() + 1))
	+ String(dtNow.getUTCDate())
	+ String(dtNow.getHours())
	+ String(dtNow.getMinutes())
	+ String(dtNow.getSeconds());
	var strToken1 = 'xxxx'.replace(/[xy]/g, function(c) {var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;return v.toString(16);});
	var strToken2 = 'xxxx'.replace(/[xy]/g, function(c) {var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;return v.toString(16);});	
	return strPrefix + strToken0 + strToken1 + strToken2;
}
function refreshShowHideElements(strParentElementID) {
	var elParent = document.getElementById(strParentElementID);
	var arrDIV = null;

	if (elParent) {
		arrDIV = $(".sh-element", elParent);
	} else {
		arrDIV = $(".sh-element");
	}

	var lDIVCount = arrDIV.length;
	var elDIV = null;

	for (var i = 0; i < lDIVCount; i++) {
		elDIV = arrDIV[i];
		doShowHideByElementMainElementChange(elDIV);
	}
}
function refreshSwitchElements(elContainer) {
	var arrSwitchElements = $(".switchrefresh", elContainer);
	var lSwitchElementCount = arrSwitchElements.length;
	var elSwitchElement = null;
	var strHTMLContent = "";
	var elParent = null;

	for (var i = 0; i < lSwitchElementCount; i++) {
		elSwitchElement = arrSwitchElements[i];
		elParent = elSwitchElement.parentNode;
		strHTMLContent = elParent.innerHTML;
		elParent.innerHTML = "";
		elParent.innerHTML = strHTMLContent;
	}

	initializeShowHideByElement(elContainer);
}
function showDialog(strDIVID, strGUID) {
	var elDIV = document.getElementById(strDIVID);

	if (!elDIV) {
		return;
	}

	$(document.body).addClass("bodyDialogActive");
	$(elDIV).addClass("divDialogActive");

	elDIV.style.display = "block";
	$(".divContentWrapper", elDIV).css("display", "block");
	// $(".divContentPanel", elDIV).css("display", "none");

	appendActiveDialog(strDIVID);

	$(elDIV).velocity("stop");
	$(".divContentWrapper", elDIV).velocity("transition.flipXIn", 300);

	elDIV.scrollTop = "0px";

	$(".divFloatingActionButton", elDIV).css("display", "block");

	$(".buttonCloseDialog", elDIV).off("click").on("click", function() {
		hideDialog(strDIVID);
	});

	if (elDIV.showDialogCallback) {
		elDIV.showDialogCallback(elDIV)
	}
}
function showPage(strDIVID) {
	var elDIV = document.getElementById(strDIVID);

	if (!elDIV) {
		return;
	}

	if (document.getElementById("h3PageHeader")) {
		var strPageHeader = elDIV.getAttribute("data-page-header");
		document.getElementById("h3PageHeader").innerHTML = strPageHeader;
	}

	$(elDIV).addClass("divPageActive");

	elDIV.style.display = "block";
	$(".divContentWrapper", elDIV).css("display", "block");
	// $(".divContentPanel", elDIV).css("display", "none");

	appendActivePage(strDIVID);

	$(elDIV).velocity("stop");
	$(".divContentWrapper", elDIV).velocity("transition.slideUpBigIn", 300);

	elDIV.scrollTop = "0px";

	$(".buttonClosePage", elDIV).off("click").on("click", function() {
		hidePage(strDIVID);
	});
}
function appendActivePage(strDIVID) {
	var strActivePageCSV = document.body.getAttribute("data-active-page-csv");
	if (strActivePageCSV != "") {
		strActivePageCSV += ",";
	}
	strActivePageCSV += strDIVID;
	document.body.setAttribute("data-active-page-csv", strActivePageCSV);
}
function setActivePage(strDIVID) {
	document.body.setAttribute("data-active-page-csv", strDIVID);
}
function hidePage(strDIVID) {
	var elDIV = document.getElementById(strDIVID);

	if (!elDIV) {
		return;
	}

	if ("1" == document.body.getAttribute("data-hiding-page")) {
		return;
	}

	document.body.setAttribute("data-hiding-page", "1");

	elDIV.style.display = "none";
	$(".divContentWrapper", elDIV).css("display", "none");

	var strActivePageCSV = document.body.getAttribute("data-active-page-csv");
	arrActivePages = strActivePageCSV.split(",");
	arrActivePages.pop();
	strActivePageCSV = arrActivePages.join(",");
	document.body.setAttribute("data-active-page-csv", strActivePageCSV);

	$(".buttonClosePage", elDIV).off("click");
	elDIV.scrollTop = "0px";
	$(elDIV).removeClass("divPageActive");

	$(elDIV).velocity("stop");
	$(".divContentWrapper", elDIV).velocity("transition.slideDownBigOut", 300, function () {
		elDIV.style.display = "none";
		document.body.setAttribute("data-hiding-page", "0");
	});
}
function appendActiveDialog(strDIVID) {
	var strActiveDialogCSV = document.body.getAttribute("data-active-dialog-csv");
	if (strActiveDialogCSV != "") {
		strActiveDialogCSV += ",";
	}
	strActiveDialogCSV += strDIVID;
	document.body.setAttribute("data-active-dialog-csv", strActiveDialogCSV);
}
function setActiveDialog(strDIVID) {
	document.body.setAttribute("data-active-dialog-csv", strDIVID);
}
function hideDialog(strDIVID) {
	var elDIV = document.getElementById(strDIVID);
	var bMessageDialog = $(elDIV).hasClass("divMessageDialog");
	var bAlertDialog = $(elDIV).hasClass("divAlertDialog");

	if (!elDIV) {
		return;
	}

	if ("1" == document.body.getAttribute("data-hiding-dialog")) {
		return;
	}

	document.body.setAttribute("data-hiding-dialog", "1");

	var strActiveDialogCSV = document.body.getAttribute("data-active-dialog-csv");
	arrActiveDialogs = strActiveDialogCSV.split(",");
	arrActiveDialogs.pop();
	strActiveDialogCSV = arrActiveDialogs.join(",");
	document.body.setAttribute("data-active-dialog-csv", strActiveDialogCSV);

	if (arrActiveDialogs.length < 2) {
		$(document.body).removeClass("bodyDialogActive");
	}

	$(".buttonCloseDialog", elDIV).off("click");
	
	$(elDIV).removeClass("divDialogActive");

	$(elDIV).velocity("stop");
	$(".divContentWrapper", elDIV).velocity("transition.slideDownBigOut", 300, function () {
		elDIV.style.display = "none";
		document.body.setAttribute("data-hiding-dialog", "0");
		if (elDIV.hideDialogCallback) {
			elDIV.hideDialogCallback(elDIV);
		}
	});
}
function hideDialogs() {
	var arrDialogContentDIV = $(".divDialogContent");
	var lDialogContentDIVCount = arrDialogContentDIV.length;
	var elDialogContentDIV = null;

	for (var i = 0; i < lDialogContentDIVCount; i++) {
		elDialogContentDIV = arrDialogContentDIV[i];
		hideDialog(elDialogContentDIV.id);
	}
}
function showSuccessDialog(strMessage) {
	document.getElementById("pFormSuccessText").innerHTML = strMessage;
	showDialog("divSuccessDialog");
	setTimeout(function() {
		hideDialog("divSuccessDialog");
	}, 3000);	
}
function showSuccessCard(strMessage) {
	document.getElementById("pFormSuccessCardText").innerHTML = strMessage;
	document.getElementById("divSuccessCard").style.display = "block";

	$("#divSuccessCard").velocity("stop");
	$("#divSuccessCard").velocity("scroll", 500);
}
function showErrorDialog(strMessage) {
	document.getElementById("pFormErrorText").innerHTML = strMessage;
	showDialog("divErrorDialog");
}
function htmlspecialchars(strHTML) {
	var arrMap = {
		"&": "&amp;",
		"<": "&lt;",
		">": "&gt;",
		'"': "&quot;",
		"'": "&#039;"
	};

	return strHTML.replace(/[&<>"']/g, function(m) {
		return arrMap[m];
	});
}
function htmlspecialchars_decode(strHTML) {
	var element = document.createElement('div');

	if(strHTML && typeof strHTML === 'string') {
		// strip script/html tags
		strHTML = strHTML.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, "");
		strHTML = strHTML.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, "");
		element.innerHTML = strHTML;
		strHTML = element.textContent;
		element.textContent = "";
	}

	return strHTML;
}
function encodeBackslash(strHTML) {
	return String(strHTML).replace(/\\/g, "&bs;");
}
function decodeBackslash(strHTML) {
	return String(strHTML).replace(/&bs;/g, "\\");
}
function checkFTPConnection(doSuccess, doError) {

    var checkURL = document.body.getAttribute("data-url-prefix");
    checkURL += "ftp_server/checkconnection";
    checkServerConnection(checkURL, doSuccess, doError);

}
function checkMySQLConnection(doSuccess, doError) {

    var checkURL = document.body.getAttribute("data-url-prefix");
    checkURL += "database_server/checkconnection";
    checkServerConnection(checkURL, doSuccess, doError);

}
function checkServerConnection(checkURL, doSuccess, doError) {

    var ajaxURL = checkURL;
    var dtNow = new Date();
    ajaxURL += ("/nocache" + dtNow.getTime());

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {

        if (this.readyState == 4){

            if (404 == this.status) {

                throw(new Error(ajaxURL + " not found on the server."));
                return false;

            }

            response = JSON.parse(this.responseText);
            
            if (response.errorCount > 0) {

            	showErrorDialog(response.lastError);
            	if (doError) {
            		doError();
            	}

            } else {
            	if (doSuccess) {
            		doSuccess();
            	}
            }

            request = null;

        }

    }

    try {

        request.open("GET", ajaxURL, true);
        request.send();

    } catch (e) {
        throw(e);
    }

}


// ---------------------
// Helper Event Handlers
// ---------------------

function doTopMenuSideNavButtonClick(sender) {
	if (!sender) {
		return;
	}


}

function doTopMenuMyProfileLinkClick(sender) {
	if (!sender) {
		return;
	}

	$("#buttonTopMenuSideNav").sideNav('hide');

	$("#buttonSaveMyProfileForm").off("click").on("click", function() {
		doSaveMyProfileFormClick(this);
	});

	refreshShowHideElements();

	showDialog("divMyProfile");
}
function doSaveMyProfileFormClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormMyProfile").data("bLoading")) {
		return;
	}

	$("#iframeFormMyProfile").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");

	$("#iframeFormMyProfile").unbind("load").bind("load", function() {
		$("#iframeFormMyProfile").data("bLoading", false);
		clearTimeout($("#iframeFormMyProfile").data("tmLoadingTimer"));

		iframeWindow = top.frames["iframeFormMyProfile"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());

		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			showSuccessDialog(objResponse.lastMessage);
			hideDialog("divMyProfile");
		} 

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormMyProfile").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormMyProfile").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormMyProfile").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("formMyProfile").submit();
}
function doOpenDialogButtonClick(sender) {
	if (!sender) {
		return;
	}

	var elDialog = document.getElementById(sender.getAttribute("data-dialog-id"));

	if (elDialog) {
		showDialog(elDialog.id);
	}
}

function doShowHideByElementMainElementChange(sender) {
	if (!sender) {
		return;
	}

	var arrDIV = $(".sh-element");
	var lDIVCount = arrDIV.length;
	var elDIV = null;

	for (var i = 0; i < lDIVCount; i++) {
		elDIV = arrDIV[i];
		if (elDIV.isShowHideStatusVisible) {
			if (elDIV.isShowHideStatusVisible()) {
				if (elDIV.style.display === "none") {
					$(elDIV).velocity("stop");
					$(elDIV).velocity("fadeIn", 500);
				}
			} else {
				$(elDIV).velocity("stop");
				elDIV.style.display = "none";
			}
		}  
	}
}
function setInputValue(strInputIdentifier, strValue) {
	var elInput = null;

	if (document.getElementById(strInputIdentifier)) {
		elInput = document.getElementById(strInputIdentifier);
	} else if (document.getElementById(strInputIdentifier + strValue)) {
		elInput = document.getElementById(strInputIdentifier + strValue);
	} else if (document.getElementById(strInputIdentifier + "Option" + strValue)) {
		elInput = document.getElementById(strInputIdentifier + "Option" + strValue);
	} else {
		return false;
	}

	var strTagName = String(elInput.tagName).toLowerCase();
	var strInputType = String(elInput.getAttribute("type")).toLowerCase();

	switch (strTagName) {
		case "input":
			if ("checkbox" == strInputType) {
				elInput.checked = ("1" == strValue);
			} else if ("radio" == strInputType) {
				if (elInput.value == strValue) {
					elInput.checked = true;
				}
			} else {
				elInput.value = decodeBackslash(htmlspecialchars_decode(strValue));
			}
		break;
		case "textarea":
			elInput.innerHTML = strValue;

			if (elInput.className.indexOf("textareaCodeMirror") != -1) {
				$(elInput).data("objCodeMirror").setValue(
					decodeBackslash(htmlspecialchars_decode(strValue)));
			} else if (elInput.className.indexOf("textareaHTMLEditor") != -1) {
				tinyMCE.get(elInput.id).setContent(
						decodeBackslash(
						htmlspecialchars_decode(
						htmlspecialchars_decode(strValue))));
			} else {
				return elInput.value;
			}
		break;
		case "select":
			if (elInput.selectize) {
				if (!elInput.multiple) {
					elInput.selectize.setValue(
						decodeBackslash(htmlspecialchars_decode(strValue)));
				} else {
					elInput.selectize.clear(true);
					var selections = strValue.split(",");
					var selectionCount = selections.length;
					for (var i = 0; i < selectionCount; i++) {
						elInput.selectize.addItem(selections[i]);
					}
				}
			}
		break;
	}
}
function getInputValue(strInputIdentifier) {
	var elInput = null;
	var arrInputs = null;
	var lInputCount = 0;
	var strTagName = "";
	var strInputType = "";

	if (document.getElementById(strInputIdentifier)) {
		elInput = document.getElementById(strInputIdentifier);
		strTagName = String(elInput.tagName).toLowerCase();
		strInputType = String(elInput.getAttribute("type")).toLowerCase();

		switch (strTagName) {
			case "input":
				if ("checkbox" == strInputType) {
					return (elInput.checked ? 1 : 0);
				} else if ("radio" == strInputType) {
					return ((elInput.checked) ? elInput.value : "");
				} else {
					return htmlspecialchars(encodeBackslash(elInput.value));
				}
			break;

			case "textarea":
				if (elInput.className.indexOf("textareaHTMLEditor") != -1) {
					return htmlspecialchars(
							encodeBackslash(
							tinyMCE.get(
							elInput.id).getContent()));
				} else {
					return htmlspecialchars(
							encodeBackslash(
							elInput.value));
				}
			break;
			case "select":
				if (elInput.selectize) {
					if (undefined == elInput.attributes['multiple']) {
						return htmlspecialchars(encodeBackslash($(elInput).val()));
					} else {
						var selections = $(".selectize-input.items > .item", elInput.parentNode);
						var selectionCount = selections.length;
						var selectionCSV = "";
						var selection = null;
						for (var i = 0; i < selectionCount; i++) {
							selection = selections[i];
							if (selectionCSV != "") {
								selectionCSV += ",";
							}
							selectionCSV += selection.getAttribute("data-value");
						}
						return selectionCSV;
					}
				} else {
					return htmlspecialchars(encodeBackslash($(elInput).val()));
				}
			break;
		}
	} else {
		arrInputs = document.getElementsByName(strInputIdentifier);
		lInputCount = arrInputs.length;

		if (0 == lInputCount) {
			return "";
		}

		for (var i = 0; i < lInputCount; i++) {
			if (arrInputs[i].checked) {
				return htmlspecialchars(encodeBackslash(arrInputs[i].value));
			}
		}
	}
}
function resetProgressBar(strLoaderText, bLive, bIndeterminate) {
	var elLoader = document.getElementById("divLoader");
	var elProgressBar = document.getElementById("divLoaderProgress");
	elProgressBar.style.width = "%0";
	elProgressBar.setAttribute("data-progress", "0");
	var elProgressBarText = document.getElementById("divLoaderText");

	if (true === bIndeterminate) {
		$(elProgressBar).removeClass("determinate");
		$(elProgressBar).addClass("indeterminate");
	} else {
		$(elProgressBar).removeClass("indeterminate");
		$(elProgressBar).addClass("determinate");
	}

	if (undefined === strLoaderText) {
		strLoaderText = elProgressBarText.getAttribute("data-default-text");
	}

	elProgressBarText.innerHTML = strLoaderText;

	elLoader.style.display = "block";
	$(elLoader).css("opacity", "1");

	stepProgressBar(8, bLive);
}
function stepProgressBar(lStepValue, bLive) {
	var elProgressBar = document.getElementById("divLoaderProgress");
	var lCurrentValue = parseInt(elProgressBar.getAttribute("data-progress"));
	lCurrentValue += lStepValue;

	if (lCurrentValue >= 100) {
		lCurrentValue = 100;
	}

	elProgressBar.style.width = (lCurrentValue + "%");
	elProgressBar.setAttribute("data-progress", lCurrentValue);

	clearTimeout($(elProgressBar).data("tmProgressbarTimer"));

	if (100 == lCurrentValue) {
		document.body.setAttribute("data-body-loading", "0");
		setTimeout(function () {
			$("#divLoader").velocity("transition.shrinkOut", 300);
		}, 300);
	} else {
		if (true === bLive) {
			var tmProgressbarTimer = setTimeout(function() {
				stepProgressBar(2);
			}, 500);
			$(elProgressBar).data("tmProgressbarTimer", tmProgressbarTimer);
		}
	}
}
function doChangeImageAClick(sender) {
	if (!sender) {
		return;	
	}
	
	$("#filUploadedImage").trigger("click");

	$("#filUploadedImage").off("change").on("change", function() {	
		var elIMG = $("#imgUploadedImage");
		prepareUploadedImageForEdit(this, elIMG);
	});
}
function prepareUploadedImageForEdit(sender, elIMG) {
	if (sender.files && sender.files[0]) {
		var strRevisedImageTemplateHTML = document.getElementById("divRevisedImageTemplate").innerHTML;
		strRevisedImageTemplateHTML = strRevisedImageTemplateHTML.replace(/__DELETE__/g,"");
		document.getElementById("divRevisedImage").innerHTML = strRevisedImageTemplateHTML;
	}

	if (sender.files && sender.files[0]) {
		var imgType = sender.files[0].name.split('.').pop().toLowerCase();
		var reader = new FileReader();
		reader.onload = function (e) {
			if (e.target.result.length > 0) {
				$(elIMG).attr('src', e.target.result);
			}			
			var img = document.getElementById("imgRevisedImage");
			var src = imageToDataUri(document.getElementById("imgUploadedImage"), 200, imgType);
			img.src = src;
			$("#imgRevisedImage").attr('data-img-type', imgType);
		}
		reader.readAsDataURL(sender.files[0]);
	}

	imgRevisedImageChanged();
	initializeEditImage();	
}
function prepareCurrentImageForEdit() {
	var strRevisedImageTemplateHTML = document.getElementById("divRevisedImageTemplate").innerHTML;
	strRevisedImageTemplateHTML = strRevisedImageTemplateHTML.replace(/__DELETE__/g,"");
	document.getElementById("divRevisedImage").innerHTML = strRevisedImageTemplateHTML;

	var elIMG = document.getElementById("imgCurrentImage");
	var imgType = document.getElementById("strCurrentImageType").value;
	var img = document.getElementById("imgRevisedImage");
	var src = imageToDataUri(elIMG, 200, imgType);
	img.src = src;
	img.setAttribute("data-img-type", imgType);

	document.getElementById("imgUploadedImage").src = src;
	document.getElementById("imgUploadedImage").setAttribute("data-img-type", imgType);

	document.getElementById("filUploadedImage").value = "";

	initializeEditImage();	
}
function imageToDataUri(img, maxHeight, imgType) {
	var canvas = document.getElementById("canvasTemplate");
	var canvasContext = canvas.getContext("2d");

	var imgWidth = img.width;
	var imgHeight = img.height;
	var scale = maxHeight / imgHeight;
	var imgWidthScaled = imgWidth * scale;
	var imgHeightScaled = imgHeight * scale;

	canvas.width = imgWidthScaled;
	canvas.height = imgHeightScaled;

	canvasContext.drawImage(img, 0, 0, imgWidthScaled, imgHeightScaled);

	if ("jpg" == imgType) { imgType = "jpeg"; }

	return canvas.toDataURL("image/" + imgType);
}
function initializeEditImage() {
	resizeableImage.initialize({
		image_target : $("#imgRevisedImage"),
		firstHandle : true
	});

	document.getElementById("divCroppedImage").style.display = "block";

	$(".imagesCropWrapper").unbind("click").bind("click", function() {
		doCropWrapperDIVClick(this);
	});

	$("#buttonSaveImage").unbind("click").bind("click", function() {
		resizeableImage.crop();
	});

	$("#resizeImage").val("50");

	$("#resizeImage").on("change", function(){
		changeImageSize(this);
	});
}
function doCropWrapperDIVClick(sender) {
	if (!sender) {
		return;
	}

	if ("true" == sender.getAttribute("data-handle-before")) {
		resizeableImage.initialize({
			image_target : $(sender),
			firstHandle : false
		});
	}

	return;  
}
function changeImageSize(sender) {
	var imgUploaded = document.getElementById("imgUploadedImage");
	var imgType = imgUploaded.getAttribute("data-img-type");
	var width = imgUploaded.width;
	var height = imgUploaded.height;
	var scale = 4 * (sender.value / height);

	var imgRevised = document.getElementById("imgRevisedImage");
	var currentHeight = (height * scale);
	imgRevised.src = imageToDataUri(imgUploaded, currentHeight, imgType);
}
function imgRevisedImageChanged() {
    setTimeout(function(){ 
        var imgUploaded = document.getElementById("imgUploadedImage");
        var imgType = imgUploaded.getAttribute("data-img-type");
        var width = imgUploaded.width;
        var height = imgUploaded.height;
        var scale = 4 * (50 / height);

        var imgRevised = document.getElementById("imgRevisedImage");
        var currentHeight = (height * scale);
        imgRevised.src = imageToDataUri(imgUploaded, currentHeight, imgType);
    }, 25);    
}
function humanFileSize(bytes, si) {
	var thresh = si ? 1000 : 1024;
	if(Math.abs(bytes) < thresh) {
		return bytes + ' B';
	}
	var units = si
	? ['kB','MB','GB','TB','PB','EB','ZB','YB']
	: ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
	var u = -1;
	do {
		bytes /= thresh;
		++u;
	} while(Math.abs(bytes) >= thresh && u < units.length - 1);
	return bytes.toFixed(1)+' '+units[u];
}
function md5cycle(x, k) {
	var a = x[0], b = x[1], c = x[2], d = x[3];

	a = ff(a, b, c, d, k[0], 7, -680876936);
	d = ff(d, a, b, c, k[1], 12, -389564586);
	c = ff(c, d, a, b, k[2], 17,  606105819);
	b = ff(b, c, d, a, k[3], 22, -1044525330);
	a = ff(a, b, c, d, k[4], 7, -176418897);
	d = ff(d, a, b, c, k[5], 12,  1200080426);
	c = ff(c, d, a, b, k[6], 17, -1473231341);
	b = ff(b, c, d, a, k[7], 22, -45705983);
	a = ff(a, b, c, d, k[8], 7,  1770035416);
	d = ff(d, a, b, c, k[9], 12, -1958414417);
	c = ff(c, d, a, b, k[10], 17, -42063);
	b = ff(b, c, d, a, k[11], 22, -1990404162);
	a = ff(a, b, c, d, k[12], 7,  1804603682);
	d = ff(d, a, b, c, k[13], 12, -40341101);
	c = ff(c, d, a, b, k[14], 17, -1502002290);
	b = ff(b, c, d, a, k[15], 22,  1236535329);

	a = gg(a, b, c, d, k[1], 5, -165796510);
	d = gg(d, a, b, c, k[6], 9, -1069501632);
	c = gg(c, d, a, b, k[11], 14,  643717713);
	b = gg(b, c, d, a, k[0], 20, -373897302);
	a = gg(a, b, c, d, k[5], 5, -701558691);
	d = gg(d, a, b, c, k[10], 9,  38016083);
	c = gg(c, d, a, b, k[15], 14, -660478335);
	b = gg(b, c, d, a, k[4], 20, -405537848);
	a = gg(a, b, c, d, k[9], 5,  568446438);
	d = gg(d, a, b, c, k[14], 9, -1019803690);
	c = gg(c, d, a, b, k[3], 14, -187363961);
	b = gg(b, c, d, a, k[8], 20,  1163531501);
	a = gg(a, b, c, d, k[13], 5, -1444681467);
	d = gg(d, a, b, c, k[2], 9, -51403784);
	c = gg(c, d, a, b, k[7], 14,  1735328473);
	b = gg(b, c, d, a, k[12], 20, -1926607734);

	a = hh(a, b, c, d, k[5], 4, -378558);
	d = hh(d, a, b, c, k[8], 11, -2022574463);
	c = hh(c, d, a, b, k[11], 16,  1839030562);
	b = hh(b, c, d, a, k[14], 23, -35309556);
	a = hh(a, b, c, d, k[1], 4, -1530992060);
	d = hh(d, a, b, c, k[4], 11,  1272893353);
	c = hh(c, d, a, b, k[7], 16, -155497632);
	b = hh(b, c, d, a, k[10], 23, -1094730640);
	a = hh(a, b, c, d, k[13], 4,  681279174);
	d = hh(d, a, b, c, k[0], 11, -358537222);
	c = hh(c, d, a, b, k[3], 16, -722521979);
	b = hh(b, c, d, a, k[6], 23,  76029189);
	a = hh(a, b, c, d, k[9], 4, -640364487);
	d = hh(d, a, b, c, k[12], 11, -421815835);
	c = hh(c, d, a, b, k[15], 16,  530742520);
	b = hh(b, c, d, a, k[2], 23, -995338651);

	a = ii(a, b, c, d, k[0], 6, -198630844);
	d = ii(d, a, b, c, k[7], 10,  1126891415);
	c = ii(c, d, a, b, k[14], 15, -1416354905);
	b = ii(b, c, d, a, k[5], 21, -57434055);
	a = ii(a, b, c, d, k[12], 6,  1700485571);
	d = ii(d, a, b, c, k[3], 10, -1894986606);
	c = ii(c, d, a, b, k[10], 15, -1051523);
	b = ii(b, c, d, a, k[1], 21, -2054922799);
	a = ii(a, b, c, d, k[8], 6,  1873313359);
	d = ii(d, a, b, c, k[15], 10, -30611744);
	c = ii(c, d, a, b, k[6], 15, -1560198380);
	b = ii(b, c, d, a, k[13], 21,  1309151649);
	a = ii(a, b, c, d, k[4], 6, -145523070);
	d = ii(d, a, b, c, k[11], 10, -1120210379);
	c = ii(c, d, a, b, k[2], 15,  718787259);
	b = ii(b, c, d, a, k[9], 21, -343485551);

	x[0] = add32(a, x[0]);
	x[1] = add32(b, x[1]);
	x[2] = add32(c, x[2]);
	x[3] = add32(d, x[3]);

}

function cmn(q, a, b, x, s, t) {
	a = add32(add32(a, q), add32(x, t));
	return add32((a << s) | (a >>> (32 - s)), b);
}

function ff(a, b, c, d, x, s, t) {
	return cmn((b & c) | ((~b) & d), a, b, x, s, t);
}

function gg(a, b, c, d, x, s, t) {
	return cmn((b & d) | (c & (~d)), a, b, x, s, t);
}

function hh(a, b, c, d, x, s, t) {
	return cmn(b ^ c ^ d, a, b, x, s, t);
}

function ii(a, b, c, d, x, s, t) {
	return cmn(c ^ (b | (~d)), a, b, x, s, t);
}

function md51(s) {
	txt = '';
	var n = s.length,
	state = [1732584193, -271733879, -1732584194, 271733878], i;
	for (i=64; i<=s.length; i+=64) {
		md5cycle(state, md5blk(s.substring(i-64, i)));
	}
	s = s.substring(i-64);
	var tail = [0,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0];
	for (i=0; i<s.length; i++)
		tail[i>>2] |= s.charCodeAt(i) << ((i%4) << 3);
	tail[i>>2] |= 0x80 << ((i%4) << 3);
	if (i > 55) {
		md5cycle(state, tail);
		for (i=0; i<16; i++) tail[i] = 0;
	}
	tail[14] = n*8;
	md5cycle(state, tail);
	return state;
}

/* there needs to be support for Unicode here,
 * unless we pretend that we can redefine the MD-5
 * algorithm for multi-byte characters (perhaps
 * by adding every four 16-bit characters and
 * shortening the sum to 32 bits). Otherwise
 * I suggest performing MD-5 as if every character
 * was two bytes--e.g., 0040 0025 = @%--but then
 * how will an ordinary MD-5 sum be matched?
 * There is no way to standardize text to something
 * like UTF-8 before transformation; speed cost is
 * utterly prohibitive. The JavaScript standard
 * itself needs to look at this: it should start
 * providing access to strings as preformed UTF-8
 * 8-bit unsigned value arrays.
 */
function md5blk(s) { /* I figured global was faster.   */
	var md5blks = [], i; /* Andy King said do it this way. */
	for (i=0; i<64; i+=4) {
		md5blks[i>>2] = s.charCodeAt(i)
		+ (s.charCodeAt(i+1) << 8)
		+ (s.charCodeAt(i+2) << 16)
		+ (s.charCodeAt(i+3) << 24);
	}
	return md5blks;
}

var hex_chr = '0123456789abcdef'.split('');

function rhex(n) {
 	var s='', j=0;
 	for(; j<4; j++)
 		s += hex_chr[(n >> (j * 8 + 4)) & 0x0F]
 	+ hex_chr[(n >> (j * 8)) & 0x0F];
 	return s;
 }

function hex(x) {
 	for (var i=0; i<x.length; i++)
 		x[i] = rhex(x[i]);
 	return x.join('');
}

function md5(s) {
 	return hex(md51(s));
}

/* this function is much faster,
so if possible we use it. Some IEs
are the only ones I know of that
need the idiotic second function,
generated by an if clause.  */

function add32(a, b) {
	return (a + b) & 0xFFFFFFFF;
}

if (md5('hello') != '5d41402abc4b2a76b9719d911017c592') {
	function add32(x, y) {
		var lsw = (x & 0xFFFF) + (y & 0xFFFF),
		msw = (x >> 16) + (y >> 16) + (lsw >> 16);
		return (msw << 16) | (lsw & 0xFFFF);
	}
}

function resetForm(formElement) {

	var elements = formElement.elements;
	var elementCount = elements.length;
	var fieldType = "";
	formElement.reset();

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

		if (elements[i].getAttribute("data-reset-value")) {
			setInputValue(elements[i].id, elements[i].getAttribute("data-reset-value"));
		}

	}

}