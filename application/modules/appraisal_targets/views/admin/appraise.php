<div class="col-md-12">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Appraising Teachers  </h2>
           
             <div class="right"> 
             <?php echo anchor( 'admin/appraisal_targets/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Appraisal Targets')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/appraisal_targets' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Appraisal Targets')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
            <div class="block-fluid">

                    <?php 
                    echo validation_errors();
                    $attributes = array('class' => 'form-horizontal', 'id' => '');
                    echo   form_open_multipart(current_url(), $attributes); 
                    ?>

                        <fieldset class="border border-info p-2 w-100">
                                <legend  class="w-auto">Rating Legend</legend>
                                <p>5 = Strongly Agree, 4 = Agree, 3 = Uncertain, 2 = Disagree, 1 = Strongly Disagree</p>
                        </fieldset>
                        <hr>
                        <div class="form-group col-md-12">
                            <label>Select Teacher</label>
                            <select class="select select-2" name="teacher" required>
                                <option >Select Teacher to Appraise</option>
                                <?php foreach($teachers as $teacher) {?>
                                    <option value="<?php echo $teacher->user_id?>.<?php echo $teacher->id?>">
                                    <?php echo strtoupper($teacher->last_name.' '.$teacher->first_name ). '('.$teacher->id_no.')'?></option>
                                <?php }?>
                            </select>
                        </div><br><br>
                          
                        
                    <table class="table table-condensed">
                        <thead>
							<tr class="bg-gradient-secondary">
								<th colspan="2" class=" p-1"><b>Targets</b></th>
								<th class="text-center">1</th>
								<th class="text-center">2</th>
								<th class="text-center">3</th>
								<th class="text-center">4</th>
								<th class="text-center">5</th>
							</tr>
						</thead>
                        <tbody class="tr-sortable">
                        <?php 
                        $index=1;
                        foreach($targets as $target){?>
							<tr class="bg-white">

                                <td class="p-1 text-center" width="5px"><?php echo $index;?></td>
									
								<td class="p-1" width="40%">
									<?php echo $target->target ?>
									<input type="hidden" name="target_id[]" value="<?php echo $target->id ?>">
								</td>
								<?php for($c=0;$c<5;$c++): ?>
								<td class="text-center">
									<div class="icheck-success d-inline">
				                        <input type="radio" name="rate[<?php echo $target->id?>]" id="<?php echo $c+1?>" value="<?php echo $c+1?>">
				                        <label>
				                        </label>
			                      </div>
								</td>
								<?php endfor; ?>
							</tr>
                            <?php $index++; }?>
                            <tr>
                                <td colspan="7" >
                                    <button style="float:right" class="btn btn-sm btn-success">Save</button>
                                </td>
                            </tr>
						</tbody>
                    </table>
                       
                    <?php echo form_close(); ?>
                    <div class="clearfix"></div>
 </div>
            </div>

            <style>
                input[type="radio"] {
  -webkit-appearance: checkbox; /* Chrome, Safari, Opera */
  -moz-appearance: checkbox;    /* Firefox */
  -ms-appearance: checkbox;     /* not currently supported */
}   
            </style>