<div id="modal-responsive" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
                          
	<form action="<?php echo base_url('admin/subordinate/upload_subordinate');?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
		  <div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" data-dismiss="modal" aria-hidden="true"
								class="close">&times;</button>
						<h4 id="modal-responsive-label" class="modal-title">Upload Staff</h4></div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
							<div class="mbm">
							<h3>Steps </h3>
							<ul>
								<li>Download Sample CSV <a href="<?php echo base_url('uploads/sample_csv.csv')?>">Here</a></li>
								<li>Ensure Data are arranges as show in the CSV sample format</li>
								<li>Resubordinate to save document as MSDOS csv.</li>
								<li>Click on upload file button then browse to where the file is located/saved</li>
								<li>Click click on upload subordinate button. Finished subordinate will be uploaded</li>
							</ul>
								
								</div>
                       </div>
					  <div class="col-md-12">
								<div class="mbm">
								<div class="col-md-2"></div>
								<div class="col-md-2">
								<input name="csv" type="file" id="csv" />
								</div>
								</div>
                       </div>
					  
					</div>
				</div>
				<div class="modal-footer">
				  		
					
					<button type="submit" class="btn btn-success">Upload Subordinate</button>
					<button type="button" data-dismiss="modal" class="btn btn-default">Close
					</button>
				</div>
			</div>
		</div>
	</form>	
	</div>

 <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Supporting Staff </h2>
             <div class="right"> 
               <?php echo anchor('admin/subordinate/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Staff')), 'class="btn btn-primary"'); ?>

			<?php echo anchor('admin/subordinate', '<i class="glyphicon glyphicon-list">
                </i> Staff Grid View', 'class="btn btn-success"'); ?> 
				
        <?php echo anchor('admin/subordinate/list_view', '<i class="glyphicon glyphicon-list">
                </i> Staff List View' , 'class="btn btn-info"'); ?>
				
				<?php echo anchor('admin/subordinate/inactive', '<i class="glyphicon glyphicon-list">
                </i> Inactive Staff' , 'class="btn btn-warning"'); ?>	
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

          
               <div class="panel-body" style="display: block;">   
               <div class="widget-main">
                
                                  
                <?php if ($subordinate): ?>
                 <div class='clearfix'></div>

 <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">       	
	 <thead>
                <th>#</th>
				
				<th>Passport</th>
				<th>Name</th>
				<th>DOB</th>
				<th>Gender</th>
				<th>Contacts</th>
				<th>ID/PIN No.</th>
				<th>Contract</th>
				
				
				
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
				 $i = 0;
					if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
					{
						$i = ($this->uri->segment(4) - 1) * $per;  
					}
                
            foreach ($subordinate as $p ): 
			
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i; ?></td>					
               	<td>

                          <?php
                        if (!empty($p->passport)):
                             
						?> 
						<image src="<?php echo base_url('uploads/files/' . $p->passport); ?>" width="40" height="40" class="img-polaroid" >
                       
                        <?php else: ?>   
                              <image src="<?php echo base_url('uploads/files/member.png'); ?>" width="40" height="40" class="img-polaroid" >
                        <?php endif; ?>  
						
               	</td>		
				<td><?php echo $p->first_name.' '.$p->middle_name.' '.$p->last_name;?> <br>No: <?php echo $p->staff_no . '.'; ?></td>
				 <td><?php echo date('d M Y',$p->dob); ?></td>		
				<td><?php echo $p->gender;?></td>
				<td><?php echo $p->phone;?><br><?php echo $p->email;?></td>					
				<td><b>ID:</b> <?php echo $p->id_no;?><br><b>PIN:</b><?php echo $p->pin;?></td>
				<td><b>Contracts:</b> <?php echo $contracts[$p->contract_type];?><br><b>Dept: </b><?php echo $departments[$p->department];?></td>
				
					
					
				
					
<td width='200'>
		<div>

				<a class='btn btn-success btn-sm' href='<?php echo site_url('admin/subordinate/profile/'.$p->id.'/'.$page);?>'>
							<i class="fa fa-share"></i> Profile
						</a>
						<a class='btn btn-primary btn-sm' href='<?php echo site_url('admin/subordinate/edit/'.$p->id.'/'.$page);?>'>
							<i class="fa fa-edit"></i> Edit
						</a>
						<a class='btn btn-danger btn-sm'  href="#modal-exit_<?php echo $p->id;?>" data-toggle="modal">
							<i class="fa fa-trash"></i> Exit
						</a>
		
			</div>
		</td>
				</tr>
				
				
	<div id="modal-exit_<?php echo $p->id;?>" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
                          
	<?php 
		
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart('admin/employee_exit/employee_exit/'.$p->id, $attributes); 
?>
	  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true"
							class="close">&times;</button>
					<h4 id="modal-responsive-label" class="modal-title">Add To Group</h4></div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
						
						<div class='form-group'>
	<label class=' col-sm-3 control-label' for='date'>Date <span class='required'>*</span></label>
	<div class="col-sm-9">
	<div class="input-group">
	
	<input id='date' type='text' name='date' required="required" class='form-control datepicker' value=""  />
	
	<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>

</div>
</div>
</div>


		<div class='form-group'>
				<label class=' col-sm-3 control-label' for='reason'>Reason <span class='required'>*</span></label><div class="col-sm-9">
				<?php echo form_input('reason' ,'', 'id="reason_"  class="form-control" required="required"' );?>
				
		</div>
		</div>
                                                
<div class='form-group'>
	<label class=' col-sm-3 control-label' for='comments'>Comments </label><div class="col-sm-9">
	<textarea id="comments"  class="autosize-transition ckeditor form-control "  name="comments"  /></textarea>
	
</div>
</div>
                                             
                         
                        <div class="mbm" > 
						
						</div>
						
						
						
                       </div>
					  
					</div>
				</div>
				<div class="modal-footer">
				                
                                        <button type="submit" class="btn btn-success">Save changes</button> 
										<button type="button" data-dismiss="modal" class="btn btn-default">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
						<?php echo form_close(); ?>	
       </div>
	   
	   
	   
	   
	   <div id="add_groups_<?php echo $p->id;?>" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
                          
	<?php 
		
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart('admin/subordinate/add_groups/'.$p->id, $attributes); 
?>
	  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true"
							class="close">&times;</button>
					<h4 id="modal-responsive-label" class="modal-title">Add To Group</h4></div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
                                             
                         
                        <div class="mbm" > 
						Select Group<br>
						   <?php	
     echo form_dropdown('member_groups',$groups_list,'',' id=""  class=" form-control" placeholder="Member Groups"');
    ?> <i style="color:red"><?php echo form_error('member_groups'); ?></i>
						</div>
						
						
						
                       </div>
					  
					</div>
				</div>
				<div class="modal-footer">
				                
                                        <button type="submit" class="btn btn-success">Save changes</button> 
										<button type="button" data-dismiss="modal" class="btn btn-default">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
						<?php echo form_close(); ?>	
       </div>
			
	<div id="View<?php echo $p->id;?>" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
                          

	  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true"
							class="close">&times;</button>
					<h4 id="modal-responsive-label" class="modal-title">Member Details</h4></div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
                                             
                         
                     <h1>  Implement This view...No More Support hahaha!! </h1>
					 Theme / Template is Mtrek
						
						
						
                       </div>
					  
					</div>
				</div>
				<div class="modal-footer">
				                
                                        
										<button type="button" data-dismiss="modal" class="btn btn-default">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
						
       </div>
				
				
 			<?php endforeach ?>
		</tbody>

	</table>

	<?php echo $links; ?>
  </div>
            </div>
			
			<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 
        </div>


 
