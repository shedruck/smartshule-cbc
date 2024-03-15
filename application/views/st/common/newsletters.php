<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
				 <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-4">		
								<h4 class="m-b-10">  Newsletters  </h4>
							</div>
             <div class="col-md-8">
                                <div class="pull-right">
              <?php echo anchor( 'st#communication' , '<i class="fa fa-caret-left"></i> Exit', 'class="btn btn-danger"');?> 
             
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
			<hr>      
				   <div class="block-fluid">
         	                    
              
                 <?php if ($newsletters): ?>
                 <div class="block-fluid">
				<table id="dom-jqry" class="table table-striped table-bordered " >
	 <thead>
                <th>#</th>
				<th>Name</th>
				<th>Title</th>
				<th>Description</th>
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
 
            foreach ($newsletters as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->name;?></td>
				<td><?php echo $p->title;?></td>
				<td><?php echo substr(strip_tags($p->description),0,50)?>...</td>

			 <td width='30'>
						 <div class='btn-group'>
						   <a class="btn btn-success" href='<?php echo site_url('st/view_newsletters/'.$p->id);?>'><i class='fa fa-share'></i> View</a>
						   
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
</div>
</div>