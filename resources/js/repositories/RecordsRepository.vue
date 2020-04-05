  
<template>
    <div>

    </div>
</template>
<script>
import Vue from 'vue'
import Repository from './Repository';
const resource = '/users';
const apiurl = '/v1/api/';
import {get, byMethod } from '../lib/api'
export default {
    //template: '<div>{{ hi }}</div>',
    data () {
        return { 
            errors:'',
    }    
    },      
    methods: {
    index(model) {
        return Repository.get(`${apiurl}${model}/index`)
    },
	sortFilter(model,updateParams) {
        return Repository.get(`${apiurl}${model}/index?${updateParams}`)
    },	
    create(model) {
        return Repository.get(`${apiurl}${model}/create`)
    },	
    edit(model,id) {
        return Repository.get(`${apiurl}${model}/${id}/edit`)
    },
    createPost(model,payload) {
        return Repository.post(`${apiurl}${model}/create`, payload)
    },
    updatePost(model,id,payload) {
        return Repository.post(`${apiurl}${model}/update/${id}`, payload)
    },
    	
	delete(model,id) {
        return Repository.delete(`${apiurl}${model}/delete/${id}`)
    },
    /////////////
    reccurences() {
        return Repository.get('/v1/api/reccurences/index')
    },
    /////////////
    onSave(model,id,form,editmode) {
                this.errors = {}
                this.isProcessing = true                
                byMethod('POST',editmode === 'edit' ? '/v1/api/'+model+'/update/'+id : '/v1/api/'+model+'/create' ,form)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            this.success(model)
                            this.loadToast('success',''+model+' updated successfully')   
                        }
                        if(res.data && res.data.created) {
                            this.success(model)
                            this.loadToast('success',''+model+' created successfully')
                        }
                    })
                    .catch((error) => {
                        if(error.response.status === 422) {                            
                            this.$parent.errors = error.response.data.errors
                            this.loadToast('error','Check the forms')
                        }
                        this.isProcessing = false
                    })
    },    
    success(model) {
        this.$router.push('/'+model)                
    },           
    loadToast(icon,text){
      toast.fire({icon: icon,title: text })
    },
    deleteRecord(model,serverParams,queryParams,id){
            swal.fire({title: 'Are you sure?',text: "You won't be able to revert this!",type: 'warning',showCancelButton: true,
            confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText: 'Yes, delete it!'})
                .then((result) => {                      
                if (result.value) {
                    byMethod('DELETE','/v1/api/'+model+'/delete/'+id)
                    .then((res)=>{
                        if(res.data.deleted) {                          
                        swal.fire('Deleted!','Your '+ model +' has been deleted.','success')
                        this.fetchData(model,serverParams,queryParams) 
                        }
                    }).catch((res)=> {
                        if(res.status === 422) {                            
                            swal.fire("Failed!", "There was something wronge.", "warning")
                        }
                        
                    });
                }
                })
        
    },
    fetchData: async function(model,serverParams,queryParams) {  
                
                this.queryParams = queryParams
                this.serverParams = serverParams             
                let self = this;
                this.$Progress.start()
                this.serverParams = Object.assign({}, this.serverParams, this.queryParams)                                    
                //sorting params   
                var params = { field: this.serverParams.sort[0].name,order: this.serverParams.sort[0].order }                       
                this.querySorting = Object.keys(params).map(key => key + '=' + params[key]).join('&')
                // filter params
                var filterParams = []
                this.serverParams.filters.forEach(element => {                   
                    if(element.type==='simple'){
                    filterParams.push(element.name+'='+ element.text)
                    }else{
                    filterParams.push(element.name+'='+ element.selected_options)    
                    }                   
                });
                //per page
                var perpage = { perPage: this.serverParams.per_page };
                var queryPer = Object.keys(perpage).map(key => key + '=' + perpage[key]).join('&'); 
                //which page
                var pageparams = { page: this.serverParams.page };
                var page = Object.keys(pageparams).map(key => key + '=' + pageparams[key]).join('&'); 

                const { data } = await this.sortFilter(model,this.querySorting+'&'+queryPer+'&'+page+'&'+filterParams.join('&')); 
                self.$parent.rows = data.rows.data;              
                this.$Progress.finish()
                self.$parent.total_rows = data.rows.total;      
            }
   
  }//meth
}
</script>
