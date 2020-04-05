<template>
    <div>        

            <div class="panel-heading">
                <div>                   
                    <Buttons :editMode="editMode" :model="model"></Buttons>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">User Edit </h3>
                        </div>
                                            

                        <div class="card-body">
                            
                            <div class="row">                                
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Photos</label>
                                        <DzoneComponent v-if="isMounted" :photableType="photable_Type" :photosList="photos_List" :photableId="photable_Id" :editMode="editMode"></DzoneComponent>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">               

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input v-model="form.name_t" type="text" name="name_t" class="form-control" :class="{ 'is-invalid': errors.name_t }" >
                                         <div class="alert alert-danger" v-if="errors.name_t"> {{errors.name_t[0]}}</div>
                                    </div>                                                                    
                                </div>
                                                           
                                <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input v-model="form.email" type="text" name="email" class="form-control" :class="{ 'is-invalid': errors.email }" >
                                         <div class="alert alert-danger" v-if="errors.email"> {{errors.email[0]}}</div>
                                    </div>  
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label>Role</label>
                                       <multiselect 
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
                                <Buttons :editMode="editMode" :model="model"></Buttons>
                            </div>
                        </div>
                        
                        
            </div>
         </div>
      </div>          

       <RecordsRepository ref="RecordsRepo" > </RecordsRepository>     

    </div>
</template>

<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod } from '../../lib/api'    
    import Buttons from '../../components/buttons/Buttons'
    import Datepicker from 'vuejs-datetimepicker'
    import Multiselect from 'vue-multiselect'
    import RecordsRepository from "../../repositories/RecordsRepository.vue"
    import DzoneComponent from '../../components/dzone/DzoneComponent'  

    export default {
        components: { Buttons, Datepicker, Multiselect, RecordsRepository, DzoneComponent },
       
        data () {
            return {
                model:'users', isMounted: false, allroles:[],roles:[],                         
                ////////////////////////////////////////////////////////// 
                editMode: this.$route.meta.mode,
               
                form: { active:0,}, errors: {},                         
                //////////////////////////////////////////////////////////               
                photable_Type: "App\\User", photable_Id: this.$route.params.id,                
                //
                datetime:'',date:'',
                //
                // client_type:'',alllocations:[],reccurences: [],clienttype:'',clienttypes:[
                //     {id: 1,name: 'Private' },
                //     {id: 2,name: 'Company' },                            
                // ],
            }
        },
        beforeRouteEnter(to, from, next) {            
            get('/v1/api'+to.path).then((res) => {  next(vm => vm.setData(res))  })
        },         
        methods: {           
            nameWithNameLastName ({ title_t }) {
                return `${title_t}`
            },           
            setData(res) { 
                if(this.$route.meta.mode === 'edit') {
                    Vue.set(this.$data, 'form', res.data.form)                                       
                    this.roles =  res.data.form.roles //assigned roles                  
                    this.photos_List = res.data.form.photos;
                    //console.log('setData-parent')
                }                
                //    console.log(this.photos_List)
                this.allroles =  res.data.allroles //all roles
                this.isMounted = true            
            },
            onSave() {
                this.$refs.RecordsRepo.onSave(this.model,this.$route.params.id,this.form,this.$route.meta.mode) 
            }                               
  
        }
    }
</script>
 <style src="vue-multiselect/dist/vue-multiselect.min.css"></style>