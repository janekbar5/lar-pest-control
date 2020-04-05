<template>
    <div >

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
                              
          <template slot="photos" slot-scope="props">  
           <img v-if="props.row.photos[0] == null" src="https://dummyimage.com/50x40/807c80/fff" style="width:50px;height:40px">
           <img v-else :src="'images/thumb_medium-' + props.row.photos[0].path" style="width:50px;height:40px" /> 
         </template> 

          <template slot="clienttypes" slot-scope="props">          
           {{ props.row.client_type_n == 1 ? 'Private' : 'Company' }}        
         </template>

        <template slot="clients" slot-scope="props">     
            <div v-if="props.row.clients.length > 0" >            
            <small v-for="client in props.row.clients" :key="client.data" class="badge badge-danger"><i class="fa fa-user"></i> {{client.name_t}} </small>   
           </div>  
           <div v-else ></div>     
         </template> 

         <template slot="cities" slot-scope="props">     
            <p v-if="props.row.address != null">{{ props.row.address.city }}</p>
            <p v-else >cc</p>
         </template> 

         <template slot="postcodes" slot-scope="props">     
            <p v-if="props.row.address != null">{{ props.row.address.postcode }}</p>
            <p v-else >cc</p>
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
    import RecordsRepository from "../../repositories/RecordsRepository.vue";  
    import Buttons from '../../components/buttons/Buttons'
    export default {
        name: 'App',
        components: { VueBootstrap4Table,Buttons,RecordsRepository },
        data: function() {
            return {
                model:'locations',
                editMode: this.$route.meta.mode,
                rows: [],
                columns: [
                     {label: "Id",name: "id",filter: {},sort: true,column_classes: "location_id",initial_sort: true, initial_sort_order: "asc" }, 
                     //Own Text                     
                     {label: "Title",name: "title_t",filter: {type: "simple",placeholder: "Title",},sort: true },   
                     {label: "Surface",name: "surface_n",filter: {type: "simple",placeholder: "Surface",},sort: true },  
                     {label: "Price",name: "price_n",filter: {type: "simple",placeholder: "Price",},sort: true },                    
                     {label: "City",name: "city",slot_name: "cities",filter: {type: "simple",placeholder: "Price",},sort: true}, 
                     {label: "Postcode",name: "postcode",slot_name: "postcodes",filter: {type: "simple",placeholder: "Postcode",},sort: true}, 
                     {label: "Client",name: "id",slot_name: "clients"},
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
                this.$refs.RecordsRepo.fetchData(this.model,this.serverParams, this.queryParams)                                
               // this.fetchData();                   
            },            

        }//meth
        
    }
</script>

<style>
.location_id{
    width:5%;     
}
</style>