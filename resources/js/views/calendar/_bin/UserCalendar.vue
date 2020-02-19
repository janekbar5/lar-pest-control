<template>
  <div>




                 <div class="row">    
                  <div class="container-fluid">
                  
                    <div class="row">

                      <div class="col-lg-2 col-6" v-for="stat in statuses" :key="stat.data">                        
                        <div class="small-box ">
                          <div class="inner">
                            <h3>{{stat.count}}</h3>
                            <p>{{stat.title}}</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      
                      <!-- <div class="col-lg-2 col-6">                        
                        <div class="small-box">
                          <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Done Dasks</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                          </div>
                          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                       <div class="col-lg-2 col-6">                        
                        <div class="small-box">
                          <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Done Dasks</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                          </div>
                          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div> -->
                    
                    
                      
                      <div class="col-lg-6 col-6"> 
                         <div class="small-box">
                          <div class="inner">
                            <h3>Todo </h3>
                           
                           
                            <table class="table">
                            <thead>
                              <tr>
                                <th style="width: 10%">#</th>
                                <th style="width: 70%">Task</th>
                                <th style="width: 10%">Label</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="todo in todos" :key="todo.data"> 
                                <td>{{todo.id}}</td>
                                <td>{{todo.title}}</td>
                              
                                <td><span class="badge ">
                                    <i aria-hidden="true" class="fa fa-pen" @click="showModal()"></i>&nbsp;&nbsp;&nbsp;&nbsp;                                
                                  <i aria-hidden="true" class="fa fa-trash" @click="modelDelete(todo)"></i> 
                                    </span>
                                    </td>
                              </tr>
                            </tbody>
                        </table>       

                          </div>
                          <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                          </div>
                          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>


                                      
                        
                      </div>
                    
                    </div>
                  
                    
                  </div>
                </div>

      <div class="row">      
              <div class="col-md-12">
                 
                  <!--<full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" /> -->
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Bordered Table</h3>
                      </div>
                      
                      <div class="card-body">                  
                      <!--<full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" /> -->
                      </div>
                        <full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick" /> 
                     
                      <div class="card-footer clearfix">
                       sdvsdfv
                      </div>
                    </div>
              </div>   
                   
        </div>
      
      <!-- <Modal /> -->

   </div>     
 
</template>

<script>

import moment from "moment"
import "jquery-ui-bundle"
import $ from 'jquery'
//import Modal from './Modal.vue'    

export default {
  name: "hello",
  //components: { Modal },  
  data() {
    var $this = this;
    return {
      unassignedtasks:[],
      value:'',
      events: {}, 
      statuses:{},
      todos:{},
      config: {
        defaultView: "agendaWeek",
        //defaultView: "month",
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
        drop(calEvent, jsEvent, view) {
          // is the "remove after drop" checkbox checked?
          if ($("#drop-remove").is(":checked")) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
            //console.log(calEvent)
            alert('jan1')  
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
          alert('jan2')   
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
    axios.get('/v1/api/tasks/usercalendar').then((res) => {
     if(res.data) {     
      this.events = res.data.userstasks
      this.statuses = res.data.statuses
      }
      })
      .catch((error) => {
        if(error.response.status === 422) {
          this.errors = error.response.data.errors
        }
        this.isProcessing = false
      })
    
  },
  mounted() {
    //this.getNotifications()
    this.todos = [
      {"id":1,"title":"Lorem ipsum dolor"},
       {"id":2,"title":"Lorem ipsum dolor 2"},
        {"id":3,"title":"Lorem ipsum dolor 3 "},
         {"id":4,"title":"Lorem ipsum dolo  4"},
    ]
  },
  //
  methods: {
    callModal() {        
      $("#addNew").modal("show")
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
