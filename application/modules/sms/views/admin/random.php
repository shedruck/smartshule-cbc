
<div class="col-md-12">
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

<div class="col-md-12">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icosg-newtab"></span></div>
            <h2>Message</h2>
        </div>
        <div class="block-fluid">
         
            <div class="block-fluid">
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open_multipart(current_url(), $attributes);
                ?>
              
            </div>
			<div class="col-md-4">
				<div id="type1" class="hider">
					<span>NB: Enter phone numbers in new line </span>
					<i style="color:red"><?php echo form_error('numbers'); ?></i>
					<textarea name="numbers" placeholder="Enter Number in new line" class="common autoExpand"  style="height:500" rows='15' id="numbers"></textarea>
					
					 
				</div>
            </div>

			<div class="col-md-4">
				<div id="type1" class="hider">
					<span>NB: Sms is charged per 160 characters </span>
					 <i style="color:red"><?php echo form_error('message'); ?></i>
					<textarea name="message" placeholder="Your Message" class="common autoExpand" rows='5' id="message"></textarea>
					
					<br>
					<input type="submit" class="btn btn-success " value="Send SMS" onClick="return confirm('Confirm Send SMS')" name="send" />
				</div>
            </div>
			
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<style>
   
	#numbers  {
        min-height: 300px !important;
    }
	
	#message  {
        min-height: 200px !important;
    }
    .autoExpand{  
        display:block;
        width:100%;       
        border-radius:6px;
    }
    .p-action{margin: 7px;}
</style>
