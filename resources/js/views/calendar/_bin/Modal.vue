<template> 
 <div>


 <div class="modal fade" id="addNew" data-keyboard="false"  data-backdrop="static" @mouseover="getValues">
                    <div class="modal-dialog modal-xl">

                        <form @submit.prevent="onSave()">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="addNewLabel">
                                    <!-- freefieldusers:{{freefieldusers}}  -->                                    
                                </h5>
                            </div>

                            
                                <div class="modal-body">
                                   
                                    <div class="col-12 col-sm-12 col-lg-12">

                                        <div class="card card-primary card-tabs">
                                            <div class="card-header p-0 pt-1">
                                              
                                            </div>
                                            <div class="card-body">
                                             //start {{ start }}
                                             <input type="text" id="start" value="" ref="start"></br>
                                             <input type="text" id="end" value="" ref="end"></br>
                                             <input type="text" id="itemid" value="" ref="itemid"></br>
                                             <input type="text" id="title" value="" ref="title"></br> 

                                              <input type="text" id="price" value="" ref="price"></br> 
                                              <input type="text" id="location_id" value="" ref="location_id"></br> 
                                              <input type="text" id="status_id" value="" ref="status_id"></br> 

                                            </div>

                                        </div>
                                        <div class="row">
                                            Day {{day}}
                                             <div class="col-md-2">                                   
                                                <div class="form-group">
                                                    <label>Location</label>
                                                    <input v-model="form.location_id" type="text" name="location_id" class="form-control" :class="{ 'is-invalid': errors.location_id }" >                                                      
                                                    <div class="alert alert-danger" v-if="errors.location_id"> {{errors.location_id[0]}}</div>
                                                </div>  
                                            </div> 

                                            <div class="col-md-2">                                   
                                                <div class="form-group">
                                                    <label>start</label>
                                                    <input v-model="form.start" type="text" name="start" class="form-control" :class="{ 'is-invalid': errors.start }" >                                                    
                                                    <div class="alert alert-danger" v-if="errors.start"> {{errors.start[0]}}</div>
                                                </div>  
                                            </div> 
                                            <div class="col-md-2">                                   
                                                <div class="form-group">
                                                    <label>end</label>
                                                    <input v-model="form.end" type="text" name="end" class="form-control" :class="{ 'is-invalid': errors.end }" >                                                      
                                                    <div class="alert alert-danger" v-if="errors.end"> {{errors.end[0]}}</div>
                                                </div>  
                                            </div> 


                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">                                   
                                            <div class="form-group">
                                                <label>Assigned Users</label> 
                                                <!-- @tag="addTag2" -->                                     
                                                <multiselect 
                                                v-model="form.selected_users" 
                                                :options="freefieldusers"
                                                :custom-label="nameWithNameLastName"                                                                                         
                                                placeholder="Select users"
                                                :multiple="true"                                            
                                                label="name" 
                                                track-by="name"></multiselect>
                                                <!-- :custom-label="nameWithSuename"  -->
                                        </div> 
                                        <div class="alert alert-danger" v-if="errors.selected_users"> {{errors.selected_users[0]}}</div> 
                                        </div> 
                                    </div>

                                   
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-danger" @click="onSave()">onSave</button> -->
                                    <button type="button" class="btn btn-danger" @click="hideModal()">Close</button> 
                                    <button type="submit" class="btn btn-primary">Create</button>
                                    
                                </div>
                           

                        </div>
                        </form>



      </div>

 </div> 



  </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import moment from 'moment'
import {get, byMethod } from '../../lib/api'
export default {
  name: 'Modal',
  props: {        
        //locationdata: {},
        //freefieldusers:{},
  }, 
//   props: {
//     locationdata: Object,
//     freefieldusers: Array,    
//   }, 
  components: { Multiselect },
  data: function () {       
    return {
      item_id:'',
      counter: 0,
      freefieldusers:[], //dont need allPermissions in form only selected
      errors: {},
      day:'',
      start:'', end:'',
      form:{
           start:'', end:'',
      },
    }
  },
  mounted() { 
      //console.log(this.$refs.start)
      //this.freefieldusers = [ {"id":1,"name":"Jan","last_name": "Dan"},{"id":2,"name":"Jan 2","last_name": "Dan 2"} ]
      
  },

  methods: {
    getValues(){ 
      this.counter++  
      if(this.counter == 1){
      this.form.start = this.$refs.start.value
      this.form.end = this.$refs.end.value 
      this.item_id = this.$refs.itemid.value
      this.form.title = this.$refs.title.value
      this.form.location_id = this.$refs.itemid.value


      this.day = moment(String(this.$refs.start.value)).format('YYYY-MM-DD')
      
      console.log('getValues') 
        axios.get('/v1/api/tasks/gettasksbydate?date='+this.day).then((res) => {
        if(res.data) {       
            this.setTasksByDate(res)
        }})
        .catch((error) => {
          if(error.res.status === 422) {
            //this.errors = error.res.errors
            console.log('422')
          }
        this.isProcessing = false
      })   
      }else{

      }

    },  
     setTasksByDate(res) {       
      this.freefieldusers = res.data.freefieldusers    
      //console.log( this.freefieldusers) 
    }, 
    hideModal(){      
      var person = {itemid:this.$refs.itemid.value, content:this.$refs.title.value};   
      this.$parent.hideModal(person);
      //console.log()
    },
    setData(res) {                 
        //this.photos_List = res.data.form.photos;
        //this.allFieldUsers =  res.data.fieldusers //all roles        
    }, 
    nameWithNameLastName ({ name, last_name }) {
        return `${name} ${last_name}`
    },
    onSave() {
        this.$parent.onSave()
        //this.errors = {}
        //this.isProcessing = true                
        // axios.post('/v1/api/tasks/updatefromcalendar/'+this.item_id, this.form)
        //     .then((res) => {
        //          if(res.saved) {
        //                     this.success(res)
        //                     this.loadToast('success',''+this.modelSingular+' updated successfully'); 
        //                     this.$parent.hideModal(person={}); 
        //          }
                 
        //         })
        //         .catch((error) => {
        //                 if(error.res.status === 422) {
        //                     this.errors = error.response.data.errors
        //                     this.loadToast('error','Check the forms'); 
        //                 }
        //                 this.isProcessing = false
        //         })
    },  
    onSave() {
       this.errors = {} 
       byMethod('POST', '/v1/api/tasks/updatefromcalendar/'+this.item_id, this.form)
        .then((res) => {
           if(res.data && res.data.saved) {
            this.success(res)
          }
        })
        .catch((error) => {
          if(error.response.status === 422) {
            this.errors = error.response.data.errors
          }
          //this.isProcessing = false
        }) 
    }, 
    loadToast(icon,text){
       toast.fire({icon: icon,title: text })
   }, 
    
    
    
    }//meth
}
</script>