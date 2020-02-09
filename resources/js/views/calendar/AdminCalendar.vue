<template>
  <div>
      
      <div class="row">
                
               <div class="col-md-3">

                   <div id='external-events'>
                    <div id='external-events-listing' @mouseover="getNotifications">
                        <h4> Unassigned Tasks </h4> 
                       <!-- v-show="per.selected_users.length === 0"-->
 <div  v-bind:style="{ 'background-color': per.statuses.colour }" class="fc-event" v-for="(per, idx) in unassignedtasks" v-bind:key="idx" v-bind:id="per.id">{{ per.title }} {{ per.locations.title }} {{ per.selected_users }}</div>
                    </div>
                      
                      <p style="display:none">
                        <input type='checkbox' id='drop-remove' checked='checked' />
                        <label for='drop-remove'>remove after drop</label>
                      </p>
                    </div>
<!------------------------------------DATTASKS--------------------------------------------->  
                    <!-- DIRECT CHAT -->
                    <div class="card direct-chat direct-chat-warning">
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
                     <div class="direct-chat-msg" v-for="(user, idx) in freefieldusers" v-bind:key="idx" v-bind:id="user.id">
                      {{user.name}}  {{user.last_name}}
                    </div>            
  <!------------------------------------DATTASKS--------------------------------------------->              
               </div>  


            
                 
               
              <div class="col-md-9">
                 
                  <!--<full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" /> -->
                    <div class="card">
                      <div class="card-header">
                        <!-- <h3 class="card-title">Bordered Table</h3> -->
                      </div>
                      
                      <div class="card-body">                  
                      <!--<full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" /> -->
                    <!-- tasksbydate {{ tasksbydate }}</br> -->
                    <!-- <button class="btn btn-danger" @click="push">push</button> -->
                      
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
                        <full-calendar id="calendar" 
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
                       sdvsdfv
                      </div>
                    </div>
              </div>   
                   
        </div>
      
                   <Modal :freefieldusers="freefieldusers" /> 
   </div>     
 
</template>

<script>

import moment from "moment"
import "jquery-ui-bundle"
import $ from 'jquery'
import Modal from './Modal.vue'    


export default {
  name: "hello",
  components: { Modal },  
  data() {
    var $this = this;
    return {
      unassignedtasks:[],
      value:'',
      events: [],
      location:'',
      //location2:'',  
      locations:{},
      locationdata:{},
      variableToPass:'',
      //
      tasksbydate:{}, 
      tasksbydate_date:'',
      freefieldusers:{},
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
        allDayText: "All Day Events",        
        //allDaySlot: false,
        //////////////////////////////////////////////////////////////////////
        eventRender(event, element) {                 
            //event.selected_users.forEach(function (item) {
                      element.find('.fc-content').append(' <i class="delete fas fa-trash-alt"></i> <span class="description"></span>');                      
            //});   
            element.find(".delete").click(function() {
            //console.log(event._id)                    
            $('#calendar').fullCalendar('removeEvents', event._id);
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
                    });
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
          // is the "remove after drop" checkbox checked?
          if ($("#drop-remove").is(":checked")) {            
            $(this).remove();    
            $("#addNew").modal("show")  
            $('#start').val(date.format('YYYY-MM-DD hh:mm'));
            $('#end').val(date.format('YYYY-MM-DD hh:mm'));  
            $('#itemid').val($(this).attr("id")); 
            $('#title').val($(this).html()); 
            this.start = date.format('YYYY-MM-DD hh:mm')           
            //var itemid = $(this).attr("id")  
              // console.log('Clicked on: ' + date.format());
              // console.log('Coordinates: ' + jsEvent);
              // console.log('Current text: ' + $(this).text());
              // console.log('Current html: ' + $(this).html());         
          }           
        },
         eventDrop() {
         alert('eventDrop')
           console.log(event)
        },
       
        //////////////////////////////////////////////////////////////////////
        //eventDragStop: function(event, jsEvent, ui, view) {
        eventDragStop: function(event, jsEvent) {  
          if ($this.isEventOverDiv(jsEvent.clientX, jsEvent.clientY)) {
            $("#calendar").fullCalendar("removeEvents", event._id);
            var el = $("<div class='fc-event'>")
              .appendTo("#external-events-listing")
              .text(event.title);
            el.draggable({
              zIndex: 999,
              revert: true,
              revertDuration: 0
            });
            el.data("event", { title: event.title, id: event.id, stick: true });
          }
        },
        //////////////////////////////////////////////////////////////////////
        
      },
        
      //////////config
    };
  },
  //data
 

  created() { 
    this.loadCalendar()
    
    //console.log(this.externalVar); 
  },
  mounted() {   
  },
  //
  methods: {    
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
    loadCalendar(){
      axios.get('/v1/api/tasks/calendar').then((res) => {
      if(res.data) {       
          this.setData(res)
      }})
      .catch((error) => {
        if(error.response.status === 422) {
          this.errors = error.response.data.errors
        }
       this.isProcessing = false
    })
    },    
    dayClick(date, jsEvent, view){ 
        axios.get('/v1/api/tasks/gettasksbydate?date='+date.format()).then((res) => {
        if(res.data) {       
            this.setTasksByDate(res,date)
        }})
        .catch((error) => {
          if(error.response.status === 422) {
            this.errors = error.response.data.errors
          }
        this.isProcessing = false
      })   
              //console.log('Day Clicked on : ' + calEvent.id);
              // console.log('Clicked on: ' + date.format());
              // console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
              // console.log('Current view: ' + view.name);
    },
    setData(res) { 
      this.unassignedtasks = res.data.unassignedtasks
      this.events = res.data.assignedtasks              
      this.locations = res.data.alllocations
    },
    setTasksByDate(res,date) { 
      this.tasksbydate = res.data.tasksbydate 
      this.tasksbydate_date = date.format() 
      this.freefieldusers = res.data.freefieldusers     
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
            this.locationdata = this.location   
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
