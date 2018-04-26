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

	document.getElementById("divLoader").style.display = "none";
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

    HTMLDB.insert("divAuditStepHTMLDBWriter", object);
    document.getElementById("divAuditStepHTMLDBWriter").setAttribute("data-htmldb-reader", "");
    HTMLDB.write("divAuditStepHTMLDBWriter", true, function () {

        document.getElementById("divAuditStepHTMLDBWriter_tbody").innerHTML = "";
        document.getElementById("divAuditStepHTMLDBWriter").setAttribute(
                "data-htmldb-reader",
                "divAuditStepHTMLDBReader");

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
    var object = HTMLDB.get("divAuditStepHTMLDBReader", rowId);

    object["yes"] = 0;
    object["no"] = 1;

    HTMLDB.insert("divAuditStepHTMLDBWriter", object);
    document.getElementById("divAuditStepHTMLDBWriter").setAttribute("data-htmldb-reader", "");
    HTMLDB.write("divAuditStepHTMLDBWriter", true, function () {

        document.getElementById("divAuditStepHTMLDBWriter_tbody").innerHTML = "";
        document.getElementById("divAuditStepHTMLDBWriter").setAttribute(
                "data-htmldb-reader",
                "divAuditStepHTMLDBReader");

    });

    $("#buttonSatisfiedYes" + rowId).removeClass("buttonSatisfiedYes1");
    $("#buttonSatisfiedYes" + rowId).addClass("buttonSatisfiedYes0");
    $("#buttonSatisfiedNo" + rowId).removeClass("buttonSatisfiedNo0");
    $("#buttonSatisfiedNo" + rowId).addClass("buttonSatisfiedNo1");

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