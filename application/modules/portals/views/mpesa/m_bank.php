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
			
			<?php echo validation_errors() ?>
			<?php echo  form_open('portals/parents/malipo')?>

			<div class="form-group">
				<div class="input-prepend">
					<label>Select Term</label>
					<select name="term" class="form-control" required>
						<option value="">.....Select Term....</option>
						<option value="Term 1">.....First Term....</option>
						<option value="Term 2">.....Second Term....</option>
						<option value="Term 3">.....Third Term....</option>
					</select>
				</div>
			</div>
            
            <div class="row-fluid">
			  <div class="form-group ">
					<div class="input-prepend">
					   <?php echo form_dropdown('reg_no', array('' => 'Select Student') + $students, $this->input->post('reg_no'), 'id="reg_no"  class="xsel form-control " placeholder="Select Student"'); ?>

						<?php echo form_error('reg_no'); ?>
					   
					</div>
                </div>
				
				
				
				
			<div class="form-group">
                <input type="number" name="amount" class="form-control" placeholder="Amount payable">
            </div>
			 
			 
			 <div class="form-group ">

			
				<div class="input-prepend input-group">
						<span class="input-group-addon"> <i class="icon-user"></i> </span>
                   
                    <?php echo form_input('phone' , $new_phone,'id="phone" pattern="\d*" minlength="12" maxlength="12" class="form-control" required="required" placeholder="Phone * E.g 254720000000" style="font-weight:700"' );?>
 	                <?php echo form_error('phone'); ?>
					
					
                </div>
					<p class="text-center" style="color:blue">You can input a different number E.g 254720000000</p>
            </div>

			<div class="form-group">
				<div class="input-prepend">
					<label>Select Account</label>
					<select name="api_key" class="form-control" required>
						<option value="">.....Select Account....</option>
						<?php foreach($banks as $bank){
							$api_key=$bank->api_key;
							$api_username= $bank->api_username;
							$bank_name= $bank->bank_name;
							$account_number= $bank->account_number;
							?>
						<option value="<?php echo $bank_name?>.<?php echo $api_username?>.<?php echo $api_key?>.<?php echo $account_number?>"><?php echo $bank_name?></option>
						<?php }?>
						
					</select>
				</div>
			</div>
			
			
                           
                <div class="dr"><span></span></div>                                
            </div>
         
		   <div class="form-group text-center">
                <div class="">
                   <input type="submit" name="m_bank" style="padding:8px; text-decoration:none" value="Proceed To Payment"  class="btn btn-primary subs" >
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
				
				<li>You will receive M-PESA push notification <hr></li>
				
				<li>Enter your M-PESA PIN to confirm payment <hr></li>
			
				<li>If payment is successful you will receive SMS alert with the amount paid and your fee balance <hr></li>
				
				<li>Receipts can be printed <a href="<?php echo base_url('fee_payment/fee')?>">HERE</a></li>
			</ul>
			
			</div>
		</div>
	   </div>
	   
	   </div>
	   
	   <?php $st = $this->ion_auth->students_full_details();
    ?>
	  
		
		
		
