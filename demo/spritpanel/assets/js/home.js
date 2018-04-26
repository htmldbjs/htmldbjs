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

	showCacheAllDialogIfRequired();

	$(".aCacheClassListSelectAll").off("click").on("click", function () {
		doCacheClassListSelectAllLinkClick(this);
	});

	$(".aCacheClassListSelectNone").off("click").on("click", function () {
		doCacheClassListSelectNoneLinkClick(this);
	});

	$("#buttonStartCacheProcess").off("click").on("click", function () {
		doStartCacheProcessButtonClick(this);
	});

}

function doStartCacheProcessButtonClick(sender) {
	beginCacheProcess();
}

function beginCacheProcess() {

    var urlPrefix = document.body.getAttribute("data-url-prefix");
    var ajaxURL = urlPrefix + "cache_manager/start";
    var dtNow = new Date();
	var checkboxes = $("#divCacheClassList .inputCacheClass:checked");
	var checkboxCount = checkboxes.length;
	var checkbox = null;

    $("#divCacheClassListContainer").velocity("stop");
    document.getElementById("divCacheClassListContainer").style.display = "none";
    $("#divCacheProcessContainer").velocity("stop");
    $("#divCacheProcessContainer").velocity("transition.slideUpBigIn", 300);

	if (0 == checkboxCount) {
		showErrorDialog("Please choose at least one class to be cached.");
		return false;
	}

	var classCSV = "";

	for (var i = 0; i < checkboxCount; i++) {

		checkbox = checkboxes[i];

		if (i > 0) {
			classCSV += ",";
		}

		classCSV += checkbox.value;

	}

    ajaxURL += ("/" + classCSV + "/nocache" + dtNow.getTime());

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {

        if (this.readyState == 4){

            if (404 == this.status) {

                throw(new Error(ajaxURL + " not found on the server."));
                return false;

            }

            stepCacheProcess();

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

function stepCacheProcess() {

    var urlPrefix = document.body.getAttribute("data-url-prefix");
    var ajaxURL = urlPrefix + "cache_manager/step";
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

            if (response.completed && (1 == response.completed)) {
                endCacheProcess();
            } else {

                updateCacheProgress(response);
                stepCacheProcess();

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

function updateCacheProgress(response) {

    var checkboxes = $("#divCacheClassListContainer .inputCacheClass:checked");
    var checkboxCount = checkboxes.length;
    var modelName = "";

    if (response.model_index < checkboxCount) {
        modelName = checkboxes[response.model_index].value;
    }

    var minorWidth = parseInt(response.model_row_index / (response.model_row_count + 1) * 100);
    var majorWidth = parseInt(response.model_index / (response.model_count) * 100);

    document.getElementById("divCacheProcessMinorProgressBar").setAttribute("data-progress", minorWidth);
    document.getElementById("divCacheProcessMinorProgressBar").style.width = (minorWidth + "%");
    document.getElementById("divCacheProcessMajorProgressBar").setAttribute("data-progress", majorWidth);
    document.getElementById("divCacheProcessMajorProgressBar").style.width = (majorWidth + "%");

    var template = document.getElementById("pCacheProcessMinorProgressText").getAttribute("data-template-text");
    var content = template;
    content = content.replace(/%1/g, (response.model_row_index + 1));
    content = content.replace(/%2/g, ((0 == response.model_row_count) ? 1 : response.model_row_count));
    document.getElementById("pCacheProcessMinorProgressText").innerHTML = content;

    template = document.getElementById("pCacheProcessMajorProgressText").getAttribute("data-template-text");
    content = template;
    content = content.replace(/%1/g, modelName);
    content = content.replace(/%2/g, (response.model_index + 1));
    content = content.replace(/%3/g, (response.model_count));
    document.getElementById("pCacheProcessMajorProgressText").innerHTML = content;

}

function endCacheProcess() {

    document.getElementById("divCacheProcessMinorProgressBar").setAttribute("data-progress", 100);
    document.getElementById("divCacheProcessMinorProgressBar").style.width = ("100%");
    document.getElementById("divCacheProcessMajorProgressBar").setAttribute("data-progress", 100);
    document.getElementById("divCacheProcessMajorProgressBar").style.width = ("100%");

    document.getElementById("pCacheProcessMinorProgressText").innerHTML
            = document.getElementById("pCacheProcessMinorProgressText").getAttribute("data-completed-text");
    document.getElementById("pCacheProcessMajorProgressText").innerHTML
            = document.getElementById("pCacheProcessMajorProgressText").getAttribute("data-completed-text");

    $("#divCacheProcessCloseButtonContainer").velocity("stop");
    $("#divCacheProcessCloseButtonContainer").velocity("transition.fadeIn", 300);

}

function doCacheClassListSelectAllLinkClick(sender) {
	$("#divCacheClassList .inputCacheClass").prop("checked", true);
}

function doCacheClassListSelectNoneLinkClick(sender) {
	$("#divCacheClassList .inputCacheClass").prop("checked", false);
}

function showCacheAllDialogIfRequired() {

	var cacheAllRequired = parseInt(document.body.getAttribute("data-cache-all-required"));

	if (cacheAllRequired > 0) {

        checkFTPConnection(function () {
            checkMySQLConnection(function () {

                initializeCacheAllDialog();
                showDialog("divCacheAllDialog");

            });
        });

	}

}

function initializeCacheAllDialog() {

    var urlPrefix = document.body.getAttribute("data-url-prefix");
    var ajaxURL = urlPrefix + "cache_manager/status";
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
            renderCacheClassList(response);

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

function renderCacheClassList(response) {

	var classCount = response.class_list.length;
	var content = "";
	var template = document.getElementById("divCacheClassListTemplate").innerHTML;
	var currentContent = "";

	for (var i = 0; i < classCount; i++) {

		currentContent = template;
		currentContent = currentContent.replace(/__CLASS_NAME__/g, response.class_list[i]);
		content += currentContent;

	}

	document.getElementById("divCacheClassList").innerHTML = content;

	$("#divCacheClassListLoaderContainer").velocity("stop");
	document.getElementById("divCacheClassListLoaderContainer").style.display = "none";
	$("#divCacheClassListContainer").velocity("stop");
	$("#divCacheClassListContainer").velocity("transition.slideUpBigIn", 300);

}