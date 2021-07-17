require('./bootstrap');

import Custom from './custom';
window.Custom = Custom;


import Vue from 'vue';
window.Vue = require('vue');


Vue.component('switch-input', require('./components/form-inputs/SwitchInput.vue').default);
Vue.component('text-input', require('./components/form-inputs/TextInput.vue').default);
Vue.component('drop-down', require('./components/form-inputs/DropDown.vue').default);
Vue.component('text-area', require('./components/form-inputs/TextArea.vue').default);

// Questionnary Process
if(document.getElementById("questionnaryForm")) {
console.log('ERT');
    Vue.component('questionary-form', require('./components/QuestionnaryComponent.vue').default);
    const app = new Vue({
        el: '#questionnaryForm'
    });
}