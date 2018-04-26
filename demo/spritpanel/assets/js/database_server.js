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
	showPage("divDatabaseContent");

	$(".selectSelectizeSingle").selectize();

	$("#buttonTestDatabase").click(function() {
		doTestDatabaseButtonClick(this);
	});

	$("#buttonSaveDatabase").click(function() {
		doSaveDatabaseButtonClick(this);
	});

	refreshShowHideElements();
}

// ----------------
// Helper Functions
// ----------------

function doTestDatabaseButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormDatabase").data("bLoading")) {
		return;
	}

	$("#iframeFormDatabase").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");
	document.getElementById("spanDatabaseTestMessage").style.display = "none";
	document.getElementById("spanDatabaseSaveMessage").style.display = "none";

	$("#iframeFormDatabase").unbind("load").bind("load", function() {
		$("#iframeFormDatabase").data("bLoading", false);
		clearTimeout($("#iframeFormDatabase").data("tmLoadingTimer"));

		iframeWindow = top.frames["iframeFormDatabase"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());

		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			$("#spanDatabaseTestMessage").velocity("stop");
			$("#spanDatabaseTestMessage").velocity("fadeIn", 100);
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormDatabase").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormDatabase").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormDatabase").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("bTestDatabase").value = 1;
	document.getElementById("bSaveDatabase").value = 0;

	document.getElementById("formDatabase").submit();
}

function doSaveDatabaseButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormDatabase").data("bLoading")) {
		return;
	}

	checkFTPConnection(function () {

		$("#iframeFormDatabase").data("bLoading", true);
		sender.innerHTML = sender.getAttribute("data-loading-text");
		document.getElementById("spanDatabaseTestMessage").style.display = "none";
		document.getElementById("spanDatabaseSaveMessage").style.display = "none";

		$("#iframeFormDatabase").unbind("load").bind("load", function() {

			$("#iframeFormDatabase").data("bLoading", false);
			clearTimeout($("#iframeFormDatabase").data("tmLoadingTimer"));

			iframeWindow = top.frames["iframeFormDatabase"];

			var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
					
			if (objResponse.errorCount > 0) { 
				showErrorDialog(objResponse.lastError);
			} else {

				$("#spanDatabaseSaveMessage").velocity("stop");
				$("#spanDatabaseSaveMessage").velocity("fadeIn", 100);

			} 

			sender.innerHTML = sender.getAttribute("data-default-text");

		});

		// Catch Loading Error
		tmLoadingTimer = setTimeout(function() {

			if (true == $("#iframeFormDatabase").data("bLoading")) {

				sender.innerHTML = sender.getAttribute("data-error-text");
				$("#iframeFormDatabase").data("bLoading", false);
				sender.innerHTML = sender.getAttribute("data-default-text");

			}

		}, 5000);

		$("#iframeFormDatabase").data("tmLoadingTimer", tmLoadingTimer);
		
		document.getElementById("bTestDatabase").value = 0;
		document.getElementById("bSaveDatabase").value = 1;
		document.getElementById("formDatabase").submit();

	});

}