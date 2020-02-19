<template>
  <div>

    
    <router-link :to="{path: this.urlCreate}" class="btn btn-secondary"> New Location </router-link>
    <vue-good-table
      :columns="columns"
      :rows="rows"
      :sort-options="{
        enabled: true,
        initialSortBy: [
        //{field: 'person_name', type: 'asc'},
       // {field: 'id', type: 'asc'},
        {field: 'id', type: 'asc'},
        //{field: 'active', type: 'desc'},        
        ],
      }"
      :pagination-options="{
            enabled: true,
            mode: 'records',
            perPage: 20,
            position: 'top',
            perPageDropdown: [40, 60, 80],
            dropdownAllowAll: false,
            setCurrentPage: 1,
            nextLabel: 'next',
            prevLabel: 'prev',
            rowsPerPageLabel: 'Rows per page',
            ofLabel: 'of',
            pageLabel: 'page', // for 'pages' mode
            allLabel: 'All',
        }"        
      >
        <template slot="table-row" slot-scope="props">

                <span v-if="props.column.field == 'action_buttons'">               
                 <i aria-hidden="true" class="fa fa-pen" @click="recordEdit(props.row.id)"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                 <i aria-hidden="true" class="fa fa-trash" v-if="$can('location-delete')" @click="recordDelete(props.row.id)"></i>  
                </span>

                <span v-else-if="props.column.field == 'client'">
                    <span  v-for="client in props.row.clients" :key="client.data">{{ client.person_name }}</span>                  
                </span>

                
                <span v-else>
                {{props.formattedRow[props.column.field]}}
                </span>
        </template>

      </vue-good-table>



  </div>
</template>

<script>
import 'vue-good-table/dist/vue-good-table.css'
import { VueGoodTable } from 'vue-good-table';



export default {
    // add to component
components: {VueGoodTable},
  name: 'my-component',
  data(){
    return {
      columns: [
        {
        label: 'Id',
        field: 'id',
        type: 'number',        
        }, 

        { 
            label: 'Location',
            field: 'title',
            filterOptions: {
            enabled: true, // enable filter for this column
            placeholder: 'Location...', // placeholder for filter input
            filterValue: '', // initial populated value for this filter
            filterDropdownItems:'',  
            //filterFn: this.columnFilterFn, //custom filter function that
            trigger: '', //only trigger on enter not on keyup 
            },
        },
       
         /////////////////////////////////for slots     
       /* {
        label: 'Client',
        field: 'Client',
        sortable: true,
        },*/

        { 
        label: 'Client',
        field: 'id',
        filterOptions: {
          enabled: true, // enable filter for this column
          placeholder: 'Filter This Thing', // placeholder for filter input
          filterValue: 'Jane', // initial populated value for this filter
          filterDropdownItems: [], // dropdown (with selected values) instead of text input
          filterFn: this.columnFilterClient, //custom filter function that
          trigger: 'enter', //only trigger on enter not on keyup 
        },
      },
        
       /*{
          label: 'Address',
          field: 'address',
          filterOptions: {
            enabled: true, // enable filter for this column
            placeholder: 'Reccurence...', // placeholder for filter input
            filterValue: '', // initial populated value for this filter
            filterDropdownItems:'',  
            //filterFn: this.columnFilterFn, //custom filter function that
            trigger: '', //only trigger on enter not on keyup 
          },
          sortable: true,
          sortFn: this.sortFn,
          formatFn: this.formatAddress,
        },  */
       /* { 
            label: 'VAT no.',
            field: 'vat_number',
            filterOptions: {
            enabled: true, // enable filter for this column
            placeholder: 'VAT no...', // placeholder for filter input
            filterValue: '', // initial populated value for this filter
            filterDropdownItems:'',  
            //filterFn: this.columnFilterFn, //custom filter function that
            trigger: '', //only trigger on enter not on keyup 
            },
            //width: '150px',
        },*/
        
        
       /* { 
            label: 'Reccurence',
            field: 'reccurence',
            filterOptions: {
            enabled: true, // enable filter for this column
            placeholder: 'Reccurence...', // placeholder for filter input
            filterValue: '', // initial populated value for this filter
            filterDropdownItems:'',  
            //filterFn: this.columnFilterFn, //custom filter function that
            trigger: '', //only trigger on enter not on keyup 
            },
            //width: '150px',
        },*/
        /*{
          label: 'Active',
          field: 'active',
          filterOptions: {
            enabled: true, // enable filter for this column
            placeholder: 'Reccurence...', // placeholder for filter input
            filterValue: '', // initial populated value for this filter
            filterDropdownItems: [  
              { value: 1, text: 'Active' },  
              { value: 0, text: 'Inactive' },  
               
            ],  
            //filterFn: this.columnFilterFn, //custom filter function that
            trigger: '', //only trigger on enter not on keyup 
          },
          sortable: true,
          sortFn: this.sortFn,
          formatFn: this.formatFn,
        },   */
        {
        label: 'Action',
        field: 'action_buttons',
        sortable: false,
        },
        
        
      ],
      rows: [
        // { id:1, name:"John", age: 20, createdAt: '',score: 0.03343 },
        // { id:2, name:"Jane", age: 24, createdAt: '2011-10-31', score: 0.03343 },
        // { id:3, name:"Susan", age: 16, createdAt: '2011-10-30', score: 0.03343 },
        // { id:4, name:"Chris", age: 55, createdAt: '2011-10-11', score: 0.03343 },
        // { id:5, name:"Dan", age: 40, createdAt: '2011-10-21', score: 0.03343 },
        // { id:6, name:"John", age: 20, createdAt: '2011-10-31', score: 0.03343 },
      ],
    ///////////
      modelPlural: 'locations', modelSingular: 'Location', 
        urlList:'/locations',
        urlCreate:'/locations/create',
        urlEdit:'/locations/',
        apiList:'/v1/api/locations/index',
        apiCreate:'/v1/api/locations/create',
        apiEdit:'/v1/api/locations/edit/',       
        apiUpdate:'/v1/api/locations/update/',     
        apiDelete:'/v1/api/locations/delete/',
    }
        
  },//data
created() {
    this.$eventHub.$on('settings', this.modelSettings) 
},
beforeDestroy(){
    this.$eventHub.$off('settings');
},
 mounted() {            
   this.fetchData()       
 },
  methods: {
    /*columnFilterClient(data, filterString){
      return data+filterString;
    },*/
    columnFilterClient: function(data, filterString) {
      var x = parseInt(filterString)
      return 'ggg';
    },
    sortFn(x, y, col, rowX, rowY) {
      // x - row1 value for column
      // y - row2 value for column
      // col - column being sorted
      // rowX - row object for row1
      // rowY - row object for row2
      return (x < y ? -1 : (x > y ? 1 : 0))
      
    },
    formatAddress: function(value) {
      return value.address_line1+''+value.address_line2;
    },     
    onChangeQuery(queryParams) {
        this.queryParams = queryParams;
        console.log(this.queryParams.filters)
        this.fetchData();
    },
    fetchData() {
        let self = this;
        axios.get(this.apiList)
            .then((res) => {                        
            this.setData(res) 
        })                    
    },
    setData(res) { 
        this.rows = res.data.rows       
    }, 
    newRecord(){
       this.$router.push(this.urlCreate) 
    },
   
    recordEdit(item) {        
        this.$router.push(this.urlList+'/'+item+'/edit')
    },  

    }//met

}
</script>
<style>
.vgt-table.bordered td, .vgt-table.bordered th {
    border: 0px solid #dcdfe6;
}

 table.vgt-table td {
    padding: .75em .75em .75em .75em;
    vertical-align: top;
    border-bottom: 1px solid #dcdfe6;
    color: #000000;
}
table.vgt-table {
    font-size: 14px;
    border-collapse: collapse;
}
</style>