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
<br>

<a class="btn btn-danger hidden-print" onclick="window.history.back()" style="float:right">Back</a>
<div class="tools hidden-print">
    <div class="panel panel-default">
        <div class="panel-heading">Filter</div>
        <div class="panel-body">
            <?php echo form_open(current_url()) ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Subject</td>
                        <td>Week</td>
                    </tr>

                    <tr>

                        <td>
                            <?php echo form_dropdown('subject', array('' => 'Please select') + $cbc_subjects, $this->input->post('subject'), 'class="tsel" required'); ?>
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
                        <td>Class</td>
                        <td>Action</td>
                    </tr>
                    <tr>

                        <td>
                            <?php echo form_dropdown('class', array('' => 'Please select') + $this->classes, $this->input->post('class'), 'class="tsel" required'); ?>
                        </td>
                        <td style="text-align:right">
                            <button class="btn btn-primary" type="submit">Filter</button>
                            <button class="btn btn-info" type="button" onclick="window.print()">Print</button>
                        </td>
                    </tr>


                </table>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


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
                <tr>
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
                <tr>
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

<style>
    .bld {
        font-weight: bold;
        text-align: center;
    }
</style>


<script type="text/javascript">
    $(function() {
        $(".tsel").select2({
            'placeholder': 'Please Select',
            'width': '100%'
        });
    });
</script>