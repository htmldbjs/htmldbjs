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

    $("#buttonAddApplication").on("click", function () {
        doAddApplicationButtonClick(this);
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
function extractUnitId() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var URLTokens = window.location.href.split(URLPrefix + "unit/");
    var Id = 0;

    if (URLTokens.length > 0) {
    	Id = parseInt(URLTokens[1]);
    }

    if (isNaN(Id)) {
    	Id = 0;
    }

    return Id;

}
function initializeHTMLDB() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var unitId = extractUnitId();

    HTMLDB.initialize({
        elementID:"divAuditTypeHTMLDBReader",
        readURL:(URLPrefix + "audits/readpropertyoptions/audit_type_id"),
        readAllURL:(URLPrefix + "audits/readpropertyoptions/audit_type_id"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doAuditTypeHTMLDBReaderRead,
        onRead:doAuditTypeHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divUnitHTMLDBWriter",
        readURL:(URLPrefix + "unit/read/nodata"),
        readAllURL:(URLPrefix + "unit/read/nodata"),
        validateURL:(URLPrefix + "unit/validate"),
        writeURL:(URLPrefix + "unit/write"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divUnitHTMLDBReader",
        readURL:(URLPrefix + "unit/read/" + unitId),
        readAllURL:(URLPrefix + "unit/read/" + unitId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doUnitHTMLDBReaderRead,
        onRead:doUnitHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divCrewHTMLDBWriter",
        readURL:(URLPrefix + "unit/readcrew/nodata"),
        readAllURL:(URLPrefix + "unit/readcrew/nodata"),
        validateURL:(URLPrefix + "unit/validatecrew"),
        writeURL:(URLPrefix + "unit/writecrew"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divCrewHTMLDBReader",
        readURL:(URLPrefix + "unit/readcrew/" + unitId),
        readAllURL:(URLPrefix + "unit/readcrew/" + unitId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyCrewListTemplate",
            targetElementID:"tbodyCrewList"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doCrewHTMLDBReaderRender,
        onRenderAll:doCrewHTMLDBReaderRender
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
        readURL:(URLPrefix + "unit/readaudit/" + unitId),
        readAllURL:(URLPrefix + "unit/readaudit/" + unitId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyAuditListTemplate",
            targetElementID:"tbodyAuditList"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doAuditHTMLDBReaderRender,
        onRenderAll:doAuditHTMLDBReaderRender
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
        readURL:(URLPrefix + "unit/readapplication/" + unitId),
        readAllURL:(URLPrefix + "unit/readapplication/" + unitId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyApplicationListTemplate",
            targetElementID:"tbodyApplicationList"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doApplicationHTMLDBReaderRender,
        onRenderAll:doApplicationHTMLDBReaderRender
    });

}
function doAddApplicationButtonClick(sender) {

    var object = {};

    $("#divLoader").velocity("fadeIn", 300);

    object["id"] = 0;
    object["unit_id"] = extractUnitId();
    HTMLDB.insert("divApplicationHTMLDBWriter", object);

}
function doAuditTypeHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divAuditTypeHTMLDBReader");
}
function doUnitHTMLDBReaderRead() {

	document.getElementById("divLoader").style.display = "none";
	setHTMLDBFieldContents("divUnitHTMLDBReader");
    setHTMLDBFieldValues("divUnitHTMLDBReader");
	setHTMLDBFieldAttributes("divUnitHTMLDBReader");

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    $(".aCompanyNameLink").attr("href", (URLPrefix
            + "company/"
            + document.getElementById("spanCompanyId").innerHTML));

    document.getElementById("crewUnitId").value
            = extractUnitId();
    document.getElementById("crewUnitId").setAttribute(
            "data-reset-value",
            document.getElementById("crewUnitId").value);

    document.getElementById("auditUnitId").value
            = document.getElementById("crewUnitId").value;
    document.getElementById("auditUnitId").setAttribute(
            "data-reset-value",
            document.getElementById("crewUnitId").value);

    initializeHTMLDBHelpers();

}
function doCrewHTMLDBReaderRender() {

    document.getElementById("divLoader").style.display = "none";
    setHTMLDBFieldContents("divCrewHTMLDBReader");
    setHTMLDBFieldValues("divCrewHTMLDBReader");
    setHTMLDBFieldAttributes("divCrewHTMLDBReader");

    initializeHTMLDBHelpers();

}
function doAuditHTMLDBReaderRender() {

    document.getElementById("divLoader").style.display = "none";
    setHTMLDBFieldContents("divAuditHTMLDBReader");
    setHTMLDBFieldValues("divAuditHTMLDBReader");
    setHTMLDBFieldAttributes("divAuditHTMLDBReader");

    initializeHTMLDBHelpers();

}
function doApplicationHTMLDBReaderRender() {

    document.getElementById("divLoader").style.display = "none";
    setHTMLDBFieldContents("divApplicationHTMLDBReader");
    setHTMLDBFieldValues("divApplicationHTMLDBReader");
    setHTMLDBFieldAttributes("divApplicationHTMLDBReader");

    initializeHTMLDBHelpers();

}