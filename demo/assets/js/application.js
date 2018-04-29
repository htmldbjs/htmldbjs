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

	$("#divLoader").velocity("fadeIn", 300);
    window.onbeforeunload = confirmExit;

    $("#ulApplicationTaskCategory .tab a").on("click", function () {
        doApplicationTaskCategoryLinkClick(this);
    });

    $("#buttonDownloadPhotos").off("click").on("click", function () {
        doDownloadPhotosButtonClick(this);
    });

}
function confirmExit() {

	var elements = $(".HTMLDBAction.HTMLDBLoopWriter,.HTMLDBAction.HTMLDBLoopReader");
	var elementCount = elements.length;
	var element = null;

	for (var i = 0; i < elementCount; i++) {

		element = elements[i];

		if (1 == parseInt(element.getAttribute("data-loading"))) {
            return false;
        }

	}

}
function extractApplicationId() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var URLTokens = window.location.href.split(URLPrefix + "application/");
    var Id = 0;

    if (URLTokens.length > 0) {
    	Id = parseInt(URLTokens[1]);
    }

    if (isNaN(Id)) {
    	Id = 0;
    }

    return Id;

}
function doEditApplicationSubTaskButtonClick(sender) {

    if (!sender) {
        return;
    }

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var applicationTaskId = sender.getAttribute("data-htmldb-row-id");

    HTMLDB.initialize({
        elementID:"divApplicationSubTaskHTMLDBWriter",
        readURL:(URLPrefix + "application/readapplicationsubtask/nodata"),
        readAllURL:(URLPrefix + "application/readapplicationsubtask/nodata"),
        validateURL:(URLPrefix + "application/validateapplicationsubtask"),
        writeURL:(URLPrefix + "application/writeapplicationsubtask"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divApplicationSubTaskHTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationsubtask/" + applicationTaskId),
        readAllURL:(URLPrefix + "application/readapplicationsubtask/" + applicationTaskId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyApplicationSubTaskListTemplate",
            targetElementID:"tbodyApplicationSubTaskList"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doApplicationSubTaskHTMLDBReaderRender,
        onRenderAll:doApplicationSubTaskHTMLDBReaderRender
    });

    document.getElementById("addApplicationSubTaskApplicationTaskId").value = applicationTaskId;
    document.getElementById("editApplicationSubTaskApplicationTaskId").value = applicationTaskId;
    document.getElementById("addApplicationSubTaskApplicationTaskId").setAttribute("data-reset-value", applicationTaskId);
    document.getElementById("editApplicationSubTaskApplicationTaskId").setAttribute("data-reset-value", applicationTaskId);

    showDialog("divEditApplicationSubTasksDialog");

}
function doApplicationTaskCategoryLinkClick(sender) {

    var index = sender.getAttribute("data-index");

    for (var i = 1; i <= 6; i++) {
        document.getElementById("application_task" + i + "_list").style.display = "none";
    }

    if (0 == index) {
        for (var i = 1; i <= 6; i++) {
            document.getElementById("application_task" + i + "_list").style.display = "block";
        }
    } else {
        document.getElementById("application_task" + index + "_list").style.display = "block";
    }

}
function initializeHTMLDB() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var applicationId = extractApplicationId();

    HTMLDB.initialize({
        elementID:"divApplicationTaskCategoryHTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationtaskpropertyoptions/application_task_category_id"),
        readAllURL:(URLPrefix + "application/readapplicationtaskpropertyoptions/application_task_category_id"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doApplicationTaskCategoryHTMLDBReaderRead,
        onRead:doApplicationTaskCategoryHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divApplicationTaskStateHTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationtaskpropertyoptions/application_task_state_id"),
        readAllURL:(URLPrefix + "application/readapplicationtaskpropertyoptions/application_task_state_id"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doApplicationTaskStateHTMLDBReaderRead,
        onRead:doApplicationTaskStateHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divApplicationTaskCrewHTMLDBReader",
        readURL:(URLPrefix + "application/readcrew/" + applicationId),
        readAllURL:(URLPrefix + "application/readcrew/" + applicationId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doApplicationTaskCrewHTMLDBReaderRead,
        onRead:doApplicationTaskCrewHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divApplicationHTMLDBWriter",
        readURL:(URLPrefix + "application/read/nodata"),
        readAllURL:(URLPrefix + "application/read/nodata"),
        validateURL:(URLPrefix + "application/validate"),
        writeURL:(URLPrefix + "application/write"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divApplicationHTMLDBReader",
        readURL:(URLPrefix + "application/read/" + applicationId),
        readAllURL:(URLPrefix + "application/read/" + applicationId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doApplicationHTMLDBReaderRead,
        onRead:doApplicationHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divApplicationTaskHTMLDBWriter",
        readURL:(URLPrefix + "application/readapplicationtask/nodata"),
        readAllURL:(URLPrefix + "application/readapplicationtask/nodata"),
        validateURL:(URLPrefix + "application/validateapplicationtask"),
        writeURL:(URLPrefix + "application/writeapplicationtask"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divApplicationTaskHTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationtask/" + applicationId),
        readAllURL:(URLPrefix + "application/readapplicationtask/" + applicationId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyApplicationTaskListTemplate",
            targetElementID:"tbodyApplicationTaskList"
        }],
        onReadAll:doApplicationTaskHTMLDBReaderRead,
        onRead:doApplicationTaskHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divApplicationTask1HTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/1"),
        readAllURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/1"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyApplicationTask1ListTemplate",
            targetElementID:"tbodyApplicationTask1List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doApplicationTask1HTMLDBReaderRender,
        onRenderAll:doApplicationTask1HTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divApplicationTask2HTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/2"),
        readAllURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/2"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyApplicationTask2ListTemplate",
            targetElementID:"tbodyApplicationTask2List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doApplicationTask1HTMLDBReaderRender,
        onRenderAll:doApplicationTask1HTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divApplicationTask3HTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/3"),
        readAllURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/3"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyApplicationTask3ListTemplate",
            targetElementID:"tbodyApplicationTask3List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doApplicationTask1HTMLDBReaderRender,
        onRenderAll:doApplicationTask1HTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divApplicationTask4HTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/4"),
        readAllURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/4"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyApplicationTask4ListTemplate",
            targetElementID:"tbodyApplicationTask4List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doApplicationTask1HTMLDBReaderRender,
        onRenderAll:doApplicationTask1HTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divApplicationTask5HTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/5"),
        readAllURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/5"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyApplicationTask5ListTemplate",
            targetElementID:"tbodyApplicationTask5List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doApplicationTask1HTMLDBReaderRender,
        onRenderAll:doApplicationTask1HTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divApplicationTask6HTMLDBReader",
        readURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/6"),
        readAllURL:(URLPrefix + "application/readapplicationtask/" + applicationId + "/6"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyApplicationTask6ListTemplate",
            targetElementID:"tbodyApplicationTask6List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doApplicationTask1HTMLDBReaderRender,
        onRenderAll:doApplicationTask1HTMLDBReaderRender
    });
    
}
function doApplicationStateHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divApplicationStateHTMLDBReader");
}
function doApplicationHTMLDBReaderRead() {
    if ("" == document.getElementById("divApplicationHTMLDBReader_tbody").innerHTML) {
        window.location = (document.body.getAttribute("data-url-prefix") + "home");
    }

	setHTMLDBFieldContents("divApplicationHTMLDBReader");
    setHTMLDBFieldValues("divApplicationHTMLDBReader");
	setHTMLDBFieldAttributes("divApplicationHTMLDBReader");

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    $(".aCompanyNameLink").attr("href", (URLPrefix
            + "company/"
            + document.getElementById("spanCompanyId").innerHTML));
    $(".aUnitNameLink").attr("href", (URLPrefix
            + "unit/"
            + document.getElementById("spanUnitId").innerHTML));

    document.getElementById("editApplicationTaskApplicationId").value
            = extractApplicationId();
    document.getElementById("editApplicationTaskApplicationId").setAttribute(
            "data-reset-value",
            document.getElementById("editApplicationTaskApplicationId").value);

    document.getElementById("addApplicationTaskApplicationId").value
            = document.getElementById("editApplicationTaskApplicationId").value;
    document.getElementById("addApplicationTaskApplicationId").setAttribute(
            "data-reset-value",
            document.getElementById("editApplicationTaskApplicationId").value);

    initializeHTMLDBHelpers();

}
function doApplicationTask1HTMLDBReaderRender() {
    initializeHTMLDBHelpers();

    $(".buttonEditApplicationSubTask").off("click").on("click", function () {
        doEditApplicationSubTaskButtonClick(this);
    });
    
    $(".buttonAddTaskPhoto").off("click").on("click", function() {
        doAddTaskPhotoButtonClick(this);
    });

    renderTaskIMGCounts();

    var exit = false;
    for (var i = 1; ((i <= 6) && (!exit)); i++) {

        if ("" == document.getElementById("tbodyApplicationTask" + i + "List").innerHTML) {
            exit = true;
        }

    }

    if (!exit) {
        document.getElementById("divLoader").style.display = "none";
    }

}
function renderTaskIMGCounts() {
    for (var s = 1; s < 7; s++) {
        strHTMLDBDIVID = "divApplicationTask" + s + "HTMLDBReader";
        elTBODY = document.getElementById("divApplicationTask" + s + "HTMLDBReader_tbody");
        
        arrHTMLDBTR = $("tr", elTBODY);
        trCount = arrHTMLDBTR.length;

        for (var i = 0; i < trCount; i++) {
            rowId = arrHTMLDBTR[i].getAttribute("data-row-id");
            object = HTMLDB.get(strHTMLDBDIVID, rowId);
            if ("" != object["photos"]) {                
                spanIMGCount = (object["photos"].match(/media\//g) || []).length;
                elSPAN = document.getElementById("spanTaskIMGCount" + rowId);
                elSPAN.innerHTML = spanIMGCount;
                elSPAN.parentNode.style.color = "#2e7d32";
            }
        }
    }
}
function doSatisfiedYesButtonClick(sender) {

    if (!sender) {
        return false;
    }

    var rowId = sender.getAttribute("data-row-id");
    var object = HTMLDB.get("divApplicationTaskHTMLDBReader", rowId);

    object["yes"] = 1;
    object["no"] = 0;

    HTMLDB.insert("divApplicationTaskHTMLDBWriter", object);
    document.getElementById("divApplicationTaskHTMLDBWriter").setAttribute("data-htmldb-reader", "");
    HTMLDB.write("divApplicationTaskHTMLDBWriter", true, function () {

        document.getElementById("divApplicationTaskHTMLDBWriter_tbody").innerHTML = "";
        document.getElementById("divApplicationTaskHTMLDBWriter").setAttribute(
                "data-htmldb-reader",
                "divApplicationTaskHTMLDBReader");

    });

    $("#buttonSatisfiedNo" + rowId).removeClass("buttonSatisfiedNo1");
    $("#buttonSatisfiedNo" + rowId).addClass("buttonSatisfiedNo0");
    $("#buttonSatisfiedYes" + rowId).removeClass("buttonSatisfiedYes0");
    $("#buttonSatisfiedYes" + rowId).addClass("buttonSatisfiedYes1");

}
function doSatisfiedNoButtonClick(sender) {

    if (!sender) {
        return false;
    }

    var rowId = sender.getAttribute("data-row-id");
    var object = HTMLDB.get("divApplicationTaskHTMLDBReader", rowId);

    object["yes"] = 0;
    object["no"] = 1;

    HTMLDB.insert("divApplicationTaskHTMLDBWriter", object);
    document.getElementById("divApplicationTaskHTMLDBWriter").setAttribute("data-htmldb-reader", "");
    HTMLDB.write("divApplicationTaskHTMLDBWriter", true, function () {

        document.getElementById("divApplicationTaskHTMLDBWriter_tbody").innerHTML = "";
        document.getElementById("divApplicationTaskHTMLDBWriter").setAttribute(
                "data-htmldb-reader",
                "divApplicationTaskHTMLDBReader");

    });

    $("#buttonSatisfiedYes" + rowId).removeClass("buttonSatisfiedYes1");
    $("#buttonSatisfiedYes" + rowId).addClass("buttonSatisfiedYes0");
    $("#buttonSatisfiedNo" + rowId).removeClass("buttonSatisfiedNo0");
    $("#buttonSatisfiedNo" + rowId).addClass("buttonSatisfiedNo1");

}
function doApplicationTaskCategoryHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divApplicationTaskCategoryHTMLDBReader");
}
function doApplicationTaskStateHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divApplicationTaskStateHTMLDBReader");
}
function doApplicationTaskCrewHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divApplicationTaskCrewHTMLDBReader");
}
function doApplicationTaskHTMLDBReaderRead() {

    document.getElementById("divApplicationTask1HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divApplicationTask1HTMLDBReader", true);

    document.getElementById("divApplicationTask2HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divApplicationTask2HTMLDBReader", true);

    document.getElementById("divApplicationTask3HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divApplicationTask3HTMLDBReader", true);

    document.getElementById("divApplicationTask4HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divApplicationTask4HTMLDBReader", true);

    document.getElementById("divApplicationTask5HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divApplicationTask5HTMLDBReader", true);

}
function doApplicationSubTaskHTMLDBReaderRender() {
    initializeHTMLDBHelpers();

    $(".buttonAddSubTaskPhoto").off("click").on("click", function() {
        doAddSubTaskPhotoButtonClick(this);
    });

    renderSubTaskIMGCounts();
}
function renderSubTaskIMGCounts() {
    strHTMLDBDIVID = "divApplicationSubTaskHTMLDBReader";
    elTBODY = document.getElementById("divApplicationSubTaskHTMLDBReader_tbody");
    
    arrHTMLDBTR = $("tr", elTBODY);
    trCount = arrHTMLDBTR.length;

    for (var i = 0; i < trCount; i++) {
        rowId = arrHTMLDBTR[i].getAttribute("data-row-id");
        object = HTMLDB.get(strHTMLDBDIVID, rowId);
        if ("" != object["photos"]) {                
            spanIMGCount = (object["photos"].match(/media\//g) || []).length;
            elSPAN = document.getElementById("spanSubTaskIMGCount" + rowId);
            elSPAN.innerHTML = spanIMGCount;
            elSPAN.parentNode.style.color = "#2e7d32";
        }
    }
}
function doDownloadPhotosButtonClick(sender) {
    document.getElementById("formCreateZip").submit();
}