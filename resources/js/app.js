/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

//////////////////////////////////////////////// 1 import router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
/////////////////////////////////////////////////////////////vue permisions
import Permissions from './mixins/Permissions';
import Roles from './mixins/Roles';
Vue.mixin(Permissions);
Vue.mixin(Roles);
////////////////////////////////////////////////////////////////////////////// Global event bus
Vue.prototype.$eventHub = new Vue(); 
////////////////////////////////////////////////////////////////////////// Custom Event
window.Fire =  new Vue();
////////////////////////////////////////////////////////////////////////// sweetalert2
import swal from 'sweetalert2' // sweetalert2
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
window.toast = toast;




////////////////////////////////////////////////////
import Dashboard from './components/Dashboard.vue'

import UsersIndex from './views/users/UsersIndex'
import UsersShow from './views/users/UsersShow'
import UsersEdit from './views/users/UsersEdit'

import RolesIndex from './views/roles/RolesIndex'
import RolesShow from './views/roles/RolesShow'
import RolesEdit from './views/roles/RolesEdit'


//////////////////////////////////////////////// 2 routers
let routes = [

    { path: '/dashboard', name: 'Dashboard', component: Dashboard },

    ////////////////    
    { path: '/users', name: 'UsersIndex', component:UsersIndex, meta: {mode: 'list'} },
    { path: '/users/create', name: 'UsersEdit', component: UsersEdit, meta: {mode: 'create'} },
    { path: '/users/:id/edit', name: 'UsersEdit', component: UsersEdit, meta: {mode: 'edit'} },
    { path: '/users/:id',  name: 'UsersShow', component: UsersShow, meta: {mode: 'view'} },
    
    { path: '/roles', name: 'RolesIndex', component: RolesIndex, meta: {mode: 'list'} },
    { path: '/roles/create', name: 'RolesEdit', component: RolesEdit, meta: {mode: 'create'} },
    { path: '/roles/:id/edit', name: 'RolesEdit', component: RolesEdit, meta: {mode: 'edit'} },
    { path: '/roles/:id',  name: 'RolesShow', component: RolesShow, meta: {mode: 'view'} },  

    
    ]




////////////////////////////////////////////////3 define router
const router = new VueRouter({    
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router,
});
