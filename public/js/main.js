/*!
 * Start Bootstrap - Simple Sidebar v6.0.2 (https://startbootstrap.com/template/simple-sidebar)
 * Copyright 2013-2021 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-simple-sidebar/blob/master/LICENSE)
 */
//
// Scripts
//

window.addEventListener("DOMContentLoaded", (event) => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector("#sidebarToggle");
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener("click", (event) => {
            event.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sb-sidenav-toggled")
            );
        });
    }
});

jQuery(document).ready(function ($) {
    /*clickable rows in table*/
    $(".clickable-row").click(function () {
        window.location = $(this).data("href");
    });

    //input file

    $(".inputFile").on("change", function () {
        var dataId = "#" + $(this).attr("name");
        $(dataId).html(this.files[0].name);

        if (dataId == "#fileInputPic") {
            $(".file-upload").addClass("picexist");
            $("#facultyPic").attr(
                "src",
                URL.createObjectURL(event.target.files[0])
            );
        }

        if (this.files[0].name != "") {
            $("#submitBtn").attr("aria-disabled", "false");
        }
    });

    //faculty position form
    $("#employee-type-form").on("change", function () {
        if ($(this).val() === "Part-Timer") {
            $("#faculty-position-form").prop("disabled", true);
        } else {
            $("#faculty-position-form").prop("disabled", false);
        }
    }); // in case of reload

    $("#select_form").on("change", function () {
        if ($(this).val() === "2") {
            $("#InputFacultyNo").prop("hidden", false);
        } else {
            $("#InputFacultyNo").prop("hidden", true);
        }
    });
});

// Password Hide and Unhide Value
$(document).ready(function () {
    $("#InputConfirmPassword a").on("click", function (event) {
        event.preventDefault();
        if ($("#InputConfirmPassword input").attr("type") == "text") {
            $("#InputConfirmPassword input").attr("type", "password");
            $("#InputConfirmPassword i").addClass("fa-eye-slash");
            $("#InputConfirmPassword i").removeClass("fa-eye");
        } else if (
            $("#InputConfirmPassword input").attr("type") == "password"
        ) {
            $("#InputConfirmPassword input").attr("type", "text");
            $("#InputConfirmPassword i").removeClass("fa-eye-slash");
            $("#InputConfirmPassword i").addClass("fa-eye");
        }
    });

    $("#InputNewPassword a").on("click", function (event) {
        event.preventDefault();
        if ($("#InputNewPassword input").attr("type") == "text") {
            $("#InputNewPassword input").attr("type", "password");
            $("#InputNewPassword i").addClass("fa-eye-slash");
            $("#InputNewPassword i").removeClass("fa-eye");
        } else if ($("#InputNewPassword input").attr("type") == "password") {
            $("#InputNewPassword input").attr("type", "text");
            $("#InputNewPassword i").removeClass("fa-eye-slash");
            $("#InputNewPassword i").addClass("fa-eye");
        }
    });

    $("#InputCurrentPassword a").on("click", function (event) {
        event.preventDefault();
        if ($("#InputCurrentPassword input").attr("type") == "text") {
            $("#InputCurrentPassword input").attr("type", "password");
            $("#InputCurrentPassword i").addClass("fa-eye-slash");
            $("#InputCurrentPassword i").removeClass("fa-eye");
        } else if (
            $("#InputCurrentPassword input").attr("type") == "password"
        ) {
            $("#InputCurrentPassword input").attr("type", "text");
            $("#InputCurrentPassword i").removeClass("fa-eye-slash");
            $("#InputCurrentPassword i").addClass("fa-eye");
        }
    });
});

//Popover
$(function () {
    $('[data-toggle="popover"]')
        .popover({ trigger: "manual", html: true, animation: false })

        .on("mouseenter", function () {
            var _this = this;
            $(this).popover("show");
            $(".popover").on("mouseleave", function () {
                $(_this).popover("hide");
            });
        })
        .on("mouseleave", function () {
            var _this = this;
            setTimeout(function () {
                if (!$(".popover:hover").length) {
                    $(_this).popover("hide");
                }
            }, 300);
        });
});

function injectJS() {
    var frame = $("iframe");
    var contents = frame.contents();
    var body = contents.find("body").attr("oncontextmenu", "return false");
    document.addEventListener("contextmenu", (event) => event.preventDefault());
}

// currency for budget
// Jquery Dependency

$("input[data-type='currency']").on({
    keyup: function () {
        formatCurrency($(this));
    },
    blur: function () {
        formatCurrency($(this), "blur");
    },
});

function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function putremarks() {
    if(document.getElementById("remarks").value==="") { 
           document.getElementById('rejectbutton').disabled = true; 
           document.getElementById('acceptbutton').disabled = false; 
       } else { 
           document.getElementById('rejectbutton').disabled = false;
           document.getElementById('acceptbutton').disabled = true;
       }
   }


function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") {
        return;
    }

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {
        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
            right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = "₱ " + left_side + "." + right_side;
    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = "₱ " + input_val;

        // final formatting
        if (blur === "blur") {
            input_val += ".00";
        }
    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

// proposal comments

function injectJS() {
    var frame = $("iframe");
    var contents = frame.contents();
    var body = contents.find("body").attr("oncontextmenu", "return false");
    document.addEventListener("contextmenu", (event) => event.preventDefault());
}

$(document).ready(function () {
    $("#arrow-comments").on("click", function (event) {
        if ($("#arrow-comments").hasClass("fa-chevron-circle-down")) {
            $("#arrow-comments")
                .removeClass("fa-chevron-circle-down")
                .addClass("fa-chevron-circle-up");
            $("#comments-container").removeClass("d-none").addClass("d-block");
        } else if ($("#arrow-comments").hasClass("fa-chevron-circle-up")) {
            $("#arrow-comments")
                .removeClass("fa-chevron-circle-up")
                .addClass("fa-chevron-circle-down");
            $("#comments-container").removeClass("d-block").addClass("d-none");
        }
    });
});