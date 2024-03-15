<div class="row"> 

<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Lesson Plan  </h2>
             <div class="right">  
           
                </div>
                </div>
   <div class="block-fluid">
<table class="table table-bordered">
	<tr class=" " >
	<th width="30%" class="bg-black">Class/Level </th>
	<td><?php  $classes = $this->ion_auth->fetch_classes();     echo  isset($result->class) ? $classes[$result->class]: ''; ?></td>
   </tr>
	<tr>
	<th width="30%" class="bg-black">Term </th>
	<td><?php echo $result->term ?></td>
	</tr>
	
	<tr>
	<th width="30%" class="bg-black">Year </th>
	<td><?php echo $result->year ?></td>
	</tr>
	
	<tr>
	<th width="30%" class="bg-black">Week of the Term </th>
	<td><?php echo $result->week ?></td>
	</tr>
	
	
	<tr >
	<th  width="30%" class="bg-black">Day of the week </th>
	<td><?php echo $result->day ?></td>
	</tr>
	
	
	<tr>
	<th width="30%" class="bg-black">Subject (Learning Area) </th>
	<td><?php echo $result->subject ?></td>
	</tr>
	
	<tr>
	<th colspan="2" class="bg-black">Lesson </th>
	</tr>
	<tr>
	<td colspan="2"><?php echo $result->lesson ?></td>
	</tr>

	<tr>
	<th colspan="2" class="bg-black">Lesson Activities </th>
	</tr>
	<tr>
	<td  colspan="2"><?php echo $result->activity ?></td>
	</tr>

	<tr>
	<th colspan="2" class="bg-black">Lesson Objective  </th>
	</tr>
	<tr>
	<td  colspan="2"><?php echo $result->objective ?></td>
	</tr>

	<tr>
	<th colspan="2" class="bg-black">Lesson Materials </th>
	</tr>
	<tr>
	<td  colspan="2"><?php echo $result->materials ?></td>
	</tr>

	<tr>
	<th colspan="2" class="bg-black">Lesson Assignment </th>
	</tr>
	<tr>
	<td  colspan="2"><?php echo $result->assignment ?></td>
	</tr>

	
</table>

            </div>
			
			
			
			