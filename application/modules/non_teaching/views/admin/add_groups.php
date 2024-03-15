<section class="box ">
        <div class="panel panel-default"> 
        <header class="panel_header">
                                <h2 class="title pull-left"><?php echo   ($updType == 'edit') ? 'Edit ' : 'Add ';?>Non_teaching </h2>
                               <div class="actions panel_actions pull-right">
                                    <?php echo anchor( 'admin/non_teaching/create' , '<span><i class="fa fa-plus white"></i> Add Non_teaching</span>', 'class="btn btn-success" ');?> 
                        <?php echo anchor( 'admin/non_teaching' , '<span><i class="fa fa-list white"></i> All Non_teaching' .'</span>', 'class="btn btn-info"');?> 
                                </div>
                            </header>
							
          	                    
               <div class="panel-body" style="display: block;">    
                
              
                   <div class='clearfix'></div>

                <?php 
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo   form_open_multipart(current_url(), $attributes); 
                ?>
		
		
		
		<div class='form-group'>
		<label class=' col-sm-3 control-label' for='phone'>Phone <span class='required'>*</span></label>
		<div class="col-sm-5">
		
				<?php echo $result->phone ;?>
			
		</div>
		</div>
		
		
<div class='form-group'>
<label class='col-sm-3 control-label' for='member_groups'>Add to Group <span class='required'>*</span></label>
<div class="col-sm-5">
                <?php	
     echo form_dropdown('member_groups[]',$groups_list,'',' id="form-field-select-1" multiple="multiple" class="select2-multi-value form-control" data-style="btn-white" data-live-search="true"  placeholder="Member Groups"');
    ?> <i style="color:red"><?php echo form_error('member_groups'); ?></i>
</div></div>
		

<div class='form-group'><label class="col-sm-3 control-label"></label><div class="col-sm-5">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save Changes', (($updType == 'create') ? "id='submit' class=' btn btn-info''" : "id='submit' class='btn btn-info'")); ?>
	
	<?php echo anchor('admin/non_teaching','Cancel','class="btn btn-default btn-shadow"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
        </div> 
        </section>