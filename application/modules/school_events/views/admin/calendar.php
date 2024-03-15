<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Full Calender</h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/school_events/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => ' New Event')), 'class="btn btn-primary"');?>
                <?php echo anchor( 'admin/school_events/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
			
                     </div>    					
                </div>
         	                 
               <div class="block-fluid">
		   
			   
			   <div class="widget-main">
                <div style="backround:#fff !important;" id='calendar'></div>
           </div>
           </div>
          
<!--- Full skul Calendar---->

<?php
$event_data = array();

foreach ($events as $event)
{

    $user = $this->ion_auth->get_user($event->created_by);
    
	$start_date = $event->start_date;
    $end_date = $event->end_date;
    $current = date('Y-m-d', time());
  
     if($end_date<time()){
        $event_data[] = array(
            'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
            'start' => date('d M Y H:i', $event->start_date),
            'end' => date('d M Y H:i', $event->end_date),
            'venue' => $event->venue,
            'event_title' => $event->title,
            'cache' => true,
            'backgroundColor' => 'black',
            'description' => strip_tags($event->description),
            'user' => $user->first_name . ' ' . $user->last_name,
        );
	}
  else{
        $event_data[] = array(
            'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
            'start' => date('d M Y H:i', $event->start_date),
            'end' => date('d M Y H:i', $event->end_date),
            'venue' => $event->venue,
            'event_title' => $event->title,
            'cache' => true,
            'backgroundColor' => $event->color,
            'description' => strip_tags($event->description),
            'user' => $user->first_name . ' ' . $user->last_name,
        );
	}
  
}
?>




<script>

   var cld;

cld = (function($) {
  "use strict";
  var handleNewEventsForm, init, initCalendar, initExternalEvents;
  init = function() {
  
    initCalendar();
    handleNewEventsForm();
  };
  /* initialize the external events*/

 
  /* initialize the calendar*/

  initCalendar = function() {
    var d, date, m, y;
    date = new Date();
    d = date.getDate();
    m = date.getMonth();
    y = date.getFullYear();
    $("#calendar").fullCalendar({
      header: {
        left: "prev,next today",
        center: "title",
        right: "month,agendaWeek,agendaDay"
      },
      events: <?php echo json_encode($event_data); ?>,
      
      
    });
  };
  /* Add a new elements to the "Draggable Events" list */

 
  return {
    init: init
  };
})(jQuery);

          cld.init();
      
</script>		

		   
		   
		   