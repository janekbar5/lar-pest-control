<template>
  <div>
    <!-- <table-component
     :data="data"
     sort-by="songs"
     sort-order="asc"
     >

     <table-column show="firstName" label="First name"></table-column>
     <table-column show="songs" label="Songs" data-type="numeric"></table-column>
     <table-column show="birthday" label="Birthday" :filterable="false" data-type="date:DD/MM/YYYY"></table-column>


 </table-component> -->

 <table-component
    :data="data">
    <table-column show="firstName" label="First name"></table-column>
    <table-column show="songs" label="Songs" data-type="numeric"></table-column>
    <template slot="tfoot" slot-scope="{ rows }">
        <tr>
            <th>Total Songs:</th>
            <th>{{ rows.reduce((sum, value) => { return sum + value.data.songs; }, 0) }}</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
    </template>
</table-component>

  </div>
</template>

<script>
import TableComponent from 'vue-table-component';
import Vue from 'vue'
Vue.use(TableComponent);

export default {
     data: function () {   
        return {         
                data: [],
                
        }       
  },

      mounted() {                
        this.data = [
        { firstName: 'John', birthday: '04/10/1940', songs: 72 },
        { firstName: 'Paul', birthday: '18/06/1942', songs: 70 },
        { firstName: 'George', birthday: '25/02/1943', songs: 22 },
        { firstName: 'Ringo', birthday: '07/07/1940', songs: 2 },
        ]  
      },
                    
    methods: {
            
    }
}
    
</script>