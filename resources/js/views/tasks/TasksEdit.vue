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
                            <!-- <h3 class="card-title">Quick Example {{ editMode }} </h3> -->
                            <!-- <Buttons :editMode="editMode" ></Buttons> -->
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
                                        <typeahead :url="dataURL" :initialize="form.locations" @input="onLocation" />                                      
                                        <input v-model="form.location_id" type="hidden" name="location" class="form-control" :class="{ 'is-invalid': errors.location_id }" >
                                         <div class="alert alert-danger" v-if="errors.location_id"> {{errors.location_id[0]}}</div>
                                    </div>                                                                    
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input v-model="form.title_t" type="text" name="title_t" class="form-control" :class="{ 'is-invalid': errors.title_t }" >
                                         <div class="alert alert-danger" v-if="errors.title_t"> {{errors.title_t[0]}}</div>
                                    </div>                                                                    
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input v-model="form.price_n" type="text" name="price_n" class="form-control" :class="{ 'is-invalid': errors.price_n }" >
                                         <div class="alert alert-danger" v-if="errors.price_n"> {{errors.price_n[0]}}</div>
                                    </div>                                                                    
                                </div>

                                
                            </div>
                            <div class="row">
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start</label>                                        
                                        <Datepicker format="YYYY-MM-DD H:i" v-model="form.start_t" class="" :class="{ 'is-invalid': errors.start_t }"  />
                                         <div class="alert alert-danger" v-if="errors.start_t"> {{errors.start_t[0]}}</div>
                                    </div>                                                                    
                                </div>
                                                           
                                <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>End</label>                                        
                                         <Datepicker format="YYYY-MM-DD H:i" v-model="form.end_t" class="" :class="{ 'is-invalid': errors.end_t }" />
                                         <div class="alert alert-danger" v-if="errors.end_t"> {{errors.end_t[0]}}</div>
                                    </div>  
                                </div>
                                <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>Last Service</label>                                      
                                         <Datepicker format="YYYY-MM-DD H:i" v-model="form.last_service_t" class="" :class="{ 'is-invalid': errors.last_service_t }" />
                                         <div class="alert alert-danger" v-if="errors.last_service_t"> {{errors.last_service_t[0]}}</div>
                                    </div>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Assigned Users</label>                                                                          
                                        <multiselect 
                                        v-model="form.users" 
                                        :options="allAvailableFieldUsers"
                                        :custom-label="nameWithSuename"                                          
                                        placeholder="Select users"
                                        :multiple="true"                                       
                                        label="name" 
                                        track-by="name"
                                        :class="{ 'is-invalid': errors.users }"
                                        ></multiselect>
                                         <div class="alert alert-danger" v-if="errors.users"> {{errors.users[0]}}</div>
                                  </div>  
                                </div> 
                            </div>

                            <div class="row"> </div>
                           <div class="row">                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label>Status</label>
                                            <select v-model="form.status_id_n" class="form-control"  :class="{ 'is-invalid': errors.status_id_n}">
                                            <option value="">Select Status</option>
                                            <option v-for="status in statuses" :value="status.id">
                                                {{status.title}}
                                            </option>
                                            </select>                                        
                                            <div class="alert alert-danger" v-if="errors.status_id_n"> {{errors.status_id_n[0]}}</div>
                                    </div>
                                  </div>   
                                
                                <div class="col-md-4" v-show="form.status_id_n == 3">
                                    <div class="form-group">
                                    <label>Sub Status</label>
                                            <select v-model="form.substatus_id_n" class="form-control"  :class="{ 'is-invalid': errors.substatus_id_n}">
                                            <option value="">Select Sub Status</option>
                                            <option v-for="substatus in substatuses" :value="substatus.id">
                                                {{substatus.title}}
                                            </option>
                                            </select>                                        
                                            <div class="alert alert-danger" v-if="errors.substatus_id_n"> {{errors.substatus_id_n[0]}}</div>
                                    </div>
                                  </div>   
                               
                            </div>
                         
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="label">Treatment List</label>
                                        <br>
                                        <div class="icheck-danger d-inline">
                                            <div v-for="treat in allTreatments" style="border:solid 0px red;width:300px;float:left">
                                                <input :value="treat.id" v-model="form.selectedTreatments" type="checkbox" :disabled="treat.deleted_at !== null"/> {{treat.title}}
                                            </div>
                                            <br>
                                        </div>
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
    import moment from 'moment'
    import {get, byMethod } from '../../lib/api'
    import {Typeahead } from '../../components/typeahead'
    import DzoneComponent from '../../components/dzone/DzoneComponent'
    import Buttons from '../../components/buttons/Buttons'
    import Multiselect from 'vue-multiselect' 
    import Datepicker from 'vuejs-datetimepicker'
    import RecordsRepository from '../../repositories/RecordsRepository.vue'
    export default {
        components: { DzoneComponent, Buttons, Multiselect, Datepicker, Typeahead, RecordsRepository },
        data () {
            return {
                model:'tasks',                              
                // 
                editMode: this.$route.meta.mode,
                form: {                  
                   status_id: this.$route.meta.mode==="edit" ? '' : 1,                   
                   start: this.$route.meta.mode==="edit" ? '' : '',
                   end: this.$route.meta.mode==="edit" ? '' : '',                   
                },               
                errors: {},               
                //
                photable_Type: "App\\Task", photable_Id: this.$route.params.id, photos_List: [],
                //
                roles: null, allroles: [], statuses:[], substatuses:[],
                //
                dataURL: '/v1/api/locations/searchlocations',               
                selected_users:[], allAvailableFieldUsers:[], grantedTreatments:[], selectedTreatments:[], allTreatments:[], 
                //               
                newStart:'', newEnd:'',
               
            }
        },
        beforeRouteEnter(to, from, next) {           
            get('/v1/api'+to.path).then((res) => {  next(vm => vm.setData(res))  })
        },        
        
        watch: {
            'form.start_t': function(newVal1) {                
                this.newStart = newVal1
                this.Search()  
            },
            'form.end_t': function(newVal2) { 
                this.newEnd = newVal2
                this.Search()            
                },
        },       
        methods: {           
            Search(){
            if (this.newStart && this.newEnd ) {
                //console.log('value changed from ' + this.newStart + this.newEnd );
                axios.get('/v1/api/tasks/getfreefieldusersfordate?start_t='+this.newStart+'&end_t='+this.newEnd)
                    .then((res) => {                      
                    this.setFreeUser(res) 
                })   
            }
            },
            onLocation(e) {
                const locations = e.target.value
                Vue.set(this.$data.form, 'locations', locations) 
                Vue.set(this.$data.form, 'location_id', locations.id) 
                Vue.set(this.$data.form, 'price', locations.price)                
                this.grantedTreatments = locations.treatments
                this.objectToArray();                                         
            },
            setFreeUser(res){
                this.allAvailableFieldUsers = res.data.allAvailableFieldUsers
            },
            setData(res) { 
                if(this.$route.meta.mode === 'edit') {
                    Vue.set(this.$data, 'form', res.data.form)
                    this.store = this.apiUpdate + this.$route.params.id                                      
                    this.roles =  res.data.form.roles //assigned roles                   
                    this.photos_List = res.data.form.photos;
                    this.grantedTreatments = res.data.form.locations.treatments
                }
                this.photos_List = res.data.form.photos               
                this.allAvvailableFieldUsers =  [] //all roles 
                this.statuses =  res.data.statuses //all roles
                this.substatuses =  res.data.substatuses.data //all roles
                this.allTreatments = res.data.alltreatments
                this.objectToArray();
            }, 
            objectToArray() {                
                var treatment_array = [];               
                this.grantedTreatments.forEach(element => {
                    treatment_array.push(element.id);
                });
                this.form.selectedTreatments = treatment_array;
            },   
            nameWithSuename ({ name_t, last_name_t }) {
                return `${name_t} ${last_name_t}`
            },             
            onSave() {
                this.$refs.RecordsRepo.onSave(this.model,this.$route.params.id,this.form,this.$route.meta.mode) 
            } 
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>