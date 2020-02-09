<template>
    <div>
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


        <FullCalendar
            ref="pickupCalendar"
            
            lang="de"
            :plugins="plugins"         
            editable="true"
            droppable="true"
            :events="events"
            v-on:eventDrop="eventDrop"
            v-on:drop="itemDrop"
        ></FullCalendar>
    </div>
</template>

<script>
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction';
    export default {
        components: {
            FullCalendar // make the <FullCalendar> tag available
        },
        data() {
            return {
                plugins: [dayGridPlugin, interactionPlugin],
                 config: {
                    selectable: true,
                    locale: 'en',
                    droppable: true,
                 },
                events: [
                    { title: "Event Now", start: new Date() }
                ]
            }
        },
        methods: {
            eventDrop(eventInfo) {
                console.log(eventInfo);
            },
            itemDrop(eventInfo) {
                console.log(eventInfo);
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
        },
        mounted() {
             this.makeDraggable();
            console.log('Component mounted.')
        }
    }
</script>