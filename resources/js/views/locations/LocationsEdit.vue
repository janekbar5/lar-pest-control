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
                            
                        </div>
                        
                        <div class="card-body">
                            
                            <div class="row">   
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input v-model="form.title_t" type="text" name="title_t" class="form-control" :class="{ 'is-invalid': errors.title_t }" >
                                         <div class="alert alert-danger" v-if="errors.title_t"> {{errors.title_t[0]}}</div>
                                    </div>                                                                    
                                </div>
                                                           
                              
                                <div class="col-md-4">                                   
                                        <div class="form-group">
                                            <label>Surface Area</label>
                                            <input v-model="form.surface_n" type="text" name="surface_n" class="form-control" :class="{ 'is-invalid': errors.surface_n }" >
                                            <div class="alert alert-danger" v-if="errors.surface_n"> {{errors.surface_n[0]}}</div>
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
                            <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" type="text" name="description" class="form-control" :class="{ 'is-invalid': errors.description }" >
                                        </textarea>
                                         <div class="alert alert-danger" v-if="errors.description"> {{errors.description[0]}}</div>
                                    </div>  
                                </div> 
                            </div>    


                             <div class="row">
                                <div class="col-md-12">                                   
                                    <div class="form-group">
                                        <label>Clients</label>      
                                            <multiselect 
                                            v-model="form.clients" 
                                            :options="allclients"
                                            :custom-label="nameWithNameLastName"                                                                                         
                                            placeholder="Select clients"
                                            :multiple="true"                                            
                                            label="person_name_t" 
                                            track-by="person_name_t">
                                            </multiselect>
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
                            </br>  </br>  </br>

                   

                          errors {{ errors }}
                            <div class="row">
                               <div class="col-md-3">
                               <div class="form-group">
                                        <label>Address 1</label>
                                        <input v-model="form.address_line1" type="text" name="address_line1" class="form-control" :class="{ 'is-invalid': errors.address_line1 }" >
                                        <div class="alert alert-danger" v-if="errors.address_line1"> {{errors.address_line1[0]}}</div>
                                </div> 
                                </div> 

                                 <div class="col-md-3">
                               <div class="form-group">
                                        <label>Address 2</label>
                                        <input v-model="form.address_line2" type="text" name="address_line2" class="form-control" :class="{ 'is-invalid': errors.address_line2 }" >
                                        <div class="alert alert-danger" v-if="errors.address_line2"> {{errors.address_line2[0]}}</div>
                                </div> 
                                </div> 


                                <div class="col-md-3">
                                 <div class="form-group">
                                        <label>City</label>
                                        <input v-model="form.city" type="text" name="city" class="form-control" :class="{ 'is-invalid': errors.city }" >
                                         <div class="alert alert-danger" v-if="errors.city"> {{errors.city[0]}}</div>
                                </div> 
                                </div>

                                <div class="col-md-3">
                                 <div class="form-group">
                                        <label>Postcode</label>
                                        <input v-model="form.postcode" type="text" name="postcode" class="form-control" :class="{ 'is-invalid': errors.postcode }" >
                                         <div class="alert alert-danger" v-if="errors.postcode"> {{errors.postcode[0]}}</div>
                                </div> 
                                </div>

                        </div>



                            <div class="row">
                  
                                <div class="col-md-3">
                                    <input v-model="form.lat" type="text" class="form-control" id="latitude" placeholder="Latitude" disabled>
                                </div>
                                <div class="col-md-3">
                                    <input v-model="form.lng" type="text" class="form-control" id="longitude" placeholder="Longitude" disabled>
                                </div>

                                <div class="col-md-3">                                  
                                   <button id="target2" @click="searchLocation2()" class="btn btn-secondary">Search Location...</button>
                                </div>
                            </div>

                            <LocationPicker ref="LocationPicker" v-if="isMounted" :lat="lat" :lng="lng" @update-location="updateLocation"> </LocationPicker>
                                    
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
    import LocationPicker from '../../components/locationpicker/LocationPicker3'  
    import Multiselect from 'vue-multiselect'
    import RecordsRepository from '../../repositories/RecordsRepository.vue'
    export default {
        components: {  Buttons, Multiselect, LocationPicker, RecordsRepository },
        data () {
            return {
                model:'locations', 
                editMode: this.$route.meta.mode,     
                lat:'',lng:'',
                isMounted: false,           
                //////////////////////////////////////////////////////////                 
                form: {
                    address:{address_line1:'',},
                    clients:[],                    
                },                
                errors: {                   
                },     
                            
                //////////////////////////////////////////////////////////                
                grantedTreatments:[], allTreatments:[], allclients:[],
            }
        },
        beforeRouteEnter(to, from, next) {            
            get('/v1/api'+to.path)
                .then((res) => { next(vm => vm.setData(res))  })
        },       
        methods: {
            nameWithNameLastName ({ person_name_t  }) {
                    return `${person_name_t}`
             },           
            updateLocation(itm) {             
               Vue.set(this.form, 'lat', itm.lat) 
               Vue.set(this.form, 'lng', itm.lng)               
            },
             searchLocation2(){
              var city = this.form.city
              var address_line1 = this.form.address_line1
              //var address_line2 = this.form.address.address_line2
              //var text = string.concat(city)
              this.$refs.LocationPicker.searchLocation2(city);
            },           
            setData(res) { 
                if(this.$route.meta.mode === 'edit') {
                    Vue.set(this.$data, 'form', res.data.form)
                    this.grantedTreatments = res.data.form.treatments                    
                    this.lat = res.data.form.lat
                    this.lng = res.data.form.lng              
                    this.isMounted = true
                } 
                this.isMounted = true
                var itm;
                this.updateLocation(itm = {lat:40.446947, lng:13.004})
                this.allTreatments = res.data.alltreatments  
                this.allclients = res.data.allclients    
                this.objectToArray();            
            }, 
            objectToArray() {                
                var treatment_array = [];               
                this.grantedTreatments.forEach(element => {
                    treatment_array.push(element.id);
                });
                this.form.selectedTreatments = treatment_array;
            },         
            onSave() {
                this.$refs.RecordsRepo.onSave(this.model,this.$route.params.id,this.form,this.$route.meta.mode)                 
            } 
           
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>