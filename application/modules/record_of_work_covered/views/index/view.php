<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b>  Record Of Work Covered    </b>
        </h3>
		<div class="pull-right">
		 
		 <button onClick="window.print();
                          return false" class="btn btn-primary " type="button"><span class="fa fa-print"></span> Print Receipt </button>
				
<a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>				
      </div>
        <div class="clearfix"></div>
        <hr>
    </div>

         	                    
               
				   <div class="block-fluid">


<div class='row'>
	<div class="col-md-3  control-label " for='day'>Year   </div><div class="col-md-6">
	<?php 

	 echo $result->year
	
	?>

</div>
</div>
<hr>


<div class='row'>
	<div class="col-md-3  control-label " for='day'>Term   </div><div class="col-md-6">
	<?php 
	
	 echo $result->term
	
	?>
 
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-3  control-label" for='class'>Class/Level </div><div class="col-md-6">
	<?php 
	    $classes = $this->portal_m->get_class_options();
		echo $classes[$result->level];
		
		?>
 	
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-3  control-label" for='week'>Week </div><div class="col-md-6">
		<?php echo $result->week  ?>
 	
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-3  control-label" for='subject'>Subject/Learning Area </div><div class="col-md-6">
	<td><?php $sub = $this->portal_m->get_subject($result->level); echo strtoupper($sub[$result->subject]);?></td>
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-3  control-label" for='date'>Date </div><div class="col-md-6">
	<?php echo isset($result->date) ? date('d M Y',$result->date) : ''; ?>
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-3  control-label" for='strand'>Strand </div><div class="col-md-6">
	<?php echo $result->strand ;?>
 	
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-3  control-label" for='substrand'>Sub-strand </div><div class="col-md-6">
	<?php echo $result->substrand ; ?>
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-3 control-label" for='topic'>Work Covered</div><div class="col-md-6">
	<?php echo isset($result->work_covered) ? htmlspecialchars_decode($result->work_covered) : ''; ?>
	
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-3 control-label" for='topic'>Reflection </div><div class="col-md-6">
	 <?php echo isset($result->reflection) ? htmlspecialchars_decode($result->reflection) : ''; ?>
</div>
</div>

 </div>
            </div>
			
		