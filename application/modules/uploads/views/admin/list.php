 <!-----------------------------ADD MODAL------------------------->
<div class="modal fade" id="bal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			<form action="<?php echo base_url('admin/uploads/upload_names');?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Upload Students</h4>
				<div class="clearfix"></div>
			</div>
		

			<div class='form-group'>
				<div class='col-md-1 ' for='survey_date'> 
				</div>
				<label class='col-md-9 control-label' for='survey_date'> 
				Choose CSV File <br>
				Click <a href="<?php echo base_url('uploads/Sample_Students_Upload_File.xlsx')?>">HERE</a> to download Sample file
				<span class='error'>*</span>
				</label>
				<div class="col-md-12">
				 <hr class="col-md-11">
			
				 <div class="col-md-8">
				 <hr>
						<?php

						$classes = $this->ion_auth->fetch_classes();
						echo form_dropdown('class',array(''=>'Select Class')+ $classes, (isset($result->class)) ? $result->class : '', ' class="select" data-placeholder="Select  Options..." ');

						?>
					<hr>		
				</div>
							
							 
							
							 <div class="col-md-8">
							 <hr>
							 Choose the CSV File to upload
				 <input name="csv" type="file" id="csv" /> <br>
				 </div>
				
			</div>
			</div> 

<div class="modal-footer">

				<button type="submit" class="btn btn-primary">
					Save Changes
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">
					Close
				</button>
				</div>
			</form> 
			</div>
			</div>
			</div>
			
			<div class="modal fade" id="Upload_paro" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog7">
			<form action="<?php echo base_url('admin/uploads/upload_pp');?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Upload Parents</h4>
				<div class="clearfix"></div>
			</div>
		

			<div class='form-group'>
				<div class='col-md-1 ' for='survey_date'> 
				</div>
				<label class='col-md-9 control-label' for='survey_date'> 
				Choose CSV File <br>
				Click <a href="#">here</a> to download Sample file
				<span class='error'>*</span>
				</label>
				<div class="col-md-12">
				 <input name="csv" type="file" id="csv" /> <br>
			</div>
			</div>
			
<div class="modal-footer">
				<button type="submit" class="btn btn-primary">
					Save Changes
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">
					Close
				</button>
				</div>
			</form> 
			</div>
			</div>
			</div>


<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Uploads  </h2>
             <div class="right">  
      
				
             <a data-toggle="modal" style='' class="btn btn-success" role="button" href="#bal">
				<i class='glyphicon glyphicon-share'></i> Upload Students
			  </a>
			  <a data-toggle="modal" style='' class="btn btn-danger" role="button" href="#Upload_paro">
				<i class='glyphicon glyphicon-share'></i> Upload Parents
			  </a>
			  
			  <a data-toggle="modal" style='' class="btn btn-info" role="button" href="#Upload_teaching">
				<i class='glyphicon glyphicon-share'></i> Upload Teaching
			  </a>
			  
			  <a data-toggle="modal" style='' class="btn btn-warning" role="button" href="#Upload_non_teaching">
				<i class='glyphicon glyphicon-share'></i> Upload Non Teaching
			  </a>

			  <a data-toggle="modal" style='' class="btn btn-primary" role="button" href="#Upload_support_staff">
				<i class='glyphicon glyphicon-share'></i> Upload Support Staff
			  </a>
                </div>
                </div>
				
	
				
	<div class="modal fade" id="Upload_teaching" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog">
	    <form action="<?php echo base_url('admin/uploads/upload_teaching');?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Upload Teaching Staff</h4>
				<div class="clearfix"></div>
			</div>
		

			<div class='form-group'>
				<div class='col-md-1 ' for='survey_date'> 
				</div>
				<label class='col-md-9 control-label' for='survey_date'> 
				Choose CSV File <br>
				Click <a href="#">here</a> to download Sample file
				<span class='error'>*</span>
				</label>
				<div class="col-md-12">
				 <input name="csv" type="file" id="csv" /> <br>
			</div>
			</div>
			
           <div class="modal-footer">
				<button type="submit" class="btn btn-primary">
					Save Changes
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">
					Close
				</button>
				</div>
			</form> 
			</div>
			</div>
			</div>
			
			
			<div class="modal fade" id="Upload_non_teaching" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog">
	    <form action="<?php echo base_url('admin/uploads/upload_non_teaching');?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
 
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Upload Non Teaching Staff</h4>
				<div class="clearfix"></div>
			</div>
		

			<div class='form-group'>
				<div class='col-md-1 ' for='survey_date'> 
				</div>
				<label class='col-md-9 control-label' for='survey_date'> 
				Choose CSV File <br>
				Click <a href="#">here</a> to download Sample file
				<span class='error'>*</span>
				</label>
				<div class="col-md-12">
				 <input name="csv" type="file" id="csv" /> <br>
			</div>
			</div>
			
           <div class="modal-footer">
				<button type="submit" class="btn btn-primary">
					Save Changes
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">
					Close
				</button>
				</div>
			</form> 
			</div>
			</div>
			</div>
