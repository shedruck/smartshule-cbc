<div class="card-box table-responsive"> 
<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h3> Zoom Classes
             <div class="pull-right">  
              <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
             
                </div>
			</h3>	
	<hr>			
   </div>
         	                    
              
	 <?php if ($classes): ?>
	 <div class="block-fluid">
	   <table id="datatable-buttons" class="table table-striped table-bordered">
			<thead>
					<th>#</th>
					<th>Title</th>
					<th>Link</th>
					<th>Class</th>
				</thead>
		<tbody>
	
        <?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($classes as $p ): 
                 $i++;
				 $link= $p->link;
				 $new_link = explode ('/', $link);
				 $meeting_id= $new_link[4];

				 $new_link= str_replace("?","&","$meeting_id");
				 $email=$this->user->email;
				 $name=$this->user->first_name.' '.$this->user->last_name;
				 $prev="https://smartshulezoom.smartshule.com/zoom/index.php?name=$name&email=$email&meeting_id=";
				 $meeting_link= $prev.$new_link;

				//  $users= explode(",",$p->user_group);
				
				 $cc = '';
				if (isset($this->classlist[$p->class])){
					$cro = $this->classlist[$p->class];
					$cc = isset($cro['name']) ? $cro['name'] : '';
				}
                     ?>
	 			<tr>
					<td><?php echo $i . '.'; ?></td>					
					<td><?php echo $p->title;?></td>
					<td><a href="<?php echo $meeting_link?>" target="_blank"><?php echo $meeting_link;?></a></td>
					<td><?php echo $cc;?></td>

			
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 
 </div>