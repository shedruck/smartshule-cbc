<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            My Certificates 
			
			
        </h3>
       <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        <div class="clearfix"></div>
        <hr>
    </div>
         	                    
 <div class="card flex-fill ctm-border-radius shadow-sm grow">             
	 <?php if ($nx): ?>
		<div class="table-responsive">
	 <table id="datatable-buttons" class="table table-striped table-bordered">
	 <thead>
                <th>#</th>
			
				<th>Certificate Type</th>
				<th>Serial Number</th>
				<th>Mean Grade</th>
				<th>Points</th>
				<th>Certificate</th>	
				
		</thead>
		<tbody>
		<?php 
                             $i = 0;

  			 
           foreach($nx as $p){
								
							
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
			
				<td class="text-center"><?php echo $p->certificate_type;?></td>
				<td class="text-center"><?php echo $p->serial_number;?></td>
				<td class="text-center"><?php echo $p->mean_grade;?></td>
				<td class="text-center"><?php echo $p->points;?></td>
				<td class="text-center"><a target="_blank" href='<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>' /><i class=" fa fa-download"></i>  Download file (certificate)</a></td>

			
				</tr>
				
			<?php } ?>
		</tbody>

	</table>

	
</div>


<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 
          	                    
 <div class="card flex-fill ctm-border-radius shadow-sm grow">             
	 <?php if ($oc): ?>
	 
	  <hr>
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            Others Certificates 
			
			
        </h3>
		<p>&nbsp;</p>
<hr>       
       
    </div>
	
	
	
		<div class="table-responsive">
		<table class="table bordered" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Uploaded On</th>
				
				<th>Title</th>
				
				<th>Certificate No</th>
				<th>Certificate</th>
				<th>Description</th>
				
		</thead>
		<tbody>
		<?php 
					 $i = 0;
					 
	  foreach($oc as $p){

		 $i++;
			 ?>
	 <tr>
			<td class="text-center"><?php echo $i . '.'; ?></td>					
			<td class="text-center"><?php echo date('d M Y',$p->created_on);?></td>		
			<td class="text-center"><?php echo $p->title;?></td>
			<td class="text-center"><?php echo $p->certificate_number;?></td>
			<td class="text-center"><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' /> <i class=" fa fa-download"></i>  Download Cert</a></td>
			<td class="text-center" ><?php echo $p->description;?></td>

	 </tr>

			<?php } ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 
 </div>