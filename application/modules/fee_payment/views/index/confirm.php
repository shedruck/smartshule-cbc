
        <div class="wrap">

			 <h1 style="text-align:center">M-Pesa payment</h1>
			 
			   
		<?php 
			$attributes = array('class' => 'form-horizontal', 'id' => '');
			echo   form_open_multipart('fee_payment/index/confirm', $attributes); 
		?>
            
            <div class="row-fluid">
			
			    <span style="text-align:center; font-size:15px;"> M-Pesa push notification has been sent to <?php echo $phone; ?> kindly enter password to make payment. 
				<br><br> To print receipt click on the button below</span>
                
                           
                <div class="dr"><span></span></div>                                
            </div>
         
		   <div class="row-fluid pull-right">
               
                <div class="col-md-4">
                   <button text="submit" href="#" style="padding:8px; text-decoration:none" id="payment1" class="btn btn-primary" > Print Receipt</button>
                </div>
            </div>

            <div class="dr"><span></span></div>
        <?php echo form_close(); ?>             
        </div>
		
 <script type="text/javascript">
 $(document).ready(function(){
	  
					    swal({
						  title: "M-Pesa Payment!",
						  text: "M-Pesa push notification has been sent to <?php echo $phone; ?> kindly enter password to make payment.",
						  icon: "success",
						  button:'Close',
						  dangerMode: true,
						});
		 });
</script>