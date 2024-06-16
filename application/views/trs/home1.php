<?php $avt = strtolower(substr($this->user->first_name, 0, 1)); 

?>
<?php 
$pwd= $this->ion_auth->get_user()->changed_on;
$initial_pwd='12345678';
?>
<?php $firstname= ucfirst($this->user->first_name)?>
<?php 
if($pwd == 0){
    echo "<script>
            var confo= confirm('Dear $firstname, Kindly change your password to keep your account secure');
            if(confo ==true){
                window.location='trs/change_password';
            }else{
                alert('Remember this will leave your account vulnarable');
            }
       </script>"; 
}
?>
<script>
  
</script>
<div class="row">
    <div class="col-md-4">
        <div class="text-center card-box">
            <div class="text-left">&nbsp;</div>
            <div class="member-card">
                <div class="thumb-md center-block ">
                    &nbsp;
                </div>
                <div class="">
				     <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img" width="150"  class="img-circle">
                    <h4 class="m-b-5"><?php echo $this->user->first_name . ' ' . $this->user->last_name ?></h4>
                    <h4 class="m-b-5"><?php echo $this->user->phone ?></h4>
                    <h4 class="m-b-5"><?php echo $this->user->email ?></h4>
                    <span class="badge badge-pink">Teacher</span>
                </div>
                <hr/>
				<!--
                <div class="m-t-20">
                    <ul class="list-inline">
                         <li class="m-l-15">
                            <h4><?php echo count($classes); ?></h4>
                            <p><?php echo count($classes) == 1 ? 'Assigned Subjects' : 'Assigned Subjects'; ?></p>
                        </li>
                    </ul>
                </div>
				-->
                <?php
                $name= $this->user->first_name.' '.$this->user->last_name;
                $email= $this->user->email;
                ?>
                <a href="<?php echo base_url('trs/account'); ?>" class="btn btn-brown btn-rounded waves-effect m-t-10 m-b-10 waves-light">View Profile</a><br>
                <a href="<?php echo base_url('trs/subjectAssigned');?>" target="" class="btn btn-success btn-rounded waves-effect m-t-10 m-b-10 waves-light">Subject Assigned</a>
                <a href="trs/zoom"  class="btn btn-primary btn-rounded waves-effect m-t-10 m-b-10 waves-light"><i class="mdi mdi-spin mdi-camcorder" aria-hidden="true"></i> Zoom Meeting</a>
            </div>
        </div>
    </div>  
    <div class="col-md-8">  

        <div id="calendar"></div>
    </div>
</div>
<!-- end row -->
<!-- BEGIN MODAL -->
<div class="modal fade none-border" id="event-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">View Event</h4>
            </div>
            <div class="modal-body p-20"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success hidden save-event waves-effect waves-light">Create event</button>
            </div>
        </div>
    </div>
</div>
<style>
    .fc-day-grid-event .fc-time 
    {
        display: none ;
    }
</style>
<?php
$cal = array();
foreach ($events as $e)
{
        if ($e->cat == 1)
        {
                $cal[] = array('title' => $e->title, 'start' => date('D M d Y 10:30:13 GMT+0000 (EAT)', $e->date), 'datex' => date('D M d Y', $e->date), 'desc' => $e->description, 'className' => $e->cat == 1 ? 'bg-purple' : 'bg-success');
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

