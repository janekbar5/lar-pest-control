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
                                        <label>Title</label>
                                        <input v-model="form.title" type="text" name="title" class="form-control" :class="{ 'is-invalid': errors.title }" >
                                         <div class="alert alert-danger" v-if="errors.title"> {{errors.title[0]}}</div>
                                    </div>                                                                    
                                </div>
                                                           
                                <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input v-model="form.description" type="text" name="description" class="form-control" :class="{ 'is-invalid': errors.description }" >
                                         <div class="alert alert-danger" v-if="errors.description"> {{errors.description[0]}}</div>
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
                               <div class="col-md-3">
                               <div class="form-group">
                                        <label>Address 1</label>
                                        <input v-model="form.address.address_line1" type="text" name="address_line1" class="form-control" :class="{ 'is-invalid': errors.address_line1 }" >
                                        <div class="alert alert-danger" v-if="errors.address_line1"> {{errors.address_line1[0]}}</div>
                                </div> 
                                </div> 

                                 <div class="col-md-3">
                               <div class="form-group">
                                        <label>Address 2</label>
                                        <input v-model="form.address.address_line2" type="text" name="address_line2" class="form-control" :class="{ 'is-invalid': errors.address_line2 }" >
                                        <div class="alert alert-danger" v-if="errors.address_line2"> {{errors.address_line2[0]}}</div>
                                </div> 
                                </div> 


                                <div class="col-md-3">
                                 <div class="form-group">
                                        <label>City</label>
                                        <input v-model="form.address.city" type="text" name="city" class="form-control" :class="{ 'is-invalid': errors.city }" >
                                         <div class="alert alert-danger" v-if="errors.city"> {{errors.city[0]}}</div>
                                </div> 
                                </div>

                                <div class="col-md-3">
                                 <div class="form-group">
                                        <label>Postcode</label>
                                        <input v-model="form.address.post_code" type="text" name="post_code" class="form-control" :class="{ 'is-invalid': errors.post_code }" >
                                         <div class="alert alert-danger" v-if="errors.post_code"> {{errors.post_code[0]}}</div>
                                </div> 
                                </div>

                        </div>



                            <div class="row">
                  
                                <div class="col-md-3">
                                    <!-- <input type="text" class="form-control" id="address" placeholder="Address">    -->
                                    <!-- <input v-model="form.address.city1" type="text" class="form-control" id="city1" placeholder="city1">                                     -->
                                </div>

                                <div class="col-md-3">
                                    <input v-model="form.address.lat" type="text" class="form-control" id="latitude" placeholder="Latitude">
                                </div>
                                <div class="col-md-3">
                                    <input v-model="form.address.lng" type="text" class="form-control" id="longitude" placeholder="Longitude">
                                </div>

                                <div class="col-md-3">
                                   <button id="target2" @click="searchLocation2()" >Find Location</button>
                                </div>
                            </div>



                            <LocationPicker ref="LocationPicker" v-if="isMounted" :lat="lat" :lng="lng" @update-location="updateLocation"> </LocationPicker>
                                    
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
    //import DzoneComponent from '../../components/dzone/DzoneComponent';
    import Buttons from './Buttons';
    import LocationPicker from '../../components/locationpicker/LocationPicker3'  
    
    export default {
        components: {  Buttons, LocationPicker },
        data () {
            return {
                lat:'',lng:'',
                isMounted: false,
                apiList:'', apiCreate:'', apiEdit:'', apiCreate:'', apiUpdate:'',     
                //
                urlList:'', urlCreate:'', urlEdit:'',              
                ////////////////////////////////////////////////////////// 
                editMode: this.$route.meta.mode,
                form: {
                    address:[]
                },
                errors: {},                         
                //////////////////////////////////////////////////////////               
                //photable_Type: "App\\User",
                //photable_Id: this.$route.params.id,
                grantedTreatments:[], //dont need allPermissions in form only selected 
                allTreatments:[], //dont need allPermissions in form only selected 
                
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
            updateLocation(itm) {             
               Vue.set(this.form.address, 'lat', itm.lat) 
               Vue.set(this.form.address, 'lng', itm.lng)               
            },
             searchLocation2(){
              var city = this.form.address.city
              var address_line1 = this.form.address.address_line1
              //var address_line2 = this.form.address.address_line2
              //var text = string.concat(city)
              this.$refs.LocationPicker.searchLocation2(city);
            },
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
                    this.method = 'PUT'
                    this.title = 'Edit'
                    this.grantedTreatments = res.data.form.treatments 
                    this.lat = res.data.form.address.lat
                    this.lng = res.data.form.address.lng
              
                    this.isMounted = true
                } 
                this.isMounted = true
                var itm;
                this.updateLocation(itm = {lat:40.446947, lng:13.004})

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
                //this.$router.push('/properties/1')
                
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