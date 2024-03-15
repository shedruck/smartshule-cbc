<?php
if ($this->input->get('sw'))
{
        $sel = $this->input->get('sw');
}
elseif ($this->session->userdata('pw'))
{
        $sel = $this->session->userdata('pw');
}
else
{
        $sel = 0;
}
?>
<?php echo form_open(current_url(), 'class="form-inline" id="fextra"'); ?>
<div class="col-md-7">
    <div class="middle">
        <div class="button tip" title="Sent">
            <a href="<?php echo base_url('admin/sms/log'); ?>">
                <span class="icomg-redo"></span>
                <span class="text">View Sent</span>
            </a>
        </div>                        
        <div class="button tip" title="Custom">
            <a href="<?php echo base_url('admin/sms/custom'); ?>">
                <span class="icomg-comments3"></span>
                <span class="text">Custom</span>
            </a>
        </div>

	<div class="button tip" title="Custom">
            <a href="<?php echo base_url('admin/sms/sms_random'); ?>">
                <span class="icomg-comments3"></span>
                <span class="text">SMS Random Numbers</span>
            </a>
        </div> 
		
        <div class="button tip" title="Check SMS Balance">
            <a href="<?php echo base_url('admin/sms/balance'); ?>">
                <span class="icomg-info"></span>
                <span class="text">Balance<br/> </span>
            </a>
        </div>          
    </div>
</div>

<div class="col-md-5">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icosg-newtab"></span></div>
            <h2>Message</h2>
        </div>
        <div class="block-fluid">
            <?php
            $items = array(
                '' => 'Send To:',
                'All Parents' => 'All Parents',
                'All Teachers' => 'All Teachers',
                'All Staff' => 'All Staff',
                'Staff' => 'Staff'
            );
            ?>
            <div class="block-fluid">
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open_multipart(current_url(), $attributes);
                ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <?php echo form_dropdown('send_to', $items, $sms_m->send_to, ' data-placeholder="Send To:" onchange="show_field(this.value)" id="send_to" class="select chosen col-md-4"  tabindex="4"'); ?>
                    </div>
                </div>
                <div class="form-group" id="rc_staff">
                    <div class="col-md-12">
                        <span class="top title"></span>
                        <?php
                        echo form_dropdown('staff', array('' => 'Select Staff') + $users, (isset($sms_m->staff)) ? $sms_m->staff : '', ' class="select populate col-md-4"  ');
                        echo form_error('staff');
                        ?>
                    </div>
                </div> 
                <div class="form-group" id="rc_parent">
                    <div class="col-md-12">
                        <span class="top title"></span>
                        <?php
                        echo form_dropdown('parent', array('' => 'Select Parent') + (array) $parents, (isset($sms_m->parent)) ? $sms_m->parent : '', ' class=" populate col-md-6" ');
                        echo form_error('parent');
                        ?>
                    </div>
                </div>
                <div class="form-group" id="rc_class">
                    <div class="col-md-12">
                        <span class="top title"></span>
                        <?php
                        echo form_dropdown('class', array('' => 'Select Class') + (array) $classes, (isset($sms_m->class)) ? $sms_m->class : '', ' class=" select chosen col-md-6" ');
                        echo form_error('class');
                        ?>
                    </div>
                </div>
            </div>
            <div id="type1" class="hider">
                <span>NB: Sms is charged per 160 characters <span id="len" class="pull-right"></span></span>
                <textarea name="sms" placeholder="Your Message" class="common autoExpand" rows='5' id="sms"></textarea>
            </div>
            <div class="clearfix"></div> 
            <div class="p-action pull-right">
                <input type="submit" class="btn btn-primary " value="Export" name="export"/>&nbsp;
                <input type="submit" class="btn btn-success pull-right" value="Send SMS" onClick="return confirm('Confirm Send SMS')" name="send" />
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<style>
    textarea  {
        min-height: 140px !important;
    }
    .autoExpand{  
        display:block;
        width:100%;       
        border-radius:6px;
    }
    .p-action{margin: 7px;}
</style>
<script type = "text/javascript">
        $(function () {
            $("input:radio[name=stype]").on('click', function ()
            {
                $('.hider').hide();
                $("#type" + $(this).val()).show('slow');
            });
        });
        $(document).ready(function ()
        {
            $("textarea.autoExpand").on("input", function ()
            {
                $(this).css("height", 50);
                $(this).css({"overflow": "hidden", "height": this.scrollHeight + "px"});
            });

        });
</script>
<script>
        $(document).ready(
                function ()
                {
                    $('#sms').on('change keyup', function ()
                    {
                        $("#len").text($(this).val().length);
                    });
                });
        function show_field(item)
        {
            //hide all
            document.getElementById('rc_staff').style.display = 'none';
            document.getElementById('rc_parent').style.display = 'none';
            document.getElementById('rc_class').style.display = 'none';

            if (item == 'Staff')
                document.getElementById('rc_staff').style.display = 'block';
            if (item == 'Parent')
                document.getElementById('rc_parent').style.display = 'block';
            if (item == 'Class')
                document.getElementById('rc_class').style.display = 'block';
            return;
        }
<?php
if ($this->uri->segment(3) == 'create')
{
        ?>
                show_field('None');
<?php } ?>
</script>