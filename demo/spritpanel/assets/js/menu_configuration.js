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

    $("#buttonSaveObject").off("click").on("click", function() {
        doSaveObjectButtonClick(this);
    });

    $("#aDeleteObjects").off("click").on("click", function() {
        deleteObjects(0);
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
        elementID:"divMenuHTMLDB",
        readURL:(URLPrefix + "menu_configuration/read"),
        readAllURL:(URLPrefix + "menu_configuration/read/all"),
        writeURL:(URLPrefix + "menu_configuration/write"),
        validateURL:(URLPrefix + "menu_configuration/validate"),
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
        onWrite:doHTMLDBObjectWrite,
        onRender:null,
        onRenderAll:doHTMLDBObjectRenderAll
    });

}

function doHTMLDBObjectWrite() {
    HTMLDB.read("divMenuHTMLDB", true);
}

function doHTMLDBObjectRenderAll() {

    initializeObjects();
    initializeSelectize();
    updateObjectListStatistics();
    updateNoneditableObjects();
    stepProgressBar(100);

}

function updateNoneditableObjects() {

    disabledDeleteButtons = $(".buttonDeleteObject.buttonEditable0");
    deleteButtonCount = disabledDeleteButtons.length;
    for (var i = 0; i < deleteButtonCount; i++) {
        disabledDeleteButtons[i].disabled = true;
    }

    disabledEditButtons = $(".buttonEditObject.buttonEditable0");
    editButtonCount = disabledEditButtons.length;

    for (var i = 0; i < editButtonCount; i++) {

        button = disabledEditButtons[i];
        button.disabled = true;

        objectId = button.getAttribute("data-object-id");
        $(".tr" + objectId).addClass("trDisabled");
        document.getElementById("bSelectObject" + objectId).disabled = true;

    }

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

    var selectParentIdContent = "";
    var optionTemplate = document.getElementById("parentIdTemplate").innerHTML;
    var currentOptionCode = "";
    var TDPrefix = "divMenuHTMLDB_td";
    var editable = false;
    var parentId = "";
    var rowId = "";
    var TRs = $("#divMenuHTMLDB_tbody>tr");
    var TRCount = TRs.length;

    for (var i = 0; i < TRCount; i++) {

        rowId = TRs[i].getAttribute("data-row-id");
        
        editable = parseInt(document.getElementById(TDPrefix + rowId + "editable").innerHTML);

        if (!editable) {
            continue;
        }

        parentId = document.getElementById(TDPrefix + rowId + "parentId").innerHTML;

        if ("" == parentId) {

            optionId = document.getElementById(TDPrefix + rowId + "id").innerHTML;
            optionName = document.getElementById(TDPrefix + rowId + "name").innerHTML;
            currentOptionCode = optionTemplate;
            currentOptionCode = currentOptionCode
                    .replace(/__OPTION_ID__/g, optionId)
                    .replace(/__OPTION_NAME__/g, optionName);

            selectParentIdContent = selectParentIdContent + currentOptionCode;

        }

    }

    var elSelect = document.getElementById("parentId");
    if (elSelect.selectize) {
        elSelect.selectize.destroy();
    }

    selectParentIdContent = (document.getElementById("parentIdTemplateHeader").innerHTML
            + selectParentIdContent);
    document.getElementById("parentId").innerHTML = selectParentIdContent;

    if ($(".selectSelectizeStandard").length > 0) {

        $(".selectSelectizeStandard").selectize({
            allowEmptyOption: true,
            sortField: "value"
        });

    }

}

function doWindowScroll() {

    var activePage = document.body.getAttribute("data-active-page-csv");
    document.getElementById("divGhostHeaderContainer").style.display = "none";

    if (activePage == "divObjectsContent") {

        if ($(window).scrollTop() > 126) {
            document.getElementById("divGhostHeaderContainer").style.display = "block";
        }

    }

}

function doSelectObjectCheckboxClick(sender) {

    if (!sender) {
        return;
    }

    var checked = sender.checked;

    if (checked) {
        $(sender.parentNode.parentNode.parentNode).addClass("trChecked");
    } else {
        $(sender.parentNode.parentNode.parentNode).removeClass("trChecked");
    }

    var checkedCheckboxCount = 0;
    checkedCheckboxCount = $("#tbodyObjectList  .bSelectObject:checked").length;

    if (0 == checkedCheckboxCount) {
        $(".spanSelection").html(" (0)");
    } else {
        $(".spanSelection").html(" (" + checkedCheckboxCount + ")");
    }

    var checkboxCount = $("#tbodyObjectList  .bSelectObject").length;
    var disabledCount = $("#tbodyObjectList .trDisabled").length;

    if (checkboxCount <= (checkedCheckboxCount + disabledCount)) {
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

    var checked = sender.checked;

    if (sender.id != "bSelectObjects") {
        document.getElementById("bSelectObjects").checked = checked;
    }

    if (sender.id != "bSelectObjectsGhost") {
        document.getElementById("bSelectObjectsGhost").checked = checked;        
    }

    document.getElementById("bSelectObjects").checked = checked;

    var inputs = $(".bSelectObject");
    var inputCount = inputs.length;
    var input = null;

    if (checked) {

        for (var i = 0; i < inputCount; i++) {

            input = inputs[i];
            if (input.disabled) {
                continue;
            }
            input.checked = true;
            $(input.parentNode.parentNode.parentNode).addClass("trChecked");

        }

    } else {

        for (var i = 0; i < inputCount; i++) {

            input = inputs[i];
            input.checked = false;
            $(input.parentNode.parentNode.parentNode).removeClass("trChecked");

        }

    }

    var checkedCheckboxCount = 0;
    checkedCheckboxCount = $("#tbodyObjectList .bSelectObject:checked").length;

    if (0 == checkedCheckboxCount) {
        $(".spanSelection").html(" (0)");
    } else {
        $(".spanSelection").html(" (" + checkedCheckboxCount + ")");
    }

    updateObjectListStatistics();

}

function doEditObjectButtonClick(sender) {

    if (!sender) {
        return;
    }

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

    $(".user-form-content").css("display", "none");
    $(".new-user-form-content").css("display", "block");

    hidePage("divObjectsContent");
    showPage("divObjectContent");

}

function doSaveObjectButtonClick(sender) {

    if (!sender) {
        return;
    }

    checkFTPConnection(function () {

        var id = sender.getAttribute("data-object-id");
        saveObject(id);

    });

}


function doCancelObjectButtonClick(sender) {

    hidePage("divObjectContent");
    loadObjects();

}

function saveObject(id) {

    var HTMLDBElementId = ("divMenuHTMLDB");
    var classProperties = HTMLDB.getColumnNames(HTMLDBElementId);
    var classPropertyCount = classProperties.length;
    var saveButton = document.getElementById("buttonSaveObject");
    var object = {};

    if ("" != id) {
        object = HTMLDB.get(HTMLDBElementId, id);
    }

    // Change Button Text
    saveButton.innerHTML = saveButton.getAttribute("data-loading-text");
    saveButton.setAttribute("data-loading", "1");

    for (var i = 0; i < classPropertyCount; i++) {
        object[classProperties[i]] = getInputValue(classProperties[i]);
    }

    if ("" != id) {
        object["id"] = id;
    } else {

        object["id"] = "undefined";
        object["strLanguageConstant"] = document.getElementById("name").value;

    }

    HTMLDB.validate("divMenuHTMLDB", object, function (DIVId, responseText) {

        var response = JSON.parse(responseText);

        if (response.errorCount > 0) {
            showErrorDialog(response.lastError);
        } else {

            // Insert/Update HTMLDB
            var TR = document.getElementById("divMenuHTMLDB_tr" + id);

            if (TR) {
                HTMLDB.update(HTMLDBElementId, id, object);
            } else {
                HTMLDB.insert(HTMLDBElementId, object);
            }

            HTMLDB.write("divMenuHTMLDB");
            hidePage("divObjectContent");
            document.getElementById("buttonPageFABAdd").style.display = "inline-block";
            document.getElementById("buttonPageTopMenuMore").style.display = "inline-block";
            showPage("divObjectsContent");

        }

        saveButton.innerHTML = saveButton.getAttribute("data-default-text");

    });

}

function deleteObjects(id) {

    if ("" != id) {
        objectIdCSV = id;
    } else {

        var selectedObjectCount = $("#tbodyObjectList  .bSelectObject:checked").length;

        if (0 == selectedObjectCount) {
            showErrorDialog("Please select minimum one menu object for operation.");
            return false;
        }

        $("#spanDeleteSelection").html("\"" + selectedObjectCount + "\"");

        if (selectedObjectCount > 1) {
            document.getElementById("spanPluralSuffix").style.display = "inline-block";
        } else {
            document.getElementById("spanPluralSuffix").style.display = "none";
        }

        var checkedCheckboxes = $("#tbodyObjectList .bSelectObject:checked");
        var checkedCheckboxCount = checkedCheckboxes.length;
        var objectIdCSV = "";

        for (var i = 0; i < checkedCheckboxCount; i++) {

            if ("" != objectIdCSV) {
                objectIdCSV += ",";
            }
            objectIdCSV += checkedCheckboxes[i].getAttribute("data-object-id");

        }

    }

    document.getElementById("buttonDeleteConfirm").setAttribute("data-object-id-csv", objectIdCSV);    

    $("#buttonDeleteCancel").off("click").on("click", function() {
        doDeleteCancelButtonClick(this);
    });

    $("#buttonDeleteConfirm").off("click").on("click", function() {
        doDeleteConfirmButtonClick(this);
    });

    showDialog("divDeleteDialog");

}

function doDeleteConfirmButtonClick(sender) {

    var objectIdCSV = sender.getAttribute("data-object-id-csv");
    var objectIds = objectIdCSV.split(",");
    var objectIdCount = objectIds.length;
    var TRPrefix = "divMenuHTMLDB_tr";

    for (var i = 0; i < objectIdCount; i++) {
        document.getElementById(TRPrefix + objectIds[i]).className = "deleted";
    }
    
    $(".spanSelection").html("");

    for (var i = 0; i < objectIdCount; i++) {
        $("." + "tr" + objectIds[i]).detach();
    }  
    
    HTMLDB.write("divMenuHTMLDB");

    hideDialog("divDeleteDialog");

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
    document.getElementById("h4PageHeader").style.display = "none"
    document.getElementById("buttonPageTopMenuMore").style.display = "none";

    resetForm(document.getElementById("formObject"));
    setInputValue("editable", 1);
    setInputValue("visible", 1);
    setInputValue("id", id);

    initializeSelectize();

    // Initialize Variable Values
    var TR = document.getElementById("divMenuHTMLDB_tr" + id);
    var object = null;

    if (TR) {

        object = HTMLDB.get("divMenuHTMLDB", id);   

        $('#parentId')[0].selectize.removeOption(object["id"]);

        for (var key in object) { 

           if (object.hasOwnProperty(key)) {
                setInputValue(key, object[key]);
           }

        }

    }

    document.getElementById("buttonSaveObject").setAttribute("data-object-id", id);

}
