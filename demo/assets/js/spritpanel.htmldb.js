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
		$(".htmldb-table").on("error", function (event) {
			SpritPanelHTMLDB.showError(event);
		});

		$(".htmldb-button-edit").on("click", function (event) {
			SpritPanelHTMLDB.showEditDialog(this, event);
		});

		$(".htmldb-button-save").on("save", function (event) {
			SpritPanelHTMLDB.doSave(this);
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
			throw(new Error("Edit button target form not specified."));
			return false;
		}

		var formId = HTMLDB.getHTMLDBParameter(button, "form");
		var form = document.getElementById(formId);

		if (!form) {
			throw(new Error("Edit button target form " + formId + " not found."));
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
			throw(new Error("Edit button target form " + formId + " dialog not found."));
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

		form = SpritPanelHTMLDB.extractButtonForm(sender);

		if (!form) {
			return false;
		}

		dialog = SpritPanelHTMLDB.extractFormDialog(form);

		hideDialog(dialog.id);
	}
}
SpritPanelHTMLDB.initialize();