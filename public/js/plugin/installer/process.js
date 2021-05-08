"use strict";
var error;
$(".progress").hide();
$("#submit-install").click(function(event) {
    validateForm();
    if ($("#formInstall").valid()) {
        $(this).button("loading");
        $(".progress").show();
        $("#msg").removeClass("text-danger");
        $("#msg").removeClass("text-success");
        $("#msg").html("Connecting database...");
        $.ajax({
            url: "install.php",
            type: "POST",
            dataType: "json",
            data: {
                database_host: $("#database_host").val(),
                database_name: $("#database_name").val(),
                database_user: $("#database_user").val(),
                database_password: $("#database_password").val(),
                step: "step0",
            },
        })
            .done(function(data) {
                error = parseInt(data.error);
                if (error != 1 && error != 0) {
                    $("#msg").removeClass("text-success");
                    $("#msg").addClass("text-danger");
                    $("#msg").html(data);
                } else if (error === 0) {
                    $("#msg").addClass("text-success");
                    $("#msg").html(data.msg);
                    $(".progress-bar").css("width", "11%");
                    $(".progress-bar").html("11%");
                    setTimeout(generateEnv, 1000);
                } else {
                    $("#msg").removeClass("text-success");
                    $("#msg").addClass("text-danger");
                    $("#msg").html(data.msg);
                }
            })
            .fail(function() {
                $("#msg").removeClass("text-success");
                $("#msg").addClass("text-danger");
                $("#msg").html("Error while Connecting To Database");
            });
    }
});
function generateEnv() {
    $("#msg").removeClass("text-danger");
    $("#msg").removeClass("text-success");
    $("#msg").html("Generating file .env");
    $.ajax({
        url: "install.php",
        type: "POST",
        dataType: "json",
        data: {
            database_host: $("#database_host").val(),
            database_port: $("#database_port").val(),
            database_name: $("#database_name").val(),
            database_user: $("#database_user").val(),
            admin_url: "/login",
            database_password: $("#database_password").val(),
            step: "step1",
        },
    })
        .done(function(data) {
            $("#msg").removeClass("text-success");
            $("#msg").removeClass("text-danger");
            error = parseInt(data.error);
            if (error != 1 && error != 0) {
                $("#msg").addClass("text-danger");
                $("#msg").html(data);
            } else if (error === 0) {
                $("#msg").addClass("text-success");
                $("#msg").html(data.msg);
                $(".progress-bar").css("width", "30%");
                $(".progress-bar").html("30%");
                setTimeout(generateKey, 2000);
            } else {
                $("#msg").addClass("text-danger");
                $("#msg").html(data.msg);
            }
        })
        .fail(function() {
            $("#msg").removeClass("text-success");
            $("#msg").addClass("text-danger");
            $("#msg").html("Error while generating file .env");
        });
}
function generateKey() {
    $("#msg").removeClass("text-danger");
    $("#msg").removeClass("text-success");
    $("#msg").html("Generating API key");
    $.ajax({
        url: "install.php",
        type: "POST",
        dataType: "json",
        data: { step: "step2" },
    })
        .done(function(data) {
            $("#msg").removeClass("text-success");
            $("#msg").removeClass("text-danger");
            error = parseInt(data.error);
            if (error != 1 && error != 0) {
                $("#msg").addClass("text-danger");
                $("#msg").html(data);
            } else if (error === 0) {
                $("#msg").addClass("text-success");
                $("#msg").html(data.msg);
                $(".progress-bar").css("width", "50%");
                $(".progress-bar").html("50%");
                setTimeout(installDatabase, 2000);
            } else {
                $("#msg").addClass("text-danger");
                $("#msg").html(data.msg);
            }
        })
        .fail(function() {
            $("#msg").removeClass("text-success");
            $("#msg").addClass("text-danger");
            $("#msg").html("Error while generating API key");
        });
}
function installDatabase() {
    $("#msg").removeClass("text-danger");
    $("#msg").removeClass("text-success");
    $("#msg").html("Initializing database");
    $.ajax({
        url: "install.php",
        type: "POST",
        dataType: "json",
        data: { step: "step3" },
    })
        .done(function(data) {
            $("#msg").removeClass("text-success");
            $("#msg").removeClass("text-danger");
            error = parseInt(data.error);
            if (error != 1 && error != 0) {
                $("#msg").addClass("text-danger");
                $("#msg").html(data);
            } else if (error === 0) {
                $("#msg").addClass("text-success");
                $("#msg").html(data.msg);
                $(".progress-bar").css("width", "75%");
                $(".progress-bar").html("75%");
                setTimeout(setPermission, 2000);
            } else {
                $("#msg").addClass("text-danger");
                $("#msg").html(data.msg);
            }
        })
        .fail(function() {
            $("#msg").removeClass("text-success");
            $("#msg").addClass("text-danger");
            $("#msg").html("Error while initializing database");
        });
}
function setPermission() {
    $("#msg").removeClass("text-danger");
    $("#msg").removeClass("text-success");
    $("#msg").html("Setting permissions");
    $.ajax({
        url: "install.php",
        type: "POST",
        dataType: "json",
        data: { step: "step4" },
    })
        .done(function(data) {
            $("#msg").removeClass("text-success");
            $("#msg").removeClass("text-danger");
            error = parseInt(data.error);
            if (error != 1 && error != 0) {
                $("#msg").addClass("text-danger");
                $("#msg").html(data);
            } else if (error === 0) {
                $("#msg").addClass("text-success");
                $("#msg").html(data.msg);
                $(".progress-bar").css("width", "100%");
                $(".progress-bar").html("100%");
                setTimeout(function() {
                    window.location.replace("/login");
                }, 2000);
            } else {
                $("#msg").addClass("text-danger");
                $("#msg").html(data.msg);
            }
        })
        .fail(function() {
            $("#msg").removeClass("text-success");
            $("#msg").addClass("text-danger");
            $("#msg").html("Error while initializing setting permissions");
        });
}
function validateForm() {
    $("#formInstall")
        .validate({
            rules: {
                database_host: {
                    required: true,
                },
                database_port: {
                    required: true,
                    number: true,
                },
                database_name: {
                    required: true,
                },
                database_user: {
                    required: true,
                },
            },
            messages: {
                database_host: {
                    required: "Database hostname is required",
                },
                database_port: {
                    required: "Database port is required",
                    number: "Database port is number",
                },
                database_name: {
                    required: "Database name is required",
                },
                database_user: {
                    required: "Database password is required",
                },
            },
        })
        .valid();
}
