<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2>  Classes per Subject </h2> 
                     <div class="right">                            
                       
              <?php echo anchor( 'admin/subjects/create/', '<i class="glyphicon glyphicon-plus"></i>'.lang('web_add_t', array(':name' => ' New Subject')), 'class="btn btn-primary"');?>
                <?php echo anchor( 'admin/subjects/' , '<i class="glyphicon glyphicon-list">
                </i> List All Subjects', 'class="btn btn-primary"');?>
			
                     </div>    					
                </div>
         	        <?php if ($posts): ?>              
               <div class="block-fluid">
			    <?php echo form_open('admin/subjects/bulk_delete', ' id="form"  class="form-horizontal"'); ?> 
			<table class="table table-striped table-bordered  " >
            <thead>

                <tr>

                    <th align="center"><input type="checkbox" class="checkall" /></th>

                    <th>Class Name</th>	
                    <th>Created on</th>
                    <th>Created By</th>
                    <th >  </th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($posts as $post): 
				$user=$this->ion_auth->get_user($post->created_by);
				$class = $this->ion_auth->list_classes();
				?>

                    <tr>

                        <td width="3"><?php echo form_checkbox('action_to[]', $post->id); ?></td>
                        <td><?php echo $class[$post->class_id]; ?></td>											
						<td><?php echo date('d/m/Y',$post->created_on); ?></td>
						<td><?php echo $user->first_name.' '.$user->last_name ?></td>
						
						
						<td width="20%">
					<div class="btn-group">
					<a class="btn btn-primary" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/subjects/trash/'.$post->id.'/'.$post->subject_id);?>'><i class="glyphicon glyphicon-trash"></i> Remove</a>
				</div>
			
				 
				</td>
				

                    </tr>

                <?php endforeach; ?>

            </tbody>

         

        </table>
       
        <div class="left">
<br>
<br>
            <button type="submit" name="btnAction" value="delete" class="btn btn-danger">Bulk Remove</button>

        </div>

        <?php echo form_close(); ?>    

  
	
	<?php else:?>
	
	No Classes at the moment !! <?php echo anchor('admin/subjects/create', '<i class="glyphicon glyphicon-plus-sign"></i> Add New classes', ' class="" '); ?>
<?php endif;?>
  </div><!--/span-->
