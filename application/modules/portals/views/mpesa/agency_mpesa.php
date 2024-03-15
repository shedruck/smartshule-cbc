
        <div class="wrap">

			 <h1 style="text-align:center">Fee Payment Form</h1>
			 
			   
		<?php 
			$attributes = array('class' => 'form-horizontal', 'id' => '');
			echo   form_open_multipart('fee_payment/index/agency_payment', $attributes); 
		?>
            
            <div class="row-fluid">
			
			    <span class="label-s"> Agency Account *</span>
                <div class="input-prepend">
                    <?php echo form_input('agency' ,$result->agency , 'id="agency"   class="form-control" required="required" onblur="agency_checker()" placeholder="Enter Agency Account Number *"' );?>
 	                <?php echo form_error('agency'); ?>
                   
                </div>
				
			     <span class="label-s"> Select Account *</span>
                <div class="input-prepend">              
                      <?php 
						 echo form_dropdown('account', array(''=>'Select Account')+$pays,  (isset($result->account)) ? $result->account : ''     ,   ' class="select populate" id="account" data-placeholder="Select Options..." ');
						 echo form_error('account'); ?>
                </div>
				 <span class="label-s"> Amount *</span>
                <div class="input-prepend">
                    <?php echo form_input('amount' ,$result->amount , 'id="amount"  class="form-control" required="required" placeholder="Amount *"' );?>
 	                <?php echo form_error('amount'); ?>
                   
                </div>
			

				 <span class="label-s"> Phone *</span>
				<div class="input-prepend input-group">
						<span class="input-group-addon"> <i class="icon-user"></i> </span>
                   
                    <?php echo form_input('phone' ,$result->phone , 'id="phone" pattern="\d*" minlength="12" maxlength="12" class="form-control" required="required" placeholder="Phone * E.g 254720000000"' );?>
 	                <?php echo form_error('phone'); ?>
					
                </div>
				<span  class="label-s" style="color:green; font-size:14px; text-align:center"> M-Pesa push notification will be sent to this number</span>
                           
                <div class="dr"><span></span></div>                                
            </div>
         
		   <div class="row-fluid">
               
                <div class="col-md-4">
                   <button text="submit" href="#" style="padding:8px; text-decoration:none" id="payment1" class="btn btn-primary" >Proceed To Payment</button>
                </div>
            </div>

            <div class="dr"><span></span></div>
        <?php echo form_close(); ?>             
        </div>