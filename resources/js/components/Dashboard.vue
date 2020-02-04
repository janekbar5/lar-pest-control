<template>
<div>
  
   <div>Dashboard</div>

   <div v-if="$can('role-list')">You can role-list.</div>
   <div v-if="$role('Admin')">You are admin.</div>
   <div v-if="$role('Desk User')">You are Desk User.</div>
   <div v-if="$role('Field User')">You are Field User.</div>

    <UserCalendar v-if="$role('Field User')" />


 </div>
</template>

<script>
import UserCalendar from '../views/calendar/UserCalendar.vue'
export default {
  components: { UserCalendar },
  name: 'Dashboard',  
}
</script>