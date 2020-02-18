<template>
  <div>      
       <AdminCalendar v-if="$role('Admin')" />
       <DeskUserCalendar v-if="$role('Desk User')" />
  </div>

</template>

<script>
import AdminCalendar from './AdminCalendarDD.vue'
//import AdminCalendar from './FullCalendar2.vue'
import DeskUserCalendar from './DeskUserCalendarDD.vue'

export default {
  components: { AdminCalendar,DeskUserCalendar },
  data: function () {
    return {
      
    }
  },
  methods: { 
    callbackFunction() {
      console.log('bla');
  },
  }
}
</script>

<style scoped>
p {
  font-size: 2em;
  text-align: center;
}
</style>