
<template>
  <div>
      <div class="modal fade" id="treatmentModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateTreatment() : createTreatment()">
                <div class="modal-body">
                     <div class="form-group">
                        <input v-model="form.title" type="text" name="title"
                            placeholder="Title"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                        <has-error :form="form" field="title"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="form.id" type="text" name="id"
                            placeholder="id"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('id') }">
                        <has-error :form="form" field="id"></has-error>
                    </div>

                     <div class="form-group">
                        <textarea v-model="form.user_id" name="user_id" id="user_id"
                        placeholder="user_id"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('user_id') }"></textarea>
                        <has-error :form="form" field="user_id"></has-error>
                    </div>


                    <div class="form-group">
                        <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">Standard User</option>
                            <option value="author">Author</option>
                        </select>
                        <has-error :form="form" field="type"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.password" type="password" name="password" id="password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                </div>

                </form>

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
  
  }, 
  components: {  },
  data: function () {       
    return {      
      },
  }, 
  mounted() {
  },
  methods: {
  }    

    
}
</script>      