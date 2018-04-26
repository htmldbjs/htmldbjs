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

    showPage("divGeneralSettingsContent");

    $("#buttonSaveSettings").click(function() {
        doSaveSettingsButtonClick(this);
    });

    $("#buttonRebuildCache").off("click").on("click", function () {
        doRebuildCacheButtonClick(this);
    });

    $('ul.tabs').tabs();

    resetProgressBar(
            document.getElementById("divLoaderText").getAttribute("data-default-text"),
            false,
            true);

}

function initializeHTMLDB() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");

    HTMLDB.initialize({
        elementID:"divTimezoneHTMLDB",
        readURL:(URLPrefix + "general_settings/readtimezones"),
        readAllURL:(URLPrefix + "general_settings/readtimezones"),
        writeURL:null,
        autoRefresh:0,
        renderElements:[{
            templateElementID:"selectTimezoneTemplate",
            targetElementID:"timezone"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:doTimezoneHTMLDBRenderAll
    });

    HTMLDB.initialize({
        elementID:"divDefaultLanguageNamesHTMLDB",
        readURL:(URLPrefix + "general_settings/readdefaultlanguagenames"),
        readAllURL:(URLPrefix + "general_settings/readdefaultlanguagenames"),
        writeURL:null,
        autoRefresh:0,
        renderElements:[{
            templateElementID:"selectDefaultLanguageNamesTemplate",
            targetElementID:"defaultLanguage"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:doDefaultLanguageNamesHTMLDBRenderAll
    });

    HTMLDB.initialize({
        elementID:"divAdminLanguageNamesHTMLDB",
        readURL:(URLPrefix + "general_settings/readadminlanguagenames"),
        readAllURL:(URLPrefix + "general_settings/readadminlanguagenames"),
        writeURL:null,
        autoRefresh:0,
        renderElements:[{
            templateElementID:"selectAdminLanguageNamesTemplate",
            targetElementID:"adminDefaultLanguage"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:doAdminLanguageNamesHTMLDBRenderAll
    });

    HTMLDB.initialize({
        elementID:"divDefaultPagesHTMLDB",
        readURL:(URLPrefix + "general_settings/readdefaultpages"),
        readAllURL:(URLPrefix + "general_settings/readdefaultpages"),
        writeURL:null,
        autoRefresh:0,
        renderElements:[{
            templateElementID:"selectDefaultPagesTemplate",
            targetElementID:"defaultPage"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:doDefaultPagesHTMLDBRenderAll
    });

    HTMLDB.initialize({
        elementID:"divAdminPagesHTMLDB",
        readURL:(URLPrefix + "general_settings/readadminpages"),
        readAllURL:(URLPrefix + "general_settings/readadminpages"),
        writeURL:null,
        autoRefresh:0,
        renderElements:[{
            templateElementID:"selectAdminPagesTemplate",
            targetElementID:"adminDefaultPage"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:doAdminPagesHTMLDBRenderAll
    });

    HTMLDB.initialize({
        elementID:"divSettingsHTMLDB",
        readURL:(URLPrefix + "general_settings/read"),
        readAllURL:(URLPrefix + "general_settings/read"),
        validateURL:(URLPrefix + "general_settings/validate"),
        writeURL:(URLPrefix + "general_settings/write"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:doSettingsHTMLDBReadAll,
        onRead:doSettingsHTMLDBReadAll,
        onWrite:null,
        onValidate:null,
        onRender:null,
        onRenderAll:null
    });

}

function doSettingsHTMLDBReadAll() {

    var settings = HTMLDB.get("divSettingsHTMLDB", 1);
    var settingCount = settings.length;

    for (var variable in settings){
        if (settings.hasOwnProperty(variable)) {
            if (document.getElementById(variable)) {
                setInputValue(variable, settings[variable]);
            }
        }
    }

    stepProgressBar(100);

    checkFTPConnection(null, function () {
        $(".divFTPConnectionRequired").css("display", "none");
    });

}

function doDefaultPagesHTMLDBRenderAll() {
    $("#defaultPage").selectize();
    $("#dateFormat").selectize();
    $("#timeFormat").selectize();
}

function doAdminPagesHTMLDBRenderAll() {
    $("#adminDefaultPage").selectize();
}

function doTimezoneHTMLDBRenderAll() {

    $("#timezone").selectize();

}

function doDefaultLanguageNamesHTMLDBRenderAll() {
    $("#defaultLanguage").selectize();
}

function doAdminLanguageNamesHTMLDBRenderAll() {
    $("#adminDefaultLanguage").selectize();
}

function doSaveSettingsButtonClick(sender) {
    if (!sender) {
        return;
    }

    checkFTPConnection(function () {

        sender.innerHTML = sender.getAttribute("data-loading-text");
        document.getElementById("spanSettingsSaveMessage").style.display = "none";

        var settings = HTMLDB.get("divSettingsHTMLDB", 1);
        var settingCount = settings.length;

        for (var variable in settings){
            if (settings.hasOwnProperty(variable)) {
                if (document.getElementById(variable)) {
                    settings[variable] = getInputValue(variable);
                }
            }
        }

        HTMLDB.validate("divSettingsHTMLDB", settings, function (divId, responseText) {

            var response = JSON.parse(responseText);

            if (response.errorCount > 0) {

                sender.innerHTML = sender.getAttribute("data-default-text");
                showErrorDialog(response.lastError);

            } else {

                HTMLDB.update("divSettingsHTMLDB", 1, settings);
                HTMLDB.write("divSettingsHTMLDB", false, function () {

                    $("#spanSettingsSaveMessage").velocity("stop");
                    $("#spanSettingsSaveMessage").velocity("fadeIn", 100);
                    sender.innerHTML = sender.getAttribute("data-default-text");

                });

            }

        });

    });

}