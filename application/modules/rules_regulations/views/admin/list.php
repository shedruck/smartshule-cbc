<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Rules Regulations  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/rules_regulations/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Rules Regulations')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/rules_regulations' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Rules Regulations')), 'class="btn btn-primary"');?> 

				<?php echo anchor( 'admin/rules_regulations/view' , '<i class="glyphicon glyphicon-print">
                </i> '.lang('web_list_all', array(':name' => 'Print Rules Regulations')), 'class="btn btn-success"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($rules_regulations): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Content</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($rules_regulations as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
				<td><?php echo substr($p->content,0,250);?></td>

			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								
								<li><a  href='<?php echo site_url('admin/rules_regulations/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/rules_regulations/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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