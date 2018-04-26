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
	showPage("divSetup");

	$("#divSetupProgress").carousel({full_width: true});

	$(".buttonPrevious").on("click", function () {
		doPreviousButtonClick(this);
	});

	$(".buttonNext").on("click", function () {
		doNextButtonClick(this);
	});

	$(".selectSelectizeSingle").selectize();

	$("#buttonChangeLanguage").click(function() {
		doChangeLanguageButtonClick(this);
	});

	$("#buttonSaveAccessConfiguration").click(function() {
		doSaveAccessConfigurationButtonClick(this, true);
	});

	$("#buttonTestFTPConfiguration").click(function() {
		doTestFTPConfigurationButtonClick(this);
	});

	$("#buttonSaveFTPConfiguration").click(function() {
		doSaveFTPConfigurationButtonClick(this);
	});

	$("#buttonTestDBConfiguration").click(function() {
		doTestDBConfigurationButtonClick(this);
	});

	$("#buttonSaveDBConfiguration").click(function() {
		doSaveDBConfigurationButtonClick(this);
	});

	$("#buttonStartRightNow").click(function() {
		doStartRightNowButtonClick(this);
	});

	$("#lDatabaseType").change(function() {
		if (1 == document.getElementById("lDatabaseType").value) {
			$(".mysql-content").addClass("hide");
		} else {
			$(".mysql-content").removeClass("hide");
		}
	});
}

// ----------------
// Helper Functions
// ----------------

function getCarouselPosition(strCarouselID) {
	if ("" == strCarouselID) {
		return -1;
	}

	var elCarousel = document.getElementById(strCarouselID);
	var arrIndicatorLI = $(".indicators > li", elCarousel);
	var lIndicatorLICount = arrIndicatorLI.length;
	var bExit = false;
	var elIndicatorLI = null;

	for (var i = 0; ((i < lIndicatorLICount) && !bExit); i++) {
		elIndicatorLI = arrIndicatorLI[i];
		if (elIndicatorLI.className.indexOf("active") != -1) {
			return i;
		}
	}
}

// ---------------------
// Helper Event Handlers
// ---------------------

function doNextButtonClick(sender) {
	var lCarouselPosition = getCarouselPosition("divSetupProgress");
	var lCarouselPageCount = $("#divSetupProgress .carousel-item").length;
	if (lCarouselPosition < (lCarouselPageCount - 1)) {
		$("#divSetupProgress").carousel("next");
	}
}

function doPreviousButtonClick(sender) {
	var lCarouselPosition = getCarouselPosition("divSetupProgress");
	if (lCarouselPosition > 0) {
		$("#divSetupProgress").carousel("prev");
	}
}

function doChangeLanguageButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormChangeLanguage").data("bLoading")) {
		return;
	}

	$("#iframeFormChangeLanguage").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");

	$("#iframeFormChangeLanguage").unbind("load").bind("load", function() {
		$("#iframeFormChangeLanguage").data("bLoading", false);
		clearTimeout($("#iframeFormChangeLanguage").data("tmLoadingTimer"));

		iframeWindow = window.frames["iframeFormChangeLanguage"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
				
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			var URLPrefix = document.body.getAttribute("data-url-prefix");
			window.location = (URLPrefix + "setup");
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormChangeLanguage").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormChangeLanguage").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormChangeLanguage").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("formChangeLanguage").submit();
}

function doStartRightNowButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormStartRightNow").data("bLoading")) {
		return;
	}

	$("#iframeFormStartRightNow").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");

	$("#iframeFormStartRightNow").unbind("load").bind("load", function() {
		$("#iframeFormStartRightNow").data("bLoading", false);
		clearTimeout($("#iframeFormStartRightNow").data("tmLoadingTimer"));

		iframeWindow = window.frames["iframeFormStartRightNow"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
				
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			var URLPrefix = document.body.getAttribute("data-url-prefix");
			window.location = (URLPrefix + "logins");
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormStartRightNow").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormStartRightNow").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormStartRightNow").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("bStartRightNow").value = 1;	
	document.getElementById("formStartRightNow").submit();
}

function doSaveAccessConfigurationButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormAccessConfiguration").data("bLoading")) {
		return;
	}

	$("#iframeFormAccessConfiguration").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");

	$("#iframeFormAccessConfiguration").unbind("load").bind("load", function() {
		$("#iframeFormAccessConfiguration").data("bLoading", false);
		clearTimeout($("#iframeFormAccessConfiguration").data("tmLoadingTimer"));

		iframeWindow = window.frames["iframeFormAccessConfiguration"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
				
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			hideDialog("divAccessConfiguration");
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormAccessConfiguration").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormAccessConfiguration").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormAccessConfiguration").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("formAccessConfiguration").submit();
}

function doTestFTPConfigurationButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormFTPConfiguration").data("bLoading")) {
		return;
	}

	$("#iframeFormFTPConfiguration").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");

	document.getElementById("spanFTPMessage").style.display = "none";

	$("#iframeFormFTPConfiguration").unbind("load").bind("load", function() {
		$("#iframeFormFTPConfiguration").data("bLoading", false);
		clearTimeout($("#iframeFormFTPConfiguration").data("tmLoadingTimer"));

		iframeWindow = window.frames["iframeFormFTPConfiguration"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
	
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			$("#spanFTPMessage").velocity("stop");
			$("#spanFTPMessage").velocity("fadeIn", 100);
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormFTPConfiguration").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormFTPConfiguration").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

  	$("#iframeFormFTPConfiguration").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("bTestFTPConfiguration").value = 1;
	document.getElementById("bSaveFTPConfiguration").value = 0;
	document.getElementById("formFTPConfiguration").submit();
}

function doSaveFTPConfigurationButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormFTPConfiguration").data("bLoading")) {
		return;
	}

	$("#iframeFormFTPConfiguration").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");

	$("#iframeFormFTPConfiguration").unbind("load").bind("load", function() {
		$("#iframeFormFTPConfiguration").data("bLoading", false);
		clearTimeout($("#iframeFormFTPConfiguration").data("tmLoadingTimer"));

		iframeWindow = window.frames["iframeFormFTPConfiguration"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
				
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			hideDialog("divFTPConfiguration");
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormFTPConfiguration").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormFTPConfiguration").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormFTPConfiguration").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("bTestFTPConfiguration").value = 0;
	document.getElementById("bSaveFTPConfiguration").value = 1;
	document.getElementById("formFTPConfiguration").submit();
}

function doTestDBConfigurationButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormDBConfiguration").data("bLoading")) {
		return;
	}

	$("#iframeFormDBConfiguration").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");

	document.getElementById("spanDBMessage").style.display = "none";

	$("#iframeFormDBConfiguration").unbind("load").bind("load", function() {
		$("#iframeFormDBConfiguration").data("bLoading", false);
		clearTimeout($("#iframeFormDBConfiguration").data("tmLoadingTimer"));

		iframeWindow = top.frames["iframeFormDBConfiguration"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
				
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			$("#spanDBMessage").velocity("stop");
			$("#spanDBMessage").velocity("fadeIn", 100);
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormDBConfiguration").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormDBConfiguration").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormDBConfiguration").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("bTestDBConfiguration").value = 1;
	document.getElementById("bSaveDBConfiguration").value = 0;

	document.getElementById("formDBConfiguration").submit();
}

function doSaveDBConfigurationButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormDBConfiguration").data("bLoading")) {
		return;
	}

	$("#iframeFormDBConfiguration").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");

	$("#iframeFormDBConfiguration").unbind("load").bind("load", function() {
		$("#iframeFormDBConfiguration").data("bLoading", false);
		clearTimeout($("#iframeFormDBConfiguration").data("tmLoadingTimer"));

		iframeWindow = top.frames["iframeFormDBConfiguration"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
				
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			hideDialog("divDBConfiguration");
		} 

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormDBConfiguration").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormDBConfiguration").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormDBConfiguration").data("tmLoadingTimer", tmLoadingTimer);
	
	document.getElementById("bTestDBConfiguration").value = 0;
	document.getElementById("bSaveDBConfiguration").value = 1;
	document.getElementById("formDBConfiguration").submit();
}