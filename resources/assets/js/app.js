
window._ = require('lodash');

// window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
require('./AdminLTE');
require('./datatables.js')

import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

$(function() {

    $("#uploader").dropzone({
        dictDefaultMessage: "Drag & drop file or <strong><u>browse</u></strong>",
        maxFilesize: 20, // MB
        addRemoveLinks: false,
        createImageThumbnails:false,
        init: function () {
            this.on('success', function(file, message) {
                window.location.reload(true);
            });
        },
        uploadprogress: function(file, progress, bytesSent) {
           $('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
        },

        error: function(file, response) {
            $('.progress-bar').css('width', 0+'%').attr('aria-valuenow', 0);
            alert('Opps! That did not work. Please check the upload specification and try again');
        }
    });

    $('div.alert').not('.alert-important').delay(6000).fadeOut(350);
    $('#datepicker').datepicker({ changeMonth: true, changeYear: true, inline: true,
        dateFormat: "yy-mm-dd", altField: "#d", altFormat: "yy-mm-dd" });
    $('#enrolment_date').change(function(){ $('#datepicker').datepicker('setDate', $(this).val()); });
    $('#datepicker').change(function(){ $('#enrolment_date').attr('value',$(this).val()); });
    $('#datepicker').datepicker('setDate', $('#enrolment_date').val()); });
