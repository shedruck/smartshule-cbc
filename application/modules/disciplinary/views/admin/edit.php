
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
					<div class="col-md-2" for='date_reported'>Date Reported </div>
					<div id="datepicker" class="col-md-10 input-group date form_datetime">
					<input id='date_reported' type='text' name='date_reported' maxlength=''  class='form-control datepicker' value="<?php 
					if(!empty($result->date_reported)) {echo date('d/m/Y',$result->date_reported);}
					else {echo set_value('date_reported', (isset($result->date_reported)) ? $result->date_reported : '');} ?>"  />
					
					 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
					 <?php echo form_error('date_reported'); ?>
				</div>
				</div>

				<div class='form-group'>
					<div class="col-md-2" for='culprit'>Culprit </div>
				<div class="col-md-10">
					<?php $items = $this->ion_auth->students_full_details();
					 echo form_dropdown('culprit', array(''=>'Select Culprit')+(array)$items,  (isset($result->culprit)) ? $result->culprit : ''     ,   ' class="select" data-placeholder="Select Options..." ');
					 echo form_error('culprit'); ?>
				</div>
				</div>
              <div class='form-group'>
			  <div class="col-md-2" for='reported_by'>Reported By </div>
				
				 <div class="col-md-10"> 
				 Member <input type="radio"  id="member" name="reporter" /> 
				 
				  Others <input type="radio"  name="reporter" id="others"/>
                 
                 </div>	
				
                 </div>	
				

				 <div class='form-group' id='<?php if(!empty($result->reported_by)){ echo 'member';} else {echo 'bymember';} ?>'>
					  <div class="col-md-2" for='reported_by'></div>
						<div class="col-md-10">
						<?php $items = $this->ion_auth->get_user_list();
							 echo form_dropdown('reported_by', array(''=>'Select Member')+(array)$items,  (isset($result->reported_by)) ? $result->reported_by : ''     ,   ' class="select"');
							 echo form_error('reported_by'); ?>
						</div>
				</div>

				<div class='form-group' id='<?php if(!empty($result->others)){ echo 'member';} else {echo 'by-others';} ?>'>
					<div class="col-md-2" for='others'></div>
					<div class="col-md-10">
					<?php echo form_input('others' ,$result->others , 'id="others_"  class="form-control" placeholder="Specify"' );?>
					<?php echo form_error('others'); ?>
					</div>
				</div>
		
<div class="widget">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea id="wysiwyg"  name="description" style="height: 300px;">
                          <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
                        
                    </div>
                   
                </div> 
  
				<div class='form-group'>
					<div class="col-md-2" for='action_taken'>Action Taken </div><div class="col-md-10">
					<?php echo form_input('action_taken' ,$result->action_taken , 'id="action_taken_"  class="form-control" ' );?>
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