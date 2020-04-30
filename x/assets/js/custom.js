/****
 *
 *  Custom.js file.
 *  Create custom code for admin panel  here
 *
 ****/

var hostname = $(location).attr('hostname');

if (hostname == 'localhost') {
    var post_url = $(location).attr("href");
    var host = "http://localhost/organicstore/";
} else {
    var post_url = $(location).attr("href");
    var host = "http://"+hostname+"/organicstore/";
}

function cancelBtn(url,formName){
    // alert(url);
    window.location.href = url;
    $("#"+formName).trigger("reset");
}

$('[name="role_status"]').on( 'change', function(){

    $( "#role" ).hide();
    if( $(this).val() == 1 || $(this).val() == '' ){
        $( "#role" ).show( );
    }
});

$('[name="role_status"]').on( 'click', function(){

    $( "#role-div" ).hide( 'slow' );
    if( $(this).val() == 1 ){
        $( "#role-div" ).show( 'slow' );
    }
});
$('[name="role_id"]').on( 'click', function(){

    $( "#role-div label" ).removeClass( 'checked-radio' );
    $(this).parents( 'label' ).addClass( 'checked-radio' );
});

$( function() {
    $( "#role-div div.radio").css( 'display', 'none' );
});

$('.form-actions .row .col-md-offset-3 .default ').on( 'click', function(){

   window.location.reload();
});

$(function() {

    if (localStorage.chkbx && localStorage.chkbx != '') {
        $('#remember_me').attr('checked', 'checked');
        $('#email').val(localStorage.email);
        $('#password').val(localStorage.password);
    } else {
        $('#remember_me').removeAttr('checked');
        $('#email').val('');
        $('#password').val('');
    }

    $('#remember_me').click(function() {

        if ($('#remember_me').is(':checked')) {
            // save username and password
            localStorage.email = $('#email').val();
            localStorage.password = $('#password').val();
            localStorage.chkbx = $('#remember_me').val();
        } else {
            localStorage.email = '';
            localStorage.password = '';
            localStorage.chkbx = '';
        }
    });
});