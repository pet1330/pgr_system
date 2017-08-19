
window._ = require('lodash');

// global.$ = global.jQuery = require('jquery');
require('bootstrap-sass');
require('./AdminLTE');

// window.dtbs = require('datatables.net-bs')
// window.dtbuttons = require('datatables.net-buttons')
// window.dtbs = require('datatables.net-buttons-bs')

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

// window.axios.defaults.headers.common = { 'X-Requested-With': 'XMLHttpRequest' };

window.Vue = require('vue');

window.events = new Vue();

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('click-confirm', require('./components/ClickConfirm.vue'));
Vue.component('bug-report', require('./components/BugReport.vue'));

window.flash = function(message) { window.events.$emit('flash', message); };

const app = new Vue({ el: '#app' });

require('./datatables.js')

// DEAL WITH LATER ========================================================
// Vue.component('toggle', require('./components/ToggleButton.vue'));
Vue.component('simple-toggle', require('./components/simpleToggle.vue'));
// Vue.component('edit-modal', require('./components/EditModal.vue'));
 
