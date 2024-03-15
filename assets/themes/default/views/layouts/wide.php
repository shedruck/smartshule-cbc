<!DOCTYPE html>
<html lang="en">

<head>
	
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <title><?php echo $template['title']; ?></title>
		<!-- Favicon -->
		<link rel="icon" type="image/png" href="<?php echo image_path('icons/icon.html'); ?>">
		
		<!-- Bootstrap CSS -->
		
		<?php echo theme_css('bootstrap.min.css'); ?>
		<!-- Linearicon Font -->
	
		<?php echo theme_css('lnr-icon.css'); ?>		
		<!-- Fontawesome CSS -->
   
		<?php echo theme_css('font-awesome.min.css'); ?>		
		<!-- Datetimepicker CSS -->
		
		<?php echo theme_css('fullcalendar.min.css'); ?>
		<?php echo theme_css('bootstrap-datetimepicker.min.css'); ?>	
		<!-- Custom CSS -->
		
		<?php echo theme_css('style.css'); ?>	
		
		
		<!-- jQuery -->
		<?php echo theme_js('jquery-3.2.1.min.js'); ?>
		
		<!-- Bootstrap Core JS -->
		<?php echo theme_js('popper.min.js'); ?>
		<?php echo theme_js('bootstrap.min.js'); ?>
	

		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		
	</head>
	<body class="<?php echo $this->school->theme_color . ' ' . $this->school->background; ?>">
	  <?php $settings = $this->ion_auth->settings(); ?>
		<!-- Inner wrapper -->
		<div class="inner-wrapper">
				
			<!-- Loader -->
			<div id="loader-wrapper">
				
				<div class="loader">
				  <div class="dot"></div>
				  <div class="dot"></div>
				  <div class="dot"></div>
				  <div class="dot"></div>
				  <div class="dot"></div>
				</div>
			</div>

			<!-- Header -->
			<header class="header">
			 <?php echo $template['partials']['header']; ?>
			</header>
			<!-- /Header -->
			
			<!-- Content -->
			<div class="page-wrapper">
				<div class="container-fluid">
					<div class="row">
						

						<div class="col-lg-12">
						
							  <?php echo $template['body']; ?>
						</div>
					</div>
				</div>
			</div>
			<!--/Content-->
			
		</div>
		<!-- Inner Wrapper -->
		
		<div class="sidebar-overlay" id="sidebar_overlay"></div>
		


		
		
		<!-- jQuery -->
		
				
		
		<?php echo theme_js('plugins/select2/moment.min.js'); ?>
		<?php echo theme_js('bootstrap-datetimepicker.min.js'); ?>
		
		<?php echo theme_js('plugins/fullcalendar/fullcalendar.min.js'); ?>
       <?php //echo theme_js('plugins/fullcalendar/jquery.fullcalendar.js'); ?>
		
		<!-- Sticky sidebar JS -->
		<?php echo theme_js('plugins/theia-sticky-sidebar/ResizeSensor.js'); ?>	
		<?php echo theme_js('plugins/theia-sticky-sidebar/theia-sticky-sidebar.js'); ?>	

		<!-- Custom Js -->
		<?php echo theme_js('sweet-alert.min.js'); ?>
		<?php echo theme_js('script.js'); ?>
		
		
		
		
		
<?php
	if (preg_match('/^(portals\/parents\/class_attendance)$/i', $this->uri->uri_string())):
	
	//print_r($att);
?>



<script>

!function($) {
	
    "use strict";

    var CalendarApp = function() {
        this.$body = $("body")
        this.$calendar = $('#calendar'),
        this.$event = ('#calendar-events div.calendar-events'),
        this.$categoryForm = $('#add_new_event form'),
        this.$extEvents = $('#calendar-events'),
        this.$modal = $('#my_event'),
        this.$saveCategoryBtn = $('.save-category'),
        this.$calendarObj = null
    };


    /* on drop */
    CalendarApp.prototype.onDrop = function (eventObj, date) { 
        var $this = this;
            // retrieve the dropped element's stored Event Object
            var originalEventObject = eventObj.data('eventObject');
            var $categoryClass = eventObj.attr('data-class');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            // assign it the date that was reported
            copiedEventObject.start = date;
            if ($categoryClass)
                copiedEventObject['className'] = [$categoryClass];
            // render the event on the calendar
            $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                eventObj.remove();
            }
    },
    /* on click on event */
    CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view) {
        var $this = this;
            var form = $("<form></form>");
            form.append("<label>Change event name</label>");
            form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-append'><button type='submit' class='btn btn-success'><i class='fa fa-check'></i> Save</button></span></div>");
            $this.$modal.modal({
                backdrop: 'static'
            });
            $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                    return (ev._id == calEvent._id);
                });
                $this.$modal.modal('hide');
            });
            $this.$modal.find('form').on('submit', function () {
                calEvent.title = form.find("input[type=text]").val();
                $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                $this.$modal.modal('hide');
                return false;
            });
    },
    /* on select */
    CalendarApp.prototype.onSelect = function (start, end, allDay) {
        var $this = this;
            $this.$modal.modal({
                backdrop: 'static'
            });
            var form = $("<form></form>");
            form.append("<div class='event-inputs'></div>");
            form.find(".event-inputs")
                .append("<div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div>")
                .append("<div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div>")
                .find("select[name='category']")
                .append("<option value='bg-danger'>Danger</option>")
                .append("<option value='bg-success'>Success</option>")
                .append("<option value='bg-purple'>Purple</option>")
                .append("<option value='bg-primary'>Primary</option>")
                .append("<option value='bg-info'>Info</option>")
                .append("<option value='bg-warning'>Warning</option></div></div>");
            $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                form.submit();
            });
            $this.$modal.find('form').on('submit', function () {
                var title = form.find("input[name='title']").val();
                var beginning = form.find("input[name='beginning']").val();
                var ending = form.find("input[name='ending']").val();
                var categoryClass = form.find("select[name='category'] option:checked").val();
                if (title !== null && title.length != 0) {
                    $this.$calendarObj.fullCalendar('renderEvent', {
                        title: title,
                        start:start,
                        end: end,
                        allDay: false,
                        className: categoryClass
                    }, true);  
                    $this.$modal.modal('hide');
                }
                else{
                    alert('You have to give a title to your event');
                }
                return false;
                
            });
            $this.$calendarObj.fullCalendar('unselect');
    },
    CalendarApp.prototype.enableDrag = function() {
        //init events
        $(this.$event).each(function () {
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
    }
    /* Initializing */
    CalendarApp.prototype.init = function() {
        this.enableDrag();
        /*  Initialize the calendar  */
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';
        var today = new Date($.now());

//Sun May 02 2021 10:35:07 GMT+0300 (East Africa Time)
//1619773311381
//1617310800

        var defaultEvents =  [
		
		<?php foreach($att as $p){?>
		    {
                title: '<?php echo $p->title;?>',
                start: new Date('<?php echo date("Y-m-d",$p->attendance_date);?>'),
                className: '<?php if($p->status=="Present") echo "bg-success"; else echo "bg-danger";?>'
            },
		<?php } ?>
           
			];

        var $this = this;
        $this.$calendarObj = $this.$calendar.fullCalendar({
            slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
            minTime: '08:00:00',
            maxTime: '19:00:00',  
            defaultView: 'month',  
            handleWindowResize: true,   
             
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: defaultEvents,
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            drop: function(date) { $this.onDrop($(this), date); },
            select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
            eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }

        });

        //on new event
        this.$saveCategoryBtn.on('click', function(){
            var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
            var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
            if (categoryName !== null && categoryName.length != 0) {
                $this.$extEvents.append('<div class="calendar-events" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-circle text-' + categoryColor + '"></i>' + categoryName + '</div>')
                $this.enableDrag();
            }

        });
    },

   //init CalendarApp
    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
    
}(window.jQuery),


//initializing CalendarApp
function($) {
    "use strict";
    $.CalendarApp.init()
}(window.jQuery);

</script>
<?php endif ;?>
	</body>

</html>