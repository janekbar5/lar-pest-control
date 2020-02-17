<template>
  <div>
      
      <div class="row">
                
               <div class="col-md-3">

                   <div id='external-events'>
                    <div id='external-events-listing' @mouseover="getNotifications">
                        <h4> Unassigned Tasks </h4> 
                       <!-- v-show="per.selected_users.length === 0"-->
                    <div 
                    :data-title="per.title"
                    :data-price="per.price" 
                    :data-start="per.start|formatDateNoSeconds" 
                    :data-end="per.end|formatDateNoSeconds" 
                    :data-status_id="per.status_id" 
                    :data-location_id="per.location_id" 
                    v-bind:style="{ 'background-color': per.statuses.colour }" 
                    class="fc-event" v-for="(per, idx) in unassignedtasks" 
                    v-bind:key="idx" v-bind:id="per.id">

                    {{ per.title }} </br>
                    {{ per.locations.title }} {{ per.start | formatDayOnly }} {{ per.start | formatDate }} {{ per.end | formatDate }}  
                    </div>
                    </div>
                      
                      <p style="display:none">
                        <input type='checkbox' id='drop-remove' checked='checked' />
                        <label for='drop-remove'>remove after drop</label>
                      </p>
                    </div>
<!------------------------------------DATTASKS--------------------------------------------->  
                    <!-- DIRECT CHAT -->
                    <div class="card direct-chat direct-chat-warning" v-show="tasksbydate.length > 0">
                      <div class="card-header">
                       
                        <h3 class="card-title">Tasks for {{ tasksbydate_date }}</h3>
                        <div class="card-tools">                     
                        </div>
                      </div>
                    
                      <div class="card-body">                
                        <div class="direct-chat-messages">                      
                          <div class="direct-chat-msg" v-for="(task, idx) in tasksbydate" v-bind:key="idx" v-bind:id="task.id">                  

                          <div class="row">
                            <div  class="col-md-12">
                              <div class="direct-chat-text">
                                  {{task.title}}                            
                                </div>
                                <span class="direct-chat-timestamp float-left">Start {{task.start | formatDate}} End {{task.end | formatDate }}</span>
                            </div>          
                              <div  class="col-md-4" v-for="(user, idx) in task.selected_users" v-bind:key="idx" v-bind:id="user.id">
                                <div class="direct-chat-infos clearfix">
                                  <span class="direct-chat-name float-left">{{user.name}} {{user.last_name}}</span>                          
                                </div>                           
                                <img v-if="user.firstPhoto == null" :src="'https://dummyimage.com/40x30/807c80/fff'" style="width:40px;height:30px">
                                <img v-else :src="'images/thumb_medium-' + user.firstPhoto.path" style="width:40px;height:30px" class="direct-chat-img">
                                
                            </div>                    
                          </div> 
                          </div>
                        </div>                    
                      </div>
                    
                      <div class="card-footer">                   
                      </div>                    
                    </div>   


                    <div class="card direct-chat direct-chat-warning" v-show="freefieldusers.length > 0">
                     <h3 class="card-title">Available users</h3></br>
                     <div class="direct-chat-msg" v-for="(user, idx) in freefieldusers" v-bind:key="idx" v-bind:id="user.id">
                      {{user.name}}  {{user.last_name}}
                    </div>  
                    </div>            
  <!------------------------------------DATTASKS--------------------------------------------->              
               </div>  


            
                 
               
              <div class="col-md-9">                 
                
                    <div class="card">
                      <div class="card-header">
                       <h3 class="card-title"> Admin User</h3>
                      </div>
                      
                      <div class="card-body">                  
                      <!--<full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" /> -->
                    <!-- tasksbydate {{ tasksbydate }}</br> -->
                    <button class="btn btn-danger" @click="loadCalendar">loadCalendar</button> 
                    <button class="btn btn-danger" @click="refetchEvents">refetchEvents</button>  
                    
                      
                    <!-- events {{ events }} -->
                    <!-- <div v-for="(un, index) in unassignedtasks" :key="index">{{un.title}} </div> -->
                    

                      <select @change="filterLocation()" v-model="location" class="form-control">
                        <option value="" selected>All Locations</option>
                         <option :value="location.id" v-for="(location, index) in locations" :key="index">
									        	{{ location.title }} 
									     	</option>                                       
                       </select>
                      </div>

                      
                        <!-- <full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick"  />  -->
                        <full-calendar 
                        id="calendar" 
                        ref="calendar" 
                        :config="config" 
                        :events="events"                        
                        @day-click="dayClick"                        
                         /> 
                        <!-- 
                        @event-selected="eventClick"       
                        @event-drop="eventDrop"
                        @drop="eventDrop"
                         -->                     
                      <div class="card-footer clearfix">
                     
                      </div>
                    </div>
              </div>   
                   
        </div>
      



        <!-- <Modal :freefieldusers="freefieldusers" />  -->
        <!----------------------- Modal statusesModal------------------------------------>
            <div class="modal fade" id="assignTaskToUserModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true" data-backdrop="static" >
              <!-- @mouseover="getValues" -->
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title"  id="addNewLabel">Update Status</h5>
                    <button type="button" class="close" @click="clear()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="updateAssignment()">
                <div class="modal-body">
                     
                    <div class="form-group">
                        <input v-model="form.start" type="text" name="start" id="start" ref="start"
                            placeholder="start"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('start') }">
                            
                        <has-error :form="form" field="start"></has-error>
                    </div>




                    <!-- <datetime type="time" v-model="time"></datetime>
                    <datetime type="datetime" v-model="datetime13" format="yyyy-MM-dd HH:mm:ss" name="datetime13" id="datetime13" ref="datetime13"></datetime> -->


                    <div class="form-group">
                        <input v-model="form.end" type="text" name="end" id="end" ref="end"
                            placeholder="end"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('end') }">
                            
                        <has-error :form="form" field="end"></has-error>
                    </div>

                    <div style="display:none">

                     <div class="form-group">
                        <input v-model="form.itemid" type="text" name="itemid" id="itemid" ref="itemid"
                            placeholder="itemid"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('itemid') }">
                        <has-error :form="form" field="itemid"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.title" type="text" name="title" id="title" ref="title"
                            placeholder="title"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                        <has-error :form="form" field="title"></has-error>
                    </div>

                        <div class="form-group">
                            <input v-model="form.price" type="text" name="price" id="price" ref="price"
                                placeholder="price"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                            <has-error :form="form" field="price"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.status_id" type="text" name="status_id" id="status_id" ref="status_id"
                                placeholder="status_id"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('status_id') }">
                            <has-error :form="form" field="status_id"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.location_id" type="text" name="location_id" id="location_id" ref="location_id"
                                placeholder="location_id"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('location_id') }">
                            <has-error :form="form" field="location_id"></has-error>
                        </div>
                    </div>


                    <multiselect 
                    v-show="usersMultiselectBox"
                    v-model="form.users" 
                    :options="allAvailableFieldUsers"
                    :custom-label="nameWithNameLastName"                                                                                         
                    placeholder="Select users"
                    :multiple="true"                                            
                    label="name" 
                    track-by="name"
                    :class="{ 'is-invalid': form.errors.has('users') }"
                    >
                    </multiselect>
                     <has-error :form="form" field="users"></has-error>
                
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                    <button  type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-danger" @click="clear()">Close</button>
                </div>

                </form>

                </div>
            </div>
            </div> 
              <!----------------------- Modal end statusesModal------------------------------------>



   </div>     
 
</template>

<script>

import moment from "moment"
import "jquery-ui-bundle"
import $ from 'jquery'
// import Modal from './Modal.vue'    
import Multiselect from 'vue-multiselect'
import Datepicker from 'vuejs-datetimepicker'
//
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

export default {
  name: "hello",
  components: { Multiselect,Datepicker,Datetime },  
  data() {
    var $this = this;
    return {
      //isModalMounted: false,
      unassignedtasks:[],
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
      allAvailableFieldUsers:[],
      //
      //start:'',  
      time:'',
      datetime13:'', 
      usersMultiselectBox:false,  
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
        allDayText: "All Day Events",        
        //allDaySlot: false,
        //////////////////////////////////////////////////////////////////////
        eventRender(event, element) {  
          if(event.end){
             element.find('.fc-content').append('<b>'+event.end.format('HH:mm')+'</b>'); 
           }
            if(event.users) {             
              event.users.forEach(function (item) {
                   
                  element.find('.fc-content').append(' <br><i class="delete fas fa-user"></i> <span class="description">'+item.name+' '+item.last_name+'</span>');                      
              });   
            }

           
            
            //element.find(".delete").click(function() {
            //console.log(event._id)                    
            //$('#calendar').fullCalendar('removeEvents', event._id);
                        // swal.fire({
                        //     title: 'Weet je het zeker?',
                        //     text: "Je staat op het punt dit item te verwijderen",
                        //     type: 'warning',
                        //     showCancelButton: true,
                        //     confirmButtonColor: '#3085d6',
                        //     cancelButtonColor: '#d33',
                        //     confirmButtonText: 'Ja, verwijderen'
                        //     }).then((result) => {
                        //         if (result.value) {
                        //             console.log(event._id)
                        //             $('#calendar').fullCalendar('removeEvents', event._id);

                        //             axios.delete('/agenda_items/'+ event.id)
                        //             swal.fire(
                        //             'Verwijderd!',
                        //             'De afspraak is verwijderd.',
                        //             'success'
                        //             )
                        //         }
                        //     })
                    //});
         },
        //////////////////////////////////////////////////////////////////////
        //drop(calEvent, jsEvent, view) {
        //drop(date, jsEvent, view) {  
        // drop22(info) {
        //             // remove the element from the "Draggable Events" list
        //             $(this).remove();
        //             console.log($(this))
        //             //this.collapse()
        // },
       // drop(date,jsEvent) {
        drop(date, jsEvent, resource){  
          this.usersMultiselectBox = false 
          // is the "remove after drop" checkbox checked?
          if ($("#drop-remove").is(":checked")) {            
            $(this).remove();    
            $("#assignTaskToUserModal").modal("show")  
            ///////////////////////////////////////////////////taken from calendar
            $('#start').val(date.format('YYYY-MM-DD hh:mm'));
            $('#end').val(date.format('YYYY-MM-DD hh:mm'));
            
            

            //$('#start').val($(this).data("start"));
            //$('#end').val($(this).data("end"));

            $('#itemid').val($(this).attr("id")); 
            //$('#title').val($(this).html());
            $('#title').val($(this).data("title"));
            $('#price').val($(this).data("price"));
            $('#status_id').val($(this).data("status_id"));
            $('#location_id').val($(this).data("location_id"));
            

            this.start = date.format('YYYY-MM-DD hh:mm') 
            //var itemid = $(this).attr("id")  
              // console.log('Clicked on: ' + date.format());
              // console.log('Coordinates: ' + jsEvent);
              // console.log('Current text: ' + $(this).text());
              // console.log('Current html: ' + $(this).html());         
          }           
        },
        //  eventDrop() {
        //  alert('eventDrop')
        //    console.log(event)
        // },
       
        //////////////////////////////////////////////////////////////////////
        //eventDragStop: function(event, jsEvent, ui, view) {
        eventDragStop: function(event, jsEvent) {  
          if ($this.isEventOverDiv(jsEvent.clientX, jsEvent.clientY)) {
            $("#calendar").fullCalendar("removeEvents", event._id);
            var el = $("<div class='fc-event'>")
              .appendTo("#external-events-listing")
              .text(event.title)
              .text(event.start)
              .text(event.end);
              el.draggable({
              zIndex: 999,
              revert: true,
              revertDuration: 0
            });
            el.data("event", { id: event.id,title: event.title,start: event.start, stick: true });
          }
        },
        //////////////////////////////////////////////////////////////////////
        
      },
        
      //////////config
      form: new Form({                   
        title : '',
        start: '',
        end: '',
        title: '',
        price: '',
        status_id: '',
        users: [],
      }),
      //
      counter: 0,
      freefieldusers:[], //dont need allPermissions in form only selected

    };
  },
  //data
 

  created() { 
    this.loadCalendar()    
    //console.log(this.externalVar); 
  },
  mounted() {   
  },
  watch: {
            'form.start': function(newVal1) {              
                this.newStart = newVal1
                this.fillForm()  
                //this.getValues()
            },
            'form.end': function(newVal2) { 
                this.newEnd = newVal2
                this.fillForm() 
                //this.getValues()
                           
            },            
  },
  //
  methods: { 
    refetchEvents(){
    //this.$refs.calendar.$emit('refetch-events')
    //this.$refs.calendar.fireMethod('refetchEvents')
    this.$refs.calendar.fireMethod('refetchEventSources')
    this.$refs.calendar.fireMethod('changeView', 'month')
    },
    Search(){
      if (this.newStart && this.newEnd ) {
        //console.log('value changed from ' + this.newStart + this.newEnd );
         axios.get('/v1/api/tasks/getfreefieldusersfordate?start='+this.newStart+'&end='+this.newEnd)
            .then((res) => {                        
            //this.setFreeUser(res) 
        })   
      }
    },
    nameWithNameLastName ({ name, last_name }) {
        return `${name} ${last_name}`
    },
    clear(){
      this.usersMultiselectBox = false
      console.log(this.usersMultiselectBox)
      this.form.users = []
      //this.allAvailableFieldUsers = [];
      $("#assignTaskToUserModal").modal("hide")
      this.form.reset()
      //this.loadCalendar()           
    },  
    fillForm(){
      
      this.form.start = this.$refs.start.value
      this.form.end = this.$refs.end.value 
      this.form.itemid = this.$refs.itemid.value
      this.form.title = this.$refs.title.value
      this.form.price = this.$refs.price.value
      this.form.status_id = this.$refs.status_id.value      
      this.form.location_id = this.$refs.location_id.value
      this.day = moment(String(this.$refs.start.value)).format('YYYY-MM-DD') 
      this.getValues()
    },  
    getValues(){ 
      this.counter++  
      
      //if(this.counter == 1){
      console.log('getValues') 
        //axios.get('/v1/api/tasks/gettasksbydate?date='+this.day)
        axios.get('/v1/api/tasks/getfreefieldusersfordate?start='+ this.form.start+'&end='+this.form.end)        
        .then((res) => {            
            this.setTasksByDate(res)
             //console.log(res)    
        })
    // }  
    },
     setTasksByDate(res) { 
      
      this.allAvailableFieldUsers = res.data.allAvailableFieldUsers
      this.usersMultiselectBox = true
      console.log(this.usersMultiselectBox) 
    }, 
     setFreeUser(res) {  
      this.allAvailableFieldUsers = res.data.allAvailableFieldUsers
      //this.form.users = '' 
    }, 
    ///////////////UPDATE
    updateAssignment(){
                this.$Progress.start();
                this.form.post('/v1/api/tasks/update/'+this.form.itemid)
                .then(()=>{
                    //Fire.$emit('AfterCreate');
                    this.form.reset();                    
                    this.clear()
                    $('#assignTaskToUserModal').modal('hide')
                     //this.loadData()
                    //this.loadCalendar()
                    toast({
                        type: 'success',
                        title: 'User Created in successfully'
                        })
                    this.$Progress.finish();
                })
                .catch(()=>{

                })
    },
    loadCalendar(){      
      axios.get('/v1/api/tasks/calendar').then((res) => {
      if(res.data) {       
          this.setData(res)
      }})
      .catch((error) => {
        if(error.response.status === 422) {
          this.errors = error.response.data.errors
        }
      
    })
    },
    setData(res) { 
      this.unassignedtasks = res.data.unassignedtasks
      this.events = res.data.assignedtasks              
      this.locations = res.data.alllocations
    },    
    ////////////////////////////////////////////////////////////////////////////////////









    hideModal(per){
      $("#addNew").modal("hide")
      $('#calendar').fullCalendar('removeEvents', per.itemid)     
      this.unassignedtasks.push({
        title: per.content,
        start: '2015-11-20T08:30:00',
        end: '2015-11-20T08:30:00',
        statuses:'',
        color: '#C2185B',
        locations:'',
      });
    },
    
    dayClick(date, jsEvent, view){ 
    //     axios.get('/v1/api/tasks/gettasksbydate?date='+date.format()).then((res) => {
    //     if(res.data) {       
    //         this.setTasksByDate(res,date)
    //     }})
    //     .catch((error) => {
    //       if(error.response.status === 422) {
    //         this.errors = error.response.data.errors
    //       }
    //     this.isProcessing = false
    //   })   
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
    filterLocation() {        
        axios    
            .get('/v1/api/tasks/calendar?'+'location='+this.location)
            .then((res) => {
            this.events = res.data.assignedtasks
            //this.locationdata = this.location   
            })
            .catch(error => {				
			this.errored = true
			})
			.finally(() => this.loading = false)	
    }, 

      
    handleDateClick(arg) {
      alert(arg.date)
    },
    isEventOverDiv(x, y) {
      var external_events = $("#external-events");
      var offset = external_events.offset();
      offset.right = external_events.width() + offset.left;
      offset.bottom = external_events.height() + offset.top;

      // Compare
      if (
        x >= offset.left &&
        y >= offset.top &&
        x <= offset.right &&
        y <= offset.bottom
      ) {
        return true;
      }
      return false;
    },
    getNotifications() {
      //alert('fff')
      $("#external-events-listing .fc-event").each(function() {
        //console.log($(this).attr('id'))
      // store data so the calendar knows to render an event upon drop
      $(this).data("event", {
        id:$(this).attr('id'),        
        title: $.trim($(this).text()), // use the element's text as the event title
        start: '2020-02-02 07:30', // use the element's text as the event title
        end: '2020-02-02 07:30', // use the element's text as the event title
        stick: true // maintain when user navigates (see docs on the renderEvent method)
      });
      // make the event draggable using jQuery UI
      $(this).draggable({
        zIndex: 999,
        revert: true, // will cause the event to go back to its
        revertDuration: 0 //  original position after the drag
      });
    });

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
