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

	$("#divLoader").velocity("fadeIn", 300);

	initializeHTMLDB();
	initializeHTMLDBHelpers();

}
function initializeHTMLDB() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");

    HTMLDB.initialize({
        elementID:"divCompanyHTMLDBWriter",
        readURL:(URLPrefix + "companies/read/nodata"),
        readAllURL:(URLPrefix + "companies/read/nodata"),
        validateURL:(URLPrefix + "companies/validate"),
        writeURL:(URLPrefix + "companies/write"),
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
        readURL:(URLPrefix + "companies/read"),
        readAllURL:(URLPrefix + "companies/read"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[{
            templateElementID:"tbodyObjectListTemplate",
            targetElementID:"tbodyObjectList"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doCompanyHTMLDBReaderRender,
        onRenderAll:doCompanyHTMLDBReaderRender
    });

    HTMLDB.initialize({
        elementID:"divSessionHTMLDB",
        readURL:(URLPrefix + "companies/readsession"),
        readAllURL:(URLPrefix + "companies/readsession"),
        writeURL:(URLPrefix + "companies/writesession"),
        writeDelay:1000,
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

}
function doCompanyHTMLDBReaderRender() {
	document.getElementById("divLoader").style.display = "none";
}