require('./bootstrap');

//window.$ = jQuery;
global.jQuery = window.$ = require('jquery');

require('snazzy-info-window/dist/snazzy-info-window.min');

Tagify = require('@yaireo/tagify/dist/jQuery.tagify.min');

global.Cropper = require('cropperjs/dist/cropper.min');

toastr = require('toastr/toastr');
window.Dropzone = require('dropzone/src/dropzone');

require('@popperjs/core');
require('bootstrap/dist/js/bootstrap');


toastr.options = {
    "showMethod": "slideDown",
    "hideMethod": "slideUp",
    "positionClass": "toast-bottom-center",
}
