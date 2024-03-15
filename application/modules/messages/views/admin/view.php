<div class="encl">
    <div id="message">
        <div class="clearfix"></div>
        <div class="headerx">
            <h3 class="page-title"> <?php echo $message->title ?>
                <a class="btn  pull-right btn-primary" href="<?php echo base_url('admin/messages'); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </h3>
        </div>
        <div id="message-nano-wrapper" class="nanox">
            <ul class="message-container">
                <?php
                foreach ($message->items as $m)
                {
                        ?>
                        <li class="convos">
                            <div class="details">
                                <div class="left"><?php echo $m->from; ?>
                                    <div class="arrow"></div><?php echo $m->to; ?>
                                </div>
                                <div class="right"><?php echo $m->created_on > 10000 ? date('jS M Y H:i', $m->created_on) : ' - '; ?></div>
                            </div>
                            <div class="message">
                                <?php echo htmlspecialchars_decode($m->message); ?>
                            </div>
                            <div class="tool-box">
                                <a href="#" class="circle-icon small red-hover glyphicon glyphicon-edit"></a>
                                <a href="#" class="circle-icon small red-hover glyphicon glyphicon-remove"></a>
                            </div>
                        </li>
                <?php } ?>
                <li class="convos">
                    <div class="details">
                        <div class="left">Reply</div>
                        <div class="right">&nbsp;</div>
                    </div>
                    <?php
                    $attributes = array('class' => 'form-horizontal', 'id' => '');
                    echo form_open_multipart(current_url(), $attributes);
                    ?>
                    <?php echo form_error('message'); ?>
                    <textarea class="compse" name="message"></textarea>
                    <div class="toolbar">
                        <div class="pull-right">
                            <button class="btn btn-primary" type="submit"><i  class=" glyphicon glyphicon-send"></i> Send</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </li>
            </ul>
        </div>
    </div>    
</div>
<style>
    .circle-icon.small {
        line-height: 12px;
    }
    .cleditorMain{min-height: 300px !important;}
    #message .headerx 
    {
        padding: 1px 22px;
        background: white;
    }
    ol li {
        list-style-type: decimal ;
        padding: 0px;
    }
    #message .message-container li .message
    {
        padding: 0 40px;
        font-size: 13px;
    }
</style>
<script>
        $(document).ready(function ()
        {
            $(".compse").cleditor({width: "100%", height: "320px"});

        });
</script>