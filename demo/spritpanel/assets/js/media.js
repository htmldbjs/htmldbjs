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
	initializeHTMLDB();
	initializeDropzone();

    $("#aDeleteObjects").off("click").on("click", function() {
        deleteObjects();
    });

    $(".buttonPageFABAdd").off("click").on("click", function() {
        doShowCreateDirectoryDialogButtonClick(this);
    });

    $("#buttonCreateDirectory").off("click").on("click", function () {
    	doCreateDirectoryButtonClick(this);
    });

	document.getElementById("buttonPageTopMenuMore").style.display = "inline-block";

	showPage("divMediaContent");
}

function doCreateDirectoryButtonClick(sender) {
	if (!sender) {
		return;
	}

	if ($("#iframeCreateDirectory").data("bLoading")) {
		return;
	}
        
	$("#iframeCreateDirectory").data("bLoading", true);

	$("#iframeCreateDirectory").unbind("load").bind("load", function() {

		$("#iframeCreateDirectory").data("bLoading", false);

		iframeWindow = top.frames["iframeCreateDirectory"];

		var objResponse = JSON.parse(String(iframeWindow.document.body.innerHTML).trim());

		if (objResponse.errorCount > 0) { 
			showErrorDialog(objResponse.lastError);
		} else {

			document.getElementById("ulUploadedFiles").innerHTML = "";
			document.getElementById("divMediaHTMLDB_tbody").innerHTML = "";

			HTMLDB.read("divMediaHTMLDB", true);

			$("#ulUploadedFiles").velocity("stop");
			$("#ulUploadedFiles").velocity("transition.slideUpIn", 500);

			hideDialog("divCreateDirectoryDialog");
		}

	});

	document.getElementById("formCreateDirectory").submit();
}

function doShowCreateDirectoryDialogButtonClick(sender) {
	if (!sender) {
		return;
	}

	document.getElementById("formCreateDirectory").reset();

	showDialog("divCreateDirectoryDialog");
}

function initializeDropzone() {
	var URLPrefix = document.body.getAttribute("data-url-prefix");

	$("#buttonUploadMedia").bind("click", function () {
		doUploadButtonClick(this);
	})

	var dropzoneElements = $("div.divDropzone");
	var dropzoneElement = null;
	var dropzoneElementCount = dropzoneElements.length;
	var dropzoneObject = null;

	for (var i = 0; i < dropzoneElementCount; i++) {
		dropzoneElement = dropzoneElements[i];
		dropzoneObject = new Dropzone(dropzoneElement, {
			"url": (URLPrefix + "media/formupload"),
			"addedfile": function (file) {
				uploadFile(file, 1);
				return false;
			}
		});
	}
}

function initializeHTMLDB() {

	var URLPrefix = document.body.getAttribute("data-url-prefix");

	HTMLDB.initialize({
		elementID:"divSessionHTMLDB",
		readURL:(URLPrefix + "media/readsession"),
		readAllURL:(URLPrefix + "media/readsession"),
		writeURL:(URLPrefix + "media/writesession"),
		autoRefresh:0,
		startupDelay:0,
		renderElements:null,
		onReadAll:null,
		onWrite:null,
		onRenderAll:null
	});

	HTMLDB.initialize({
		elementID:"divMediaHTMLDB",
		readURL:(URLPrefix + "media/readmedia"),
		readAllURL:(URLPrefix + "media/readmedia"),
		writeURL:"",
		autoRefresh:0,
		startupDelay:0,
		renderElements:null,
		onReadAll:doMediaHTMLDBReadAll,
		onWrite:null,
		onRenderAll:null
	});

}
function doMediaHTMLDBReadAll(sender) {
	if (!sender) {
		return;
	}

	document.body.setAttribute("data-loading", "0");

	var strContentHTML = document.getElementById("ulUploadedFilesTemplate").innerHTML;
	var strULHTML = "";
	var strLIHTML = "";

	var elementTBODY = document.getElementById("divMediaHTMLDB_tbody");
	var arrTR = $(">tr", elementTBODY);
	var elTR = null;
	var lTRCount = arrTR.length;
	var lID = "";

	for (var i = 0; i < lTRCount; i++) {
		elTR = arrTR[i];
		lID = parseInt(elTR.getAttribute("data-row-id"));

		strLIHTML = strContentHTML;

		strLIHTML = strLIHTML.replace(/__GUID__/g, lID);
		strLIHTML = strLIHTML.replace(/__FILE_NAME__/g,
				document.getElementById("divMediaHTMLDB_td"
				+ lID
				+ "name").innerHTML);

		if (parseInt(document.getElementById("divMediaHTMLDB_td"
				+ lID
				+ "directory").innerHTML) > 0) {

			strLIHTML = strLIHTML.replace(/__FILE_SIZE__/g,
					document.getElementById(
					"divDirectoryLinkTemplate").getAttribute(
					"data-directory-description"));

			strLIHTML = strLIHTML.replace(/__FILE_NAME_CLASS__/g, "aMediaDirectory");
			strLIHTML = strLIHTML.replace(/__FILE_LINK_TARGET__/g, "");
			strLIHTML = strLIHTML.replace(/__MEDIA_TYPE__/g, "0");

		} else {

			strLIHTML = strLIHTML.replace(/__FILE_SIZE__/g,
					humanFileSize(
					parseInt(
					document.getElementById(
					"divMediaHTMLDB_td"
					+ lID
					+ "fileSize").innerHTML)));

			var imageFile = parseInt(
					document.getElementById(
					"divMediaHTMLDB_td"
					+ lID
					+ "image").innerHTML)

			if (imageFile) {
				strLIHTML = strLIHTML.replace(/__FILE_NAME_CLASS__/g, "aMediaFile aMediaImage");
				strLIHTML = strLIHTML.replace(/__MEDIA_TYPE__/g, "2");
			} else {
				strLIHTML = strLIHTML.replace(/__FILE_NAME_CLASS__/g, "aMediaFile");
				strLIHTML = strLIHTML.replace(/__MEDIA_TYPE__/g, "1");
			}

			strLIHTML = strLIHTML.replace(/__FILE_LINK_TARGET__/g, "_blank");

		}

		strULHTML += strLIHTML;
	}

	// Current Directory
	var sessionObject = HTMLDB.get("divSessionHTMLDB", 1);
	var sessionCurrentDirectory = sessionObject["currentDirectory"];
	var parentDirectories = sessionCurrentDirectory.split("/");
	var parentDirectoryCount = parentDirectories.length;
	var strCurrentDirectoryLIHTML
			= document.getElementById("ulFilesCurrentDirectoryTemplate").innerHTML;
	var directoryLinksHTML = "";
	var directoryLinkTemplate = document.getElementById("divDirectoryLinkTemplate").innerHTML;
	var currentDirectoryURL = "";

	if (sessionCurrentDirectory != "") {
		directoryLinksHTML += directoryLinkTemplate;
		directoryLinksHTML = directoryLinksHTML.replace(/__DIRECTORY_NAME__/g, "media");
		directoryLinksHTML = directoryLinksHTML.replace(/__DIRECTORY_URL__/g, "");
	}

	for (var i = 0; i < parentDirectoryCount - 1; i++) {
		directoryLinksHTML += directoryLinkTemplate;
		directoryLinksHTML = directoryLinksHTML.replace(/__DIRECTORY_NAME__/g, parentDirectories[i]);

		if (currentDirectoryURL != "") {
			currentDirectoryURL += "/";
		}

		currentDirectoryURL += parentDirectories[i];
		directoryLinksHTML = directoryLinksHTML.replace(/__DIRECTORY_URL__/g, currentDirectoryURL);
	}

	if (sessionCurrentDirectory != "") {
		directoryLinksHTML += parentDirectories[parentDirectoryCount - 1];

		strCurrentDirectoryLIHTML
				= strCurrentDirectoryLIHTML.replace(/__BLANK__/g, "");
		strCurrentDirectoryLIHTML
				= strCurrentDirectoryLIHTML.replace(/__DIRECTORY_LINKS__/g,
				directoryLinksHTML);
	} else {
		strCurrentDirectoryLIHTML
				= strCurrentDirectoryLIHTML.replace(/__BLANK__/g, "");
		strCurrentDirectoryLIHTML
				= strCurrentDirectoryLIHTML.replace(/__DIRECTORY_LINKS__/g,
				"media");
	}

	var elUL = document.getElementById("ulUploadedFiles");

	elUL.innerHTML = strCurrentDirectoryLIHTML + strULHTML;

	var mediaElement = null;

	for (var i = 0; i < lTRCount; i++) {
		elTR = arrTR[i];
		lID = parseInt(elTR.getAttribute("data-row-id"));

		mediaElement = document.getElementById("aMedia" + lID);

		if ($(mediaElement).hasClass("aMediaFile")) {

			mediaElement.href
					= "../"
					+ document.getElementById("divMediaHTMLDB_td"
					+ lID
					+ "URL").innerHTML;

		}

		mediaElement = document.getElementById("aMediaImage" + lID);

		if ($(mediaElement).hasClass("aMediaFile")) {

			mediaElement.href
					= "../"
					+ document.getElementById("divMediaHTMLDB_td"
					+ lID
					+ "URL").innerHTML;

		}

		if (document.getElementById("divMediaHTMLDB_td"
				+ lID
				+ "imageURL").innerHTML != "") {
	
			document.getElementById("imgMedia" + lID).src
					= document.getElementById("imgMedia" + lID).getAttribute("data-img-directory")
					+ document.getElementById("divMediaHTMLDB_td"
					+ lID
					+ "imageURL").innerHTML;
	
		} else {
			var elElement = document.getElementById("aMediaImage" + lID);
			elElement.parentNode.removeChild(elElement);

			elElement = document.getElementById("imgMedia" + lID);
			elElement.parentNode.removeChild(elElement);
		}
	}

	// Delete and Re-create File Input So That It Can Accept New Files
	var strInputHTML = document.getElementById("divInputUploaderTemplate").innerHTML;
	strInputHTML = strInputHTML.replace(/__BLANK__/g, "");
	document.getElementById("divUploaderInputContainer").innerHTML = strInputHTML;

	$("#inputUploadMedia").bind("change", function(evEvent) {
		doUploaderInputChange(this, evEvent);
	});

	$("#buttonUpload").removeClass("disabled");

	initializeObjects();
	updateObjectListStatistics();
}
function initializeObjects() {
	var elementUL = document.getElementById("ulUploadedFiles");

	$(".aMediaDirectory", elementUL).off("click").on("click", function () {
		doDirectoryLinkClick(this);
	});

    $("#bSelectObjects").off("click").on("click", function () {
        doSelectObjectsCheckboxAllClick(this);
    });

    $(".bSelectObject").off("click").on("click", function () {
        doSelectObjectCheckboxClick(this);
    });

}
function doDirectoryLinkClick(sender) {
	if (!sender) {
		return;
	}

	if ("1" == document.body.getAttribute("data-loading")) {
		return;
	}

	document.body.setAttribute("data-loading", "1");
	var sessionObject = HTMLDB.get("divSessionHTMLDB", 1);

	if ($(sender).hasClass("aCurrentDirectory")) {
		sessionObject["currentDirectory"] = sender.getAttribute("data-directory-url");
	} else {
		if (sessionObject["currentDirectory"] != "") {
			sessionObject["currentDirectory"] += "/";
		}

		sessionObject["currentDirectory"] += sender.getAttribute("data-directory-url");
	}

	$("#ulUploadedFiles").css("display", "none");

	document.getElementById("ulUploadedFiles").innerHTML = "";
	document.getElementById("divMediaHTMLDB_tbody").innerHTML = "";

	HTMLDB.update("divSessionHTMLDB", 1, sessionObject);
	HTMLDB.write("divSessionHTMLDB", false, function () {
		HTMLDB.read("divSessionHTMLDB", true);
		HTMLDB.read("divMediaHTMLDB", true);

		$("#ulUploadedFiles").velocity("stop");
		$("#ulUploadedFiles").velocity("transition.slideUpIn", 500);
	});
}
function doUploadButtonClick(sender) {
	if (!sender) {
		return;
	}

	$("#divDropzone").trigger("click");
}
function doUploaderInputChange(sender, evEvent) {
	if (!sender) {
		return;
	}

	uploadFile(evEvent.target.files[0]);
}
function uploadFile(objFile) {
	var xhr = new XMLHttpRequest();

	if (objFile.size > document.getElementById("MAX_FILE_SIZE").value) {
		return false;
	}

	$("#buttonUpload").addClass("disabled");

	var strUploaderGUID = generateGUID("");
	createUploaderLI(objFile, strUploaderGUID);

	if (xhr.upload) {
		var elProgressDIV = document.getElementById("divProgressBar" + strUploaderGUID);
		elProgressDIV.style.width = "85%";

		// progress bar
		xhr.upload.addEventListener("progress", function(e) {
			var lWidth = parseInt((e.loaded / e.total) * 100);
			elProgressDIV.style.width = (lWidth + "%");
		}, false);

		// file received/failed
		xhr.onreadystatechange = function(e) {
			if (xhr.readyState == 4) {
				var objResponse = JSON.parse(String(xhr.responseText).trim());

				if (objResponse.errorCount > 0) {      
					showErrorDialog(objResponse.lastError);
				}

				HTMLDB.read("divMediaHTMLDB", true);
			}
		};

		var fdFormData = new FormData();
		fdFormData.append("filMedia", objFile);

		// start upload
		xhr.open("POST", document.getElementById("formUpload").action, true);
		xhr.send(fdFormData);
	}
}
function createUploaderLI(objFile, strGUID) {
	var strContentHTML = document.getElementById("ulFilesToUploadTemplate").innerHTML;

	strContentHTML = strContentHTML.replace(/__GUID__/g, strGUID);
	strContentHTML = strContentHTML.replace(/__FILE_NAME__/g, objFile.name);
	strContentHTML = strContentHTML.replace(/__FILE_SIZE__/g, humanFileSize(objFile.size));

	document.getElementById("ulUploadedFiles").innerHTML = strContentHTML
			+ document.getElementById("ulUploadedFiles").innerHTML;
}
function updateObjectListStatistics() {
	var elementUL = document.getElementById("ulUploadedFiles");
    var objectCount = ($(">li", elementUL).length - 1);
    var checkedCount = $("#ulUploadedFiles .imageCheckbox:checked").length;
    var listTemplate = document.getElementById("h4PageHeader").getAttribute("data-list-template");
    var selectionTemplate = document.getElementById("h4PageHeader").getAttribute("data-selection-template");
    var infoText = "";

    document.getElementById("h4PageHeader").innerHTML = "";

    if (objectCount > 0) {
        listTemplate = listTemplate.replace(/%1/g, objectCount);
        infoText = listTemplate;

        document.getElementById("h4PageHeader").innerHTML = infoText;
    }

    if (checkedCount > 0) {
        selectionTemplate = selectionTemplate.replace(/%1/g, checkedCount);
        infoText = selectionTemplate;

        document.getElementById("h4PageHeader").innerHTML += infoText;        
    }
}
function doSelectObjectCheckboxClick(sender) {
    if (!sender) {
        return;
    }

    var bChecked = sender.checked;

    var lCheckedCheckboxCount = 0;
    lCheckedCheckboxCount = $("#ulUploadedFiles .bSelectObject:checked").length;

    if (0 == lCheckedCheckboxCount) {
        $(".spanSelection").html("");
    } else {
        $(".spanSelection").html(" (" + lCheckedCheckboxCount + ")");
    }

    var lCheckboxCount = $("#ulUploadedFiles .bSelectObject").length;

    if (lCheckboxCount == lCheckedCheckboxCount) {
        document.getElementById("bSelectObjects").checked = true;
    } else {
        document.getElementById("bSelectObjects").checked = false;
    }

    updateObjectListStatistics();
}
function doSelectObjectsCheckboxAllClick(sender) {
    if (!sender) {
        return;
    }

    var bChecked = sender.checked;

    var arrInputs = $(".bSelectObject");
    var lCountInput = arrInputs.length;
    var elInput = null;

    if (bChecked) {
        for (var i = 0; i < lCountInput; i++) {
            elInput = arrInputs[i];
            elInput.checked = true;
            $(elInput.parentNode.parentNode).addClass("checkedTR");
        }
    } else {
        for (var i = 0; i < lCountInput; i++) {
            elInput = arrInputs[i];
            elInput.checked = false;
            $(elInput.parentNode.parentNode).removeClass("checkedTR");
        }
    }

    var lCheckedCheckboxCount = 0;
    lCheckedCheckboxCount = $("#ulUploadedFiles .bSelectObject:checked").length;

    if (0 == lCheckedCheckboxCount) {
        $(".spanSelection").html("");
    } else {
        $(".spanSelection").html(" (" + lCheckedCheckboxCount + ")");
    }

    updateObjectListStatistics();
}
function deleteObjects() {
    
    var lSelectedObjectCount = $("#ulUploadedFiles  .bSelectObject:checked").length;

    if (0 == lSelectedObjectCount) {
        return false;
    }

    $("#spanDeleteSelection").html("\"" + lSelectedObjectCount + "\"");

    if (lSelectedObjectCount > 1) {
        document.getElementById("spanPluralSuffix").style.display = "inline-block";
    } else {
        document.getElementById("spanPluralSuffix").style.display = "none";
    }

    var arrCheckedCheckboxes = $("#ulUploadedFiles .bSelectObject:checked");
    var lCheckedCheckboxesCount = arrCheckedCheckboxes.length;
    var strObjectIDCSV = "";

    for (var i = 0; i < lCheckedCheckboxesCount; i++) {
        if ("" != strObjectIDCSV) {
            strObjectIDCSV += ",";
        }
        strObjectIDCSV += arrCheckedCheckboxes[i].getAttribute("data-object-id");
    }

    document.getElementById("buttonDeleteConfirm").setAttribute("data-object-id-csv", strObjectIDCSV);    

    $("#buttonDeleteConfirm").off("click").on("click", function() {
        doDeleteConfirmButtonClick(this);
    });

    showDialog("divDeleteDialog");
}
function doDeleteCancelButtonClick(sender) {
    hideDialog("divDeleteDialog");
}
function doDeleteConfirmButtonClick(sender) {
	if ($("#iframeDeleteMedia").data("bLoading")) {
		return;
	}

    var strObjectIDCSV = sender.getAttribute("data-object-id-csv");
    var arrObjectIDs = strObjectIDCSV.split(",");
    var lObjectIDCount = arrObjectIDs.length;

    var deletedFileNames = "";

    for (var i = 0; i < lObjectIDCount; i++) {
        if (deletedFileNames != "") {
        	deletedFileNames += "/";
        }

        deletedFileNames += document.getElementById("bSelectObject" + arrObjectIDs[i]).value;
    }
    
    $(".spanSelection").html("");
    
    document.getElementById("deletedFileNames").value = deletedFileNames;

	$("#iframeDeleteMedia").data("bLoading", true);

    resetProgressBar(
            document.getElementById("iframeDeleteMedia").getAttribute("data-loading-text"),
            false,
            true);

	$("#iframeDeleteMedia").unbind("load").bind("load", function() {

		$("#iframeDeleteMedia").data("bLoading", false);

		document.getElementById("ulUploadedFiles").innerHTML = "";
		document.getElementById("divMediaHTMLDB_tbody").innerHTML = "";

		HTMLDB.read("divSessionHTMLDB", true);
		HTMLDB.read("divMediaHTMLDB", true);

		$("#ulUploadedFiles").velocity("stop");
		$("#ulUploadedFiles").velocity("transition.slideUpIn", 500);

		stepProgressBar(100);
	});

	document.getElementById("formDeleteMedia").submit();

    hideDialog("divDeleteDialog");
}