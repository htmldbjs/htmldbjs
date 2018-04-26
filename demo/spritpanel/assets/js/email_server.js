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
	showPage("divEmailConfigurationContent");

	$(".selectSelectizeSingle").selectize();

	$("#buttonTestSMTP").click(function() {
		doTestSMTPButtonClick(this);
	});

	$("#buttonSaveEmailConfiguration").click(function() {
		doSaveEmailConfigurationButtonClick(this);
	});

	refreshShowHideElements();
}


// ----------------
// Helper Functions
// ----------------

function doTestSMTPButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormEmailConfiguration").data("bLoading")) {
		return;
	}

	$("#iframeFormEmailConfiguration").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");
	document.getElementById("spanEmailTestMessage").style.display = "none";
	document.getElementById("spanEmailSaveMessage").style.display = "none";

	$("#iframeFormEmailConfiguration").unbind("load").bind("load", function() {
		$("#iframeFormEmailConfiguration").data("bLoading", false);
		clearTimeout($("#iframeFormEmailConfiguration").data("tmLoadingTimer"));

		iframeWindow = top.frames["iframeFormEmailConfiguration"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
				
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			$("#spanEmailTestMessage").velocity("stop");
			$("#spanEmailTestMessage").velocity("fadeIn", 100);
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormEmailConfiguration").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormEmailConfiguration").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormEmailConfiguration").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("bTestSMTP").value = 1;
	document.getElementById("bSaveEmailConfiguration").value = 0;

	document.getElementById("formEmailConfiguration").submit();
}

function doSaveEmailConfigurationButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormEmailConfiguration").data("bLoading")) {
		return;
	}

	checkFTPConnection(function () {

		$("#iframeFormEmailConfiguration").data("bLoading", true);
		sender.innerHTML = sender.getAttribute("data-loading-text");
		document.getElementById("spanEmailTestMessage").style.display = "none";
		document.getElementById("spanEmailSaveMessage").style.display = "none";

		$("#iframeFormEmailConfiguration").unbind("load").bind("load", function() {

			$("#iframeFormEmailConfiguration").data("bLoading", false);
			clearTimeout($("#iframeFormEmailConfiguration").data("tmLoadingTimer"));
			iframeWindow = top.frames["iframeFormEmailConfiguration"];

			var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());

			if (objResponse.errorCount > 0) { 
				showErrorDialog(objResponse.lastError);
			} else {

				$("#spanEmailSaveMessage").velocity("stop");
				$("#spanEmailSaveMessage").velocity("fadeIn", 100);

			} 

			sender.innerHTML = sender.getAttribute("data-default-text");

		});

		// Catch Loading Error
		tmLoadingTimer = setTimeout(function() {

			if (true == $("#iframeFormEmailConfiguration").data("bLoading")) {

				sender.innerHTML = sender.getAttribute("data-error-text");
				$("#iframeFormEmailConfiguration").data("bLoading", false);
				sender.innerHTML = sender.getAttribute("data-default-text");

			}

		}, 5000);

		$("#iframeFormEmailConfiguration").data("tmLoadingTimer", tmLoadingTimer);
		
		document.getElementById("bTestSMTP").value = 0;
		document.getElementById("bSaveEmailConfiguration").value = 1;
		document.getElementById("formEmailConfiguration").submit();

	});

}