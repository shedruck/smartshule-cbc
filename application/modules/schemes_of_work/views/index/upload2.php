<?php

$range = range(date('Y') - 5, date('Y') + 2);
$yrs = array_combine($range, $range);
krsort($yrs);

$assessment_tool = [
    'Portfolio' => 'Portfolio',
    'Written Tests' => 'Written Tests',
    'Anecdontal' =>  'Anecdontal',
    'Oral and Aural' => 'Oral and Aural',
    'Questionnaire' => 'Questionnaire',
    'Observation and Recording Schedule' => 'Observation and Recording Schedule',
    'Checklist' => 'Checklist',
    'Rubric' => 'Rubric',
    'Journals' => 'Journals',
    'Rating Scale' => 'Rating Scale',
    'Projects' => 'Projects',
];
?>

<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            <b> Schemes of Work </b>
        </h3>
        <div class="pull-right">

            <?php echo anchor('schemes_of_work/trs', '<i class="fa fa-list">
                </i> ' . lang('web_list_all', array(':name' => 'Schemes of work')), 'class="btn btn-primary"'); ?>

            <a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>



    <div class="block-fluid">
        <?php echo form_open_multipart(base_url('schemes_of_work/trs/put_excel')) ?>
        <p>Click <a href="<?php echo base_url('uploads/Schemes_of_work_temp.xlsx') ?>">Here for sample to download sample</a> (.xlsx)</p>
        <div class="col-md-12">

            <div class="col-md-4">
                <label>Subject</label>
                <?php echo form_dropdown('subject', array('' => 'Please select') + $cbc_subjects, $this->input->post('subject'), 'class="tsel" '); ?>
            </div>

            <div class="col-md-4">
                <label>Term</label>
                <?php echo form_dropdown('term', array('' => 'Please select') + $this->terms, $this->input->post('term'), 'class="tsel" '); ?>


            </div>

            <div class="col-md-4">
                <label>Year</label>
                <?php echo form_dropdown('year', array('' => 'Please select') + $yrs, $this->input->post('year'), 'class="tsel" required '); ?>

            </div>

            <div class="col-md-4">
                <label>Assessment Tool</label>
                <?php echo form_dropdown('assessment_tool', array('' => 'Please select') + $assessment_tool, $this->input->post('assessment_tool'), 'class="tsel" required '); ?>

            </div>

            <div class="col-md-4">
                <label>Class</label>
                <?php
                $classes = $this->portal_m->get_class_options();
                echo form_dropdown('class', array('' => 'Please select') + $classes, $this->input->post('class'), 'class="tsel" required'); ?>

            </div>

            <div class="col-md-4">
                <label>Select File </label>
                <input type="file" name="userfile" required>
            </div>

            <div class="col-md-4">
                <br>
                <input type="submit" class="btn btn-primary" value="Upload">
            </div>


        </div>
        <br></br></br><br>
        <hr><br>
        <?php echo form_close() ?>
    </div>



    <script>
        jQuery(function() {

            jQuery("#class").change(function() {
                jQuery('#subject').empty();

                var level = jQuery(".class").val();

                var options = '';
                jQuery('#subject').children().remove();

                jQuery.getJSON("<?php echo base_url('admin/evideos/list_subjects'); ?>", {
                    id: jQuery(this).val()
                }, function(data) {


                    for (var i = 0; i < data.length; i++) {

                        options += '<option value="' + data[i].optionValue + '">' + data[i].optionDisplay + '</option>';
                    }

                    jQuery('#subject').append(options);

                });

                //alert(options);
            });

            $(".tsel").select2({
                'placeholder': 'Please Select',
                'width': '100%'
            });
        });
    </script>