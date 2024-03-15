<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
               
				 <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-6">		
								    <div class=" col-md-12">
                                             <h5 class="text-18-bold"> <?php echo theme_image('icons2/Approvals.jpg',array('width'=>'93','height'=>'80'))?> Loan Application </h5>
                                     </div>
									
							</div>
             <div class="col-md-6">
                                <div class="pull-right">
         <?php echo anchor( 'st/loan_application/' , '<i class="fa fa-plus"></i> New Application', 'class="btn btn-primary"');?> 
         <?php echo anchor( 'st/loan_statement/' , '<i class="fa fa-file"></i> Statement', 'class="btn btn-success"');?> 
		 
         <?php echo anchor( 'st/finance' , '<i class="fa fa-caret-left"></i> Exit ', 'class="btn btn-danger"');?> 
             
                              </div>
                            </div>
                        </div>
                    </div>
   <hr>
	<div class="block-fluid">
	
		  <?php $settings = $this->ion_auth->settings();?>
		  
  <div class="image text-center" >
			<img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" class="text-center" align="center" style="" width="120" height="120" />    
		</div>

                
				<h3 style="text-align: center;"><?php echo $settings->school;?></h3>
<ul style="text-align: center;">
<li><?php echo $settings->postal_addr;?></li>
</ul>
<p style="text-align: center;">Tel: <?php echo $settings->tel;?> <?php echo $settings->cell;?>&nbsp; &nbsp;&nbsp;&nbsp; Email: <?php echo $settings->email;?></p>
	
	
	  <div class="image text-center" >
			<?php 
												
								 $photo = $this->student->photo ? $this->st_m->passport($this->student->photo) : 0;
									if ($photo)
									{
											$path = 'uploads/' . $photo->fpath . '/' . $photo->filename;
											
									}
									else
									{
											$path = image_path('avatar-blank.jpg');
									}
									

							?>
						
				<image src="<?php echo base_url($path); ?>" width="120" height="120" class="" alt="User-Profile-Image">  
				<p>&nbsp;</p>
				<div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
						<table style="width: 100%;" border="1" class="profile-table profile-text" >
							   <tbody>


								  <tr class="profile-th">
									 <td width="187" class="">
										<p><strong>Student Name </strong></p>
									 </td>
									 <td width="450" class="bg-white">
										<p>
										<?php echo $this->student->first_name;?>
										<?php echo $this->student->middle_name;?>
										<?php echo $this->student->last_name;?>
										</p>
									 </td>
								  </tr>

								  <tr class="profile-th">
									 <td width="187" class="">
										<p><strong>Class </strong></p>
									 </td>
									 <td width="450" class="bg-white">
										<p><?php $cl = $this->ion_auth->fetch_classes(); echo $cl[$this->student->class];?></p>
									 </td>
								  </tr>

								  <tr class="profile-th">
									 <td width="187" class="">
										<p><strong>UPI Number </strong></p>
									 </td>
									 <td width="450" class="bg-white">
										<p><?php echo $this->student->upi_number;?></p>
									 </td>
								  </tr>
								  
							</tbody>	  
						</table>
               </div>
                 <div class="col-sm-3"></div>	
              </div>				 
		</div>
	
	<p>&nbsp;</p>
                                          
  <div class="row" >
					<!-- web statustic card start -->
					<div class="col-xl-3 col-md-6">
						<div class="card o-hidden bg-c-purple web-num-card">
							<div class="card-block text-white">
								<h6 class="text-center"><b> Applications</b></h6>
								<h3 class="text-center">
									<?php
									  echo number_format(count($loans));
								   
									?>

								</h3>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card o-hidden bg-c-green web-num-card">
							<div class="card-block text-white">
								<h6 class="text-center"> <b>Approved</b></h6>
								<h3 class="text-center"><?php
								   
									 $count = $this->portal_m->user_loan_counter($this->student->id,1,1);
									 echo number_format($count);
									?></h3>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-md-6">
						<div class="card o-hidden bg-c-red web-num-card">
							<div class="card-block text-white">
								<h6 class="text-center"> <b>Declined</b></h6>
								<h3 class="text-center"><?php
									 $count = $this->portal_m->user_loan_counter($this->student->id,1,2);
									echo number_format($count);
									?></h3>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-md-6">

						<div class="card o-hidden bg-c-yellow web-num-card">
							<div class="card-block text-white">
								<h6 class="text-center"> <b>Pending</b> </h6>
								<h3 class="text-center"><?php
									 $count = $this->portal_m->user_loan_counter($this->student->id,1,0);
									echo number_format($count);
									?></h3>
							</div>
						</div>
					</div>

				</div>

                                            <!-- web statustic card end -->
	  
								      
                 <?php if ($loans): ?>
                 <div class="block-fluid">
				<table id="dom-jqry1" class="table table-striped table-bordered " >
	 <thead>
                <th>#</th>
				<th>Date</th>
				<th>Loan Ref</th>
				<th>Approved</th>
				<th>Paid</th>
				<th>Balance</th>
				
		</thead>
		<tbody>
		<?php 
                             $i = 0;
            $tot_approved = 0;    
            $tot_paid = 0;    
            $bal = 0;    
            foreach ($loans as $p ): 
                 $i++;
             $bal = $p->approved_amount - $p->paid_amount;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>				
				<td><?php echo date('d M Y',$p->date);?></td>
				<td>1000500<?php echo $p->id;?></td>		
				<td><?php echo number_format($p->approved_amount,2);?></td>
				<td><?php echo number_format($p->paid_amount);?></td>
				
				<td><?php echo number_format($bal);?></td>

				</tr>
			
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>


<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?> 
  </div>
</div>
</div>



