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
/////////////////////////////////////////////////////////////////////////polyfill
require('es6-promise').polyfill();
/////////////////////////////////////////////////////////////fullcal
import FullCalendar from "vue-full-calendar";
import "fullcalendar/dist/fullcalendar.min.css";
Vue.use(FullCalendar);
Vue.config.productionTip = false;
////////////////////////////////////////////////////////////fullcal


////////////////////////////////////////////////////
import Calendar from './views/calendar/Calendar'
import Dashboard from './components/Dashboard.vue'

import UsersIndex from './views/users/UsersIndex'
import UsersEdit from './views/users/UsersEdit'

import RolesIndex from './views/roles/RolesIndex'
import RolesShow from './views/roles/RolesShow'
import RolesEdit from './views/roles/RolesEdit'

import TasksIndex from './views/tasks/TasksIndex'
import TasksShow from './views/tasks/TasksShow'
import TasksEdit from './views/tasks/TasksEdit'

import TreatmentsIndex from './views/treatments/TreatmentsIndex'
import TreatmentsShow from './views/treatments/TreatmentsShow'
import TreatmentsEdit from './views/treatments/TreatmentsEdit'

import LocationsIndex from './views/locations/LocationsIndex'
import LocationsShow from './views/locations/LocationsShow'
import LocationsEdit from './views/locations/LocationsEdit'

import StatusesIndex from './views/statuses/StatusesIndex'
import StatusesShow from './views/statuses/StatusesShow'
import StatusesEdit from './views/statuses/StatusesEdit'

import SubStatusesIndex from './views/substatuses/SubStatusesIndex'
import SubStatusesShow from './views/substatuses/SubStatusesShow'
import SubStatusesEdit from './views/substatuses/SubStatusesEdit'

import ClientsIndex from './views/clients/ClientsIndex'
import ClientsEdit from './views/clients/ClientsEdit'

//////////////////////////////////////////////// 2 routers
let routes = [

    { path: '/dashboard', name: 'Dashboard', component: Dashboard },
    { path: '/calendar', name: 'Calendar', component: Calendar },

    ////////////////    
    { path: '/users', name: 'UsersIndex', component:UsersIndex, meta: {mode: 'list'} },
    { path: '/users/create', name: 'UsersEdit', component: UsersEdit, meta: {mode: 'create'} },
    { path: '/users/:id/edit', name: 'UsersEdit', component: UsersEdit, meta: {mode: 'edit'} },
    
    
    { path: '/roles', name: 'RolesIndex', component: RolesIndex, meta: {mode: 'list'} },
    { path: '/roles/create', name: 'RolesEdit', component: RolesEdit, meta: {mode: 'create'} },
    { path: '/roles/:id/edit', name: 'RolesEdit', component: RolesEdit, meta: {mode: 'edit'} },
    { path: '/roles/:id',  name: 'RolesShow', component: RolesShow, meta: {mode: 'view'} },  

    { path: '/tasks', name: 'TasksIndex', component:TasksIndex, meta: {mode: 'list'} },
    { path: '/tasks/create', name: 'TasksEdit', component: TasksEdit, meta: {mode: 'create'} },
    { path: '/tasks/:id/edit', name: 'TasksEdit', component: TasksEdit, meta: {mode: 'edit'} },
    { path: '/tasks/:id',  name: 'TasksShow', component: TasksShow, meta: {mode: 'view'} },  
    
    { path: '/treatments', name: 'TreatmentsIndex', component:TreatmentsIndex, meta: {mode: 'list'} },
    { path: '/treatments/create', name: 'TreatmentsEdit', component: TreatmentsEdit, meta: {mode: 'create'} },
    { path: '/treatments/:id/edit', name: 'TreatmentsEdit', component: TreatmentsEdit, meta: {mode: 'edit'} },
    { path: '/treatments/:id',  name: 'TreatmentsShow', component: TreatmentsShow, meta: {mode: 'view'} },

    { path: '/locations', name: 'LocationsIndex', component:LocationsIndex, meta: {mode: 'list'} },
    { path: '/locations/create', name: 'LocationsEdit', component: LocationsEdit, meta: {mode: 'create'} },
    { path: '/locations/:id/edit', name: 'LocationsEdit', component: LocationsEdit, meta: {mode: 'edit'} },
    { path: '/locations/:id',  name: 'LocationsShow', component: LocationsShow, meta: {mode: 'view'} },

    { path: '/statuses', name: 'StatusesIndex', component:StatusesIndex, meta: {mode: 'list'} },
    { path: '/statuses/create', name: 'StatusesEdit', component: StatusesEdit, meta: {mode: 'create'} },
    { path: '/statuses/:id/edit', name: 'StatusesEdit', component: StatusesEdit, meta: {mode: 'edit'} },
    { path: '/statuses/:id',  name: 'StatusesShow', component: StatusesShow, meta: {mode: 'view'} },

    { path: '/substatuses', name: 'SubStatusesIndex', component:SubStatusesIndex, meta: {mode: 'list'} },
    { path: '/substatuses/create', name: 'SubStatusesEdit', component: SubStatusesEdit, meta: {mode: 'create'} },
    { path: '/substatuses/:id/edit', name: 'SubStatusesEdit', component: SubStatusesEdit, meta: {mode: 'edit'} },
    { path: '/substatuses/:id',  name: 'SubStatusesShow', component: SubStatusesShow, meta: {mode: 'view'} },

    { path: '/clients', name: 'ClientsIndex', component:ClientsIndex, meta: {mode: 'list'} },
    { path: '/clients/create', name: 'ClientsEdit', component: ClientsEdit, meta: {mode: 'create'} },
    { path: '/clients/:id/edit', name: 'ClientsEdit', component: ClientsEdit, meta: {mode: 'edit'} },
  



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
