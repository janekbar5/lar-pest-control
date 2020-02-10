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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': errors.name }" >
                                         <div class="alert alert-danger" v-if="errors.name"> {{errors.name[0]}}</div>
                                    </div>

                                    <!-- <div class="form-group">
                                        <label>Guard_name</label>
                                        <input v-model="form.guard_name" type="text" name="guard_name" class="form-control" :class="{ 'is-invalid': errors.guard_name }">
                                        <div class="alert alert-danger" v-if="errors.guard_name"> {{errors.guard_name[0]}}</div>
                                    </div> -->
                                   
                                </div>
                                                                             
                                                          
                            </div>
                            
                          

                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="label">Inventories List</label>
                                        <br>
                                        <div class="icheck-danger d-inline">
                                            <div v-for="item in allInventories" style="border:solid 0px red;width:300px;float:left">
                                                <input :value="item.id" v-model="form.selectedInventories" type="checkbox" /> {{item.title}}
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>

                            </div> -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Permission List</label>       <br>                                 
                                        <!-- <div class="icheck-danger d-inline"> -->
                                            <div v-for="perm in allPermisions" style="border:solid 0px red;width:300px;float:left">
                                                <input :value="perm.id" v-model="form.grantedPermissions" type="checkbox" /> {{perm.name}}
                                            </div>
                                            <!-- <br>
                                        </div> -->
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
    import Buttons from './Buttons';

    // function initialize(to) {
    //     let urls = {
    //         'create': `/v1/api/properties/create`,
    //         'edit':  `/v1/api/properties/edit/${to.params.id}`
    //     }

    //     return (urls[to.meta.mode] || urls['create'])
    // }
    export default {
        components: { Buttons },
        data () {
            return {
                apiList:'',
                apiCreate:'',
                apiEdit:'',
                apiCreate:'',
                apiUpdate:'',     
                //
                urlList:'',               
                urlCreate:'',                 
                urlEdit:'',
                //store: '/v1/api/properties/create',
                //modelList: '/properties',
                ////////////////////////////////////////////////////////// 
                editMode: this.$route.meta.mode,
                form: {},
                errors: {},
                // isProcessing: false,
                // show: false,
                // method: 'POST',
                // title: 'Create',
                //////////////////////////////////////////////////////////
                //groups:[],
                //seasonGroups:[],
                //grantedInventories:[], //dont need allPermissions in form only selected 
                allPermisions:[], //dont need allPermissions in form only selected 
                grantedPermisions:[], //dont need allPermissions in form only selected 
                //allAdvantages:[], //dont need allPermissions in form only selected 
                //showSubmitFeedback: false,
                //
                photable_Type: "App\\Property",
                photable_Id: this.$route.params.id,
                photos_List: [],
               
            }
        },
        beforeRouteEnter(to, from, next) {
            //console.log(to)
            get('/v1/api'+to.path)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            //get(initialize(to))
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
                //console.log(settings)                
            },
            setData(res) { 
                if(this.$route.meta.mode === 'edit') {
                    Vue.set(this.$data, 'form', res.data.form)
                    this.store = this.apiUpdate + this.$route.params.id
                    //this.method = 'PUT'
                    //this.title = 'Edit' 
                }
                this.grantedPermissions = res.data.form.grantedPermissions
                this.allPermisions = res.data.form.allPermissions 
                this.objectToArray(); 
                
            
            },
            onSave() {
                this.errors = {}
                this.isProcessing = true                
                byMethod('POST',this.$route.meta.mode === 'edit' ? this.apiUpdate+this.form.id : this.apiCreate , this.form)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            this.success(res)
                             this.loadToast('success','Updated successfully');  
                        }
                        if(res.data && res.data.created) {
                            this.success(res)
                             this.loadToast('success','Created successfully');  
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
                this.$router.push(this.urlList+'/'+res.data.id)
                console.log(this.urlList+'/'+res.data.id)  
            },
            objectToArray() {
                var perm_array = [];               
                this.grantedPermissions.forEach(element => {
                    perm_array.push(element.id);
                });       
                this.form.grantedPermissions = perm_array;               
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
