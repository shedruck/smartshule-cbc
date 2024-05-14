<?php
// echo "<pre>";
// print_r($events);
// echo "<pre>";

?>

<script>

(function () {
    "use strict";
    //_____Calendar Events Intialization
  
    // sample calendar events data
    var curYear = moment().format('YYYY');
    var curMonth = moment().format('MM');
    // Calendar Event Source
    var sptCalendarEvents = {
      id: 1,
      events: [{
        id: '1',
        start: curYear + '-' + curMonth + '-02',
        end: curYear + '-' + curMonth + '-03',
        title: 'Spruko Meetup',
        backgroundColor: '#845adf',
        borderColor: '#845adf',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      }, {
        id: '2',
        start: curYear + '-' + curMonth + '-17',
        end: curYear + '-' + curMonth + '-17',
        title: 'Design Review',
        backgroundColor: '#23b7e5',
        borderColor: '#23b7e5',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      }, {
        id: '3',
        start: curYear + '-' + curMonth + '-13',
        end: curYear + '-' + curMonth + '-13',
        title: 'Lifestyle Conference',
        backgroundColor: '#845adf',
        borderColor: '#845adf',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      }, {
        id: '4',
        start: curYear + '-' + curMonth + '-21',
        end: curYear + '-' + curMonth + '-21',
        title: 'Team Weekly Brownbag',
        backgroundColor: '#f5b849',
        borderColor: '#f5b849',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      }, {
        id: '5',
        start: curYear + '-' + curMonth + '-04T10:00:00',
        end: curYear + '-' + curMonth + '-06T15:00:00',
        title: 'Music Festival',
        backgroundColor: '#26bf94',
        borderColor: '#26bf94',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      }, {
        id: '6',
        start: curYear + '-' + curMonth + '-23T13:00:00',
        end: curYear + '-' + curMonth + '-25T18:30:00',
        title: 'Attend Lea\'s Wedding',
        backgroundColor: '#26bf94',
        borderColor: '#26bf94',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      }]
    };
    // Birthday Events Source
    var sptBirthdayEvents = {
      id: 2,
      backgroundColor: '#49b6f5',
      borderColor: '#49b6f5',
      textColor: '#fff',
      events: [{
        id: '7',
        start: curYear + '-' + curMonth + '-04',
        end: curYear + '-' + curMonth + '-04',
        title: 'Harcates Birthday',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      }, {
        id: '8',
        start: curYear + '-' + curMonth + '-28',
        end: curYear + '-' + curMonth + '-28',
        title: 'Bunnysin\'s Birthday',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      }, {
        id: '9',
        start: curYear + '-' + curMonth + '-31',
        end: curYear + '-' + curMonth + '-31',
        title: 'Lee shin\'s Birthday',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      }, {
        id: '10',
        start: curYear + '-' + 11 + '-11',
        end: curYear + '-' + 11 + '-11',
        title: 'Shinchan\'s Birthday',
        description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
      },]
    };
    var sptHolidayEvents = {
      id: 3,
      backgroundColor: '#e6533c',
      borderColor: '#e6533c',
      textColor: '#fff',
      events: [{
        id: '10',
        start: curYear + '-' + curMonth + '-05',
        end: curYear + '-' + curMonth + '-08',
        title: 'Festival Day'
      }, {
        id: '11',
        start: curYear + '-' + curMonth + '-18',
        end: curYear + '-' + curMonth + '-19',
        title: 'Memorial Day'
      }, {
        id: '12',
        start: curYear + '-' + curMonth + '-25',
        end: curYear + '-' + curMonth + '-26',
        title: 'Diwali'
      }]
    };
    var sptOtherEvents = {
      id: 4,
      backgroundColor: '#23b7e5',
      borderColor: '#23b7e5',
      textColor: '#fff',
      events: [{
        id: '13',
        start: curYear + '-' + curMonth + '-07',
        end: curYear + '-' + curMonth + '-09',
        title: 'My Rest Day'
      }, {
        id: '13',
        start: curYear + '-' + curMonth + '-29',
        end: curYear + '-' + curMonth + '-31',
        title: 'My Rest Day'
      }]
    };
  
  
    //________ FullCalendar
    var containerEl = document.getElementById('external-events');
    new FullCalendar.Draggable(containerEl, {
      itemSelector: '.fc-event',
      eventData: function (eventEl) {
        return {
          title: eventEl.innerText.trim(),
          title: eventEl.innerText,
          className: eventEl.className + ' overflow-hidden '
        }
      }
    });
    var calendarEl = document.getElementById('calendar2');
  
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      defaultView: 'month',
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: true,
      selectable: true,
      selectMirror: true,
      droppable: true, // this allows things to be dropped onto the calendar
  
      select: function (arg) {
        var title = prompt('Event Title:');
        if (title) {
          calendar.addEvent({
            title: title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })
        }
        calendar.unselect()
      },
      eventClick: function (arg) {
        if (confirm('Are you sure you want to delete this event?')) {
          arg.event.remove()
        }
      },
  
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      eventSources: [sptCalendarEvents, sptBirthdayEvents, sptHolidayEvents, sptOtherEvents,],
  
    });
    calendar.render();
  
  })();
  
</script>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><b>EVENTS CALENDER</b></h5>

        <div class="pull-right">
          <?php echo anchor('class_attendance/trs/list', '<i class="mdi mdi-reply"></i>Back', 'class="btn btn-secondary"'); ?>
        </div>

      </div>

      <div class="card-body p-2">
        <div class="row">
          <div class="col-xl-3">
            <div id="external-events" style="display: none;">

            </div>
            <div class="mt-2">
              <h4 class="card-title mb-4"><b>My Schedules</b></h4>
              <div class="card overflow-hidden">
                <div class="py-2">
                  <div class="list-group">
                    <div class="list-group-item d-flex pt-3 pb-3 border-0">
                      <div class="me-3 me-xs-0">
                        <div class="calendar-icon icons">
                          <div class="date_time bg-primary-transparent">
                            <span class="date">18</span> <span class="month">FEB</span>
                          </div>
                        </div>
                      </div>
                      <div class="ms-1">
                        <div class="h5 fs-14 mb-1">Board meeting
                          Completed</div> <small class="text-muted">attend the company
                          mangers...</small>
                      </div>
                    </div>
                    <div class="list-group-item d-flex pt-3 pb-3 border-0">
                      <div class="me-3 me-xs-0">
                        <div class="calendar-icon icons">
                          <div class="date_time bg-secondary-transparent ">
                            <span class="date">16</span> <span class="month">FEB</span>
                          </div>
                        </div>
                      </div>
                      <div class="ms-1">
                        <div class="h5 fs-14 mb-1">Updated the Company
                          Policy</div> <small class="text-muted">some
                          changes &amp; add the terms &amp; conditions
                        </small>
                      </div>
                    </div>
                    <div class="list-group-item d-flex pt-3 pb-3 border-0">
                      <div class="me-3 me-xs-0">
                        <div class="calendar-icon icons">
                          <div class="date_time bg-success-transparent ">
                            <span class="date">17</span> <span class="month">FEB</span>
                          </div>
                        </div>
                      </div>
                      <div class="ms-1">
                        <div class="h5 fs-14 mb-1">Office Timings
                          Changed</div> <small class="text-muted">
                          this effetct after March 01st 9:00 Am To
                          5:00 Pm</small>
                      </div>
                    </div>
                    <div class="list-group-item d-flex pt-3 pb-3 border-0">
                      <div class="me-3 me-xs-0">
                        <div class="calendar-icon icons">
                          <div class="date_time bg-info-transparent ">
                            <span class="date">26</span> <span class="month">JAN</span>
                          </div>
                        </div>
                      </div>
                      <div class="ms-1">
                        <div class="h5 fs-15 mb-1"> Republic Day
                          Celebrated </div> <small class="text-muted">participate the all
                          employess </small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-9">
            <div class="card p-2 mt-5">
              <div id='calendar2'></div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">

      </div>
    </div>
  </div>
</div>

<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>