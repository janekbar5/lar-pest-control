<template>
  <div id="app">
      <div id='draggable-el' data-event='{ "title": "my event", "duration": "02:00" }'>drag me</div>
    <button @click="refreshEvents">Refresh2</button>
    <button v-if="selected._id" @click="removeEvent">Remove</button>
    <pre>{{ selected }}</pre>
    <full-calendar 
                   ref="calendar" 
                   :event-sources="eventSources"
                   @event-selected="eventSelected" 
                   @event-created="eventCreated"
                   @dateClick="handleDateClick"
                   :config="config">
    </full-calendar>
  </div>
</template>

<script>
import moment from 'moment';
export default {
  name: 'app',
  data() {
    return {
      events: [
        {
          id: 1,
          title: 'event janek 1',
          start: '2020-02-02 07:30',
          end: '2020-02-02 09:30',
          allDay: true,
        },
        {
          id: 2,
          title: 'event janek 2',
          start: '2020-02-05 01:30',
          end: '2020-02-05 03:30',
          allDay: false,
        },
        {
          id: 3,
          title: 'event3 3',
          start: '2020-02-08 02:30',
          end: '2020-02-08 03:30',
          allDay: false,
        },
      ],
      config: {
        //defaultView: "month",
        defaultView: "agendaWeek",  
        /*eventClick: (event) => {
          this.selected = event;
        },*/
      },
      selected: {},
    };
  },
  methods: {
    handleDateClick(arg) {
        alert(arg.date)
    },  
    refreshEvents() {
      this.$refs.calendar.$emit('refetch-events');
    },
    removeEvent() {
      this.$refs.calendar.$emit('remove-event', this.selected);
      this.selected = {};
    },
    eventSelected(event) {
      this.selected = event;
    },
    eventCreated(...test) {
      console.log(test);
    },
  },
  computed: {
    eventSources() {
      const self = this;
      return [
        {
          events(start, end, timezone, callback) {
            setTimeout(() => {
              callback(self.events);
            }, 100);
          },
        },
      ];
    },
  },
};
</script>

<style>
@import '~fullcalendar/dist/fullcalendar.css';
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>