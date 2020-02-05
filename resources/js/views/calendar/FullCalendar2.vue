<template>
    <div class="home">
        
        
        <div class="sidebar__content">
                

                <div id="external_events">

                    <div class="fc-event">
                        <div class="type">HW</div>
                        <div class="class">Engels</div>
                        <div class="date"> 
                            <span class="date__day">3</span>
                            <span class="date__month">mei</span>
                        </div>
                    </div>
                    <div class="fc-event">
                        <div class="type">HW</div>
                        <div class="class">Aardrijkskunde</div>
                        <div class="date"> 
                            <span class="date__day">5</span>
                            <span class="date__month">mei</span>
                        </div>
                    </div>
                    <div class="fc-event">
                        <div class="type">HW</div>
                        <div class="class">Engels</div>
                        <div class="date"> 
                            <span class="date__day">3</span>
                            <span class="date__month">mei</span>
                        </div>
                    </div>
                </div>
            </div>
        
        <div class="calendar_wrap">
            <full-calendar :config="config" :events="agenda_items"  @event-selected="eventClick"/>
        </div>

        <div class="sidebar">

            <div class="sidebar__header">
                <button @click="collapse" class="close" aria-label="Close menu" type="button">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.66666 4L13.3333 10.6667L6.66666 17.3333" stroke="#B3ECFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

             
            </div>

            
        </div>
    </div>
</template>

<script>
import { FullCalendar } from 'vue-full-calendar'
import 'fullcalendar/dist/locale/nl'
//import navHeader from '../components/navHeader.vue'
// import mSidebar from '../components/mSidebar.vue'
import Swal from 'sweetalert2'

export default {
    components: {
        FullCalendar,
        //navHeader,
        // 'sidebar': mSidebar,
    },
    data() {
        return {
            agenda_items: [],
            config: {
                locale: 'en',
                droppable: true,                
                eventRender(event, element) {
                    element.find('.fc-content').append('<i class="delete fas fa-trash-alt"></i> <span class="description">' + event.description + '</span>');

                    element.find(".delete").click(function() {
                        Swal.fire({
                            title: 'Weet je het zeker?',
                            text: "Je staat op het punt dit item te verwijderen",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ja, verwijderen'
                            }).then((result) => {
                                if (result.value) {
                                    $('#calendar').fullCalendar('removeEvents', event._id);

                                    axios.delete('/agenda_items/'+ event.id)

                                    Swal.fire(
                                    'Verwijderd!',
                                    'De afspraak is verwijderd.',
                                    'success'
                                    )
                                }
                            })
                    });
                },
                drop(info) {
                    // remove the element from the "Draggable Events" list
                    $(this).remove();
                    console.log(info)
                    //this.collapse()
                },
                eventDragStop: function( event, jsEvent, ui, view ) {

                    var isEventOverDiv = function(x, y) {

                        var external_events = $( '#external_events' );
                        var offset = external_events.offset();
                        offset.right = external_events.width() + offset.left;
                        offset.bottom = external_events.height() + offset.top;

                        // Compare
                        if (x >= offset.left
                            && y >= offset.top
                            && x <= offset.right
                            && y <= offset .bottom) { return true; }
                        return false;
                    }

                    if(isEventOverDiv(jsEvent.clientX, jsEvent.clientY)) {
                        $('#calendar').fullCalendar('removeEvents', event._id);
                        var el = $( "<div class='fc-event'>" ).appendTo( '#external_events_listing' ).text( event.title );
                        el.draggable({
                            zIndex: 999,
                            revert: true, 
                            revertDuration: 0 
                        });
                        el.data('event', { title: event.title, id :event.id, stick: true });
                    }
                },
            },
        }
    },
    mounted() {
        this.get_agenda_items();
        this.makeDraggable();
    },
    methods: {
        collapse(){
          console.log('collapse')  
        },
        get_agenda_items() {
           //this.agenda_items = data;
           this.agenda_items = [
            { id: 1, title: 'event janek 1', start: '2020-02-02 07:30',end: '2020-02-02 09:30',allDay: false, },
            { id: 2, title: 'event janek 2', start: '2020-02-05 07:30',end: '2020-02-05 09:30',allDay: false, },
            { id: 3, title: 'event janek 3', start: '2020-02-06 07:30',end: '2020-02-06 09:30',allDay: true, },   
            ]
           
        },
        refresh() {
            this.get_agenda_items();
            $('.refresh').toggleClass("rotate");

        },
        makeDraggable() {
            // initialize the external events
            $('#external_events').sortable()
            var elements = $('#external_events .fc-event')
            elements.each(function() {
                // store data so the calendar knows to render an event upon drop
                $(this).data('event', {
                    title: $.trim($(this).text()), // use the element's text as the event title
                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                });

            });
        },
        eventClick22(item) {
            alert(item)
            //var data = item.id
            //this.$router.push({ path: '/agendaitem/' + data });
        },
        eventClick(calEvent, jsEvent, view) {
           var dt = calEvent.start;
           alert('Event Clicked on : ' + calEvent.id);
        },
        eventDrop(info) {
            alert(info.event.title + " was dropped on " + info.event.start.toISOString());

            if (!confirm("Are you sure about this change?")) {
              info.revert();
            }
        },
       
        
    },
  }
</script>