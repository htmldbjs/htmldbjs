$(function() {
	initializeMediaHTMLDB();
	initializeMediaDialogs();
	initializeDropzone();
});
function initializeMediaHTMLDB() {

	var URLPrefix = document.body.getAttribute("data-url-prefix");
	
	HTMLDB.initialize({
        elementID:"divMediaSessionHTMLDB",
        readURL:(URLPrefix + "uploadtaskphoto/readsession"),
        readAllURL:(URLPrefix + "uploadtaskphoto/readsession"),
        writeURL:(URLPrefix + "uploadtaskphoto/writesession"),
        writeDelay:1000,
        autoRefresh:0,
        renderElements:[],
        onReadAll:doMediaSessionHTMLDBRead,
        onRead:doMediaSessionHTMLDBRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

}
function doMediaSessionHTMLDBRead() {

	var URLPrefix = document.body.getAttribute("data-url-prefix");

	HTMLDB.initialize({
		elementID:"divMediaHTMLDB",
		readURL:(URLPrefix + "uploadtaskphoto/readmedia"),
		readAllURL:(URLPrefix + "uploadtaskphoto/readmedia/all"),
		writeURL:"",
		writeDelay:1000,
		autoRefresh:0,
		renderElements:[],
		onReadAll:doMediaHTMLDBRead,
		onRead:doMediaHTMLDBRead,
		onWrite:null,
		onRender:null,
		onRenderAll:null
	});

}
function doAddTaskPhotoButtonClick(sender) {
    if (!sender) {
        return;
    }
	
	rowId = sender.getAttribute("data-row-id");
	document.getElementById("uploadPhotoTaskId").value = rowId;

	setHTMLDBFieldContents("divApplicationTaskHTMLDBReader", rowId);
    setHTMLDBFieldValues("divApplicationTaskHTMLDBReader", rowId);
	setHTMLDBFieldAttributes("divApplicationTaskHTMLDBReader", rowId);

	document.getElementById("uploaderActiveClass").value = "Task";

	setFileListUL("ulTaskPhotosFileList");
	showDialog("divPhotoDialogTask");
}

function doAddSubTaskPhotoButtonClick(sender) {
    if (!sender) {
        return;
    }
	
	rowId = sender.getAttribute("data-row-id");
	document.getElementById("uploadPhotoSubTaskId").value = rowId;

	setHTMLDBFieldContents("divApplicationSubTaskHTMLDBReader", rowId);
    setHTMLDBFieldValues("divApplicationSubTaskHTMLDBReader", rowId);
	setHTMLDBFieldAttributes("divApplicationSubTaskHTMLDBReader", rowId);

	document.getElementById("uploaderActiveClass").value = "SubTask";

	setFileListUL("ulSubTaskPhotosFileList");
	showDialog("divPhotoDialogSubTask");
}

function initializeMediaDialogs() {
	$(".buttonBrowseFile").off("click").on("click", function () {
		doBrowseFileButtonClick(this);
	});

	$("#buttonSelectMedia").off("click").on("click", function () {
		doSelectMediaButtonClick(this);
	});
}
function doSelectMediaButtonClick(element) {
	if (!element) {
		return;
	}

    var checkedCheckboxCount = 0;
    checkedCheckboxCount = $("#ulUploadedFiles .bSelectMediaObject:checked").length;

    if (0 == checkedCheckboxCount) {
    	return;
    }

    var checkedMediaList = $("#ulUploadedFiles .bSelectMediaObject:checked");
    var checkedMedia = null;
    var generatedLIHTML = "";
    var generatedULHTML = "";
    var id = 0;
    var fileGUID = "";
    var targetFileList = document.getElementById("divUploadTaskPhotoDialog").getAttribute("data-target-file-list");
    var targetFileListElement = document.getElementById(targetFileList);
    var inputElement = document.getElementById(targetFileListElement.getAttribute("data-target-input-id"));
    var maxFileCount = parseInt(inputElement.getAttribute("data-max-file-count"));
    var elementLI = null;
    var fileCount = $(">li", targetFileListElement).length;
    var fileName = "";

    for (var i = 0; i < checkedCheckboxCount; i++) {
    	checkedMedia = checkedMediaList[i];

    	elementLI = checkedMedia.parentNode.parentNode.parentNode;

    	id = elementLI.getAttribute("data-guid");

    	fileGUID = md5(targetFileList
    			+ ":"
    			+ document.getElementById("aMedia" + id).innerHTML);

    	if (document.getElementById("liFileListItem" + fileGUID)) {
    		continue;
    	}

    	if ((maxFileCount > 0) && (fileCount >= maxFileCount)) {
    		continue;
    	}

    	fileName = document.getElementById("divMediaSessionHTMLDB_td1currentDirectory").innerHTML;
    	if (fileName != "") {
    		fileName += "/";
    	}
    	fileName += document.getElementById("aMedia" + id).innerHTML;

    	generatedLIHTML = document.getElementById("ulFileListTemplate").innerHTML;
    	generatedLIHTML = generatedLIHTML.replace(/__GUID__/g, fileGUID);
    	generatedLIHTML = generatedLIHTML.replace(/__MEDIA_TYPE__/g,
    			elementLI.getAttribute("data-media-type"));
    	generatedLIHTML = generatedLIHTML.replace(/__FILE_NAME__/g, fileName);

    	generatedULHTML += generatedLIHTML;

    	fileCount++;
    }

    document.getElementById(targetFileList).innerHTML += generatedULHTML;

    updateFileListUL(targetFileList);
    updateFileListInput(targetFileList);
	
    hideDialog("divUploadTaskPhotoDialog");
}
function updateFileListUL(targetFileList) {
	var elementUL = document.getElementById(targetFileList);
	var elementLIList = $(">li", elementUL);
	var elementLIListCount = elementLIList.length;
	var elementLI = null;
	var fileName = "";
	var fileExtension = "";
	var imageFile = false;

	$(".aDeleteFileListItem", elementUL).off("click").on("click", function () {
		doDeleteFileListItemLinkClick(this);
	});

	for (var i = 0; i < elementLIListCount; i++) {
		elementLI = elementLIList[i];
		fileName = elementLI.getAttribute("data-file-name");
		fileExtension = String(fileName.split('.').pop()).toLowerCase();
		imageFile = (2 == parseInt(elementLI.getAttribute("data-media-type")));
		$(".aFileListItemFileURL", elementLI).attr("href", "" + fileName);

		if (imageFile) {
			$(".imgFileListItemFileURL", elementLI).attr("src", "" + fileName);
		} else {
			$(".imgFileListItemFileURL", elementLI).attr("src", "assets/img/" + fileExtension + ".png");
		}
	}

	if (elementLIListCount > 0) {
		elementUL.style.display = "block";
	    $(elementUL).sortable({
	    		items: "li",
	    		handle: ".grippy",
	    		update: function (event, ui) {
	    			updateFileListInput(targetFileList);
	    		}
	    });
	    
	    $(elementUL).disableSelection();
	} else {
		elementUL.style.display = "none";	
	}
}
function setFileListUL(targetFileList) {
	var elementUL = document.getElementById(targetFileList);
	elementUL.style.display = "none";
	elementUL.innerHTML = "";
	var inputElement = document.getElementById(elementUL.getAttribute("data-target-input-id"));
	var maxFileCount = parseInt(inputElement.getAttribute("data-max-file-count"));

	var inputFiles = String(inputElement.innerHTML).split(/\r?\n/);
	var inputFileCount = inputFiles.length;
    var generatedLIHTML = "";
    var generatedULHTML = "";
    var id = 0;
    var fileName = "";
    var fileGUID = "";
   	var fileExtension = "";
    var elementLI = null;
    var mediaType = 0;
    var imageFileExtensions = ["jpg", "jpeg", "png", "gif"];

    if (maxFileCount > 0) {
    	if (inputFileCount > maxFileCount) {
    		inputFileCount = maxFileCount;
    	}
    }

	for (var i = 0; i < inputFileCount; i++) {
    	fileName = inputFiles[i];

    	if ("" == fileName) {
    		continue;
    	}

    	fileGUID = md5(targetFileList + ":" + fileName);

    	if (document.getElementById("liFileListItem" + fileGUID)) {
    		continue;
    	}

		fileExtension = String(fileName.split('.').pop()).toLowerCase();

		if (imageFileExtensions.indexOf(fileExtension) != -1) {
			mediaType = 2;
		} else {
			mediaType = 1;
		}

    	generatedLIHTML = document.getElementById("ulFileListTemplate").innerHTML;
    	generatedLIHTML = generatedLIHTML.replace(/__GUID__/g, fileGUID);
    	generatedLIHTML = generatedLIHTML.replace(/__MEDIA_TYPE__/g, mediaType);
    	generatedLIHTML = generatedLIHTML.replace(/__FILE_NAME__/g, fileName);

    	generatedULHTML += generatedLIHTML;
    }

    elementUL.innerHTML = generatedULHTML;

    updateFileListUL(targetFileList);
}
function doDeleteFileListItemLinkClick(element) {
	if (!element) {
		return;
	}

	var elementUL = element.parentNode.parentNode;

	$(element.parentNode).detach();

	if (0 == $(">li", elementUL).length) {
		elementUL.style.display = "none";
	}

	updateFileListInput(elementUL.id);
}
function updateFileListInput(targetFileList) {
	var targetFileListInput
			= document.getElementById(
			targetFileList).getAttribute("data-target-input-id");

	document.getElementById(targetFileListInput).innerHTML = "";

	targetFileListElement = document.getElementById(targetFileList);
	targetFileListItems = $(">li", targetFileListElement);
	targetFileListItemCount = targetFileListItems.length;
	targetFileListItem = null;
	fileListInputValue = "";

	for (var i = 0; i < targetFileListItemCount; i++) {
		targetFileListItem = targetFileListItems[i];

		if (fileListInputValue != "") {
			fileListInputValue += "\r\n";
		}

		fileListInputValue += targetFileListItem.getAttribute("data-file-name");
	}

	document.getElementById(targetFileListInput).innerHTML = fileListInputValue;
}
function doBrowseFileButtonClick(element) {
	if (!element) {
		return;
	}
	
	doMediaHTMLDBRead(element);

	var targetFileListElement = document.getElementById(element.getAttribute("data-target-file-list"));
	var targetInputElement = document.getElementById(targetFileListElement.getAttribute("data-target-input-id"));
	var mediaType = targetInputElement.getAttribute("data-media-type");
	
	var activeClass = document.getElementById("uploaderActiveClass").value;
	document.getElementById("divUploadTaskPhotoDialog").setAttribute(
			"data-target-file-list",
			targetFileListElement.id);

	document.getElementById("divUploadTaskPhotoDialog").setAttribute(
			"data-media-type",
			mediaType);

	filterMediaFiles();
	
	document.getElementById("lastUploadedPhotoNameList").innerHTML = "";
	
	showDialog("divUploadTaskPhotoDialog");
}
function filterMediaFiles() {
	var uploadedFilesUL = document.getElementById("ulUploadedFiles");
	var mediaType = parseInt(
			document.getElementById("divUploadTaskPhotoDialog").getAttribute("data-media-type"));

	$(".liUploadedFile", uploadedFilesUL).css("display", "none");
	$(".liUploadedFile", uploadedFilesUL).addClass("disabled");

	if (2 == mediaType) {
		// Show Images
		$((".liUploadedFile.liMediaType" + mediaType), uploadedFilesUL).css("display", "block");
		$((".liUploadedFile.liMediaType" + mediaType), uploadedFilesUL).removeClass("disabled");
	} else {
		// Show All Files
		$(".liUploadedFile", uploadedFilesUL).css("display", "block");
		$(".liUploadedFile", uploadedFilesUL).removeClass("disabled");
	}

	$(".bSelectMediaObject", uploadedFilesUL).prop('checked', false);

}
function doMediaHTMLDBRead(element) {
	if (!element) {
		return;
	}

	document.body.setAttribute("data-loading", "0");

	var strFileContentHTML = document.getElementById("ulUploadedFilesTemplate").innerHTML;
	var strDirectoryContentHTML = document.getElementById("ulUploadedDirectoriesTemplate").innerHTML;
	var strULHTML = "";
	var strLIHTML = "";

	var elementTBODY = document.getElementById("divMediaHTMLDB_tbody");
	var arrTR = $(">tr", elementTBODY);
	var elTR = null;
	var lTRCount = arrTR.length;
	var lID = "";

	if (0 == lTRCount) {
		$("#buttonDownloadPhotos").hide();
	} else {
		$("#buttonDownloadPhotos").show();
	}

	for (var i = 0; i < lTRCount; i++) {
		elTR = arrTR[i];
		lID = parseInt(elTR.getAttribute("data-row-id"));


		if (parseInt(document.getElementById("divMediaHTMLDB_td"
				+ lID
				+ "directory").innerHTML) > 0) {

			strLIHTML = strDirectoryContentHTML;

			strLIHTML = strLIHTML.replace(/__GUID__/g, lID);
			strLIHTML = strLIHTML.replace(/__FILE_NAME__/g,
					document.getElementById("divMediaHTMLDB_td"
					+ lID
					+ "name").innerHTML);

			strLIHTML = strLIHTML.replace(/__FILE_SIZE__/g,
					document.getElementById(
					"divDirectoryLinkTemplate").getAttribute(
					"data-directory-description"));

			strLIHTML = strLIHTML.replace(/__FILE_NAME_CLASS__/g, "aMediaDirectory");
			strLIHTML = strLIHTML.replace(/__FILE_LINK_TARGET__/g, "");
			strLIHTML = strLIHTML.replace(/__MEDIA_TYPE__/g, "0");

		} else {

			strLIHTML = strFileContentHTML;

			strLIHTML = strLIHTML.replace(/__GUID__/g, lID);
			strLIHTML = strLIHTML.replace(/__FILE_NAME__/g,
					document.getElementById("divMediaHTMLDB_td"
					+ lID
					+ "name").innerHTML);

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
	var sessionObject = HTMLDB.get("divMediaSessionHTMLDB", 1);
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
	
	var activeClass = document.getElementById("uploaderActiveClass").value;

	var elUL = document.getElementById("ulUploadedFiles");

	elUL.innerHTML = /*strCurrentDirectoryLIHTML +*/ strULHTML;

	var mediaElement = null;

	for (var i = 0; i < lTRCount; i++) {
		elTR = arrTR[i];
		lID = parseInt(elTR.getAttribute("data-row-id"));

		mediaElement = document.getElementById("aMedia" + lID);

		if ($(mediaElement).hasClass("aMediaFile")) {

			mediaElement.href
					= ""
					+ document.getElementById("divMediaHTMLDB_td"
					+ lID
					+ "URL").innerHTML;

		}

		mediaElement = document.getElementById("aMediaImage" + lID);

		if ($(mediaElement).hasClass("aMediaFile")) {

			mediaElement.href
					= ""
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

	$(".inputUploadMedia").bind("change", function(evEvent) {
		doUploaderInputChange(this, evEvent);
	});

	$(".buttonUploadMedia").removeClass("disabled");

	initializeMediaObjects();
	selectLastUploadedPhotos();
}
function initializeMediaObjects() {
	var elementUL = document.getElementById("ulUploadedFiles");

	$(".aMediaDirectory", elementUL).off("click").on("click", function () {
		doMediaDirectoryLinkClick(this);
	});

    $("#bSelectMediaObjects").off("click").on("click", function () {
        doSelectMediaObjectsCheckboxAllClick(this);
    });

    $(".bSelectMediaObject").off("click").on("click", function () {
        doSelectMediaObjectCheckboxClick(this);
    });

	filterMediaFiles();

	updateMediaObjectListStatistics();
}
function doMediaDirectoryLinkClick(sender) {
	if (!sender) {
		return;
	}

	if ("1" == document.body.getAttribute("data-loading")) {
		return;
	}

	document.body.setAttribute("data-loading", "1");
	var sessionObject = HTMLDB.get("divMediaSessionHTMLDB", 1);

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

	HTMLDB.update("divMediaSessionHTMLDB", 1, sessionObject);
	HTMLDB.write("divMediaSessionHTMLDB", false, function () {
		HTMLDB.read("divMediaSessionHTMLDB", true);
		HTMLDB.read("divMediaHTMLDB", true);

		$("#ulUploadedFiles").velocity("stop");
		$("#ulUploadedFiles").velocity("transition.slideUpIn", 500);

		updateMediaObjectListStatistics();
	});
}
function doSelectMediaObjectCheckboxClick(sender) {
    if (!sender) {
        return;
    }
	
    var bChecked = sender.checked;

    var lCheckedCheckboxCount = 0;
    lCheckedCheckboxCount = $("#ulUploadedFiles .bSelectMediaObject:checked").length;

    if (0 == lCheckedCheckboxCount) {
        $(".spanSelection").html("");
    } else {
        $(".spanSelection").html(" (" + lCheckedCheckboxCount + ")");
    }

    /*var lCheckboxCount = $("#ulUploadedFiles .bSelectMediaObject").length;

    if (lCheckboxCount == lCheckedCheckboxCount) {
        document.getElementById("bSelectMediaObjects").checked = true;
    } else {
        document.getElementById("bSelectMediaObjects").checked = false;
    }*/

    updateMediaObjectListStatistics();
}
function doSelectMediaObjectsCheckboxAllClick(sender) {
    if (!sender) {
        return;
    }

    var bChecked = sender.checked;

    var arrInputs = $(".bSelectMediaObject");
    var lCountInput = arrInputs.length;
    var elInput = null;
    var elementLI = null;

    if (bChecked) {
        for (var i = 0; i < lCountInput; i++) {
            elInput = arrInputs[i];
            elementLI = elInput.parentNode.parentNode.parentNode;

            // Exclude Disabled Elements
            if (elementLI.className.indexOf("disabled") != -1) {
            	continue;
            }

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

    updateMediaObjectListStatistics();
}
function updateMediaObjectListStatistics() {
	var activeClass = document.getElementById("uploaderActiveClass").value;

    var checkedCheckboxCount = 0;
    checkedCheckboxCount = $("#ulUploadedFiles .bSelectMediaObject:checked").length;

    var textPattern = "";

    if (checkedCheckboxCount > 0) {
    	textPattern = document.getElementById("buttonSelectMedia").getAttribute("data-text-pattern");
    	textPattern = textPattern.replace(/%1/g, checkedCheckboxCount);
    } else {
    	textPattern = document.getElementById("buttonSelectMedia").getAttribute("data-zero-selection-pattern");
    }
    
    document.getElementById("buttonSelectMedia").innerHTML = textPattern;
}
function initializeDropzone() {
	var URLPrefix = document.body.getAttribute("data-url-prefix");

	$(".buttonUploadMedia").bind("click", function () {
		doUploadButtonClick(this);
	})

	var dropzoneElements = $("div.divDropzone");
	var dropzoneElement = null;
	var dropzoneElementCount = dropzoneElements.length;
	var dropzoneObject = null;

	for (var i = 0; i < dropzoneElementCount; i++) {
		dropzoneElement = dropzoneElements[i];
		dropzoneObject = new Dropzone(dropzoneElement, {
			"url": (URLPrefix + "uploadtaskphoto/formupload"),
			"addedfile": function (file) {
				uploadFile(file, 1);
				return false;
			}
		});
	}
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

	$(".buttonUploadMedia").addClass("disabled");

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
	
	var elTargetElement = document.getElementById("ulUploadedFiles");
	elTargetElement.innerHTML = strContentHTML + elTargetElement.innerHTML;

	addFileToLastUploadedPhotoList(objFile.name);
}
function addFileToLastUploadedPhotoList(fileName) {
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();

	if(dd<10) {
	    dd = "0"+dd
	} 

	if(mm<10) {
	    mm = "0"+mm
	} 

	today = yyyy + "-" + mm + "-" + dd;
	fileName = today + "-" + fileName;

	listHTML = document.getElementById("lastUploadedPhotoNameList").innerHTML;
	listHTML += "<li>" + fileName + "</li>";
	document.getElementById("lastUploadedPhotoNameList").innerHTML = listHTML;
}
function selectLastUploadedPhotos() {
	arrLastUploadPhotosList = $("#lastUploadedPhotoNameList > li");
	fileCount = arrLastUploadPhotosList.length;
	if (0 == fileCount) {
		return;
	}

	arrFileNames = [];
	for (var i = 0; i < fileCount; i++) {
		arrFileNames[i] = arrLastUploadPhotosList[i].innerHTML;
	}

	arrCheckboxList = $(".bSelectMediaObject");
	countCheckboxes = arrCheckboxList.length;

	for (var i = 0; i < countCheckboxes; i++) {
		elCheckbox = arrCheckboxList[i];
		if (arrFileNames.includes(elCheckbox.value)) {
			elCheckbox.click();
		}
	}

}