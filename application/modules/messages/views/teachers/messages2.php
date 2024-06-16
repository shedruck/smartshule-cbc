<main id="main">

  
    <div id="main-nano-wrapper" class="nano card-box table-responsive">
	
	      <h3 class="page-title">Messages & Feedback
        <a class="btn btn-custom pull-right" href="<?php echo base_url('trs/new_message'); ?>"> 
            <i class="glyphicon glyphicon-plus"></i>
            New Message
        </a></h3>
			
		<hr>
        <div class="nanco-content">  
            <table id="datatable-buttons" class="table table-striped table-bordered">
			 <thead  class="active">
					
					<th>#</th>
					<th>Tile</th>
					<th>Sent To</th>
					<th>Date</th>
					<th>Action</th>
				</thead>
				<tbody>
				   <?php
						$i = 0;
						foreach ($messages as $m)
						{
								$i++;
								$get = $m->seen ? '' : '/?st=' . rand(10, 3000);
								?>
							<tr>
								 <td>
								  <?php echo $i; ?>.
									  
								 </td>
								 <td>
								   <a href="<?php echo base_url('trs/view_message/' . $m->id . $get); ?>">
											<p class="title"><?php echo $m->seen ? $m->title : '<strong>' . $m->title . '</strong>'; ?></p>
										</a>
								 </td>
								 <td><?php echo $m->to; ?></td>
								 <td><?php echo date('d-m-Y h:i A', $m->last); ?></td>
								 <td>
								   <a class="btn btn-info pull-right"  href="<?php echo base_url('trs/view_message/' . $m->id . $get); ?>"> View Responses</a>
								 </td>
							</tr>
						  <?php } ?>    
				</tbody>
			</table>

		
         
        </div>
    </div>
</main>  

<style>
    .form-group {
        margin-bottom: 15px;
    }
</style>