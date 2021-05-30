import VueRouter from 'vue-router';
import Vuetify from './plugins/vuetify'

import HeaderComponent from "./components/HeaderComponent";
import KyouanListComponent from "./components/KyouanListComponent";
import KyouanDetailComponent from "./components/KyouanDetailComponent";
import KyouanCreateComponent from "./components/KyouanCreateComponent";
import KyouanEditComponent from "./components/KyouanEditComponent";
import TeacherProfileComponent from "./components/TeacherProfileComponent";


require('./bootstrap');

window.Vue = require('vue');
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/kyouan/list',
            name: 'kyouan.list',
            component: KyouanListComponent
        },
        {
            path: '/kyouan/create',
            name: 'kyouan.create',
            component: KyouanCreateComponent
        },
        {
            path: '/kyouan/:kyouanId',
            name: 'kyouan.show',
            component: KyouanDetailComponent,
            props: true

        },
        {
            path: '/kyouan/:kyouanId/edit',
            name: 'kyouan.edit',
            component: KyouanEditComponent,
            props: true
        },
        {
            path: '/teacher/:teacherId/profile',
            name: 'teacher.profie',
            component: TeacherProfileComponent,
            props: true
        }
    ]
});

Vue.component('header-component', HeaderComponent);

const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    router
});
