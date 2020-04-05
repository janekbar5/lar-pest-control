<template>
  <div>
      
      <div class="row">
                
               <div class="col-md-2">

                   <div id='external-events'>
                    <div id='external-events-listing' @mouseover="getNotifications">
                        <h4> Unassigned Tasks </h4> 
                       <!-- v-show="per.selected_users.length === 0"-->
                    <div 
                    :class="per.price"
                    :alt="per.location_id"
                    :data-title="per.title_t"
                    :data-price="per.price_n" 
                    :data-start="per.start|formatDateNoSeconds" 
                    :data-end="per.end|formatDateNoSeconds" 
                    :data-status_id="per.status_id_n" 
                    :data-location_id="per.location_id" 
                    v-bind:style="{ 'background-color': per.statuses.colour }" 
                    class="fc-event" v-for="(per, idx) in unassignedtasks" 
                    v-bind:key="idx" v-bind:id="per.id">
                    Id:{{ per.id }} </br>
                    Title:{{ per.title_t }} </br>
                    Status:{{ per.status_id_n }} </br>
                    Users: {{ per.locations.users }}</br>
                    {{ per.locations.title }} {{ per.start_t | formatDayOnly }} {{ per.start_t | formatDate }} {{ per.end_t | formatDate }} 

                     <!-- <label v-for="(user, idx) in per.users" v-bind:key="idx" >{{user}}</label> -->

                    </div>
                    </div>
                      
                      <p style="display:none">
                        <input type='checkbox' id='drop-remove' checked='checked' />
                        <label for='drop-remove'>remove after drop</label>
                      </p>
                    </div>

                   


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
               
               </div>  


            
                 
               
              <div class="col-md-10">                 
                
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

                      
                      
                        <full-calendar 
                        id="calendar" 
                        ref="calendar" 
                        :config="config" 
                        :events="events"                        
                        @day-click="dayClick" 
                        @event-receive="onEventReceive"  
                        @event-selected="eventClick"                        
                         />  

                      <div class="card-footer clearfix">
                     <!-- {{events}} -->
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
                    
                    <h5 class="modal-title"  id="addNewLabel">Assign Users</h5>
                    <button type="button" class="close" @click="clear()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form @submit.prevent="updateAssignment()">
                <div class="modal-body">

                    <div class="form-group">
                        <input v-model="form.title_t" type="text" name="title" placeholder="title"  class="form-control" :class="{ 'is-invalid': form.errors.has('title_t') }" disabled>
                        <has-error :form="form" field="title"></has-error>
                    </div> 

                     <div class="row">
                                <div class="col-md-6">                                   
                                    <div class="form-group">
                                        <label>Start</label>     
                                        <Datepicker format="YYYY-MM-DD H:i" v-model="form.start_t"  :class="{ 'is-invalid': form.errors.has('start_t') }" />                                          
                                        <has-error :form="form" field="start_t"></has-error>
                                         
                                     </div>  
                                </div> 
                                <div class="col-md-6">                                   
                                    <div class="form-group">
                                        <label>End</label>     
                                         <Datepicker format="YYYY-MM-DD H:i" v-model="form.end_t" class="" :class="{ 'is-invalid': form.errors.has('end_t') }" />   
                                         <has-error :form="form" field="end_t"></has-error>
                                         
                                     </div>  
                                </div>                                  
                            </div>


                    <div class="form-group">
                     
                    </div>

                    <div style="display:none">

                     <div class="form-group">
                        <input v-model="form.itemid" type="text" name="itemid"  placeholder="itemid"  class="form-control" :class="{ 'is-invalid': form.errors.has('itemid') }">
                        <has-error :form="form" field="itemid"></has-error>
                    </div>

                    
                        <div class="form-group">
                            <input v-model="form.price_n" type="text" name="price" placeholder="price" class="form-control" :class="{ 'is-invalid': form.errors.has('price_n') }">
                            <has-error :form="form" field="price_n"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.status_id_n" type="text" name="status_id_n" placeholder="status_id_n"  class="form-control" :class="{ 'is-invalid': form.errors.has('status_id_n') }">
                            <has-error :form="form" field="status_id"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.location_id" type="text" name="location_id" id="location_id" ref="location_id"
                                placeholder="location_id"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('location_id') }">
                            <has-error :form="form" field="location_id"></has-error>
                        </div>
                    </div>
                    <small v-show="loading == true" class="badge badge-success"><i class="far fa-clock"></i> Loading...</small>
                                         
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
      unassignedtasks:[],value:'',location:'',
      events: [],
      // events: [ // 
      //  { title: 'event 1', start: '2020-03-01',end: '2020-03-02' },
      //  { title: 'event 2', start: '2020-03-04',end: '2020-03-05' }
      // ],
      locations:[],locationdata:[],variableToPass:'',
      //
      tasksbydate:[], tasksbydate_date:'',allAvailableFieldUsers:[],
      //
      //start:'',  
      time:'',datetime13:'', usersMultiselectBox:false, janek:'',
      config: {          
        //defaultView: "agendaWeek",
        defaultView: "month",editable: true,droppable: true,eventLimit: true,
        nowIndicator: true, slotDuration: "01:00:00", slotLabelInterval: "01:00:00",
        height: "auto", contentHeight: "auto", slotLabelFormat: "LT",
        allDayText: "All Day Events",        
        //allDaySlot: false,
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
            el.data("event", { id: event.id,title: event.title,start: event.start,eventSources: [{url: '/myfeed.php'}], stick: true });
          }
        },
        //////////////////////////////////////////////////////////////////////
        
      },
        
      //////////config
      form: new Form({                   
        title_t : '',
        start_t: '',
        end_t: '',        
        price_n: '',
        status_id_n: '',
        users: [],
      }),
      //
      counter: 0,
      freefieldusers:[], //dont need allPermissions in form only selected
      //
      loading:true,

    };
  },
  //data
 

  created() { 
    this.loadCalendar() 
  },

  watch: {
            'form.start_t': function(newVal1) {              
                this.newStart = newVal1
                this.getFreeUsers()  
                //console.log(newVal1)
            },
            'form.end_t': function(newVal2) { 
                this.newEnd = newVal2
                this.getFreeUsers() 
                //console.log(newVal2)                          
            }, 
                   
  },
  //
  methods: {
    //////////////////////////////////////////////////////////////////////////////////////////////ON DROP
    onEventReceive(date, jsEvent, resource){
      if ($("#drop-remove").is(":checked")) {  
        $(this).remove();
      }  
      $("#assignTaskToUserModal").modal("show")  ///////////////////////////////////////////////// 1 Modal open fill fields
      this.form.start_t = moment(date.start._d).format('YYYY-MM-DD hh:mm')      
      this.form.end_t = moment(date.start._d).add(14, 'hours').format('YYYY-MM-DD HH:m') //02
      this.form.itemid = date.id
      this.form.title_t = date.className[0].title
      this.form.location_id = date.className[0].location_id
      this.form.price_n = date.className[0].price
      this.form.status_id_n = date.className[0].status_id
      //console.log(date)    
    },



    refetchEvents(){ 
    this.$refs.calendar.fireMethod('refetchEventSources')
    this.$refs.calendar.fireMethod('changeView', 'month')
    },
    nameWithNameLastName ({ name, last_name }) {
        return `${name} ${last_name}`
    },
    clear(){
      this.usersMultiselectBox = false
      //console.log(this.usersMultiselectBox)
      this.form.users = []
      //this.allAvailableFieldUsers = [];
      $("#assignTaskToUserModal").modal("hide")
      this.errors = ''
      this.form.reset()
      this.loadCalendar()           
    },   
    getFreeUsers(){ 
        this.loading = true //the loading begin        
        axios.get('/v1/api/tasks/getfreefieldusersfordate?start_t='+ this.form.start_t+'&end_t='+this.form.end_t)        
        .then((res) => {            
            this.setTasksByDate(res)
            this.loading = false   
        })
    // }  
    },
     setTasksByDate(res) { 
      this.allAvailableFieldUsers = res.data.allAvailableFieldUsers
      this.usersMultiselectBox = true
      //console.log(this.usersMultiselectBox) 
    }, 
     setFreeUser(res) {  
      this.allAvailableFieldUsers = res.data.allAvailableFieldUsers     
    }, 
    ///////////////UPDATE
    updateAssignment(){
                this.$Progress.start();
                this.form.post('/v1/api/tasks/update/'+this.form.itemid)
                .then(()=>{                   
                    this.form.reset();                    
                    this.clear()
                    $('#assignTaskToUserModal').modal('hide')                   
                    this.loadCalendar()
                    toast({type: 'success', title: 'User Created in successfully'})
                   
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
    eventClick() {     
      alert('eventClick')
      console.log(event.target.innerText)
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
        className: [
          { 
          location_id: $(this).data("location_id"),
          price: $(this).data("price"),
          status_id: $(this).data("status_id"),
          title: $(this).data("title"),
          }],
        //$('#itemid').val($(this).attr("id"));             
        //     $('#title').val($(this).data("title"));
        //     $('#price').val($(this).data("price"));
        //     $('#status_id').val($(this).data("status_id"));
        //     $('#location_id').val($(this).data("location_id")); 
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
/* .fc-more-popover {
    z-index: 2;
    width: 300px;
}
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
} */
</style>
