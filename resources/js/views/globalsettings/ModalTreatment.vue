
<template>
  <div>
<div class="modal fade show" id="tasksModal" aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Default Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                  <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tratment</label>
                                        <input v-model="form.title" type="text" name="title" class="form-control" :class="{ 'is-invalid': errors.title }" >
                                         <div class="alert alert-danger" v-if="errors.title"> {{errors.title[0]}}</div>
                                    </div>                                                                    
                                </div>  
                    </div>                    
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" @click="hideModal()">Close</button>
              <button type="button" class="btn btn-primary" @click="onCreate()">Create</button>
              <button type="button" class="btn btn-primary" @click="onSave()">Save</button>
            </div>
          </div>
          
        </div>
       
      </div>
  </div>
</template>
<script>
//import Multiselect from 'vue-multiselect'

export default {
  name: 'Modal',
  props: {
   // locationdata: Object,
    //freefieldusers: Object,    
  }, 
  components: {  },
  data: function () {       
    return {
      item_id:'',     
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
    hideModal(){      
     // var person = {itemid:this.$refs.itemid.value, content:this.$refs.content.value};   
      this.$parent.hideModal();
      //console.log()
    },
     

    setData(res) { 
         
    }, 
    nameWithNameLastName ({ name, last_name }) {
        return `${name} ${last_name}`
    },
     loadToast(icon,text){
              toast.fire({icon: icon,title: text })
    }, 
     onCreate() {                    
        axios.post('http://www.lar-pest-control.test/v1/api/treatments/create', this.form)
            .then((res) => {
                 if(res.data && res.data.saved) {
                            this.hideModal()
                            this.loadToast('success','updated successfully');  
                 }
                 if(res.data && res.data.created) {
                            this.hideModal()
                            this.loadToast('success','created successfully');    
                }
                })
                // .catch((error) => {
                //         if(error.res.status === 422) {
                //             this.errors = error.response.data.errors
                //             this.loadToast('error','Check the forms'); 
                //         }
                //         this.isProcessing = false
                // })
            },         
    
    },
    onSave() {                    
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
   
    // success(res) {
    //             this.$router.push(this.urlList)                
    // },         
    
    
}
</script>      