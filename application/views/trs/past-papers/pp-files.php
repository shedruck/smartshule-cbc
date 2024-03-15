<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            Upload files to "<?php $f = $this->ion_auth->populate('folders','id','title'); echo $f[$folder]?>" folder
        </h3>
      <div class="pull-right">
      
	    <?php echo anchor( 'trs/past_papers', '<i class="fa fa-list"></i> List All Videos', 'class="btn btn-primary btn-sm "');?>
		 <a class="btn btn-sm btn-danger" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>
 <div class="content">
	  <div class="row">
	  <div class="col-sm-12">


 <?php if ($pp): ?>
 
<?php 
			 $i = 0;
			
            $path = $this->ion_auth->populate('folders','id','slug');    
            foreach ($pp as $p ): 
                 $i++;
                     ?>
					 
					  <div class="col-sm-3 card-box" style="text-align:center"> 
					  <a href='<?php echo base_url('uploads/past_papers/'.$path[$folder].'/'.$p->file);?>'>
							 <embed src="<?php echo base_url('uploads/past_papers/' . $path[$folder] . '/' . $p->file); ?>" width="250" style="min-height:250px;" class="tr_all_hover" type='application/pdf'>
						</a>
						<br>
					     <a target="_blank" href='<?php echo base_url('uploads/past_papers/'.$path[$folder].'/'.$p->file);?>' class="btn btn-info">Year <?php echo $p->year;?><br>
						 <?php echo $p->name?>
						 </a> <hr>
				     </div>	

<?php endforeach ?>


<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 

</div>
</div>
</div>
</div>



			
			
			
			
			
			