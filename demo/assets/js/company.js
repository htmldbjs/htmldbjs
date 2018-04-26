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
	initializeHTMLDBHelpers();

	$("#divLoader").velocity("fadeIn", 300);
    window.onbeforeunload = confirmExit;

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
function extractCompanyId() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var URLTokens = window.location.href.split(URLPrefix + "company/");
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

    initializePrimaryHTMLDB();

}
function initializePrimaryHTMLDB() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var companyId = extractCompanyId();

    HTMLDB.initialize({
        elementID:"divConsultantHTMLDBReader",
        readURL:(URLPrefix + "company/readpropertyoptions/consultant"),
        readAllURL:(URLPrefix + "company/readpropertyoptions/consultant"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:divConsultantHTMLDBReaderRead,
        onRead:divConsultantHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

}
function divConsultantHTMLDBReaderRead() {
    initializeSecondaryHTMLDB();
    setHTMLDBFieldSelects("divConsultantHTMLDBReader");
}
function initializeSecondaryHTMLDB() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var companyId = extractCompanyId();

    HTMLDB.initialize({
        elementID:"divCompanyHTMLDBWriter",
        readURL:(URLPrefix + "company/read/nodata"),
        readAllURL:(URLPrefix + "company/read/nodata"),
        validateURL:(URLPrefix + "company/validate"),
        writeURL:(URLPrefix + "company/write"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divCompanyHTMLDBReader",
        readURL:(URLPrefix + "company/read/" + companyId),
        readAllURL:(URLPrefix + "company/read/" + companyId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doCompanyHTMLDBReaderRead,
        onRead:doCompanyHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divUnitHTMLDBWriter",
        readURL:(URLPrefix + "company/readunit/nodata"),
        readAllURL:(URLPrefix + "company/readunit/nodata"),
        validateURL:(URLPrefix + "company/validateunit"),
        writeURL:(URLPrefix + "company/writeunit"),
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
        readURL:(URLPrefix + "company/readunit/" + companyId),
        readAllURL:(URLPrefix + "company/readunit/" + companyId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyUnitListTemplate",
            targetElementID:"tbodyUnitList"
        }],
        onReadAll:doUnitHTMLDBReaderRead,
        onRead:doUnitHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

}
function doCompanyHTMLDBReaderRead() {

	document.getElementById("divLoader").style.display = "none";
	setHTMLDBFieldContents("divCompanyHTMLDBReader");
    setHTMLDBFieldValues("divCompanyHTMLDBReader");
	setHTMLDBFieldAttributes("divCompanyHTMLDBReader");

    document.getElementById("companyId").value
            = extractCompanyId();
    document.getElementById("companyId").setAttribute(
            "data-reset-value",
            document.getElementById("companyId").value);
    document.getElementById("unitCompany").value
            = document.getElementById("companyId").value
    document.getElementById("unitCompany").setAttribute(
            "data-reset-value",
            document.getElementById("companyId").value);

}
function doUnitHTMLDBReaderRead() {

    document.getElementById("divLoader").style.display = "none";
    setHTMLDBFieldContents("divUnitHTMLDBReader");
    setHTMLDBFieldValues("divUnitHTMLDBReader");
    setHTMLDBFieldAttributes("divUnitHTMLDBReader");

}