<div class="col-md-2">&nbsp;</div>
<div class="col-md-9 card-box table-responsive">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2> New Message 
            <div class="pull-right">
                <?php echo anchor('trs/messages', '<i class="mdi mdi-reply">
                </i> Back ', 'class="btn btn-primary"'); ?> 
            </div>
        </h2>
    </div>
    <div class="block-fluid">
        <div class="clearfix"></div>
        <hr/>
        <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class="form-group">
            <label for="tt" class="col-sm-3 control-label">Title <span class="required">*</span></label>
            <div class="col-sm-9">
                <?php echo form_input('title', $result->title, 'id="tt" class="form-control " placeholder="Message Title" '); ?>
                <?php echo form_error('title'); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Parent <span class="required">*</span></label>
            <div class="col-sm-9">
                <?php
                echo form_dropdown('to[]', $parents, (isset($result->to)) ? $result->to : '', ' class="select" multiple data-placeholder="Select ..." ');
                echo form_error('to');
                ?>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-3 control-label">Message <span class="required">*</span></label>
            <div class="col-sm-9">
                <?php echo form_error('message'); ?>
                <textarea name="message" class="summernote"><?php echo set_value((isset($result->message)) ? htmlspecialchars_decode($result->message) : ''); ?></textarea>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <a href="<?php echo base_url('trs/messages'); ?>" class="btn btn-custom-2">  <i class="mdi mdi-close"></i> <span>Cancel</span></a>
                <button  type="submit" class="btn btn-pink"> <i class="mdi mdi-send"></i> <span> Send &nbsp; </span> </button>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<style>
    .btn {
        border: 1px solid #84bb26;
        padding: 7px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        border-radius: 3px;
    }
</style>