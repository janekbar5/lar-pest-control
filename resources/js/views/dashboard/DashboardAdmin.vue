<template>
  <div>
      
                 <section  class="content"> 

      <div class="container-fluid">      
        <div class="row">
          
          <div class="col-lg-3 col-6">
           
            <div class="small-box">
              <div class="inner">
                <h3>{{dueTasksCount}}</h3>
                <p>Unassigned Due Tasks</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        
          <div class="col-lg-3 col-6">         
            <div class="small-box">
              <div class="inner">
                <h3>0</h3>
                <p>Tasks assigned but not done</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        
          <div class="col-lg-3 col-6">
           
            <div class="small-box">
              <div class="inner">
                <h3>0</h3>
                <p>Total charges for today</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        
          <div class="col-lg-3 col-6">
           
            <div class="small-box ">
              <div class="inner">
                <h3>{{charges}}</h3>

                <p>Total charges</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        
        </div>
         
      </div>
    </section> 
      <div class="row">
              <div class="col-md-12">                 
                 
                    <div class="card">
                      <div class="card-header">
                        <!-- <h3 class="card-title">Bordered Table</h3> -->
                      </div>
                      
                      <div class="card-body"> 
                       <!-- <select @change="filterLocation()" v-model="location" class="form-control">
                        <option value="" selected>All Locations</option>
                         <option :value="location.id" v-for="(location, index) in locations" :key="index">
									        	{{ location.title }} 
									     	</option>                                       
                       </select> -->
                          <button class="btn btn-secondary" @click="prev"><< Prev</button>
                          <button class="btn btn-secondary" @click="next">Next >></button>
                          <button class="btn btn-secondary" @click="today">Today</button>                         
                        
                          <button class="btn btn-secondary" @click="changeView('month')">Month</button>
                          <button class="btn btn-secondary" @click="changeView('agendaWeek')">Week</button>
                          <button class="btn btn-secondary" @click="changeView('agendaDay')">Day</button>
                          
                      </div>

                       




                      <!-- <button id="next" @click="next()">next</button> -->

                        <!-- <full-calendar id="calendar" :config="config" :events="events" @dateClick="handleDateClick"  />  -->
                        <full-calendar 
                        :header="{
                            left:'',
                            center: 'title',
                            right: '',
                          }"
                        :config="config" 
                        :events="events"                        
                        @day-click="dayClick" 
                        @scrollTime="scrollTime" 
                        ref="calendar"   
                        @changeMonth="changeMonth"                    
                         /> 
                        <!-- 
                        @event-selected="eventClick"       
                        @event-drop="eventDrop"
                        @drop="eventDrop"
                         -->
                        
                        <!--:header="{
                            left:'',
                            center: 'title',
                            right: '',
                          }"-->


                     
                      <div class="card-footer clearfix">
                       sdvsdfv
                      </div>
                    </div>
              </div>   
                   
        </div>
      



   



   </div>     
 
</template>

<script>

import moment from "moment"
import "jquery-ui-bundle"
import $ from 'jquery'
import FullCalendar from "vue-full-calendar";   


export default {
  name: "hello",
  components: {  },  
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
      freefieldusers:[],
      //
      //start:'',     
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
        //allDayText: "All Day Events",        
        allDaySlot: false,
        //////////////////////////////////////////////////////////////////////
      },        
      //////////config
        start:'',
        end:'',
        dueTasksCount:'',
        charges:'',
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
  },
  //
  methods: {
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
      axios.get('/v1/api/home/loadstatistics?start='+this.start+'&end='+this.end).then((res) => {
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
      axios.get('/v1/api/home/admincalendar?start='+this.start+'&end='+this.end).then((res) => {
      if(res.data) {       
          this.setData(res)
      }})
      .catch((error) => {
        if(error.response.status === 422) {
          this.errors = error.response.data.errors
        }       
    })
    },    
    dayClick(date, jsEvent, view){ 
    },
    setData(res) { 
      this.unassignedtasks = res.data.unassignedtasks
      this.events = res.data.assignedtasks              
      this.locations = res.data.alllocations
    },
    setStats(res) { 
      this.dueTasksCount = res.data.dueTasksCount 
      this.charges = res.data.charges   
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
    handleDateClick(arg) {
      alert(arg.date)
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
