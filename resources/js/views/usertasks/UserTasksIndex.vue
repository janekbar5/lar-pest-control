<template>
    <div>

        <!-- <div id="app">
            <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config">
            </vue-bootstrap4-table>
        </div> -->

<div class="layout-table">
   <div class="layout-header"> 
       <div class="layout-column"> Date</div>
       <div class="layout-column"> Time </div>
       <div class="layout-column"> Task </div>
       <div class="layout-column"> Location </div>
       <div class="layout-column"> Status </div>
       <div class="layout-column"> Action </div>
   </div>

   <div class="layout-row" v-for="(item, index) in records" :key="item.data"> 
        <b>{{ index }} </b>
        <div class="row" v-for="day in item" :key="day.data">             
            <div class="layout-column"> </div>
             <div class="layout-column">  From {{day.start | formatDate}} To {{day.end | formatDate}} </div>
             <div class="layout-column">  {{day.title}} </div>
             <div class="layout-column">  {{day.locations.title}}  </div>
             <div class="layout-column"> <span style="width:100px;" v-bind:style="{ 'background-color': day.statuses.colour }"> {{day.statuses.title}} </span> </div>
             <div class="layout-column">  
                <div class="field">                   
                     <div class="control">
                         <div class="select">
                         <select v-model="day.statuses.id" @change="changeStatus(day.id,$event.target.value)">
                             <option :value="status.id" v-for="status in statuses" :key="status.data"> {{ status.title }}</option>
                            </select>
                            </div>
                      </div>
                 </div>
                 <i aria-hidden="true" class="fa fa-pen" @click="modelEdit(day)"></i> 
            </div>
            
        </div>

   </div>

   <div class="layout-footer"> 
       <div class="layout-column"> </div>
       <div class="layout-column"> </div>
       <div class="layout-column"> </div>
       <div class="layout-column"> </div>
       <div class="layout-column"> </div>
       <div class="layout-column"> </div>
   </div>
</div>
        <!-- <Filters v-on:childToParent="onChildLoad" ></Filters> -->
       
    </div>
</template>


<script type="text/javascript">
import Vue from 'vue'
import { get, byMethod } from '../../lib/api'
import {isEmpty} from "lodash"
import Buttons from './Buttons'
//import Filters from './Filters'
import VueBootstrap4Table from 'vue-bootstrap4-table'


export default {
    components: { Buttons, VueBootstrap4Table },    
data () {
return {
    url:'',
    settings: {},
    urlList:'/usertasks',
    urlCreate:'/usertasks/create',
    urlEdit:'/usertasks/',
    apiList:'/v1/api/usertasks/index',
    apiCreate:'/v1/api/usertasks/create',
    apiEdit:'/v1/api/usertasks/edit/',       
    apiUpdate:'/v1/api/usertasks/update/',     
    apiDelete:'/v1/api/usertasks/delete/',
    //    
    editMode: this.$route.meta.mode,
    model: {
        // urlList:'',
        // data: []
    },
    records:[],
    /////////////////////////////
    statuses:[],
    
}
},
//
//  beforeRouteEnter(to, from, next) {    
//      get('/v1/api/tasks/indexfielduser', to.query)
//          .then((res) => {
//              next(vm => vm.setData(res))
//          })
//  },
// // //
//  beforeRouteUpdate(to, from, next) {
//      get('/v1/api/tasks/indexfielduser', to.query)
//          .then((res) => {
//              this.setData(res)
//              next()
//      })
//  },
//
created() {
    //this.$eventHub.$on('settings', this.modelSettings)
    
},
mounted(){
    this.loadData()
},
//
methods: {
    modelEdit(day) {        
        this.$router.push(this.urlList+'/'+day.id+'/edit')
    },   
    changeStatus(taskid,statusid) {
        //console.log(event) 
        //console.log(task) 
        axios.get('/v1/api/tasks/updatestatus?taskid='+taskid+'&statusid='+statusid)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            //this.success(res)
                            this.loadToast('success','Task updated successfully'); 
                            this.loadData() 
                        }
                        
                    })
                    // .catch((error) => {
                    //     if(error.response.status === 422) {
                    //         this.errors = error.response.data.errors
                    //         this.loadToast('error','Check the forms'); 
                    //     }                       
                    // })                           
    },
    loadData(){ 
        axios.get('/v1/api/tasks/indexfielduser').then((res) => {
        if(res.data) {       
            this.setData(res)
        }})
        .catch((error) => {
          if(error.response.status === 422) {
            this.errors = error.response.data.errors
          }        
      })                
    },
    loadToast(icon,text){
        toast.fire({icon: icon,title: text })
    }, 
    setData(res) {
        this.records = res.data.results
        this.statuses  = res.data.statuses
        //console.log('this.records')             
    },
    // modelSettings(settings){
    //     //return name
    //     this.settings = settings;
    //     this.urlList = settings.urlList
    //     this.urlEdit = settings.urlEdit
    //     //
    //     this.apiList = settings.apiList
    //     this.apiDelete = settings.apiDelete
    //     //console.log(settings)  
    // },
    onChildLoad (value) {
		this.records = value						
	},
    modelView(item) {        
        this.$router.push(this.urlList+'/'+item.id)
    },
    modelEdit(item) {
        this.$router.push(this.urlList+'/'+item.id+'/edit')
    },
   /* setData(res) {
        Vue.set(this.$data, 'model', res.data.results)
        this.page = this.model.current_page
        //this.$bar.finish()
    },*/
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
    // checkThis(cos) {
    // return photo
    // },
    getApi(url){
        get(url)
        .then((res) => {
            this.setData(res)                   
        })
    },
    // modelDelete(item){
    //     swal.fire({
    //     title: 'Are you sure?',
    //     text: "You won't be able to revert this!",
    //     type: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes, delete it!'
    //     }).then((result) => {
    //     // Send request to the server
    //     if (result.value) {
    //         byMethod('delete',  this.apiDelete+item.id).then(()=>{
    //         swal.fire('Deleted!','Your file has been deleted.','success')
    //         this.getApi(this.apiList+'?page='+this.page)                                         
    //     }).catch(()=> {
    //         swal.fire("Failed!", "There was something wronge.", "warning");
    //         });
    //     }
    //     })
    // },



    }
}
</script>
<style>
.layout-table
{
    display : table;
    clear : both;
    table-layout : fixed;
    width : 100%;
}

.layout-table:unresolved
{
    color : red;
    border: 1px blue solid;
    empty-cells : show;
}

.layout-header, .layout-footer, .layout-row 
{
    display : table-row;
    clear : both;   
    empty-cells : show;
    width : 100%;
}

.layout-column 
{ 
    display : table-column;
    float : left;
    width : 15%;
    min-width : 15%;
    empty-cells : show;
    box-sizing: border-box;
    /* border: 1px solid white; */
    padding : 1px 1px 1px 1px;
}

.layout-row:nth-child(even)
{ 
    background-color : #eeeeee;
}

.layout-row:hover 
{ background-color: #ffffff }
</style>