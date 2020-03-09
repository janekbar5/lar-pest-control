<template>
    <div id="app">
        <vue-bootstrap4-table :rows="rows"
                              :columns="columns"
                              :config="config"
                              @on-change-query="onChangeQuery"
                              :total-rows="total_rows">

                              
          <template slot="photos" slot-scope="props">  
           <img v-if="props.row.photos[0] == null" src="https://dummyimage.com/60x50/807c80/fff" style="width:60px;height:50px">
           <img v-else :src="'images/thumb_medium-' + props.row.photos[0].path" style="width:60px;height:50px" /> 
         </template> 

          <template slot="locations" slot-scope="props">          
           {{ props.row.locations.title }}        
         </template>

         <template slot="substatuses" slot-scope="props">          
           {{ loadSubstatuses(props)}}        
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
                     {label: "Title",name: "title-t",filter: {type: "simple",placeholder: "title",},sort: true },   
                     {label: "Location",name: "location_id",slot_name: "locations",filter: {type: "simple",placeholder: "Location"},sort: true},                   
                     {label: "Start",name: "start-t",filter: {type: "simple",placeholder: "start"},sort: true },
                     {label: "End",name: "end-t",filter: {type: "simple",placeholder: "end"},sort: true },
                     //Own Number
                     {label: "Price",name: "price-n",filter: {type: "simple",placeholder: "price"},sort: true },
                     {label: "Status",name: "status_id-n",slot_name: "substatuses", filter: {type: "select", mode: "single",closeDropdownOnSelection: true,placeholder: "Status",options: [
                        {"name": "New","value": 1},
                        {"name": "Done","value": 2},
                        {"name": "Not Done","value": 3},
                     ],
                     //init: {value : 2}
                     },sort: true },    
                     {label: "Actions",name: "id",slot_name: "actions"},              
                ],
                config: { server_mode: true,per_page: 20,per_page_options: [20, 40, 60, 80], },
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
            getPhotos(props) {
                //return props.row.photos[0] == null ? <img src="https://dummyimage.com/60x50/807c80/fff" style="width:60px;height:50px"> : <img v-else src=images/thumb_medium-' + props.row.photos[0].path+' style="width:60px;height:50px" />       
            }, 
            loadSubstatuses(props){
               return props.row.statuses.title               
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

                const { data } = await RecordsRepository.sortFilter(this.model,this.querySorting+'&'+filterParams.join('&')+'&'+queryPer+'&'+page); 
                self.rows = data.rows.data;
                self.total_rows = data.rows.total;      
            }

        }//meth
        
    }
</script>

<style>
.my_id{
    width:5%
}
</style>