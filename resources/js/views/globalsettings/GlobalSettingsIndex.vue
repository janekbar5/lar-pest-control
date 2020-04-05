<template>
    <div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">         
          <div class="col-md-6">

              <vue-bootstrap4-table 
                :rows="treatments"        
                :columns="columns_formTreatment"
                :config="config"
                @on-change-query="onChange_formTreatment"
                :total-rows="total_rows"
                :actions="actions_treatments"
                @on-download="newRecord(model='formTreatment')"
                >
                <template slot="actions" slot-scope="props"> 
                   
                    <a href="#" @click="editPopup(model='treatments',form='formTreatment',props.row)"><i class="fa fa-edit black"></i></a>
                    /
                    <a href="#" @click="deleteRecord(model='treatments',props.cell_value)"><i class="fa fa-trash black"></i></a>   
                </template>       


                </vue-bootstrap4-table>
                <!----------------------- Modal treatmentModal ------------------------------------>
                <div class="modal fade" id="formTreatment" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New {{currentModel}}</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update {{currentModel}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateModel(currentModel,currentForm) : createModel(model='treatments',form='formTreatment')">
                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="formTreatment.title" type="text" name="title"
                                placeholder="Title"
                                class="form-control" :class="{ 'is-invalid': formTreatment.errors.has('title') }">
                            <has-error :form="formTreatment" field="title"></has-error>
                        </div>

                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="formHideReset('formTreatment')">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>

                    </form>

                    </div>
                </div>
                </div> 
            <!----------------------- Modal ------------------------------------>
              
          </div>


          <div class="col-md-6">
              <vue-bootstrap4-table 
                :rows="statuses"        
                :columns="columns_formStatus"
                :config="config"
                @on-change-query="onChange_formStatus"
                :total-rows="total_rows"
                :actions="actions_statuses"
                @on-download="newRecord(model='formStatus')"
                >
                <template slot="actions" slot-scope="props">
                    <a href="#" @click="editPopup(model='statuses',form='formStatus',props.row)"><i class="fa fa-edit black"></i></a>
                    /
                    <a href="#" @click="deleteRecord(model='statuses',props.cell_value)"><i class="fa fa-trash black"></i></a>   
                </template>       


                </vue-bootstrap4-table>
          </div>
           <!----------------------- Modal statusesModal------------------------------------>
             <div class="modal fade" id="formStatus" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New {{currentModel}}</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update {{currentModel}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{ currentForm }}{{ currentModel }}
                <form @submit.prevent="editmode ? updateModel(currentModel,currentForm) : createModel(model='statuses',form='formStatus')">
                <div class="modal-body">

                    <div class="form-group">
                        <input v-model="formStatus.title" type="text" name="title"
                            placeholder="Title"
                            class="form-control"                            
                            :class="{ 'is-invalid': errors.title }"
                            >
                             <!-- :class="{ 'is-invalid': formStatus.errors.has('title') }" -->
                        <!-- <has-error :form="formStatus" field="title"></has-error> -->
                        <div class="alert alert-danger" v-if="errors.title"> {{errors.title[0]}}</div>
                    </div>
                     <div class="form-group">
                        <input v-model="formStatus.colour" type="text" name="colour"
                            placeholder="Colour"
                            class="form-control" :class="{ 'is-invalid': errors.colour }">
                        <!-- <has-error :form="formStatus" field="colour"></has-error> -->
                        <div class="alert alert-danger" v-if="errors.colour"> {{errors.colour[0]}}</div>
                    </div>

                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="formHideReset('formStatus')">Close</button>
                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                </div>

                </form>

                </div>
            </div>
            </div> 
              <!----------------------- Modal end statusesModal------------------------------------>


       
         
      </div>
      </div>
    </section>
        
        <RecordsRepository ref="RecordsRepo" > </RecordsRepository>
    </div>
</template>

<script>
    import VueBootstrap4Table from 'vue-bootstrap4-table'
    import RecordsRepository from '../../repositories/RecordsRepository.vue'
    export default {
        name: 'Global',
        components: { VueBootstrap4Table,RecordsRepository },
        data: function() {
            return {
                editmode: false,
                ///////////
                currentModel:'', currentForm:'',
                treatments: [],statuses: [],
                columns_formTreatment: [
                     {label: "Id",name: "id",filter: {},sort: true,column_classes: "my_id",initial_sort: true, initial_sort_order: "asc" },                      
                     //Own Text                     
                     {label: "Title",name: "title",filter: {type: "simple",placeholder: "Title",},sort: true,column_classes: "my_title" },                    
                     {label: "Actions",name: "id",slot_name: "actions"},              
                ],
                columns_formStatus:[
                     {label: "Id",name: "id",filter: {},sort: true,column_classes: "my_id",initial_sort: true, initial_sort_order: "asc" },                      
                     //Own Text                     
                     {label: "Title",name: "title",filter: {type: "simple",placeholder: "Title",},sort: true,column_classes: "my_title" },                    
                     {label: "Actions",name: "id",slot_name: "actions"},              
                ],

                actions_treatments: [ { btn_text: "New Treatment", event_name: "on-download",class: "btn btn-secondary",event_payload: { msg: "my custom msg" } } ],
                actions_statuses: [ { btn_text: "New Status", event_name: "on-download",class: "btn btn-secondary",event_payload: { msg: "my custom msg" } } ],
                config: { server_mode: true,show_reset_button: true,show_refresh_button: false,global_search: {visibility: false,},per_page: 10,per_page_options: [10, 20], },
                queryParams: {sort: [],filters: [],global_search: "",page: 1,},
                total_rows: 0,
                //////
                serverParams:[],querySorting:[],queryFilters:[],
                //////
                formTreatment: new Form({id:'',title : ''}),
                formStatus: new Form({id:'',title : '',colour : '',}),
                errors:'',
                // formStatus: {
                //     errors:''        
                // },
            }
        },       
        mounted() {
            let model = 'treatments'          
        },
        methods: { 
            ///////////////////////////////////////      
            loadSubstatuses(props){
               return props.row.statuses.title               
            },
            newRecord(model,form) {        
                this.editmode = false;
                this[model].reset()           
                $('#'+model).modal('show') 
                this.currentModel = model
                this.currentForm = form
            },
            editPopup(model,form,row){
                this.editmode = true  
                this[form].reset()           
                $('#'+form).modal('show')                 
                this[form].fill(row)  
                this.currentModel = model
                this.currentForm = form                
            },
            
            updateModel(model,form){              
                this.$refs.RecordsRepo.updatePost(model,this[form].id,this[form]).then((res) => {
                        if(res.data.saved) {
                            this.fetchData(model)
                            $('#'+form).modal('hide')
                            this[form].reset()  
                            this.loadToast('success',''+model+' updated successfully');   
                        }                                  
                        })
                        .catch((error) => { 
                          this.errors = error.response.data.errors                       
                          if(error.response.status === 422) {                                
                                this.errors = error.response.data.errors
                                this.loadToast('error','Check the forms'); 
                           }         
                        })                  
            },
            createModel(model,form){                
                this.$refs.RecordsRepo.createPost(model,this[form]).then((res) => {                        
                        if(res.data.created) {                            
                            this.fetchData(model)
                            $('#'+form).modal('hide')
                            this[form].reset()  
                            this.loadToast('success',''+model+' created successfully');   
                        }                                  
                        })
                        .catch((error) => {                           
                          this.errors = error.response.data.errors                       
                          if(error.response.status === 422) {                                
                                this.errors = error.response.data.errors
                                this.loadToast('error','Check the forms'); 
                           }         
                        })    
            },
            deleteRecord(model,id){
                swal.fire({title: 'Are you sure?',text: "You won't be able to revert this!",type: 'warning',showCancelButton: true,
                confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                // Send request to the server
                if (result.value) {
                    this.$refs.RecordsRepo.delete(model,id).then(()=>{
                    swal.fire('Deleted!','Your '+model+' has been deleted.','success')
                    this.fetchData(model)                                         
                }).catch(()=> {
                    swal.fire("Failed!", "There was something wronge.", "warning");
                    });
                }
                })        
            },
            loadToast(icon,text){ toast.fire({icon: icon,title: text }) }, 

            ////////////////////////////////////////////////////////////////////////////////////////////////////////TABLE
           
            onChange_formTreatment(queryParams) {
                var model1
                this.queryParams = queryParams                                   
                this.fetchData(model1='treatments');                   
            },
            onChange_formStatus(queryParams) {
                var model2
                this.queryParams = queryParams                                   
                this.fetchData(model2='statuses');                   
            },
                    
            fetchData: async function(model) {
                //console.log('ddd'+model)
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

                const { data } = await this.$refs.RecordsRepo.sortFilter(model,this.querySorting+'&'+filterParams.join('&')+'&'+queryPer+'&'+page); 
                //self.rows_[model] = data.rows.data;
                this[model] = data.rows.data;
                self.total_rows = data.rows.total; 
              
            },
           

        }//meth
        
    }
</script>

<style>
.my_id{
    width:10%
}
.my_title{
    width:50%
}


</style>