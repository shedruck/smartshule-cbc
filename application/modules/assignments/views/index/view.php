

<div class="card flex-fill ctm-border-radius shadow-sm grow">

		<div class="card-header">
		<b>TITLE:</b>  <?php echo strtoupper($p->title); ?>
			
		</div>


     <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-5">
	<div class="table-responsive">
											   <table class="table mb-0 thead-border-top-0 table-nowrap">
		
            <tr>  
			   <td>Start Date:</td>
			   <td><?php echo $p->start_date > 10000 ? date('d M Y', $p->start_date) : ' - '; ?></td>
			</tr>
            <tr> 
				<td>Due Date:</td>
				<td><?php echo $p->end_date > 10000 ? date('d M Y', $p->end_date) : ' - '; ?></td>
			</tr>
            <tr> 
				<td>Class:</td>
				<td><?php
					$class_id = $this->assignments_m->get_classes($p->id);
					$class = $this->ion_auth->classes_and_stream();
					$i = 0;
					foreach ($class_id as $c)
					{
							$i++;
							echo  $class[$c->class] . '<br>';
					}
					?>
					</td>
			</tr>
           
			
        </table>
	</div>
	</div>
    <div class="col-md-5">
       <div class="table-responsive">
											   <table class="table mb-0 thead-border-top-0 table-nowrap">

            <tr>
			<td>
			<span>Given By:</td><td><?php
                $u = $this->ion_auth->get_user($p->created_by);
                echo $u->first_name . ' ' . $u->last_name;
                ?> </td>
			</tr>
			<tr> 
				<td>Attachment:</td>
				<td>
					 <?php
						if (!empty($p->document))
						{
								?>
						<a target="_blank" href="<?php echo base_url('uploads/files/' . $p->document); ?>" class="btn btn-sm btn-outline-primary">
								<span class="fa fa-download"></span> Download </a>
						<?php
						}
						else
						{
								?>
								<b >No Attachment</b>
						<?php } ?>
				</td>
			</tr>
			
			 <tr> 
				<td>Remarks/Comment:</td>
				<td> <?php echo empty($p->comment) ? ' --' : $p->comment; ?> </td>
			</tr>
			
        </table>
	</div><!-- End .col-md-6 -->
	</div><!-- End .col-md-6 -->
 <div class="col-md-1"></div>
		<div class="col-md-12">
			
		<div class="card-header">
			<?php echo strtoupper('Assignment Description / Details'); ?> <br>
		</div>
		<div class="col-md-8">		
		    <?php echo $p->assignment; ?>
			<br>
			 <br>
			 <br>
		 </div>
		 
		</div> 
 


 </div>

</div>

