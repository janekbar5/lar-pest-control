<template>
  <div>      
       <AdminCalendar v-if="$role('Admin')" />
  </div>

</template>

<script>
import AdminCalendar from './AdminCalendar.vue'
//import AdminCalendar from './FullCalendar2.vue'

export default {
  components: { AdminCalendar },
  data: function () {
    return {
      
    }
  }
}
</script>

<style scoped>
p {
  font-size: 2em;
  text-align: center;
}
</style>