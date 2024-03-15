<div class="encl">
 <a class="btn btn-primary pull-right btn-custom" href="<?php echo base_url('trs/messages'); ?>"><i class="mdi mdi-chevron-left"></i> Back</a>
    <div id="message1" class="card-box table-responsive">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="timeline timeline-left">
                                    <article class="timeline-item alt">
                                        <div class="text-left">
                                            <div class="time-show first">
                                                <a href="#" class="btn btn-danger w-lg">Parent Chat Bot - <?php echo $message->title ?></a>
                                            </div>
                                        </div>
                                    </article>
									 <?php
                foreach ($message->items as $m)
                {
					$color = 'style="color:#F06292"';
					if($m->from=='Me'){
						$color = 'style="color:#000"';
					}
                        ?>
                                    <article class="timeline-item">
                                        <div class="timeline-desk">
                                            <div class="panel">
                                                <div class="timeline-box">
                                                    <span class="arrow"></span>
                                                    <span class="timeline-icon"><i class="mdi mdi-checkbox-blank-circle-outline"></i></span>
                                                    <h4 ><span <?php echo $color;?>>From:</span> <?php echo $m->from; ?> 
													<span <?php echo $color;?>>To:</span> <i style="color:#000"> <?php echo $m->to; ?></i></h4>
                                                    <p class="timeline-date text-muted"><small><?php echo $m->created_on > 10000 ? date('jS M Y H:i', $m->created_on) : ' - '; ?></small></p>
													
                                                    <p><?php echo $m->message; ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
				<?php } ?>
                             
                                   

                                </div>
                            </div>
                        </div>
                        <!-- end row -->




       
        <div class="clearfix"></div>
        <div class="headerx">
            <h3 class="page-title"> <?php echo $message->title ?></h3>
        </div>
        <div id="message-nano-wrapper" class="nanox">
            <ul class="message-container">
               
                     
                <li class="convos">
                    <div class="details">
                        <div class="left">Reply</div>
                        <div class="right">&nbsp;</div>
                    </div>
                    <?php
                    $attributes = array('class' => 'form-horizontal', 'id' => '');
                    echo form_open_multipart(current_url(), $attributes);
                    ?>
                    <?php echo form_error('message'); ?>
                    <textarea name="message" class="summernote"><?php echo set_value((isset($result->message)) ? htmlspecialchars_decode($result->message) : ''); ?></textarea>
                    <div class="pul">
                        <button class="btn btn-primary btn-small" type="submit"><i  class=" mdi mdi-send"></i> Send</button>
                    </div>
                    <?php echo form_close(); ?>
                </li>               
            </ul>
        </div>
    </div>    
</div>
<style>
    #message
    {    
        background: #f3f6f9;
        padding: 10px;
    }
    #message  .btn {
        border: 1px solid #84bb26;
        padding: 7px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        border-radius: 3px;
    }
</style>