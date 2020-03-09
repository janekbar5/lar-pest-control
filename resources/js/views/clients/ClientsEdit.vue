<template>
    <div>        

            <div class="panel-heading">
                <div>                   
                    <Buttons :editMode="editMode" ></Buttons>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Client {{ editMode }} </h3>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">   
                                    <div class="form-group">                                       
                                        <div class="custom-control custom-checkbox">
                                        <input v-model="form.active" class="custom-control-input" type="checkbox" id="customCheckbox2" :value="form.active" :class="{ 'is-invalid': errors.active }">
                                        <label for="customCheckbox2" class="custom-control-label">Active {{form.active }}</label>
                                         <div class="alert alert-danger" v-if="errors.active"> {{errors.active[0]}}</div>
                                        </div>                                        
                                    </div>
                                </div>    
                            </div>    
                            <div class="row">
                                <div class="col-md-2">   
                                  <div class="form-group">
                                        <label>Client Type</label> 
                                        <select v-model="form.client_type" name="client_type" class="form-control" :class="{ 'is-invalid': errors.client_type }">
                                            <option value="">Select Client Type</option>
                                            <option v-for="client in clienttypes" :value="client.id">
                                            {{client.name}}
                                            </option>
                                        </select>                                        
                                       <div class="alert alert-danger" v-if="errors.client_type"> {{errors.client_type[0]}}</div>
                                    </div>  
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input v-model="form.name" type="text" name="company_name" class="form-control" :class="{ 'is-invalid': errors.name }" >
                                         <div class="alert alert-danger" v-if="errors.name"> {{errors.name[0]}}</div>
                                    </div>                                                                    
                                </div>


                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input v-model="form.phone" type="text" name="phone" class="form-control" :class="{ 'is-invalid': errors.phone }" >
                                         <div class="alert alert-danger" v-if="errors.phone"> {{errors.phone[0]}}</div>
                                    </div>                                                                    
                                </div>
                                                           
                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input v-model="form.email" type="text" name="email" class="form-control" :class="{ 'is-invalid': errors.email }" >
                                         <div class="alert alert-danger" v-if="errors.email"> {{errors.email[0]}}</div>
                                    </div>  
                                </div>


                                

                                                              
                            </div>
                            <div class="row" v-show="form.client_type == 2">

                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Contract Number</label>
                                        <input v-model="form.contract_number" type="text" name="contract_number" class="form-control" :class="{ 'is-invalid': errors.contract_number }" >
                                         <div class="alert alert-danger" v-if="errors.contract_number"> {{errors.contract_number[0]}}</div>
                                    </div>  
                                </div> 
                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Vat Number</label>
                                        <input v-model="form.vat_number" type="text" name="vat_number" class="form-control" :class="{ 'is-invalid': errors.vat_number }" >
                                         <div class="alert alert-danger" v-if="errors.vat_number"> {{errors.vat_number[0]}}</div>
                                    </div>  
                                </div>

                               <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Person Title</label>
                                        <input v-model="form.person_title" type="text" name="person_title" class="form-control" :class="{ 'is-invalid': errors.person_title }" >
                                         <div class="alert alert-danger" v-if="errors.person_title"> {{errors.person_title[0]}}</div>
                                    </div>  
                                </div> 
                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Person Name</label>
                                        <input v-model="form.person_name" type="text" name="person_name" class="form-control" :class="{ 'is-invalid': errors.person_name }" >
                                         <div class="alert alert-danger" v-if="errors.person_name"> {{errors.person_name[0]}}</div>
                                    </div>  
                                </div> 
                                                                 
                            </div>

                            <div class="row">  
                            <div class="col-md-3">                                   
                                    <div class="form-group">
                                        <label>Contract Start</label>
                                        <Datepicker format="YYYY-MM-DD" v-model="form.contract_start" class=""  />
                                       
                                         <div class="alert alert-danger" v-if="errors.contract_start"> {{errors.contract_start[0]}}</div>
                                    </div>  
                                </div> 
                                <div class="col-md-3">                                   
                                    <div class="form-group">
                                        <label>Contract End</label>                                       
                                        <!-- <input v-model="form.contract_end" type="text" name="contract_end" class="form-control" :class="{ 'is-invalid': errors.contract_end }" > -->
                                        <Datepicker format="YYYY-MM-DD" v-model="form.contract_end" class=""  />
                                        <div class="alert alert-danger" v-if="errors.contract_end"> {{errors.contract_end[0]}}</div>
                                    </div>  
                                </div> 
                                <div class="col-md-3">                                   
                                    <div class="form-group">
                                        <label>Reccurence</label>                                       
                                        <!-- <input v-model="form.reccurence" type="text" name="reccurence" class="form-control" :class="{ 'is-invalid': errors.reccurence }" >  -->
                                        <select v-model="form.reccurence_id" name="reccurence" class="form-control" :class="{ 'is-invalid': errors.reccurence_id }">
                                            <option v-for="rec in reccurences" :value="rec.id">
                                            {{rec.title}}
                                            </option>
                                        </select>                                        
                                        <div class="alert alert-danger" v-if="errors.reccurence_id"> {{errors.reccurence_id[0]}}</div>
                                    </div>  
                                </div>   

                            </div>        
                            <div class="row">                               
                                <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" type="text" name="description" class="form-control" :class="{ 'is-invalid': errors.description }" ></textarea>
                                         <div class="alert alert-danger" v-if="errors.description"> {{errors.description[0]}}</div>
                                    </div>  
                                </div>                                 
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Locations</label>     

                                            <multiselect 
                                            v-model="form.locations" 
                                            :options="alllocations"
                                            :custom-label="nameWithNameLastName"                                                                                         
                                            placeholder="Select users"
                                            :multiple="true"                                            
                                            label="name" 
                                            track-by="title">
                                            </multiselect>
                                     </div>  
                                </div>                                 
                            </div>
                           

                           
                                           

                                    
                       </div> 
                        
                        <div class="card-footer">
                            <div>                               
                                <Buttons :editMode="editMode" ></Buttons>
                            </div>
                        </div>
                        
                        
            </div>
         </div>
      </div>          
            

    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod } from '../../lib/api'
    //import { Datetime } from 'vue-datetime';
    //import {Typeahead } from '../../components/typeahead'
    //import DzoneComponent from '../../components/DzoneComponent';
    import Buttons from './Buttons';
    import Datepicker from 'vuejs-datetimepicker'
    import Multiselect from 'vue-multiselect'
        
    export default {
        components: { Buttons, Datepicker, Multiselect },
        //components: {  Multiselect },
        data () {
            return {
                modelSingular: '',
                apiList:'', apiCreate:'', apiEdit:'', apiCreate:'', apiUpdate:'',     
                //
                urlList:'', urlCreate:'', urlEdit:'',              
                ////////////////////////////////////////////////////////// 
                editMode: this.$route.meta.mode,

                client_type:'',
                form: {
                    active:0,
                },
                errors: {},                         
                //////////////////////////////////////////////////////////               
                photable_Type: "App\\User",
                photable_Id: this.$route.params.id,
                // photos_List: [],
                //
                //roles: null,
                //allroles: [],
                datetime:'',
                date:'',
                //
                alllocations:[],
                //locations:[],
                // value: [],
                // options: [
                //     { name: 'Vue.js', language: 'JavaScript' },
                //     { name: 'Adonis', language: 'JavaScript' },
                //     { name: 'Rails', language: 'Ruby' },
                //     { name: 'Sinatra', language: 'Ruby' },
                //     { name: 'Laravel', language: 'PHP' },
                //     { name: 'Phoenix', language: 'Elixir' }
                // ],
                //
                modelPlural: 'clients', modelSingular: 'Client', 
                urlList:'/clients',
                urlCreate:'/clients/create',
                urlEdit:'/clients/',
                apiList:'/v1/api/clients/index',
                apiCreate:'/v1/api/clients/create',
                apiEdit:'/v1/api/clients/edit/',       
                apiUpdate:'/v1/api/clients/update/',     
                apiDelete:'/v1/api/clients/delete/',
                reccurences: [],
                clienttype:'',
                clienttypes:[
                    {id: 1,name: 'Private' },
                    {id: 2,name: 'Company' },                            
                ],
            }
        },
        beforeRouteEnter(to, from, next) {            
            get('/v1/api'+to.path)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false            
            get('/v1/api'+to.path)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        computed: {
          
        },
        created() {
            //this.$eventHub.$on('settings', this.modelSettings) 
        },
        methods: {
           
            nameWithNameLastName ({ title }) {
                return `${title}`
            },
           
            setData(res) { 
                if(this.$route.meta.mode === 'edit') {
                    Vue.set(this.$data, 'form', res.data.form)                     
                    this.store = this.apiUpdate + this.$route.params.id
                    this.locations =  res.data.form.locations //assigned locations
                    this.method = 'PUT'
                    this.title = 'Edit'    
                } 
                this.reccurences =  res.data.reccurences
                this.alllocations =  res.data.alllocations //alllocations            
            }, 
            onSave() {
                this.errors = {}
                this.isProcessing = true                
                byMethod('POST',this.$route.meta.mode === 'edit' ? this.apiUpdate+this.form.id : this.apiCreate , this.form)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            this.success(res)
                            this.loadToast('success',''+this.modelSingular+' updated successfully');   
                        }
                        if(res.data && res.data.created) {
                            this.success(res)
                            this.loadToast('success',''+this.modelSingular+' created successfully');   
                        }
                    })
                    .catch((error) => {
                        if(error.response.status === 422) {
                            this.errors = error.response.data.errors
                            this.loadToast('error','Check the forms'); 
                        }
                        this.isProcessing = false
                    })
            },
            success(res) {
                this.$router.push(this.urlList)                
            },           
            loadToast(icon,text){
              toast.fire({icon: icon,title: text })
            }, 
            // onDelete(){
            //     swal.fire({
            //         title: 'Are you sure?',
            //         text: "You won't be able to revert this!"+this.urlList,
            //         type: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Yes, delete it!'
            //         }).then((result) => {
            //             // Send request to the server
            //              if (result.value) {
            //                     //byMethod('delete', `/api/properties/${this.model.id}`).then(()=>{
            //                     byMethod('delete',this.apiDelete+this.$route.params.id).then(()=>{
            //                             swal.fire(
            //                             'Deleted!',
            //                             'Your file has been deleted.',
            //                             'success'
            //                             )
            //                         //Fire.$emit('AfterCreate');
            //                         this.$router.push(this.urlList)
            //                     }).catch(()=> {
            //                         swal.fire("Failed!", "There was something wronge.", "warning");
            //                     });
            //              }
            //         })
            // },
        }
    }
</script>
 <style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
