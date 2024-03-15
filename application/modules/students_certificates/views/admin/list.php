<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Students Certificates  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/students_certificates/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Students Certificates')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/students_certificates' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Students Certificates')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($students_certificates): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Uploaded On</th>
				<th>Title</th>
				<th>Student</th>
				<th>Certificate No</th>
				<th>Certificate</th>
				<th>Description</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($students_certificates as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo date('d M Y',$p->created_on);?></td>
				<td><?php echo $p->title;?></td>
			
				<td><?php $students=$this->ion_auth->students_full_details(); echo $students[$p->student];?></td>
				<td><?php echo $p->certificate_number;?></td>
				<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' /> <i class=" glyphicon glyphicon-download"></i>  Download Cert</a></td>
				<td><?php echo $p->description;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/students_certificates/my_certs/'.$p->student.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/students_certificates/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/students_certificates/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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