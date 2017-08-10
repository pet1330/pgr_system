
require('./bootstrap');

window.events = new Vue();

require('./AdminLTE');

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('click-confirm', require('./components/ClickConfirm.vue'));
// Vue.component('toggle', require('./components/ToggleButton.vue'));
// Vue.component('simple-toggle', require('./components/simpleToggle.vue'));
// Vue.component('edit-modal', require('./components/EditModal.vue'));
Vue.component('bug-report', require('./components/BugReport.vue'));

window.flash = function(message) { window.events.$emit('flash', message); };

const app = new Vue({ el: '#app' });
