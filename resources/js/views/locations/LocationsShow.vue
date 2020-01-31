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
                                        <label>Title</label>
                                        <input v-model="form.title" type="text" name="title" class="form-control" disabled>

                                    </div>                                   
                                </div>
                                <div class="col-md-4">                                    
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input v-model="form.description" type="text" name="email" class="form-control" disabled>
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
    //import DzoneComponent from '../../components/dzone/DzoneComponent';
    import Buttons from './Buttons';
   

    export default {
        components: { Buttons, },
        data () {
            return {
                show: false,
                form: {                    
                },
                ////////////////
                settings: {}, apiList:'', apiCreate:'', apiEdit:'', apiCreate:'', apiUpdate:'',     
                //
                urlList:'', urlCreate:'', urlEdit:'',
                editMode: this.$route.meta.mode,
                //
                // photable_Type: "App\\Property",
                // photable_Id: this.$route.params.id,
                // photos_List: [],
                //
                //roles: null, allroles: [], 
                errors: {},
               
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
                //this.allroles =  res.data.allroles //all roles
                //this.roles =  res.data.form.roles //assigned roles
                //this.groups = res.data.allgroups.data
                //this.seasonGroups = res.data.seasonGroups.data
                //this.allInventories = res.data.allinventories 
                //this.allAdvantages = res.data.alladvantages
                //                 
                //this.grantedInventories = res.data.form.inventories
                //this.grantedAdvantages = res.data.form.advantages
                //this.photos_List = res.data.form.photos;
                //this.$bar.finish()
                //this.objectToArray();
            },
            //  addTag (newTag) {
            //     const tag = {
            //         name: newTag,
            //         code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            //     }
            //     this.options.push(tag)
            //     this.value.push(tag)
            //     console.log(options)
            // },
             addTag2 (newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.allroles.push(tag)
                this.roles.push(tag)
                //console.log(options)
            },
            // objectToArray() {
            // var invent_array = [];
            // var advant_array = [];
            // this.grantedInventories.forEach(element => {
            //     invent_array.push(element.id);
            // });
            // this.grantedAdvantages.forEach(element => {
            //     advant_array.push(element.id);
            // });

            // this.form.selectedInventories = invent_array;
            // this.form.selectedAdvantages = advant_array;
            // },
            // onDelete() { 
            //     alert('delete from view')
            // },             
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