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
                            <h3 class="card-title">User Edit </h3>
                        </div>
                                            

                        <div class="card-body">
                            
                            <!-- <div class="row">                                
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Photos</label>
                                        <DzoneComponent v-if="isMounted" :photableType="photable_Type" :photosList="photos_List" :photableId="photable_Id" :editMode="editMode"></DzoneComponent>
                                    </div>
                                </div>
                            </div> -->
                            
                            <div class="row">               

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': errors.name }" disabled>
                                         <div class="alert alert-danger" v-if="errors.name"> {{errors.name[0]}}</div>
                                    </div>                                                                    
                                </div>
                                                           
                                <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input v-model="form.email" type="text" name="email" class="form-control" :class="{ 'is-invalid': errors.email }" disabled>
                                         <div class="alert alert-danger" v-if="errors.email"> {{errors.email[0]}}</div>
                                    </div>  
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label>Role</label>
                                       <multiselect 
                                        disabled
                                        v-model="form.roles" 
                                        deselect-label="Can't remove this value" 
                                        track-by="name" 
                                        label="name" 
                                        placeholder="Select one" 
                                        :options="allroles" 
                                        :multiple="true" 
                                        :searchable="true" 
                                        :allow-empty="true"
                                        :taggable="true"                                        
                                        :class="{ 'is-invalid': errors.roles }"                          
                                        >
                                            <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.name }}</strong> </template>
                                            <pre class="language-json"><code>{{ roles  }}</code></pre>
                                            <pre class="language-json"><code>{{ allroles  }}</code></pre>
                                        </multiselect>
                                     <div class="alert alert-danger" v-if="errors.roles"> {{errors.roles[0]}}</div>  
                                    </div>       
                                 </div> 

                                 <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input v-model="form.password" type="password" name="password" class="form-control" :class="{ 'is-invalid': errors.password }" >
                                         <div class="alert alert-danger" v-if="errors.password"> {{errors.password[0]}}</div>
                                    </div>  
                                </div> 

                                <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input v-model="form.confirm_password" type="password" name="confirm_password" class="form-control" :class="{ 'is-invalid': errors.confirm_password }" >
                                         <div class="alert alert-danger" v-if="errors.confirm_password"> {{errors.confirm_password[0]}}</div>
                                    </div>  
                                </div>   


                            </div>
                                    
                       </div> 
                       

                        <div class="card-footer">
                            <div>                               
                                <button class="btn btn-danger" @click="onSave">Update</button>
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
    import DzoneComponent from '../../components/dzone/DzoneComponent';
    import Buttons from './Buttons';
    import Multiselect from 'vue-multiselect'
  
    export default {
        components: { DzoneComponent, Buttons, Multiselect },
        data () {
            return {
                isMounted: false,
                apiList:'', apiCreate:'', apiEdit:'', apiCreate:'', apiUpdate:'',     
                //
                urlList:'', urlCreate:'', urlEdit:'',              
                ////////////////////////////////////////////////////////// 
                editMode: this.$route.meta.mode,
                form: {},
                errors: {},              
                //
                photable_Type: "App\\User",
                photable_Id: this.$route.params.id,
                photos_List: [],
                //
                roles: null,
                allroles: [],
            }
        },
        beforeRouteEnter(to, from, next) {
            //console.log(to)
            get('v1/api/users/usersettings')
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            //get(initialize(to))
            get('v1/api/users/usersettings')
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        computed: {
          
        },
        created() {
            
        },
        methods: {
            
            setData(res) { 
               
                    Vue.set(this.$data, 'form', res.data.results)
                    this.store = this.apiUpdate + this.$route.params.id
                    this.method = 'PUT'
                    this.title = 'Edit'                    
                    this.roles =  res.data.roles //assigned roles                  
                    this.photos_List = res.data.photos;                  
                    this.allroles =  [] //all roles
             
            },
         
            // addTag2 (newTag) {
            //     const tag = {
            //         name: newTag,
            //         code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            //     }
            //     this.allroles.push(tag)
            //     this.roles.push(tag)               
            // },
            onSave() {
                this.errors = {}
                byMethod('POST','/v1/api/users/updatesettings/'+this.form.id, this.form)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            this.success(res)
                            this.loadToast('success','Updated successfully');  
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
                this.$router.push('/dashboard')
                
            },
            
            loadToast(icon,text){
              toast.fire({icon: icon,title: text })
            }, 
            
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>