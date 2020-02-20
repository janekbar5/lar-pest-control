/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import moment from 'moment';  //MOMENT JS   

//import { Form, HasError, AlertError } from 'vform';



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


////////////////////////////////////////////////////////////Datepicker
// import { Datetime } from 'vue-datetime'
// // You need a specific loader for CSS files
// import 'vue-datetime/dist/vue-datetime.css' 
// Vue.use(Datetime)
////////////////////////////////////////////////////////////From hello and welcome
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
///////////////////////////////////////////////////////////VueProgressBar hello and welcome
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })
/////////////////////////////////////////////////////////////BootstrapVue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Install BootstrapVue
Vue.use(BootstrapVue)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'



////////////////////////////////////////////////////
import Calendar from './views/calendar/Calendar'
import Dashboard from './views/dashboard/Dashboard.vue'

import UsersIndex from './views/users/UsersIndex'
import UsersEdit from './views/users/UsersEdit'

import RolesIndex from './views/roles/RolesIndex'
import RolesShow from './views/roles/RolesShow'
import RolesEdit from './views/roles/RolesEdit'

import TasksIndex from './views/tasks/TasksIndex'
import TasksHistoryIndex from './views/tasks/TasksHistoryIndex'
import TasksEdit from './views/tasks/TasksEdit'

import UserTasksIndex from './views/usertasks/UserTasksIndex'
import UserTasksEdit from './views/usertasks/UserTasksEdit'
import UserSettings from './views/usertasks/UserSettings'


import TreatmentsIndex from './views/treatments/TreatmentsIndex'
import TreatmentsShow from './views/treatments/TreatmentsShow'
import TreatmentsEdit from './views/treatments/TreatmentsEdit'

import LocationsIndex from './views/locations/LocationsIndex'
import LocationsIndex2 from './views/locations/LocationsIndex2'
import LocationsEdit from './views/locations/LocationsEdit'

import StatusesIndex from './views/statuses/StatusesIndex'
import StatusesShow from './views/statuses/StatusesShow'
import StatusesEdit from './views/statuses/StatusesEdit'

import SubStatusesIndex from './views/substatuses/SubStatusesIndex'
import SubStatusesShow from './views/substatuses/SubStatusesShow'
import SubStatusesEdit from './views/substatuses/SubStatusesEdit'

import ClientsIndex from './views/clients/ClientsIndex'
import ClientsIndex2 from './views/clients/ClientsIndex2'
import ClientsEdit from './views/clients/ClientsEdit'

import HistoryIndex from './views/history/HistoryIndex'
import GlobalSettingsIndex from './views/globalsettings/GlobalSettingsIndex'

import FiltersIndex from './views/filters/FiltersIndex'

//////////////////////////////////////////////// 2 routers
let routes = [

    { path: '/dashboard', name: 'Dashboard', component: Dashboard },
    { path: '/calendar', name: 'Calendar', component: Calendar },
    { path: '/globalsettings', name: 'GlobalSettingsIndex', component:GlobalSettingsIndex, meta: {mode: 'list'} },

    ////////////////    
    { path: '/users', name: 'UsersIndex', component:UsersIndex, meta: {mode: 'list'} },
    { path: '/users/create', name: 'UsersEdit', component: UsersEdit, meta: {mode: 'create'} },
    { path: '/users/:id/edit', name: 'UsersEdit', component: UsersEdit, meta: {mode: 'edit'} },
    
    
    { path: '/roles', name: 'RolesIndex', component: RolesIndex, meta: {mode: 'list'} },
    { path: '/roles/create', name: 'RolesEdit', component: RolesEdit, meta: {mode: 'create'} },
    { path: '/roles/:id/edit', name: 'RolesEdit', component: RolesEdit, meta: {mode: 'edit'} },
    { path: '/roles/:id',  name: 'RolesShow', component: RolesShow, meta: {mode: 'view'} },  

    { path: '/tasks', name: 'TasksIndex', component:TasksIndex, meta: {mode: 'list'} },
    { path: '/taskshistory', name: 'TasksHistoryIndex', component:TasksHistoryIndex },
    
    { path: '/tasks/create', name: 'TasksEdit', component: TasksEdit, meta: {mode: 'create'} },
    { path: '/tasks/:id/edit', name: 'TasksEdit', component: TasksEdit, meta: {mode: 'edit'} },
     
    { path: '/usertasks', name: 'UserTasksIndex', component:UserTasksIndex, meta: {mode: 'list'} },    
    { path: '/usertasks/:id/edit', name: 'UserTasksEdit', component: UserTasksEdit, meta: {mode: 'edit'} },
    { path: '/usersettings', name: 'UserSettings', component:UserSettings },

    
     
    
    { path: '/treatments', name: 'TreatmentsIndex', component:TreatmentsIndex, meta: {mode: 'list'} },
    { path: '/treatments/create', name: 'TreatmentsEdit', component: TreatmentsEdit, meta: {mode: 'create'} },
    { path: '/treatments/:id/edit', name: 'TreatmentsEdit', component: TreatmentsEdit, meta: {mode: 'edit'} },
    { path: '/treatments/:id',  name: 'TreatmentsShow', component: TreatmentsShow, meta: {mode: 'view'} },

    //{ path: '/locations', name: 'LocationsIndex', component:LocationsIndex, meta: {mode: 'list'} },
    { path: '/locations', name: 'LocationsIndex2', component:LocationsIndex2, },
    { path: '/locations/create', name: 'LocationsEdit', component: LocationsEdit, meta: {mode: 'create'} },
    { path: '/locations/:id/edit', name: 'LocationsEdit', component: LocationsEdit, meta: {mode: 'edit'} },
    //{ path: '/locations/:id',  name: 'LocationsShow', component: LocationsShow, meta: {mode: 'view'} },

    { path: '/statuses', name: 'StatusesIndex', component:StatusesIndex, meta: {mode: 'list'} },
    { path: '/statuses/create', name: 'StatusesEdit', component: StatusesEdit, meta: {mode: 'create'} },
    { path: '/statuses/:id/edit', name: 'StatusesEdit', component: StatusesEdit, meta: {mode: 'edit'} },
    { path: '/statuses/:id',  name: 'StatusesShow', component: StatusesShow, meta: {mode: 'view'} },

    { path: '/substatuses', name: 'SubStatusesIndex', component:SubStatusesIndex, meta: {mode: 'list'} },
    { path: '/substatuses/create', name: 'SubStatusesEdit', component: SubStatusesEdit, meta: {mode: 'create'} },
    { path: '/substatuses/:id/edit', name: 'SubStatusesEdit', component: SubStatusesEdit, meta: {mode: 'edit'} },
    { path: '/substatuses/:id',  name: 'SubStatusesShow', component: SubStatusesShow, meta: {mode: 'view'} },

    //{ path: '/clients', name: 'ClientsIndex', component:ClientsIndex, meta: {mode: 'list'} },
    { path: '/clients', name: 'ClientsIndex2', component:ClientsIndex2, meta: {mode: 'list'} },
    { path: '/clients/create', name: 'ClientsEdit', component: ClientsEdit, meta: {mode: 'create'} },
    { path: '/clients/:id/edit', name: 'ClientsEdit', component: ClientsEdit, meta: {mode: 'edit'} },

    { path: '/history', name: 'HistoryIndex', component: HistoryIndex, meta: {mode: 'list'} },  

    { path: '/filters', name: 'FiltersIndex', component: FiltersIndex, meta: {mode: 'list'} },  
  
    



    ]

///////////////////////////////////////////////////////5 filters
Vue.filter('formatDate', function(value) {
    if (value) {
      return moment(String(value)).format('hh:mm')
    }
});
Vue.filter('formatDayOnly', function(value) {
    if (value) {
      return moment(String(value)).format('YYYY-MM-DD')
    }
});
Vue.filter('formatDateNoSeconds', function(value) {
    if (value) {
      return moment(String(value)).format('YYYY-MM-DD hh:mm')
    }
});
////////////////////////////////////////////////3 define router
const router = new VueRouter({    
    mode: 'history',
    routes
});
import { Typeahead2 } from './components/typeahead'

const app = new Vue({
    el: '#app',
    components: { Typeahead2 },
    data: function () {
        return {        
          form:'',
          customerURL: '/v1/api/home/searchbox',                
        }
      }, 
    ////
    methods: {
        onCustomer(e) { 
            var id = e.target.value.searchable.id    
            var model = e.target.value.type  
           // console.log(e.target.value)   
           this.$router.push('/'+model+'/'+id+'/edit')    
        },
    },  
    //
    router,
});
global.vm = app;