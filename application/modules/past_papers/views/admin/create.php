<div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>
 			 
            <h2>  Upload files to "<?php $f = $this->ion_auth->populate('folders','id','title'); echo $f[$folder]?>" folder</h2>
             <div class="right"> 
             
              <?php echo anchor( 'admin/past_papers' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Past Papers')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>

<br>
<div class="col-md-12">

	   <div class="block-fluid">

			<?php 
			$attributes = array('class' => 'form-horizontal', 'id' => '');
			echo   form_open_multipart(current_url(), $attributes); 
			?>
			<div class='form-group col-md-6'>
				<div class="col-md-3" for='year'>Year <span class='required'>*</span></div><div class="col-md-9">
				<?php 
											
					 $time = strtotime('1/1/1990');
						$dates = array();

						for ($i=0; $i<35; $i++) {
							$dates[date('Y', mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time)+$i))] = date('Y', mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time)+$i));        
						}
					
					echo form_dropdown('year', array(date('Y')=>date('Y'))+$dates, '' ,   ' id="year" class="select"');
				?>
				<?php echo form_error('year'); ?>
			</div>
			</div>

			<div class='form-group col-md-6'>
				<div class="col-md-3" for='name'>Name <span class='required'>*</span></div><div class="col-md-9">
				<?php echo form_input('name' ,$result->name , 'id="name_"  class="form-control" placeholder="English Paper One, Mathematics etc"' );?>
				<?php echo form_error('name'); ?>
			</div>
			</div>

			<div class='form-group col-md-6'>
				<div class="col-md-3" for='name'>Class <span class='required'>*</span></div><div class="col-md-9">
				 <?php

					$classes = $this->portal_m->get_class_options();
					echo form_dropdown('class',array(''=>'Select Class')+ $classes + array('9999'=>'General'), (isset($result->class)) ? $result->class : '', ' class="select " data-placeholder="Select  Options..." ');

				?>
			</div>
			</div>

			<div class='form-group col-md-6'>
				<div class="col-md-3" for='file'> Upload Paper <span class='required'>*</span> </div>
			 <div class="col-md-6">
				<input id='file' type='file' name='file' required="required" />

				<?php if ($updType == 'edit'): ?>
				<a href='/public/uploads/past_papers/files/<?php echo $result->file?>' />Download actual file (file)</a>
				<?php endif ?>

				
			</div>
</div>


<div class='form-group col-md-12'>
<div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Upload Paper', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>

</div>



<div class="col-md-12">

 <h2>  Upload files papers</h2>

  <div class="block-fluid">

 <?php if ($pp): ?>
 
<?php 
			 $i = 0;
				if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
				{
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}
            $path = $this->ion_auth->populate('folders','id','slug');    
            foreach ($pp as $p ): 
                 $i++;
                     ?>
					 
					  <div class="col-sm-4" style="text-align:center"> 
					  <a href='<?php echo base_url('uploads/past_papers/'.$path[$folder].'/'.$p->file);?>'>
							 <embed src="<?php echo base_url('uploads/past_papers/' . $path[$folder] . '/' . $p->file); ?>" width="250" style="min-height:250px;" class="tr_all_hover" type='application/pdf'>
						</a>
						<br>
					     <a target="_blank" href='<?php echo base_url('uploads/past_papers/'.$path[$folder].'/'.$p->file);?>' class="btn btn-default">Year <?php echo $p->year;?><br>
						 <?php echo $p->name?>
						 </a> <hr>
				     </div>	

<?php endforeach ?>


<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 

</div>
</div>


			
			
			
			
			
			