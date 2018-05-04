var SpritPanelHTMLDB = {
	"initialize": function () {
		SpritPanelHTMLDB.initializeHTMLDBEvents();
	},
	"validate": function() {
		if (!document.getElementById("divErrorDialog")) {
	    	throw(new Error("Sprit Panel HTMLDB error dialog not found."));
			return false;
		}
	},
	"initializeHTMLDBEvents": function () {
		$(".htmldb-table").on("htmldberror", function (event) {
			SpritPanelHTMLDB.showError(event);
		});

		$(".htmldb-button-edit").on("click", function (event) {
			SpritPanelHTMLDB.showEditDialog(this, event);
		});

		$(".htmldb-button-save").on("htmldbsave", function (event) {
			SpritPanelHTMLDB.doSave(this);
		});

		$(".htmldb-button-add").on("click", function (event) {
			SpritPanelHTMLDB.showEditDialog(this, event);
		});

		$("select.htmldb-field").on("htmldbsetoptions", function (event) {
			SpritPanelHTMLDB.renderSelectElement(this, event);
		});
	},
	"showError": function (event) {
		showErrorDialog(event.detail.errorText);
	},
	"showEditDialog": function (sender, event) {
		var form = null;
		var dialog = null;

		form = SpritPanelHTMLDB.extractButtonForm(sender);

		if (!form) {
			return false;
		}

		dialog = SpritPanelHTMLDB.extractFormDialog(form);

		showDialog(dialog.id);
	},
	"extractButtonForm": function (button) {
		if (!button) {
			return false;
		}

		if ("" == HTMLDB.getHTMLDBParameter(button, "form")) {
			throw(new Error("Button target form not specified."));
			return false;
		}

		var formId = HTMLDB.getHTMLDBParameter(button, "form");
		var form = document.getElementById(formId);

		if (!form) {
			throw(new Error("Button target form " + formId + " not found."));
			return false;
		}

		return form;
	},
	"extractFormDialog": function (form) {
		if (!form) {
			return false;
		}

		var parent = form.parentNode;
		var exit = false;

		while ((-1 == parent.className.indexOf("htmldb-dialog-edit"))
				&& (parent.tagName.toLowerCase() != "body")) {
			parent = parent.parentNode;
		}

		if (-1 == parent.className.indexOf("htmldb-dialog-edit")) {
			throw(new Error("Button target form " + form.getAttribute("id") + " dialog not found."));
			return false;
		}

		return parent;
	},
	"doSave": function (sender) {
		if (!sender) {
			return false;
		}

		var form = null;
		var dialog = null;
		var tableId = "";
		var table = null;

		$(sender).addClass("disabled");

		form = SpritPanelHTMLDB.extractButtonForm(sender);

		if (!form) {
			return false;
		}

		tableId = HTMLDB.getHTMLDBParameter(form, "table");

		if ("" == tableId) {
			return false;
		}

		table = document.getElementById(tableId);

		if (HTMLDB.getHTMLDBParameter(table, "redirect") != "") {
			return true;
		}

		$(sender).removeClass("disabled");

		dialog = SpritPanelHTMLDB.extractFormDialog(form);

		if (!dialog) {
			return false;
		}

		hideDialog(dialog.id);
	},
	"renderSelectElement": function (sender, event) {
		if (!sender) {
			return false;
		}

        if (sender.selectize) {
            sender.selectize.destroy();
        }

        if (sender.multiple) {

            $(sender).selectize({
	    		preload: false,
                plugins: ["remove_button"],
                create: true,
                createFilter: function(input) {
                    return false;
                }
            });

            if ($(".selectize-input.items", sender.parentNode).hasClass('ui-sortable')) {
                $(".selectize-input.items", sender.parentNode).sortable("destroy");
            }

            $(".selectize-input.items", sender.parentNode).sortable({
                axis: "x",
                opacity: 0.7,
                placeholder: "item"
            });

        } else {

	        $(sender).selectize({
	    		preload: false,
	    		create: false
	        });

        }
	}
}
SpritPanelHTMLDB.initialize();