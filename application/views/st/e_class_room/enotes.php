<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> <?php $classes = $this->ion_auth->fetch_classes(); echo strtoupper($classes[$this->student->class]); ?> : Subject <?php echo $subject?></b>
        </h3>
       <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        <div class="clearfix"></div>
        <hr>
    </div>
 <div class="content">
	  <div class="row">
	  <div class="col-sm-12">


 <?php if ($notes): ?>
 
<?php 
			 $i = 0;

            foreach ($notes as $p ): 
                 $i++;
                     ?>
					 
					    <div class="col-lg-4">
						  <a  data-toggle="modal" data-target="#view_<?php echo $p->id?>" href='#' class="btn btn-default waves-effect waves-light">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><b>Term</b> <?php echo $p->term;?> -  <?php echo $p->year;?> <button class="btn btn-sm btn-danger pull-right">View</button> </h3>
                                        <p class="panel-sub-title font-13 text-muted">Topic:<?php if($p->topic) echo substr($p->topic,0,20);?></p>
                                    </div>
                                    <div class="panel-body">
                                        <embed src="<?php echo base_url($p->file_path.'/'.$p->file_name);?>" width="250" style="min-height:250px;" class="tr_all_hover" type='application/pdf'>
                                    </div>
                                </div>
                             </a>
                         </div>
					 
					
					 
					   <div id="view_<?php echo $p->id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog modal-full">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close btn" data-dismiss="modal" aria-hidden="true">CLOSE</button>
										<h4 class="modal-title" id="full-width-modalLabel"><?php echo $subject?></h4>
									</div>
									<div class="modal-body">
										 <embed src="<?php echo base_url($p->file_path.'/'.$p->file_name);?>" width="100%" height="480" class="tr_all_hover" type='application/pdf'>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->

<?php endforeach ?>


<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 

</div>
</div>
</div>
</div>



			
			
			
			
			
			