<template>
  <div>
 
    <vue-good-table
       
    mode="remote"
    @on-page-change="onPageChange"
    @on-sort-change="onSortChange"
    @on-column-filter="onColumnFilter"
    @on-per-page-change="onPerPageChange"
    :totalRows="totalRecords"
    :isLoading.sync="isLoading"    
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
    :sort-options="{enabled: true,initialSortBy: {field: 'id', type: 'asc'} }"
    styleClass="vgt-table striped"                
    :rows="rows"
    :columns="columns">
   <div slot="table-actions">
    <router-link :to="{path: this.model+'/create'}" class="btn btn-secondary"> Create new {{ model }}</router-link>
  </div>
   <template slot="table-row" slot-scope="props">
      <span v-if="props.column.field == 'action_buttons2'">               
       fff
      </span>               
    </template>
    <template slot="table-row" slot-scope="props">
      <span v-if="props.column.field == 'action_buttons'">               
        <i aria-hidden="true" class="fa fa-pen" @click="editRecord(props.row.id)"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
        <i aria-hidden="true" class="fa fa-trash" @click="deleteRecord2(props.row.id)"></i>  
      </span>               
    </template>

  </vue-good-table> 


  </div>
</template>


<script>
import Repository from "../../repositories/RepositoryFactory";
const RecordsRepository = Repository.get("records");

import 'vue-good-table/dist/vue-good-table.css'
import { VueGoodTable } from 'vue-good-table';

export default {
  name: "Clients",
  components: { VueGoodTable },
  data() {
    return {
      posts: [],
      model:'clients',
      //////////////////////
        isLoading: false,
        columns: [
        {label: 'Id',field: 'id',width:'5%',filterOptions: {enabled: false} },
      //   { 
      //   label: 'State',
      //   field: 'active',
      //   //field: this.getActive,
      //   width: '10%',
      //   filterOptions: {
      //     enabled: true, // enable filter for this column
      //     placeholder: 'State', // placeholder for filter input
      //     filterValue: '', // initial populated value for this filter
      //     filterDropdownItems: [], // dropdown (with selected values) instead of text input
      //     filterMultiselectDropdownItems: [], // dropdown (with multiple selected values) instead of text input
      //     filterDropdownItems: [ { value: '1', text: 'Inactive' },  { value: '2', text: 'Active' } ],
      //     filterFn: this.columnFilterFn, //custom filter function that
      //     trigger: '', //only trigger on enter not on keyup 
      //   },
      // },

        {label: 'Active / Inactive',field: 'active' ,width: '10%',sortable: true,filterOptions: {enabled: true, filterFn: '',
        filterDropdownItems: [ { value: '1', text: 'Inactive' },  { value: '2', text: 'Active' },],
         },         
        },       
        //{label: 'Photos',field: this.getPhotos,html: true,sortable: false},
        {label: 'Name',field: 'name',width: '20%',filterOptions: {enabled: true, filterFn: this.onColumnFilter } },
        {label: 'Email',field: 'email',filterOptions: {enabled: true, filterFn: this.onColumnFilter} },
        {label: 'Phone',field: 'phone',width: '15%',filterOptions: {enabled: true, filterFn: this.onColumnFilter } }, 
        {label: 'Contract Nr',field: 'contract_number',width: '10%',filterOptions: {enabled: true} },
        {label: 'VAT Nr',field: 'vat_number',filterOptions: {enabled: true} },
        {label: 'Start',field: 'contract_start',width: '10%',filterOptions: {enabled: true} },
        {label: 'End',field: 'contract_end',width: '10%',filterOptions: {enabled: true} },
        //
        
        //{label: 'Price',field: 'price',filterOptions: {enabled: true, filterFn: this.onColumnFilter } },
        //{label: 'Start',field: 'start',width: '20%',filterOptions: {enabled: true, filterFn: this.onColumnFilter } }, 
        {label: 'Action',field: 'action_buttons',sortable: false },  

        ],
        rows: [],
        totalRecords: 0,
        serverParams: {columnFilters: {}, sort: {field: 'id',type: 'asc', },
            page: 1, 
            perPage: 20,            
        },
    };
  },
  created() {
    //this.loadItems();
  },
  methods: {
    columnFilterFn: function(data, filterString) {
      var x = parseInt(filterString)
      return data >= x - 5 && data <= x + 5;
    },
    getActive(rowObj){
      return rowObj.active == 0 ? 'Inactive' : 'Active'     
    },
    getPhotos(rowObj) {
      return rowObj.photos[0] == null ? '<img src="https://dummyimage.com/60x50/807c80/fff" style="width:60px;height:50px">' : '<img v-else src=images/thumb_medium-' + rowObj.photos[0].path+' style="width:60px;height:50px" />'       
    },    
    editRecord(item) {        
        this.$router.push(this.model+'/'+item+'/edit')
    },
    getRecords: async function() {
      const { data } = await RecordsRepository.index(this.model);
      this.posts = data.results;
      console.log( this.posts)
    },
    getRecords2() {
      const { data } = RecordsRepository.index(this.model);
      this.rows = data.results;
    },
    deleteRecord: async function(id) {
      const { data } = await RecordsRepository.delete(this.model,id);     
      if(data.deleted) {
        swal.fire('Deleted!','Your file has been deleted.','success')
        this.sortFilter();
      }else{
        console.log('not')
      }
    },
   deleteRecord2(id){
        swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        // Send request to the server
        if (result.value) {
            RecordsRepository.delete(this.model,id).then(()=>{
            swal.fire('Deleted!','Your file has been deleted.','success')
            this.sortFilter()                                         
        }).catch(()=> {
            swal.fire("Failed!", "There was something wronge.", "warning");
            });
        }
        })
    
    },
    //////////////////////////////////////////////////////////////////////
    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },    
    onPageChange(params) {/////////////////////////////////////////////Pages
      this.updateParams({page: params.currentPage}); 
      this.sortFilter();
    },
    onPerPageChange(params) {////////////////////////////////////////Pagination
      this.updateParams({perPage: params.currentPerPage});        
      this.sortFilter();
    },
    onSortChange(params) {/////////////////////////////////////////////Sort   
      this.updateParams({
        sort: [{       
        type: params[0].type,
        field: params[0].field,
        }],
      });
      this.sortFilter();
    },    
    onColumnFilter(params) {/////////////////////////////////////////////Filter   
      this.updateParams(params);
      this.sortFilter();
    },


    sortFilter: async function() {  
         console.log(this.serverParams)     
         //sorting params
         var params = { field: this.serverParams.sort[0].field,sort: this.serverParams.sort[0].type };
         var querySorting = Object.keys(params).map(key => key + '=' + params[key]).join('&');
         // filter params
         var queryFilters = Object.keys(this.serverParams.columnFilters).map(key => key + '=' + this.serverParams.columnFilters[key]).join('&'); 
         //per page
         var params2 = { perPage: this.serverParams.perPage };
         var queryPer = Object.keys(params2).map(key => key + '=' + params2[key]).join('&');
        //which page
        var params3 = { page: this.serverParams.page };
        var page = Object.keys(params3).map(key => key + '=' + params3[key]).join('&');        
        //
         const { data } = await RecordsRepository.sortFilter(this.model,querySorting+'&'+queryFilters+'&'+queryPer+'&'+page);     
         this.totalRecords = data.results.total;
         this.rows = data.results.data;         
      
    },

  }
};
</script>
<style>
.fa-trash:hover,.fa-pen:hover {
    color: red;
    cursor:pointer;
}
.table-active {
    background-color:white;    
}
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