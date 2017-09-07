
window._ = require('lodash');

// global.$ = global.jQuery = require('jquery');
require('bootstrap-sass');
require('./AdminLTE');

// window.dtbs = require('datatables.net-bs')
// window.dtbuttons = require('datatables.net-buttons')
// window.dtbs = require('datatables.net-buttons-bs')

// window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// let token = document.head.querySelector('meta[name="csrf-token"]');

// window.axios.defaults.headers.common = { 'X-Requested-With': 'XMLHttpRequest' };

// window.Vue = require('vue');

// window.events =  Vue();

// Vue.component('flash', require('./components/Flash.vue'));
// Vue.component('click-confirm', require('./components/ClickConfirm.vue'));
// Vue.component('bug-report', require('./components/BugReport.vue'));

// window.flash = function(message) { window.events.$emit('flash', message); };

// const app = new Vue({ el: '#app' });

require('./datatables.js')

import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

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

// DEAL WITH LATER ========================================================
// Vue.component('toggle', require('./components/ToggleButton.vue'));
// Vue.component('simple-toggle', require('./components/simpleToggle.vue'));
// Vue.component('edit-modal', require('./components/EditModal.vue'));

