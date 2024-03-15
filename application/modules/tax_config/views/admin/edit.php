<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  tax_config  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/tax_config/create' , '<i class="glyphicon glyphicon-plus">
                </i> Tax', 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/tax_config' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'tax_config')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">
				   <?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
				   	   <!-- END ADVANCED SEARCH EXAMPLE -->
        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
		 <table cellpadding="0" cellspacing="0" width="100%">
		  <!-- BEGIN -->
            <thead>
                <tr role="row">
				
				
				<th width="3%">#</th>
				<th width="50" >Name</th>
					<th width="50">Percentage(%)</th>
				
				</tr>
            </thead>
           </table>
		   
		   <div id="entry1" class="clonedInput">
							
							 <table cellpadding="0" cellspacing="0" width="100%">  
										<tbody>
										
										<tr >
                  
													 <td width="3%">
													  <span id="reference" name="reference" class="heading-reference">1</span>
													</td>
													<td width="50">
													<input type="text" name="name" id="name" readonly class="name" value="<?php 
															if(!empty($result->name)){
																	echo $result->name;}
															?>">
													<?php echo form_error('name'); ?>
													</td> 
													
													<td width="50">
													<input type="text" name="amount" id="amount" class="amount" value="<?php 
															if(!empty($result->amount)){
																	echo $result->amount;}
															?>">
														<?php echo form_error('amount'); ?>
													
													</td>
											
													
												</tr>
										
										</tbody>
								</table>
							</div>
		   
		   
				
		</div>


<div class='form-group'><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/tax_config','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
