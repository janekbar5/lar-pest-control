<template> 
 <div>


 <div class="modal fade" id="addNew" data-keyboard="false" data-backdrop="static" @mouseover="getValues">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="addNewLabel">locationdata:{{locationdata}}</h5>

                            </div>

                            
                                <div class="modal-body">
                                    <div class="col-12 col-sm-12 col-lg-12">

                                        <div class="card card-primary card-tabs">
                                            <div class="card-header p-0 pt-1">
                                              
                                            </div>
                                            <div class="card-body">
                                             //start {{ start }}
                                             Start<input id="start" value="" ref="start"></br>
                                             End<input id="end" value="" ref="end"></br>
                                             itemid<input  id="itemid" value="" ref="itemid"></br>
                                             content<input  id="title" value="" ref="title"></br> 
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">                                   
                                                <div class="form-group">
                                                    <label>start</label>
                                                    <input v-model="form.start" type="text" name="start" class="form-control" :class="{ 'is-invalid': errors.start }" >                                                    
                                                    <div class="alert alert-danger" v-if="errors.start"> {{errors.start[0]}}</div>
                                                </div>  
                                            </div> 
                                            <div class="col-md-12">                                   
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
                                        </div> 
                                    </div>

                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" @click="onSave()">onSave</button>
                                    <button type="button" class="btn btn-danger" @click="hideModal()">Close</button>
                                    
                                </div>
                           

                        </div>

      </div>

 </div> 



  </div>
</template>
<script>
import Multiselect from 'vue-multiselect'

export default {
  name: 'Modal',
//   props: {        
//         locationdata: { required: true },
//         freefieldusers:{},
//   }, 
  props: {
    locationdata: Object,
    freefieldusers: Object,    
  }, 
  components: { Multiselect },
  data: function () {       
    return {
      item_id:'',
      //freefieldusers:[], //dont need allPermissions in form only selected
      errors: {},
      start:'', end:'',
      form:{
           start:'', end:'',
      },
    }
  },
  mounted() { 
      //console.log(this.$refs.start)
      
  },

  methods: {
    getValues(){
      this.form.start = this.$refs.start.value
      this.form.end = this.$refs.end.value 
      this.item_id = this.$refs.itemid.value
      this.form.title = this.$refs.title.value
      console.log('getValues') 
    },  
    hideModal(){      
      var person = {itemid:this.$refs.itemid.value, content:this.$refs.content.value};   
      this.$parent.hideModal(person);
      console.log(person)
    },
    setData(res) {                 
        //this.photos_List = res.data.form.photos;
        //this.allFieldUsers =  res.data.fieldusers //all roles        
    }, 
    nameWithNameLastName ({ name, last_name }) {
        return `${name} ${last_name}`
    },
    onSave() {
        //this.errors = {}
        //this.isProcessing = true                
        axios.post('http://www.lar-pest-control.test/v1/api/tasks/update/'+this.item_id, this.form)
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
    
    }
}
</script>