<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Edit Class Attendance
        <div class="pull-right">
            <?php echo anchor('trs/attendance/', '<i class="mdi mdi-reply"></i> List All', 'class="btn btn-primary"'); ?>
        </div>
    </h2>
</div>
<div class="block-fluid card-box table-responsive">
    <hr>
    <?php
                $cc = '';
                if (isset($this->classlist[$dat->class_id]))
                {
                        $cro = $this->classlist[$dat->class_id];
                        $cc = isset($cro['name']) ? $cro['name'] : '';
                }
                ?>
                <h3>Class Register For <span style="color:green"> <?php
                        echo $cc;
                        ?></span>
                </h3>
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo form_open_multipart(current_url(), $attributes);
    ?>
    <div class='form-group'>
        <div class="col-md-2" for='attendance_date'>Attendance Date <span class='required'>*</span></div>
        <div class="col-md-6">
            <div id="datetimepicker1" class="input-group date form_datetime">
                <?php echo form_input('attendance_date', $dat->attendance_date > 0 ? date('d M Y', $dat->attendance_date) : $dat->attendance_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
                <span class="input-group-addon "><i class="mdi mdi-calendar"></i></span>
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
            echo form_dropdown('title', $items, (isset($dat->title)) ? $dat->title : '', ' class="select form-control" data-placeholder="Select Options..." ');
            echo form_error('title');
            ?>
        </div>
    </div>
    <table class="table table-striped table-bordered  " >
        <!-- BEGIN -->
        <thead>
            <tr >
                <th width="3">#</th>
                <th>Student</th>
                <th><input type="checkbox" class="checks" /> Present</th>
                <th><input type="checkbox" class="checkall" /> Absent</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody role="alert">
            <?php
            $i = 1;
            foreach ($post as $p):
                    ?>  
                    <tr >
                        <td >
                            <span id="reference" name="reference" class="heading-reference"><?php echo $i; ?></span>
                        </td> 
                        <td>
                            <?php
                            $st = $this->worker->get_student($p->student);
                            echo $st->first_name . ' ' . $st->last_name;
                            ?>
                        </td>
                        <td>
                            <?php echo form_radio('status[' . $p->student . ']', 'Present', $p->status == 'Present' ? 1 : 0, 'class="switchx check-lef"') ?>
                        </td>
                        <td>
                            <?php echo form_radio('status[' . $p->student . ']', 'Absent', $p->status == 'Absent' ? 1 : 0, 'class="switchx check"') ?>
                            <?php echo form_error('status'); ?>
                        </td>
                        <td>
                            <textarea name="remarks[<?php echo $p->student; ?>]" cols="25" rows="1" class="col-md-12 remarks  validate[required]" style="resize:vertical;" id="remarks"><?php echo set_value('remarks', (isset($p->remarks)) ? htmlspecialchars_decode($p->remarks) : ''); ?></textarea>
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
            <?php echo anchor('trs/attendance', 'Cancel', 'class="btn btn-default"'); ?>
            <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
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
        });
</script>