<template> 
<div class="modal fade" id="addNew">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="addNewLabel">locationdata:{{locationdata}}</h5>
                            </div>

                            
                                <div class="modal-body">
                                    <div class="col-12 col-sm-12 col-lg-12">

                                        <div class="card card-primary card-tabs">
                                            <div class="card-header p-0 pt-1">
                                               hgghmg
                                            </div>
                                            <div class="card-body">

                                             Start<input id="start" value=""></br>

                                             End<input id="end" value=""></br>

                                             Location<input id="location" value=""></br>

                                            </div>

                                        </div>
                                    </div>

                                   
                                </div>
                                <div class="modal-footer">
                                   fgngnhghn
                                </div>

                           

                        </div>

      </div>

 </div>
</template>
<script>


export default {
  name: 'Modal',
  props: {        
        locationdata: { required: true },
  },  
  data: function () {
    return {
      
    }
  }
}
</script>