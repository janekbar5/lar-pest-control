<template>
    <div id="app">
            <vue-bootstrap4-table 
            :rows="rows"        
            :columns="columns"
            :config="config"
            @on-change-query="onChangeQuery"
            :total-rows="total_rows"
            :actions="actions"
            @on-download="newRecord"
            >
                              
          <template slot="photos" slot-scope="props">  
           <img v-if="props.row.photos[0] == null" src="https://dummyimage.com/50x40/807c80/fff" style="width:50px;height:40px">
           <img v-else :src="'images/thumb_medium-' + props.row.photos[0].path" style="width:50px;height:40px" /> 
         </template> 

          <template slot="locations" slot-scope="props">          
           {{ props.row.locations.title }}        
         </template>

         <template slot="statuses" slot-scope="props"> 
           <small class="badge" v-bind:style="{ 'background-color': props.row.statuses.colour }"><i class="fa fa-clock"></i> {{props.row.statuses.title}}</small>     
         </template> 

          <template slot="users" slot-scope="props">  
              
              <!-- {{ props.row.users.length > 0 ? '' :'' }}  -->
            <div v-if="props.row.users.length > 0" >            
            <small v-for="user in props.row.users" :key="user.data" class="badge badge-danger"><i class="fa fa-user"></i> {{user.name}}</small>   
           </div>  
           <div v-else ></div>     
         </template> 

        <template slot="actions" slot-scope="props"> 
            <i aria-hidden="true" class="fa fa-pen" @click="editRecord(props.cell_value)"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
            <i aria-hidden="true" class="fa fa-trash" @click="deleteRecord(props.cell_value)"></i>     
       </template>       


        </vue-bootstrap4-table>
    </div>
</template>

<script>
    import VueBootstrap4Table from 'vue-bootstrap4-table'
    import Repository from "../../repositories/RepositoryFactory";
    const RecordsRepository = Repository.get("records");
    export default {
        name: 'App',
        components: { VueBootstrap4Table },
        data: function() {
            return {
                model:'tasks',
                rows: [],
                columns: [
                     {label: "Id",name: "id",filter: {},sort: true,column_classes: "my_id",initial_sort: true, initial_sort_order: "asc" }, 
                     {label: "Photo",name: "id",slot_name: "photos"}, 
                     //Own Text                     
                     {label: "Title",name: "title_t",filter: {type: "simple",placeholder: "Title",},sort: true },   
                     {label: "Location",name: "location_id",slot_name: "locations",filter: {type: "simple",placeholder: "Location"},sort: true},                   
                     {label: "Start",name: "start_t",filter: {type: "simple",placeholder: "Start"},sort: true },
                     {label: "End",name: "end_t",filter: {type: "simple",placeholder: "End"},sort: true },
                     //Own Number
                     {label: "Price",name: "price_n",filter: {type: "simple",placeholder: "Price"},sort: true },
                     {label: "Status",name: "status_id_n",slot_name: "statuses", filter: {type: "select", mode: "single",closeDropdownOnSelection: true,placeholder: "Status",options: [
                        {"name": "All","value": null},
                        {"name": "New","value": 1},
                        {"name": "Done","value": 2},
                        {"name": "Not Done","value": 3},
                     ],
                     //init: {value : 2}
                     },sort: true },    
                     {label: "User",name: "id",slot_name: "users"}, 
                     {label: "Actions",name: "id",slot_name: "actions"},              
                ],
                actions: [ { btn_text: "New Task", event_name: "on-download",class: "btn btn-secondary",event_payload: { msg: "my custom msg" } } ],
                config: { server_mode: true,show_reset_button: true,show_refresh_button: false,global_search: {visibility: false,},per_page: 20,per_page_options: [20, 40, 60, 80], },
                queryParams: {sort: [],filters: [],global_search: "",per_page: 20,page: 1,},
                total_rows: 0,
                //////
                serverParams:[],querySorting:[],queryFilters:[]
            }
        },       
        mounted() {
            this.fetchData();
        },
        methods: {            
            loadStatuses(props){
               //return props.row.statuses.title      
               //return '<span class="badge badge-info right">2</span>'         
            },
            newRecord() {        
                this.$router.push(this.model+'/create')
            },
            editRecord(id) {        
                this.$router.push(this.model+'/'+id+'/edit')
            },
            deleteRecord(id){
            swal.fire({title: 'Are you sure?',text: "You won't be able to revert this!",type: 'warning',showCancelButton: true,
            confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            // Send request to the server
            if (result.value) {
                RecordsRepository.delete(this.model,id).then(()=>{
                swal.fire('Deleted!','Your file has been deleted.','success')
                this.fetchData()                                         
            }).catch(()=> {
                swal.fire("Failed!", "There was something wronge.", "warning");
                });
            }
            })
        
            },

            ////////////////////////////////////////////////////////////////////////////////////////////////////////TABLE
            
            onChangeQuery(queryParams) {
                this.queryParams = queryParams                                   
                this.fetchData();                   
            },
            fetchData: async function() {
                let self = this;
                this.$Progress.start()
                this.serverParams = Object.assign({}, this.serverParams, this.queryParams) 
                //console.log(this.serverParams)                        
                //sorting params   
                var params = { field: this.serverParams.sort[0].name,order: this.serverParams.sort[0].order }                       
                this.querySorting = Object.keys(params).map(key => key + '=' + params[key]).join('&')
                // filter params
                var filterParams = []
                this.serverParams.filters.forEach(element => {                   
                    if(element.type==='simple'){
                    filterParams.push(element.name+'='+ element.text)
                    }else{
                    filterParams.push(element.name+'='+ element.selected_options)    
                    }                   
                });
                //per page
                var perpage = { perPage: this.serverParams.per_page };
                var queryPer = Object.keys(perpage).map(key => key + '=' + perpage[key]).join('&'); 
                //which page
                var pageparams = { page: this.serverParams.page };
                var page = Object.keys(pageparams).map(key => key + '=' + pageparams[key]).join('&'); 

                const { data } = await RecordsRepository.sortFilter(this.model,this.querySorting+'&'+queryPer+'&'+page+'&'+filterParams.join('&')); 
                self.rows = data.rows.data;
                this.$Progress.finish()
                self.total_rows = data.rows.total;      
            }

        }//meth
        
    }
</script>

<style>
.my_id{
    width:5%
}

.table-active .form-control{
display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    padding-right: 0.75rem;
    font-size: 0.8rem;
    font-weight: 200;
    line-height: 1.2;
    color: #495057;
    background-color:#fff;
    background-clip: padding-box;
    border: 1px solid  #ced4da;
    border-radius: 0.25rem;
    -webkit-transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.table{
    font-size:14px;
}
.table th, .table td {
    padding: 0rem;
    vertical-align: top;
    border-top: 1px solid 
    #dee2e6;
}
.table th, .table td {
    padding: 0rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.table th, .table td {
    padding: 0.5rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.text-center {
    text-align: center !important;
}
</style>