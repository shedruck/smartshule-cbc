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

echo form_open_multipart(base_url('schemes_of_work/trs/put_excel'));
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Schemes of Work</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <?php echo anchor('schemes_of_work/trs', '<i class="fa fa-list">
                    </i> ' . lang('web_list_all', array(':name' => 'Schemes of work')), 'class="btn btn-primary"'); ?>

                    <a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <p class="text-center">Click <a href="<?php echo base_url('uploads/Schemes_of_work_temp.xlsx') ?>">Here for sample to download sample</a> (.xlsx)</p>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-xl-8 col-lg-8 col-sm-12">
                        <!-- Form Fields Start -->
                        <div class="row m-2">
                            <label class="col-md-3 col-lg-3 col-xl-3">Subject</label>
                            <div class="col-md-9 col-lg-9 col-xl-9">
                                <?php echo form_dropdown('subject', array('' => 'Please select') + $cbc_subjects, $this->input->post('subject'), 'class="tsel" '); ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <label class="col-md-3 col-lg-3 col-xl-3">Term</label>
                            <div class="col-md-9 col-lg-9 col-xl-9">
                                <?php echo form_dropdown('term', array('' => 'Please select') + $this->terms, $this->input->post('term'), 'class="tsel" '); ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <label class="col-md-3 col-lg-3 col-xl-3">Year</label>
                            <div class="col-md-9 col-lg-9 col-xl-9">
                            <?php echo form_dropdown('year', array('' => 'Please select') + $yrs, $this->input->post('year'), 'class="tsel" required '); ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <label class="col-md-3 col-lg-3 col-xl-3">Assessment Tool</label>
                            <div class="col-md-9 col-lg-9 col-xl-9">
                            <?php echo form_dropdown('assessment_tool', array('' => 'Please select') + $assessment_tool, $this->input->post('assessment_tool'), 'class="tsel" required '); ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <label class="col-md-3 col-lg-3 col-xl-3">Class</label>
                            <div class="col-md-9 col-lg-9 col-xl-9">
                            <?php
                            $classes = $this->portal_m->get_class_options();
                            echo form_dropdown('class', array('' => 'Please select') + $classes, $this->input->post('class'), 'class="tsel" required'); ?>
                            </div>
                        </div>

                        <div class="row m-2">
                            <label class="col-md-3 col-lg-3 col-xl-3">Select File </label>
                            <div class="col-md-9 col-lg-9 col-xl-9">
                            <input type="file" name="userfile" class="form-control" required>
                            </div>
                        </div>
                        <!-- Form Fields End -->
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-check d-inline-block">
                    <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
                </div>
                <div class="float-end d-inline-block btn-list">
                    <input type="submit" class="btn btn-primary" value="Upload">
                    <?php echo anchor('trs/schemes_of_work', 'Cancel', 'class="btn  btn-default"'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>

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