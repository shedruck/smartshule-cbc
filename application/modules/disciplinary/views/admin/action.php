
  <div class="col-md-8">
  <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Disciplinary </h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/disciplinary/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => ' New Disciplinary')), 'class="btn btn-primary"');?>
                <?php echo anchor( 'admin/disciplinary/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
			
                     </div>    					
                </div>
         	                   
               <div class="block-fluid"> 

				<?php 
				$attributes = array('class' => 'form-horizontal', 'id' => '');
				echo   form_open_multipart(current_url(), $attributes); 
				?>
				<div class='form-group'>
					<div class="col-md-2" for='date_reported'><b>Date Reported </b></div>
					<div  class="col-md-10">
					<?php echo date('d/m/Y',$result->date_reported); ?>
				</div>
				</div>

				<div class='form-group'>
					<div class="col-md-2" for='culprit'><b>Culprit </b></div>
				<div class="col-md-10">
					<?php  $user=$this->ion_auth->students_full_details(); echo $user[$result->culprit]; ?>
				</div>
				</div>
              <div class='form-group'>
			  <div class="col-md-2" for='reported_by'><b>Reported By </b></div>
				
				<div class="col-md-10" id='<?php if(!empty($result->reported_by)){ echo 'member';} else {echo 'bymember';} ?>'>
						<?php $user=$this->ion_auth->get_user($result->reported_by);
							 echo $user->first_name.' '.$user->last_name; ?>
						</div>
						
				<div class="col-md-10" id='<?php if(!empty($result->others)){ echo 'member';} else {echo 'by-others';} ?>'>
					<?php echo $result->others;?>
					
					</div>
				
                 </div>	
				<div class='form-group'>
					<div class="col-md-2" for='culprit'><b>Description </b></div>
				<div class="col-md-10">
					<?php echo $result->description; ?>
				</div>
				</div>

	
  
				<div class='form-group'>
					<div class="col-md-2" for='action_taken'>Action Taken </div><div class="col-md-10">
					<?php echo form_input('action_taken' ,$result->action_taken , 'id="action_taken_"  class="form-control" required="required"' );?>
					<?php echo form_error('action_taken'); ?>
				</div>
				</div>
				<div class="widget">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Comment</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea class="wysiwyg"  name="comment" style="height: 300px;">
                          <?php echo set_value('comment', (isset($result->comment)) ? htmlspecialchars_decode($result->comment) : ''); ?></textarea>
	<?php echo form_error('comment'); ?>
                        
                    </div>
                   
                </div> 
				


<div class='form-group'><div class="control-div"></div>
<div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/disciplinary','Cancel','class="btn btn-danger"');?>
</div>
</div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
        </div>
    </div>
	
	<script>



$(document).ready(function(){
$('#bymember').hide();
$('#by-others').hide();


$('#member').click(function(){
	  $('#bymember').show();
	  $('#by-others').hide();
	});
$('#others').click(function(){
	  $('#bymember').hide();
	  $('#by-others').show();
	});
});
	
</script>	