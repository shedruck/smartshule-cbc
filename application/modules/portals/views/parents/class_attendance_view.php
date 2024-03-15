<?php

$students = array();
foreach ($this->parent->kids as $k)
{
        $usr = $this->admission_m->find($k->student_id);
        $students[$k->student_id] = strtoupper(trim($usr->first_name . ' ' . $usr->middle_name. ' ' . $usr->last_name));
}


?>

				<div class="card shadow-sm ctm-border-radius grow">
			<div class="card-header d-flex align-items-center justify-content-between">
				<h4 class="card-title mb-0 d-inline-block">Attendance Register</h4>
			
			</div>
		
		

    <div class="row">
    <div class="col-md-7">
        <h6>&nbsp;</h6>
        <?php echo form_open(current_url()); ?>
         <div class="form-group row">
			  <div class="col-md-6">
				<?php echo form_dropdown('student', array('' => 'Select Student') + $students, $this->input->post('student'), 'class="xsel form-control " placeholder="Select Student"'); ?>
			 </div>
			  <div class="col-md-3">
				<button type="submit" class="form-control btn btn-primary   text-white text-center">Submit</button>
				 </div>
			 
		</div>
        
		<br>
		<br>
        <?php
        echo form_close();
        ?>
		
		<?php if($stud){?>
		
		 <div class="row">
          <div class="col-sm-12">
				<table width="20%" class="table table-striped table-bordered">
				      <tr>
						   <td class="bg-black text-center">DESCRIPTION</td>
					       <td  class="bg-black text-center">PERIOD <?php echo strtoupper(date('F Y')); ?> </td>
					   </tr>

					   <tr>
						   <td class="input-green">Total Present:</td>
					       <td  class="bg-green"><?php echo $present; ?> times</td>
					   </tr>
				      <tr>
						   <td class="input-red">Total Absent:</td>
					       <td class="bg-red"><?php echo $absent; ?> times</td>
					   </tr>

					   <tr>
						   <td class="input-red">Total Sessions:</td>
					       <td class="bg-blue" ><?php echo number_format($present + $absent); ?> Sessions </td>
					   </tr>
					  
					</table>
		
					
	
     </div>
     </div>
     </div>
				 
	<div class="col-sm-5">
			   <table class="table-bordered" width="100%">
				      <tr>
						   <td colspan="3" class="input-blue text-center" ><h4 class="card-title mb-0 d-inline-block text-center"> Annual Attendance Summary- <?php echo date('Y')?></h4></td>
					   </tr>
					   <tr>
						   <td class="text-center input-blue">Month</td>
					       <td class="text-center input-green" >Present </td>
					       <td class="text-center input-red" >Absent </td>
					   </tr>
					   <?php 
							for($m=1; $m<=12; ++$m){
								
							$pre = $this->ion_auth->count_attendance($stud,'Present',$m,date('Y'));
							$abs = $this->ion_auth->count_attendance($stud,'Absent',$m,date('Y'));
							
							$bg ='';
							
							if(date('m')==$m){
								$bg = 'bg-blue';
								
							}elseif(date('m') > $m){
										$bg = 'bg-black';
									}
							?>
					   <tr>
						   <td class="text-center <?php echo $bg?>"><?php echo date('M', mktime(0, 0, 0, $m, 1));?></td>
					       <td class="text-center <?php if($pre >0) echo 'bg-green'; else echo 'bg-grey';?>" ><b><?php echo $pre; ?></b> </td>
					       <td class="text-center <?php if($abs >0) echo 'bg-red'; else echo 'bg-grey';?>"><b><?php echo $abs; ?></b> </td>
					   </tr>
				   <?php } ?>
					  
					</table>
			</div>
			
			
              </div>
		
		<hr>
		<br>
		<div class="row">
                <div class="col-sm-12">
				
				<div class="card-header d-flex align-items-center justify-content-between">
						<h4 class="card-title mb-0 d-inline-block col-sm-12">CALENDAR VIEW
						 <span class="pull-right">
		                    KEY:
								<div class="btn bg-green btn-sm"><i class="fa fa-calender"></i> Present</div>
								<div class="btn bg-red btn-sm"><i class="fa fa-calender"></i> Absent</div>
						</span>
                 
						</h4>
					
					</div>
					
					 
					 <div id='calendar'></div>
		     
 
				
	   </div>
	  </div>
	  
	  <?php } ?>		
    </div>


	   
	


<style>
.fc-time{
	display:none !important;
}
    table.calendar{ border-left:1px solid #999;     width: 100%;}
    table.calendar   td.calendar-day-head
    { 
        font-weight:bold; text-align:center; width:14.3%;  
        text-transform: uppercase;
        font-size: 12px;
        padding-top: 20px;
        color: rgba(255,255,255,0.2);
    }
    /* shared */
    table.calendar  td.calendar-day, td.calendar-day-np {  padding:5px; }
</style>