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
	initializeForms();

}
function initializeHTMLDB() {

    var URLPrefix = document.body.getAttribute("data-url-prefix");

    HTMLDB.initialize({
        elementID:"divProfileHTMLDBWriter",
        readURL:(URLPrefix + "my_profile/readprofile/nodata"),
        readAllURL:(URLPrefix + "my_profile/readprofile/nodata"),
        validateURL:(URLPrefix + "my_profile/validateprofile"),
        writeURL:(URLPrefix + "my_profile/writeprofile"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

    HTMLDB.initialize({
        elementID:"divPasswordHTMLDBWriter",
        readURL:(URLPrefix + "my_profile/readpassword/nodata"),
        readAllURL:(URLPrefix + "my_profile/readpassword/nodata"),
        validateURL:(URLPrefix + "my_profile/validatepassword"),
        writeURL:(URLPrefix + "my_profile/writepassword"),
        autoRefresh:0,
        renderElements:[],
        onReadAll:null,
        onRead:null,
        onWrite:null,
        onRender:null,
        onRenderAll:null
    });

}
function initializeForms() {

	$("#buttonEdit").on("click", function () {
		doEditButtonClick(this);
	});

	$("#buttonChangePassword").on("click", function () {
		doChangePasswordButtonClick(this);
	});

	$("#buttonSaveProfile").on("click", function () {
		doSaveProfileButtonClick(this);
	});

	$("#buttonSavePassword").on("click", function () {
		doSavePasswordButtonClick(this);
	});

}
function doSaveProfileButtonClick(sender) {

	if (!sender) {
		return false;
	}

	$("#divLoader").velocity("fadeIn", 300);
	var profile = collectObjectValues("#formProfile .inputProfile");
	profile["id"] = 0;

	HTMLDB.validate("divProfileHTMLDBWriter", profile, function (DIVId, response) {

		var responseObject = JSON.parse(String(response).trim());
		if (responseObject.errorCount > 0) {
			document.getElementById("divLoader").style.display = "none";
			showErrorDialog(responseObject.lastError);
		} else {

			document.getElementById("divProfileHTMLDBWriter_tbody").innerHTML = "";
			HTMLDB.insert("divProfileHTMLDBWriter", profile);
			HTMLDB.write("divProfileHTMLDBWriter", false, function () {

				$("#divLoader").velocity("fadeOut", 500, function () {
					window.location = window.location.href;
				});

			});

		}

	});

}
function doSavePasswordButtonClick(sender) {

	if (!sender) {
		return false;
	}

	$("#divLoader").velocity("fadeIn", 300);
	var password = collectObjectValues("#formPassword .inputPassword");
	password["id"] = 0;

	HTMLDB.validate("divPasswordHTMLDBWriter", password, function (DIVId, response) {

		var responseObject = JSON.parse(String(response).trim());
		if (responseObject.errorCount > 0) {
			document.getElementById("divLoader").style.display = "none";
			showErrorDialog(responseObject.lastError);
		} else {

			document.getElementById("divPasswordHTMLDBWriter_tbody").innerHTML = "";
			HTMLDB.insert("divPasswordHTMLDBWriter", password);
			HTMLDB.write("divPasswordHTMLDBWriter", false, function () {

				$("#divLoader").velocity("fadeOut", 500, function () {
					window.location = window.location.href;
				});

			});

		}

	});

}
function collectObjectValues(selector) {

	var elements = $(selector);
	var elementCount = elements.length;
	var element = null;
	var object = {};

	for (var i = 0; i < elementCount; i++) {

		element = elements[i];
		if (undefined == element.name) {
			continue;
		}

		object[element.name] = getInputValue(element.name);

	}

	return object;

}
function doEditButtonClick(sender) {

	if (!sender) {
		return false;
	}

	showDialog("divProfileDialog");

}
function doChangePasswordButtonClick(sender) {

	if (!sender) {
		return false;
	}

	showDialog("divPasswordDialog");

}