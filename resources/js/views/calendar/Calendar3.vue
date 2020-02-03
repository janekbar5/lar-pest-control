<template>
  <div>
             <div class="row">
                
               <div class="col-md-3">
                   <div id='external-events'>
                    <div id='external-events-listing' @mouseover="getNotifications">
                        <h4> Tasks </h4> 
                        <div  v-bind:style="{ 'background-color': per.statuses.colour }" class="fc-event" v-for="(per, idx) in persons" v-bind:key="idx" v-bind:id="per.id">
                          {{ per.title }}
                           {{ per.locations.title }}
                          </div>
                    </div>

                      
                      <p style="display:none">
                        <input type='checkbox' id='drop-remove' checked='checked' />
                        <label for='drop-remove'>remove after drop</label>
                      </p>
                    </div>                                                                            
               </div>
                                                           
              <div class="col-md-9">                
                  <full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" />                
               </div>                               
                   
            </div>
         </div>
     
  </div>
</template>

<script>

import moment from "moment";
import "jquery-ui-bundle";
import $ from 'jquery'

export default {
  name: "hello",
  data() {
    var $this = this;
    return {
      persons:[],
      value:'',
      events: [
        {"id":1,title: "test 1","start":"2020-02-05","end":"2020-02-05",color: '#01bd61',eventTextColor:'#fff',allDay:false},// #c9b606 yellow
        {"id":2,title: "test 2","start":"2020-02-07","end":"2020-02-07",color: '#01bd61',eventTextColor:'#fff',allDay:false},// #0c6924 green
        {"id":3,title: "test 3","start":"2020-02-15","end":"2020-02-15",color: '#01bd61',eventTextColor:'#fff',allDay:false},// #9c0505 red
        {"id":4,title: "test 4","start":"2020-02-12","end":"2020-02-12",color: '#01bd61',eventTextColor:'#fff',allDay:false},
        {"id":5,title: "test 5","start":"2020-02-13","end":"2020-02-14",color: '#ff3142',eventTextColor:'#fff',allDay:false},
             
      ],
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
        allDaySlot: false,
        //////////////////////////////////////////////////////////////////////
        drop(calEvent, jsEvent, view) {
          // is the "remove after drop" checkbox checked?
          if ($("#drop-remove").is(":checked")) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
            console.log(calEvent)
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
        // eventClick() {
        //   alert('eventClick')
        //   console.log(event.target.innerText)
        // },
        eventClick(calEvent, jsEvent, view) {
        var dt = calEvent.start;
          alert('Event Clicked on : ' + calEvent.id);
         // var r = confirm("Delete " + calEvent.title + "\n" + dt);
          console.log(calEvent)
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
    axios.get('/v1/api/tasks/index').then(res => (this.persons = res.data.results.data))
  },
  mounted() {
    //this.getNotifications()
  },
  //
  methods: {
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
