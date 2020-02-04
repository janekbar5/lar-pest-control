<template>
    <div>
  


  <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <Buttons :editMode="editMode" ></Buttons>
                    </div>
                  </div>
                </div>
              </div>
             
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 5%">ID</th>
                        <th style="width: 10%">Image</th>
                        <th style="width: 10%">Name</th>
                        <th style="width: 10%">Surname</th>
                        <th style="width: 10%">Email</th> 
                        <th style="width: 20%">Work Phone</th>      
                        <th style="width: 10%">Leave Days Taken/Left</th>    
                        <th style="width: 20%">Personal Phone</th>                 
                        <th style="width: 10%">Roles</th>
                        <th style="width: 10%">Status</th>                       
                        <th style="width: 10%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="item in model.data" :key="item.data">
                        <td>{{item.id}}</td>
                        <td>
                            <img v-if="item.firstPhoto == null" :src="'https://dummyimage.com/50x50/807c80/fff'" style="width:50px;height:50px">
                            <img v-else :src="'images/thumb_medium-' + item.firstPhoto.path" style="width:50px;height:50px">
                        </td>

                        <td>{{item.name}}</td>
                        <td>{{item.last_name}}</td>
                        <td>{{item.email}}</td>      
                        <td>{{item.work_phone}}</td>
                        <td>{{item.leaves_day}}</td>
                        <td>{{item.personal_phone}}</td>

                        <td> <span class="badge bg-secondary" v-for="role in item.roles" style="font-size:10px">{{role.name}} </span> </td>   
                        <td> Active </td>                    
                        <td>
                            <div class="btn-group">
                               
                                 <i aria-hidden="true" class="fa fa-pen" @click="modelEdit(item)"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                                 <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(item)"></i> 
                               
                            </div>

                        </td>
                    </tr>  
                 
                    
                 
                  </tbody>
                </table>
              </div>
            
            </div>
        
          </div>
        </div>



<!-- <div class="row">  
          <div class="col-md-12">  
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3> 

                <div style="float:right"><Buttons :editMode="editMode" ></Buttons></div>

              
              </div>
         
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 10%">Image</th>
                        <th style="width: 10%">Name</th>
                        <th style="width: 10%">Surname</th>
                        <th style="width: 10%">Email</th> 
                        <th style="width: 20%">Work Phone</th>      
                        <th style="width: 10%">Leave Days Taken/Left</th>    
                        <th style="width: 20%">Personal Phone</th>                 
                        <th style="width: 10%">Roles</th>
                        <th style="width: 10%">Status</th>                       
                        <th style="width: 10%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in model.data" :key="item.data">
                        <td>{{item.id}}</td>
                        <td>
                            <img v-if="item.firstPhoto == null" :src="'https://dummyimage.com/50x50/807c80/fff'" style="width:50px;height:50px">
                            <img v-else :src="'images/thumb_medium-' + item.firstPhoto.path" style="width:50px;height:50px">
                        </td>

                        <td>{{item.name}}</td>
                        <td>{{item.last_name}}</td>
                        <td>{{item.email}}</td>      
                        <td>{{item.work_phone}}</td>
                        <td>{{item.leaves_day}}</td>
                        <td>{{item.personal_phone}}</td>

                        <td> <span class="badge bg-secondary" v-for="role in item.roles" style="font-size:8px">{{role.name}} </span> </td>   
                        <td> Active </td>                    
                        <td>
                            <div class="btn-group">
                                <i aria-hidden="true" class="fa fa-eye" @click="modelView(item)"></i>&nbsp;&nbsp;&nbsp;&nbsp; 
                                 <i aria-hidden="true" class="fa fa-pen" @click="modelEdit(item)"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                                 <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(item)"></i> 
                               
                            </div>

                        </td>
                    </tr>                     
                  </tbody>
                </table>
              </div>
            
               <div class="card-footer clearfix">                 
                <ul class="pagination pagination-sm m-0 float-right">
                      <div>
                        <small>Showing {{model.from}} - {{model.to}} of {{model.total}}</small>
                    </div>
                  <li class="page-item"><a class="page-link" href="#"  :disabled="!model.prev_page_url" @click="prevPage">« Prev</a></li>
               
                  <li class="page-item"><a class="page-link" href="#"  :disabled="!model.next_page_url" @click="nextPage">» Next</a></li>
                </ul>
              </div>
            </div>         
          </div>         
        </div> 
         -->










        <!-- <div class="panel-heading">
            <div>             
                
                <Buttons :editMode="editMode" ></Buttons>
            </div>
        </div>
       
        <div class="panel-body">
            <table class="table table-link">
                <thead>
                    <tr>
                        <th style="width: 10%">ID</th>
                        <th style="width: 10%">Image</th>
                        <th style="width: 10%">Name</th>
                        <th style="width: 10%">Email</th>                       
                        <th style="width: 40%">Roles</th>                       
                        <th style="width: 30%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in model.data" :key="item.data">
                        <td>{{item.id}}</td>
                        <td>
                            <img v-if="item.firstPhoto == null" :src="'https://dummyimage.com/100/09f/fff.png'" style="width:100px;height:80px">
                            <img v-else :src="'images/thumb_medium-' + item.firstPhoto.path" style="width:100px;height:80px">
                        </td>

                        <td>{{item.name}}</td>
                        <td>{{item.email}}</td>                       
                        <td> <span class="badge bg-primary" v-for="role in item.roles" style="font-size:8px">{{role.name}} </span> </td>                      
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" @click="modelView(item)"> View</button>
                                <button type="button" class="btn btn-info" @click="modelEdit(item)">Edit</button>
                                <button type="button" class="btn btn-danger" @click="modelDelete(item)">Delete</button>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="panel-footer flex-between">
            <div>
                <small>Showing {{model.from}} - {{model.to}} of {{model.total}}</small>
            </div>
            <div>
                <button class="btn btn-sm" :disabled="!model.prev_page_url" @click="prevPage">
                    Prev
                </button>
                <button class="btn btn-sm" :disabled="!model.next_page_url" @click="nextPage">
                    Next
                </button>
            </div>
        </div> -->


    </div>
</template>


<script type="text/javascript">
import Vue from 'vue'
import { get, byMethod } from '../../lib/api'
import {isEmpty} from "lodash"
import Buttons from './Buttons'

export default {
    components: { Buttons },
data () {
return {
    url:'',
    settings: {},
    urlList: '',
    urlEdit: '',
    apiList: '',
    //    
    editMode: this.$route.meta.mode,
    model: {
        // urlList:'',
        // data: []
    },
    
}
},
//
beforeRouteEnter(to, from, next) {    
    get('/v1/api'+to.path+'/index', to.query)
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
    modelView(item) {        
        this.$router.push(this.urlList+'/'+item.id)
    },
    modelEdit(item) {
        this.$router.push(this.urlList+'/'+item.id+'/edit')
    },
    setData(res) {
        Vue.set(this.$data, 'model', res.data.results)
        this.page = this.model.current_page
        //this.$bar.finish()
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
