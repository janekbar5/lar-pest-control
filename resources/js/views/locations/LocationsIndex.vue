<template>
    <div class="panel">
        <div class="panel-heading">
            <div>             
              
                <Buttons :editMode="editMode" ></Buttons>
            </div>
        </div>
       
        <div class="panel-body">
            <table class="table table-link">
                <thead>
                    <tr>
                        <th style="width: 5%">ID</th>                       
                        <th style="width: 20%">Client</th>
                        <th style="width: 20%">City</th>
                        <th style="width: 20%">Address</th>
                        <th style="width: 10%">Actions</th>                       
                       
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in model.data" :key="item.data">
                        <td>{{item.id}}</td> 
                        <td>{{item.clients.name}}</td>
                        <td>{{item.address.city}} </td>
                        <td>{{item.address.address_line1}} </br>
                            {{item.address.address_line2}}

                        </td>
                        
                       
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
        </div>
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
