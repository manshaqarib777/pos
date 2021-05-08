"use strict";
$("ul")
    .not(":has(li)")
    .parent()
    .parent()
    .remove();
var sidebar = $(".sidebar-content")
    .find('a[href="' + pageURL + '"]')
    .parent();
sidebar.addClass("active");
sidebar
    .parent()
    .parent()
    .parent()
    .addClass("active submenu");
sidebar
    .parent()
    .parent()
    .addClass("show");
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
$("#label_height_input").hide();
$("#label_width_input").hide();
$(document).on("click", "#label_height", function() {
    $("#col").val("p-0 col-md-12 col-sm-12");
    $("#label_height_options").toggle();
    $("#label_height_options").val("");
    $("#label_height_input").toggle();
});
$(document).on("click", "#label_width", function() {
    $("#col").val("p-0 col-md-12 col-sm-12");
    $("#label_width_options").val("");
    $("#label_width_options").toggle();
    $("#label_width_input").toggle();
});

function deletereport(id) {
    var from = document.getElementById("delete_form");
    from.action = "/report/" + id;
    $("#reportDeleteModal").modal("show");
    console.log(form);
}
