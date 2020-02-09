<template>
    <div class="panel">

       <div class="panel-heading">
            <div> 
                <Buttons :editMode="editMode" ></Buttons>
            </div>
        </div>
			
			<Filters v-on:childToParent="onChildLoad" ></Filters>
					
		<table class="table">
			<thead>
			<tr>				
                <th style="width: 10%">ID</th>                       
                <th style="width: 40%">Title</th>
                <th style="width: 40%">Client</th>           
                <th style="width: 10%">Actions</th> 
			</tr>
			</thead>
			<tbody>			
			 <tr v-for="item in records" :key="item.data">
                        <td>{{item.id}}</td> 
						<td>{{item.title}}</td> 
                        <td>{{item.clients.name}}</td>                      

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
</template>


<script>
import { get, byMethod } from '../../lib/api'
import {isEmpty} from "lodash"
import Buttons from './Buttons'
import Filters from './Filters'

export default {
	  components: { Buttons,Filters },
    data () {
        return {
            url:'',
            settings: {},
            urlList: '',
            urlEdit: '',
            apiList: '',
            //    
            editMode: this.$route.meta.mode,
            records: {},
            loading: true,
            errored: false,             
            location: "",
						color: null,					          
            }

    },

  computed: {	  
	  
	},
  
  filters: {
    currencydecimal (value) {
      return value.toFixed(2)
    }
  },
  
  mounted () {    
		this.onChildLoad()    
  },
  created() {
    this.$eventHub.$on('settings', this.modelSettings) 
},
  methods: {
	  onChildLoad (value) {
			this.records = value						
	  },
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
                this.getApi(this.apiList+'?page='+this.page)                  //stay on pagination page                       
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
