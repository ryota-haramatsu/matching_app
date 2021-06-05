import './bootstrap'
import Vue from 'vue'
import Vuetify from './plugins/vuetify'
import router from './router'
import App from './App.vue'
import store from './stores'


// require('./bootstrap');

// window.Vue = require('vue');
const createApp = async () => {
    await store.dispatch('auth/currentUser')

    new Vue({
        el: '#app',
        router,
        store,
        vuetify: Vuetify,
        components: { App },
        template: '<App />',
    })
}

createApp()


