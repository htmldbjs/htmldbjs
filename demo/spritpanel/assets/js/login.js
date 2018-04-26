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

	$("#aForgotPasswordLink").on("click", function () {
		doForgotPasswordLinkClick(this);
	});

	$("#aCreateAccountLink").on("click", function () {
		doCreateAccountLinkClick(this);
	});

	$(".aLoginLink").on("click", function () {
		doLoginLinkClick(this);
	});

	$("#formLogin").on("submit", function () {
		doLoginFormSubmit(this);
	});

	$("#formForgotPassword").on("submit", function () {
		doForgotPasswordFormSubmit(this);
	});
}

// ---------------------
// Helper Event Handlers
// ---------------------

function doLoginFormSubmit(sender) {
	if (!sender) {
		return false;
	}

	if (true == $("#iframeFormLogin").data("bLoading")) {
		return false;
	}

	var elErrorDIV = document.getElementById("divErrorDialog");
	$(elErrorDIV).velocity("stop");
	elErrorDIV.style.display = "none";
	
	$("#iframeFormLogin").data("bLoading", true);
	
	var elButton = document.getElementById("buttonSubmitLoginForm");
	elButton.innerHTML = elButton.getAttribute("data-loading-text");
	
	$("#iframeFormLogin").off("load").on("load", function() {
		$("#iframeFormLogin").data("bLoading", false);
		clearTimeout($("#iframeFormLogin").data("tmLoadingTimer"));

		iframeWindow = top.frames["iframeFormLogin"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());

		if (objResponse.errorCount > 0) {
			showErrorDialog(objResponse.lastError);
		} else {
			window.location = (document.body.getAttribute("data-url-prefix") + "home");
		} 

		elButton.innerHTML = elButton.getAttribute("data-default-text");
	});

  // Catch Loading Error
  tmLoadingTimer = setTimeout(function() {
  	if (true == $("#iframeFormLogin").data("bLoading")) {
  		elButton.innerHTML = elButton.getAttribute("data-error-text");

  		$("#iframeFormLogin").data("bLoading", false);
  		elButton.innerHTML = elButton.getAttribute("data-default-text");
  	}
  }, 6000);

  $("#iframeFormLogin").data("tmLoadingTimer", tmLoadingTimer);
}

function doForgotPasswordFormSubmit(sender) {
		if (!sender) {
		return false;
	}

	if (true == $("#iframeFormForgotPassword").data("bLoading")) {
		return false;
	}

	var elErrorDIV = document.getElementById("divErrorDialog");
	$(elErrorDIV).velocity("stop");
	elErrorDIV.style.display = "none";

	$("#iframeFormForgotPassword").data("bLoading", true);
	
	var elButton = document.getElementById("buttonSubmitForgotPasswordForm");
	elButton.innerHTML = elButton.getAttribute("data-loading-text");
	
	$("#iframeFormForgotPassword").off("load").on("load", function() {
		$("#iframeFormForgotPassword").data("bLoading", false);
		clearTimeout($("#iframeFormForgotPassword").data("tmLoadingTimer"));

		iframeWindow = top.frames["iframeFormForgotPassword"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());

		if (objResponse.errorCount > 0) {
			showErrorDialog(objResponse.lastError);
		} else {
			showSuccessDialog(objResponse.lastMessage);
		} 

		elButton.innerHTML = elButton.getAttribute("data-default-text");
	});

  // Catch Loading Error
  tmLoadingTimer = setTimeout(function() {
  	if (true == $("#iframeFormForgotPassword").data("bLoading")) {
  		elButton.innerHTML = elButton.getAttribute("data-error-text");

  		$("#iframeFormForgotPassword").data("bLoading", false);
  		elButton.innerHTML = elButton.getAttribute("data-default-text");
  	}
  }, 6000);

  $("#iframeFormForgotPassword").data("tmLoadingTimer", tmLoadingTimer);
}

function doLoginLinkClick(sender) {
	if (!sender) {
		return;
	}

	var elDIV = sender.parentNode.parentNode.parentNode
			.parentNode.parentNode.parentNode.parentNode;

	hideDialog(elDIV.id);
	showDialog("divLogin");
}

function doCreateAccountLinkClick(sender) {
	if (!sender) {
		return;
	}

	hideDialog("divLogin");
	showDialog("divCreateAccount");
}

function doForgotPasswordLinkClick(sender) {
	if (!sender) {
		return;
	}

	hideDialog("divLogin");
	showDialog("divForgotPassword");
}
