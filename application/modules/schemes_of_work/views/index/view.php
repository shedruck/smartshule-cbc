
<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b>   Schemes of Work    </b>
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
	<div class="col-md-4  " for='day'>Year  </div><div class="col-md-8">
	<?php 

	 echo $result->year;
	
	?>
 
</div><hr>
</div>



<div class='row'>
	<div class="col-md-4  " for='day'>Term  </div><div class="col-md-8">
	<?php 
	echo $result->term
	?>
 	
</div><hr>
</div>


<div class='row'>
	<div class="col-md-4 " for='class'>Class/Level </div><div class="col-md-8">
	<?php 
	    $classes = $this->portal_m->get_class_options();
		echo $classes[$result->level];
		?>
 	
</div>
<hr>
</div>

<div class='row'>
	<div class="col-md-4 " for='week'>Week </div><div class="col-md-8">
		<?php echo $result->week  ?>
 	
</div>
<hr>
</div>

<div class='row'>
	<div class="col-md-4 " for='subject'>Subject/Learning Area </div><div class="col-md-8">
	<?php 
	$sub = $this->portal_m->get_subject($result->level);
	echo strtoupper($sub[$result->subject]);
		
	 ?>
</div><hr>
</div>


<div class='row'>
	<div class="col-md-4 " for='strand'>Strand </div><div class="col-md-8">
	<?php echo $result->strand;?>
 
</div><hr>
</div>

<div class='row'>
	<div class="col-md-4   " for='substrand'>Sub-strand </div><div class="col-md-8">
	<?php echo $result->substrand ;?>
 	
</div><hr>
</div>


<div class='row'>
	<div class="col-md-4  " for='topic'>Lesson</div><div class="col-md-8">
	<?php echo isset($result->lesson) ? htmlspecialchars_decode($result->lesson) : ''; ?>
	
	
</div>
</div>
<hr>

<div class='row'>
	<div class="col-md-4" for='topic'>Specific Learning Outcomes</div><div class="col-md-8">
	<?php echo isset($result->specific_learning_outcomes) ? htmlspecialchars_decode($result->specific_learning_outcomes) : ''; ?>

</div>
</div><hr>

<div class='row'>
	<div class="col-md-4" for='topic'>Key Inquiry Question</div><div class="col-md-8">
	 <?php echo isset($result->key_inquiry_question) ? htmlspecialchars_decode($result->key_inquiry_question) : ''; ?>

</div>
</div>

<hr>
<div class='row'>
	<div class="col-md-4" for='topic'>Learning Experiences</div><div class="col-md-8">
	<?php echo isset($result->learning_experiences) ? htmlspecialchars_decode($result->learning_experiences) : ''; ?>
	
	
</div>
</div>
<hr>
<div class='row'>
	<div class="col-md-4" for='topic'>Learning Resources</div><div class="col-md-8">
	 <?php echo isset($result->learning_resources) ? htmlspecialchars_decode($result->learning_resources) : ''; ?>
	
</div>
</div><hr>

<div class='row'>
	<div class="col-md-4" for='topic'>Assessment</div><div class="col-md-8">
	<?php echo isset($result->assessment) ? htmlspecialchars_decode($result->assessment) : ''; ?>
	
</div>
</div>
<hr>

<div class='row'>
	<div class="col-md-4" for='topic'>Reflection</div><div class="col-md-8">
	 <?php echo isset($result->reflection) ? htmlspecialchars_decode($result->reflection) : ''; ?>

</div>
</div>


 </div>
            </div>
			
			
						
						