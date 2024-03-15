
<div class="row">
    <div class="widget-box centered" style="opacity: 1; z-index: 0;">   
        <div class="widget-header"> <h3>Deactivate User <?php echo $user['username']; ?> </h3>
            <div class="widget-toolbar"> 
                <a href="#" data-action="collapse"> <i class="glyphicon glyphicon-chevron-up"></i> </a>
            </div>
        </div>

        <div class="widget-body">    
            <div class="widget-main">
                <p>Are you sure you want to deactivate the user '<?php echo $user['username']; ?>'</p>

                <?php echo form_open("admin/users/deactivate/" . $user['id']); ?>

                <div class="controls">
                    <label>
                        <input type="radio" name="confirm" value="yes" checked="checked" />
                        <span class="lbl">Yes</span>
                    </label>

                    <label>
                        <input type="radio" name="confirm" value="no" />
                        <span class="lbl"> No</span>
                    </label>

                </div>
 
                <?php echo form_hidden($csrf); ?>
                <?php echo form_hidden(array('id' => $user['id'])); ?>

                <p><?php echo form_submit('submit', 'Submit', 'class="btn btn-blue btn-small"'); ?></p>

                <?php echo form_close(); ?>
            </div>

        </div>
    </div>


    <!-- content ends -->
</div><!--/#content.col-md-10-->

