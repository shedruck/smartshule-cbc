<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            <b>Summative Assessment </b>
        </h3>
        <div class="pull-right">

            <a class="btn btn-success " href="<?php echo base_url('trs/cbc_exams/summative_assess') ?>"><i class="fa fa-plus"></i> Add Assessment</a>
            <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>

        <div class="clearfix"></div>
        <hr>
    </div>



    <div class="block-fluid">
        <table class="table">
            <tr>
                <td>Class</td>
                <td>Exam</td>
                <td>Term</td>
                <td>Year</td>
            </tr>
            <tr>
                <td><?php echo form_dropdown('class', $this->streams, $this->input->post('class'), 'class="select"') ?></td>
                <td><?php $exams = [1 => 'Opener Exam', 2 => 'Mid Term', 3 => 'End Term'];
                    echo form_dropdown('exam', ['' => ''] + $exams, $this->input->post('exam'), 'class="select" required'); ?></td>
                <td> <?php
                        echo form_dropdown('term', ['' => ''] + $this->terms, $this->input->post('term'), 'class="select" required')
                        ?></td>
                <td> <?php
                        $range = range(date('Y') - 10, date('Y')+1);
                        $yrs = array_combine($range, $range);
                        krsort($yrs);
                        echo form_dropdown('year', ['' => ''] + $yrs, $this->input->post('year'), 'class="select" required')
                        ?></td>
            </tr>
        </table>
    </div>