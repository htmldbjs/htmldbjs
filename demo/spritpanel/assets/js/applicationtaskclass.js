$(function() {
    initializeApplication();
    initializePage();
});
function initializePage() {
    initializeHTMLDB();
    initializeSelectize();
    initializeTableList();
	initializeMediaDialogs();
	initializeDropzone();
    
    $(".buttonPageFABAdd").off("click").on("click", function() {
        doAddObjectButtonClick(this);
    });

    $("#buttonCancelObjectDialog").off("click").on("click", function() {
        doCancelObjectButtonClick(this);
    });

    $("#buttonPageTopMenuSave").off("click").on("click", function() {
        doSaveObjectButtonClick(this);
    });

    $("#buttonPageTopMenuCancel").off("click").on("click", function() {
        doCancelObjectButtonClick(this);
    });

    $("#buttonSaveObject").off("click").on("click", function() {
        doSaveObjectButtonClick(this);
    });

    $("#aDeleteObjects").off("click").on("click", function() {
        deleteObjects(0);
    });

    $(".buttonTableColumn").off("click").on("click", function () {
        doTableColumnButtonClick(this);
    });

    $("#strSearchObject").off("keyup").on("keyup", function (e) {
        doSearchObjectKeyUp(this, e);
    });

    $("#buttonShowMore").off("click").on("click", function () {
        doShowMoreButtonClick(this);
    });

    $(window).on("scroll", function () {
        doWindowScroll();
    });

    resetProgressBar(
            document.getElementById("divLoaderText").getAttribute("data-default-text"),
            false,
            true);

    loadObjects();       
}
function initializeTableList() {
    var elementList = $("#tableGhostObjectList .buttonTableColumn");
    var elementCount = elementList.length;
    var element = null;

    for (var i = 0; i < elementCount; i++) {

        element = elementList[i];
        $(element).addClass("buttonTableColumn" + i);
        element.setAttribute("data-column-index", i);

    }

    elementList = $("#tableObjectList .buttonTableColumn");
    elementCount = elementList.length;
    element = null;

    for (var i = 0; i < elementCount; i++) {

        element = elementList[i];
        $(element).addClass("buttonTableColumn" + i);
        element.setAttribute("data-column-index", i);

    }
}
function initializeHTMLDB() {
    var URLPrefix = document.body.getAttribute("data-url-prefix");

    HTMLDB.initialize({
        elementID:"divApplicationTaskHTMLDB",
        readURL:(URLPrefix + "applicationtaskclass/read/all"),
        readAllURL:(URLPrefix + "applicationtaskclass/read/all"),
        validateURL:(URLPrefix + "applicationtaskclass/validate"),
        writeURL:(URLPrefix + "applicationtaskclass/write"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:doHTMLDBApplicationTaskReadAll,
        onRead:null,
        onWrite:doHTMLDBApplicationTaskWrite,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divApplicationTaskTableHTMLDB",
        readURL:(URLPrefix + "applicationtaskclass/readtable/all"),
        readAllURL:(URLPrefix + "applicationtaskclass/readtable/all"),
        writeURL:null,
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyObjectListTemplate",
            targetElementID:"tbodyObjectList"
        },{
            templateElementID:"tbodyGhostObjectListTemplate",
            targetElementID:"tbodyGhostObjectList"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:doHTMLDBApplicationTaskRenderAll
    });

    HTMLDB.initialize({
        elementID:"divSessionHTMLDB",
        readURL:(URLPrefix + "applicationtaskclass/readsession"),
        readAllURL:(URLPrefix + "applicationtaskclass/readsession"),
        writeURL:(URLPrefix + "applicationtaskclass/writesession"),
        writeDelay:1000,
        autoRefresh:0,
        renderElements:[],
        onReadAll:doHTMLDBSessionReadAll,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divapplication_idPropertyOptionsHTMLDB",
        readURL:(URLPrefix + "applicationtaskclass/readpropertyoptions/application_id"),
        readAllURL:(URLPrefix + "applicationtaskclass/readpropertyoptions/application_id"),
        writeURL:"",
        writeDelay:1000,
        autoRefresh:0,
        renderElements:[],
        onReadAll:doPropertyOptionsHTMLDBRead,
        onRead:doPropertyOptionsHTMLDBRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });


    HTMLDB.initialize({
        elementID:"divapplication_task_category_idPropertyOptionsHTMLDB",
        readURL:(URLPrefix + "applicationtaskclass/readpropertyoptions/application_task_category_id"),
        readAllURL:(URLPrefix + "applicationtaskclass/readpropertyoptions/application_task_category_id"),
        writeURL:"",
        writeDelay:1000,
        autoRefresh:0,
        renderElements:[],
        onReadAll:doPropertyOptionsHTMLDBRead,
        onRead:doPropertyOptionsHTMLDBRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });


    HTMLDB.initialize({
        elementID:"divresponsiblePropertyOptionsHTMLDB",
        readURL:(URLPrefix + "applicationtaskclass/readpropertyoptions/responsible"),
        readAllURL:(URLPrefix + "applicationtaskclass/readpropertyoptions/responsible"),
        writeURL:"",
        writeDelay:1000,
        autoRefresh:0,
        renderElements:[],
        onReadAll:doPropertyOptionsHTMLDBRead,
        onRead:doPropertyOptionsHTMLDBRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });


    HTMLDB.initialize({
        elementID:"divapplication_task_state_idPropertyOptionsHTMLDB",
        readURL:(URLPrefix + "applicationtaskclass/readpropertyoptions/application_task_state_id"),
        readAllURL:(URLPrefix + "applicationtaskclass/readpropertyoptions/application_task_state_id"),
        writeURL:"",
        writeDelay:1000,
        autoRefresh:0,
        renderElements:[],
        onReadAll:doPropertyOptionsHTMLDBRead,
        onRead:doPropertyOptionsHTMLDBRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });


    HTMLDB.initialize({
        elementID:"divMediaHTMLDB",
        readURL:(URLPrefix + "media/readmedia"),
        readAllURL:(URLPrefix + "media/readmedia/all"),
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
function doHTMLDBSessionReadAll() {
    var sessionObject = HTMLDB.get("divSessionHTMLDB", 1);
    document.getElementById("strSearchObject").value = sessionObject["searchText"];
    var sortingColumn = sessionObject["sortingColumn"];
    var sortingASC = sessionObject["sortingASC"];

    $("#tableObjectList .buttonTableColumn").removeClass("sorting-asc");
    $("#tableObjectList .buttonTableColumn").removeClass("sorting-desc");
    $("#tableGhostObjectList .buttonTableColumn").removeClass("sorting-asc");
    $("#tableGhostObjectList .buttonTableColumn").removeClass("sorting-desc");

    if (sortingASC) {
        $("#tableObjectList .buttonTableColumn" + (sortingColumn)).addClass("sorting-asc");
        $("#tableGhostObjectList .buttonTableColumn" + (sortingColumn)).addClass("sorting-asc");
    } else {
        $("#tableObjectList .buttonTableColumn" + (sortingColumn)).addClass("sorting-desc");
        $("#tableGhostObjectList .buttonTableColumn" + (sortingColumn)).addClass("sorting-desc");        
    }

    if (parseInt(sessionObject["pageCount"]) > 1) {
        document.getElementById("buttonShowMore").style.display = "block";
    } else {
        document.getElementById("buttonShowMore").style.display = "none";
    }
}
function doShowMoreButtonClick(sender) {
    if (!sender) {
        return;
    }

    sender.disabled = true;

    var object = HTMLDB.get("divSessionHTMLDB", 1);

    if ((parseInt(object["page"]) + 1) >= parseInt(object["pageCount"])) {
        return;
    }

    object["page"] = (parseInt(object["page"]) + 1);
    HTMLDB.update("divSessionHTMLDB", 1, object);
    HTMLDB.write("divSessionHTMLDB", false, function () {
        HTMLDB.read("divApplicationTaskHTMLDB", false, function () {
            sender.disabled = false;
            HTMLDB.renderAll("divApplicationTaskHTMLDB");
        });
    });
}

function doSearchObjectKeyUp(sender, e) {

    if (!sender) {
        return;
    }

    var tmSearch = $("#strSearchObject").data("tmSearch");

    if (13 == e.keyCode) {
        clearTimeout(tmSearch);
        searchList();
    } else {

        clearTimeout(tmSearch);
        tmSearch = setTimeout(function () {
            searchList();
        }, 1000);
        $("#strSearchObject").data("tmSearch", tmSearch);

    }

}

function searchList() {

    var object = HTMLDB.get("divSessionHTMLDB", 1);
    object["searchText"] = document.getElementById("strSearchObject").value;
    object["page"] = 0;
    HTMLDB.update("divSessionHTMLDB", 1, object);
    HTMLDB.write("divSessionHTMLDB", false, function () {

        resetProgressBar(
                document.getElementById("divLoaderText").getAttribute("data-default-text"),
                false,
                true);
        document.getElementById("divApplicationTaskHTMLDB_tbody").innerHTML = "";
        document.getElementById("divApplicationTaskTableHTMLDB_tbody").innerHTML = "";
        document.getElementById("tbodyObjectList").innerHTML = "";
        document.getElementById("tbodyGhostObjectList").innerHTML = "";
        HTMLDB.read("divApplicationTaskHTMLDB", true);

    });

}

function doTableColumnButtonClick(sender) {
    if (!sender) {
        return;
    }

    var columnIndex = sender.getAttribute("data-column-index");
    var sortingClass = "sorting-asc";
    var tableElement = sender.parentNode.parentNode.parentNode;
    var tableId = tableElement.id;
    var relatedTableId = tableElement.getAttribute("data-related-table-id");
    var sortingSessionValue = columnIndex;
    var sortingASCSessionValue = 1;

    if ($(sender).hasClass("sorting-asc")) {
        sortingClass = "sorting-desc";
        sortingSessionValue = columnIndex;
        sortingASCSessionValue = 0;
    } else if ($(sender).hasClass("sorting-desc")) {
        sortingClass = "sorting-asc";
        sortingSessionValue = columnIndex;
        sortingASCSessionValue = 1;
    } else {
        sortingClass = "sorting-asc";
        sortingSessionValue = columnIndex;
        sortingASCSessionValue = 1;
    }

    $(".buttonTableColumn", tableElement).removeClass("sorting-asc");
    $(".buttonTableColumn", tableElement).removeClass("sorting-desc");
    $((".buttonTableColumn" + columnIndex), tableElement).addClass(sortingClass);

    if (document.getElementById(relatedTableId)) {
        var relatedTable = document.getElementById(relatedTableId);
        $(".buttonTableColumn", relatedTable).removeClass("sorting-asc");
        $(".buttonTableColumn", relatedTable).removeClass("sorting-desc");
        $((".buttonTableColumn" + columnIndex), relatedTable).addClass(sortingClass);
    }

    var object = HTMLDB.get("divSessionHTMLDB", 1);
    object["sortingColumn"] = sortingSessionValue;
    object["sortingASC"] = sortingASCSessionValue;
    object["page"] = 0;
    HTMLDB.update("divSessionHTMLDB", 1, object);
    HTMLDB.write("divSessionHTMLDB", true, function () {
        resetProgressBar(
                document.getElementById("divLoaderText").getAttribute("data-default-text"),
                false,
                true);
        document.getElementById("divApplicationTaskHTMLDB_tbody").innerHTML = "";
        document.getElementById("divApplicationTaskTableHTMLDB_tbody").innerHTML = "";
        document.getElementById("tbodyObjectList").innerHTML = "";
        document.getElementById("tbodyGhostObjectList").innerHTML = "";
        HTMLDB.read("divApplicationTaskHTMLDB", true);
    });
}
function doHTMLDBApplicationTaskReadAll() {
    HTMLDB.read("divApplicationTaskTableHTMLDB", true);
}
function doHTMLDBApplicationTaskWrite() {
    HTMLDB.read("divApplicationTaskHTMLDB", true);
}
function doHTMLDBApplicationTaskRenderAll() {
    initializeObjects();
    updateObjectListStatistics();
    stepProgressBar(100);
}
function initializeObjects() {
    $(".buttonEditObject").off("click").on("click", function() {
        doEditObjectButtonClick(this);
    });

    $(".buttonDeleteObject").off("click").on("click", function() {
        doDeleteObjectButtonClick(this);
    });

    $("#bSelectObjects").off("click").on("click", function () {
        doSelectObjectsCheckboxAllClick(this);
    });

    $("#bSelectObjectsGhost").off("click").on("click", function () {
        doSelectObjectsCheckboxAllClick(this);
    });

    $(".bSelectObject").off("click").on("click", function () {
        doSelectObjectCheckboxClick(this);
    });
}
function initializeSelectize() {

    var selectElements = $(".selectSelectizeStandard");
    var selectElementCount = selectElements.length;
    var selectElement = null;

    for (var i = 0; i < selectElementCount; i++) {

        selectElement = selectElements[i];
        if (selectElement.selectize) {
            selectElement.selectize.destroy();
        }

    }

    selectElements = $(".selectClassSelection");
    selectElementCount = selectElements.length;

    for (var i = 0; i < selectElementCount; i++) {

        selectElement = selectElements[i];
        if (selectElement.selectize) {
            selectElement.selectize.destroy();
        }

    }

    if ($(".selectSelectizeStandard").length > 0) {

        var selectizeElements = $(".selectSelectizeStandard");
        var selectizeCount = selectizeElements.length;
        var selectizeElement = null;
        var maxSelectionCount = 0;

        for (var i = 0; i < selectizeCount; i++) {

            selectizeElement = selectizeElements[i];
            if (undefined == selectizeElement.attributes['multiple']) {

                $(selectizeElement).selectize({
                    sortField: "text"
                });

            } else {

                maxSelectionCount = parseInt(selectizeElement.getAttribute("data-max-selection"));

                if (isNaN(maxSelectionCount) || (maxSelectionCount <= 0)) {
                    maxSelectionCount = null;
                }

                $(selectizeElement).selectize({
                    plugins: ["remove_button"],
                    sortField: "text",
                    persist: false,
                    create: true,
                    maxItems: maxSelectionCount,
                    createFilter: function(input) {
                        return false;
                    }
                });

                if (maxSelectionCount > 1) {

                    if ($(".selectize-input.items", selectizeElement.parentNode).hasClass('ui-sortable')) {
                        $(".selectize-input.items", selectizeElement.parentNode).sortable("destroy");
                    }

                    $(".selectize-input.items", selectizeElement.parentNode).sortable({
                        axis: "x",
                        opacity: 0.7,
                        placeholder: "item"
                    });

                }

            }

        }

    }

    if ($(".selectClassSelection").length > 0) {

        var selectizeElements = $(".selectClassSelection");
        var selectizeCount = selectizeElements.length;
        var selectizeElement = null;
        var maxSelectionCount = 0;

        for (var i = 0; i < selectizeCount; i++) {

            selectizeElement = selectizeElements[i];
            if (undefined == selectizeElement.attributes['multiple']) {

		        $(selectizeElement).selectize({
		    		valueField: "id",
		    		labelField: "column0",
		    		searchField: "column0",
		    		preload: false,
		    		create: false,
				    render: {
				        option: function(item, escape) {
				        	var contentHTML = document.getElementById("divClassSelectionOptionTemplate").innerHTML;
				        	contentHTML = contentHTML.replace(/__NAME__/g, item.column0);
				        	return contentHTML;
				        }
				    },
				    score: function(search) {
				        var score = this.getScoreFunction(search);
				        return function(item) {
				            return score(item);
				        };
				    },
				    load: doClassSelectionSelectLoad
		        });

            } else {

            	maxSelectionCount = parseInt(selectizeElement.getAttribute("data-max-selection"));

            	if (isNaN(maxSelectionCount) || (maxSelectionCount <= 0)) {
            		maxSelectionCount = null;
            	}

		        $(selectizeElement).selectize({
		    		plugins: ["remove_button"],
		    		valueField: "id",
		    		labelField: "column0",
		    		searchField: "column0",
		    		preload: false,
		    		create: false,
		    		maxItems: maxSelectionCount,
				    render: {
				        option: function(item, escape) {
				        	var contentHTML = document.getElementById("divClassSelectionOptionTemplate").innerHTML;
				        	contentHTML = contentHTML.replace(/__NAME__/g, item.column0);
				        	return contentHTML;
				        }
				    },
				    score: function(search) {
				        var score = this.getScoreFunction(search);
				        return function(item) {
				            return score(item);
				        };
				    },
				    load: doClassSelectionSelectLoad
		        });

                if (maxSelectionCount > 1) {

	                if ($(".selectize-input.items", selectizeElement.parentNode).hasClass('ui-sortable')) {
	                    $(".selectize-input.items", selectizeElement.parentNode).sortable("destroy");
	                }

	                $(".selectize-input.items", selectizeElement.parentNode).sortable({
	                    axis: "x",
	                    opacity: 0.7,
	                    placeholder: "item"
	                });

                }

            }

        }

    }

}
function doClassSelectionSelectLoad(query, callback) {

    var selectElement = this.$input[0];
    var propertyName = selectElement.id;

    document.getElementById("div"
            + propertyName
            + "PropertyOptionsHTMLDB_tbody").innerHTML = "";

    var object = HTMLDB.get("divSessionHTMLDB", 1);

    if (object[propertyName + "SearchText"] != undefined) {
        object[propertyName + "SearchText"] = query;
    }

    HTMLDB.update("divSessionHTMLDB", 1, object);
    HTMLDB.write("divSessionHTMLDB", false, function () {
        HTMLDB.read("div" + propertyName + "PropertyOptionsHTMLDB", false);
    });

}
function doPropertyOptionsHTMLDBRead(element) {

    var propertyName = element.id;
    propertyName = propertyName.substr(3);
    propertyName = propertyName.replace(/PropertyOptionsHTMLDB/g, "");

    var selectInput = document.getElementById(propertyName);

    itemCount = document.getElementById(element.id + "_tbody").children.length;
    childrenTR = document.getElementById(element.id + "_tbody").children;
    items = new Array();
    itemId = 0;

    for (var i = 0; i < itemCount; i++) {
        itemId = childrenTR[i].getAttribute("data-row-id");
        items.push(HTMLDB.get(element.id, itemId));
    }

    if (selectInput.selectize) {
        selectInput.selectize.addOption(items);
    }

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
    var targetFileList = document.getElementById("divBrowseMediaDialog").getAttribute("data-target-file-list");
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

    	fileName = document.getElementById("divSessionHTMLDB_td1currentDirectory").innerHTML;
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

    hideDialog("divBrowseMediaDialog");
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
		$(".aFileListItemFileURL", elementLI).attr("href", "../media/" + fileName);

		if (imageFile) {
			$(".imgFileListItemFileURL", elementLI).attr("src", "../media/" + fileName);
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
	var inputElement = document.getElementById(
			elementUL.getAttribute("data-target-input-id"));
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

	var targetFileListElement
			= document.getElementById(
			element.getAttribute("data-target-file-list"));
	var targetInputElement
			= document.getElementById(
			targetFileListElement.getAttribute("data-target-input-id"));
	var mediaType = targetInputElement.getAttribute("data-media-type");

	document.getElementById("divBrowseMediaDialog").setAttribute(
			"data-target-file-list",
			targetFileListElement.id);

	document.getElementById("divBrowseMediaDialog").setAttribute(
			"data-media-type",
			mediaType);

	filterMediaFiles();

	showDialog("divBrowseMediaDialog");
}
function filterMediaFiles() {
	var uploadedFilesUL = document.getElementById("ulUploadedFiles");
	var mediaType = parseInt(
			document.getElementById("divBrowseMediaDialog").getAttribute("data-media-type"));

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

	initializeMediaObjects();
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

    var lCheckboxCount = $("#ulUploadedFiles .bSelectMediaObject").length;

    if (lCheckboxCount == lCheckedCheckboxCount) {
        document.getElementById("bSelectMediaObjects").checked = true;
    } else {
        document.getElementById("bSelectMediaObjects").checked = false;
    }

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
    var objectCount = document.getElementById("tbodyObjectList").children.length;
    var checkedCount = $("#tbodyObjectList  .bSelectObject:checked").length;
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

    if (bChecked) {
        $(sender.parentNode.parentNode).addClass("checkedTR");
    } else {
        $(sender.parentNode.parentNode).removeClass("checkedTR");
    }

    var lCheckedCheckboxCount = 0;
    lCheckedCheckboxCount = $("#tbodyObjectList  .bSelectObject:checked").length;

    if (0 == lCheckedCheckboxCount) {
        $(".spanSelection").html("");
    } else {
        $(".spanSelection").html(" (" + lCheckedCheckboxCount + ")");
    }

    var lCheckboxCount = $("#tbodyObjectList  .bSelectObject").length;

    if (lCheckboxCount == lCheckedCheckboxCount) {
        document.getElementById("bSelectObjects").checked = true;
        document.getElementById("bSelectObjectsGhost").checked = true;
    } else {
        document.getElementById("bSelectObjects").checked = false;
        document.getElementById("bSelectObjectsGhost").checked = false;
    }

    updateObjectListStatistics();
}
function doWindowScroll() {
    var strActivePage = document.body.getAttribute("data-active-page-csv");

    document.getElementById("divGhostHeaderContainer").style.display = "none";

    if (strActivePage == "divObjectsContent") {
        if ($(window).scrollTop() > 195) {
            $("#tableGhostObjectList").css("width", $("#tableObjectList").css("width"));
            document.getElementById("divGhostHeaderContainer").style.display = "block";
        }
    }
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
    lCheckedCheckboxCount = $("#tbodyObjectList .bSelectObject:checked").length;

    if (0 == lCheckedCheckboxCount) {
        $(".spanSelection").html("");
    } else {
        $(".spanSelection").html(" (" + lCheckedCheckboxCount + ")");
    }

    updateObjectListStatistics();
}
function doEditObjectButtonClick(sender) {
    if (!sender) {
        return;
    }

    var id = sender.getAttribute("data-object-id");
    loadObject(id);
    hidePage("divObjectsContent");
    showPage("divObjectContent");
}
function doDeleteObjectButtonClick(sender) {
    if (!sender) {
        return;
    }

    deleteObjects(sender.getAttribute("data-object-id"));
}
function doAddObjectButtonClick(sender) {
    if (!sender) {
        return;
    }

    loadObject(0);
    hidePage("divObjectsContent");
    showPage("divObjectContent");
}
function doSaveObjectButtonClick(sender) {
    if (!sender) {
        return;
    }

    var id = sender.getAttribute("data-object-id");
    validateObject(id);
}
function doCancelObjectButtonClick(sender) {
    hidePage("divObjectContent");
    loadObjects();
}
function validateObject(id) {
    var strHTMLDBDIVID = "divApplicationTaskHTMLDB";
    var arrClassProperties = HTMLDB.getColumnNames(strHTMLDBDIVID);
    var lClassPropertyCount = arrClassProperties.length;
    var objObject = {};

    if (id > 0) {
        objObject = HTMLDB.get(strHTMLDBDIVID, id);
    }

    for (var i = 0; i < lClassPropertyCount; i++) {
        objObject[arrClassProperties[i]] = getInputValue(arrClassProperties[i]);
    }

    HTMLDB.validate(strHTMLDBDIVID, objObject, function (strDIVID, strResponse) {
        var objResponse = JSON.parse(String(strResponse).trim());
        if (objResponse.errorCount > 0) {      
            showErrorDialog(objResponse.lastError);
        } else {
            saveObject(objObject);
        }
    });
}
function saveObject(objObject) {
    var strHTMLDBDIVID = "divApplicationTaskHTMLDB";
    var elSaveButton = document.getElementById("buttonSaveObject");

    // Change Button Text
    elSaveButton.innerHTML = elSaveButton.getAttribute("data-loading-text");
    elSaveButton.setAttribute("data-loading", "1");

    var id = objObject["id"];

    // Insert/Update HTMLDB
    var elTR = document.getElementById("divApplicationTaskHTMLDB_tr" + id);

    if (elTR) {
        HTMLDB.update(strHTMLDBDIVID, id, objObject);
    } else {
        HTMLDB.insert(strHTMLDBDIVID, objObject);
    }

    hidePage("divObjectContent");
    document.getElementById("buttonPageFABAdd").style.display = "inline-block";
    document.getElementById("h4PageHeader").style.display = "block";
    document.getElementById("buttonPageTopMenuMore").style.display = "inline-block";
    showPage("divObjectsContent");
    HTMLDB.write("divApplicationTaskHTMLDB");
    elSaveButton.innerHTML = elSaveButton.getAttribute("data-default-text");
}
function deleteObjects(lID) {
    if (lID > 0) {
        strObjectIDCSV = lID;
    } else {
        var lSelectedObjectCount = $("#tbodyObjectList  .bSelectObject:checked").length;

        if (0 == lSelectedObjectCount) {
            return false;
        }

        $("#spanDeleteSelection").html("\"" + lSelectedObjectCount + "\"");

        if (lSelectedObjectCount > 1) {
            document.getElementById("spanPluralSuffix").style.display = "inline-block";
        } else {
            document.getElementById("spanPluralSuffix").style.display = "none";
        }

        var arrCheckedCheckboxes = $("#tbodyObjectList .bSelectObject:checked");
        var lCheckedCheckboxesCount = arrCheckedCheckboxes.length;
        var strObjectIDCSV = "";

        for (var i = 0; i < lCheckedCheckboxesCount; i++) {
            if ("" != strObjectIDCSV) {
                strObjectIDCSV += ",";
            }
            strObjectIDCSV += arrCheckedCheckboxes[i].getAttribute("data-object-id");
        }
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
    var strObjectIDCSV = sender.getAttribute("data-object-id-csv");
    var arrObjectIDs = strObjectIDCSV.split(",");
    var lObjectIDCount = arrObjectIDs.length;
    var strTR1Prefix = "divApplicationTaskHTMLDB_tr";
    var strTR2Prefix = "divApplicationTaskTableHTMLDB_tr";

    for (var i = 0; i < lObjectIDCount; i++) {
        document.getElementById(strTR1Prefix + arrObjectIDs[i]).className = "deleted";
        $("#" + strTR2Prefix + arrObjectIDs[i]).detach();
    }
    
    $(".spanSelection").html("");       
    
    for (var i = 0; i < lObjectIDCount; i++) {
        $("." + "tr" + arrObjectIDs[i]).detach();
    }
    
    HTMLDB.write("divApplicationTaskHTMLDB");

    hideDialog("divDeleteDialog");
}
function doSearchObjects(sender) {
    var strClassName = sender.getAttribute("data-class-name");
    var arrTR = $("#classlist-tbody>tr");

    var strSearch = String(sender.value).trim();
    strSearch = strSearch.replace(/ +/g, ' ');
    strSearch = strSearch.toLowerCase();

    $(arrTR).show().filter(function() {
        var strText = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~strText.indexOf(strSearch);
    }).hide();
}
function loadObjects() {
    document.getElementById("buttonPageFABAdd").style.display = "inline-block";
    document.getElementById("h4PageHeader").style.display = "block";
    document.getElementById("buttonPageTopMenuMore").style.display = "inline-block";

    showPage("divObjectsContent");

    initializeObjects();
}
function loadObject(id) {
    document.getElementById("buttonPageFABAdd").style.display = "none";
    document.getElementById("h4PageHeader").style.display = "none";
    document.getElementById("buttonPageTopMenuMore").style.display = "none";

    resetForm(document.getElementById("formObject"));
    document.getElementById("id").value = 0;
    
	document.getElementById("application_id").selectize.setValue(0);
	document.getElementById("application_task_category_id").selectize.setValue(0);
	document.getElementById("responsible").selectize.setValue(0);
	document.getElementById("application_task_state_id").selectize.setValue(0);

    // Initialize Variable Values
    var arrClassProperties = HTMLDB.getColumnNames("divApplicationTaskHTMLDB");
    var lClassPropertyCount = arrClassProperties.length;
    var elTR = document.getElementById("divApplicationTaskHTMLDB_tr" + id);
    var objObject = null;

    if (elTR) {

        objObject = HTMLDB.get("divApplicationTaskHTMLDB", id);
		if (parseInt(objObject["application_id"]) > 0) {
			document.getElementById("application_id").selectize.addOption(
					{value: objObject["application_id"],
					text: objObject["application_idDisplayText"]});
		}
		if (parseInt(objObject["application_task_category_id"]) > 0) {
			document.getElementById("application_task_category_id").selectize.addOption(
					{value: objObject["application_task_category_id"],
					text: objObject["application_task_category_idDisplayText"]});
		}
		if (parseInt(objObject["responsible"]) > 0) {
			document.getElementById("responsible").selectize.addOption(
					{value: objObject["responsible"],
					text: objObject["responsibleDisplayText"]});
		}
		if (parseInt(objObject["application_task_state_id"]) > 0) {
			document.getElementById("application_task_state_id").selectize.addOption(
					{value: objObject["application_task_state_id"],
					text: objObject["application_task_state_idDisplayText"]});
		}
        for (var i = 0; i < lClassPropertyCount; i++) {
            setInputValue(arrClassProperties[i], objObject[arrClassProperties[i]]);
        }

    }
	setFileListUL("ulphotosFileList");
    document.getElementById("buttonSaveObject").setAttribute("data-object-id", id);
}