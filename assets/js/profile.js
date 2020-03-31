/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// import '../css/profile.js';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

// console.log('Hello Webpack Encore! Edit me in assets/js/main.js');

// $("#btn-submit").click(function(){

// });

$("#inputPassword1").on("keypress", function(){

    var password2 = $("#inputPassword2").val();

    // console.log(password2, (password2 != ""));
    if (password2 != ""){

        var password1 = $("#inputPassword1");

        if (password1 != password2){
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
        }
        else{
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
        }
    }

});

$("#inputPassword2").on("keyup paste change", function(){

    var password1 = $("#inputPassword1").val(),
    password2 = $("#inputPassword2").val();

    if (password1 != password2){
        $(this).removeClass("is-valid");
        $(this).addClass("is-invalid");
    }
    else{
        $(this).removeClass("is-invalid");
        $(this).addClass("is-valid");
    }

});