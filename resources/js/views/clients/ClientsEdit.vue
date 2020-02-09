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
                            <h3 class="card-title">Quick Example {{ editMode }} </h3>
                        </div>
                        
                        <div class="card-body">
                            
                            <div class="row">   
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': errors.name }" >
                                         <div class="alert alert-danger" v-if="errors.title"> {{errors.name[0]}}</div>
                                    </div>                                                                    
                                </div>
                                                           
                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input v-model="form.email" type="text" name="email" class="form-control" :class="{ 'is-invalid': errors.email }" >
                                         <div class="alert alert-danger" v-if="errors.email"> {{errors.email[0]}}</div>
                                    </div>  
                                </div>

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
                                        <label>Contract Start</label>
                                        <input v-model="form.contract_start" type="text" name="contract_start" class="form-control" :class="{ 'is-invalid': errors.contract_start }" >
                                         <div class="alert alert-danger" v-if="errors.contract_start"> {{errors.contract_start[0]}}</div>
                                    </div>  
                                </div> 
                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Contract End</label>
                                        <input v-model="form.contract_end" type="text" name="contract_end" class="form-control" :class="{ 'is-invalid': errors.contract_end }" >
                                         <div class="alert alert-danger" v-if="errors.contract_end"> {{errors.contract_end[0]}}</div>
                                    </div>  
                                </div>                                 
                            </div>
                            <div class="row">
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
                               
                                <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" type="text" name="description" class="form-control" :class="{ 'is-invalid': errors.description }" ></textarea>
                                         <div class="alert alert-danger" v-if="errors.description"> {{errors.description[0]}}</div>
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
    //import {Typeahead } from '../../components/typeahead'
    //import DzoneComponent from '../../components/DzoneComponent';
    import Buttons from './Buttons';
    
    export default {
        components: { Buttons },
        data () {
            return {
                modelSingular: '',
                apiList:'', apiCreate:'', apiEdit:'', apiCreate:'', apiUpdate:'',     
                //
                urlList:'', urlCreate:'', urlEdit:'',              
                ////////////////////////////////////////////////////////// 
                editMode: this.$route.meta.mode,
                form: {},
                errors: {},                         
                //////////////////////////////////////////////////////////               
                photable_Type: "App\\User",
                photable_Id: this.$route.params.id,
                // photos_List: [],
                //
                //roles: null,
                //allroles: [],
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
            this.$eventHub.$on('settings', this.modelSettings) 
        },
        methods: {
            modelSettings(settings){                
                //return name
                this.settings = settings;
                this.urlList = settings.urlList
                this.urlEdit = settings.urlEdit
                this.urlCreate = settings.urlCreate
                //         
                this.apiList = settings.apiList
                this.apiDelete = settings.apiDelete
                this.apiCreate = settings.apiCreate
                this.apiEdit = settings.apiEdit
                this.apiUpdate = settings.apiUpdate
                //
                this.modelSingular = settings.modelSingular
                //console.log(settings)                
            },
            setData(res) { 
                if(this.$route.meta.mode === 'edit') {
                    Vue.set(this.$data, 'form', res.data.form)
                    this.store = this.apiUpdate + this.$route.params.id
                    this.method = 'PUT'
                    this.title = 'Edit'    
                }               
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
            onDelete(){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!"+this.urlList,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                //byMethod('delete', `/api/properties/${this.model.id}`).then(()=>{
                                byMethod('delete',this.apiDelete+this.$route.params.id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    //Fire.$emit('AfterCreate');
                                    this.$router.push(this.urlList)
                                }).catch(()=> {
                                    swal.fire("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
            },
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>