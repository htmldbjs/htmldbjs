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

    HTMLDB.initialize({
        elementID:"divCompanyTypeHTMLDBReader",
        readURL:(URLPrefix + "company/readcompanytype"),
        readAllURL:(URLPrefix + "company/readcompanytype"),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doCompanyTypeHTMLDBReaderRender,
        onRenderAll:doCompanyTypeHTMLDBReaderRender
    });
    
    HTMLDB.initialize({
        elementID:"divCrewTypeHTMLDBReader",
        readURL:(URLPrefix + "company/readcrewtype"),
        readAllURL:(URLPrefix + "company/readcrewtype"),
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
        readURL:(URLPrefix + "company/readaudittype"),
        readAllURL:(URLPrefix + "company/readaudittype"),
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
        elementID:"divUnitForAuditHTMLDBReader",
        readURL:(URLPrefix + "company/readunitforaudit/" + companyId),
        readAllURL:(URLPrefix + "company/readunitforaudit/" + companyId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doUnitForAuditHTMLDBReaderRead,
        onRead:doUnitForAuditHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divUnitForApplicationHTMLDBReader",
        readURL:(URLPrefix + "company/readunitforapplication/" + companyId),
        readAllURL:(URLPrefix + "company/readunitforapplication/" + companyId),
        validateURL:"",
        writeURL:"",
        autoRefresh:0,
        renderElements:[],
        onReadAll:doUnitForApplicationHTMLDBReaderRead,
        onRead:doUnitForApplicationHTMLDBReaderRead,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });
}
function doCompanyTypeHTMLDBReaderRender() {
    setHTMLDBFieldSelects("divCompanyTypeHTMLDBReader");    
    $("#type").on("change", function(){
        doCompanyTypeChange();
    });
}
function doCompanyTypeChange() {
    $("#consultantContainer").hide();
    $(".hideWhenPersonelCompany").show();

    var type = getInputValue("type");
    if (1 == type) {
        $("#consultantContainer").show();
    } else if (2 == type) {
        $(".hideWhenPersonelCompany").hide();
    }
}
function doCrewTypeHTMLDBReaderRender() {
    setHTMLDBFieldSelects("divCrewTypeHTMLDBReader");    
}
function doAuditTypeHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divAuditTypeHTMLDBReader");
}
function doUnitForAuditHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divUnitForAuditHTMLDBReader");
}
function doUnitForApplicationHTMLDBReaderRead() {
    setHTMLDBFieldSelects("divUnitForApplicationHTMLDBReader");

    var arrTR = $("#divUnitForApplicationHTMLDBReader_tbody > tr");
    var TRLength = arrTR.length;

    if (0 == TRLength) {
        $("#buttonAddApplication").hide();
    } else {
        $("#buttonAddApplication").show();
    }
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
        onRender:doUnitHTMLDBReaderRender,
        onRenderAll:doUnitHTMLDBReaderRender
    });
    
    HTMLDB.initialize({
        elementID:"divCrewHTMLDBWriter",
        readURL:(URLPrefix + "company/readcrew/nodata"),
        readAllURL:(URLPrefix + "company/readcrew/nodata"),
        validateURL:(URLPrefix + "company/validatecrew"),
        writeURL:(URLPrefix + "company/writecrew"),
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
        readURL:(URLPrefix + "company/readcrew/" + companyId),
        readAllURL:(URLPrefix + "company/readcrew/" + companyId),
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
        readURL:(URLPrefix + "company/readaudit/" + companyId),
        readAllURL:(URLPrefix + "company/readaudit/" + companyId),
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
        readURL:(URLPrefix + "company/readapplication/" + companyId),
        readAllURL:(URLPrefix + "company/readapplication/" + companyId),
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
function doCrewHTMLDBReaderRender() {

    document.getElementById("divLoader").style.display = "none";
    setHTMLDBFieldContents("divCrewHTMLDBReader");
    setHTMLDBFieldValues("divCrewHTMLDBReader");
    setHTMLDBFieldAttributes("divCrewHTMLDBReader");

    initializeHTMLDBHelpers();

}
function doCompanyHTMLDBReaderRead() {
    
    if ("" == document.getElementById("divCompanyHTMLDBReader_tbody").innerHTML) {
        window.location = (document.body.getAttribute("data-url-prefix") + "home");
    }

    companyId = extractCompanyId();
    objCompany = HTMLDB.get("divCompanyHTMLDBReader", companyId);

    if (2 == objCompany["type"]) {
        $(".hideWhenPersonelCompany").hide();
    } else {
        $(".hideWhenPersonelCompany").show();
    }
    
	document.getElementById("divLoader").style.display = "none";
	setHTMLDBFieldContents("divCompanyHTMLDBReader");
    setHTMLDBFieldValues("divCompanyHTMLDBReader");
	setHTMLDBFieldAttributes("divCompanyHTMLDBReader");
    
    document.getElementById("crewCompanyId").value = companyId;
    document.getElementById("crewCompanyId").setAttribute(
            "data-reset-value",
            document.getElementById("crewCompanyId").value);
    
    document.getElementById("companyId").value = companyId;
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
function doUnitHTMLDBReaderRender() {
    $(".tdUnitEditObject").off("click").on("click", function() {
        doTDUnitEditObjectClick(this);
    });
}
function doAuditHTMLDBReaderRender() {
    $(".tdAuditEditObject").off("click").on("click", function() {
        doTDAuditEditObjectClick(this);
    });

    document.getElementById("divLoader").style.display = "none";
    setHTMLDBFieldContents("divAuditHTMLDBReader");
    setHTMLDBFieldValues("divAuditHTMLDBReader");
    setHTMLDBFieldAttributes("divAuditHTMLDBReader");

    initializeHTMLDBHelpers();

}
function doApplicationHTMLDBReaderRender() {
    $(".tdApplicationEditObject").off("click").on("click", function() {
        doTDApplicationEditObjectClick(this);
    });

    document.getElementById("divLoader").style.display = "none";
        
    setHTMLDBFieldContents("divApplicationHTMLDBReader");
    setHTMLDBFieldValues("divApplicationHTMLDBReader");
    setHTMLDBFieldAttributes("divApplicationHTMLDBReader");

    initializeHTMLDBHelpers();

}
function doTDUnitEditObjectClick(sender) {
    if (!sender) {
        return;
    }
    
    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var unitId = sender.parentNode.getAttribute("data-object-id");
    window.location = (URLPrefix + "unit/" + unitId);
}
function doTDAuditEditObjectClick(sender) {
    if (!sender) {
        return;
    }
    
    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var auditId = sender.parentNode.getAttribute("data-object-id");
    window.location = (URLPrefix + "audit/" + auditId);
}
function doTDApplicationEditObjectClick(sender) {
    if (!sender) {
        return;
    }
    
    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var applicationId = sender.parentNode.getAttribute("data-object-id");
    window.location = (URLPrefix + "application/" + applicationId);
}