<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
		General E-Videos
			
			
        </h3>
       <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        <div class="clearfix"></div>
      <hr>
    </div>
	
	
	<div class="blog-list-wrapper">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="p-20">

                                        <!-- Image Post -->
                                        <div class="blog-post m-b-30">
                                            <div class="post-image">

												   <iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php echo $post->video_embed_code?>?playlist=<?php echo $post->video_embed_code?>&loop=1">
                  </iframe>
				  
				 
                                                <span class="label label-danger"><?php echo $post->subject ?> </span>
                                            </div>
											
											
                                            <hr>
                                            <div class="text-muted">
											<span>by <a class="text-dark font-secondary">
												<?php $u=$this->ion_auth->get_user($post->created_by); echo $u->first_name.' '.$u->last_name;?>
											</a>,</span> 
											<span> <?php echo date('F d, Y',$post->created_on)?></span></div>
                                            <div class="post-title">
                                                <h4><a href="javascript:void(0);"><?php echo strtoupper($post->title);?></a></h4>
                                            </div>
                                            <div>
                                                

                                                <blockquote class="custom-blockquote margin-t-30">
                                                    <p>
                                                      <?php echo $post->description;?>
                                                    </p>
                                               
													<footer>
                                                        Subject <cite title="Source Title"><?php echo $post->subject;?></cite>
                                                    </footer>
													<footer>
                                                        Topic <cite title="Source Title"><?php echo $post->topic;?> </cite>
                                                    </footer>
													<footer>
                                                        Sub Topic <cite title="Source Title"><?php echo $post->subtopic;?> </cite>
                                                    </footer>
                                                </blockquote>

                                            </div>

                                        </div>

                                      

                                        <hr/>

                                          <div class="m-t-50 blog-post-comment">
                                            <h4 class="text-uppercase">Comments <small>(<?php echo count($comments )?>)</small></h4>
                                            <div class="border m-b-20"></div>

                                            <ul class="media-list">

                                             
                                           <?php foreach($comments as $c){ $u = $this->ion_auth->get_user($c->created_by);?>
                                                <li class="media">
                                                    <a class="pull-left" href="#">
                                                     <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img"   class="media-object img-circle">
                                                    </a>
                                                    <div class="media-body">
                                                        <h5 class="media-heading"><?php echo $u->first_name.' '.$u->last_name?></h5>
                                                        <h6 class="text-muted"><?php echo  date('F, d Y : H:i A',$c->created_on)?></h6>
                                                        <p><?php echo $c->comment;?></p>
                                                        <a href="#" class="text-success"><i
                                                                class="mdi mdi-reply"></i>&nbsp; Reply</a>


                                                      
                                                    </div>
                                                </li>
										   <?php } ?>

                                                <li class="media" id="now_response" style="display:none">
                                                    <a class="pull-left" href="#">
                                                       <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img"   class="media-object img-circle">
                                                    </a>
                                                    <div class="media-body">
                                                        <h5 class="media-heading"><?php echo $this->user->first_name . ' ' . $this->user->last_name ?></h5>
                                                        <h6 class="text-muted"><?php echo  date('F, d Y : H:i A')?></h6>
                                                        <p id="user_comment<?php echo $post->id;?>"></p>
                                                        <a href="#" class="text-success"><i
                                                                class="mdi mdi-reply"></i>&nbsp; Reply</a>
                                                    </div>
                                                </li>

                                            </ul>

                                            <h4 class="text-uppercase m-t-50">Leave a comment</h4>
                                            <div class="border m-b-20"></div>

                                           

                                                <div class="form-group">
                                                    <textarea class="form-control" id="comment_<?php echo $post->id;?>" name="message" rows="5" placeholder="Message" required=""></textarea>
                                                </div>
                                                <!-- /Form Msg -->

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="">
                                                            <button type="submit" class="btn btn-custom" id="submt_<?php echo $post->id;?>">Submit</button>
                                                        </div>
                                                    </div> <!-- /col -->
                                                </div> <!-- /row -->

                                          


                                        </div><!-- end m-t-50 -->

                                    </div> <!-- end p-20 -->
                                </div> <!-- end col -->
								     <div class="col-sm-4">
                                    <div class="p-20">

                                        <div class="">
                                            <h4 class="text-uppercase">Search Video</h4>
                                            <div class="border m-b-20"></div>
                                            <div class="form-group search-box">
                                                <input type="text" id="search-input" class="form-control" placeholder="Search here...">
                                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>

                                        <div class="m-t-50">
                                            <h4 class="text-uppercase">Related Topics</h4>
                                            <div class="border m-b-20"></div>
											<?php 
										$i = 0;

									foreach ($general as $p ): 
									$u=$this->ion_auth->get_user($p->created_by);
										 $i++;
											 ?>
                                            <div class="media latest-post-item">
                                                <div class="media-left">
                                                    <a href="<?php echo base_url('st/watch_general/'.$this->session->userdata['session_id'].'&'.$p->id)?>"> <img class="media-object" alt="64x64" src="<?php echo $p->preview_link;?>" style="width: 100px; height: 66px;"> </a>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="media-heading"><a href="<?php echo base_url('st/watch_general/'.$this->session->userdata['session_id'].'/'.$p->id)?>"><?php echo strtoupper($p->title);?></a> </h5>
                                                    <p class="font-13 text-muted">
                                                        <?php echo date('F d, Y',$p->created_on)?> | <?php echo $u->first_name.' '.$u->last_name;?>
                                                    </p>
                                                </div>
                                            </div>
                                    <?php endforeach ?>
                                           

                                        </div>



                                    </div>
                                </div> <!-- end col -->
                            
								
					</div>
		</div>
		</div>
	
	
</div> <script>
			$(document).ready(function ()
			{
					
                  //******   POST THE COMMENT ON REPLIES ******//
				  
					$("#submt_<?php echo $post->id;?>").click(function () {	
															
						    var id = <?php echo $post->id;?>;
						    var comment = $('#comment_<?php echo $post->id;?>').val();
							
							var dataString = '&comment='+ comment + '&id='+ id + '&type=2';
							
							if(comment==''||id=='')
							{
							   alert("Atleast write something before submitting !");
							}
							else
							{ 
						//alert(comment);
								// AJAX Code To Submit Form.
								$.ajax({
								type: "POST",
								url: "<?php echo base_url('st/post_comment');?>",
								data: dataString,
								cache: false,
								success: function(result){
								
							     
                                    document.getElementById("user_comment<?php echo $post->id;?>").innerHTML += "<span>"+comment+"</span>"; 
			                        document.getElementById('comment_<?php echo $post->id;?>').value = ''
									
									 $('#now_response').show('fast');
							      

									}
								}); 
									
							}
															
														
						});
			})
						

				</script>
