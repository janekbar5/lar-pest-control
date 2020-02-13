<template>
    <div>
        <Buttons :editMode="editMode" style="display:none"></Buttons>
  
      <vue-bootstrap4-table 
      :rows="rows"
      :columns="columns"
      :config="config"
      :actions="actions"
      @on-download="newRecord"                               
      >

        <template slot="photo" slot-scope="props">
              <img v-if="(props.cell_value) == null" :src="'https://dummyimage.com/60x50/807c80/fff'" style="width:60px;height:50px">
              <img v-else :src="'images/thumb_medium-' + props.cell_value" style="width:60px;height:50px">
       </template>

        <template slot="actions" slot-scope="props"> 
            <i aria-hidden="true" class="fa fa-pen" @click="recordEdit(props.cell_value)"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
            <i aria-hidden="true" class="fa fa-trash" @click="recordDelete(props.cell_value)"></i>     
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
                        {label: "Company", name: "company_name",filter: {type: "simple",placeholder: "Company"},sort: true,},
                        {label: "Location",name: "locations[0].title",filter: {type: "simple",placeholder: "Location"},sort: true,},
                        {label: "Contract", name: "contract_number",filter: {type: "simple",placeholder: "Contract"},sort: true,},
                        {label: "VAT", name: "vat_number",filter: {type: "simple",placeholder: "VAT"},sort: true,},
                        {label: "Start", name: "contract_start",filter: {type: "simple",placeholder: "Start"},sort: true,},
                        {label: "End", name: "contract_end",filter: {type: "simple",placeholder: "End"},sort: true,},
                                                
                        {label: "Actions",name: "id",slot_name: "actions"}, 
                   ],
                   actions: [
                    {
                        btn_text: "New Client",
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
                        card_title: "Clients"
                    },
    ////
    // url:'',
    // settings: {},
    urlList: '',
    urlEdit: '',
    urlCreate:'',
    apiList: '',
    //    
    editMode: this.$route.meta.mode,
    model: {
        // urlList:'',
        // data: []
    },
    dataUser:'/v1/api/users/searchusers',
    perpage:10,
    //

    
}
},
created() {
    this.$eventHub.$on('settings', this.modelSettings) 
},
beforeDestroy(){
    this.$eventHub.$off('settings');
},
//
mounted() {   
    this.onFilter() 
},          
methods: {
    modelSettings(settings){
        //return name
        this.settings = settings;
        this.urlList = settings.urlList
        this.urlEdit = settings.urlEdit
        this.urlCreate = settings.urlCreate
        //
        this.apiList = settings.apiList
        this.apiDelete = settings.apiDelete
        //console.log(settings)  
    },
    newRecord(){
       this.$router.push(this.urlCreate) 
    },
   
    recordEdit(item) {        
        this.$router.push(this.urlList+'/'+item+'/edit')
    },   
    onFilter() {      
         axios    
            .get(this.apiList)
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
    
    recordDelete(item){
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
            this.getApi(this.apiList)     //refresh list after delete                                    
        }).catch(()=> {
            swal.fire("Failed!", "There was something wronge.", "warning");
            });
        }
        })
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
