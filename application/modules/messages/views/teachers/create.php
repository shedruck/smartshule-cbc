<?php
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes);

// echo "<pre>";
// print_r($this->profile);
// echo "</pre>";
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">New Message</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <?php echo anchor('messages/trs', '<i class="mdi mdi-reply">
                    </i> Back ', 'class="btn btn-primary"'); ?>
                </div>
            </div>
            <div class="card-body p-0 mb-2">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-xl-8 col-lg-8 col-sm-12">
                        <div class="row m-2">
                            <label for="tt" class="col-sm-3 control-label">Title <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <?php echo form_input('title', $result->title, 'id="tt" class="form-control " placeholder="Message Title" '); ?>
                                <?php echo form_error('title'); ?>
                            </div>
                        </div>
                        <div class="row m-2">
                            <label class="col-sm-3 control-label">Parent <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <?php
                                echo form_dropdown('to[]', $parents, (isset($result->to)) ? $result->to : '', ' class="form-control js-example-placeholder-exam" multiple data-placeholder="Select ..." ');
                                echo form_error('to');
                                ?>
                            </div>
                        </div>
                        <div class="row m-2">
                            <label class="col-sm-3 control-label">Message <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <?php echo form_error('message'); ?>
                                <textarea name="message" class="form-control editor"><?php echo set_value((isset($result->message)) ? htmlspecialchars_decode($result->message) : ''); ?></textarea>
                            </div>
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
                    <a href="<?php echo base_url('messages/trs'); ?>" class="btn btn-default"> <i class="mdi mdi-close"></i> <span>Cancel</span></a>
                    <button type="submit" class="btn btn-pink"> <i class="mdi mdi-send"></i> <span> Send &nbsp; </span> </button>
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