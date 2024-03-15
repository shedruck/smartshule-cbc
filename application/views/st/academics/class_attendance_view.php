


<div class="card card-header" style="background:#fff">
				<div class="card shadow-sm ctm-border-radius grow">
			<div class="card-header d-flex align-items-center justify-content-between">
				<h4 class="card-title mb-0 d-inline-block">Attendance Register
				
				<a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</h4>
			<hr>
			</div>
		
		

    <div class="row">
    <div class="col-md-7">
   
		
		<?php if($stud){?>
		
		 <div class="row">
          <div class="col-sm-12">
				<table width="20%" class="table table-striped table-bordered">
				      <tr>
						   <td class="bg-black text-center">DESCRIPTION</td>
					       <td  class="bg-black text-center">PERIOD <?php echo strtoupper(date('F Y')); ?> </td>
					   </tr>

					   <tr>
						   <td class="input-green">Total Present:</td>
					       <td  class="bg-green"><?php echo $present; ?> times</td>
					   </tr>
				      <tr>
						   <td class="input-red">Total Absent:</td>
					       <td class="bg-red"><?php echo $absent; ?> times</td>
					   </tr>

					   <tr>
						   <td class="input-red">Total Sessions:</td>
					       <td class="bg-blue" ><?php echo number_format($present + $absent); ?> Sessions </td>
					   </tr>
					  
					</table>
		
					
	
     </div>
     </div>
     </div>
				 
	<div class="col-sm-5">
			   <table class="table-bordered" width="100%">
				      <tr>
						   <td colspan="3" class="input-blue text-center" ><h4 class="card-title mb-0 d-inline-block text-center"> Annual Attendance Summary- <?php echo date('Y')?></h4></td>
					   </tr>
					   <tr>
						   <td class="text-center input-blue">Month</td>
					       <td class="text-center input-green" >Present </td>
					       <td class="text-center input-red" >Absent </td>
					   </tr>
					   <?php 
							for($m=1; $m<=12; ++$m){
								
							$pre = $this->ion_auth->count_attendance($stud,'Present',$m,date('Y'));
							$abs = $this->ion_auth->count_attendance($stud,'Absent',$m,date('Y'));
							
							$bg ='';
							
							if(date('m')==$m){
								$bg = 'bg-blue';
								
							}elseif(date('m') > $m){
										$bg = 'bg-black';
									}
							?>
					   <tr>
						   <td class="text-center <?php echo $bg?>"><?php echo date('M', mktime(0, 0, 0, $m, 1));?></td>
					       <td class="text-center <?php if($pre >0) echo 'bg-green'; else echo 'bg-grey';?>" ><b><?php echo $pre; ?></b> </td>
					       <td class="text-center <?php if($abs >0) echo 'bg-red'; else echo 'bg-grey';?>"><b><?php echo $abs; ?></b> </td>
					   </tr>
				   <?php } ?>
					  
					</table>
			</div>
			
			
              </div>
		
		<hr>
		<div class="row">
                <div class="col-sm-12">
				
				<div class="card-header d-flex align-items-center justify-content-between">
						<h4 class="card-title mb-0 d-inline-block col-sm-12">CALENDAR VIEW
						 <span class="pull-right">
		                    KEY:
								<div class="btn bg-green btn-sm"><i class="fa fa-calender"></i> Present</div>
								<div class="btn bg-red btn-sm"><i class="fa fa-calender"></i> Absent</div>
						</span>
                 
						</h4>
					
					</div>
					
		<div class="card ctm-border-radius shadow-sm grow">
		
					<div class="card-body">
						<div id="calendar"></div>
					</div>
				</div>
				
	   </div>
	  </div>
	  
	  <?php } ?>		
    </div>
</div>


<?php

foreach ($att as $e)
{
        if ($e->status=="Present")
        {
                $cal[] = array('title' => $e->title, 'start' => date('D M d Y 10:30:13 GMT+0000 (EAT)', $e->attendance_date), 'datex' => date('D M d Y', $e->attendance_date), 'desc' => $e->title, 'className' => $e->status=="Present" ? 'bg-green' : 'bg-blue');
        }
}
?>
<script>
        $(document).ready(function ()
        {
            var $modal = $('#event-modal'),
                    $calendarObj = null;

            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
                minTime: '08:00:00',
                maxTime: '19:00:00',
                defaultView: 'month',
                handleWindowResize: true,
                height: $(window).height() - 200,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events:<?php echo json_encode($cal); ?>,
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                drop: function (eventObj, date) {
                    return false;
                },
                select: function (start, end, allDay) {
                    return false;
                },
                eventClick: function (calEvent, jsEvent, view)
                {
                    var $this = $(this);
                    var form = $("<form></form>");
                    form.append("<label>Title:</label>");
                    //form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span></div>");
                    form.append("<div class='input-group'> " + calEvent.title + " <span class='input-group-btn'></span></div>");
                    form.append("<hr/><label>Date:</label>");
                    form.append("<div class='input-group'> " + calEvent.datex + " <span class='input-group-btn'></span></div>");
                    form.append("<hr/><label>Description:</label>");
                    form.append("<div class='input-group'> " + calEvent.desc + " <span class='input-group-btn'></span></div>");
                    $modal.modal({
                        backdrop: 'static'
                    });
                    $modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                        $calendarObj.fullCalendar('removeEvents', function (ev)
                        {
                            return (ev._id == calEvent._id);
                        });
                        $modal.modal('hide');
                    });
                    $modal.find('form').on('submit', function ()
                    {
                        calEvent.title = form.find("input[type=text]").val();
                        $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                        $modal.modal('hide');
                        return false;
                    });
                }
            });
        });
</script>




<style>
.fc-time{
	display:none !important;
}
    table.calendar{ border-left:1px solid #999;     width: 100%;}
    table.calendar   td.calendar-day-head
    { 
        font-weight:bold; text-align:center; width:14.3%;  
        text-transform: uppercase;
        font-size: 12px;
        padding-top: 20px;
        color: rgba(255,255,255,0.2);
    }
    /* shared */
    table.calendar  td.calendar-day, td.calendar-day-np {  padding:5px; }
</style>