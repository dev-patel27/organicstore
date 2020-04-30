var hostname = $(location).attr("hostname");

if (hostname == "localhost") {
    var post_url = $(location).attr("href");
    var host = "http://localhost/organicstore/";
} else {
    var post_url = $(location).attr("href");
    var host = "http://" + hostname + "/organicstore/";
}

$(document).ready(function() {
    /** search by suggestion */
    $("#search-top").on("keyup", function(e) {
        var search = $(this).val();
        if (search != "") {
            $.ajax({
                type: "POST",
                url: host + "search-listing",
                data: { search: search },
                success: function(response) {
                    var response_data = JSON.parse(response);
                    if (response_data.status == 200) {
                        $("#suggestion").html(response_data.data);
                        $("#suggestion").show();
                    }
                    if (response_data.status == 400) {
                        $("#suggestion").html(response_data.data);
                    }
                },
            });
        } else {
            $("#suggestion").hide("");
            $("#suggestion").html("");
        }
    });
    /* enter event*/
    $("#search-top").keypress(function(event) {
        if (event.keyCode === 13) {
            search();
        }
    });
    /**search on-click */
    function search() {
        var search = $("#search-top").val();
        var url = host + "search-keyword?keyword=" + search;
        window.location.replace(url);
    }

    $("#bill-add").click(function(e) {
        let bill_first_name = $.trim($("#bill_first_name").val());
        let bill_last_name = $.trim($("#bill_last_name").val());
        let bill_email = $.trim($("#bill_email").val());
        let bill_number = $.trim($("#bill_number").val());
        let bill_address = $.trim($("#bill_address").val());
        let bill_country = $.trim($("#bill_country").val());
        let bill_state = $.trim($("#bill_state").val());
        let bill_city = $.trim($("#bill_city").val());
        let payment_mode = $.trim($("#payment_mode").val());
        let bill_post_code = $.trim($("#bill_post_code").val());
        let nameFilter = /^[a-z ,.'-]+$/i;
        let mobileFilter = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
        let postFilter = /\d{6}$/;
        let emailFilter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (bill_first_name == "") {
            toaserMessage(400, "First name is required");
            return false;
        } else if (!nameFilter.test(bill_first_name)) {
            toaserMessage(400, "Please enter valid first name");
            return false;
        } else if (bill_last_name == "") {
            toaserMessage(400, "Last name is required");
            return false;
        } else if (!nameFilter.test(bill_last_name)) {
            toaserMessage(400, "Please enter valid last name");
            return false;
        } else if (bill_email == "") {
            toaserMessage(400, "Email is required");
            return false;
        } else if (!emailFilter.test(bill_email)) {
            toaserMessage(400, "Please enter valid email");
            return false;
        } else if (bill_number == "") {
            toaserMessage(400, "Mobile number is required");
            return false;
        } else if (!mobileFilter.test(bill_number)) {
            toaserMessage(400, "Please enter valid mobile number");
            return false;
        } else if (bill_address == "") {
            toaserMessage(400, "Address is required");
            return false;
        } else if (bill_country == "") {
            toaserMessage(400, "Country is required");
            return false;
        } else if (bill_state == "") {
            toaserMessage(400, "State is required");
            return false;
        } else if (bill_city == "") {
            toaserMessage(400, "City is required");
            return false;
        } else if (bill_post_code == "") {
            toaserMessage(400, "Postal code is required");
            return false;
        } else if (!postFilter.test(bill_post_code)) {
            toaserMessage(400, "Please enter valid postal code");
            return false;
        } else if ($('input[name="payment_mode"]:checked').length == 0) {
            toaserMessage(400, "Please select payment mode");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "billing-address",
                data: $("#billing-form").serialize(),
                success: function(response) {},
            });
        }
    });

    $("#confirmOrder").click(function(e) {
        let bill_first_name = $.trim($("#bill_first_name").val());
        let bill_last_name = $.trim($("#bill_last_name").val());
        let bill_email = $.trim($("#bill_email").val());
        let bill_number = $.trim($("#bill_number").val());
        let bill_address = $.trim($("#bill_address").val());
        let bill_country = $.trim($("#bill_country").val());
        let bill_state = $.trim($("#bill_state").val());
        let bill_city = $.trim($("#bill_city").val());
        let bill_post_code = $.trim($("#bill_post_code").val());
        let additional_note = $.trim($("#additional_note").val());
        let sub_total = $("#sub-total").html();
        let ship_charge = $("#ship-charge").html();
        let grand_total = $("#grand-total").html();
        if ($("#cod").prop("checked")) {
            var payment_mode = 0;
        }
        if ($("#bank_transfer").prop("checked")) {
            var payment_mode = 1;
        }
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: host + "confirm-order",
            data: {
                first_name: bill_first_name,
                last_name: bill_last_name,
                email: bill_email,
                mobile_no: bill_number,
                address: bill_address,
                country: bill_country,
                state: bill_state,
                city: bill_city,
                post_code: bill_post_code,
                payment_mode: payment_mode,
                sub_total: sub_total,
                ship_charge: ship_charge,
                grand_total: grand_total,
                additional_note: additional_note,
            },
            success: function(response) {
                let response_data = JSON.parse(response);
                if (response_data.status == 200) {
                    window.location.href = host + response_data.data;
                    return false;
                } else if (response_data.status == 400) {
                    toastr.error(response_data.data);
                    return false;
                }
            },
        });
    });

    $(".order-popup").on("click", function() {
        let order_id = $(this).attr("id");
        $.ajax({
            type: "post",
            url: host + "order-details-modal",
            data: { order_id: order_id },
            success: function(response) {
                let response_data = JSON.parse(response);
                if (response_data.status == 200) {
                    $(".order-display").html(response_data.data);
                    return false;
                } else if (response_data.status == 400) {
                    toastr.error(response_data.data);
                    return false;
                }
            },
        });
    });

    $("#contact-form").submit(function(e) {
        let cname = $.trim($("#cname").val());
        let cemail = $.trim($("#cemail").val());
        let cmessage = $.trim($("#cmessage").val());
        let nameFilter = /^[a-z ,.'-]+$/i;
        let emailFilter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (cname == "") {
            toaserMessage(400, "Name is required");
            return false;
        } else if (!nameFilter.test(cname)) {
            toaserMessage(400, "Please enter valid name");
            return false;
        } else if (cemail == "") {
            toaserMessage(400, "Email is required");
            return false;
        } else if (!emailFilter.test(cemail)) {
            toaserMessage(400, "Please enter valid email");
            return false;
        } else if (cmessage == "") {
            toaserMessage(400, "Message is required");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "contact",
                data: $("#contact-form").serialize(),
                beforeSend: function() {
                    $(".se-pre-con").show();
                },
                complete: function() {
                    $(".se-pre-con").hide();
                },
                success: function(response) {
                    let response_data = JSON.parse(response);
                    if (response_data.status == 200) {
                        toastr.success(response_data.data);
                        $("#contact-form").trigger("reset");
                        return false;
                    } else if (response_data.status == 400) {
                        toastr.error(response_data.data);
                        return false;
                    }
                },
            });
        }
    });

    $(".change-details").on("click", function(e) {
        let social_title = $("input[name='social_title']:checked").val();
        let first_name = $.trim($("#change_first_name").val());
        let last_name = $.trim($("#change_last_name").val());
        let email = $.trim($("#change_email").val());
        let password = $.trim($("#change_password").val());
        let dob = $.trim($("#change_dob").val());
        let nameFilter = /^[a-z ,.'-]+$/i;
        let emailFilter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        let dobFilter = /^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/;
        if (!nameFilter.test(first_name)) {
            toaserMessage(400, "Please enter valid first name");
            return false;
        } else if (!nameFilter.test(last_name)) {
            toaserMessage(400, "Please enter valid last name");
            return false;
        } else if (!emailFilter.test(email)) {
            toaserMessage(400, "Please enter valid email");
            return false;
        } else if (!dobFilter.test(dob)) {
            toaserMessage(400, "Please enter valid birth date");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "change-profile",
                data: {
                    social_title: social_title,
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    password: password,
                    dob: dob,
                },
                beforeSend: function() {
                    $(".se-pre-con").show();
                },
                complete: function() {
                    $(".se-pre-con").hide();
                },
                success: function(response) {
                    let response_data = JSON.parse(response);
                    if (response_data.status == 200) {
                        toastr.success(response_data.data);
                        return false;
                    } else if (response_data.status == 400) {
                        toastr.error(response_data.data);
                        return false;
                    }
                },
            });
        }
    });

    $("#change-password-form").submit(function(e) {
        let old_password = $.trim($("#old_password").val());
        let new_password = $.trim($("#new_password").val());
        let confirm_new_password = $.trim($("#confirm_new_password").val());
        if (old_password == "") {
            toaserMessage(400, "Old Password is required");
            return false;
        } else if (new_password == "") {
            toaserMessage(400, "New Password is required");
            return false;
        } else if (confirm_new_password == "") {
            toaserMessage(400, "Confirm Password is required");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "change-password",
                data: {
                    old_password: old_password,
                    new_password: new_password,
                    confirm_new_password: confirm_new_password,
                },
                success: function(response) {
                    var response_data = JSON.parse(response);
                    if (response_data.message == "old_password") {
                        toastr.error(response_data.old_password_error);
                    }
                    if (response_data.message == "new_password") {
                        toastr.error(response_data.new_password_error);
                    }
                    if (response_data.message == "confirm_new_password") {
                        toastr.error(response_data.confirm_new_password_error);
                    }
                    if (response_data.status == 200) {
                        toastr.success(response_data.data);
                        $("#change-password-form").trigger("reset");
                        setTimeout(function() {
                            window.location.href = host;
                        }, 1500);
                    }
                    if (response_data.status == 400) {
                        toastr.error(response_data.data);
                    }
                },
            });
        }
    });

    $("#add-address").on("click", function(e) {
        let add_first_name = $.trim($("#add_first_name").val());
        let add_last_name = $.trim($("#add_last_name").val());
        let add_email = $.trim($("#add_email").val());
        let add_number = $.trim($("#add_number").val());
        let add_address = $.trim($("#add_address").val());
        let bill_country = $.trim($("#bill_country").val());
        let bill_state = $.trim($("#bill_state").val());
        let bill_city = $.trim($("#bill_city").val());
        let add_post_code = $.trim($("#add_post_code").val());
        let nameFilter = /^[a-z ,.'-]+$/i;
        let mobileFilter = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
        let postFilter = /\d{6}$/;
        let emailFilter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (add_first_name == "") {
            toaserMessage(400, "First name is required");
            return false;
        } else if (!nameFilter.test(add_first_name)) {
            toaserMessage(400, "Please enter valid first name");
            return false;
        } else if (add_last_name == "") {
            toaserMessage(400, "Last name is required");
            return false;
        } else if (!nameFilter.test(add_last_name)) {
            toaserMessage(400, "Please enter valid last name");
            return false;
        } else if (add_email == "") {
            toaserMessage(400, "Email is required");
            return false;
        } else if (!emailFilter.test(add_email)) {
            toaserMessage(400, "Please enter valid email");
            return false;
        } else if (add_number == "") {
            toaserMessage(400, "Mobile Number is required");
            return false;
        } else if (!mobileFilter.test(add_number)) {
            toaserMessage(400, "Please enter valid mobile number");
            return false;
        } else if (add_address == "") {
            toaserMessage(400, "Address is required");
            return false;
        } else if (bill_country == "") {
            toaserMessage(400, "Country is required");
            return false;
        } else if (bill_state == "") {
            toaserMessage(400, "State is required");
            return false;
        } else if (bill_city == "") {
            toaserMessage(400, "City is required");
            return false;
        } else if (add_post_code == "") {
            toaserMessage(400, "Postal code is required");
            return false;
        } else if (!postFilter.test(add_post_code)) {
            toaserMessage(400, "Please enter valid postal code");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "add-address",
                data: {
                    add_first_name: add_first_name,
                    add_last_name: add_last_name,
                    add_email: add_email,
                    add_number: add_number,
                    add_address: add_address,
                    bill_country: bill_country,
                    bill_state: bill_state,
                    bill_city: bill_city,
                    add_post_code: add_post_code,
                },
                success: function(response) {
                    var response_data = JSON.parse(response);
                    if (response_data.status == 200) {
                        toastr.success(response_data.data);
                        $("#add-address-form").trigger("reset");
                        setTimeout(function() {
                            window.location.href = host + "myaccount";
                        }, 1500);
                    }
                    if (response_data.status == 400) {
                        toastr.error(response_data.data);
                    }
                },
            });
        }
    });

    $("#newsletter-form").on("click", function(e) {
        let newsemail = $.trim($("#newsemail").val());
        let emailFilter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (newsemail == "") {
            toaserMessage(400, "Email is required");
            return false;
        } else if (!emailFilter.test(newsemail)) {
            toaserMessage(400, "Please enter valid email");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "newsletter",
                data: { newsemail: newsemail },
                beforeSend: function() {
                    $(".se-pre-con").show();
                },
                complete: function() {
                    $(".se-pre-con").hide();
                },
                success: function(response) {
                    let response_data = JSON.parse(response);
                    if (response_data.status == 200) {
                        toastr.success(response_data.data);
                        $("#newsemail").val("");
                        return false;
                    } else if (response_data.status == 400) {
                        toastr.error(response_data.data);
                        return false;
                    }
                },
            });
        }
    });

    $("#reg-form").submit(function(e) {
        let first_name = $.trim($("#first_name").val());
        let last_name = $.trim($("#last_name").val());
        let username = $.trim($("#username").val());
        let email = $.trim($("#email").val());
        let password = $.trim($("#password").val());
        let nameFilter = /^[a-z ,.'-]+$/i;
        let usernameFilter = /^[a-z]\w+$/i;
        let emailFilter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (first_name == "") {
            toaserMessage(400, "First name is required");
            return false;
        } else if (!nameFilter.test(first_name)) {
            toaserMessage(400, "Please enter valid first name");
            return false;
        } else if (last_name == "") {
            toaserMessage(400, "Last name is required");
            return false;
        } else if (!nameFilter.test(last_name)) {
            toaserMessage(400, "Please enter valid last name");
            return false;
        } else if (username == "") {
            toaserMessage(400, "Username is required");
            return false;
        } else if (!usernameFilter.test(username)) {
            toaserMessage(400, "Please enter valid username");
            return false;
        } else if (email == "") {
            toaserMessage(400, "Email is required");
            return false;
        } else if (!emailFilter.test(email)) {
            toaserMessage(400, "Please enter valid email");
            return false;
        } else if (password == "") {
            toaserMessage(400, "Password is required");
            return false;
        } else if (re_password == "") {
            toaserMessage(400, "Confirm Password is required");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "registration",
                data: $("#reg-form").serialize(),
                beforeSend: function() {
                    $(".se-pre-con").show();
                },
                complete: function() {
                    $(".se-pre-con").hide();
                },
                success: function(response) {
                    let response_data = JSON.parse(response);
                    if (response_data.message == "first_name") {
                        toastr.error(response_data.fname_error);
                    }
                    if (response_data.message == "last_name") {
                        toastr.error(response_data.lname_error);
                    }
                    if (response_data.message == "username") {
                        toastr.error(response_data.username_error);
                    }
                    if (response_data.message == "email") {
                        toastr.error(response_data.email_error);
                    }
                    if (response_data.message == "password") {
                        toastr.error(response_data.password_error);
                    }
                    if (response_data.message == "re_password") {
                        toastr.error(response_data.re_password_error);
                    }
                    if (response_data.status == 200) {
                        toastr.success(response_data.data);
                        $("#RegistrationModal").modal("hide");
                        $("#reg-form").trigger("reset");
                        return false;
                    } else if (response_data.status == 400) {
                        if (response_data.data) {
                            toastr.error(response_data.data);
                        }
                        if (response_data.data1) {
                            toastr.error(response_data.data1);
                        }
                        return false;
                    }
                },
            });
        }
    });

    $("#login-form").submit(function(e) {
        let login_id = $.trim($("#login_id").val());
        let login_password = $.trim($("#login_password").val());
        if (login_id == "") {
            toaserMessage(400, "Username / E-mail is required");
            return false;
        } else if (login_password == "") {
            toaserMessage(400, "Password is required");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "login",
                data: $("#login-form").serialize(),
                success: function(response) {
                    $(".se-pre-con").hide();
                    var response_data = JSON.parse(response);
                    if (response_data.message == "login_id") {
                        toastr.error(response_data.login_id_error);
                    }
                    if (response_data.message == "login_password") {
                        toastr.error(response_data.password_error);
                    }
                    if (response_data.status == 200) {
                        toastr.success(response_data.data);
                        $(".se-pre-con").show();
                        $("#login-form").trigger("reset");
                        $("#LogInModal").modal("hide");
                        setTimeout(function() {
                            window.location.href = host;
                            $(".se-pre-con").hide();
                        }, 1500);
                    }
                    if (response_data.status == 400) {
                        toastr.error(response_data.data);
                    }
                },
            });
        }
    });

    $("#forgotpass-form").submit(function(e) {
        let flag = 0;
        let forgot_email = $.trim($("#forgot_email").val());
        let emailFilter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (forgot_email == "") {
            toaserMessage(400, "E-mail is required");
            return false;
        } else if (!emailFilter.test(forgot_email)) {
            toaserMessage(400, "Please enter valid email");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "forgot-password",
                data: $("#forgotpass-form").serialize(),
                beforeSend: function() {
                    $(".se-pre-con").show();
                },
                complete: function() {
                    $(".se-pre-con").hide();
                },
                success: function(response) {
                    var response_data = JSON.parse(response);
                    if (response_data.message == "forgot_email") {
                        toastr.error(response_data.forgot_email_error);
                        return 5;
                    }
                    if (response_data.status == 200) {
                        toastr.success(response_data.data);
                        $("#ForgotModal").modal("hide");
                        $("#forgotpass-form").trigger("reset");
                    }
                    if (response_data.status == 400) {
                        toastr.error(response_data.data);
                    }
                },
            });
        }
    });

    $("#resetpass-form").submit(function(e) {
        let reset_password = $.trim($("#reset_password").val());
        let reset_password2 = $.trim($("#reset_password2").val());
        let id = $("#user_id").val();
        if (reset_password == "") {
            toaserMessage(400, "Password is required");
            return false;
        } else if (reset_password2 == "") {
            toaserMessage(400, "Confirm Password is required");
            return false;
        } else {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: host + "update-reset-password",
                data: {
                    reset_password: reset_password,
                    reset_password2: reset_password2,
                    id: id,
                },
                success: function(response) {
                    var response_data = JSON.parse(response);
                    if (response_data.message == "reset_password") {
                        toastr.error(response_data.reset_password_error);
                    }
                    if (response_data.message == "reset_password2") {
                        toastr.error(response_data.reset_password2_error);
                    }
                    if (response_data.status == 200) {
                        toastr.success(response_data.data);
                        $(".se-pre-con").show();
                        $("#resetpass-form").trigger("reset");
                        setTimeout(function() {
                            window.location.href = host;
                            $(".se-pre-con").hide();
                        }, 3000);
                    }
                    if (response_data.status == 400) {
                        toastr.error(response_data.data);
                    }
                },
            });
        }
    });

    $("#ckbCheckAll").click(function() {
        $(".checkBoxClass").prop("checked", $(this).prop("checked"));
    });
});

function addToWishlist(product_id) {
    $.ajax({
        type: "POST",
        url: host + "add-wishlist",
        data: {
            product_id: product_id,
        },
        success: function(response) {
            var response_data = JSON.parse(response);
            if (response_data.status == 200) {
                if (response_data.data1 == 2) {
                    toastr.error(response_data.data);
                    $("#LogInModal").modal("show");
                }
                if (response_data.data1 == 0) {
                    $("." + product_id + "-active").removeClass("active-wishlist");
                    toastr.success(response_data.data);
                    $(".my-wishlist").html(response_data.data2);
                    if (response_data.data2 == 0) {
                        $(".empty-wishlist").html(
                            '<div class="container> <div class="row"><div class="displayFlex"><h1>Empty Wishlist</h1><div>You have no items in your wishlist. Start adding!</div></div> </div> </div>'
                        );
                        $(".rm-class").hide();
                    }
                }
                if (response_data.data1 == 1) {
                    $("." + product_id + "-active").addClass("active-wishlist");
                    toastr.success(response_data.data);
                    $(".my-wishlist").html(response_data.data2);
                }
            }
            if (response_data.status == 400) {
                toastr.error(response_data.data);
            }
        },
    });
}

function addToCart(product_id, product_price, availability, type) {
    if (type == "detail") {
        quantity = $("#product-detail-" + product_id).val();
    }
    if (type == "grid") {
        quantity = $("#product-grid-" + product_id).val();
    }
    if (type == "list") {
        quantity = $("#product-list-" + product_id).val();
    }
    if (type == 0) {
        quantity = $("#load-product-grid-" + product_id).val();
    }
    if (type == 1) {
        quantity = $("#load-product-list-" + product_id).val();
    }
    if (type == 2) {
        quantity = $("#filter-product-grid-" + product_id).val();
    }
    if (type == 3) {
        quantity = $("#filter-product-list-" + product_id).val();
    }
    $.ajax({
        type: "POST",
        url: host + "add-cart",
        data: {
            product_id: product_id,
            quantity: quantity,
            product_price: product_price,
            availability: availability,
        },
        success: function(response) {
            var response_data = JSON.parse(response);
            if (response_data.status == 200) {
                if (response_data.data1 == 2) {
                    toastr.error(response_data.data);
                    $("#LogInModal").modal("show");
                }
                if (response_data.data1 == 0) {
                    toastr.success(response_data.data);
                    $(".my-cart").html(response_data.data2);
                    location.href = host + "cart";
                    if (response_data.data2 == 0) {
                        $(".empty-wishlist").html(
                            '<div class="container> <div class="row"><div class="displayFlex"><h1>Empty Cart</h1><div>You have no items in your cart. Start adding!</div></div> </div> </div>'
                        );
                        $(".rm-class").hide();
                        $("._grid").hide();
                    }
                }
                if (response_data.data1 == 1) {
                    toastr.success(response_data.data);
                    $(".my-cart").html(response_data.data2);
                    location.href = host + "cart";
                }
                if (response_data.data1 == 3) {
                    toastr.error(response_data.data);
                }
            }
            if (response_data.status == 400) {
                toastr.error(response_data.data);
            }
        },
    });
}

function removeCart(id) {
    var price = $(".update-total" + id).html();
    var sub_total = $(".sub-total").html();
    var final_total = $(".final-total").html();
    var ship_charge = $("#old-ship-charge").val();
    $.ajax({
        type: "POST",
        url: host + "remove-cart",
        data: {
            id: id,
            price: price,
            sub_total: sub_total,
            final_total: final_total,
            ship_charge: ship_charge,
        },
        success: function(response) {
            var response_data = JSON.parse(response);
            if (response_data.status == 200) {
                $(".my-cart").html(response_data.data1);
                toastr.error("Removed from your cart");
                $(".sub-total").html(response_data.data3);
                if (response_data.data3 > 100) {
                    $(".ship-charge").html("Free");
                    $(".final-total").html(response_data.data3);
                } else {
                    $(".ship-charge").html("₹" + response_data.data5);
                    $(".final-total").html(response_data.data4);
                }
                if (response_data.data1 == null) {
                    $(".my-cart").html(0);
                    $(".rm-class").hide();
                    $("._grid").hide();
                    $(".empty-wishlist").html(
                        '<div class="container> <div class="row"><div class="displayFlex"><h1>Empty Cart</h1><div>You have no items in your cart. Start adding!</div></div> </div></div>'
                    );
                }
            }
            if (response_data.status == 400) {
                toastr.error(response_data.data);
            }
        },
    });
}

function incrementQuantity(id, product_id) {
    var price = $(".update-total" + id).html();
    var sub_total = $(".sub-total").html();
    var final_total = $(".final-total").html();
    $.ajax({
        type: "POST",
        url: host + "increment-quantity",
        data: {
            price: price,
            product_id: product_id,
            id: id,
            sub_total: sub_total,
            final_total: final_total,
        },
        success: function(response) {
            var response_data = JSON.parse(response);
            if (response_data.status == 200) {
                $("#minus" + id).prop("disabled", false);
                $("#minus" + id).css("cursor", "pointer");
                $(".update-total" + id).html(response_data.data);
                $("#qty" + id).html(response_data.data1);
                $(".my-cart").html(response_data.data2);
                $(".sub-total").html(response_data.data3);
                if (response_data.data3 > 100) {
                    $(".ship-charge").html("Free");
                    $(".final-total").html(response_data.data3);
                } else {
                    $(".final-total").html(response_data.data4);
                }
            }
            if (response_data.data1 == 0) {
                toastr.success(response_data.data);
                $(".my-cart").html(response_data.data2);
                location.href = host + "cart";
                if (response_data.data2 == 0) {
                    $(".empty-wishlist").html(
                        '<div class="container> <div class="row"><div class="displayFlex"><h1>Empty Wishlist</h1><div>You have no items in your cart. Start adding!</div></div> </div> </div>'
                    );
                    $(".rm-class").hide();
                }
            }
            if (response_data.status == 400) {
                toastr.error(response_data.data);
            }
        },
    });
}

function decrementQuantity(id, product_id) {
    var price = $(".update-total" + id).html();
    var sub_total = $(".sub-total").html();
    var final_total = $(".final-total").html();
    var ship_charge = $("#old-ship-charge").val();
    $.ajax({
        type: "POST",
        url: host + "decrement-quantity",
        data: {
            price: price,
            product_id: product_id,
            id: id,
            sub_total: sub_total,
            final_total: final_total,
            ship_charge: ship_charge,
        },
        success: function(response) {
            var response_data = JSON.parse(response);
            if (response_data.status == 200) {
                if (response_data.data == 0) {
                    $("#minus" + id).prop("disabled", true);
                    $("#minus" + id).css("cursor", "not-allowed");
                } else {
                    $(".update-total" + id).html(response_data.data);
                    $("#qty" + id).html(response_data.data1);
                    $(".my-cart").html(response_data.data2);
                    $(".sub-total").html(response_data.data3);
                    if (response_data.data3 < 100) {
                        $(".final-total").html(response_data.data4);
                        $(".ship-charge").html("₹" + response_data.data5);
                    } else {
                        $(".final-total").html(response_data.data3);
                    }
                }
            }
            if (response_data.data1 == 0) {
                toastr.success(response_data.data);
                $(".my-cart").html(response_data.data2);
                location.href = host + "cart";
                if (response_data.data2 == 0) {
                    $(".empty-wishlist").html(
                        '<div class="container> <div class="row"><div class="displayFlex"><h1>Empty Wishlist</h1><div>You have no items in your cart. Start adding!</div></div> </div> </div>'
                    );
                    $(".rm-class").hide();
                }
            }
            if (response_data.status == 400) {
                toastr.error(response_data.data);
            }
        },
    });
}

function removeAddress(address_id) {
    $.ajax({
        method: "POST",
        url: host + "remove-address",
        data: { address_id: address_id },
        success: function(response) {
            var response_data = JSON.parse(response);
            if (response_data.status == 200) {
                toastr.error(response_data.data);
                setTimeout(function() {
                    window.location.href = host + "myaccount";
                }, 1000);
            }
        },
    });
}

function selectAddress(address_id) {
    $(".address-1").removeClass("selected");
    $.ajax({
        method: "POST",
        url: host + "select-address",
        data: { address_id: address_id },
        success: function(response) {
            var response_data = JSON.parse(response);
            if (response_data.status == 200) {
                toastr.success(response_data.data);
                $("#select-address-" + address_id).addClass("selected");
            }
        },
    });
}

function getCountry() {
    //Country
    let country_id = $("#bill_country").val();
    if (country_id != "") {
        $.ajax({
            method: "POST",
            url: host + "state",
            data: { country_id: country_id },
            success: function(response) {
                var response_data = JSON.parse(response);
                if (response_data.status == 200) {
                    $("#bill_state").html(response_data.data);
                    $("#bill_city").html('<option value="">Select City</option>');
                }
            },
        });
    } else {
        $("#bill_state").html('<option value="">Select State</option>');
        $("#bill_city").html('<option value="">Select City</option>');
    }
}

//State
function getState() {
    let state_id = $("#bill_state").val();
    // alert(state_id);
    if (state_id != "") {
        $.ajax({
            method: "POST",
            url: host + "city",
            data: { state_id: state_id },
            success: function(response) {
                let response_data = JSON.parse(response);
                if (response_data.status == 200) {
                    $("#bill_city").html(response_data.data);
                }
            },
        });
    } else {
        $("#bill_city").html('<option value="">Select City</option>');
    }
}

function toaserMessage(status, message) {
    var type = status == "200" ? "success" : "error";
    toastr[type](message);
    toastr.options = {
        closeButton: true,
        debug: true,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: true,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
}