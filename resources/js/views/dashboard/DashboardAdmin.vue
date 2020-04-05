<template>
  <div>


      



      
      <div class="row">
              <div class="col-lg-6">  
                    <div class="card">
                      <div class="card-header">
                      
                      </div>
                      <div class="card-body">                        
                          <button class="btn btn-secondary" @click="prev"><< Prev</button>
                          <button class="btn btn-secondary" @click="next">Next >></button>
                          <button class="btn btn-secondary" @click="today">Today</button>                         
                        
                          <button class="btn btn-secondary" @click="changeView('month')">Month</button>
                          <button class="btn btn-secondary" @click="changeView('agendaWeek')">Week</button>
                          <button class="btn btn-secondary" @click="changeView('agendaDay')">Day</button>                          
                      </div> 

                        <full-calendar 
                        :header="{left:'',center: 'title',right: ''}"
                        :config="config" 
                        :events="events"                        
                        @day-click="dayClick" 
                        @scrollTime="scrollTime" 
                        ref="calendar"   
                        @changeMonth="changeMonth"                    
                         />            
                    </div>
              </div>

              <div class="col-lg-6">
                 <div class="row">
                  <div class="col-lg-3 col-6">                   
                    <div class="small-box bg-info">
                      <div class="inner">
                        <p>Tasks number: {{assignedtasks.length}}</p>
                        <p>Tasks value: {{assignedtasksCount}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                 
                  <div class="col-lg-3 col-6">                   
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>
                        <p>Bounce Rate {{unassignedtasksCount}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                  <div class="col-lg-3 col-6">                   
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3>44</h3>
                        <p>User Registrations</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-person-add"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                  <div class="col-lg-3 col-6">                   
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>65</h3>
                        <p>Unique Visitors</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                
                </div>
          </div>          
      </div>

        <div class="row">
              <div class="col-md-6">

 <div class="card">
                
              <div class="card-header">
                <h3 class="card-title">Subtatuses</h3> 
                 <div class="card-tools">                  
                    <div class="input-group-append">
                     <button  class="btn btn-secondary" @click="newTodo()" >Add New Todo</button> 
                    </div>                 
                </div>                
              </div>
                <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 10%">#</th>
                      
                      <th style="width: 30%">Substatus</th>
                      <th style="width: 20%">Parent Status</th>
                      <th style="width: 10%">Colour</th>
                      <th style="width: 15%"></th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="todo in todos" :key="todo.data"> 
                      <td>{{todo.id}}</td>
                      <td>{{todo.title}}</td>
                      <td>{{todo.users.name}} {{todo.users.last_name}}</td>
                                                            
                     
                      <td>    
                        <a href="#" @click="editTodo(todo)">
                            <i class="fa fa-edit black"></i>
                        </a>
                        /
                       <a href="#" @click="deleteRecord(todo,model='todos')">
                            <i class="fa fa-trash black"></i>
                        </a>
                        </td>
                    </tr>
                           
                  </tbody>
                </table>
              </div>
                   <div class="card-tools">
                  <!-- <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                  </ul> -->
                </div>
              
            </div>

            </div>  
        </div>

        <!----------------------- Modal substatuses ------------------------------------>
            <div class="modal fade" id="formTodo" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateTodo() : createTodo()">
                <div class="modal-body">
                     <div class="form-group">
                        <input v-model="formTodo.title" type="text" name="title"
                            placeholder="Title"
                            class="form-control" :class="{ 'is-invalid': formTodo.errors.has('title') }">
                        <has-error :form="formTodo" field="title"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="formTodo.description" type="text" name="description"
                            placeholder="description"
                            class="form-control" :class="{ 'is-invalid': formTodo.errors.has('description') }">
                        <has-error :form="formTodo" field="description"></has-error>
                    </div>

                     
 
                    <div class="form-group">
                        <select name="user_id" v-model="formTodo.user_id" id="user_id" class="form-control" :class="{ 'is-invalid': formTodo.errors.has('user_id') }">
                            <option value="">Select User</option>                           
                            <option :value="user.id" v-for="user in fieldusers" :key="user.data">{{user.name}} {{user.last_name}}</option>                           
                        </select>
                        <has-error :form="formTodo" field="user_id"></has-error>
                    </div>

                   

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"  @click="formHideReset('formTodo')">Close</button>
                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                </div>

                </form>

                </div>
            </div>
            </div> 
            <!----------------------- Modal ------------------------------------>



   



   </div>     
</div> 
</template>

<script>

import moment from "moment"
import "jquery-ui-bundle"
import $ from 'jquery'
import FullCalendar from "vue-full-calendar";   
// import Multiselect from 'vue-multiselect'
import { get, byMethod } from '../../lib/api'

export default {
  name: "hello",
  components: {  },  
  data() {
    var $this = this;
    return {
      editmode: false,
      unassignedtasks:[],assignedtasks:[],
      value:'',
      events: [],
      location:'',
      //location2:'',  
      locations:[],
      locationdata:[],
      variableToPass:'',
      //
      tasksbydate:[], 
      tasksbydate_date:'',
      freefieldusers:[],
      //
      //start:'',     
      config: {          
        //defaultView: "agendaWeek",
        defaultView: "month",
        editable: true,
        droppable: true,
        eventLimit: true,
        nowIndicator: true,
        slotDuration: "01:00:00",
        slotLabelInterval: "01:00:00",
        height: "auto",
        contentHeight: "auto",
        slotLabelFormat: "LT",
        //allDayText: "All Day Events",        
        allDaySlot: false,
        //////////////////////////////////////////////////////////////////////
        eventRender(event, element) {  
            if(event.end){
              element.find('.fc-content').append('<b> '+event.end.format('HH:mm')+'</b>'); 
            }

            if(event.users) {             
               event.users.forEach(function (item) {                   
                  element.find('.fc-content').append(' <span style="font-size:12px"><i class="delete fas fa-user"></i> '+item.name+' '+item.last_name+'</span></br>');                      
              });   
            }           
         },
        //////////////////////////////////////////////////////////////////////
      },        
      //////////config
        start:'',
        end:'',
        dueTasksCount:'',
        unassignedtasksCount:'',
        assignedtasksCount:'',
        charges:'',
        //
        value: [],
        todos:[],
        fieldusers:[],
      ///
      formTodo: new Form({ 
        id:'',                  
        title : '',        
        user_id : '',
        description : '',
                   
    }),  
                
    };
  },
  //data
 

  created() { 
    //this.loadCalendar()
    
    //console.log(this.externalVar); 
  },
  mounted() { 
      this.setStartEnd()
      this.loadStatistics()
      this.loadCalendar()
      this.loadTodo()
  },
  //
  methods: {
     formHideReset(form){ 
        this.formTodo.reset();             
        $('#'+form).modal('hide');
    },
   ///////////////////////////////////////////////New
    newTodo(){
                this.editmode = false;
                this.formTodo.reset();
                $('#formTodo').modal('show');
    },
    /////////////////////////////////////////////Edit
    editTodo(todo){
                this.editmode = true;
                this.formTodo.reset();
                $('#formTodo').modal('show');                
                this.formTodo.fill(todo);
                //console.log(this.form)
    },
    ////////////////////////////////////////////////////////CREATE POST
    createTodo(){ 
                this.$Progress.start();
                this.formTodo.post('/v1/api/todos/create')
                .then(()=>{
                    //Fire.$emit('AfterCreate');
                    $('#formTodo').modal('hide')
                    this.loadTodo()
                     toast({
                        type: 'success',
                        title: 'User Created in successfully'
                        })
                    this.$Progress.finish();
                })
                .catch(()=>{})
    },
 //////////////////////////////////////////////////////// UPDATE  Post     
    updateTodo(){
                this.$Progress.start();
                // console.log('Editing data');
                this.formTodo.put('/v1/api/todos/update/'+this.formTodo.id)
                .then(() => {
                    // success
                    $('#formTodo').modal('hide');
                    this.loadTodo()
                     swal(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                        )
                        this.$Progress.finish();
                         Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });

     },
 /////////////////////////////////////////////////////////////DELETE
     deleteRecord(item,model){
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
            byMethod('delete','v1/api/'+model+'/delete/'+item.id).then(()=>{
            swal.fire('Deleted!','Your file has been deleted.','success')
             this.loadTodo()
                                                
        }).catch(()=> {
            swal.fire("Failed!", "There was something wronge.", "warning");
            });
        }
        })
    },







     ///////////////////////////////////////////////////////////////////////////////////
    today() {
      this.$refs.calendar.fireMethod('today')
      console.log('today'); 
    },  
    next() {
      this.$refs.calendar.fireMethod('next') 
      this.setStartEnd()
      this.loadStatistics()
      this.loadCalendar()  
    },
    prev() {
      this.$refs.calendar.fireMethod('prev')
      this.setStartEnd()
      this.loadStatistics()
      this.loadCalendar()  
    },   
    setStartEnd() {
      this.start = this.$refs.calendar.fireMethod('getView').start.format('YYYY-MM-DD')
      this.end = this.$refs.calendar.fireMethod('getView').end.add(-1, 'd').format('YYYY-MM-DD')
        //moment().add(-1, 'd')
    },
    changeView(view){
      this.$refs.calendar.fireMethod('changeView', view)
      this.setStartEnd() 
      this.loadStatistics()
      this.loadCalendar()  
    },  
    scrollTime(){
      console.log('scrollTime');
    },     
    changeMonth(start, end, currentMonthStartDate) {
      console.log(currentMonthStartDate); // the start date of the current month after changing month by clicking the '<'(previous) or '>'(next) button
    },
    loadStatistics(){
      axios.get('/v1/api/home/loadstatistics?start_t='+this.start+'&end_t='+this.end).then((res) => {
      if(res.data) {       
          this.setStats(res)
      }})
      .catch((error) => {
        if(error.response.status === 422) {
          this.errors = error.response.data.errors
        }      
    })
    },
    loadCalendar(){
      axios.get('/v1/api/home/admincalendar?start_t='+this.start+'&end_t='+this.end).then((res) => {
      if(res.data) {       
          this.setData(res)
      }})
      .catch((error) => {
        if(error.response.status === 422) {
          this.errors = error.response.data.errors
        }       
    })
    },
     loadTodo(){
      axios.get('v1/api/todos/index').then((res) => {
      if(res.data) {       
          this.setDataTodo(res)
      }})
      .catch((error) => {
        if(error.response.status === 422) {
          this.errors = error.response.data.errors
        }       
    })
    },

    dayClick(date, jsEvent, view){ 
      console.log(date + jsEvent + view)
    },
     handleDateClick(arg) {
      alert(arg.date)
    }, 
    setData(res) { 
      this.unassignedtasks = res.data.unassignedtasks      
      this.assignedtasks = res.data.assignedtasks
      this.events = res.data.assignedtasks              
      this.locations = res.data.alllocations
      this.assignedtasksCount = this.assignedtasks.reduce(function(prev, cur) { return prev + cur.price_n    }, 0)
      this.unassignedtasksCount = this.unassignedtasks.reduce(function(prev1, cur2) { return prev1 + cur2.price_n    }, 0)
    },
    setStats(res) { 
      this.dueTasksCount = res.data.dueTasksCount
      //this.unassignedtasksCount = res.data.unassignedtasksCount 
      //this.assignedtasksCount = res.data.assignedtasksCount 
      this.charges = res.data.charges   
      
    },  
    setDataTodo(res) { 
      this.todos = res.data.todos  
      this.fieldusers = res.data.fieldusers      
    },  
    eventClick(calEvent, jsEvent, view) {
           var dt = calEvent.start;
           alert('Event Clicked on : ' + calEvent.id);
    },
    eventDrop(drop){ 
          console.log('eventDrop: ' + drop);
    },   
    callModal() {        
      $("#addNew").modal("show")
    },   
    
  },

  

  
};
</script>

<style>
#external-events { 
  padding: 0 10px;
  border: 1px solid #ccc;
  background: #eee;
  text-align: left;
}

#external-events h4 {
  font-size: 16px;
  margin-top: 0;
  padding-top: 1em;
}

#external-events .fc-event {
  margin: 10px 0;
  cursor: pointer;
}

#external-events p {
  margin: 1.5em 0;
  font-size: 11px;
  color: #666;
}

#external-events p input {
  margin: 0;
  vertical-align: middle;
}
</style>
