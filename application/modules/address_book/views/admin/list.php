
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2><?php echo $title; ?></h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/address_book/create/'.$page, '<i class="glyphicon glyphicon-plus"></i>'.lang('web_add_t', array(':name' => ' New Contact')), 'class="btn btn-primary"');?>
			    <?php echo anchor( 'admin/address_book/' , '<i class="glyphicon glyphicon-list">
                </i> List All Contacts', 'class="btn btn-primary"');?>
			   
                     </div>    					
                </div>
<div class="head dark">
			<div class="icon"><i class="icos-bookmark"></i></div>
			<h2>Contacts</h2>
			<ul class="buttons">                                                        
				<li><a href="#"><span class="icos-share"></span></a></li>
			</ul>                                                  
		</div> 
		<div class="toolbar">
			<div class="input-group">
				<input type="text" placeholder="Keyword..." style="width: 432px;">
				<button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search glyphicon glyphicon-white"></span></button>
			</div>                          
		</div>
				
 <?php if ($address_book): ?>

					 


<div class="widget">
 

                        <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                            <tbody >
							 <?php 
								   $i = 0;
											   
							foreach ($address_book as $p ): 
								 $i++;
								?>
                                <tr>
                                    <td width="100" align="center">
                                      <?php if($p->address_book=='supplier'):?>
									  <span class="icosg-user3"> </span> 
                                      <?php else:?>	
										<span class="icosg-user2"> </span> 
                                      <?php endif;?>									  
                                        <address>
                                            <strong><?php echo $p->title;?></strong><br>
                                            <a href="mailto:#"><?php echo $p->email;?></a>
                                        </address>
                                    </td>
                                    <td width="40%">
                                        <address>
                                            <strong>Contact Details.</strong><br>
                                            <?php echo $p->address;?><br> <?php echo $p->city;?> <?php echo $p->country;?><br>
                                            <?php echo $p->email;?><br>
                                            <abbr title="Phone">P:</abbr> <?php echo $p->phone;?><br>
                                            <abbr title="Phone">T:</abbr> <?php echo $p->landline;?><br>
											  <?php echo $p->website;?><br>
                                        </address>
                                    </td>
                                    <td width="30%">
                                       <?php echo $p->description;?>
                                    </td> 
									<td width="30%">
									    <?php if($p->address_book=='supplier'):?>
									  <span class="label label-success"><?php echo $p->address_book;?></span>
                                      <?php else:?>	
										 <span class="label label-warning"><?php echo $p->address_book;?></span>
                                      <?php endif;?>
                                       
                                       
                                    </td>
                                    <td width="20%">
									
                      <a href="<?php echo site_url('admin/sms/');?>"> 
	<button class="btn btn-primary tipl" title="" data-original-title="Send message"><span class="glyphicon glyphicon-envelope glyphicon glyphicon-white"></span> </button></a>
                                        <a href="<?php echo site_url('admin/address_book/edit/'.$p->id);?>"><button class="btn btn-primary tipl" title="" data-original-title="Edit"><span class="glyphicon glyphicon-pencil glyphicon glyphicon-white"></span></button></a>
                                        <a onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/address_book/delete/'.$p->id);?>'><button class="btn btn-primary tipl" title="" data-original-title="Remove"><span class="glyphicon glyphicon-remove glyphicon glyphicon-white"></span></button></a>
                                    </td>
                                </tr>
                               
						<?php endforeach ?>       
                                                        
                               
                            </tbody>
							
                        </table>
						
						
                </div>

		
	
           
<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>

