function initializeHTMLDBHelpers() {

	$(".HTMLDBAction.HTMLDBAdd").off("click").on("click", function () {
		doHTMLDBActionAdd(this);
	});

	$(".HTMLDBAction.HTMLDBEdit").off("click").on("click", function () {
		doHTMLDBActionEdit(this);
	});

	$(".HTMLDBAction.HTMLDBSave").off("click").on("click", function () {
		doHTMLDBActionSave(this);
	});

	resetHTMLDBReaderLoops();
	resetHTMLDBWriterLoops();

}
function resetHTMLDBLoader() {

    var elements = $(".HTMLDBLoopReader,.HTMLDBLoopWriter");
    var elementCount = elements.length;
    var element = null;
    var hasLoadingHTMLDB = false;

    for (var i = 0; ((i < elementCount) && !hasLoadingHTMLDB); i++) {

    	element = elements[i];
    	if (1 == parseInt(element.getAttribute("data-loading"))) {
    		hasLoadingHTMLDB = true;
    	}

    }

    if (hasLoadingHTMLDB) {
    	showHTMLDBNotification();
    } else {
    	hideHTMLDBNotification();
    }

}
function resetHTMLDBReaderLoops() {

    var tmHTMLDBReaderTimer = $(document.body).data("tmHTMLDBReaderTimer");
    clearTimeout(tmHTMLDBReaderTimer);

    tmHTMLDBReaderTimer = setTimeout(function () {

    	var elements = $(".HTMLDBAction.HTMLDBLoopReader");
    	var elementCount = elements.length;
    	var element = null;
    	var loading = false;

    	for (var i = 0; i < elementCount; i++) {

    		element = elements[i];

    		if (!document.getElementById(element.id + "_tbody")) {
    			continue;
    		}

    		loading = parseInt(document.getElementById(element.id).getAttribute("data-loading"));

    		if (loading > 0) {
    			document.getElementById(element.id).setAttribute("data-loading", 0);
				resetHTMLDBReaderLoops();
    			continue;
    		}

    		clearHTMLDBTableContents(element.id);
    		HTMLDB.read(element.id, true);

    	}

    	resetHTMLDBLoader();
    	resetHTMLDBReaderLoops();

    }, 45000);

    $(document.body).data("tmHTMLDBReaderTimer", tmHTMLDBReaderTimer);

}
function resetHTMLDBWriterLoops() {

    var tmHTMLDBWriterTimer = $(document.body).data("tmHTMLDBWriterTimer");
    clearTimeout(tmHTMLDBWriterTimer);

    tmHTMLDBWriterTimer = setTimeout(function () {

    	var elements = $(".HTMLDBAction.HTMLDBLoopWriter");
    	var elementCount = elements.length;
    	var element = null;
    	var loading = false;

    	for (var i = 0; i < elementCount; i++) {

    		element = elements[i];

    		if (!document.getElementById(element.id + "_tbody")) {
    			continue;
    		}

    		loading = parseInt(document.getElementById(element.id).getAttribute("data-loading"));

    		if (loading > 0) {
    			document.getElementById(element.id).setAttribute("data-loading", 0);
				resetHTMLDBWriterLoops();
    			continue;
    		}

    		if (0 == document.getElementById(element.id + "_tbody").children.length) {
    			continue;
    		}

    		if ($("tr.updating", document.getElementById(element.id + "_tbody")).length > 0) {
    			continue;
    		}

    		$("tr", document.getElementById(element.id + "_tbody")).addClass("updating");

    		HTMLDB.write(element.id, false, function (DIVId, response) {
    			$("tr.updating", document.getElementById(DIVId + "_tbody")).detach();
    			// If there is a record to be written, write them first...
    			if (0 == document.getElementById(element.id + "_tbody").children.length) {
	    			if (document.getElementById(DIVId).getAttribute("data-htmldb-reader")) {
	    				clearHTMLDBTableContents(document.getElementById(DIVId).getAttribute("data-htmldb-reader"));
	    				HTMLDB.read(document.getElementById(DIVId).getAttribute("data-htmldb-reader"), true);
	    			} else if (document.getElementById(DIVId).getAttribute("data-htmldb-redirect")) {
	    				window.location.href = document.getElementById(DIVId).getAttribute("data-htmldb-redirect");
	    			}
    			}
    		});

    	}

		resetHTMLDBLoader();
		resetHTMLDBWriterLoops();

    }, 2000);

    $(document.body).data("tmHTMLDBWriterTimer", tmHTMLDBWriterTimer);

}
function showHTMLDBNotification() {

	visibleHTMLDBNotifications = $(document.body).data("visibleHTMLDBNotifications");

	if (undefined === visibleHTMLDBNotifications) {
		visibleHTMLDBNotifications = 0;
	}

	visibleHTMLDBNotifications++;

	if (1 == visibleHTMLDBNotifications) {
		$(".divLoaderNonBlocking").velocity("fadeIn", 500);
	}

	$(document.body).data("visibleHTMLDBNotifications", visibleHTMLDBNotifications);

}
function hideHTMLDBNotification() {

	visibleHTMLDBNotifications = $(document.body).data("visibleHTMLDBNotifications");

	if (undefined === visibleHTMLDBNotifications) {
		visibleHTMLDBNotifications = 0;
	} else {
		visibleHTMLDBNotifications--;
	}

	if (visibleHTMLDBNotifications < 0) {
		visibleHTMLDBNotifications = 0;
		return;
	}

	if (0 == visibleHTMLDBNotifications) {
		$(".divLoaderNonBlocking").velocity("fadeOut", 500);
	}

	$(document.body).data("visibleHTMLDBNotifications", visibleHTMLDBNotifications);

}
function doHTMLDBActionAdd(sender) {

	if (!sender) {
		return;
	}

	var rowId = 0;
	var sourceHTMLDB = sender.getAttribute("data-htmldb-source");
	var dialogId = sender.getAttribute("data-htmldb-dialog");
	var dialogElement = document.getElementById(dialogId);

	var forms = $("form", dialogElement);
	var formCount = forms.length;
	var form = null;

	for (var i = 0; i < formCount; i++) {
		form = forms[i];
		resetForm(form);
	}

	var saveButtons = $(".HTMLDBAction.HTMLDBSave", dialogElement);
	saveButtons.attr("data-htmldb-row-id", 0);

	refreshShowHideElements(dialogId);

	dialogElement.showDialogCallback = function (sender) {
		disableDialogLoopReaders(sender);
	}

	dialogElement.hideDialogCallback = function (sender) {
		enableDialogLoopReaders(sender);
	}

	showDialog(dialogId);

}
function disableDialogLoopReaders(dialogElement) {

	var elements = $(".HTMLDBFieldValue,.HTMLDBFieldSelect,"
			+ ".HTMLDBFieldContent,.HTMLDBFieldAttribute",
			dialogElement);
	var elementCount = elements.length;
	var element = null;
	var sourceHTMLDB = "";

	for (var i = 0; i < elementCount; i++) {

		element = elements[i];

		if (element.getAttribute("data-htmldb-source")) {
			sourceHTMLDB = element.getAttribute("data-htmldb-source");
			$("#" + sourceHTMLDB).removeClass("HTMLDBLoopReader");
		}

		if (element.getAttribute("data-htmldb-option-source")) {
			sourceHTMLDB = element.getAttribute("data-htmldb-option-source");
			$("#" + sourceHTMLDB).removeClass("HTMLDBLoopReader");
		}

	}
	
}
function enableDialogLoopReaders(dialogElement) {

	var elements = $(".HTMLDBFieldValue,.HTMLDBFieldSelect,"
			+ ".HTMLDBFieldContent,.HTMLDBFieldAttribute",
			dialogElement);
	var elementCount = elements.length;
	var element = null;
	var sourceHTMLDB = "";

	for (var i = 0; i < elementCount; i++) {

		element = elements[i];

		if (element.getAttribute("data-htmldb-source")) {
			sourceHTMLDB = element.getAttribute("data-htmldb-source");
			$("#" + sourceHTMLDB).addClass("HTMLDBLoopReader");
		}

		if (element.getAttribute("data-htmldb-option-source")) {
			sourceHTMLDB = element.getAttribute("data-htmldb-option-source");
			$("#" + sourceHTMLDB).addClass("HTMLDBLoopReader");
		}

	}

}
function doHTMLDBActionEdit(sender) {

	if (!sender) {
		return;
	}

	var rowId = sender.getAttribute("data-htmldb-row-id");
	var sourceHTMLDB = sender.getAttribute("data-htmldb-source");
	var dialogId = sender.getAttribute("data-htmldb-dialog");
	var dialogElement = document.getElementById(dialogId);

	var forms = $("form", dialogElement);
	var formCount = forms.length;
	var form = null;

	for (var i = 0; i < formCount; i++) {
		form = forms[i];
		resetForm(form);
	}

	setHTMLDBFieldValues(sourceHTMLDB, rowId);
	setHTMLDBFieldAttributes(sourceHTMLDB, rowId);
	setHTMLDBFieldContents(sourceHTMLDB, rowId);
	refreshShowHideElements(dialogId);

	dialogElement.showDialogCallback = function (sender) {
		$("#" + sourceHTMLDB).removeClass("HTMLDBLoopReader");
	}

	dialogElement.hideDialogCallback = function (sender) {
		$("#" + sourceHTMLDB).addClass("HTMLDBLoopReader");	
	}

	showDialog(dialogId);

}
function doHTMLDBActionSave(sender) {

	if (!sender) {
		return;
	}

	var rowId = sender.getAttribute("data-htmldb-row-id");
	var targetHTMLDB = sender.getAttribute("data-htmldb-target");
	var dialogId = sender.getAttribute("data-htmldb-dialog");
	var loaderId = sender.getAttribute("data-htmldb-loader");

	var elements = $("#" + dialogId + " .HTMLDBFieldValue");
	var elementCount = elements.length;
	var element = null;
	var object = {};

	for (var i = 0; i < elementCount; i++) {
		
		element = elements[i];
		object[element.getAttribute("data-htmldb-field")]
				= getInputValue(element.id);

	}

	object["id"] = rowId;

	HTMLDB.validate(targetHTMLDB, object, function (DIVId, response) {

		var responseObject = JSON.parse(String(response).trim());
		if (responseObject.errorCount > 0) {
			showErrorDialog(responseObject.lastError);
		} else {
			if (loaderId != "") {
				$("#" + loaderId).velocity("fadeIn", 300);
			}

			HTMLDB.insert(targetHTMLDB, object);
			hideDialog(dialogId);
		}

	});

}
function setHTMLDBFieldContents(elementHTMLDBId, rowId) {

	var elements = $(".HTMLDBFieldContent");
	var elementCount = elements.length;
	var element = null;

	if (undefined === rowId) {

		if (0 == document.getElementById(elementHTMLDBId + "_tbody").children.length) {
			return;
		}

		var firstRow = document.getElementById(elementHTMLDBId + "_tbody").children[0];
		rowId = firstRow.getAttribute("data-row-id");

	}

	var object = HTMLDB.get(elementHTMLDBId, rowId);

	for (var i = 0; i < elementCount; i++) {
		element = elements[i];

		if (!element.getAttribute("data-htmldb-source")) {
			continue;
		}

		if (element.getAttribute("data-htmldb-source") != elementHTMLDBId) {
			continue;
		}

		if (element.getAttribute("data-htmldb-field")
				&& (object[element.getAttribute("data-htmldb-field")] !== undefined)) {
			element.innerHTML = object[element.getAttribute("data-htmldb-field")];
		}
	}

}
function setHTMLDBFieldAttributes(elementHTMLDBId, rowId) {

	var elements = $(".HTMLDBFieldAttribute");
	var elementCount = elements.length;
	var element = null;

	if (undefined === rowId) {

		if (0 == document.getElementById(elementHTMLDBId + "_tbody").children.length) {
			return;
		}

		var firstRow = document.getElementById(elementHTMLDBId + "_tbody").children[0];
		rowId = firstRow.getAttribute("data-row-id");

	}

	var object = HTMLDB.get(elementHTMLDBId, rowId);
	var attributeName = "";

	for (var i = 0; i < elementCount; i++) {
		element = elements[i];
		if (element.getAttribute("data-htmldb-field")
				&& (object[element.getAttribute("data-htmldb-field")] !== undefined)) {
			attributeName = element.getAttribute("data-htmldb-attribute");
			
			if ((undefined === attributeName) || ("" == attributeName)) {
				continue;
			}

			if (!element.getAttribute("data-htmldb-source")) {
				continue;
			}

			if (element.getAttribute("data-htmldb-source") != elementHTMLDBId) {
				continue;
			}

			element.setAttribute(attributeName, object[element.getAttribute("data-htmldb-field")]);
		}
	}

}
function setHTMLDBFieldValues(elementHTMLDBId, rowId) {

	var elements = $(".HTMLDBFieldValue");
	var elementCount = elements.length;
	var element = null;

	if (undefined === rowId) {

		if (0 == document.getElementById(elementHTMLDBId + "_tbody").children.length) {
			return;
		}

		var firstRow = document.getElementById(elementHTMLDBId + "_tbody").children[0];
		rowId = firstRow.getAttribute("data-row-id");

	}

	var object = HTMLDB.get(elementHTMLDBId, rowId);

	for (var i = 0; i < elementCount; i++) {
		element = elements[i];

		if (!element.getAttribute("data-htmldb-source")) {
			continue;
		}

		if (element.getAttribute("data-htmldb-source") != elementHTMLDBId) {
			continue;
		}

		if (element.getAttribute("data-htmldb-field")
				&& (object[element.getAttribute("data-htmldb-field")] !== undefined)) {
			setInputValue(element.id, object[element.getAttribute("data-htmldb-field")])
		}
	}

	refreshShowHideElements();

}
function setHTMLDBFieldSelects(elementHTMLDBId) {

    var itemCount = document.getElementById(elementHTMLDBId + "_tbody").children.length;
    var childrenTR = document.getElementById(elementHTMLDBId + "_tbody").children;
    var items = new Array();
    var itemId = 0;

    for (var i = 0; i < itemCount; i++) {
        itemId = childrenTR[i].getAttribute("data-row-id");
        items.push(HTMLDB.get(elementHTMLDBId, itemId));
    }

	var elements = $(".HTMLDBFieldSelect");
	var elementCount = elements.length;
	var element = null;

	for (var i = 0; i < elementCount; i++) {

		element = elements[i];

		if (!element.getAttribute("data-htmldb-option-source")) {
			continue;
		}

		if (element.getAttribute("data-htmldb-option-source") != elementHTMLDBId) {
			continue;
		}

        if (element.selectize) {
            element.selectize.destroy();
        }

        if (element.multiple) {

            $(element).selectize({
	    		valueField: "id",
	    		labelField: "column0",
	    		searchField: "column0",
	    		preload: false,
                plugins: ["remove_button"],
                sortField: "column0",
                create: true,
                createFilter: function(input) {
                    return false;
                }
            });

            if ($(".selectize-input.items", element.parentNode).hasClass('ui-sortable')) {
                $(".selectize-input.items", element.parentNode).sortable("destroy");
            }

            $(".selectize-input.items", element.parentNode).sortable({
                axis: "x",
                opacity: 0.7,
                placeholder: "item"
            });

        } else {

	        $(element).selectize({
	    		valueField: "id",
	    		labelField: "column0",
	    		searchField: "column0",
	    		preload: false,
	    		create: false
	        });

        }

	    if (element.selectize) {
	        element.selectize.addOption(items);
	    }

	}

}
function clearHTMLDBTableContents(elementHTMLDBId) {

	element = document.getElementById(elementHTMLDBId + "_tbody");
	if (element) {
		element.innerHTML = "";
	}

}