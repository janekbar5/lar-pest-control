
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
              <p>One fine body…</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" @click="hideModal()">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
    
    }
}
</script>      