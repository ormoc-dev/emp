document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    fetch('/events')
        .then(response => response.json())
        .then(events => {
            var calendarEvents = events.map(event => ({
                title: event.event_name,
                start: event.date_start,
                end: event.date_end,
                extendedProps: {
                    event_subtitle: event.event_subtitle,
                    event_status: event.event_status,
                    event_rounds: event.event_rounds,
                    event_year: event.event_year,
                    event_venue: event.event_venue,
                    updated_at: event.updated_at 
                }
            }));

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: calendarEvents
            });

            calendar.render();
        });
});