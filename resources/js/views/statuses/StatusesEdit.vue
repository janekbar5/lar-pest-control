<template>
    <div>        

            <div class="panel-heading">
                <div>                   
                    <Buttons :editMode="editMode" ></Buttons>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Quick Example {{ editMode }} </h3>
                        </div>
                        
                        <div class="card-body">
                            
                            <div class="row">   
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input v-model="form.title" type="text" name="title" class="form-control" :class="{ 'is-invalid': errors.title }" >
                                         <div class="alert alert-danger" v-if="errors.title"> {{errors.title[0]}}</div>
                                    </div>                                                                    
                                </div>
                                                           
                                <div class="col-md-4">                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input v-model="form.description" type="text" name="title" class="form-control" :class="{ 'is-invalid': errors.email }" >
                                         <div class="alert alert-danger" v-if="errors.description"> {{errors.title[0]}}</div>
                                    </div>  
                                </div>                                
                            </div>
                                    
                       </div> 
                        
                        <div class="card-footer">
                            <div>                               
                                <Buttons :editMode="editMode" ></Buttons>
                            </div>
                        </div>
                        
                        
            </div>
         </div>
      </div>          
            

    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod } from '../../lib/api'
    //import {Typeahead } from '../../components/typeahead'
    //import DzoneComponent from '../../components/DzoneComponent';
    import Buttons from './Buttons';
    
    export default {
        components: { Buttons },
        data () {
            return {
                apiList:'', apiCreate:'', apiEdit:'', apiCreate:'', apiUpdate:'',     
                //
                urlList:'', urlCreate:'', urlEdit:'',              
                ////////////////////////////////////////////////////////// 
                editMode: this.$route.meta.mode,
                form: {},
                errors: {},                         
                //////////////////////////////////////////////////////////               
                photable_Type: "App\\User",
                photable_Id: this.$route.params.id,
                // photos_List: [],
                //
                //roles: null,
                //allroles: [],
            }
        },
        beforeRouteEnter(to, from, next) {            
            get('/v1/api'+to.path)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false            
            get('/v1/api'+to.path)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        computed: {
          
        },
        created() {
            this.$eventHub.$on('settings', this.modelSettings) 
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
                this.apiCreate = settings.apiCreate
                this.apiEdit = settings.apiEdit
                this.apiUpdate = settings.apiUpdate
                //console.log(settings)                
            },
            setData(res) { 
                if(this.$route.meta.mode === 'edit') {
                    Vue.set(this.$data, 'form', res.data.form)
                    this.store = this.apiUpdate + this.$route.params.id
                    this.method = 'PUT'
                    this.title = 'Edit'    
                }               
            },          
            //  addTag2 (newTag) {
            //     const tag = {
            //         name: newTag,
            //         code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            //     }
            //     this.allroles.push(tag)
            //     this.roles.push(tag)
            //     //console.log(options)
            // },
            onSave() {
                this.errors = {}
                this.isProcessing = true                
                byMethod('POST',this.$route.meta.mode === 'edit' ? this.apiUpdate+this.form.id : this.apiCreate , this.form)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            this.success(res)
                             this.loadToast('success','Updated successfully');  
                        }
                        if(res.data && res.data.created) {
                            this.success(res)
                             this.loadToast('success','Created successfully');  
                        }
                    })
                    .catch((error) => {
                        if(error.response.status === 422) {
                            this.errors = error.response.data.errors
                            this.loadToast('error','Check the forms'); 
                        }
                        this.isProcessing = false
                    })
            },
            success(res) {
                this.$router.push(this.urlList+'/'+res.data.id)
                console.log(this.urlList+'/'+res.data.id)
                //this.$router.push('/properties/1')
                
            },           
            loadToast(icon,text){
              toast.fire({icon: icon,title: text })
            }, 
            onDelete(){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!"+this.urlList,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                //byMethod('delete', `/api/properties/${this.model.id}`).then(()=>{
                                byMethod('delete',this.apiDelete+this.$route.params.id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                    //Fire.$emit('AfterCreate');
                                    this.$router.push(this.urlList)
                                }).catch(()=> {
                                    swal.fire("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
            },
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>