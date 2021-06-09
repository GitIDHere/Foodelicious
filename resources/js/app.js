require('./bootstrap');

//window.$ = jQuery;
global.jQuery = window.$ = require('jquery');

Tagify = require('@yaireo/tagify/dist/jQuery.tagify.min');

global.Cropper = require('cropperjs/dist/cropper.min');

toastr = require('toastr/toastr');
require('@popperjs/core');
require('bootstrap/dist/js/bootstrap');


toastr.options = {
    "timeOut": "15000000",
    "showMethod": "slideDown",
    "hideMethod": "slideUp",
    "positionClass": "toast-bottom-center",
}
