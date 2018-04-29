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
        elementID:"divCrewTypeHTMLDBReader",
        readURL:(URLPrefix + "unit/readcrewtype"),
        readAllURL:(URLPrefix + "unit/readcrewtype"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doCrewTypeHTMLDBReaderRender,
        onRenderAll:doCrewTypeHTMLDBReaderRender
    });

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
        elementID:"divUnitCrewHTMLDBWriter",
        readURL:(URLPrefix + "unit/readunitcrew/nodata"),
        readAllURL:(URLPrefix + "unit/readunitcrew/nodata"),
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
        elementID:"divUnitCrewHTMLDBReader",
        readURL:(URLPrefix + "unit/readunitcrew/" + unitId),
        readAllURL:(URLPrefix + "unit/readunitcrew/" + unitId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyUnitCrewListTemplate",
            targetElementID:"tbodyUnitCrewList"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doUnitCrewHTMLDBReaderRender,
        onRenderAll:doUnitCrewHTMLDBReaderRender
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
        renderElements:[],
        onReadAll:doApplicationHTMLDBReaderRead,
        onRead:doApplicationHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

}
function doCrewTypeHTMLDBReaderRender() {
    setHTMLDBFieldSelects("divCrewTypeHTMLDBReader");    
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
    if ("" == document.getElementById("divUnitHTMLDBReader_tbody").innerHTML) {
        window.location = (document.body.getAttribute("data-url-prefix") + "home");
    }

    unitId = extractUnitId();
    objUnit = HTMLDB.get("divUnitHTMLDBReader", unitId);

	document.getElementById("divLoader").style.display = "none";
	setHTMLDBFieldContents("divUnitHTMLDBReader");
    setHTMLDBFieldValues("divUnitHTMLDBReader");
	setHTMLDBFieldAttributes("divUnitHTMLDBReader");

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    $(".aCompanyNameLink").attr("href", (URLPrefix
            + "company/"
            + document.getElementById("spanCompanyId").innerHTML));

    document.getElementById("crewUnitId").value
            = unitId;
    document.getElementById("crewUnitId").setAttribute(
            "data-reset-value",
            document.getElementById("crewUnitId").value);
    document.getElementById("unit_crewUnitId").value
            = unitId;
    document.getElementById("unit_crewUnitId").setAttribute(
            "data-reset-value",
            document.getElementById("unit_crewUnitId").value);

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
function doUnitCrewHTMLDBReaderRender() {

    document.getElementById("divLoader").style.display = "none";
    setHTMLDBFieldContents("divUnitCrewHTMLDBReader");
    setHTMLDBFieldValues("divUnitCrewHTMLDBReader");
    setHTMLDBFieldAttributes("divUnitCrewHTMLDBReader");

    initializeHTMLDBHelpers();

}
function doAuditHTMLDBReaderRender() {
    $(".tdEditObject").off("click").on("click", function() {
        doTDEditObjectClick(this);
    });

    document.getElementById("divLoader").style.display = "none";
    setHTMLDBFieldContents("divAuditHTMLDBReader");
    setHTMLDBFieldValues("divAuditHTMLDBReader");
    setHTMLDBFieldAttributes("divAuditHTMLDBReader");

    initializeHTMLDBHelpers();

}
function doApplicationHTMLDBReaderRead() {

    document.getElementById("divLoader").style.display = "none";
    
    var arrTR = $("#divApplicationHTMLDBReader_tbody > tr");
    var TRLength = arrTR.length;

    if (0 == TRLength) {
        $("#showApplication").off("click").on("click", function() {
            doAddApplicationButtonClick(this);
        });
    } else {
        var URLPrefix = document.body.getAttribute("data-url-prefix");
        var rowId = arrTR[0].getAttribute("data-row-id");
        $("#showApplication").off("click").on("click", function() {
            window.location = (URLPrefix + "application/" + rowId);
        });
    }
    
    /*setHTMLDBFieldContents("divApplicationHTMLDBReader");
    setHTMLDBFieldValues("divApplicationHTMLDBReader");
    setHTMLDBFieldAttributes("divApplicationHTMLDBReader");

    initializeHTMLDBHelpers();*/

}
function doTDEditObjectClick(sender) {
    if (!sender) {
        return;
    }
    
    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var auditId = sender.parentNode.getAttribute("data-object-id");
    window.location = (URLPrefix + "audit/" + auditId);
}