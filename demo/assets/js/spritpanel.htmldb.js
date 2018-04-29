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
	},
	"showError": function (event) {
		showErrorDialog(event.detail.errorText);
	}
}
SpritPanelHTMLDB.initialize();