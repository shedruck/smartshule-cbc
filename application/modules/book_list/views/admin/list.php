<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Book List  </h2>
	
             <div class="right">  
             <?php echo anchor( 'admin/book_list/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Book List')), 'class="btn btn-primary"');?>
			 
			 <button class="btn btn-primary" onClick="window.location='<?php echo base_url()?>admin/book_list'"><i class="glyphicon glyphicon-list"></i>Grid View</button>
            <button class="btn btn-primary" onClick="window.location='<?php echo base_url()?>admin/book_list/listView'">List View</button>
             
                </div>
                </div>
         	                    
              
                 <?php if ($book_list): ?>
                 <div class="block-fluid">
					 <div class="col-md-12">
						 <form method="post" action="<?php echo base_url('admin/book_list/filterByClass')?>">
						 	<div class="form-group col-md-6">
								 <select class="select select-2" name="class">
									 <option>Filter By class</option>
									 <?php foreach($class as $value){?>
										<option value="<?php echo $value->class_name?>"><?php echo ucfirst($value->class_name)?></option>
									<?php }?>
								 </select>
								 <button name="filter_by_class" class="btn btn-sm btn-primary">Submit</button>
							 </div>
						 </form>

						 <form method="post" action="<?php echo base_url('admin/book_list/filterBySubject')?>">
						 	<div class="form-group col-md-6">
								 <select class="select select-2" name="subject">
									 <option>Filter By Subject</option>
									 <?php foreach($subjects as $subject){?>
										<option value="<?php echo $subject->subject_name?>"><?php echo ucfirst($subject->subject_name)?></option>
									<?php }?>
								 </select>
								 <button name="filter_by_subject" class="btn btn-sm btn-primary">Submit</button>
							 </div>
						 </form>
					 </div>
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Book Name</th>
				<th>Publisher</th>	
				<th>Subject</th>	
				<th>Class</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($book_list as $p ): 
                 $i++;
                     ?>
	 <tr>
					<td><?php echo $i . '.'; ?></td>					
					<td><?php echo $p->book_name;?></td>
					<td><?php echo $p->publisher;?></td>
					<td><?php echo $p->subject_name;?></td>
					<td><?php echo $p->class_name;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/book_list/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/book_list/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/book_list/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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

 <style>
	 .image{
		 width:9%
	 }
	
 </style>

