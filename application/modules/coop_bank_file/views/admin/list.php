<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Coop Bank File  </h2>
             <div class="right">  
               <a data-toggle="modal" style='' class="btn btn-success" role="button" href="#coop">
				<i class='glyphicon glyphicon-share'></i> Upload Coop File
			  </a>
			 
			 <?php echo anchor( 'admin/coop_bank_file' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Coop Bank File')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($coop_bank_file): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th><th>Transaction Date</th><th>Channel Ref</th><th>Transaction Ref</th><th>Narrative</th><th>Debit</th><th>Credit</th><th>Running Bal</th><th>Transaction No</th><th>Admission No</th><th>Student</th><th>Phone</th>	<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;

            foreach ($coop_bank_file as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->transaction_date;?></td>
					
					<td><?php echo  substr($p->channel_ref,0,10);?>...</td>
					<td><?php echo substr($p->transaction_ref,0,10);?>...</td>
					<td><?php echo $p->narrative;?></td>
					<td><?php echo $p->debit;?></td>
					<td><?php echo $p->credit;?></td>
					<td><?php echo $p->running_bal;?></td>
					<td><?php echo $p->transaction_no;?></td>
					<td><?php echo $p->admission_no;?></td>
					<td><?php echo $p->student;?></td>
					<td><?php echo $p->phone;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/coop_bank_file/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/coop_bank_file/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/coop_bank_file/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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
 
 
  <!-----------------------------ADD MODAL------------------------->
<div class="modal fade" id="coop" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<form action="<?php echo base_url('admin/coop_bank_file/coop');?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Upload Bank Files</h4>
				<div class="clearfix"></div>
			</div>
		

			<div class='form-group'>
				<div class='col-md-1 ' for='survey_date'> 
				</div>
				<label class='col-md-9 control-label' for='survey_date'> 
				Choose CSV File <br>
				Click <a href="<?php echo base_url('uploads/Sample_Students_Upload_File.xlsx')?>">HERE</a> to download Sample file
				<span class='error'>*</span>
				</label>
				<div class="col-md-12">
				 <hr class="col-md-11">
	
				 <div class="col-md-8">
				 <hr>
							 Choose the CSV File to upload
				 <input name="file" type="file" id="file" /> <br>
				 </div>
				
			</div>
			</div> 

<div class="modal-footer">

				<button type="submit" class="btn btn-primary">
					Upload
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">
					Close
				</button>
				</div>
			</form> 
			</div>
			</div>
			</div>