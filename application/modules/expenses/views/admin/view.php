<div class="col-md-4">
<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Expense Details  </h2>
			  <div class="right">  
			 <?php echo anchor( 'admin/expenses/edit/'.$p->id , '<i class="glyphicon glyphicon-edit"></i> Edit Details', 'class="btn btn-primary"');?> 
             
                </div>
                </div>

          <div class="block-fluid">
                        
            <div class="col-md-12">
                
                <div class="timeline">
				<div class="event" style="min-width:180px !important">
                        <div class="icon"><span class="icos-calendar"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#"> Expense Date</a> </div>
                             <div class="text"><?php echo date('d M Y',$p->expense_date);?></div>
                        </div>
                    </div>  
                    
                    <div class="event" style="min-width:180px !important">
                      
                        <div class="icon"><span class="icos-share"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#">  Title</a> </div>
                             <div class="text"><?php echo $p->title;?></div>
                        </div>
                    </div>    
					 <div class="event" style="min-width:180px !important">
                      
                        <div class="icon"><span class="icos-comments3"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#">  Category</a> </div>
                             <div class="text"><?php echo $cats[$p->category];?></div>
                        </div>
                    </div>    
					 <div class="event" style="min-width:180px !important">
                      
                        <div class="icon"><span class="icos-briefcase"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#">  Amount</a> </div>
                             <div class="text"><?php echo $this->currency;?><?php echo number_format($p->amount,2);?></div>
                        </div>
                    </div>    
					 <div class="event" style="min-width:180px !important">
                      
					<div class="icon"><span class="icos-user"></span></div>
					<div class="body">
						<div class="arrow"></div>
						<div class="user"><a href="#">  Person Responsible</a> </div>
						 <div class="text"><?php  $user=$this->ion_auth->get_user($p->person_responsible); echo $user->first_name.' '.$user->last_name;?></div>
					</div>
				</div>    
					
					
					<div class="event" style="min-width:180px !important">
                        <div class="icon"><span class="icos-download"></span></div>
                        <div class="body">
                            <div class="arrow"></div>
                            <div class="user"><a href="#"> Receipt</a> </div>
                             <div class="text">
								<?php if(!empty($p->receipt)){?>
								<a href="<?php echo base_url('uploads/files/'.$p->receipt);?>"><i class="glyphicon glyphicon-download"></i> Download Attachment</a>
								<?php } else {?>
								<b >No Attachment</b>
								<?php } ?>
							 
							 </div>
                        </div>
                    </div>  
                </div>
             </div>
           </div>
    </div>
	<div class="col-md-8">
	
	<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Description  </h2>
             <div class="right">  
					 <?php echo anchor( 'admin/expenses/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Expense')), 'class="btn btn-primary"');?>
					
					<?php echo anchor( 'admin/expenses' , '<i class="glyphicon glyphicon-list"></i> List All', 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                
                 <div class="block-fluid" style="padding:20px !important;">
				
				 <?php echo $p->description; ?>
				
	
				</div>

	</div>