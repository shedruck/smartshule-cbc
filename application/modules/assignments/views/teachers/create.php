<?php
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes);
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Add Assignments</h6>
                <div class="float-end">
                    <?php echo anchor('assignments/trs', '<i class="mdi mdi-reply">
                    </i> ' . lang('web_list_all', array(':name' => 'Assignments')), 'class="btn btn-primary"'); ?>
                </div>
            </div>
            <div class="card-body p-0 mb-2">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-xl-8 col-lg-8 col-sm-12">
                        <div class='row m-2'>
                            <div class="col-md-3" for='title'>Title <span class='required'>*</span></div>
                            <div class="col-md-9">
                                <?php echo form_input('title', $result->title, 'id="title"  class="form-control" '); ?>
                                <?php echo form_error('title'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3" for='title'>Subject / Learning Area <span class='required'>*</span></div>
                            <div class="col-md-9">
                                <?php
                                $items = array('' => 'Select Subject');
                                echo form_dropdown('subject', $items + $subjects, (isset($result->subject)) ? $result->subject : '', ' id="subject" class="select js-example-placeholder-exam form-control" data-placeholder="Select Options..." ');
                                echo form_error('subject');
                                ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3" for='topic'>Topic / Strand <span class='required'>*</span></div>
                            <div class="col-md-9">
                                <?php echo form_input('topic', $result->topic, 'id="topic"  class="form-control" '); ?>
                                <?php echo form_error('topic'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3" for='title'>Subtopic / Sub-strand </div>
                            <div class="col-md-9">
                                <?php echo form_input('subtopic', $result->subtopic, 'id="subtopic"  class="form-control" '); ?>
                                <?php echo form_error('subtopic'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3" for='start_date'>Start Date <span class='required'>*</span></div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="start_date" value="<?php if ($result->start_date) echo date('d M Y', $result->start_date); ?>" class="date form-control datepicker">
                                    <span class="input-group-text" id="basic-addon2"><i class="mdi mdi-calendar"></i></span>
                                </div>
                                <?php echo form_error('start_date'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3" for='end_date'>End Date <span class='required'>*</span></div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input value="<?php if ($result->end_date) echo date('d M Y', $result->end_date); ?>" type="text" name="end_date" class="date form-control datepicker">
                                    <span class="input-group-text" id="basic-addon2"><i class="mdi mdi-calendar"></i></span>
                                </div>
                                <?php echo form_error('end_date'); ?>
                            </div>
                        </div>
                        <div class='row m-2'>
                            <div class="col-md-3" for='document'>Upload Document </div>
                            <div class="col-md-9">
                                <input id='document' type='file' name='document' class="form-control" />
                                <br /><?php echo form_error('document'); ?>
                                <?php echo isset($type) ? 'File: ' . $result->document : ' ' ?>
                                <?php echo (isset($upload_error['document'])) ? $upload_error['document'] : ""; ?>
                            </div>
                        </div>

                        <div class='widget'>
                            <div class='head dark'>
                                <div class='icon'><i class='icos-pencil'></i></div>
                                <h6>Assignment - Type or past the assignment here </h6>
                            </div>
                            <!-- <div class="block-fluid"> -->
                                <textarea style="min-height: 150px;" id="" class="form-control" name="assignment" /><?php echo set_value('assignment', (isset($result->assignment)) ? htmlspecialchars_decode($result->assignment) : ''); ?></textarea>
                                <?php echo form_error('assignment'); ?>
                            <!-- </div> -->
                        </div>

                        <div class='widget'>
                            <div class='head dark'>
                                <div class='icon'><i class='icos-pencil'></i></div>
                                <h6>Comment </h6>
                            </div>
                            <!-- <div class="block-fluid"> -->
                                <textarea style="min-height: 150px;" id="" class="form-control" name="comment" /><?php echo set_value('comment', (isset($result->comment)) ? htmlspecialchars_decode($result->comment) : ''); ?></textarea>
                                <?php echo form_error('comment'); ?>
                                <?php
                                $ext = isset($ex) ? $ex : 0;
                                echo form_hidden('extras', set_value('extras', $ext));
                                ?>
                            <!-- </div> -->
                        </div>
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
                    <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                    <!-- <button type="submit" class="btn btn-primary" id="submitButton"><i class="fe fe-check-square me-1 lh-base"></i>Submit</button> -->
                    <!-- <a class="btn btn-secondary" id="cancelButton"><i class="fe fe-arrow-left-circle me-1 lh-base"></i>Cancel</a> -->
                    <?php echo anchor('assignments/trs', 'Cancel', 'class="btn  btn-secondary"'); ?>
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
