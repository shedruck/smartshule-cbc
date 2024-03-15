<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> <?php echo $thread->title ?> </h2>
    <div class="right">
        <a type="button" class="btn btn-success" data-toggle="modal" data-target="#examModal"><i class="glyphicon glyphicon-plus"></i> Add Exam</a>
        <?php echo anchor('admin/igcse/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Igcse')), 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/igcse', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Igcse')), 'class="btn btn-primary"'); ?>
    </div>
</div>

<!-- Exam Add Modal -->
<div id="examModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Exam</h4>
            </div>
            <div class="modal-body">
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open_multipart(current_url(), $attributes);
                ?>
                <div class='form-group'>
                    <div class="col-md-3" for='title'>Title <span class='required'>*</span></div>
                    <div class="col-md-9">
                        <?php echo form_input('title', isset($result->title) ? $result->title : '', 'id="title_"  class="form-control" required'); ?>
                        <?php echo form_error('title'); ?>
                    </div>
                </div>
                <div class='form-group'>
                    <div class="col-md-3" for='start_date'>Start Date <span class='required'>*</span></div>
                    <div class="col-md-9">
                        <?php
                        $dt = '';
                        if (isset($result->start_date)) {
                            if ($result->start_date) {
                                if ((!preg_match('/[^\d]/', $result->start_date))) //if it contains digits only
                                {
                                    $dt = date('d M Y', $result->start_date);
                                } else {
                                    $dt = $result->start_date;
                                }
                            }
                        }
                        echo form_input('start_date', $dt, 'class="validate[required] form-control datepicker col-md-6" required');
                        echo form_error('start_date');
                        ?>
                    </div>
                </div>

                <div class='form-group'>
                    <div class="col-md-3" for='end_date'>End Date <span class='required'>*</span></div>
                    <div class="col-md-9">
                        <?php
                        $edt = '';
                        if (isset($result->end_date)) {
                            if ($result->end_date) {
                                if ((!preg_match('/[^\d]/', $result->end_date))) //if it contains digits only
                                {
                                    $edt = date('d M Y', $result->end_date);
                                } else {
                                    $edt = $result->end_date;
                                }
                            }
                        }

                        echo form_input('end_date', $edt, 'class="validate[required] form-control datepicker col-md-6" required');
                        echo form_error('end_date');
                        ?>
                    </div>
                </div>


                <div class='form-group'>
                    <div class="col-md-3" for='record_end_date'>Recording End Date <span class='required'>*</span> </div>
                    <div class="col-md-9">
                        <?php
                        $edt = '';
                        if (isset($result->recording_end_date)) {
                            if ($result->recording_end_date) {
                                if ((!preg_match('/[^\d]/', $result->recording_end_date))) //if it contains digits only
                                {
                                    $edt = date('d M Y', $result->recording_end_date);
                                } else {
                                    $edt = $result->recording_end_date;
                                }
                            }
                        }

                        echo form_input('recording_end_date', $edt, 'class="validate[required] form-control datepicker col-md-6" required');
                        echo form_error('recording_end_date');
                        ?>
                    </div>
                </div>

                <div class='form-group'>
                    <div class="col-md-3" for='record_end_date'>Exam Type <span class='required'>*</span> </div>
                    <div class="col-lg-9">
                        <input id="r1" class="radio-custom switchx" name="type" type="radio" value="1" required>
                        <label for="r1" class="radio-custom-label">Main Exam</label>
                        <input id="r3" class="radio-custom switchx" name="type" type="radio" value="2" required>
                        <label for="r3" class="radio-custom-label">CAT</label>
                    </div>
                </div>

                <div class='form-group'>
                    <div class="col-md-3" for='record_end_date'>Description <span class='required'></span> </div>
                    <div class="col-md-9">
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control">

                        </textarea>
                    </div>
                </div>

                <div class='form-group'>
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <?php 
                            $updType = "create";
                            echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); 
                        ?>
                    </div>
                </div>


                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!-- Exam Add Modal End-->

<?php if ($exams) : ?>
    <div class="block-fluid">
    <h6 class="text-center"><?php echo anchor('admin/igcse/compute/' . $id, 'Compute Marks', 'class="btn btn-success mt-2 text-center"'); ?>&nbsp;<?php echo anchor('admin/igcse/comments/' . $id, 'Comments', 'class="btn btn-success mt-2 text-center"'); ?></h6>
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Term</th>
                <th>Year</th>
                <th>Start</th>
                <th>End</th>
                <th>Recording Final Day</th>
                <th><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
                <?php
                $i = 0;

                // echo "<pre>";
                //     print_r($classes);
                // echo "</pre>";

                foreach ($exams as $p) :
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>
                        <td><?php echo $p->title; ?></td>
                        <td> <?php echo isset($this->terms[$p->term]) ? $this->terms[$p->term] : ' '; ?></td>
                        <td><?php echo $p->year; ?></td>
                        <td><?php echo $p->start_date ? date('d M Y', $p->start_date) : ''; ?></td>
                        <td><?php echo $p->end_date ? date('d M Y', $p->end_date) : ''; ?> </td>
                        <td><?php echo $p->recording_end ? date('d M Y', $p->recording_end) : ''; ?> </td>
                        <td width='40%'>

                            <div class="btn-group">
                                <button class="btn btn-success">Record</button>
                                <button class="btn  btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <?php
                                    foreach ($classes as $xid => $c) {
                                        
                                    ?>
                                            <li><?php echo anchor('admin/igcse/record/'. $thread->id.'/' . $p->id . '/' . $xid, $c->name); ?></li>
                                        <?php
                                       
                                     }
                                    ?>
                                </ul>
                            </div>
                           
                            <!-- <div class="btn-group">
                                <a class="btn btn-primary " href=""><span class="glyphicon glyphicon-pencil"></span></a>
                                <?php
                                if ($this->ion_auth->is_in_group($this->user->id, 1)) {
                                ?>
                                    <a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/igcse/exams/delete/' . $p->id); ?>'><span class="glyphicon glyphicon-remove"></span> </a>
                                <?php } ?>
                            </div> -->
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    

<?php else : ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif;
