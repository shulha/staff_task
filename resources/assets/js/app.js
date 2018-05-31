
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import EmployeesIndex from './components/employees/EmployeesIndex.vue';
import EmployeesCreate from './components/employees/EmployeesCreate.vue';

const routes = [
    {
        path: '/',
        component: EmployeesIndex
    },
    {
        path: '/create',
        component: EmployeesCreate,
        name: 'createEmployee'
    },
];

const router = new VueRouter({ routes });

const app = new Vue({ router }).$mount('#app');
