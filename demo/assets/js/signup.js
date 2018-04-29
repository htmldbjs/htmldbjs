// ----------------------
// Initialize Application
// ----------------------

$(function() {
	initializeApplication();
	initializePage();
});

// ------------------------
// Initialization Functions
// ------------------------

function initializePage() {
	showDialog("divLogin");

	$("#formSignup").on("submit", function () {
		doSignupFormSubmit(this);
	});
}

// ---------------------
// Helper Event Handlers
// ---------------------

function doSignupFormSubmit(sender) {
	if (!sender) {
		return false;
	}

	if (true == $("#iframeFormSignup").data("bLoading")) {
		return false;
	}

	var elErrorDIV = document.getElementById("divErrorDialog");
	$(elErrorDIV).velocity("stop");
	elErrorDIV.style.display = "none";
	
	$("#iframeFormSignup").data("bLoading", true);
	
	var elButton = document.getElementById("buttonSubmitSignupForm");
	elButton.innerHTML = elButton.getAttribute("data-loading-text");
	
	$("#iframeFormSignup").off("load").on("load", function() {
		$("#iframeFormSignup").data("bLoading", false);
		clearTimeout($("#iframeFormSignup").data("tmLoadingTimer"));

		iframeWindow = top.frames["iframeFormSignup"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());

		if (objResponse.errorCount > 0) {
			showErrorDialog(objResponse.lastError);
		} else {
			window.location = (document.body.getAttribute("data-url-prefix") + "login");
		} 

		elButton.innerHTML = elButton.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormSignup").data("bLoading")) {
		  	elButton.innerHTML = elButton.getAttribute("data-error-text");

		  	$("#iframeFormSignup").data("bLoading", false);
		  	elButton.innerHTML = elButton.getAttribute("data-default-text");
		}
	}, 6000);

	$("#iframeFormSignup").data("tmLoadingTimer", tmLoadingTimer);
}