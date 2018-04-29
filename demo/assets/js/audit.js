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

    $("#ulAuditStepCategory .tab a").on("click", function () {
        doAuditStepCategoryLinkClick(this);
    });

    $("#buttonDownloadPhotos").off("click").on("click", function () {
        doDownloadPhotosButtonClick(this);
    });

    doAuditStepCategoryLinkClick(document.getElementById("aAuditStepCategoryAll"));

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

    elements = $(".HTMLDBAction.HTMLDBLoopWriter");
    elementCount = elements.length;
    element = null;

    for (var i = 0; i < elementCount; i++) {

        element = elements[i];

        if (document.getElementById(element.id + "_tbody").innerHTML != "") {
            return false;
        }

    }

}
function extractAuditId() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var URLTokens = window.location.href.split(URLPrefix + "audit/");
    var Id = 0;

    if (URLTokens.length > 0) {
    	Id = parseInt(URLTokens[1]);
    }

    if (isNaN(Id)) {
    	Id = 0;
    }

    return Id;

}
function doAuditStepCategoryLinkClick(sender) {

    var index = sender.getAttribute("data-index");

    for (var i = 1; i <= 5; i++) {
        document.getElementById("audit_step" + i + "_list").style.display = "none";
    }

    if (0 == index) {
        for (var i = 1; i <= 5; i++) {
            document.getElementById("audit_step" + i + "_list").style.display = "block";
        }
    } else {
        document.getElementById("audit_step" + index + "_list").style.display = "block";
    }

}
function initializeHTMLDB() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var auditId = extractAuditId();

    HTMLDB.initialize({
        elementID:"divAuditStateHTMLDBReader",
        readURL:(URLPrefix + "audits/readpropertyoptions/audit_state_id"),
        readAllURL:(URLPrefix + "audits/readpropertyoptions/audit_state_id"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doAuditStateHTMLDBReaderRead,
        onRead:doAuditStateHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divAuditStepCategoryHTMLDBReader",
        readURL:(URLPrefix + "audit/readauditsteppropertyoptions/audit_step_category_id"),
        readAllURL:(URLPrefix + "audit/readauditsteppropertyoptions/audit_step_category_id"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doAuditStepCategoryHTMLDBReaderRead,
        onRead:doAuditStepCategoryHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divAuditStepTypeHTMLDBReader",
        readURL:(URLPrefix + "audit/readauditsteppropertyoptions/audit_step_type_id"),
        readAllURL:(URLPrefix + "audit/readauditsteppropertyoptions/audit_step_type_id"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doAuditStepTypeHTMLDBReaderRead,
        onRead:doAuditStepTypeHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divAuditHTMLDBWriter",
        readURL:(URLPrefix + "audit/read/nodata"),
        readAllURL:(URLPrefix + "audit/read/nodata"),
        validateURL:(URLPrefix + "audit/validate"),
        writeURL:(URLPrefix + "audit/write"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divAuditStepHTMLDBWriter",
        readURL:(URLPrefix + "audit/readauditstep/nodata"),
        readAllURL:(URLPrefix + "audit/readauditstep/nodata"),
        validateURL:(URLPrefix + "audit/validateauditstep"),
        writeURL:(URLPrefix + "audit/writeauditstep"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divAuditStepYesHTMLDBWriter",
        readURL:(URLPrefix + "audit/readauditstep/nodata"),
        readAllURL:(URLPrefix + "audit/readauditstep/nodata"),
        validateURL:(URLPrefix + "audit/validateauditstep"),
        writeURL:(URLPrefix + "audit/writeauditstep"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divAuditHTMLDBReader",
        readURL:(URLPrefix + "audit/read/" + auditId),
        readAllURL:(URLPrefix + "audit/read/" + auditId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doAuditHTMLDBReaderRead,
        onRead:doAuditHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divAuditStepHTMLDBReader",
        readURL:(URLPrefix + "audit/readauditstep/" + auditId),
        readAllURL:(URLPrefix + "audit/readauditstep/" + auditId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyAuditStepListTemplate",
            targetElementID:"tbodyAuditStepList"
        }],
        onReadAll:doAuditStepHTMLDBReaderRead,
        onRead:doAuditStepHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divAuditStep1HTMLDBReader",
        readURL:(URLPrefix + "audit/readauditstep/" + auditId + "/1"),
        readAllURL:(URLPrefix + "audit/readauditstep/" + auditId + "/1"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyAuditStep1ListTemplate",
            targetElementID:"tbodyAuditStep1List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doAuditStep1HTMLDBReaderRender,
        onRenderAll:doAuditStep1HTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divAuditStep2HTMLDBReader",
        readURL:(URLPrefix + "audit/readauditstep/" + auditId + "/2"),
        readAllURL:(URLPrefix + "audit/readauditstep/" + auditId + "/2"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyAuditStep2ListTemplate",
            targetElementID:"tbodyAuditStep2List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doAuditStep1HTMLDBReaderRender,
        onRenderAll:doAuditStep1HTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divAuditStep3HTMLDBReader",
        readURL:(URLPrefix + "audit/readauditstep/" + auditId + "/3"),
        readAllURL:(URLPrefix + "audit/readauditstep/" + auditId + "/3"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyAuditStep3ListTemplate",
            targetElementID:"tbodyAuditStep3List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doAuditStep1HTMLDBReaderRender,
        onRenderAll:doAuditStep1HTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divAuditStep4HTMLDBReader",
        readURL:(URLPrefix + "audit/readauditstep/" + auditId + "/4"),
        readAllURL:(URLPrefix + "audit/readauditstep/" + auditId + "/4"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyAuditStep4ListTemplate",
            targetElementID:"tbodyAuditStep4List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doAuditStep1HTMLDBReaderRender,
        onRenderAll:doAuditStep1HTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divAuditStep5HTMLDBReader",
        readURL:(URLPrefix + "audit/readauditstep/" + auditId + "/5"),
        readAllURL:(URLPrefix + "audit/readauditstep/" + auditId + "/5"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyAuditStep5ListTemplate",
            targetElementID:"tbodyAuditStep5List"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doAuditStep1HTMLDBReaderRender,
        onRenderAll:doAuditStep1HTMLDBReaderRender
    });

}
function doAuditStateHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divAuditStateHTMLDBReader");
}
function doAuditHTMLDBReaderRead() {
    if ("" == document.getElementById("divAuditHTMLDBReader_tbody").innerHTML) {
        window.location = (document.body.getAttribute("data-url-prefix") + "home");
    }

	setHTMLDBFieldContents("divAuditHTMLDBReader");
    setHTMLDBFieldValues("divAuditHTMLDBReader");
	setHTMLDBFieldAttributes("divAuditHTMLDBReader");

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    $(".aCompanyNameLink").attr("href", (URLPrefix
            + "company/"
            + document.getElementById("spanCompanyId").innerHTML));
    $(".aUnitNameLink").attr("href", (URLPrefix
            + "unit/"
            + document.getElementById("spanUnitId").innerHTML));

    document.getElementById("editAuditStepAuditId").value
            = extractAuditId();
    document.getElementById("editAuditStepAuditId").setAttribute(
            "data-reset-value",
            document.getElementById("editAuditStepAuditId").value);

    document.getElementById("addAuditStepAuditId").value
            = document.getElementById("editAuditStepAuditId").value;
    document.getElementById("addAuditStepAuditId").setAttribute(
            "data-reset-value",
            document.getElementById("editAuditStepAuditId").value);

    initializeHTMLDBHelpers();

}
function doAuditStep1HTMLDBReaderRender() {
    initializeHTMLDBHelpers();
    initializeSatisfiedButtons();

    $(".buttonAddStepPhoto").off("click").on("click", function() {
        doAddStepPhotoButtonClick(this);
    });

    calculateCompletedStepCount();
    
    renderIMGCounts();

    var exit = false;
    for (var i = 1; ((i <= 5) && (!exit)); i++) {

        if ("" == document.getElementById("tbodyAuditStep" + i + "List").innerHTML) {
            exit = true;
        }

    }

    if (!exit) {
        document.getElementById("divLoader").style.display = "none";
    }

}
function calculateCompletedStepCount() {
    var totalCount = 0;
    var totalCompletedCount = 0;
    var auditStepCount = 0;
    var auditStepCompletedCount = 0;

    for (var i = 1; i < 6; i++) {
        elTBODY = document.getElementById("tbodyAuditStep" + i + "List");
        
        arrSatisfiedBUTTON = $(".buttonSatisfied", elTBODY);
        auditStepCount = ((arrSatisfiedBUTTON.length) / 2);

        arrCompletedSatisfiedBUTTON = $(".buttonSatisfiedYes1,.buttonSatisfiedNo1", elTBODY);
        auditStepCompletedCount = arrCompletedSatisfiedBUTTON.length;
        
        document.getElementById("spanStep" + i + "CompletedCount").innerHTML = ("(" 
                + auditStepCompletedCount
                + "/"
                + auditStepCount
                + ")");

        totalCount += auditStepCount;
        totalCompletedCount += auditStepCompletedCount;
    }

    document.getElementById("spanAllCompletedCount").innerHTML = ("(" 
                + totalCompletedCount
                + "/"
                + totalCount
                + ")");
}
function renderIMGCounts() {
    for (var s = 1; s < 6; s++) {
        strHTMLDBDIVID = "divAuditStep" + s + "HTMLDBReader";
        elTBODY = document.getElementById("divAuditStep" + s + "HTMLDBReader_tbody");
        
        arrHTMLDBTR = $("tr", elTBODY);
        trCount = arrHTMLDBTR.length;

        for (var i = 0; i < trCount; i++) {
            rowId = arrHTMLDBTR[i].getAttribute("data-row-id");
            object = HTMLDB.get(strHTMLDBDIVID, rowId);
            if ("" != object["photos"]) {                
                spanIMGCount = (object["photos"].match(/media\//g) || []).length;
                elSPAN = document.getElementById("spanIMGCount" + rowId);
                elSPAN.innerHTML = spanIMGCount;
                elSPAN.parentNode.style.color = "#2e7d32";
            }
        }
    }
}
function initializeSatisfiedButtons() {

    $(".buttonSatisfied.buttonSatisfiedYes").off("click").on("click", function () {
        doSatisfiedYesButtonClick(this);
    });

    $(".buttonSatisfied.buttonSatisfiedNo").off("click").on("click", function () {
        doSatisfiedNoButtonClick(this);
    });

}
function doSatisfiedYesButtonClick(sender) {

    if (!sender) {
        return false;
    }

    var rowId = sender.getAttribute("data-row-id");
    var object = HTMLDB.get("divAuditStepHTMLDBReader", rowId);

    object["yes"] = 1;
    object["no"] = 0;

    HTMLDB.insert("divAuditStepYesHTMLDBWriter", object);

    $("#buttonSatisfiedNo" + rowId).removeClass("buttonSatisfiedNo1");
    $("#buttonSatisfiedNo" + rowId).addClass("buttonSatisfiedNo0");
    $("#buttonSatisfiedYes" + rowId).removeClass("buttonSatisfiedYes0");
    $("#buttonSatisfiedYes" + rowId).addClass("buttonSatisfiedYes1");

    calculateCompletedStepCount();
    calculateAuditScore();
}
function doSatisfiedNoButtonClick(sender) {

    if (!sender) {
        return false;
    }

    var rowId = sender.getAttribute("data-row-id");
    var object = HTMLDB.get("divAuditStepHTMLDBReader", rowId);

    object["yes"] = 0;
    object["no"] = 1;

    HTMLDB.insert("divAuditStepHTMLDBWriter", object);
    document.getElementById("divAuditStepHTMLDBWriter").setAttribute("data-htmldb-reader", "");
    $("#divLoader").velocity("fadeIn", 300);

    $("tr", document.getElementById("divAuditStepHTMLDBWriter_tbody")).addClass("updating");

    HTMLDB.write("divAuditStepHTMLDBWriter", false, function () {

        document.getElementById("divLoader").style.display = "none";

        $("tr.updating", document.getElementById("divAuditStepHTMLDBWriter_tbody")).detach();

        document.getElementById("divAuditStepHTMLDBWriter").setAttribute(
                "data-htmldb-reader",
                "divAuditStepHTMLDBReader");

        elTR = sender.parentNode.parentNode;
        $(".buttonEditAuditStep", elTR).first().click();

    });

    $("#buttonSatisfiedYes" + rowId).removeClass("buttonSatisfiedYes1");
    $("#buttonSatisfiedYes" + rowId).addClass("buttonSatisfiedYes0");
    $("#buttonSatisfiedNo" + rowId).removeClass("buttonSatisfiedNo0");
    $("#buttonSatisfiedNo" + rowId).addClass("buttonSatisfiedNo1");
    
    calculateCompletedStepCount();
    calculateAuditScore();
}
function calculateAuditScore() {
    arrCompletedSatisfiedYesBUTTON = $(".buttonSatisfiedYes1");
    buttonCount = arrCompletedSatisfiedYesBUTTON.length;
    
    var whitetypeCount = 0;
    var yellowtypeCount = 0;
    var redtypeCount = 0;

    for (var i = 0; i < buttonCount; i++) {
        audittype = arrCompletedSatisfiedYesBUTTON[i].getAttribute("data-audit-type");
        
        if (1 == audittype) {
            whitetypeCount++;
        } else if(2 == audittype) {
            yellowtypeCount++;
        } else if (3 == audittype) {
            redtypeCount++;
        }
    }
    
    whiteScore = (whitetypeCount * 0.8);
    yellowScore = (yellowtypeCount * 2.7);
    redScore = (redtypeCount * 2.44);
    totalScore = (whiteScore + yellowScore + redScore);

    var rowId = document.getElementById("buttonEdit").getAttribute("data-htmldb-row-id");
    var object = HTMLDB.get("divAuditHTMLDBReader", rowId);
    object["score"] = totalScore;
    object["audit_state_id"] = 2;
    
    document.getElementById("pScore").innerHTML = Number(totalScore).toFixed(2);

    HTMLDB.insert("divAuditHTMLDBWriter", object);
    document.getElementById("divAuditHTMLDBWriter").setAttribute("data-htmldb-reader", "");
    HTMLDB.write("divAuditHTMLDBWriter", false, function () {

        document.getElementById("divAuditHTMLDBWriter_tbody").innerHTML = "";
        document.getElementById("divAuditHTMLDBWriter").setAttribute(
                "data-htmldb-reader",
                "divAuditHTMLDBReader");
    });

}
function doAuditStepCategoryHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divAuditStepCategoryHTMLDBReader");
}
function doAuditStepTypeHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divAuditStepTypeHTMLDBReader");
}
function doAuditStepHTMLDBReaderRead() {

    document.getElementById("divAuditStep1HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divAuditStep1HTMLDBReader", true);

    document.getElementById("divAuditStep2HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divAuditStep2HTMLDBReader", true);

    document.getElementById("divAuditStep3HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divAuditStep3HTMLDBReader", true);

    document.getElementById("divAuditStep4HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divAuditStep4HTMLDBReader", true);

    document.getElementById("divAuditStep5HTMLDBReader_tbody").innerHTML = "";
    HTMLDB.read("divAuditStep5HTMLDBReader", true);

}
function doDownloadPhotosButtonClick(sender) {
    document.getElementById("formCreateZip").submit();
}