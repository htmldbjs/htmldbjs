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
        elementID:"divStepStateHTMLDB",
        readURL:(URLPrefix + "stepstateclass/read/all"),
        readAllURL:(URLPrefix + "stepstateclass/read/all"),
        validateURL:(URLPrefix + "stepstateclass/validate"),
        writeURL:(URLPrefix + "stepstateclass/write"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:doHTMLDBStepStateReadAll,
        onRead:null,
        onWrite:doHTMLDBStepStateWrite,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divStepStateTableHTMLDB",
        readURL:(URLPrefix + "stepstateclass/readtable/all"),
        readAllURL:(URLPrefix + "stepstateclass/readtable/all"),
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
        onRenderAll:doHTMLDBStepStateRenderAll
    });

    HTMLDB.initialize({
        elementID:"divSessionHTMLDB",
        readURL:(URLPrefix + "stepstateclass/readsession"),
        readAllURL:(URLPrefix + "stepstateclass/readsession"),
        writeURL:(URLPrefix + "stepstateclass/writesession"),
        writeDelay:1000,
        autoRefresh:0,
        renderElements:[],
        onReadAll:doHTMLDBSessionReadAll,
        onRead:null,
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
        HTMLDB.read("divStepStateHTMLDB", false, function () {
            sender.disabled = false;
            HTMLDB.renderAll("divStepStateHTMLDB");
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
        document.getElementById("divStepStateHTMLDB_tbody").innerHTML = "";
        document.getElementById("divStepStateTableHTMLDB_tbody").innerHTML = "";
        document.getElementById("tbodyObjectList").innerHTML = "";
        document.getElementById("tbodyGhostObjectList").innerHTML = "";
        HTMLDB.read("divStepStateHTMLDB", true);

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
        document.getElementById("divStepStateHTMLDB_tbody").innerHTML = "";
        document.getElementById("divStepStateTableHTMLDB_tbody").innerHTML = "";
        document.getElementById("tbodyObjectList").innerHTML = "";
        document.getElementById("tbodyGhostObjectList").innerHTML = "";
        HTMLDB.read("divStepStateHTMLDB", true);
    });
}
function doHTMLDBStepStateReadAll() {
    HTMLDB.read("divStepStateTableHTMLDB", true);
}
function doHTMLDBStepStateWrite() {
    HTMLDB.read("divStepStateHTMLDB", true);
}
function doHTMLDBStepStateRenderAll() {
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
    var strHTMLDBDIVID = "divStepStateHTMLDB";
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
    var strHTMLDBDIVID = "divStepStateHTMLDB";
    var elSaveButton = document.getElementById("buttonSaveObject");

    // Change Button Text
    elSaveButton.innerHTML = elSaveButton.getAttribute("data-loading-text");
    elSaveButton.setAttribute("data-loading", "1");

    var id = objObject["id"];

    // Insert/Update HTMLDB
    var elTR = document.getElementById("divStepStateHTMLDB_tr" + id);

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
    HTMLDB.write("divStepStateHTMLDB");
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
    var strTR1Prefix = "divStepStateHTMLDB_tr";
    var strTR2Prefix = "divStepStateTableHTMLDB_tr";

    for (var i = 0; i < lObjectIDCount; i++) {
        document.getElementById(strTR1Prefix + arrObjectIDs[i]).className = "deleted";
        $("#" + strTR2Prefix + arrObjectIDs[i]).detach();
    }
    
    $(".spanSelection").html("");       
    
    for (var i = 0; i < lObjectIDCount; i++) {
        $("." + "tr" + arrObjectIDs[i]).detach();
    }
    
    HTMLDB.write("divStepStateHTMLDB");

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
    

    // Initialize Variable Values
    var arrClassProperties = HTMLDB.getColumnNames("divStepStateHTMLDB");
    var lClassPropertyCount = arrClassProperties.length;
    var elTR = document.getElementById("divStepStateHTMLDB_tr" + id);
    var objObject = null;

    if (elTR) {

        objObject = HTMLDB.get("divStepStateHTMLDB", id);
        for (var i = 0; i < lClassPropertyCount; i++) {
            setInputValue(arrClassProperties[i], objObject[arrClassProperties[i]]);
        }

    }
    document.getElementById("buttonSaveObject").setAttribute("data-object-id", id);
}