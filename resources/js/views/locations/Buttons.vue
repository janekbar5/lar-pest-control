<template>
<div>

<!----------------LIST------------------------> 
<router-link v-show="editMode==='create' || editMode==='view' || editMode==='edit'" :to="{path: this.modelSettings.urlList}" class="btn btn-primary">
    <i aria-hidden="true" class="fa fa-list"></i> Back to list
</router-link>

<!----------------EDIT-------------------------> 
<router-link v-show="editMode==='view'" :to="{path: this.modelSettings.urlEdit+this.modelId+'/edit'}" class="btn btn-info">
     <i aria-hidden="true" class="fa fa-pen"></i> Edit
</router-link>


<!----------------NEW-------------------------> 
<router-link v-show="editMode==='list'" :to="{path: this.modelSettings.urlCreate}" class="btn btn-primary"> New {{modelSettings.modelSingular}} </router-link>

<!----------------SAVE-------------------------> 
<button v-show="editMode==='edit' || editMode==='create'" class="btn btn-success" @click="onSave">Save</button>
<!-- <button v-show="editMode==='edit'" class="btn" @click="onCancel">Cancel</button> -->
<!----------------DELETE-------------------------> 
<button v-show="editMode==='edit'" class="btn btn-danger" @click="onDelete">Delete</button>


</div>
</template>

<script>
module.exports = {
  props: {        
        editMode: { required: true },
  },  
  //
  data: function () {   
    return {         
      modelSettings: {
        modelPlural: 'locations', modelSingular: 'Location', 
        urlList:'/locations',
        urlCreate:'/locations/create',
        urlEdit:'/locations/',
        apiList:'/v1/api/locations/index',
        apiCreate:'/v1/api/locations/create',
        apiEdit:'/v1/api/locations/edit/',       
        apiUpdate:'/v1/api/locations/update/',     
        apiDelete:'/v1/api/locations/delete/'
      },
      modelId: this.$route.params.id,
    }
  },
  //
  mounted() {
    this.renderSettings()
  },
  //
  methods: {
    onSave(){
        this.$parent.onSave();
    },
    onCancel(){
        this.$parent.onCancel();
    },
    onDelete(){
        this.$parent.onDelete();
    },

    renderSettings(){
      this.$eventHub.$emit('settings', this.modelSettings);
    }   
  }
}
</script>

