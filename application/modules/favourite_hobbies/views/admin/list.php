<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Favourite Hobbies  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/favourite_hobbies/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Favourite Hobbies')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/favourite_hobbies' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Favourite Hobbies')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($favourite_hobbies): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Student</th>
				<th>Year</th>
				<th>Languages Spoken</th>
				<th>Hobbies</th>
				<th>Favourite Subjects</th>
				<th>Favourite Books</th>
				<th>Favourite Food</th>
				<th>Favourite Bible Verse</th>
				<th>Favourite Cartoon</th>
				<th>Favourite Career</th>
				<th>Others</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
			 $i = 0;
				if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
				{
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}
             $data = $this->ion_auth->students_full_details();   
            foreach ($favourite_hobbies as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $data[$p->student];?></td>
					<td><?php echo $p->year;?></td>
					<td><?php echo $p->languages_spoken;?></td>
					<td><?php echo $p->hobbies;?></td>
					<td><?php echo $p->favourite_subjects;?></td>
					<td><?php echo $p->favourite_books;?></td>
					<td><?php echo $p->favourite_food;?></td>
					<td><?php echo $p->favourite_bible_verse;?></td>
					<td><?php echo $p->favourite_cartoon;?></td>
					<td><?php echo $p->favourite_career;?></td>
					<td><?php echo $p->others;?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/favourite_hobbies/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/favourite_hobbies/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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