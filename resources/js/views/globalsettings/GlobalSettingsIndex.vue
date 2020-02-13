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
                     <button  class="btn btn-secondary" @click="newTreatment()" >Add New Treatment</button> 
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
                     
                      <!-- <td><span class="badge ">
                          <i aria-hidden="true" class="fa fa-pen" @click="showModal()"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                         <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(treat)"></i> 
                          </span>
                        </td> -->
                        <td>
                        <a href="#" @click="editTreatment(treat)">
                            <i class="fa fa-edit black"></i>
                        </a>
                        /
                        <a href="#" @click="deleteTreatment(treat)">
                            <i class="fa fa-trash black"></i>
                        </a>

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
       


        <!-- <ModalTreatment  /> -->



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
                      <!-- <td><span class="badge ">
                         <i aria-hidden="true" class="fa fa-pen" ></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                         <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(item)"></i> 
                          </span>
                          </td>
                        <td> -->
                        <td>    
                        <a href="#" @click="editStatus(status)">
                            <i class="fa fa-edit black"></i>
                        </a>
                        /
                        <a href="#" @click="deleteUser(status.id)">
                            <i class="fa fa-trash black"></i>
                        </a>
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
                      
                      <th style="width: 30%">Substatus</th>
                      <th style="width: 20%">Parent Status</th>
                      <th style="width: 20%">Colour</th>
                      <th style="width: 10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="sub in substatuses" :key="sub.data"> 
                      <td>{{sub.id}}</td>
                       <td>{{sub.title}}</td>
                      <td>{{sub.status.title}}</td>
                      <td><span v-bind:style="{ 'background-color': sub.colour }">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>                                          
                      <!-- <td><span class="badge ">
                         <i aria-hidden="true" class="fa fa-pen" ></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                         <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(item)"></i> 
                          </span>
                      </td> -->
                      <td>    
                        <a href="#" @click="editSubStatus(sub)">
                            <i class="fa fa-edit black"></i>
                        </a>
                        /
                        <a href="#" @click="deleteUser(status.id)">
                            <i class="fa fa-trash black"></i>
                        </a>
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
       


            <!----------------------- Modal treatmentModal ------------------------------------>
            <div class="modal fade" id="treatmentModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Treatment</h5>
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
            <!----------------------- Modal ------------------------------------>





              <!----------------------- Modal statusesModal------------------------------------>
             <div class="modal fade" id="statusesModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Status</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateTreatment() : createTreatment()">
                <div class="modal-body">

                    <div class="form-group">
                        <input v-model="formstatuses.title" type="text" name="title"
                            placeholder="Title"
                            class="form-control" :class="{ 'is-invalid': formstatuses.errors.has('title') }">
                        <has-error :form="formstatuses" field="title"></has-error>
                    </div>
                     <div class="form-group">
                        <input v-model="formstatuses.colour" type="text" name="colour"
                            placeholder="Colour"
                            class="form-control" :class="{ 'is-invalid': formstatuses.errors.has('colour') }">
                        <has-error :form="formstatuses" field="colour"></has-error>
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
              <!----------------------- Modal end statusesModal------------------------------------>





            <!----------------------- Modal treatmentModal ------------------------------------>
            <div class="modal fade" id="substatusesModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
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
                        <input v-model="formsubstatus.title" type="text" name="title"
                            placeholder="Title"
                            class="form-control" :class="{ 'is-invalid': formsubstatus.errors.has('title') }">
                        <has-error :form="formsubstatus" field="title"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="formsubstatus.colour" type="text" name="colour"
                            placeholder="colour"
                            class="form-control" :class="{ 'is-invalid': formsubstatus.errors.has('colour') }">
                        <has-error :form="formsubstatus" field="colour"></has-error>
                    </div>

                     
 
                    <div class="form-group">
                        <select name="status_id" v-model="formsubstatus.status_id" id="status_id" class="form-control" :class="{ 'is-invalid': formsubstatus.errors.has('status_id') }">
                            <option value="">Select Parent Status</option>                           
                            <option :value="status.id" v-for="status in statuses" :key="status.data">{{status.title}}</option>                           
                        </select>
                        <has-error :form="formsubstatus" field="status_id"></has-error>
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
//import ModalTreatment from './ModalTreatment.vue' 

export default {
    components: { Buttons },
data () {
return {
    editmode: false,
    url:'',
    settings: {},
    urlList: '',
    urlEdit: '',
    apiList: '',
    //    
    //editMode: this.$route.meta.mode,
    treatments:{},statuses:{},substatuses:{},
    model: {
        // urlList:'',
        // data: []
    },
    // form: {
    //     errors:''        
    // },
    form: new Form({
                    id:'',
                    title : '',
                    user_id: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
    }),
    formstatuses: new Form({                   
        title : '',
        colour : '',
                   
    }),
    formsubstatus: new Form({                   
        title : '',
        colour : '',
        status_id : '',
                   
    }),
    
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
// beforeRouteEnter(to, from, next) {    
//     get('/v1/api/home/globalsettings')
//         .then((res) => {
//             next(vm => vm.setData(res))
//         })
// },
// //
// beforeRouteUpdate(to, from, next) {
//     get('/v1/api'+to.path+'/index', to.query)
//         .then((res) => {
//             this.setData(res)
//             next()
//     })
// },
//
created() {
    this.$eventHub.$on('settings', this.modelSettings) 
     this.loadData()
},
beforeDestroy(){
    //this.$eventHub.$off('settings');
},
//
methods: {
    loadData(){
        get('/v1/api/home/globalsettings')
        .then((res) => {
            this.setData(res)
        })
    },
    newTreatment(){
                this.editmode = false;
                this.form.reset();
                $('#treatmentModal').modal('show');
    },
    editTreatment(treat){
                this.editmode = true;
                this.form.reset();
                $('#treatmentModal').modal('show');                
                this.form.fill(treat);
                //console.log(this.form)
    },
    editStatus(stat){
                this.editmode = true;
                this.form.reset();
                $('#statusesModal').modal('show');                
                this.formstatuses.fill(stat);
                //console.log(this.form)
    },
    editSubStatus(sub){
       this.editmode = true;
       this.form.reset();
       $('#substatusesModal').modal('show');                
       this.formsubstatus.fill(sub);   
    },
    ///////////////CREATE
    createTreatment(){
                this.$Progress.start();
                this.form.post('/v1/api/treatments/create')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#treatmentModal').modal('hide')
                     this.loadData()
                    toast({
                        type: 'success',
                        title: 'User Created in successfully'
                        })
                    this.$Progress.finish();

                })
                .catch(()=>{

                })
    },
    /////////////// UPDATE       
    updateTreatment(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('/v1/api/treatments/update/'+this.form.id)
                .then(() => {
                    // success
                    $('#treatmentModal').modal('hide');
                    this.loadData()
                     swal(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                        )
                        this.$Progress.finish();
                         Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });

     },
     ///////////////////////////DELETE
     deleteTreatment(item){
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
            //this.$router.push('/globalsettings') 
             this.loadData()
                                                
        }).catch(()=> {
            swal.fire("Failed!", "There was something wronge.", "warning");
            });
        }
        })
    },

    /////////////////////////////////////////////////////




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
         //$("#tasksModal").modal("show")
         $("#addNew2").modal("show")    
         
        //this.$router.push(this.urlList+'/'+item.id+'/edit')
    },
    newModal(){
        //this.editmode = false;
        this.form.reset();
        $('#addNew2').modal('show');
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
    // nextPage() {
    //     if(this.model.next_page_url) {
    //         //console.log(this.model.next_page_url)
    //         const query = Object.assign({}, this.$route.query)
    //         query.page = query.page ? (Number(query.page) + 1) : 2

    //         this.$router.push({
    //             path: this.urlList,
    //             query: query
    //         })
    //     }
    // },
    // prevPage () {
    //     if(this.model.prev_page_url) {
    //         const query = Object.assign({}, this.$route.query)
    //         query.page = query.page ? (Number(query.page) - 1) : 1

    //         this.$router.push({
    //             path: this.urlList,
    //             query: query
    //         })
    //     }
    // },
    checkThis(cos) {
    return photo
    },
    getApi(url){
        get(url)
        .then((res) => {
            this.setData(res)                   
        })
    },
    



    }
}
</script>
