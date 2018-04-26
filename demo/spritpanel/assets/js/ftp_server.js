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
	showPage("divFTPServerContent");
	$(".selectSelectizeSingle").selectize();
	
	$("#buttonTestFTPServer").click(function() {
		doTestFTPServerButtonClick(this);
	});

	$("#buttonSaveFTPServer").click(function() {
		doSaveFTPServerButtonClick(this);
	});
}

function doTestFTPServerButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormFTPServer").data("bLoading")) {
		return;
	}

	$("#iframeFormFTPServer").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");
	document.getElementById("spanFTPTestMessage").style.display = "none";
	document.getElementById("spanFTPSaveMessage").style.display = "none";

	$("#iframeFormFTPServer").unbind("load").bind("load", function() {
		$("#iframeFormFTPServer").data("bLoading", false);
		clearTimeout($("#iframeFormFTPServer").data("tmLoadingTimer"));

		iframeWindow = window.frames["iframeFormFTPServer"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
	
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			$("#spanFTPTestMessage").velocity("stop");
			$("#spanFTPTestMessage").velocity("fadeIn", 100);
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormFTPServer").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormFTPServer").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

  	$("#iframeFormFTPServer").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("bTestFTPServer").value = 1;
	document.getElementById("bSaveFTPServer").value = 0;
	document.getElementById("formFTPServer").submit();
}

function doSaveFTPServerButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormFTPServer").data("bLoading")) {
		return;
	}

	$("#iframeFormFTPServer").data("bLoading", true);
	sender.innerHTML = sender.getAttribute("data-loading-text");
	document.getElementById("spanFTPTestMessage").style.display = "none";
	document.getElementById("spanFTPSaveMessage").style.display = "none";

	$("#iframeFormFTPServer").unbind("load").bind("load", function() {
		$("#iframeFormFTPServer").data("bLoading", false);
		clearTimeout($("#iframeFormFTPServer").data("tmLoadingTimer"));

		iframeWindow = window.frames["iframeFormFTPServer"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());
				
		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {
			$("#spanFTPSaveMessage").velocity("stop");
			$("#spanFTPSaveMessage").velocity("fadeIn", 100);
		}

		sender.innerHTML = sender.getAttribute("data-default-text");
	});

	// Catch Loading Error
	tmLoadingTimer = setTimeout(function() {
		if (true == $("#iframeFormFTPServer").data("bLoading")) {
			sender.innerHTML = sender.getAttribute("data-error-text");

			$("#iframeFormFTPServer").data("bLoading", false);
			sender.innerHTML = sender.getAttribute("data-default-text");
		}
	}, 5000);

	$("#iframeFormFTPServer").data("tmLoadingTimer", tmLoadingTimer);

	document.getElementById("bTestFTPServer").value = 0;
	document.getElementById("bSaveFTPServer").value = 1;
	document.getElementById("formFTPServer").submit();
}