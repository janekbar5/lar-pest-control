<template>
<!-- <div style="position:fixed;z-index:10000"> -->
<div>
<!----------------LIST------------------------> 
<router-link v-show="editMode==='create' || editMode==='view' || editMode==='edit'" :to="{path: '/'+model}" class="btn btn-primary">
    <i aria-hidden="true" class="fa fa-list"></i> Back to list
</router-link>

<!----------------EDIT-------------------------> 
<router-link v-show="editMode==='view'" :to="{path: model+this.modelId+'/edit'}" class="btn btn-info">
     <i aria-hidden="true" class="fa fa-pen"></i> Edit
</router-link>


<!----------------NEW-------------------------> 
<router-link v-show="editMode==='list'" :to="{path: '/'+model+'/create'}" class="btn btn-primary"> <i aria-hidden="true" class="fa fa-pen"></i> New {{model}} </router-link>

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
        model: { required: true },
  },  
  //
  data: function () {   
    return {         
      // modelSettings: {
      //   modelPlural: 'tasks', modelSingular: 'Task', 
      //   urlList:'/tasks',
      //   urlCreate:'/tasks/create',
      //   urlEdit:'/tasks/',
      //   apiList:'/v1/api/tasks/index',
      //   apiCreate:'/v1/api/tasks/create',
      //   apiEdit:'/v1/api/tasks/edit/',       
      //   apiUpdate:'/v1/api/tasks/update/',     
      //   apiDelete:'/v1/api/tasks/delete/'
      // },
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

