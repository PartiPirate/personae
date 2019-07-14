/*
	Copyright 2019 Cédric Levieux, Parti Pirate

	This file is part of Personae.

    Personae is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Personae is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Personae.  If not, see <http://www.gnu.org/licenses/>.
*/

/* global $ */

$(function() {
    $("body").on("click", ".group-link,.group-admin-link", function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        $("#frame").html("");
        $.get($(this).attr("href"), function(data) {
            var groupContainer = $(data).filter(".group-container").removeClass("container");

            $("#frame").append(groupContainer);
            $("#frame").append('<script src="assets/js/perpage/group.js"></script>');
        }, "html");

    });

    $("body").on("click", ".theme-link,.theme-admin-link", function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        $("#frame").html("");
        $.get($(this).attr("href"), function(data) {
            var themeContainer = $(data).filter(".theme-container").removeClass("container");
            var alertContainer = $(data).filter(".alert-container");

            $("#frame").append(themeContainer);
            $("#frame").append(alertContainer);
            $("#frame").append('<script src="assets/js/perpage/theme.js"></script>');
            $("#frame").append('<script src="assets/js/perpage/theme_user_delegation_advanced.js"></script>');
        }, "html");

    });
});