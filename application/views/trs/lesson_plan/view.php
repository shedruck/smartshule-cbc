<div class="row"> 

<div class="col-md-12 card-box table-responsive">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h4> Lesson Plan - Details
             <div class="pull-right"> 
            
              <?php echo anchor( 'trs/lesson_plan' , '<i class="mdi mdi-list">
                </i> '.lang('web_list_all', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"');?> 
             
                </div> 
				</h4>
				<hr>
        </div>


<table class="table table-bordered">
	<tr class=" " >
	<th width="30%" class="bg-green">Class/Level </th>
	<td><?php  $classes = $this->ion_auth->fetch_classes();     echo  isset($result->class) ? $classes[$result->class]: ''; ?></td>
   </tr>
	<tr>
	<th width="30%" class="bg-green">Term </th>
	<td><?php echo $result->term ?></td>
	</tr>
	
	<tr>
	<th width="30%" class="bg-green">Year </th>
	<td><?php echo $result->year ?></td>
	</tr>
	
	<tr>
	<th width="30%" class="bg-green">Week of the Term </th>
	<td><?php echo $result->week ?></td>
	</tr>
	
	
	<tr >
	<th  width="30%" class="bg-green">Day of the week </th>
	<td><?php echo $result->day ?></td>
	</tr>
	
	
	<tr>
	<th width="30%" class="bg-green">Subject (Learning Area) </th>
	<td><?php echo $result->subject ?></td>
	</tr>
	
	<tr>
	<th colspan="2" class="bg-green">Lesson </th>
	</tr>
	<tr>
	<td colspan="2"><?php echo $result->lesson ?></td>
	</tr>

	<tr>
	<th colspan="2" class="bg-green">Lesson Activities </th>
	</tr>
	<tr>
	<td  colspan="2"><?php echo $result->activity ?></td>
	</tr>

	<tr>
	<th colspan="2" class="bg-green">Lesson Objective  </th>
	</tr>
	<tr>
	<td  colspan="2"><?php echo $result->objective ?></td>
	</tr>

	<tr>
	<th colspan="2" class="bg-green">Lesson Materials </th>
	</tr>
	<tr>
	<td  colspan="2"><?php echo $result->materials ?></td>
	</tr>

	<tr>
	<th colspan="2" class="bg-green">Lesson Assignment </th>
	</tr>
	<tr>
	<td  colspan="2"><?php echo $result->assignment ?></td>
	</tr>

	
</table>

            </div>
			
			
			
			