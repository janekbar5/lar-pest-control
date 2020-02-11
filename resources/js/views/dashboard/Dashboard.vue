<template>
<div>
  
   <div>Dashboard</div>

   <!-- <div v-if="$can('role-list')">You can role-list.</div> 
   <div v-if="$role('Admin')">You are admin.</div>
   <div v-if="$role('Desk User')">You are Desk User.</div>
   <div v-if="$role('Field User')">You are Field User.</div>-->

   


   
    



     <!------------------------------------------------------------------------------------------->
    <DashboardFieldUser v-if="$role('Field User')" />
    <DashboardAdmin v-if="$role('Admin')" />





 </div>
</template>

<script>
//import UserCalendar from '../views/calendar/UserCalendar.vue'
import DashboardFieldUser from './DashboardFieldUser.vue'
import DashboardAdmin from './DashboardAdmin.vue'
export default {
  components: { DashboardFieldUser,DashboardAdmin },
  name: 'Dashboard',  
}
</script>