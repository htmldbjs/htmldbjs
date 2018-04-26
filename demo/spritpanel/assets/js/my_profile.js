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
	resetProgressBar("Loading...", false, true);
	$(".divFormResult").css("display", "none");

	$("#imgCurrentImage").off("click").on("click", function() {
		prepareCurrentImageForEdit();
		showDialog("divEditCurrentImage");
	});

	$("#buttonChangeCurrentImage").off("click").on("click", function() {
		prepareCurrentImageForEdit();
		showDialog("divEditCurrentImage");
	});

	$(".aChangeImage").off("click").on("click", function() {
		doChangeImageAClick(this);
	});

	$("#buttonCancelObjectDialog").off("click").on("click", function() {
        doCancelObjectButtonClick(this);
    });

    $("#buttonSaveMyProfileForm").off("click").on("click", function() {
		doSaveMyProfileFormButtonClick(this);
	});

	showPage("divMyProfileContent");
	stepProgressBar(100);
}

function doCancelObjectButtonClick(sender) {
    hidePage("divEditCurrentImage");
}

function doSaveMyProfileFormButtonClick(sender) {
	if (!sender) {
		return;
	}

	if (true == $("#iframeFormMyProfile").data("bLoading")) {
		return;
	}

	$("#iframeFormMyProfile").data("bLoading", true);
	var elButton = document.getElementById("buttonSaveMyProfileForm");
	elButton.innerHTML = elButton.getAttribute("data-loading-text");

	$(".divFormResult").velocity("stop");
	$(".divFormResult").css("display", "none");

	$("#iframeFormMyProfile").off("load").on("load", function() {
		$("#iframeFormMyProfile").data("bLoading", false);
		clearTimeout($("#iframeFormMyProfile").data("tmLoadingTimer"));

		iframeWindow = top.frames["iframeFormMyProfile"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());

		
		if (objResponse.errorCount > 0) {
			document.getElementById("pErrorMessage").innerHTML = objResponse.lastError;
			$("#divFormError").velocity("fadeIn", 300);
		} else {
			document.getElementById("pSuccessMessage").innerHTML = objResponse.lastMessage;
			$("#divFormSuccess").velocity("fadeIn", 300);
		}
		
		elButton.innerHTML = elButton.getAttribute("data-default-text");
	});

  // Catch Loading Error
  tmLoadingTimer = setTimeout(function() {
  	if (true == $("#iframeFormMyProfile").data("bLoading")) {
  		elButton.innerHTML = elButton.getAttribute("data-error-text");

  		$("#iframeFormMyProfile").data("bLoading", false);
  		elButton.innerHTML = elButton.getAttribute("data-default-text");
  	}
  }, 5000);

  $("#iframeFormMyProfile").data("tmLoadingTimer", tmLoadingTimer);

  document.getElementById("formMyProfile").submit();
}