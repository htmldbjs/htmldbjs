$(function() {
    initializeApplication();
    initializePage();
});
function initializePage() {
	initializePageFrame();

    showPage("divPageFrame");
}
function initializePageFrame() {
	$("#iframePageFrame").off("load").on("load", function() {
		doPageFrameIframeLoad(this);
	});

	document.getElementById("iframePageFrame").src
			= document.getElementById("iframePageFrame").src;
}
function doPageFrameIframeLoad(sender) {
	if (!sender) {
		return;
	}

	setTimeout(locatePageEditorButtons, 50);
}
function resizePageFrame() {
	var elIframe = document.getElementById("iframePageFrame");
	var elIframeWindow = window.frames["iframePageFrame"];

    elIframe.style.height = (elIframe.contentWindow.document.body.offsetHeight
    		+ 100
    		+ 'px');
}
function locatePageEditorButtons() {
	var elIframe = document.getElementById("iframePageFrame");
	var elIframeBody = elIframe.contentWindow.document.body;
	var arrButtonContainers = null;
	var lButtonContainerCount = 0;
	var elButtonContainer = null;
	var strButtonTemplateHTML = "";
	var strButtonHTML = "";

	// Locate spritpanel-action-create Buttons
	arrButtonContainers = $(".spritpanel-pages.spritpanel-action-create", elIframeBody);
	lButtonContainerCount = arrButtonContainers.length;
	elButtonContainer = null;
	strButtonTemplateHTML = document.getElementById("divActionCreateButtonTemplate").innerHTML;
	strButtonHTML = "";

	for (var i = 0; i < lButtonContainerCount; i++) {
		elButtonContainer = arrButtonContainers[i];

		$(elButtonContainer).addClass("active");

		strButtonHTML = strButtonTemplateHTML;
		strButtonHTML = strButtonHTML.replace(/__ID__/g,
				elButtonContainer.getAttribute("data-spritpanel-object-id"));
		strButtonHTML = strButtonHTML.replace(/__TYPE__/g,
				elButtonContainer.getAttribute("data-spritpanel-object-type"));

		elButtonContainer.innerHTML = strButtonHTML;
	}

	$(".spritpanel-action-create > button", elIframeBody).off("click").on("click", function () {
		doActionCreateButtonClick(this);
	});

	// Locate spritpanel-action-edit Buttons
	arrButtonContainers = $(".spritpanel-pages.spritpanel-action-edit", elIframeBody);
	lButtonContainerCount = arrButtonContainers.length;
	elButtonContainer = null;
	strButtonTemplateHTML = document.getElementById("divActionEditButtonTemplate").innerHTML;
	strButtonHTML = "";

	for (var i = 0; i < lButtonContainerCount; i++) {
		elButtonContainer = arrButtonContainers[i];

		$(elButtonContainer).addClass("active");

		strButtonHTML = strButtonTemplateHTML;
		strButtonHTML = strButtonHTML.replace(/__ID__/g,
				elButtonContainer.getAttribute("data-spritpanel-object-id"));
		strButtonHTML = strButtonHTML.replace(/__TYPE__/g,
				elButtonContainer.getAttribute("data-spritpanel-object-type"));

		elButtonContainer.innerHTML = strButtonHTML;
	}

	$(".spritpanel-action-edit > button", elIframeBody).off("click").on("click", function () {
		doActionEditButtonClick(this);
	});

	// Locate spritpanel-action-delete Buttons
	arrButtonContainers = $(".spritpanel-pages.spritpanel-action-delete", elIframeBody);
	lButtonContainerCount = arrButtonContainers.length;
	elButtonContainer = null;
	strButtonTemplateHTML = document.getElementById("divActionDeleteButtonTemplate").innerHTML;
	strButtonHTML = "";

	for (var i = 0; i < lButtonContainerCount; i++) {
		elButtonContainer = arrButtonContainers[i];

		$(elButtonContainer).addClass("active");

		strButtonHTML = strButtonTemplateHTML;
		strButtonHTML = strButtonHTML.replace(/__ID__/g,
				elButtonContainer.getAttribute("data-spritpanel-object-id"));
		strButtonHTML = strButtonHTML.replace(/__TYPE__/g,
				elButtonContainer.getAttribute("data-spritpanel-object-type"));

		elButtonContainer.innerHTML = strButtonHTML;
	}

	$(".spritpanel-action-delete > button", elIframeBody).off("click").on("click", function () {
		doActionDeleteButtonClick(this);
	});

	// Locate spritpanel-action-list Buttons
	arrButtonContainers = $(".spritpanel-pages.spritpanel-action-list", elIframeBody);
	lButtonContainerCount = arrButtonContainers.length;
	elButtonContainer = null;
	strButtonTemplateHTML = document.getElementById("divActionListButtonTemplate").innerHTML;
	strButtonHTML = "";

	for (var i = 0; i < lButtonContainerCount; i++) {
		elButtonContainer = arrButtonContainers[i];

		$(elButtonContainer).addClass("active");

		strButtonHTML = strButtonTemplateHTML;
		strButtonHTML = strButtonHTML.replace(/__ID__/g,
				elButtonContainer.getAttribute("data-spritpanel-object-id"));
		strButtonHTML = strButtonHTML.replace(/__TYPE__/g,
				elButtonContainer.getAttribute("data-spritpanel-object-type"));

		elButtonContainer.innerHTML = strButtonHTML;
	}

	$(".spritpanel-action-list > button", elIframeBody).off("click").on("click", function () {
		doActionListButtonClick(this);
	});

	resizePageFrame();
}
function doActionCreateButtonClick(sender) {
	if (!sender) {
		return;
	}

	alert("Create:"
			+ sender.getAttribute("data-spritpanel-object-type")
			+ " - "
			+ sender.getAttribute("data-spritpanel-object-id"));
}
function doActionEditButtonClick(sender) {
	if (!sender) {
		return;
	}

	alert("Edit:"
			+ sender.getAttribute("data-spritpanel-object-type")
			+ " - "
			+ sender.getAttribute("data-spritpanel-object-id"));
}
function doActionDeleteButtonClick(sender) {
	if (!sender) {
		return;
	}

	alert("Delete:"
			+ sender.getAttribute("data-spritpanel-object-type")
			+ " - "
			+ sender.getAttribute("data-spritpanel-object-id"));
}
function doActionListButtonClick(sender) {
	if (!sender) {
		return;
	}

	alert("List:"
			+ sender.getAttribute("data-spritpanel-object-type")
			+ " - "
			+ sender.getAttribute("data-spritpanel-object-id"));
}