require('./bootstrap');

//window.$ = jQuery;
global.jQuery = window.$ = require('jquery');

Tagify = require('@yaireo/tagify/dist/jQuery.tagify.min');

global.Cropper = require('cropperjs/dist/cropper.min');

toastr = require('toastr/toastr');
require('@popperjs/core');
require('bootstrap/dist/js/bootstrap');


toastr.options = {
    "showMethod": "slideDown",
    "hideMethod": "slideUp",
    "positionClass": "toast-bottom-center",
}
