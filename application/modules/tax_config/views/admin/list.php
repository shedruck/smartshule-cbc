<div class="col-md-8"> 
<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Tax Config  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/tax_config/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Tax Config')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/tax_config' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Tax Config')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($tax_config): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th><th>Name</th><th>Percentage(%)</th>	<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($tax_config as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					<td><?php echo $p->name;?></td>
					<td><?php echo $p->amount;?> %</td>

			 <td width='20%'>
						 <div class='btn-group'>
						 <a class="btn btn-primary" href='<?php echo site_url('admin/tax_config/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
						<?php if( $p->name=="VAT" OR $p->name=="PAYE"):?>
						
						
						<?php else:?>
					<a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/tax_config/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
					<?php endif?>
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
 </div>