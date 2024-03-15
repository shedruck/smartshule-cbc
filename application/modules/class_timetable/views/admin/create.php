<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
	
	
    <h2> Class Timetable - <?php
					
                    $stream = $this->ion_auth->populate('class_stream','id','name'); 
                    $cls = $this->ion_auth->populate('class_groups','id','name'); 
					
					$c = $this->portal_m->fetch_class($class);
					
						
						echo strtoupper($cls[$c->class] . ' ' . $stream[$c->stream]);
					
					?></h2> 
    <div class="right">                            

        <?php echo anchor('admin/class_timetable/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Class Timetable')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/class_timetable/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>

    </div>    					
</div>

<div class="block-fluid">
    <!-- BEGIN TABS CONTAINER WIZARD -->

    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo form_open_multipart(current_url(), $attributes);
    ?>
     
	
	<?php
$range = range(date('Y') - 1, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);
?>

<div class='form-group'>
	<div class="col-md-2 " for='day'>Select Year  <span class="required">*</span> </div><div class="col-md-6">
	<?php 

	 echo form_dropdown('year', array(date('Y')=>date('Y')) + $yrs , (isset($result->year)) ? $result->year : '', ' class="select" id="year"  data-placeholder="Select Options..." ');
	
	?>
 	<?php echo form_error('year'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-2 " for='day'>Term  <span class="required">*</span> </div><div class="col-md-6">
	<?php 
	
	 $settings = $this->ion_auth->settings();
	 
	$items =array(
	'1'=>'Term 1',
	'2'=>'Term 2',
	'3'=>'Term 3',

	);
	 echo form_dropdown('term', array($settings->term => 'Term '. $settings->term) + $items, (isset($result->term)) ? $result->term : '', ' class="select" data-placeholder="Select Options..." ');
	
	?>
 	<?php echo form_error('term'); ?>
</div>
</div>



    <?php
    $day_of_the_week = array(
        'Monday' => 'Monday',
        'Tuesday' => 'Tuesday',
        'Wednesday' => 'Wednesday',
        'Thursday' => 'Thursday',
        'Friday' => 'Friday',
        'Saturday' => 'Saturday',
        'Sunday' => 'Sunday',
    );
    ?>

    <div class='form-group'>
        <div class="col-md-2" for='day_of_the_week'>Day Of The Week <span class='required'>*</span></div>
        <div class="col-md-6">
            <?php echo form_dropdown('day_of_the_week', $day_of_the_week, $result->day_of_the_week, 'id="day_of_the_week" style=""  class="day_of_the_week select" data-placeholder="Select Options..." " '); ?>
            <?php echo form_error('day_of_the_week'); ?>
        </div>
    </div>

    <div class="body">
        <!-- BEGIN ADVANCED SEARCH EXAMPLE -->

        <!-- END ADVANCED SEARCH EXAMPLE -->
        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN -->
                <thead>
                    <tr role="row">


                        <th width="3%">#</th>
                        <th width="50" ><center>Subject</center></th>
                        <th width="50"><center>Start Time</center></th>
                        <th width="50"><center>End Time</center></th>
                        <th width="50"><center>Room</center></th>
                        <th width="50"><center>Teacher</center></th>
                    </tr>
                </thead>
            </table>

            <div id="entry1" class="clonedInput">

                <table cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>

                        <tr >

                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>
                            <td width="50">
							  <?php
                                echo form_dropdown('subject[]', array('' => 'Select Options', '99999' => 'BREAK','99' => 'FREE CLASS', '999' => 'LUNCH', '9999' => 'GAMES',  '999999' => 'P.E') + $subject, (isset($result->subject)) ? $result->subject : '', ' class="subject  tsel" id="subject" style=""');
                                echo form_error('subject');
                                ?>
                            </td> 

                            <td width="50">
                                <input type="text" name="start_time[]" id="start_time" class="start_time col-md-12 input_ed timepicker" value="<?php
                                if (!empty($result->start_time))
                                {
                                        echo $result->start_time;
                                }
                                ?>">
                                <?php echo form_error('start_time'); ?>
                            </td>
                            <td width="50">
                                <input type="text" name="end_time[]" id="end_time" class="end_time   col-md-12 input_ed timepicker" value="<?php
                                       if (!empty($result->end_time))
                                       {
                                               echo $result->end_time;
                                       }
                                       ?>">
                                <?php echo form_error('end_time'); ?>
                            </td>
                            <td width="50">
                                <?php
                                echo form_dropdown('room[]', array('' => 'Optional') + $rooms, (isset($result->room)) ? $result->room : '', ' class="col-md-12 room input_room " id="room" ');
                                echo form_error('room');
                                ?>
                            </td>
                            <td width="50" >
<?php
$teacher = $this->ion_auth->get_teachers();
echo form_dropdown('teacher[]', array('' => 'Select Options', '0' => 'None') + $teacher, (isset($result->teacher)) ? $result->teacher : '', ' class="col-md-12 input_teacher  teacher" id="teacher" ');
echo form_error('teacher');
?>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </div>



            <div class="actions">
                <a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a> 
                <a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
            </div>
        </div>
        <br />
        <br />
        <div class='form-group'>
            <div class="col-md-4">


<?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Bulk Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
<?php echo anchor('admin/class_timetable', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>


<?php echo form_close(); ?>

    </div>
</div>



<script type="text/javascript">


        $(function () {
            $('#btnAdd').click(function () {

                //$('input.timepicker').eq(0).clone().removeClass("hasTimepicker").prependTo('#entry2');
                var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                        newNum = new Number(num + 1), // the numeric ID of the new input field being added
                        newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
                // manipulate the name/id values of the input inside the new element
                // H2 - section
                newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);

                // subject - select

                newElem.find('.subject').attr('id', 'ID' + newNum + '_subject').val('');

                // start date name - text

                newElem.find('.start_time').attr('id', 'ID' + newNum + '_start_time').val('').removeClass("hasTimepicker").timepicker({
                    showPeriod: true,
                    showLeadingZero: true
                }).focus();

                // end name - text

                newElem.find('.end_time').attr('id', 'ID' + newNum + '_end_time').val('').removeClass("hasTimepicker").timepicker({
                    showPeriod: true,
                    showLeadingZero: true
                }).focus();

                newElem.find('.room').attr('id', 'ID' + newNum + '_room').val('');

                newElem.find('.teacher').attr('id', 'ID' + newNum + '_teacher').val('');

                // insert the new element after the last "duplicatable" input field
                $('#entry' + num).after(newElem);

                 //$(".tsel").select2({'placeholder': 'Please Select', 'width': '100%'});

                // enable the "remove" button
                $('#btnDel').attr('disabled', false);

                // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
                if (newNum == 100)
                    $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
            });

            $('#btnDel').click(function () {
                // confirmation
                if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
                {
                    var num = $('.clonedInput').length;
                    // how many "duplicatable" input fields we currently have
                    $('#entry' + num).slideUp('slow', function () {
                                        $(this).remove();
                        // if only one element remains, disable the "remove" button
                        if (num - 1 === 1)
                            $('#btnDel').attr('disabled', true);
                        // enable the "add" button
                        $('#btnAdd').attr('disabled', false).prop('value', "add section");
                                });
                }
                return false;
                // remove the last element

                // enable the "add" button
                $('#btnAdd').attr('disabled', false);
            });

            $('#btnDel').attr('disabled', true);
			
			

        });


</script> 

