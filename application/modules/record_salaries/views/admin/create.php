<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Record Salaries  </h2>
        <div class="right"> 
            <?php echo anchor('admin/record_salaries/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> Process Salary', 'class="btn btn-primary"'); ?>

            <?php echo anchor('admin/record_salaries', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => ' Salary Records')), 'class="btn btn-primary"'); ?> 
        </div>
    </div> 
    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group' >
            <div class="col-md-3" for='month'>Salary for Month <span class='required'>*</span></div>
            <div class="col-md-3">
                <?php
                $month = array(
                    'January' => 'January',
                    'February' => 'February',
                    'March' => 'March',
                    'April' => 'April',
                    'May' => 'May',
                    'June' => 'June',
                    'July' => 'July',
                    'August' => 'August',
                    'September' => 'September',
                    'October' => 'October',
                    'November' => 'November',
                    'December' => 'December',
                );

                echo form_dropdown('month', array('' => 'Select Month') + $month, (isset($result->month)) ? $result->month : '', ' class="select " ');
                echo form_error('month');
                ?>
            </div>
        </div>
        <div class='form-group' >
            <div class="col-md-3" for='month'>Year <span class='required'>*</span></div>
            <div class="col-md-6">

                <?php
                $years = array_combine(range(date("Y"), 2005), range(date("Y"), 2005));

                echo form_dropdown('year', $years, (isset($result->year)) ? $result->year : '', ' class="select " ');
                echo form_error('year');
                ?>
            </div>

        </div>

        <div class='form-group'>
            <div class="col-md-3" for='salary_date'>Salary Processing Date <span class='required'>*</span></div><div class="col-md-6">
                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('salary_date', $result->salary_date > 0 ? date('d M Y', $result->salary_date) : $result->salary_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
 
                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>

                </div>
                <?php echo form_error('salary_date'); ?>

            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='reported_by'>Process Type </div>

            <div class="col-md-9"> 
                Single Employee Salary process <input type="radio"  id="member" value="0" name="salo" /> 
                 Bulk Salary Process<input type="radio"  name="salo" value="1" id="bulk"/>
             </div>	
         </div>	
 
        <div class='form-group' id='mem'>
            <div class="col-md-3" for='employee'>Employee <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('employee', array('' => 'Select Employee') + $employees, (isset($result->employee)) ? $result->employee : '', ' class="select " ');
                echo form_error('employee');
                ?>
            </div></div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Comment </h2></div>
            <div class="block-fluid editor">
                <textarea id="comment"   style="height: 300px;" class=" wysiwyg "  name="comment"  /><?php echo set_value('comment', (isset($result->comment)) ? htmlspecialchars_decode($result->comment) : ''); ?></textarea>
                <?php echo form_error('comment'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">


                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Process', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/record_salaries', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>


<script>



        $(document).ready(function () {
            $('#mem').hide();

            $('#member').click(function () {
                $('#mem').show();

            });
            $('#bulk').click(function () {
                $('#mem').hide();
            });
        });

</script>