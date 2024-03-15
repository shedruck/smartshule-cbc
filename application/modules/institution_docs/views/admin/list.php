<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Institution Docs  </h2>
             <div class="right">  
            
                </div>
                </div>
         	                    
              
                 <?php if ($institution_docs): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Ownership Doc</th>
				<th>Institution Cert</th>
				<th>Incorporation Cert</th>	
				<th>Ministry Approval</th>	
				<th>Title Deed</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($institution_docs as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->ownership_doc?>' /> <i class="glyphicon glyphicon-download"></i> Ownership Doc</a></td>
				<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->institution_cert?>' /><i class="glyphicon glyphicon-download"></i>  Institution cert</a></td>
				<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->incorporation_doc?>' /><i class="glyphicon glyphicon-download"></i>  Incorporation Doc</a></td>
				<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->incorporation_doc?>' /><i class="glyphicon glyphicon-download"></i>  Ministry Approval</a></td>
				<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->incorporation_doc?>' /><i class="glyphicon glyphicon-download"></i>  Title Deed</a></td>

			 <td width='30'>
						 <div class='btn-group'>
						 <a   class="btn btn-success" href='<?php echo site_url('admin/institution_docs/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
						 
						
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