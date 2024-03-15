<div class="innerLR">
    <div class="widget widget-gray widget-body-black">
        <div class="widget-head">
            <h4 class="heading glyphicons message_plus">Sms</h4>
        </div>
        <div  class="widget-body" style="padding: 10px 0;">
            <br>
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => 'fm');
            echo form_open_multipart(current_url(), $attributes);
            ?>
             <!-- Start -->
            <div class="well" style="padding-bottom: 20px; margin: 0;">
                <h4 class="heading glyphicons message_plus"><i></i>Compose Email</h4>
                <hr class="separator" />
                <div class="row">
                    <div class="col-md-12">

                        <div class='control-group' id="rc_applicant">
                            <label class='control-label' for='to'>To</label>
                            <div class="controls" >
                                <input type="text" value="<?php echo $applicant->first_name . ' ' . $applicant->last_name . ' (' . $applicant->email . ' )'; ?>" disabled name="user_id" class="col-md-4"/>
                            </div>
                        </div>

                        <div class='control-group'>
                            <label class='control-label' for='cc'>Cc </label>
                            <div class="controls">
                                <?php echo form_input('cc', $sms_m->cc, 'id="cc"  class="col-md-4" id="focusedinput" '); ?>
                                <?php echo form_error('cc'); ?>
                            </div>
                        </div>

                        <div class='control-group'>
                            <label class=' control-label' for='subject'>Subject </label>
                            <div class="controls">
                                <?php echo form_input('subject', $sms_m->subject, 'id="subject_"  class="col-md-4" id="focusedinput" '); ?>
                                <?php echo form_error('subject'); ?>
                            </div>
                        </div>
                        <label class=' control-label' for='description'>Message Body </label>
                        
                        <div class='control-group col-md-11'>
                            <textarea id="ckeditor"  class="wysiwyg focused ckeditor "  name="description"  /><?php echo set_value('description', (isset($sms_m->description)) ? htmlspecialchars_decode($sms_m->description) : ''); ?></textarea>
                            <?php echo form_error('description'); ?>
                        </div>

                        <div class="panel-footer">
                            <div class="innerLR">
                                <div class="col-md-6 center">
                                    <div class="btn-toolbar">
                                        
                                        <button type="submit" class='btn   btn-small'>Send</button>
                                        <span style="margin-left:10px;"><a href="<?php echo base_url('admin/sms'); ?>"> <b class='btn   btn-small'>Cancel</b></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

