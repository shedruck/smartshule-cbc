<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Fee Arrears  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/fee_arrears/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Fee Arears')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/fee_arrears' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Fee Arears')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='student'>Student <span class='required'>*</span></div><div class="col-md-6">
	 <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select Student') + $data, (isset($result->student)) ? $result->student : '', ' class="select" data-placeholder="Select Options..." ');
                ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='amount'>Amount <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('amount' ,$result->amount , 'id="amount_"  class="form-control" ' );?>
 	<?php echo form_error('amount'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='term'>Term <span class='required'>*</span></div><div class="col-md-6">
	 <?php
                $data = array(1=>'Term One', 2=>'Term Two', 3=>'Term Three');
                echo form_dropdown('term', array('' => 'Select Term') + $this->terms, (isset($result->term)) ? $result->term : '', ' class="select" data-placeholder="Select Options..." ');
                ?>
 	<?php echo form_error('term'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='year'>Year <span class='required'>*</span></div><div class="col-md-6">
	
	<?php 
								
								 $time = strtotime('1/1/2005');
									$dates = array();

									for ($i=0; $i<29; $i++) {
										$dates[date('Y', mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time)+$i))] = date('Y', mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time)+$i));        
									}
								
								echo form_dropdown('year', array(''=>'Year')+$dates, '' ,   ' id="year" class="select"');
												?>
 	<?php echo form_error('year'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/fee_arrears','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
			
				<div class="col-md-4">

     <div class="widget">
          <div class="head dark">
               <div class="icon"><span class="icosg-newtab"></span></div>
               <h2>Record Fee Arrears per Class</h2>
          </div>

          <div class="block-fluid">
		
               <ul class="list tickets">
                    <?php
                    $i = 0;
                    foreach ($this->classlist as $cid => $cl)
                    {
                         $i++;
                         $cc = (object) $cl;
                         $cll =  $cid ;
                         ?> 
                         <li class = "<?php echo $cll; ?> clearfix" >
                              <div class = ""> 
							  <a href ="<?php echo base_url('admin/fee_arrears/per_class/'.$cid); ?>">
							 
								   <span class="glyphicon glyphicon-share"></span> <?php echo $cc->name; ?> 
								  <span style="background:#B1B1B1;float:right; color:#fff; padding:5px;"><b> <?php echo $cc->size; ?> Students</b> </span>
								  
								  </a>
								 
                                 
                              </div>
                         </li>
                    <?php } ?>
               </ul>
          </div>
     </div>


</div>