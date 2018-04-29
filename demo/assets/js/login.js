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
	showDialog("divLogin");

	$("#aForgotPasswordLink").on("click", function () {
		doForgotPasswordLinkClick(this);
	});

	$("#aCreateAccountLink").on("click", function () {
		doCreateAccountLinkClick(this);
	});

	$(".aLoginLink").on("click", function () {
		doLoginLinkClick(this);
	});
}

// ---------------------
// Helper Event Handlers
// ---------------------

function doLoginLinkClick(sender) {
	if (!sender) {
		return;
	}

	var elDIV = sender.parentNode.parentNode.parentNode
			.parentNode.parentNode.parentNode.parentNode;

	hideDialog(elDIV.id);
	showDialog("divLogin");
}

function doCreateAccountLinkClick(sender) {
	if (!sender) {
		return;
	}

	hideDialog("divLogin");
	showDialog("divCreateAccount");
}

function doForgotPasswordLinkClick(sender) {
	if (!sender) {
		return;
	}

	hideDialog("divLogin");
	showDialog("divForgotPassword");
}
