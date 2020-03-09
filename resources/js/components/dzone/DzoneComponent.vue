<template> 
            <div>
                <!------------------------------->               
                 <div class="row">
                    <div class="col-12">
                            <div class="card card-primary">                            
                                <div class="card-body">
                                    <div class="row">
                                        <!-- updatedPhotosList {{updatedPhotosList}}  -->                            
                                        <!-- photosList {{photosList}} -->
                                        <div class="col-sm-2" v-for="photo in updatedPhotosList">
                                            <a href="#" data-toggle="lightbox" data-title="" data-gallery="gallery">
                                            <img v-bind:src="'/images/thumb_mini-'+ photo.path" class="img-fluid mb-2" alt="white sample" width=100>
                                                <span v-if="editMode === 'edit'" @click="deletePhoto(photo.id)">DELETE</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>  
                <!-- updatedPhotosList  {{updatedPhotosList}} photosList {{photosList}} -->
                <div class="card" v-if="editMode === 'edit'" >                  
                    <div class="card-body" >  {{ editMode }}    
                        <vue-dropzone ref="myVueDropzone" id="dropzone"
                        @vdropzone-file-added="vfileAdded"
                        @vdropzone-success="vsuccess"
                        @vdropzone-error="verror"
                        @vdropzone-removed-file="vremoved"
                        @vdropzone-sending="vsending"
                        @vdropzone-success-multiple="vsuccessMuliple"
                        @vdropzone-sending-multiple="vsendingMuliple"
                        @vdropzone-queue-complete="vqueueComplete"
                        @vdropzone-total-upload-progress="vprogress"
                        @vdropzone-mounted="vmounted"
                        @vdropzone-drop="vddrop"
                        @vdropzone-drag-start="vdstart"
                        @vdropzone-drag-end="vdend"
                        @vdropzone-drag-enter="vdenter"
                        @vdropzone-drag-over="vdover"
                        @vdropzone-drag-leave="vdleave"
                        @vdropzone-duplicate-file="vdduplicate"
                        :options="dropzoneOptions"
                        :duplicateCheck="true">
                        </vue-dropzone>
                    </div>
                </div>
            </div>
       
</template>
 
<script>
 
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import {get, byMethod } from '../../lib/api'
    
    export default {
     components: { vueDropzone: vue2Dropzone },
      props: {  photableId: { required: true  }, photableType: { required: true },  photosList:{ required: true },  editMode:{ required: true }  },
      computed: {
            selectedText() {
                 this.text = this.initialize.text  
                 //console.log('jan')                  
            }
      },
      data: function () {
        return {
            updatedPhotosList:'',
            text:this.text,
            uploadMessage:this.photosList,            
            dropzoneOptions: {
                url: '/images/post',                
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                params: {
                    photoable_type:this.photableType,
                    photoable_id: this.photableId
                },                
                dictDefaultMessage: this.defaultUploadMessage()
            },
            fileAdded: true,
            filesAdded: true,
            success: false,
            error: false,
            removedFile: false,
            sending: false,
            successMultiple: false,
            sendingMultiple: false,
            queueComplete: false,
            uploadProgress: true,
            progress: false,
            myProgress: 0,
            isMounted: false,
            dDrop: false,
            dStarted: false,
            dEnded: false,
            dEntered: false,
            dOver: false,
            dLeave: false,
            dDuplicate:false
        }
      },
      ///////////////////////
      methods: {
        vmounted() { this.isMounted = true },
        vddrop() { this.dDrop = true },
        vdstart() { this.dStarted = true },
        vdend() { this.dEnded = true },
        vdenter() { this.dEntered = true },
        vdover() { this.dOver = true },
        vdleave() { this.dLeave = true },
        vdduplicate() { this.dDuplicate = true },  
        vfileAdded(file) {
        this.fileAdded = true
        // window.toastr.info('', 'Event : vdropzone-file-added')
        //console.log('Event : vdropzone-file-added')
        },
        vfilesAdded(file) {
        this.filesAdded = true
        // window.toastr.info('', 'Event : vdropzone-files-added')
         //console.log('Event : vdropzone-files-added')
        },
        vsuccess(file, response) {
        this.success = true
        // window.toastr.success('', 'Event : vdropzone-success')
         //console.log('Event : vdropzone-success')
        },
        verror(file) {
        this.error = true
         //console.log(file.upload.filename, 'Event : vdropzone-error - ' + file.status)
        },
        vremoved(file, xhr, error) {
        this.removedFile = true
         //console.log('', 'Event : vdropzone-removedFile')
        },
        vsending(file, xhr, formData) {
        this.sending = true
         //console.log('', 'Event : vdropzone-sending')
        },
        vsuccessMuliple(files, response) {
        this.successMultiple = true
         //console.log('', 'Event : vdropzone-success-multiple')
        },
        vsendingMuliple(file, xhr, formData) {
        this.sendingMultiple = true
         //console.log('', 'Event : vdropzone-sending-multiple')
        },
        vqueueComplete(file, xhr, formData) {
        this.queueComplete = true
         //console.log('', 'Event : vdropzone-queue-complete')
         this.photosUpdate()
        },

        
        deletePhoto(id){
            swal.fire({ title: 'Are you sure?',text: "You won't be able to revert this!",type: 'warning',
            showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            // Send request to the server
            if (result.value) {
                byMethod('delete', `/v1/api/images/delete/${id}`).then(()=>{
                swal.fire('Deleted!','Your file has been deleted.','success')                  
                this.photosList.splice(this.photosList.indexOf(id), 1)
            }).catch(()=> {
                swal.fire("Failed!", "There was something wronge.", "warning");
                });
            }
            })
        },
        vprogress(totalProgress, totalBytes, totalBytesSent) {
        this.progress = true
        this.myProgress = Math.floor(totalProgress)
         //console.log('', 'Event : vdropzone-sending')
        },
        
        ///////////////////////////
        disableUpload() {
          //this.$refs.myVueDropzone.disable()         
          console.log('disableUpload')
        },
        enableUpload() {
          //this.$refs.myVueDropzone.enable()          
          //console.log('enableUpload')
        },
        defaultUploadMessage(){   
            var message = ''
            if(this.editMode === 'edit') {
                message = 'Upload Images'              
            }else if(this.editMode === 'create'){
                message = 'View Images'
            }else{
                message = 'You  must save record to upload image'               
            }
            return message
        },
        photosUpdate() {            
            var params = { photoable_type: this.photableType,photoable_id: this.$route.params.id }            
            axios.post('/v1/api/images/index',params).then(res => {
              //this.photosList = res.data;
              this.updatedPhotosList = res.data;
            })  
        },
      },
      watch: {  
            photosList: function () {
            console.log('watch-photosList')   
             this.updatedPhotosList = this.photosList
             //console.log(this.updatedPhotosList)
            }  
      },    
      ///////////////////////
      created() {
          //console.log('created')
          //console.log('photosList created'+this.photosList)
      },
      mounted() {         
            if(this.editMode === 'edit') {
               this.enableUpload()
            }else{
               this.disableUpload()
            }   
            //console.log('mounted-child')
            //this.updatedPhotosList = this.photosList 
            //console.log('updatedPhotosList'+this.updatedPhotosList)
            //console.log('uploadMessage'+this.uploadMessage)     
      }
    }
</script>
