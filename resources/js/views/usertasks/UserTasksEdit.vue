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
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Photos</label>
                                        <DzoneComponent :photableType="photable_Type" :photosList="photos_List" :photableId="photable_Id" :editMode="editMode"></DzoneComponent>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">               

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <typeahead :url="dataURL" :initialize="form.locations" @input="onLocation" disabled/>
                                        <!-- <input v-model="form.location_id" type="text" name="location_id" class="form-control" :class="{ 'is-invalid': errors.location_id }" > -->
                                        <input v-model="form.location_id" type="hidden" name="location" class="form-control" :class="{ 'is-invalid': errors.location_id }" disabled>
                                         <div class="alert alert-danger" v-if="errors.location_id"> {{errors.location_id[0]}}</div>
                                    </div>                                                                    
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input v-model="form.title" type="text" name="title" class="form-control" :class="{ 'is-invalid': errors.title }" disabled >
                                         <div class="alert alert-danger" v-if="errors.title"> {{errors.title[0]}}</div>
                                    </div>                                                                    
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input v-model="form.price" type="text" name="price" class="form-control" :class="{ 'is-invalid': errors.price }" disabled>
                                         <div class="alert alert-danger" v-if="errors.price"> {{errors.price[0]}}</div>
                                    </div>                                                                    
                                </div>

                                
                            </div>
                            <div class="row">
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start</label>
                                         <input v-model="form.start" type="text" name="start" class="form-control" :class="{ 'is-invalid': errors.start }" disabled > 
                                        <!-- <Datepicker format="YYYY-MM-DD h:i" v-model="form.start" class="" :class="{ 'is-invalid': errors.start }"  disabled/> -->
                                         <div class="alert alert-danger" v-if="errors.start"> {{errors.start[0]}}</div>
                                    </div>                                                                    
                                </div>
                                                           
                                <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>End</label>
                                        <input v-model="form.end" type="text" name="end" class="form-control" :class="{ 'is-invalid': errors.end }" disabled>
                                         <!-- <Datepicker format="YYYY-MM-DD h:i" v-model="form.end" class=""  :disabled-dates="disabled"/> -->
                                         <div class="alert alert-danger" v-if="errors.end"> {{errors.end[0]}}</div>
                                    </div>  
                                </div>

                                
                               
                            </div>
                            <div class="row"> </div>
                           <div class="row">
                                                                 
                                 <!-- <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input v-model="form.status_id" type="text" name="status_id" class="form-control" :class="{ 'is-invalid': errors.status_id }" >
                                         <div class="alert alert-danger" v-if="errors.status_id"> {{errors.status_id[0]}}</div>
                                    </div>  
                                </div> -->

                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label>Status</label>
                                            <select v-model="form.status_id" class="form-control" :class="{ 'is-invalid': errors.status_id}">
                                            <option value="">Select Status</option>
                                            <option v-for="status in statuses" :value="status.id">
                                                {{status.title}}
                                            </option>
                                            </select>                                        
                                            <div class="alert alert-danger" v-if="errors.status_id"> {{errors.status_id[0]}}</div>
                                    </div>
                                  </div> 

                                   <div class="col-md-4" v-show="form.status_id == 3">
                                    <div class="form-group">
                                    <label>Sub Status</label>
                                            <select v-model="form.substatus_id" class="form-control"  :class="{ 'is-invalid': errors.substatus_id}">
                                            <option value="">Select Sub Status</option>
                                            <option v-for="substatus in substatuses" :value="substatus.id">
                                                {{substatus.title}}
                                            </option>
                                            </select>                                        
                                            <div class="alert alert-danger" v-if="errors.substatus_id"> {{errors.substatus_id[0]}}</div>
                                    </div>
                                  </div>   



                             
                            </div>


                           <div class="row">
                                <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Assigned Users</label>                                                                          
                                        <multiselect 
                                        v-model="form.users" 
                                        :options="allFieldUsers"
                                        :custom-label="nameWithSuename"                                          
                                        placeholder="Select users"
                                        :multiple="true"                                       
                                        label="name" 
                                        track-by="name"
                                        disabled
                                        ></multiselect>
                                  </div>  
                                </div> 
                            </div>
                                

                            <div class="row">
                                <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" type="text" name="description" class="form-control" :class="{ 'is-invalid': errors.description }" >
                                        </textarea>    
                                         <div class="alert alert-danger" v-if="errors.description"> {{errors.description[0]}}</div>
                                    </div>  
                                </div> 
                                 <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea v-model="form.comment" type="text" name="comment" class="form-control" :class="{ 'is-invalid': errors.comment }" >
                                        </textarea>    
                                         <div class="alert alert-danger" v-if="errors.comment"> {{errors.comment[0]}}</div>
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
    import moment from 'moment'
    import {get, byMethod } from '../../lib/api'
    import {Typeahead } from '../../components/typeahead'
    import DzoneComponent from '../../components/dzone/DzoneComponent';
    import Buttons from './Buttons';
    import Multiselect from 'vue-multiselect' 
    import Datepicker from 'vuejs-datetimepicker'

    export default {
        components: { DzoneComponent, Buttons, Multiselect, Datepicker, Typeahead },
        data () {
            return {
               
                modelPlural: 'tasks', modelSingular: 'Task', 
                urlList:'/usertasks',
                urlCreate:'/usertasks/create',
                urlEdit:'/usertasks/',
                apiList:'/v1/api/usertasks/index',
                apiCreate:'/v1/api/usertasks/create',
                apiEdit:'/v1/api/tasks/edit/',       
                apiUpdate:'/v1/api/tasks/update/',     
                apiDelete:'/v1/api/tasks/delete/',            
                // 
                editMode: this.$route.meta.mode,
                form: {
                   //locations:{}
                   status_id: this.$route.meta.mode==="edit" ? '' : 1,
                   //start: this.$route.meta.mode==="edit" ? '' : moment().format('MMMM Do YYYY, h:mm'),
                   start: this.$route.meta.mode==="edit" ? '' : '2020-02-02 07:30',
                   end: this.$route.meta.mode==="edit" ? '' : '2020-02-02 08:30',
                  
                },               
                errors: {},               
                //
                photable_Type: "App\\Task",
                photable_Id: this.$route.params.id,
                photos_List: [],
                //
                roles: null,
                allroles: [],
                statuses:[],
                substatuses:[],
                //
                dataURL: '/v1/api/locations/searchlocations',
                //fieldusers: [],
                //options:[],
                users:[], //dont need allPermissions in form only selected 
                allFieldUsers:[], //dont need allPermissions in form only selected 
                
               
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
            onLocation(e) {
                const locations = e.target.value
                Vue.set(this.$data.form, 'locations', locations) 
                Vue.set(this.$data.form, 'location_id', locations.id) 
                                                         
            },
            // modelSettings(settings){                
            //     //return name
            //     this.settings = settings;
            //     this.urlList = settings.urlList
            //     this.urlEdit = settings.urlEdit
            //     this.urlCreate = settings.urlCreate
            //     //         
            //     this.apiList = settings.apiList
            //     this.apiDelete = settings.apiDelete
            //     this.apiCreate = settings.apiCreate
            //     this.apiEdit = settings.apiEdit
            //     this.apiUpdate = settings.apiUpdate
            //     //
            //     this.modelSingular = settings.modelSingular
            //     //console.log(settings)                
            // },
            setData(res) { 
                if(res.data && res.data.created) {
                    this.success(res)
                    this.loadToast('danger','not allowed to do so');    
                }

                if(this.$route.meta.mode === 'edit') {
                    Vue.set(this.$data, 'form', res.data.form)
                    this.store = this.apiUpdate + this.$route.params.id
                    this.method = 'PUT'
                    this.title = 'Edit'                    
                    this.roles =  res.data.form.roles //assigned roles                   
                    this.photos_List = res.data.form.photos;
                }
                this.photos_List = res.data.form.photos;
                this.allFieldUsers =  [] //all roles
                this.statuses =  res.data.statuses //all roles
                this.substatuses =  res.data.substatuses.data //all roles
                this.objectToArray()
            },          
            objectToArray() {                
                var user_array = [];               
                this.allFieldUsers.forEach(element => {
                    user_array.push(element.id);
                });
                this.selected_users = user_array;
            }, 
            nameWithSuename ({ name, last_name }) {
            return `${name} ${last_name}`
            },  
            // addTag2 (newTag) {
            //     const tag = {
            //         name: newTag,                   
            //     }
            //     this.selected_users.push(tag)
            //     this.allFieldUsers.push(tag)
            //     //console.log(options)
            // },
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
                //this.$router.push(this.urlList+'/'+res.data.id)
                //console.log(this.urlList+'/'+res.data.id)
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