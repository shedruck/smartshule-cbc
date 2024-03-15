
<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b>   Students Projects   </b>
        </h3>
		<div class="pull-right">
		 
		  <?php echo anchor( 'students_projects/trs' , '<i class="fa fa-list">
                </i> '.lang('web_list_all', array(':name' => 'Students Projects')), 'class="btn btn-primary"');?>
				
<a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>				
      </div>
        <div class="clearfix"></div>
        <hr>
    </div>

  <div class="block-fluid row">


<div class='col-md-6' style="border-right:2px solid #ccc; border-left:2px solid #ccc">
<div class='row'>
	<div class="col-md-3" for='strong'><b>Class/Level</b> </div><div class="col-md-6">
	<?php 
	    $classes = $this->portal_m->get_class_options();
		echo $classes[$result->level]
		?>
 	
</div>
</div>
<hr>


<div class='row'>
	<div class="col-md-3" for='student'><b>Student</b>  </div><div class="col-md-6">
	
										<option value="">Search Student</option>
										<?php
										$data = $this->ion_auth->students_full_details();
									echo $data[$result->student]; ?>

</div>
</div>
<hr>

<div class='row'>
	<div class="col-md-3 " for='day'><b> Year  </b>  </div><div class="col-md-6">
	<?php 

	 echo $result->year ?>
</div>
</div>
<hr>

<div class='row'>
	<div class="col-md-3 " for='day'><b>Term  </b> </div><div class="col-md-6">
	<?php 
	
	 echo $result->term;
	
	?>
 
</div>
</div>
<hr>

<div class='row'>
	<div class="col-md-3" for='subject'><b>Subject/Learning Area </b> </div><div class="col-md-6">
	<?php 
	    $sub = $this->portal_m->get_subject($result->level);
		echo strtoupper($sub[$result->subject]);
	 ?>
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-3" for='strand'><b>Strand </b> </div><div class="col-md-6">
	<?php echo $result->strand?>
 
</div>
</div>
<hr>

<div class='row'>
	<div class="col-md-3 control-label" for='topic'><b>Remarks</b> </div><div class="col-md-6">
	<?php echo isset($result->remarks) ? htmlspecialchars_decode($result->remarks) : ''; ?>

</div>
</div>

<hr>
</div>
<div class='col-md-6' >
<center>
<img src='<?php echo base_url()?><?php echo $result->file_path?>/<?php echo $result->file_name?>' class="img" />
</center>
</div>

 </div>
            </div>
			
						
						