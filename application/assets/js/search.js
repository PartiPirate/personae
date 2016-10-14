function hideUnactiveSkills() {
	$(".btn-skill-filter").each(function() {
		if ($(this).hasClass("active")) {
			return;
		}
		
		$(this).hide();
	});
}

$(function() {
	checkSuccesButtonState = function(target) {
		var dialog = target.parents(".modal-dialog");
		if (dialog.length == 0) return;

		var hasSelectedRow = dialog.find("tbody tr.selected-row").length != 0;

		var successButton = dialog.find(".modal-footer button[data-bb-handler=success]");

		successButton.removeClass("disabled");
		if (hasSelectedRow == 0) {
			successButton.addClass("disabled");
		}
	};

	$("body").on("click", ".search-user", function(event) {
		event.preventDefault();
		event.stopPropagation();

		var parameters = {};

		if ($(this).data("success-function")) {
			parameters["successFunction"] = $(this).data("success-function");
		}
		if ($(this).data("filter-theme-id")) {
			parameters["filterThemeId"] = $(this).data("filter-theme-id");
		}
		if ($(this).data("filter-with")) {
			parameters["filterWith"] = $(this).data("filter-with");
		}
		if ($(this).data("selection-type")) {
			parameters["selectionType"] = $(this).data("selection-type");
		}

		var successLabel = "OK";

		if ($(this).data("success-label")) {
			successLabel = $(this).data("success-label");
		}

		$.post("search_member.php?isModal=", parameters, function(data) {
			bootbox.dialog({
	            title: "Chercher un membre",
	            message: data,
	            buttons: {
	                success: {
	                    label: successLabel,
	                    className: "btn-primary",
	                    callback: function () {
	                    		var dialog = $(this);
	                    		var successFunction = eval(dialog.find("form #successFunction").val());
	                    		if (successFunction) {
//	                    			console.log("I have a success function");
//	                    			console.log(successFunction);

	                    			var rows = dialog.find("tbody tr.selected-row");

	                    			if (rows.length == 0) return;

	                    			successFunction(rows);
	                    		}
		                    }
		                },
		            close: {
	                    label: "Close",
	                    className: "btn-default",
	                    callback: function () {

		                    }
		                }
	            },
	            className: "large-dialog"
			});
			checkSuccesButtonState($("table.search-member-table"));

		}, "html");
	});

	$("body").on("click", ".btn-search-member", function(event) {
		event.preventDefault();
		event.stopPropagation();

		$(".btn-danger.btn-add-skill-filter").click();
		hideUnactiveSkills();

		$.post("do_search_member.php", $(".search-member-form").serialize(), function(data) {

			var table = $("table.search-member-table");
			var tbody = $("table.search-member-table tbody");

			tbody.children().remove();
			table.show();

			for(var index = 0; index < data.rows.length; ++index) {
				var row = data.rows[index];

				var htmlRow = $("*[data-template-id=template-tweet]").template("use", {"data": row});
				htmlRow.data("row", row);
				tbody.append(htmlRow);
			}
		}, "json");
	});

	$("body").on("click", "table.search-member-table tbody tr", function(event) {
		var dialog = $(this).parents(".modal-dialog");
		var form = dialog.find("form");
		var selectionType = form.find("#selectionType").val();

		// If multi
		if (selectionType == "single"&& !$(this).hasClass("selected-row")) {
				dialog.find("table.search-member-table tbody tr").removeClass("selected-row");
		}
		$(this).toggleClass("selected-row");

		checkSuccesButtonState($(this));
	});
	
	$("body").on("click", ".btn-add-skill-filter", function(event) {
		var button = $(this);
		var icon = button.find(".fa");
		
		if (icon.hasClass("fa-plus")) {
			$(".btn-skill-filter").show();
		}
		else {
			hideUnactiveSkills();
		}
		
		button.toggleClass("btn-primary").toggleClass("btn-danger");
		icon.toggleClass("fa-plus").toggleClass("fa-minus");
		
		$(this).blur();
	});

	$("body").on("click", ".btn-skill-filter", function(event) {
		var button = $(this);
		button.toggleClass("active");
		
		var checkbox = $("#" + button.data("for"));
		checkbox.prop("checked", button.hasClass("active"));
	});
	
});