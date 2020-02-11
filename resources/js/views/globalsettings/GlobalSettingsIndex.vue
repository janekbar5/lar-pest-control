<template>
    <div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">         
          <div class="col-md-6">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Treatments</h3> 
                <div class="card-tools">                  
                    <div class="input-group-append">
                     <button  class="btn btn-secondary" @click="showModal()" >Add New Treatment</button> 
                    </div>                 
                </div>
              </div>
              
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 10%">#</th>
                      <th style="width: 70%">Task</th>
                      <th style="width: 10%">Label</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="treat in treatments" :key="treat.data"> 
                      <td>{{treat.id}}</td>
                       <td>{{treat.title}}</td>
                     
                      <td><span class="badge ">
                          <i aria-hidden="true" class="fa fa-pen" @click="showModal()"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                         <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(treat)"></i> 
                          </span>
                          </td>
                    </tr>
                   

                 
                  </tbody>
                </table>
              </div>

              <div class="card-tools">
                  <!-- <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                  </ul> -->
                </div>
            
            </div>
          
          </div>
       


        <ModalTreatment  />



         <div class="col-md-6">


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Task Statuses</h3>                
              </div>
              
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 10%">#</th>
                      <th style="width: 30%">Task</th>
                      <th style="width: 30%">Colour</th>
                      <th style="width: 10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="status in statuses" :key="status.data"> 
                      <td>{{status.id}}</td>
                      <td>{{status.title}}</td>
                      <td><span v-bind:style="{ 'background-color': status.colour }">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                      <td><span class="badge ">
                         <i aria-hidden="true" class="fa fa-pen" ></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                         <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(item)"></i> 
                          </span>
                          </td>
                    </tr>
                   
                   

                 
                  </tbody>
                </table>
              </div>

              <div class="card-tools">
                  <!-- <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                  </ul> -->
                </div>
              
            </div>


                     <div class="card">
              <div class="card-header">
                <h3 class="card-title">Subtatuses</h3>                
              </div>
              
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 10%">#</th>
                      <th style="width: 30%">Parent Status</th>
                      <th style="width: 30%">Substatus</th>
                      <th style="width: 10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="sub in substatuses" :key="sub.data"> 
                      <td>{{sub.id}}</td>
                       <td>{{sub.title}}</td>
                      <td>{{sub.status.title}}</td>
                     
                     
                      <td><span class="badge ">
                         <i aria-hidden="true" class="fa fa-pen" ></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                         <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(item)"></i> 
                          </span>
                          </td>
                    </tr>
                           
                  </tbody>
                </table>
              </div>

              <div class="card-tools">
                  <!-- <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                  </ul> -->
                </div>
              
            </div>
           
         
          </div>
        </div>
       


            <!----------------------- Modal ------------------------------------>
            <!-- <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateUser() : createUser()">
                <div class="modal-body">
                     <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                            placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="form.email" type="email" name="email"
                            placeholder="Email Address"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                     <div class="form-group">
                        <textarea v-model="form.bio" name="bio" id="bio"
                        placeholder="Short bio for user (Optional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio"></has-error>
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
            </div> -->
            <!----------------------- Modal ------------------------------------>

       
        
        
       
      </div>
    </section>
        
    </div>
</template>


<script type="text/javascript">
import Vue from 'vue'
import { get, byMethod } from '../../lib/api'
import {isEmpty} from "lodash"
import Buttons from './Buttons'
import ModalTreatment from './ModalTreatment.vue' 

export default {
    components: { Buttons, ModalTreatment },
data () {
return {
    //editmode: false,
    url:'',
    settings: {},
    urlList: '',
    urlEdit: '',
    apiList: '',
    //    
    editMode: this.$route.meta.mode,
    treatments:{},statuses:{},substatuses:{},
    model: {
        // urlList:'',
        // data: []
    },
    // form: new Form({
    //     id:'',
    //     name : '',
    //     email: '',
    //     password: '',
    //     type: '',
    //     bio: '',
    //     photo: ''
    // }),
    
}
},
//
beforeRouteEnter(to, from, next) {    
    get('/v1/api/home/globalsettings')
        .then((res) => {
            next(vm => vm.setData(res))
        })
},
//
beforeRouteUpdate(to, from, next) {
    get('/v1/api'+to.path+'/index', to.query)
        .then((res) => {
            this.setData(res)
            next()
    })
},
//
created() {
    this.$eventHub.$on('settings', this.modelSettings) 
},
beforeDestroy(){
    //this.$eventHub.$off('settings');
},
//
methods: {
    modelSettings(settings){
        //return name
        this.settings = settings;
        this.urlList = settings.urlList
        this.urlEdit = settings.urlEdit
        //
        this.apiList = settings.apiList
        this.apiDelete = settings.apiDelete
        //console.log(settings)  
    },
    showModal() {
         $("#tasksModal").modal("show")  
        //this.$router.push(this.urlList+'/'+item.id+'/edit')
    },
    newModal(){
        this.editmode = false;
        this.form.reset();
        $('#addNew').modal('show');
    },


    hideModal(per){
      $("#tasksModal").modal("hide")
    //    $('#calendar').fullCalendar('removeEvents', per.itemid)     
    //   this.unassignedtasks.push({
    //     title: per.content,
    //     start: '2015-11-20T08:30:00',
    //     end: '2015-11-20T08:30:00',
    //     statuses:'',
    //     color: '#C2185B',
    //     locations:'',
    //   });
    },
    modelView(item) {        
        this.$router.push(this.urlList+'/'+item.id)
    },
   
    setData(res) {
        //Vue.set(this.$data, 'model', res.data)
        this.treatments = res.data.treatments
        this.statuses = res.data.statuses.data
        this.substatuses = res.data.substatuses.data
        //console.log(res.data)
    },
    nextPage() {
        if(this.model.next_page_url) {
            //console.log(this.model.next_page_url)
            const query = Object.assign({}, this.$route.query)
            query.page = query.page ? (Number(query.page) + 1) : 2

            this.$router.push({
                path: this.urlList,
                query: query
            })
        }
    },
    prevPage () {
        if(this.model.prev_page_url) {
            const query = Object.assign({}, this.$route.query)
            query.page = query.page ? (Number(query.page) - 1) : 1

            this.$router.push({
                path: this.urlList,
                query: query
            })
        }
    },
    checkThis(cos) {
    return photo
    },
    getApi(url){
        get(url)
        .then((res) => {
            this.setData(res)                   
        })
    },
    modelDelete(item){
        swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        // Send request to the server
        if (result.value) {
            byMethod('delete','v1/api/treatments/delete/'+item.id).then(()=>{
            swal.fire('Deleted!','Your file has been deleted.','success')
            //this.getApi('this.apiList+'?page='+this.page')  
            this.$router.push('/globalsettings') 
                                                
        }).catch(()=> {
            swal.fire("Failed!", "There was something wronge.", "warning");
            });
        }
        })
    },



    }
}
</script>
