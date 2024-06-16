<?php
$range = range(date('Y') - 5, date('Y') + 2);
$yrs = array_combine($range, $range);
krsort($yrs);

$weeks = [];
for ($i = 1; $i < 57; $i++) {
    $weeks[$i] = $i;
}



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
$settings = $this->ion_auth->settings();



?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Schemes of Work - Report</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <a class="btn btn-danger hidden-print" onclick="window.history.back()" style="float:right">Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <!-- <div class="row justify-content-center"> -->
                <?php echo form_open(current_url()) ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Class</td>
                            <td>Week</td>
                        </tr>

                        <tr>

                            <td>
                                <?php echo form_dropdown('class', array('' => 'Please select') + $this->classes, $this->input->post('class'), 'id="class" class="tsel class" required'); ?>
                            </td>

                            <td>
                                <?php echo form_dropdown('week', array('' => 'Please select') + $weeks, $this->input->post('week'), 'class="tsel"'); ?>
                            </td>
                        </tr>


                        <tr>
                            <td>Term</td>
                            <td>Year</td>
                        </tr>

                        <tr>

                            <td>
                                <?php echo form_dropdown('term', array('' => 'Please select') + $this->terms, $this->input->post('term'), 'class="tsel" required'); ?>
                            </td>

                            <td>
                                <?php echo form_dropdown('year', array('' => 'Please select') + $yrs, $this->input->post('year'), 'class="tsel" required'); ?>
                            </td>

                        </tr>

                        <tr>
                            <td>Subject</td>
                            <td>Action</td>
                        </tr>
                        <tr>

                            <td>
                                <?php echo form_dropdown('subject', array('' => 'Please select') + $cbc_subjects, $this->input->post('subject'), ' id="subject" class="tsel" required'); ?>
                            </td>
                            <td style="text-align:right">
                                <button class="btn btn-primary" type="submit">Filter</button>
                                <button class="btn btn-info" type="button" onclick="window.print()">Print</button>
                            </td>
                        </tr>


                    </table>
                </div>
                <?php echo form_close(); ?>
                <hr>
                <div class="block-fluid table-responsive">
                    <div class="row">
                        <div class="col-xm-12">
                            <div class="col-xm-4"></div>
                            <div class="col-xm-4">
                                <center>
                                    <img src="<?php echo base_url('uploads/files/' . $this->school->document) ?>" style="width:80px">
                                    <h4><?php echo $this->school->school ?></h4>
                                    <h3>SCHEME OF WORK</h3>
                                </center>
                            </div>
                            <div class="col-xm-3"></div>
                        </div>
                    </div>

                    <?php if ($post) { ?>

                        <div class="row">
                            <table width="100%" class="table table-bordered">
                                <tr class="bg-default">
                                    <th>NAME OF TEACHER</th>
                                    <th>GRADE/LEVEL</th>
                                    <th>LEARNING AREA</th>
                                    <th>TERM</th>
                                    <th>YEAR</th>
                                </tr>
                                <tr>
                                    <td class="bld"><?php echo  isset($teachers[$post->created_by]) ? $teachers[$post->created_by] : ''  ?></td>
                                    <td class="bld"><?php echo  isset($this->classes[$post->level]) ? $this->classes[$post->level] : ''  ?></td>
                                    <td class="bld"><?php echo  isset($cbc_subjects[$post->subject]) ? $cbc_subjects[$post->subject] : ''  ?></td>
                                    <td class="bld"><?php echo $post->term ?></td>
                                    <td class="bld"><?php echo $post->year ?></td>
                                </tr>
                            </table>
                            <hr>
                            <table width="100%" class="table table-bordered">
                                <tr class="bg-default">
                                    <th>WK</th>
                                    <th>LES'N</th>
                                    <th>STRAND</th>
                                    <th>SUB-STRAND</th>
                                    <th>SPECIFIC LEARNING OUTCOMES (KSA)</th>
                                    <th>KEY INQUIRY QUESTION(S)</th>
                                    <th>LEARNING EXPERIENCES</th>
                                    <th>LEARNING RESOURCES</th>
                                    <th>ASSESSMENT </th>
                                    <th>REFL’N</th>
                                </tr>
                                <?php
                                $index = 1;
                                foreach ($payload as $p) {
                                ?>
                                    <tr>
                                        <td><?php echo $p->week ?></td>
                                        <td><?php echo $p->lesson ?></td>
                                        <td><?php echo $p->strand ?></td>
                                        <td><?php echo $p->substrand ?></td>
                                        <td><?php echo $p->specific_learning_outcomes ?></td>
                                        <td><?php echo $p->key_inquiry_question ?></td>
                                        <td><?php echo $p->learning_experiences ?></td>
                                        <td><?php echo $p->learning_resources ?></td>
                                        <td><?php echo $p->assessment ?></td>
                                        <td><?php echo $p->reflection ?></td>
                                    </tr>

                                <?php $index++;
                                } ?>
                            </table>
                        </div>

                    <?php } else { ?>
                        <pre>
            Please select subject, class, term and year
        </pre>
                    <?php } ?>
                </div>

                <!-- </div> -->
            </div>
            <div class="card-footer">
                <div class="form-check d-inline-block">
                    <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
                </div>
                <div class="float-end d-inline-block btn-list">

                </div>
            </div>
        </div>
    </div>
</div>
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