<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Class Attendance </h2> 
    <div class="right">                            
        <?php echo anchor('admin/class_attendance/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Attendance')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/class_attendance/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
    </div>    					
</div>
<div class="block-fluid">
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo form_open_multipart(current_url(), $attributes);
    ?>
    <div class='form-group'>
        <div class="col-md-2" for='attendance_date'>Attendance Date <span class='required'>*</span></div>
        <div class="col-md-6">
            <div id="datetimepicker1" class="input-group date form_datetime">
                <?php echo form_input('attendance_date', $result->attendance_date > 0 ? date('d M Y', $result->attendance_date) : $result->attendance_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
                <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
            </div><?php echo form_error('attendance_date'); ?>
        </div>
    </div>
    <div class='form-group'>
        <div class="col-md-2" for='title'>Attendance For </div>
        <div class="col-md-4">
            <?php
            $items = array('Whole Day' => 'Whole Day',
                "Morning" => "Morning Classes",
                "Evening" => "Evening Classes",
                "Class Time" => "Class Time",
            );
            echo form_dropdown('title', $items, (isset($result->title)) ? $result->title : '', ' class="chzn-select" data-placeholder="Select Options..." ');
            echo form_error('title');
            ?>
        </div>
    </div>
    <table class="table table-striped table-bordered  " >
        <!-- BEGIN -->
        <thead>
            <tr >
                <th width="3">#</th>
                <th >Student</th>
                <th ><input type="checkbox" class="checks" /> Present</th>
                <th ><input type="checkbox" class="checkall" /> Absent</th>
                <th > Temperature</th>
                <th  >Remarks</th>
            </tr>
        </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
            <?php
            $i = 1;
 
            foreach ($students as $post => $val):
                    ?>  
                    <tr >
                        <td >
                            <span id="reference" name="reference" class="heading-reference"><?php echo $i; ?></span>
                        </td> 
                        <td>
                            <?php echo $val; ?>
                        </td>
                        <td>
                            <?php echo form_radio('status[' . $post . ']', 'Present', $result->status, 'class="switchx check-lef"') ?>
                        </td>
                        <td>
                            <?php echo form_radio('status[' . $post . ']', 'Absent', $result->status, 'class="switchx check"') ?>
                            <?php echo form_error('status'); ?>
                        </td>
                        <td>
                            <input type="number" name="temperature[<?php echo $post?>]" class="col-md-12" >
                        </td>
                        <td>
                            <textarea name="remarks[<?php echo $post; ?>]" cols="25" rows="1" class="col-md-12 remarks  validate[required]" style="resize:vertical;" id="remarks"><?php echo set_value('remarks', (isset($result->remarks)) ? htmlspecialchars_decode($result->remarks) : ''); ?></textarea>
                        </td>
                    </tr>
                    <?php
                    $i++;
            endforeach;
            ?>		
        </tbody>
    </table>
    <div class='form-group'>
        <div class="col-md-6">
            <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Bulk Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
            <?php echo anchor('admin/class_attendance', 'Cancel', 'class="btn btn-danger"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
    <div class="clearfix"></div>
</div>
<script>
        $(function ()
        {
            $(".checks").on('change', function ()
            {
                $("input.check-lef").each(function ()
                {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });

            $(".checkall").on('change', function ()
            {
                $("input.check").each(function ()
                {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });
            $.uniform.update();
        });
</script>