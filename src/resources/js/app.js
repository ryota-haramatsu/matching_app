import Vue from 'vue'
import Vuetify from './plugins/vuetify'
import router from './router'
import App from './App.vue'
import store from './stores'
import './bootstrap'


// require('./bootstrap');

// window.Vue = require('vue');


new Vue({
    el: '#app',
    router,
    store,
    vuetify: Vuetify,
    components: { App },
    template: '<App />',
});



