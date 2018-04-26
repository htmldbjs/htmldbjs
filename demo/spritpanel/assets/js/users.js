$(function() {

    initializeApplication();
    initializePage();

});

function initializePage() {

    initializeHTMLDB();
    initializeTableList();

    $(".buttonPageFABAdd").off("click").on("click", function() {
        doAddObjectButtonClick(this);
    });

    $("#buttonCancelObjectDialog").off("click").on("click", function() {
        doCancelObjectButtonClick(this);
    });

    $("#buttonGenerateAPIKeys").off("click").on("click", function () {
        doGenerateAPIKeysButtonClick(this);
    });

    $("#buttonSaveObject").off("click").on("click", function() {
        doSaveObjectButtonClick(this);
    });

    $("#buttonSaveUserPermissions").off("click").on("click", function () {
        doSaveUserPermissionsClick(this);
    })

    $("#aDeleteObjects").off("click").on("click", function() {
        deleteObjects(0);
    });

    $(".buttonOpenDialog").off("click").on("click", function() {
        doOpenDialogButtonClick(this);
    });

    $("#buttonGrantApplyAll").off("click").on("click", function () {
        doGrantApplyAllButtonClick(this);
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

    var $divs = $('#divObjectListContainer, #divGhostHeaderContainer');
    var synchronizeScrolling = function(e) {

        var $other = $divs.not(this).off("scroll"), other = $other.get(0);
        var percentage = this.scrollLeft / (this.scrollWidth - this.offsetWidth);
        other.scrollLeft = percentage * (other.scrollWidth - other.offsetWidth);
        $other.on("scroll", synchronizeScrolling);

    }

    $divs.on("scroll", synchronizeScrolling);

}

function initializeHTMLDB() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    
    HTMLDB.initialize({
        elementID:"divUserHTMLDB",
        readURL:(URLPrefix + "users/readusers"),
        readAllURL:(URLPrefix + "users/readusers/all"),
        writeURL:(URLPrefix + "users/writeusers"),
        validateURL:(URLPrefix + "users/validateuser"),
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
        onWrite:doHTMLDBUserWrite,
        onRender:doHTMLDBUserRenderAll,
        onRenderAll:doHTMLDBUserRenderAll
    });

    HTMLDB.initialize({
        elementID:"divMenuHTMLDB",
        readURL:(URLPrefix + "users/readmenus"),
        readAllURL:(URLPrefix + "users/readmenus"),
        writeURL:null,
        autoRefresh:0,
        renderElements:[{
            templateElementID:"divMenuPermissionsTemplate",
            targetElementID:"divMenuPermissions"            
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:doHTMLDBMenuRenderAll
    });    

    HTMLDB.initialize({
        elementID:"divClassHTMLDB",
        readURL:(URLPrefix + "users/readclasses"),
        readAllURL:(URLPrefix + "users/readclasses"),
        writeURL:null,
        autoRefresh:0,
        renderElements:[{
            templateElementID:"divClassPermissionsTemplate",
            targetElementID:"divClassPermissions"            
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:doHTMLDBClassRenderAll
    });

    HTMLDB.initialize({
        elementID:"divSessionHTMLDB",
        readURL:(URLPrefix + "users/readsession"),
        readAllURL:(URLPrefix + "users/readsession"),
        writeURL:(URLPrefix + "users/writesession"),
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

        HTMLDB.read("divUserHTMLDB", false, function () {

            sender.disabled = false;
            HTMLDB.renderAll("divUserHTMLDB");

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
        document.getElementById("divUserHTMLDB_tbody").innerHTML = "";
        document.getElementById("tbodyObjectList").innerHTML = "";
        document.getElementById("tbodyGhostObjectList").innerHTML = "";
        HTMLDB.read("divUserHTMLDB", true);

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
        document.getElementById("divUserHTMLDB_tbody").innerHTML = "";
        document.getElementById("tbodyObjectList").innerHTML = "";
        document.getElementById("tbodyGhostObjectList").innerHTML = "";
        HTMLDB.read("divUserHTMLDB", true);

    });

}

function doGrantApplyAllButtonClick(sender) {

    if (!sender) {
        return;
    }

    var arrPermissionInputs = $("select.lPermission");
    var lPermissionCount = arrPermissionInputs.length;
    var elPermissionInput = null;

    for (var i = 0; i < lPermissionCount; i++) {

        elPermissionInput = arrPermissionInputs[i];
        setInputValue(elPermissionInput.id, getInputValue("lApplyAllPermission"));

    }

}

function doOpenDialogButtonClick(sender) {

    if (!sender) {
        return;
    }

    var strDIVID = sender.getAttribute("data-open-dialog");

    if (document.getElementById(strDIVID)) {
        showDialog(strDIVID);
    }    

}

function doGenerateAPIKeysButtonClick(sender) {

    if (!sender) {
        return;
    }

    document.getElementById("publicAPIKey").value
            = generateAPIKey();
    document.getElementById("privateAPIKey").value
            = generateAPIKey()
            + "-"
            + generateAPIKey()
            + "-"
            + generateAPIKey();

}

function generateAPIKey() {

    var strToken = 'xxxx-xxxx-xxxx-xxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;return v.toString(16);
    });

    return strToken;

}

function doHTMLDBUserWrite() {
    HTMLDB.read("divUserHTMLDB", true);
}

function doHTMLDBUserRenderAll() {

    initializeObjects();
    updateObjectListStatistics();
    stepProgressBar(100);

}

function doHTMLDBMenuRenderAll() {
    initializeSelectize();
}

function doHTMLDBClassRenderAll() {
    initializeSelectize();
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

function initializeSelectize() {

    var arrInputs = $("select.selectSelectizeStandard");
    var lInputCount = arrInputs.length;
    var elInput = null;

    for (var i = 0; i < lInputCount; i++) {

        elInput = arrInputs[i];
        if (elInput.selectize) {
            elInput.selectize.destroy();
        }
        $(elInput).selectize({
            sortField: "text"
        });
        setInputValue(elInput.id, elInput.getAttribute("data-initial-value"));

    }

}

function doWindowScroll() {

    var strActivePage = document.body.getAttribute("data-active-page-csv");
    document.getElementById("divGhostHeaderContainer").style.display = "none";

    if (strActivePage == "divObjectsContent") {
        if ($(window).scrollTop() > 191) {
            document.getElementById("divGhostHeaderContainer").style.display = "block";
        }
    }

}

function doSelectObjectCheckboxClick(sender) {

    if (!sender) {
        return;
    }

    var bChecked = sender.checked;

    if (bChecked) {
        $(sender.parentNode.parentNode.parentNode).addClass("trChecked");
    } else {
        $(sender.parentNode.parentNode.parentNode).removeClass("trChecked");
    }

    var lCheckedCheckboxCount = 0;
    lCheckedCheckboxCount = $("#tbodyObjectList  .bSelectObject:checked").length;

    if (0 == lCheckedCheckboxCount) {
        $(".spanSelection").html(" (0)");
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
            $(elInput.parentNode.parentNode.parentNode).addClass("trChecked");

        }

    } else {

        for (var i = 0; i < lCountInput; i++) {

            elInput = arrInputs[i];
            elInput.checked = false;
            $(elInput.parentNode.parentNode.parentNode).removeClass("trChecked");

        }

    }

    var lCheckedCheckboxCount = 0;
    lCheckedCheckboxCount = $("#tbodyObjectList .bSelectObject:checked").length;

    if (0 == lCheckedCheckboxCount) {
        $(".spanSelection").html(" (0)");
    } else {
        $(".spanSelection").html(" (" + lCheckedCheckboxCount + ")");
    }

    updateObjectListStatistics();

}

function doChangePasswordCheckboxClick(sender) {

    if (!sender) {
        return;
    }

    var checked = sender.checked;

    if (checked) {
        document.getElementById("divChangePassword").style.display = "block";
    } else {
        document.getElementById("divChangePassword").style.display = "none";
    }

}

function doEditObjectButtonClick(sender) {

    if (!sender) {
        return;
    }

    if (!sender) {
        return;
    }

    var lID = sender.getAttribute("data-object-id");
    loadObject(lID);

    $(".user-form-content").css("display", "none");
    $(".edit-user-form-content").css("display", "block");

    $("#bChangePassword").off("click").on("click", function () {
        doChangePasswordCheckboxClick(this);
    });

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

    $(".user-form-content").css("display", "none");
    $(".new-user-form-content").css("display", "block");

    hidePage("divObjectsContent");
    showPage("divObjectContent");

}

function doSaveUserPermissionsClick(sender) {

    if (!sender) {
        return;
    }

    permissionsCSV = "";

    permissionInputs = $("#divMenuPermissions select.lPermission");
    permissionInputCount = permissionInputs.length;

    for (var i = 0; i < permissionInputCount; i++) {

        if (permissionsCSV != "") {
            permissionsCSV += ",";
        }
        permissionsCSV += permissionInputs[i].getAttribute("data-identifier")
                + ":"
                + getInputValue(permissionInputs[i].id);

    }

    permissionInputs = $("#divClassPermissions select.lPermission");
    permissionInputCount = permissionInputs.length;

    for (var i = 0; i < permissionInputCount; i++) {

        if (permissionsCSV != "") {
            permissionsCSV += ",";
        }
        permissionsCSV += permissionInputs[i].getAttribute("data-identifier")
                + ":"
                + getInputValue(permissionInputs[i].id);

    }

    setInputValue("permissionsCSV", permissionsCSV);
    hideDialog("divUserPermissionsDialog");

}

function doSaveObjectButtonClick(sender) {

    if (!sender) {
        return;
    }

    checkMySQLConnection(function () {

        var lID = sender.getAttribute("data-object-id");
        saveObject(lID);

    });

}

function doCancelObjectButtonClick(sender) {

    hidePage("divObjectContent");
    loadObjects();

}

function saveObject(lID) {

    var strHTMLDBDIVID = ("divUserHTMLDB");
    var arrClassProperties = HTMLDB.getColumnNames(strHTMLDBDIVID);
    var lClassPropertyCount = arrClassProperties.length;
    var elSaveButton = document.getElementById("buttonSaveObject");
    var objObject = {};

    objObject["lID"] = 0;

    if (lID > 0) {
        objObject = HTMLDB.get(strHTMLDBDIVID, lID);
    }

    // Change Button Text
    elSaveButton.innerHTML = elSaveButton.getAttribute("data-loading-text");
    elSaveButton.setAttribute("data-loading", "1");

    for (var i = 0; i < lClassPropertyCount; i++) {
        objObject[arrClassProperties[i]] = getInputValue(arrClassProperties[i]);
    }

    HTMLDB.validate("divUserHTMLDB", objObject, function (strDIVID, strResponse) {

        var objResponse = JSON.parse(String(strResponse).trim());
        if (objResponse.errorCount > 0) {      
            showErrorDialog(objResponse.lastError);
        } else {

            // Insert/Update HTMLDB
            var elTR = document.getElementById("divUserHTMLDB_tr" + lID);

            if (elTR) {
                HTMLDB.update(strHTMLDBDIVID, lID, objObject);
            } else {
                HTMLDB.insert(strHTMLDBDIVID, objObject);
            }

            hidePage("divObjectContent");
            document.getElementById("buttonPageFABAdd").style.display = "inline-block";
            /*document.getElementById("buttonPageTopMenuPrevious").style.display = "inline-block";
            document.getElementById("buttonPageTopMenuNext").style.display = "inline-block";*/
            document.getElementById("buttonPageTopMenuMore").style.display = "inline-block";
            showPage("divObjectsContent");

            HTMLDB.write("divUserHTMLDB");

        }

        elSaveButton.innerHTML = elSaveButton.getAttribute("data-default-text");

    });

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

function doDeleteConfirmButtonClick(sender) {

    var strObjectIDCSV = sender.getAttribute("data-object-id-csv");
    var arrObjectIDs = strObjectIDCSV.split(",");
    var lObjectIDCount = arrObjectIDs.length;
    var strTRPrefix = "divUserHTMLDB_tr";

    for (var i = 0; i < lObjectIDCount; i++) {
        document.getElementById(strTRPrefix + arrObjectIDs[i]).className = "deleted";
    }
    
    $(".spanSelection").html(" (0)");

    for (var i = 0; i < lObjectIDCount; i++) {
        $("." + "tr" + arrObjectIDs[i]).detach();
    }
    
    HTMLDB.write("divUserHTMLDB");
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

function loadObject(lID) {

    document.getElementById("buttonPageFABAdd").style.display = "none";
    document.getElementById("h4PageHeader").style.display = "none"
    document.getElementById("buttonPageTopMenuMore").style.display = "none";

    document.getElementById("formObject").reset();
    document.getElementById("id").value = 0;
    document.getElementById("permissionsCSV").value = "";

    // Initialize Variable Values
    var arrClassProperties = HTMLDB.getColumnNames("divUserHTMLDB");
    var lClassPropertyCount = arrClassProperties.length;
    var elTR = document.getElementById("divUserHTMLDB_tr" + lID);
    var objObject = null;

    if (elTR) {

        objObject = HTMLDB.get("divUserHTMLDB", lID);   
        for (var i = 0; i < lClassPropertyCount; i++) {
            setInputValue(arrClassProperties[i], objObject[arrClassProperties[i]]);
        }       

    }

    if (0 == lID) {
        setInputValue("changePassword", true);
    }

    updateUserPermissionInputs();
    document.getElementById("buttonSaveObject").setAttribute("data-object-id", lID);
    refreshShowHideElements("divObjectContent");

}

function updateUserPermissionInputs() {

    permissionInputs = $("#divMenuPermissions select.lPermission");
    permissionInputCount = permissionInputs.length;
    permissionElements = new Array();

    for (var i = 0; i < permissionInputCount; i++) {

        setInputValue(permissionInputs[i].id, 0);
        permissionElements[permissionInputs[i].getAttribute("data-identifier")]
                = permissionInputs[i].id;

    }

    permissionInputs = $("#divClassPermissions select.lPermission");
    permissionInputCount = permissionInputs.length;

    for (var i = 0; i < permissionInputCount; i++) {

        setInputValue(permissionInputs[i].id, 0);
        permissionElements[permissionInputs[i].getAttribute("data-identifier")]
                = permissionInputs[i].id;

    }

    userPermissions = String(getInputValue("permissionsCSV")).split(",");
    userPermissionCount = userPermissions.length;

    permissonTokens = new Array();
    identifier = "";
    permissionType = 0;

    for (var i = 0; i < userPermissionCount; i++) {

        permissonTokens = String(userPermissions[i]).split(":");

        if (permissonTokens.length != 2) {
            continue;
        }

        identifier = permissonTokens[0];
        permissionType = permissonTokens[1];

        if (permissionElements[identifier]) {
            setInputValue(permissionElements[identifier], permissionType);
        }

    }

}