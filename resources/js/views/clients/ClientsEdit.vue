<template>
    <div>        

             <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <Buttons :editMode="editMode" :model="model"></Buttons>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <!-- <h3 class="card-title">Client {{ editMode }} </h3> -->
                            <!-- <Buttons :editMode="editMode" :model="model"></Buttons> -->
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">   
                                    <div class="form-group">                                       
                                        <div class="custom-control custom-checkbox">
                                        <input v-model="form.active_n" class="custom-control-input" type="checkbox" id="customCheckbox2" :value="form.active_n" :class="{ 'is-invalid': errors.active_n }">
                                        <label for="customCheckbox2" class="custom-control-label">Active {{form.active_n }}</label>
                                         <!-- <div class="alert alert-danger" v-if="errors.active_n"> {{errors.active_n[0]}}</div> -->
                                         <span v-if="errors.active_n" class="error invalid-feedback">{{errors.active_n[0]}}</span>
                                        </div>                                        
                                    </div>
                                </div>    
                            </div>    
                            <div class="row">
                                <div class="col-md-2">   
                                  <div class="form-group">
                                        <label>Client Type</label> 
                                        <select v-model="form.client_type_n" name="client_type_n" class="form-control" :class="{ 'is-invalid': errors.client_type_n }">
                                            <option value="">Select Client Type</option>
                                            <option v-for="client in clienttypes" :value="client.id">
                                            {{client.name}}
                                            </option>
                                        </select>                                        
                                       <!-- <div class="alert alert-danger" v-if="errors.client_type_n"> {{errors.client_type_n[0]}}</div> -->
                                       <span v-if="errors.client_type_n" class="error invalid-feedback">{{errors.client_type_n[0]}}</span>
                                    </div>  
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input v-model="form.name_t" type="text" name="name_t" class="form-control" :class="{ 'is-invalid': errors.name_t }" >
                                         <!-- <div class="alert alert-danger" v-if="errors.name_t"> {{errors.name_t[0]}}</div> -->
                                          <span v-if="errors.name_t" class="error invalid-feedback">{{errors.name_t[0]}}</span>
                                    </div>                                                                    
                                </div>


                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input v-model="form.phone_n" type="text" name="phone_n" class="form-control" :class="{ 'is-invalid': errors.phone_n }" >
                                         <!-- <div class="alert alert-danger" v-if="errors.phone_n"> {{errors.phone_n[0]}}</div> -->
                                         <span v-if="errors.phone_n" class="error invalid-feedback">{{errors.phone_n[0]}}</span>
                                    </div>                                                                    
                                </div>
                                                           
                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input v-model="form.email_t" type="text" name="email_t" class="form-control" :class="{ 'is-invalid': errors.email_t }" >
                                         <!-- <div class="alert alert-danger" v-if="errors.email_t"> {{errors.email_t[0]}}</div> -->
                                         <span v-if="errors.email_t" class="error invalid-feedback">{{errors.email_t[0]}}</span>
                                    </div>  
                                </div>


                                

                                                              
                            </div>
                            <div class="row" v-show="form.client_type_n == 2">

                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Contract Number</label>
                                        <input v-model="form.contract_number_n" type="text" name="contract_number_n" class="form-control" :class="{ 'is-invalid': errors.contract_number_n }" >
                                         <!-- <div class="alert alert-danger" v-if="errors.contract_number_n"> {{errors.contract_number_n[0]}}</div> -->
                                         <span v-if="errors.contract_number_n" class="error invalid-feedback">{{errors.contract_number_n[0]}}</span>
                                    </div>  
                                </div> 
                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Vat Number</label>
                                        <input v-model="form.vat_number_t" type="text" name="vat_number_t" class="form-control" :class="{ 'is-invalid': errors.vat_number_t }" >
                                         <!-- <div class="alert alert-danger" v-if="errors.vat_number_t"> {{errors.vat_number_t[0]}}</div> -->
                                         <span v-if="errors.vat_number_t" class="error invalid-feedback">{{errors.vat_number_t[0]}}</span>
                                    </div>  
                                </div>

                               <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Person Title</label>
                                        <input v-model="form.person_title" type="text" name="person_title" class="form-control" :class="{ 'is-invalid': errors.person_title }" >
                                         <!-- <div class="alert alert-danger" v-if="errors.person_title"> {{errors.person_title[0]}}</div> -->
                                         <span v-if="errors.person_title" class="error invalid-feedback">{{errors.person_title[0]}}</span>
                                    </div>  
                                </div> 
                                <div class="col-md-2">                                   
                                    <div class="form-group">
                                        <label>Person Name</label>
                                        <input v-model="form.person_name_t" type="text" name="person_name_t" class="form-control" :class="{ 'is-invalid': errors.person_name_t }" >
                                         <!-- <div class="alert alert-danger" v-if="errors.person_name_t"> {{errors.person_name_t[0]}}</div> -->
                                         <span v-if="errors.person_name_t" class="error invalid-feedback">{{errors.person_name_t[0]}}</span>
                                    </div>  
                                </div> 
                                                                 
                            </div>

                            <div class="row">  
                            <div class="col-md-3">                                   
                                    <div class="form-group">
                                        <label>Contract Start</label>
                                        <Datepicker format="YYYY-MM-DD" v-model="form.contract_start_t" :class="{ 'is-invalid': errors.contract_start_t }" />                                       
                                         <!-- <div class="alert alert-danger" v-if="errors.contract_start_t"> {{errors.contract_start_t[0]}}</div> -->
                                         <span v-if="errors.contract_start_t" class="error invalid-feedback">{{errors.contract_start_t[0]}}</span>
                                    </div>  
                                </div> 
                                <div class="col-md-3">                                   
                                    <div class="form-group">
                                        <label>Contract End</label>  
                                        <Datepicker format="YYYY-MM-DD" v-model="form.contract_end_t" :class="{ 'is-invalid': errors.contract_end_t }"  />
                                        <!-- <div class="alert alert-danger" v-if="errors.contract_end_t"> {{errors.contract_end_t[0]}}</div> -->
                                        <span v-if="errors.contract_end_t" class="error invalid-feedback">{{errors.contract_end_t[0]}}</span>
                                    </div>  
                                </div> 
                                <div class="col-md-3">                                   
                                    <div class="form-group">
                                        <label>Reccurence</label>   
                                        <select v-model="form.reccurence_id_n" name="reccurence_id_n" class="form-control" :class="{ 'is-invalid': errors.reccurence_id_n }">
                                            <option v-for="rec in reccurences" :value="rec.id">{{rec.title}}</option>
                                        </select>                                        
                                        <!-- <div class="alert alert-danger" v-if="errors.reccurence_id_n"> {{errors.reccurence_id_n[0]}}</div> -->
                                        <span v-if="errors.reccurence_id_n" class="error invalid-feedback">{{errors.reccurence_id_n[0]}}</span>
                                    </div>  
                                </div>   

                            </div>        
                            <div class="row">                               
                                <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" type="text" name="description" class="form-control" :class="{ 'is-invalid': errors.description }" ></textarea>
                                         <!-- <div class="alert alert-danger" v-if="errors.description"> {{errors.description[0]}}</div> -->
                                         <span v-if="errors.description" class="error invalid-feedback">{{errors.description[0]}}</span>
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
                                            track-by="title_t">
                                            </multiselect>
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
    import RecordsRepository from "../../repositories/RecordsRepository.vue";   

    export default {
        components: { Buttons, Datepicker, Multiselect, RecordsRepository },
       
        data () {
            return {
                model:'clients',                            
                ////////////////////////////////////////////////////////// 
                editMode: this.$route.meta.mode,
               
                form: { active:0,}, errors: {},                         
                //////////////////////////////////////////////////////////               
                photable_Type: "App\\Client", photable_Id: this.$route.params.id,                
                //
                datetime:'',date:'',
                //
                client_type:'',alllocations:[],reccurences: [],clienttype:'',clienttypes:[
                    {id: 1,name: 'Private' },
                    {id: 2,name: 'Company' },                            
                ],
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
                    this.locations =  res.data.form.locations //assigned locations                    
                } 
                this.reccurences =  res.data.reccurences
                this.alllocations =  res.data.alllocations //alllocations             
            },
            onSave() {
                this.$refs.RecordsRepo.onSave(this.model,this.$route.params.id,this.form,this.$route.meta.mode) 
            }                               
  
        }
    }
</script>
 <style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
