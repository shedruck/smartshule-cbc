<div class="middle">
            
                <div class="button tip" title="New mail">
                    <a href="#" id="openMailModal">
                        <span class="icomg-mail"></span>
                        <span class="text">New mail</span>
                    </a>                    
                </div>            

                <div class="button tip" title="Inbox">
                    <a href="#">
                        <span class="icomg-box-add"></span>
                        <span class="text">Inbox<br/>0</span>                        
                    </a>                    
                </div>            

                <div class="button tip" title="Outbox">
                    <a href="#">
                        <span class="icomg-box-remove"></span>
                        <span class="text">Sent<br/>0</span>
                    </a>                    
                </div>                        

                <div class="button tip" title="Removed">
                    <a href="#">
                        <span class="icomg-remove"></span>
                        <span class="text">Trash<br/>0</span>
                    </a>                    
                </div>                                     
            
        </div>

    <div class="dialog-fluid" id="sendMailModal" style="display: none;" title="Send mail">
					<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
        <div class="row">            
          
			<?php 
					  $user=$this->ion_auth->get_user_details();
					  $parent=$this->ion_auth->get_parent_details();
					  $items=array(
												''=>'Send To:',
												'All Parents'=>'All Parents',
												'All Teachers'=>'All Teachers',
												'All Staff'=>'All Staff',
												'Staff'=>'Staff',
												'Parent'=>'Parent',
												); ?>
            <div class="block-fluid">
                <div class="form-group">
                    <div class="col-md-12">
                       
                        <?php echo form_dropdown('send_to',$items,$emails_m->send_to,' data-placeholder="Send To:" onchange="show_field(this.value)" id="send_to" class="chosen col-md-4"  tabindex="4"'); ?>
						 <b class='btn btn-default cc'>Cc</b>
						
                    </div>
                </div>
				
                  
                <div class="form-group" id="rc_staff">
                    <div class="col-md-12">
                        <span class="top title"></span>
                        <?php	
							echo form_dropdown('staff', array(''=>'Select Staff')+$user,  (isset($emails_m->staff)) ? $emails_m->staff : '' ,' class="select populate col-md-4"  ');
							echo form_error('staff'); 
					     ?>
                    </div>
                </div> 
				
				<div class="form-group" id="rc_parent">
                    <div class="col-md-12">
                        <span class="top title"></span>
                       <?php	
						echo form_dropdown('parent', array(''=>'Select Parent')+(array)$parent,  (isset($emails_m->parent)) ? $emails_m->parent : ''     ,   ' class="select populate col-md-4" ');
							 echo form_error('parent'); 
						?>
                    </div>
                </div> 
				
				<div class="form-group" id="cc" style="display:none">
                    <div class="col-md-12">
                        
                       <?php echo form_input('cc' ,$emails_m->cc , 'id="cc" placeholder="cc" class="col-md-4" id="focusedinput" ' );?>
						<?php echo form_error('cc'); ?>
                    </div>
                </div>
				<div class="form-group" id="Bcc" style="display:none">
                    <div class="col-md-12">
                        
                       <?php echo form_input('cc' ,$emails_m->cc , 'id="Bcc" placeholder="Bcc" class="col-md-4" id="focusedinput" ' );?>
						<?php echo form_error('cc'); ?>
                    </div>
                </div>
				<div class="form-group">
                    <div class="col-md-12">
                       
                      <?php echo form_input('subject' ,$emails_m->subject , 'id="subject_" placeholder="Subject" class="col-md-12" id="focusedinput" ' );?>
						<?php echo form_error('subject'); ?>
                    </div>
                </div>
               
            </div>
			
            <textarea name="description" id="wysiwyg" style="min-height: 200px;">
				
				<?php 
				$user=$this->ion_auth->get_user();
				echo $user->first_name.' '.$user->last_name.'<br>'.$user->phone;
				?>
				
			</textarea>  
			
			 <div class="form-group">
                    <div class="col-md-12">
                       
                        <div class="input-group file left">
						
						<span style="display:none">
							<?php	
							$items=array('draft'=>'draft');
							echo form_dropdown('status', array(''=>'Save as')+(array)$items,  (isset($emails_m->status)) ? $emails_m->status : ''     ,   ' class="col-md-8" ');
								 echo form_error('status'); 
							?>
						</span>
						
					   <input type="file" name="attachment"/>
					   <span class="btn"><i class="icosg-attachment"></i> File</span>
                       
                        </div>
                    </div>
                </div>   
        </div> 
  <div class="toolbar inside">
                <div class="left">
				 <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Send mail', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/emails','Cancel','class="btn btn-danger"');?>
                   
                </div>
                
            </div>	
<?php echo form_close(); ?>	
    </div> 



        
        <div class="row">
                        
            <div class="col-md-9">
                
                <div class="widget">                    
                    <div class="head dark">
                        <div class="icon"><span class="icos-box-add"></span></div>
                        <h2>Inbox</h2>
                    </div>                                                 
                    <div class="toolbar">
                        <div class="left">
                            <div class="btn-group">
                                <button class="btn btn-small btn-primary tip" title="Forward"><span class="glyphicon glyphicon-share-alt glyphicon glyphicon-white"></span></button>
                                <button class="btn btn-small btn-primary tip" title="Reply"><span class="glyphicon glyphicon-arrow-right glyphicon glyphicon-white"></span></button>
                                <button class="btn btn-small btn-warning tip" title="Spam"><span class="glyphicon glyphicon-warning-sign glyphicon glyphicon-white"></span></button>
                            </div> 
                            <button class="btn btn-small btn-danger tip" title="Remove"><span class="glyphicon glyphicon-trash glyphicon glyphicon-white"></span></button>
                            
                            <div class="btn-group">                                
                                <button class="btn btn-small dropdown-toggle" data-toggle="dropdown">More <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Forward all</a></li>
                                    <li><a href="#">Reply to all</a></li>                                    
                                    <li class="divider"></li>
                                    <li><a href="#">Mask as unread</a></li>
                                    <li><a href="#">Mask as read</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="right TAR">
                            <button class="btn btn-small"><span class="glyphicon glyphicon-book"></span> Contacts</button>
                        </div>
                    </div>
                    <div class="block-fluid">
                          <?php if ($emails): ?>
						  
                        <table class="table-hover mailbox" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="checkall"/></th>
                                    <th width="30%">From</th>
                                    <th width="40%">Description</th>
                                    <th width="15%">Date</th>
                                    <th width="15%">Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php $i=1; foreach ($emails as $emails_m): $user=$this->ion_auth->get_user($emails_m->created_by)?>
                                <tr class="new">
                                    <td><input type="checkbox" name="checkbox"/></td>
                                    <td>
							<img src="<?php echo base_url('assets/themes/admin/img/examples/users/alexey_m.jpg');?>" class="img-polaroid" align="left"/> 
							<a href="#" class="name"><?php echo $user->first_name.' '.$user->last_name;?></a> <a href="#"><?php echo $user->email;?></a>
							</td>
                                    <td><?php echo '<b style="text-decoration:underline">REF: '.$emails_m->subject.'</b><br> '.substr($emails_m->description,0,70).'...';?></td>
                                    <td><?php echo time_ago($emails_m->created_on);?></td>
                                    <td><?php if(!empty($emails_m->attachment)):?>
									<a href='<?php echo base_url();?>uploads/files/<?php echo $emails_m->attachment?>' />Download File</a>
									<?php else:?>.....
									<?php endif?>
									</td>
                                </tr>
                              <?php $i++; endforeach ?>                                                                       
                            </tbody>
                        </table>
						 <div class="toolbar bottom">
                       
                        <div class="right">
                            <div class="pagination pagination-right pagination-mini">
                                <?php echo $links; ?>
								
                            </div><br>
								                              
                        </div>
                        
                    </div>
                    </div>
                   
					
					
                </div>
                
            </div>
            <div class="col-md-3">     
                                
                <div class="widget">
                    <div class="wrapper">
                        <div class="input-group input-prepend">                            
                            <input type="text" placeholder="Find your mail..."/>
                            <button class="btn btn-primary" type="button">Search</button>                            
                        </div>             
                    </div>
                </div>
                
                <div class="datepicker"></div>
            </div>
			<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?> 
            
        </div>        
        




<script>
	function show_field(item){
		//hide all
		
		//document.getElementById('cc').style.display='none';
		document.getElementById('rc_staff').style.display='none';
		document.getElementById('rc_parent').style.display='none';
		
		$('.cc').click(function(){
			$('#cc').show();
		});
		$('#Bcc').click(function(){
			$('#Bcc').show();
		});
		
		if(item=='Staff') document.getElementById('rc_staff').style.display='block';
		if(item=='Parent') document.getElementById('rc_parent').style.display='block';
		
		return ;
			
	}
	<?php if($this->uri->segment(3)=='create'){ ?>
	show_field('None');
	<?php } ?>
</script>