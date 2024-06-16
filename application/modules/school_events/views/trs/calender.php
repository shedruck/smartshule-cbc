<?php
// echo "<pre>";
// print_r($events);
// echo "<pre>"; 
?>


<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><b>EVENTS CALENDER</b></h5>

        <div class="pull-right">
          <?php echo anchor('class_attendance/trs/list', '<i class="mdi mdi-reply"></i>Back', 'class="btn btn-secondary"'); ?>
        </div>

      </div>

      <?php
      $out = [];

      foreach ($events as $keey => $eve) {
        $event = (object) $eve;
        $user = $this->ion_auth->get_user($event->created_by);
        $start = date('Y-m-d', $event->date) . 'T' . date('H:i:s', strtotime($event->start));
        $end = date('Y-m-d', $event->date) . 'T' . date('H:i:s', strtotime($event->end));

        $out[] = array(
          'title' => $event->title,
          'st' => date('H:i A', strtotime($event->start)),
          'en' => date('H:i A', strtotime($event->end)),
          'type' => 'event',
          'date' => date('d M Y', $event->date),
          'start' => $start,
          'end' => $end,
          'venue' => $event->venue,
          'event_title' => $event->title,
          'cache' => 1,
          'color' => $event->date < time() ? '#23b7e5' : 'green',
          'bg' => '#845adf',
          'description' => $event->description,
          'user' => $user->first_name . ' ' . $user->last_name
        );
      }

      foreach ($school_events as $ky => $seve) {
        $sevent = (object) $seve;
        $user = $this->ion_auth->get_user($sevent->created_by);
        $start = date('Y-m-d', $sevent->start_date) . 'T' . date('H:i:s', $sevent->start_date);
        $end = date('Y-m-d', $sevent->end_date) . 'T' . date('H:i:s', $sevent->end_date);

        $out[] = array(
          'title' => $sevent->title,
          'st' => date('d M Y', $sevent->start_date),
          'en' => date('d M Y', $sevent->end_date),
          'type' => 'sevent',
          'date' => '',
          'start' => $start,
          'end' => $end,
          'venue' => $sevent->venue,
          'event_title' => $sevent->title,
          'cache' => 1,
          'color' => $sevent->end_date < time() ? '#23b7e5' : 'green',
          'bg' => '#845adf',
          'description' => $sevent->description,
          'user' => $user->first_name . ' ' . $user->last_name
        );
      }

      ?>

      <div class="card-body p-2">
        <div class="row">
          <div class="col-xl-3">
            <div id="external-events" style="display: none;">

            </div>
            <div class="mt-2">
              <h4 class="card-title mb-4" style="margin-left:20px"><b>My Schedules</b></h4>
              <div class="card overflow-hidden">
                <div class="py-2">
                  <div class="list-group">

                    <?php

                    foreach ($out as $eve) {
                      $e = (object) $eve;
                      if ($e->type === 'event') {


                        $date = date('d M', strtotime($e->date));
                        list($day, $month) = explode(' ', $date);
                    ?>

                        <div class="list-group-item d-flex pt-3 pb-3 border-0">
                          <div class="me-3 me-xs-0">
                            <div class="calendar-icon icons">
                              <div class="date_time bg-secondary-transparent ">
                                <span class="date"><?php echo $day; ?></span> <span class="month"><?php echo $month; ?></span></span>
                              </div>
                            </div>
                          </div>
                          <div class="ms-1">
                            <div class="h5 fs-14 mb-1"><?php echo $e->title; ?></div>
                            <small class="text-muted"><b>Time: <?php echo $e->st; ?> <?php echo empty($e->en) ? '' : '-' . $e->en; ?>
                              </b></small><br>
                            <?php
                            if (!empty($e->venue)) {
                            ?>
                              <small class="text-muted"><b>Venue: <?php echo ucwords($e->venue); ?>
                                </b></small><br>
                            <?php } ?>
                            <small class="text-muted"><?php echo ucwords($e->description); ?>
                            </small>
                          </div>
                        </div>
                    <?php
                      }
                    }
                    ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-9">
            <div class="card p-2 mt-5">
              <div class="col-md-12 bg-white" id="calendarrow">
                <div class="col-md-12 col-lg-12 col-sm-12">
                  <div id="calendar">

                  </div>
                </div>
              </div>


              <script>
                document.addEventListener('DOMContentLoaded', function() {
                  var calendarEl = document.getElementById('calendar');

                  //Monthly Calendar
                  var calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                      left: 'prev,next today',
                      center: 'title',
                      right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    initialDate: '<?php echo date('Y-m-d') ?>',
                    navLinks: true, // can click day/week names to navigate views
                    businessHours: true, // display business hours
                    editable: true,
                    selectable: true,
                    events: [
                      <?php foreach ($out as $key => $t) {
                        $eve = (object) $t;
                        if ($eve->type === 'event') {
                      ?> {
                            title: '<?php echo $eve->title . ' - Venue (' . $eve->venue . ')' ?>',
                            start: '<?php echo $eve->start ?>',
                            end: '<?php echo $eve->end ?>',
                            constraint: 'businessHours',
                            color: '<?php echo $eve->color ?>',
                            backgroundColor: '<?php echo $eve->bg ?>',
                          },
                      <?php }
                      } ?>

                    ]
                  });

                  calendar.render();
                });
              </script>

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