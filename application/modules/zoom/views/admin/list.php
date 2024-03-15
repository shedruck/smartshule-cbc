<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Zoom  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/zoom/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Zoom')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/zoom' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Zoom')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($zoom): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Link</th>
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
                
            foreach ($zoom as $p ): 
                 $i++;
				 $link= $p->link;
				 $new_link = explode ('/', $link);
				 $meeting_id= $new_link[4];

				 $new_link= str_replace("?","&","$meeting_id");
				 $email=$this->user->email;
				 $name=$this->user->first_name.' '.$this->user->last_name;
				 $prev="https://smartshulezoom.smartshule.com/zoom/index.php?name=$name&email=$email&meeting_id=";
				 $meeting_link= $prev.$new_link;

				//  $users= explode(",",$p->user_group);
				
				 $cc = '';
				if (isset($this->classlist[$p->class])){
					$cro = $this->classlist[$p->class];
					$cc = isset($cro['name']) ? $cro['name'] : '';
				}
                     ?>
	 			<tr>
					<td><?php echo $i . '.'; ?></td>					
					<td><?php echo $p->title;?></td>
					<td><a href="<?php echo $meeting_link?>" target="_blank"><?php echo $meeting_link;?></a></td>
					<td><?php echo $cc;?></td>

					<td width='30'>
							<div class='btn-group'>
								<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
								<ul class='dropdown-menu pull-right'>
									<li><a href='<?php echo site_url('admin/zoom/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
									<li><a  href='<?php echo site_url('admin/zoom/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
									<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/zoom/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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