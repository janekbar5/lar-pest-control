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
             <!-- :actions="actions"
            @on-download="newRecord" -->

         <template slot="column_reccurence_id_n" slot-scope="props">            
                {{props.column.label}}            
        </template>   
                              
          <template slot="photos" slot-scope="props">  
           <img v-if="props.row.photos[0] == null" src="https://dummyimage.com/50x40/807c80/fff" style="width:50px;height:40px">
           <img v-else :src="'images/thumb_medium-' + props.row.photos[0].path" style="width:50px;height:40px" /> 
         </template> 

          <template slot="clienttypes" slot-scope="props">          
           {{ props.row.client_type_n == 1 ? 'Private' : 'Company' }}        
         </template>

         <template slot="reccurences" slot-scope="props"> 
           <small class="badge"><i class="fa fa-clock"></i> {{props.row.reccurences.title}}</small>     
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
        components: { VueBootstrap4Table, RecordsRepository, Buttons },
        data() {
            return {
                model:'users',   
                editMode: this.$route.meta.mode, 
                rows: [],
                columns: [
                     {label: "Id",name: "id",filter: {},sort: true,column_classes: "user_id",initial_sort: true, initial_sort_order: "asc" },
                     {label: "Photo",name: "id",slot_name: "photos"},                      
                     //Own Text                     
                     {label: "Name",name: "name_t",filter: {type: "simple",placeholder: "Name",},sort: true,column_classes: "user_name"}, 
                     {label: "Surname",name: "last_name_t",filter: {type: "simple",placeholder: "Surname",},sort: true,column_classes: "user_name"},   
                     {label: "Email",name: "email",filter: {type: "simple",placeholder: "Email",},sort: true },  
                     {label: "Private Phone",name: "personal_phone_t",filter: {type: "simple",placeholder: "Private Phone",},sort: true,column_classes: "user_phone" },
                     {label: "Work Phone",name: "work_phone_t",filter: {type: "simple",placeholder: "Work Phone",},sort: true,column_classes: "user_phone" },
                     {label: "Leave Days",name: "leaves_day_n",filter: {type: "simple",placeholder: "Leave Days",},sort: true },               
                                     
                     //Own Number                   
                       
                    //{label: "Reccurences",name: "reccurence_id_n",slot_name: "reccurences", 
                    //filter: {type: "select",mode: "single",closeDropdownOnSelection: true,placeholder: "Reccurence",options: []},sort: true,column_classes: "reccurence_id" },   

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
            // let self = this;
            // axios.get('/v1/api/reccurences/index').then((res) => {
            //     let listesColumn = 9
            //     self.columns[listesColumn].filter.options = res.data.reccurences                
            // })          
        },
        methods: {             
            newRecord() {        
                this.$router.push(this.model+'/create')
            },
            editRecord(id) {        
                this.$router.push(this.model+'/'+id+'/edit')
            },
            deleteRecord(id) {
                this.$refs.RecordsRepo.deleteRecord(this.model,this.serverParams, this.queryParams,id) 
            }, 
            ////////////////////////////////////////////////////////////////////////////////////////////////////////TABLE            
            onChangeQuery(queryParams) {
                this.queryParams = queryParams                                   
                this.$refs.RecordsRepo.fetchData(this.model,this.serverParams, this.queryParams);                   
            }           

        }//meth
        
    }
</script>

<style>
.user_id{
    width:5%;     
}
.user_name{
    width:15%;       
}
.user_phone{
    width:10%;   
}
.user_id{
   width:10%; 
}
</style>