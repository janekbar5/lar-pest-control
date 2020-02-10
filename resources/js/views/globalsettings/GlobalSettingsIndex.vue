<template>
    <div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">         
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Treatments</h3>
                
              </div>
              <!-- /.card-header -->
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
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                  </ul>
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
         
          </div>
          <!-- /.col -->




                  <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Task Status</h3>

                
              </div>
              <!-- /.card-header -->
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
                     <tr v-for="status in statuses" :key="status.data"> 
                      <td>{{status.id}}</td>
                      <td>{{status.title}}</td>
                     
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
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                  </ul>
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
         
          </div>
        </div>
        <!-- /.row -->


        <Modal  />
        
        
       
      </div><!-- /.container-fluid -->
    </section>
        
    </div>
</template>


<script type="text/javascript">
import Vue from 'vue'
import { get, byMethod } from '../../lib/api'
import {isEmpty} from "lodash"
import Buttons from './Buttons'
import Modal from './Modal.vue' 

export default {
    components: { Buttons, Modal },
data () {
return {
    url:'',
    settings: {},
    urlList: '',
    urlEdit: '',
    apiList: '',
    //    
    editMode: this.$route.meta.mode,
    treatments:{},statuses:{},
    model: {
        // urlList:'',
        // data: []
    },
    
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
        this.treatments = res.data.treatments.data
        this.statuses = res.data.statuses.data
        console.log(res.data)
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
            byMethod('delete',  this.apiDelete+item.id).then(()=>{
            swal.fire('Deleted!','Your file has been deleted.','success')
            this.getApi(this.apiList+'?page='+this.page)                                         
        }).catch(()=> {
            swal.fire("Failed!", "There was something wronge.", "warning");
            });
        }
        })
    },



    }
}
</script>
