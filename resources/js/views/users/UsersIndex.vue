<template>
    <div>
        <Buttons :editMode="editMode" style="display:none"></Buttons>
  
      <vue-bootstrap4-table 
      :rows="rows"
      :columns="columns"
      :config="config"
      :actions="actions"
      @on-download="newUser"                               
      >

        <template slot="photo" slot-scope="props">
              <img v-if="(props.cell_value) == null" :src="'https://dummyimage.com/60x50/807c80/fff'" style="width:60px;height:50px">
              <img v-else :src="'images/thumb_medium-' + props.cell_value" style="width:60px;height:50px">
       </template>

        <template slot="actions" slot-scope="props"> 
            <i aria-hidden="true" class="fa fa-pen" @click="modelEdit(props.cell_value)"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
            <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(props.cell_value)"></i>     
       </template>

        </vue-bootstrap4-table>
    </div>
</template>


<script type="text/javascript">
import Vue from 'vue'
import { get, byMethod } from '../../lib/api'
// import {isEmpty} from "lodash"
import Buttons from './Buttons'
// import {Typeahead } from '../../components/typeahead'
import VueBootstrap4Table from 'vue-bootstrap4-table'

export default {
    components: { VueBootstrap4Table, Buttons },
data () {
return {
    rows: [],
                columns: [
                        {label: "id", name: "id",},
                        {label: "Photo",name: "photos[0].path",slot_name: "photo"},
                        {label: "Name", name: "name",filter: {type: "simple",placeholder: "Enter name"},sort: true,},
                       
                        {label: "Surname", name: "last_name",filter: {type: "simple",placeholder: "Enter surname"},sort: true,},
                        {label: "Email", name: "email",filter: {type: "simple",placeholder: "Enter email"},sort: true,},
                        {label: "Work Phone", name: "work_phone",filter: {type: "simple",placeholder: "Enter phone"},sort: true,},
                        {label: "Leaves Days", name: "leaves_day",filter: {type: "simple",placeholder: "Enter days"},sort: true,},
                        {label: "Personal Phone", name: "personal_phone",filter: {type: "simple",placeholder: "Enter phone"},sort: true,},
                        
                        {label: "Role",name: "roles[0].name",filter: {type: "simple",placeholder: "Enter Role"},sort: true,},
                        {label: "Actions",name: "id",slot_name: "actions"}, 
                   ],
                   actions: [
                    {
                        btn_text: "New User",
                        event_name: "on-download",
                        class: "btn btn-secondary",
                        event_payload: {
                            msg: "my custom msg"
                        }
                    }
                   ],                    
                    config: {
                        checkbox_rows: false,
                        rows_selectable: true,
                        card_title: "Users"
                    },
    ////
    // url:'',
    // settings: {},
    modelPlural: 'users', modelSingular: 'user', 
    urlList:'/users',
    urlCreate:'/users/create',
    urlEdit:'/users/',
    apiList:'/v1/api/users/index',
    apiCreate:'/v1/api/users/create',
    apiEdit:'/v1/api/users/edit/',       
    apiUpdate:'/v1/api/users/update/',     
    apiDelete:'/v1/api/users/delete/',
    //    
    editMode: this.$route.meta.mode,
    model: {
        // urlList:'',
        // data: []
    },
    dataUser:'/v1/api/users/searchusers',
    perpage:10,
    
}
},
created() {
    //this.$eventHub.$on('settings', this.modelSettings) 
},
beforeDestroy(){
    //this.$eventHub.$off('settings');
},
//
mounted() {   
    this.onFilter() 
},          
methods: {
    // modelSettings(settings){
    //     //return name
    //     this.settings = settings;
    //     this.urlList = settings.urlList
    //     this.urlEdit = settings.urlEdit
    //     this.urlCreate = settings.urlCreate
    //     //
    //     this.apiList = settings.apiList
    //     this.apiDelete = settings.apiDelete
    //     //console.log(settings)  
    // },
    newUser(){
       this.$router.push(this.urlCreate) 
    },
   
    modelEdit(item) {        
        this.$router.push(this.urlList+'/'+item+'/edit')
    },   
    onFilter() {      
         axios    
            .get('/v1/api/users/filterusers')
                .then((res) => {
                    this.setData(res)                   
            })
            .catch(error => {				
					this.errored = true
					})
			.finally(() => this.loading = false)                   
        },
        setData(res) {            
            this.rows = res.data.results
            //this.$bar.finish()
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
            byMethod('delete',  this.apiDelete+item).then(()=>{
            swal.fire('Deleted!','Your file has been deleted.','success')
            this.getApi('/v1/api/users/filterusers')                                         
        }).catch(()=> {
            swal.fire("Failed!", "There was something wronge.", "warning");
            });
        }
        })
    },



    }
}
</script>
<style>
/* .fa-pen:hover {
    color: red;
} */
.fa-trash:hover,.fa-pen:hover {
    color: red;
    cursor:pointer;
}
.table-active {
    background-color:white;    
}
.btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle {
color: #fff;
background-color:grey;
border-color:grey;
}
.page-item.active .page-link {
    background-color:grey; 
}   
</style>
