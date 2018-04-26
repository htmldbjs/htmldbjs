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

	initializePages();

	showPage("divLanguagesContent");

	$("#buttonSaveTranslations").off("click").on("click", function() {
		doSaveTranslationsButtonClick(this);
	});

	$("#buttonNewTranslation").off("click").on("click", function () {
		doNewTranslationButtonClick(this);
	});

	$("#buttonAddTranslation").off("click").on("click", function () {
		doAddTranslationButtonClick(this);
	});

	$("#buttonShowCopyTranslationsForm").off("click").on("click", function () {
		doShowCopyTranslationsFormButtonClick(this);
	});

	$("#buttonCopyTranslations").off("click").on("click", function () {
		doCopyTranslationsButtonClick(this);
	});

    resetProgressBar(
            document.getElementById("divLoaderText").getAttribute("data-default-text"),
            false,
            true);

}

function initializePages() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");

    HTMLDB.initialize({
        elementID:"divPagesHTMLDB",
        readURL:(URLPrefix + "languages/readpages"),
        readAllURL:(URLPrefix + "languages/readpages"),
        writeURL:null,
        autoRefresh:0,
        renderElements:[{
            templateElementID:"selectLanguagePageTemplate",
            targetElementID:"languagePage"
        },{
            templateElementID:"selectLanguagePageTemplate",
            targetElementID:"languageCopyPage"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:doPagesHTMLDBRenderAll
    });

}

function initializeTranslations() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");
    var language = getInputValue("languageCode");
    var page = getInputValue("languagePage");

    HTMLDB.initialize({
        elementID:"divCopyTranslationsHTMLDB",
        readURL:(URLPrefix + "languages/readcopytranslations"),
        readAllURL:(URLPrefix + "languages/readcopytranslations"),
        validateURL:(URLPrefix + "languages/validatecopytranslations"),
        writeURL:(URLPrefix + "languages/writecopytranslations"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divTranslationsHTMLDB",
        readURL:(URLPrefix + "languages/read/" + language + "/" + page),
        readAllURL:(URLPrefix + "languages/read/" + language + "/" + page),
        writeURL:(URLPrefix + "languages/write"),
        autoRefresh:0,
        renderElements:[{
        	templateElementID:"divTranslationsTemplate",
        	targetElementID:"divTranslations"
        }],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:doTranslationsHTMLDBRenderAll,
        onRenderAll:doTranslationsHTMLDBRenderAll
    });

}

function doCopyTranslationsButtonClick(sender) {

	if (!sender) {
		return false;
	}

	var select = document.getElementById("languageCopyPage");

	if ("" == $(select).val()) {
		showErrorDialog(select.getAttribute("data-required-error-text"));
		return false;
	}

	var select = document.getElementById("fromLanguageCode");

	if ("" == $(select).val()) {
		showErrorDialog(select.getAttribute("data-required-error-text"));
		return false;
	}

	var select = document.getElementById("toLanguageCode");

	if ("" == $(select).val()) {
		showErrorDialog(select.getAttribute("data-required-error-text"));
		return false;
	}

	$("#buttonDeleteConfirm").off("click").on("click", function () {
		doCopyTranslationsConfirmButtonClick(this);
	});

	var object = {};
	object["id"] = 0;
	object["page"] = $("#languageCopyPage").val();
	object["fromLanguage"] = $("#fromLanguageCode").val();
	object["toLanguage"] = $("#toLanguageCode").val();

	HTMLDB.validate("divCopyTranslationsHTMLDB", object, function (DIVId, responseText) {

		var response = JSON.parse(responseText);

		if (response.errorCount > 0) {
			showErrorDialog(response.lastError);
		} else {
			showDialog("divDeleteDialog");
		}

	});

}

function doCopyTranslationsConfirmButtonClick(sender) {

	if (!sender) {
		return false;
	}

	checkFTPConnection(function () {

		var object = {};
		object["id"] = 0;
		object["page"] = $("#languageCopyPage").val();
		object["fromLanguage"] = $("#fromLanguageCode").val();
		object["toLanguage"] = $("#toLanguageCode").val();

		HTMLDB.insert("divCopyTranslationsHTMLDB", object);

		HTMLDB.write("divCopyTranslationsHTMLDB", false, function () {

			document.getElementById("divCopyTranslationsHTMLDB_tbody").innerHTML = "";
			setInputValue("languagePage", $("#languageCopyPage").val());
			setInputValue("languageCode", $("#toLanguageCode").val());

			hideDialog("divDeleteDialog");
			setTimeout(function () {
				hideDialog("divCopyTranslationsDialog");
			}, 400);

		});

	});

}

function doShowCopyTranslationsFormButtonClick(sender) {

	if (!sender) {
		return false;
	}

	showDialog("divCopyTranslationsDialog");

}

function doAddTranslationButtonClick(sender) {

	if (!sender) {
		return false;
	}

	var sentence = document.getElementById("newSentence").value;

	if ("" == sentence) {
		showErrorDialog(document.getElementById("newSentence").getAttribute("data-required-error-text"));
		return false;
	}

	sender.innerHTML = sender.getAttribute("data-loading-text");

	var content = document.getElementById("divAddNewTranslationTemplate").innerHTML;
	var translationCount = $("#divTranslations .divTranslation").length;
	var index = 0;

	if (translationCount > 0) {

		var lastTranslation = $("#divTranslations .divTranslation")[translationCount - 1];
		index = parseInt(lastTranslation.getAttribute("data-row-id"));

	}

	index++;

	content = content.replace(/__ID__/g, index);
	content = content.replace(/__SENTENCE__/g, document.getElementById("newSentence").value);

	if (translationCount > 0) {
		document.getElementById("divTranslations").innerHTML += content;
	} else {
		document.getElementById("divTranslations").innerHTML = content;
	}

	hideDialog("divNewTranslationDialog");
	sender.innerHTML = sender.getAttribute("data-default-text");

	$("#divTranslations .buttonDeleteTranslation").off("click").on("click", function () {
		doDeleteTranslationButtonClick(this);
	});

}

function doDeleteTranslationButtonClick(sender) {

	if (!sender) {
		return false;
	}

	$(sender.parentNode.parentNode).velocity("stop");
	$(sender.parentNode.parentNode).velocity("transition.slideDownOut", 250, function () {
		$(sender.parentNode.parentNode).detach();
	});

}

function doNewTranslationButtonClick(sender) {

	if (!sender) {
		return false;
	}

	resetForm(document.getElementById("formNewTranslation"));
	showDialog("divNewTranslationDialog");

}

function doTranslationsHTMLDBRenderAll() {

	if ("" == document.getElementById("divTranslations").innerHTML) {

		document.getElementById("divTranslations").innerHTML
				= document.getElementById("divTranslationsPlaceholderTemplate").innerHTML

	}

	$("#divTranslationContainer").velocity("stop");
	$("#divTranslationContainer").velocity("transition.slideUpBigIn", 300);
	$("#divTranslationButtonsContainer").velocity("stop");
	$("#divTranslationButtonsContainer").velocity("transition.slideUpBigIn", 300);

	$("#divTranslations .buttonDeleteTranslation").off("click").on("click", function () {
		doDeleteTranslationButtonClick(this);
	});

}

function doPagesHTMLDBRenderAll() {

    var select = document.getElementById("languageCode");
    if (select.selectize) {
        select.selectize.destroy();
    }

    $(select).selectize({
		allowEmptyOption: true,
		sortField: "value"
    });

    var select = document.getElementById("fromLanguageCode");
    if (select.selectize) {
        select.selectize.destroy();
    }

    $(select).selectize({
		allowEmptyOption: true,
		sortField: "value"
    });

    var select = document.getElementById("toLanguageCode");
    if (select.selectize) {
        select.selectize.destroy();
    }

    $(select).selectize({
		allowEmptyOption: true,
		sortField: "value"
    });

    var select = document.getElementById("languagePage");
    if (select.selectize) {
        select.selectize.destroy();
    }

    select.innerHTML = document.getElementById("selectLanguagePageTemplateHeader").innerHTML
    		+ select.innerHTML;

    $(select).selectize({
		allowEmptyOption: true,
        sortField: "value"
    });

    var select = document.getElementById("languageCopyPage");
    if (select.selectize) {
        select.selectize.destroy();
    }

    select.innerHTML = document.getElementById("selectLanguagePageTemplateHeader").innerHTML
    		+ select.innerHTML;

    $(select).selectize({
		allowEmptyOption: true,
        sortField: "value"
    });

	$("#languageCode").off("change").on("change", function() {
		doListTranslationsButtonClick(this);
	});

	$("#languagePage").off("change").on("change", function() {
		doListTranslationsButtonClick(this);
	});

	stepProgressBar(100);

}

function doListTranslationsButtonClick(sender) {

	if (!sender) {
		return;
	}

	if ("" == $("#languageCode").val()) {
		return false;
	}

	if ("" == $("#languagePage").val()) {
		return false;
	}

	setInputValue("languageCopyPage", $("#languagePage").val());
	setInputValue("fromLanguageCode", $("#languageCode").val());

	document.getElementById("divTranslations").innerHTML = "";

	initializeTranslations();

}

function doSaveTranslationsButtonClick(sender) {

	if (!sender) {
		return;
	}

	var language = $("#languageCode").val();
	var page = $("#languagePage").val();

	if ("" == language){
		showErrorDialog(document.getElementById("languageCode").getAttribute("data-required-error-text"));
		return;
	}

	if ("" == page){
		showErrorDialog(document.getElementById("languagePage").getAttribute("data-required-error-text"));
		return;
	}

	checkFTPConnection(function () {

		var pageTokens = page.split("/");
		var module = pageTokens[0];
		var controller = pageTokens[1];
		var sentence = "";
		var translation = "";
		var id = 0;

        document.getElementById("spanSaveMessage").style.display = "none";
		sender.innerHTML = sender.getAttribute("data-loading-text");

		var translations = $("#divTranslations .divTranslation");
		var translationCount = translations.length;
		var translation = null;
		var object = {};

		for (var i = 0; i < translationCount; i++) {

			translation = translations[i];
			id = translation.getAttribute("data-row-id");

			sentence = document.getElementById("labelTranslation" + id).innerHTML;
			translation = document.getElementById("inputTranslation" + id).value;

			object = {};
			object["id"] = 0;
			object["language"] = language;
			object["module"] = module;
			object["controller"] = controller;
			object["sentence"] = sentence;
			object["translation"] = translation;

			HTMLDB.insert("divTranslationsHTMLDB", object);

		}

		HTMLDB.write("divTranslationsHTMLDB", false, function () {

			$("#divTranslationsHTMLDB_tbody .inserted").detach();
			sender.innerHTML = sender.getAttribute("data-default-text");
            $("#spanSaveMessage").velocity("stop");
            $("#spanSaveMessage").velocity("fadeIn", 100);

		});

	});

}