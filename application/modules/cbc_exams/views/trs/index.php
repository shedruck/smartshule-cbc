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


    <?php if ($payload) : ?>
        <div class="block-fluid">
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                    <th>#</th>
                    <th>Exam</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Term</th>
                    <th>Status</th>
                    <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $st = [
                        1 => '<span class="label label-success">Approved</span>',
                        2 => '<span class="label label-danger">Pending</span>'
                    ];

                    $xm = [
                        1 => '<span class="label label-info">Opener</span>',
                        2 => '<span class="label label-success">Midterm</span>',
                        3 => '<span class="label label-primary">Endterm</span>'
                    ];
                    foreach ($payload as $p) :
                        $i++;
                    ?>
                        <tr>
                            <td><?php echo $i . '.'; ?></td>
                            <td><?php echo isset($xm[$p->exam]) ? $xm[$p->exam] : '' ?> </td>
                            <td><?php echo isset($subjects[$p->subject]) ? $subjects[$p->subject] : '' ?> </td>

                            <td><?php echo isset($this->streams[$p->class]) ? $this->streams[$p->class] : ''; ?></td>
                            <td>Term <?php echo $p->term ?> <?php echo $p->year ?></td>
                            <td><?php echo isset($st[$p->status]) ? $st[$p->status] : ''; ?></td>
                            <td>
                                <!-- <a class="btn btn-sm btn-primary" href="<?php echo base_url('trs/cbc_exams/edit/' . $p->id) ?>">Edit</a>
                                <a class="btn btn-sm btn-success" href="<?php echo base_url('trs/cbc_exams/view/' . $p->id) ?>">View</a> -->
                               
                                <a class="btn btn-sm btn-info" href="<?php echo base_url('trs/cbc_exams/report_forms/' . $p->class . '/' .  $p->exam . '/' . $p->term . '/' . $p->year) ?>">Report Form</a>

                            </td>

                        </tr>
                    <?php endforeach ?>
                </tbody>

            </table>


        </div>

    <?php else : ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
    <?php endif ?>