var SpritPanelHTMLDB = {
	"initialize": function () {
		SpritPanelHTMLDB.initializeHTMLDBEvents();
		SpritPanelHTMLDB.initializeSelectElements();
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

		$(".htmldb-template").on("htmldbrender", function (event) {
			SpritPanelHTMLDB.doTemplateRender(this, event);
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

		$("select.htmldb-field").on("htmldbsetvalue", function (event) {
			SpritPanelHTMLDB.doSelectizeSetValue(this, event);
		});

		$("select.htmldb-field").on("htmldbreset", function (event) {
			SpritPanelHTMLDB.doSelectizeReset(this, event);
		});

		$("select.htmldb-field").on("htmldbaddoptionclick", function (event) {
			SpritPanelHTMLDB.showEditDialog(this, event);
		});
	},
	"initializeSelectElements": function () {
		var selects = $("select.htmldb-field,select.htmldb-select");
		var selectCount = selects.length;
		var select = null;

		for (var i = 0; i < selectCount; i++) {
			select = selects[i];
			SpritPanelHTMLDB.renderSelectElement(select, null);
		}
	},
	"doTemplateRender": function (sender, event) {
		var targets = event.detail.targets;
		var target = null;
		var targetCount = targets.length;

		if (0 == targetCount) {
			return;
		}

		for (var i = 0; i < targetCount; i++) {
			target = document.getElementById(targets[i]);

			if (!target) {
				return;
			}

			$(".htmldb-button-edit", target)
					.off("click.spritpanelhtmldb")
					.on("click.spritpanelhtmldb", function (event) {
				SpritPanelHTMLDB.showEditDialog(this, event);
			});

			$(".htmldb-button-save", target)
					.off("htmldbsave.spritpanelhtmldb")
					.on("htmldbsave.spritpanelhtmldb", function (event) {
				SpritPanelHTMLDB.doSave(this);
			});

			$(".htmldb-button-add", target)
					.off("click.spritpanelhtmldb")
					.on("click.spritpanelhtmldb", function (event) {
				SpritPanelHTMLDB.showEditDialog(this, event);
			});

			$(".trAction", target)
					.off("click.spritpanelhtmldb")
					.on("click.spritpanelhtmldb", function (e) {
				SpritPanelHTMLDB.doActionTableRowClick(this, e);
			});
		}
	},
	"doSelectizeSetValue": function (sender, event) {
		if (sender.selectize) {
			if (undefined == sender.attributes['multiple']) {
				sender.selectize.setValue(event.detail.value);
			} else {
				var selections = strValue.split(",");
				var selectionCount = selections.length;
				for (var i = 0; i < selectionCount; i++) {
					sender.selectize.addItem(selections[i]);
				}
			}
		}
	},
	"doSelectizeReset": function (sender, event) {
		if (sender.selectize) {
			sender.selectize.clear(true);
		}
	},
	"showError": function (event) {
		showErrorDialog(event.detail.errorText);
	},
	"showEditDialog": function (sender, event) {
		var form = null;
		var dialog = null;

		form = SpritPanelHTMLDB.extractElementForm(sender);

		if (!form) {
			return false;
		}

		dialog = SpritPanelHTMLDB.extractFormDialog(form);

		if (dialog) {
			showDialog(dialog.id);			
		}
	},
	"extractElementForm": function (element) {
		if (!element) {
			return false;
		}

		var formId = "";
		var form = null;
		var tagName = element.tagName.toLowerCase();

		if (("button" == tagName) || ("a" == tagName)) {
			if ("" == HTMLDB.getHTMLDBParameter(element, "form")) {
				throw(new Error("Button target form not specified."));
				return false;
			}
			formId = HTMLDB.getHTMLDBParameter(element, "form");
		} else if ("select" == tagName) {
			if ("" == HTMLDB.getHTMLDBParameter(element, "add-option-form")) {
				throw(new Error("Select add option form not specified."));
				return false;
			}
			formId = HTMLDB.getHTMLDBParameter(element, "add-option-form");
		}

		var form = document.getElementById(formId);

		if (!form) {
			throw(new Error(tagName + " target form " + formId + " not found."));
			return false;
		}

		return form;
	},
	"extractFormDialog": function (form) {
		if (!form) {
			return false;
		}

		var parent = form.parentNode;

		while ((-1 == parent.className.indexOf("htmldb-dialog-edit"))
				&& (parent.tagName.toLowerCase() != "body")) {
			parent = parent.parentNode;
		}

		if (-1 == parent.className.indexOf("htmldb-dialog-edit")) {
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

		form = SpritPanelHTMLDB.extractElementForm(sender);

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

		var closeOnSave = true;

		if ("0"== sender.getAttribute("data-close-on-save")) {
			closeOnSave = false;
		}

		if (closeOnSave) {
			dialog = SpritPanelHTMLDB.extractFormDialog(form);

			if (dialog) {
				hideDialog(dialog.id);
			}
		}
	},
	"renderSelectElement": function (sender, event) {
		if (!sender) {
			return false;
		}

        if (sender.selectize) {
            sender.selectize.destroy();
        }

        if (sender.HTMLDBInitials !== undefined) {
        	sender.innerHTML = sender.HTMLDBInitials.content;
        }

        if (sender.multiple) {

            $(sender).selectize({
	    		preload: false,
                plugins: ["remove_button"],
                create: true,
                createFilter: function(input) {
                    return false;
                },
				onChange: function(value) {
      				SpritPanelHTMLDB.doSelectizeChange(sender, value);
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
	    		create: false,
				onChange: function(value) {
      				SpritPanelHTMLDB.doSelectizeChange(sender, value);
    			}
	        });

        }
	},
	"doSelectizeChange": function (sender, value) {
		var form = HTMLDB.extractToggleParentElement(sender);
		var field = HTMLDB.getHTMLDBParameter(sender, "field");
		HTMLDB.doParentElementToggle(form);
		HTMLDB.doActiveFormFieldUpdate(form, field);
		sender.dispatchEvent(new CustomEvent(
				"change",
				{detail: {}}));
	},
	"doActionTableRowClick": function (sender, e) {
		var parent = e.target.parentNode;

		if (!parent) {
			return false;
		}

		if (undefined != parent.actionTableRowClicked
				&& parent.actionTableRowClicked) {
			return false;
		}

		if (!parent.classList.contains("trAction")) {
			return false;
		}

		parent.actionTableRowClicked = true;

		var actionButtons = $(".buttonTableRowAction", parent);
		var actionButtonCount = actionButtons.length;
		var actionButton = null;

		if (actionButtonCount > 0) {
			actionButton = actionButtons[0];

			if (actionButton.tagName.toLowerCase() == "a") {
				actionButton.click();
			} else if ((actionButton.tagName.toLowerCase() == "button")) {
				var clickEvent = document.createEvent('HTMLEvents');
				clickEvent.initEvent("click", true, false);
				actionButton.dispatchEvent(clickEvent);
			} else if (actionButton.tagName.toLowerCase() == "input") {
				if ((actionButton.type.toLowerCase() == "checkbox")
						|| (actionButton.type.toLowerCase() == "checkbox")) {
					actionButton.checked = !actionButton.checked;
				}
			}
			
			setTimeout(function () {
				parent.actionTableRowClicked = false;
			}, 1000);
		}
	}
}
SpritPanelHTMLDB.initialize();