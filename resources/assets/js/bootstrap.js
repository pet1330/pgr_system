
window._ = require('lodash');

// global.$ = global.jQuery = require('jquery');

window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');


window.Vue = require('vue');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
};
