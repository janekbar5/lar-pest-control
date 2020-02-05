<template>
  <div>
      
      <div class="row">
                
               <div class="col-md-3">
                   <div id='external-events'>
                    <div id='external-events-listing' @mouseover="getNotifications">
                        <h4> Tasks </h4> 
                       <!-- v-show="per.selected_users.length === 0"-->
                          <div  v-bind:style="{ 'background-color': per.statuses.colour }" class="fc-event" v-for="(per, idx) in unassignedtasks" v-bind:key="idx" v-bind:id="per.id">
                          {{ per.title }}
                          {{ per.locations.title }}
                          {{ per.selected_users }}  
                          </div>
                    </div>
                      
                      <p style="display:none">
                        <input type='checkbox' id='drop-remove' checked='checked' />
                        <label for='drop-remove'>remove after drop</label>
                      </p>
                    </div>                                                                            
               </div>    
               
              <div class="col-md-9">
                 
                  <!--<full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" /> -->
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Bordered Table</h3>
                      </div>
                      
                      <div class="card-body">                  
                      <!--<full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" /> -->

                    Location: {{ location }}

                   <select @change="filterLocation()" v-model="location" class="form-control">
                        <option value="" selected>Select Location</option>
                         <option :value="location.id" v-for="(location, index) in locations" :key="index">
									        	{{ location.title }} 
									     	</option>                                       
                       </select>
                      </div>

                      
                        <full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" /> 
                     
                      <div class="card-footer clearfix">
                       sdvsdfv
                      </div>
                    </div>
              </div>   
                   
        </div>
      
                   <Modal />
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
      locations:{},  
      
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
        //drop(calEvent, jsEvent, view) { 
            
        drop(info) {    
          // is the "remove after drop" checkbox checked?
          if ($("#drop-remove").is(":checked")) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
            var now = info._d
            //dateFormat(now, "dddd, mmmm dS, yyyy, h:MM:ss TT");
            var start = moment(String(info._d)).format('YYYY-MM-DD hh:mm')
            var end = moment(String(info._d)).format('YYYY-MM-DD hh:mm')
            //console.log(now2)
            $("#addNew").modal("show")  
            $('#start').val(start);
            $('#end').val(end);  
            $('#location').val(app.location);
            console.log(app)
              //app.callModal()
          }
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
        
        eventClick(calEvent, jsEvent, view) {
        var dt = calEvent.start;
          alert('Event Clicked on : ' + calEvent.id);
         // var r = confirm("Delete " + calEvent.title + "\n" + dt);
          console.log(calEvent)
          //alert('jan2') 
            
          // if (r === true) {
          //   $('#calendar').fullCalendar('removeEvents', calEvent._id);
          // }
      },

        eventDrop() {
         alert('eventDrop')
           console.log(event)
        },
        // dayClick: function(date, jsEvent, view) {
        //     $("#myModal").modal("show");
        // },
        dayClick(){
          alert('dayClick')
        }, 

      }
      //////////config
    };
  },
  //data
  beforeCreate() { 
  },

  created() { 
    axios.get('/v1/api/tasks/calendar').then((res) => {
    if(res.data) {
     this.unassignedtasks = res.data.unassignedtasks
        this.events = res.data.assignedtasks
    }})
    .catch((error) => {
      if(error.response.status === 422) {
        this.errors = error.response.data.errors
      }
      this.isProcessing = false
    })
    
  },
  mounted() {
    this.locations = [
                        {id: 1,title: 'Location 1',age: 30 },
                        {id: 2,title: 'Location 2',age: 30 },
                        {id: 3,title: 'Location 3',age: 30 },
                ]
  },
  //
  methods: {
    callModal() {        
      $("#addNew").modal("show")
    }, 
    filterLocation() {        
        axios    
            .get('/v1/api/tasks/calendar?'+'location='+this.location)
            .then((res) => {
            this.events = res.data.assignedtasks
                   
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
