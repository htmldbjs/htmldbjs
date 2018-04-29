$(function() {
    initializeApplication();
    initializePage();
});
function initializePage() {
    initializeHTMLDB();
    initializeSelectize();
    initializeTableList();
    
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
        elementID:"divCrewHTMLDB",
        readURL:(URLPrefix + "crewclass/read/all"),
        readAllURL:(URLPrefix + "crewclass/read/all"),
        validateURL:(URLPrefix + "crewclass/validate"),
        writeURL:(URLPrefix + "crewclass/write"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:doHTMLDBCrewReadAll,
        onRead:null,
        onWrite:doHTMLDBCrewWrite,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divCrewTableHTMLDB",
        readURL:(URLPrefix + "crewclass/readtable/all"),
        readAllURL:(URLPrefix + "crewclass/readtable/all"),
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
        onRenderAll:doHTMLDBCrewRenderAll
    });

    HTMLDB.initialize({
        elementID:"divSessionHTMLDB",
        readURL:(URLPrefix + "crewclass/readsession"),
        readAllURL:(URLPrefix + "crewclass/readsession"),
        writeURL:(URLPrefix + "crewclass/writesession"),
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
        elementID:"divcompany_idPropertyOptionsHTMLDB",
        readURL:(URLPrefix + "crewclass/readpropertyoptions/company_id"),
        readAllURL:(URLPrefix + "crewclass/readpropertyoptions/company_id"),
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
        elementID:"divunit_idPropertyOptionsHTMLDB",
        readURL:(URLPrefix + "crewclass/readpropertyoptions/unit_id"),
        readAllURL:(URLPrefix + "crewclass/readpropertyoptions/unit_id"),
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
        HTMLDB.read("divCrewHTMLDB", false, function () {
            sender.disabled = false;
            HTMLDB.renderAll("divCrewHTMLDB");
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
        document.getElementById("divCrewHTMLDB_tbody").innerHTML = "";
        document.getElementById("divCrewTableHTMLDB_tbody").innerHTML = "";
        document.getElementById("tbodyObjectList").innerHTML = "";
        document.getElementById("tbodyGhostObjectList").innerHTML = "";
        HTMLDB.read("divCrewHTMLDB", true);

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
        document.getElementById("divCrewHTMLDB_tbody").innerHTML = "";
        document.getElementById("divCrewTableHTMLDB_tbody").innerHTML = "";
        document.getElementById("tbodyObjectList").innerHTML = "";
        document.getElementById("tbodyGhostObjectList").innerHTML = "";
        HTMLDB.read("divCrewHTMLDB", true);
    });
}
function doHTMLDBCrewReadAll() {
    HTMLDB.read("divCrewTableHTMLDB", true);
}
function doHTMLDBCrewWrite() {
    HTMLDB.read("divCrewHTMLDB", true);
}
function doHTMLDBCrewRenderAll() {
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
    var strHTMLDBDIVID = "divCrewHTMLDB";
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
    var strHTMLDBDIVID = "divCrewHTMLDB";
    var elSaveButton = document.getElementById("buttonSaveObject");

    // Change Button Text
    elSaveButton.innerHTML = elSaveButton.getAttribute("data-loading-text");
    elSaveButton.setAttribute("data-loading", "1");

    var id = objObject["id"];

    // Insert/Update HTMLDB
    var elTR = document.getElementById("divCrewHTMLDB_tr" + id);

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
    HTMLDB.write("divCrewHTMLDB");
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
    var strTR1Prefix = "divCrewHTMLDB_tr";
    var strTR2Prefix = "divCrewTableHTMLDB_tr";

    for (var i = 0; i < lObjectIDCount; i++) {
        document.getElementById(strTR1Prefix + arrObjectIDs[i]).className = "deleted";
        $("#" + strTR2Prefix + arrObjectIDs[i]).detach();
    }
    
    $(".spanSelection").html("");       
    
    for (var i = 0; i < lObjectIDCount; i++) {
        $("." + "tr" + arrObjectIDs[i]).detach();
    }
    
    HTMLDB.write("divCrewHTMLDB");

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
    
	document.getElementById("company_id").selectize.setValue(0);
	document.getElementById("unit_id").selectize.setValue(0);
	document.getElementById("type").selectize.setValue(0);

    // Initialize Variable Values
    var arrClassProperties = HTMLDB.getColumnNames("divCrewHTMLDB");
    var lClassPropertyCount = arrClassProperties.length;
    var elTR = document.getElementById("divCrewHTMLDB_tr" + id);
    var objObject = null;

    if (elTR) {

        objObject = HTMLDB.get("divCrewHTMLDB", id);
		if (parseInt(objObject["company_id"]) > 0) {
			document.getElementById("company_id").selectize.addOption(
					{value: objObject["company_id"],
					text: objObject["company_idDisplayText"]});
		}
		if (parseInt(objObject["unit_id"]) > 0) {
			document.getElementById("unit_id").selectize.addOption(
					{value: objObject["unit_id"],
					text: objObject["unit_idDisplayText"]});
		}
        for (var i = 0; i < lClassPropertyCount; i++) {
            setInputValue(arrClassProperties[i], objObject[arrClassProperties[i]]);
        }

    }
    document.getElementById("buttonSaveObject").setAttribute("data-object-id", id);
}