<?php

$students = array();
foreach ($this->parent->kids as $k)
{
        $usr = $this->admission_m->find($k->student_id);
		
		$adm = $usr->admission_number;
				if(!empty($usr->old_adm_no)){
					$adm = $usr->old_adm_no;
				}
		
        $students[$k->student_id] = trim($usr->first_name . ' ' . $usr->last_name . ' - ' .$adm );
}

		$phone =  $this->parent->phone;
		$new_phone = substr_replace($phone, 254, 0, ($phone[0] == '0'));

?>
     				 
	

                            <!------------Classes HISTORY--------------------->
		<div class="row">
		<div class="col-md-6">
		
		<div class="user-card card shadow-sm bg-white  ctm-border-radius grow">
		<div class="user-info card-body" style="background:#F2F2F2 !important">
			
			<div class="card-header">
				<h4 class="card-title mb-0 d-inline-block">Fee Payment Form</h4>
			</div>

			<br>
			   
			<?php 
				//$attributes = array('class' => 'form-horizontal', 'id' => 'payform');
				//echo   form_open_multipart(current_url(), $attributes); 
			?>
			
			<form action="<?php echo current_url();?>" method="POST" class="form-horizontal" id="payform">
            
            <div class="row-fluid">
			  <div class="form-group ">
			 
					<div class="input-prepend">
					   <?php echo form_dropdown('reg_no', array('' => 'Select Student') + $students, $this->input->post('reg_no'), 'id="reg_no"  class="xsel form-control " placeholder="Select Student"'); ?>

						<?php echo form_error('reg_no'); ?>
					   
					</div>
                </div>
				
				 <div class="form-group ">
					
					<div class="input-prepend">              
							<?php echo form_dropdown('payable', array('' => 'Select Account') + $payment_options, $this->input->post('payable'), 'id="payable"  class="xsel form-control " placeholder="Select Student"'); ?>
					</div>
				</div>
				
				
			 <div class="form-group ">
				
                <div class="input-prepend">
                    <?php echo form_input('amount' ,$result->amount , 'id="amount"  class="form-control" required="required" placeholder="Amount *"' );?>
 	                <?php echo form_error('amount'); ?>
                   
                </div>
             </div>
			 
			 
			 <div class="form-group ">

			
				<div class="input-prepend input-group">
						<span class="input-group-addon"> <i class="icon-user"></i> </span>
                   
                    <?php echo form_input('phone' , $new_phone,'id="phone" pattern="\d*" minlength="12" maxlength="12" class="form-control" required="required" placeholder="Phone * E.g 254720000000" style="font-weight:700"' );?>
 	                <?php echo form_error('phone'); ?>
					
					
                </div>
					<p class="text-center" style="color:blue">You can input a different number E.g 254720000000</p>
            </div>
			
			
			
                           
                <div class="dr"><span></span></div>                                
            </div>
         
		   <div class="form-group text-center">
                <div class="">
                   <input type="button" style="padding:8px; text-decoration:none" value="Proceed To Payment" id="payment1" class="btn btn-primary subs" >
                </div>
            </div>

            <div class="dr"><span></span></div>
          </form>            
       </div>
		
		
        </div>
        </div>
		
		
	<div class="col-md-6">
		
		<div class="user-card card shadow-sm bg-white  ctm-border-radius grow" >
		<div class="user-info card-body" style="">
			
		
			<br>
			
			<ul style="color:green; font-size:18px;">
				<li>Once you click on proceed to payment alert with confirmation will popup then click ok <hr></li>
				
				<li>You will receive M-PESA push notification <hr> </li>
				
				<li>Enter your M-PESA PIN to confirm payment <hr></li>
				
				<li>If payment is successful you will receive SMS alert with the amount paid and your fee balance <hr></li>
				
				<li>Receipts can be printed <a href="<?php echo base_url('fee_payment/fee')?>">HERE</a></li>
			</ul>
			
			</div>
		</div>
	   </div>
	   
	   </div>
	   
	   <?php $st = $this->ion_auth->students_full_details(); ?>
	   <script>
	    $(document).ready(function ()
                {
					
	   $('.subs').click(function(){
		   
		   var stud = $('#reg_no').val();
		   var amount = $('#amount').val();
		   var phone = $('#phone').val();
		   var payable = $('#payable').val();
	
			let dollarUSLocale = Intl.NumberFormat('en-US');
            let dollarIndianLocale = Intl.NumberFormat('en-IN');
			
				if(stud =='' ){
					 swal({
								  title: "Validation!",
								  text: "Kindly ensure you select student ",
								  icon: "warning",
								  button:'Close',
								  dangerMode: true,
							});
				  }
				  
				 else if(payable =='' ){
					 swal({
								  title: "Validation!",
								  text: "Kindly ensure you select account receiving payment",
								  icon: "warning",
								  button:'Close',
								  dangerMode: true,
							});
				  }

				  
				 else if(amount =='' ){
					 swal({
								  title: "Validation!",
								  text: "Amount field is required",
								  icon: "warning",
								  button:'Close',
								  dangerMode: true,
							});
				  }
				  
				 else if(phone =='' ){
					 swal({
								  title: "Validation!",
								  text: "Phone field is required",
								  icon: "warning",
								  button:'Close',
								  dangerMode: true,
							});
				  }
			
			
				if(stud !='' && amount !='' && phone !='' && payable !='' ){


				  swal({
						  title: "Confirmation!!",
						  text: "Are you sure you want to make a payment of ksh."+dollarUSLocale.format(amount)+" to your child?",
						  icon: "warning",
						  buttons: true,
						  dangerMode: true,
						})
						.then((willDelete) => {
						  if (willDelete) {
							swal("Success! Your payment has been pushed kindly check you phone", {
							  icon: "success",
							});
							
							document.getElementById("payform").submit();
							
						  } else {
							swal("Payment transaction cancelled");
						  }
						});
						
				}
			  
	  });
   });

</script>
		
		
		
		
		
		
		
		
		
		
