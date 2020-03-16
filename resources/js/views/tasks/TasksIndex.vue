<template>
    <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <Buttons :editMode="editMode" :model="model"></Buttons>
                    </div>
                </div>
            </div>           


            <vue-bootstrap4-table 
            :rows="rows"        
            :columns="columns"
            :config="config"
            @on-change-query="onChangeQuery"
            :total-rows="total_rows"                     
            >
            <!-- :actions="actions" -->
            <!-- @on-download="newRecord" -->
            <template slot="table-column" slot-scope="props">
                <span>
                    <i class="fa fa-address-book"></i> {{props.column.label}}
                </span>           
                {{props.column.label}}            
            </template>

          <template slot="photos" slot-scope="props">  
           <img v-if="props.row.photos[0] == null" src="https://dummyimage.com/50x40/807c80/fff" style="width:50px;height:40px">
           <img v-else :src="'images/thumb_medium-' + props.row.photos[0].path" style="width:50px;height:40px" /> 
         </template> 

          <template slot="locations" slot-scope="props">          
           {{ props.row.locations.title_t }}        
         </template>

         <template slot="statuses" slot-scope="props"> 
           <small class="badge" v-bind:style="{ 'background-color': props.row.statuses.colour }"><i class="fa fa-clock"></i> {{props.row.statuses.title}}</small>     
         </template> 

          <template slot="users" slot-scope="props">     
            <div v-if="props.row.users.length > 0" >            
            <small v-for="user in props.row.users" :key="user.data" class="badge badge-danger"><i class="fa fa-user"></i> {{user.name}} {{user.last_name}}</small>   
           </div>  
           <div v-else ></div>     
         </template> 

        <template slot="actions" slot-scope="props"> 
            <i aria-hidden="true" class="fa fa-pen" @click="editRecord(props.cell_value)"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
            <i aria-hidden="true" class="fa fa-trash" @click="deleteRecord(props.cell_value)"></i>     
       </template>       


        </vue-bootstrap4-table>


        <RecordsRepository ref="RecordsRepo" > </RecordsRepository>
    </div>
</template>

<script>
    import VueBootstrap4Table from 'vue-bootstrap4-table'
    import RecordsRepository from "../../repositories/RecordsRepository.vue"
    import Buttons from '../../components/buttons/Buttons'
    export default {
        name: 'App',
        components: { VueBootstrap4Table,Buttons,RecordsRepository },
        data: function() {
            return {
                model:'tasks',
                editMode: this.$route.meta.mode,
                rows: [],
                columns: [
                     {label: "Id",name: "id",filter: {},sort: true,column_classes: "task_id",initial_sort: true, initial_sort_order: "asc" }, 
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
                config: { server_mode: true,show_reset_button: false,show_refresh_button: false,global_search: {visibility: false,},per_page: 20,per_page_options: [20, 40, 60, 80], },
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
            newRecord() {        
                this.$router.push(this.model+'/create')
            },
            editRecord(id) {        
                this.$router.push(this.model+'/'+id+'/edit')
            },
            deleteRecord(id) {
                this.$refs.RecordsRepo.deleteRecord(this.model,id) 
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

                const { data } = await this.$refs.RecordsRepo.sortFilter(this.model,this.querySorting+'&'+queryPer+'&'+page+'&'+filterParams.join('&')); 
                self.rows = data.rows.data;
                this.$Progress.finish()
                self.total_rows = data.rows.total;      
            }

        }//meth
        
    }
</script>

<style>
.task_id{
    width:5%
}
</style>