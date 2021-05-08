"use strict";
$("#chapterBoard").hide();
$("#posPortal").hide();
setTimeout(function() {
    $("#posPortal").fadeIn();
}, 1000);
$(document).ready(function() {
    setTimeout(function() {
        $("#alerts").hide();
    }, 10000);
});
$(document).on("click", ".swicher", function() {
    $("#chapterBoard").toggle();
    $("#posPortal").toggle();
});
$(document).on("click", ".btn-submit", function() {
    $(this).html("Processing...!");
    setTimeout(function() {
        $(".btn-submit").prop("disabled", true);
    }, 800);
    setTimeout(function() {
        $("btn-submit").html("");
        $(".btn-submit").prop("disabled", false);
        $(".btn-submit").html("Try Again");
    }, 6000);
});
$(document).ready(function() {
    $("#myInput").on("keyup", function() {
        var value = $(this)
            .val()
            .toLowerCase();
        $("#name-list div").filter(function() {
            $(this).toggle(
                $(this)
                    .text()
                    .toLowerCase()
                    .indexOf(value) > -1
            );
        });
    });
});
