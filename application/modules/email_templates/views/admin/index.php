<div class="head">                    <div class="icon"><span class="icosg-target1"></span></div>                    <h2>  Email Templates  </h2>                      <div class="right">                                                                 <?php echo anchor( 'admin/email_templates/create/', '<i class="glyphicon glyphicon-plus">                </i>'.lang('web_add_t', array(':name' => ' New Template')), 'class="btn btn-primary"');?>                <?php echo anchor( 'admin/email_templates/' , '<i class="glyphicon glyphicon-list">                </i> List All Templates', 'class="btn btn-primary"');?>			                     </div>    					                </div>         	        <?php if ($posts): ?>                             <div class="block-fluid">			    <?php echo form_open('admin/email_templates/action', ' id="form"  class="form-horizontal"'); ?> 				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <td align="center"><input type="checkbox" class="checkall" /></td>
                    <th>Title</th>											
                    <th>Slug</th>                    <th>Status</th>                    <th>Created By</th>
                    <th><span>Description</span></th>                    <th >  </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): $user=$this->ion_auth->get_user($post->created_by);?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $post->id); ?></td>
                        <td><?php echo $post->title ?></td>																	<td><?php echo $post->slug ?></td>						<td><?php echo $post->status ?></td>						<td><?php echo $user->first_name.' '.$user->last_name ?></td>						<td><?php echo substr($post->description,0,100) ?></td>						<td width="20%">					<div class="btn-group">					<button class="btn dropdown-toggle" data-toggle="dropdown">Action <i class="glyphicon glyphicon-caret-down"></i></button>					<ul class="dropdown-menu pull-right">					     <li><a href="<?php echo site_url('admin/email_templates/edit/'.$post->id.'/');?>"><i class="glyphicon glyphicon-eye-open"></i> View</a></li>                        <li><a href="<?php echo site_url('admin/email_templates/edit/'.$post->id.'/');?>"><i class="glyphicon glyphicon-edit"></i> Edit</a></li>                                              <li><a onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/email_templates/delete/'.$post->id.'/');?>'><i class="glyphicon glyphicon-trash"></i> Trash</a></li>					</ul>				</div>							 				</td>				
                    </tr>
                <?php endforeach; ?>
            </tbody>
         
        </table>       
        <div class="left"><br><br>
            <button type="submit" name="btnAction" value="delete" class="btn btn-danger">Delete</button>
            <button type="submit" name="btnAction" value="publish" class="btn btn-warning">Publish</button>

        </div>
        <?php echo form_close(); ?>    
  		<?php else:?>		No Email templates at the moment !! <?php echo anchor('admin/email_templates/create', '<i class="glyphicon glyphicon-plus-sign"></i> Create New Template', ' class="" '); ?><?php endif;?>
  </div><!--/span-->
