 <!-----------------------------ADD MODAL------------------------->
<div class="modal fade" id="Upload" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<form action="<?php echo base_url('admin/subcounties/upload_subs');?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Upload Students</h4>
				<div class="clearfix"></div>
			</div>
		

			<div class='form-group'>
				<div class='col-md-1 ' for='survey_date'> 
				</div>
				<label class='col-md-9 control-label' for='survey_date'> 
				Choose CSV File
				</label>
				<div class="col-md-12">
				 <hr class="col-md-11">
			
				 <div class="col-md-8">
		
                                <?php

                               $items = $this->ion_auth->populate('counties','id','name');		
                                echo form_dropdown('county',array(''=>'Select County')+ $items, (isset($result->county)) ? $result->county : '', ' class="select" data-placeholder="Select  Options..." ');

                                ?>
								
                            </div>
							
							 
							
							 <div class="col-md-8">
							 <hr>
							 Choose the CSV File to upload
				 <input name="csv" type="file" id="csv" /> <br>
				 </div>
				
			</div>
			</div> 

            <div class="modal-footer">

				<button type="submit" class="btn btn-primary">
					Save Changes
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">
					Close
				</button>
				</div>
			</form> 
		</div>
	</div>
</div>


<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Sub Counties  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/subcounties/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Subcounties')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/subcounties' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Subcounties')), 'class="btn btn-primary"');?> 
				
				 <a data-toggle="modal" style='' class="btn btn-success" role="button" href="#Upload">
				<i class='glyphicon glyphicon-share'></i> Upload Data
			  </a>
             
                </div>
                </div>
         	                    
              
                 <?php if ($subcounties): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>County</th>	
				<th>Sub county</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
             $cc = $this->ion_auth->populate('counties','id','name');   
            foreach ($subcounties as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $cc[$p->county];?></td>
				<td><?php echo $p->subcounty;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/subcounties/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/subcounties/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
							</ul>
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>