@extends('admin.includes.Template')
@section('content')
<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
        padding: 10px;
        background: #fff;
        min-height: 600px;
    }

/* .fc-event {
  margin-right: 2px;
}
.fc-timegrid-event {
  max-width: 13% !important;
  margin-left: 10px;
}

.fc-timegrid-event {
  margin-right: 5px;
  border-radius: 6px;
  font-size: 12px;
  padding: 2px 4px;
  background-color: #3a87ad; /* optional */
} */
.fc-event .fc-custom-title {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 11px;
    padding: 2px;
}
.fc-timeGridDay-view .fc-event {
    max-width: 150px;
    margin: 0 auto; /* center events horizontally */
}
/* Remove left margin/padding of events in timeGrid view */
.fc-timegrid-event-harness {
    margin-left: 0 !important;
}

.fc-timegrid-event {
    margin-left: 0 !important;
    padding-left: 4px !important;
    border-left: none !important;
    border-radius: 4px;
}


</style>

<div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Calendar</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        {{-- <li class="breadcrumb-item"><a href="{{ route('state.index') }}">System</a></li> --}}
                        <li class="breadcrumb-item active">Calendar</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTitle">Order Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
              <!-- Order details will be inserted here -->
            </div>
          </div>
        </div>
      </div>
      
@stop

@section('footer_js')

<script src="{{ asset('public/admin/assets/plugins/fullcalendar/dist/index.global.js') }}"></script>

<script>
 /* document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

   var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
	
    initialView: 'timeGridWeek',
    navLinks: true,
    allDaySlot: false, 
    //slotDuration: '00:30:00',
    editable: false,
    dayMaxEvents: true,
    events: @json($events),

    eventContent: function(arg) {
        return {
            html: '<div class="fc-custom-title">' + arg.event.title + '</div>'
        };
    },

    eventDidMount: function(info) {
        new bootstrap.Tooltip(info.el, {
            title: info.event.title,
            placement: 'top',
            trigger: 'hover',
            container: 'body'
        });
    },

    eventClick: function(info) {
        info.jsEvent.preventDefault();
        const existingModal = bootstrap.Modal.getInstance(document.getElementById('orderDetailsModal'));
        if (existingModal) {
            existingModal.hide();
        }
        setTimeout(() => {
            document.getElementById('modalTitle').innerText = info.event.title;
            document.getElementById('modalBody').innerHTML = info.event.extendedProps.details;
            const myModal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
            myModal.show();
        }, 300);
    }
});


    calendar.render();
}); */

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
	
	var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        initialDate: new Date(),
        slotMinTime: '06:00:00',
        slotMaxTime: '20:00:00',
        slotDuration: '00:15:00',
        allDaySlot: false,
        nowIndicator: true,
        expandRows: true,
        height: 'auto',
        eventDisplay: 'block',
		eventOverlap: true,
		slotEventOverlap: true,
        eventMaxStack: 10,
        dayMaxEvents: 4,
		
		headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
	initialView: 'timeGridDay',
    navLinks: true,
    editable: false,
    dayMaxEvents: true,
       
		 events: @json($events),
		eventContent: function(arg) {
            return {
                html: '<div class="fc-custom-title">' + arg.event.title + '</div>'
            };
        },

        eventDidMount: function(info) {
            new bootstrap.Tooltip(info.el, {
                title: info.event.title,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        },

        eventClick: function(info) {
            info.jsEvent.preventDefault();
            const existingModal = bootstrap.Modal.getInstance(document.getElementById('orderDetailsModal'));
            if (existingModal) {
                existingModal.hide();
            }
            setTimeout(() => {
                document.getElementById('modalTitle').innerText = info.event.title;
                document.getElementById('modalBody').innerHTML = info.event.extendedProps.details;
                const myModal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
                myModal.show();
            }, 300);
        }
		
      });
    calendar.render();
});
</script>






@stop
