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

                     <!-- <h1>urlList {{ settings.urlList }}</h1>
                     <h1>apiDelete {{ settings.apiDelete }}</h1> -->

                    
                        <div class="card-body">
                            
                       

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input v-model="form.name" type="text" name="title" class="form-control" disabled>

                                    </div>

                                    <div class="form-group">
                                        <label>Guard_name</label>
                                        <input v-model="form.guard_name" type="text" name="max_pers" class="form-control" disabled>
                                    </div>                                   

                                </div>
                              
                               
                            </div>
                           
                           
                          <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Permission List</label>       <br>                                 
                                        <!-- <div class="icheck-danger d-inline"> -->
                                            <div v-for="perm in allPermisions" style="border:solid 0px red;width:300px;float:left">
                                                <input :value="perm.id" v-model="form.grantedPermissions" type="checkbox" disabled/> {{perm.name}}
                                            </div>
                                            <!-- <br>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            
                            

                        </div>

                        <div class="card-footer">
                            <Buttons :urlEdit="urlEdit" :urlList="urlList" :editMode="editMode" ></Buttons>
                        </div>

                    
                    <!-- <pre><code>{{form}}</code></pre>  -->

                </div>
            </div>

        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod} from '../../lib/api'    
    import Buttons from './Buttons';

    export default {
        components: { Buttons },
        data () {
            return {
                show: false,
                form: {
                    
                },
                ////////////////
                settings: {},
                apiList:'',
                apiCreate:'',
                apiEdit:'',
                apiCreate:'',
                apiUpdate:'',     
                //
                urlList:'',
                urlCreate:'', 
                urlEdit:'',
                editMode: this.$route.meta.mode,
                //
                // photable_Type: "App\\Property",
                // photable_Id: this.$route.params.id,
                // photos_List: [],
                ////////////////////////////////////////////////////////// 
                allPermisions:[], //dont need allPermissions in form only selected 
                grantedPermisions:[], //dont need allPermissions in form only selected 
                //
                //childData: "",
               
            }
        },
        beforeRouteEnter(to, from, next) {           
            get('/v1/api'+to.path+'/edit')           
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false           
            get('/v1/api'+to.path+'/edit')
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        //
        mounted() {            
          
        },
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
                this.urlList = settings.modelPlural
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
                Vue.set(this.$data, 'form', res.data.form)
                this.show = true               
                //                 
                this.grantedPermissions = res.data.form.grantedPermissions
                this.allPermisions = res.data.form.allPermissions 
                this.objectToArray(); 
                //this.$bar.finish()
                
            },
            objectToArray() {
                var perm_array = [];               
                this.grantedPermissions.forEach(element => {
                    perm_array.push(element.id);
                });       
                this.form.grantedPermissions = perm_array;               
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
