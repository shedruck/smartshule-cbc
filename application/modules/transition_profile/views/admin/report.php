<div class="row actions">
    <div class=" center" id="menus">
        <h3>End Year Transition Profile Report For - 
            <?php
                $streams = $this->streams;
              
               $ctr = isset($streams[$darasa]) ? $streams[$darasa] : '';
               echo   $ctr;
               ?>

        </h3>  

        <?php echo form_open(current_url()); ?>
        Select a Class
        <?php echo form_dropdown('class', array($darasa => $ctr) + $classes, $this->input->post('class'), 'class="select select-2"') ?> 


         OR Student
         <select name="student" class="select" tabindex="-1">
            <option value="">Select Student</option>
            <?php
            $data = $this->ion_auth->students_full_details();
            foreach ($data as $key => $value):
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $value ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        Select Year
         <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class="select select-2"') ?> 


        
        
         <button class="btn btn-warning"  style="height:30px;" type="submit">View Report</button>
        
        <a href="" onClick="window.print();
                    return false" class="btn btn-primary"><i class="icos-printer"></i> Print
        </a>

        <a href="<?php echo base_url('admin/transition_profile')?>" class="btn btn-success ">List All</a>
        
       
       <?php echo form_close()?>
        <br>
        <br>
    </div>
</div>
<br>
<hr>

<div class="clearfix"></div>

<?php if($report){ ?>
<div class="widget">
    <?php
     foreach($report as $r) { 
            $student =  $this->worker->get_student($r->student);
            $passport = $this->admission_m->passport($student->photo);

        ?>
        <br><br>
            <div class="slip">
                <div class="statement">
                    <div class="invoice slip-content">
                        <div class="row">
                        <center>
                            <div class="col-xs-3">
                                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" alt="" style="width: 70%;">
                            </div>
                            <div class="col-xs-5">
                                <h1><?php echo $this->school->school; ?></h1>
                                <br>
                                <?php
                                if (!empty($this->school->tel))
                                {
                                    echo $this->school->postal_addr . '<br> Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                }
                                else
                                {
                                    echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                }
                                ?>
                            </div>

                            <div class="col-xs-3">
                                <div class='btn btn-default btn-sm' >                   
                                    <?php
                                    if (!empty($student->photo)):
                                            if ($passport)
                                            {
                                                    ?> 
                                                    <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                                     <?php } ?> 

                                    <?php else: ?>   
                                            <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                                    <?php endif; ?>  
                                    <br>                    
                                </div>
                            </div>
                            </center>
                        </div>
                        <div>
                            <div class="center">
                                <h4> <?php 
                                $cg = isset($class_group[$darasa]) ? $class_group[$darasa] : '';
                                $tp = isset($type[$cg]) ? $type[$cg] : '';
                                echo strtoupper($tp); 
                            ?></h4>
                                <span class="center titles">END OF YEAR <?php echo $this->input->post('year')?> LEARNERS TRANSITION PROFILE </span>
                                <hr>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                   <table class="table " width="100%">
                                   <tr>
                                       <td><strong>Name : </strong>
                                           <abbr title="Name" style="font-size:15px"><?php echo $student->first_name . ' ' . $student->last_name; ?> </abbr>
                                       </td>
                                       <td><strong>Age : </strong> <abbr title="age" style="font-size:15px">
                                           <?php 

                                                $date = $student->dob > 10000 ? date('Y-m-d', $student->dob) : 0;
                                                $age = $date && $student->dob > 10000 ? date_diff(date_create($date), date_create('today'))->y : '';
                                                if($age == 0){
                                                   $age = '';
                                                }

                                                echo $age;
                                           ?>
                                           
                                       </abbr></td>
                                        
                                   </tr>
                                   <tr>
                                       <td>
                                           <strong>Class : </strong>
                                           <abbr title="Class" style="font-size:15px"><?php
                                                $streams = $this->streams;
                                              
                                               $ctr = isset($streams[$r->class]) ? $streams[$r->class] : '';
                                               echo   $ctr;
                                               ?>
                                           </abbr>
                                       </td>
                                       <td>
                                           <strong>Date : </strong> 
                                           <abbr title="Date" style="font-size:15px">
                                               <?php echo date("d M, Y", $r->created_on)?>
                                           </abbr>
                                       </td>
                                        
                                   </tr>
                               </table>
                            </div>
                        </div>

                        

                        
                        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30%"><strong>Key Areas</strong></th>
                            <th><strong>Comment</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Allergies</td>
                            <td><?php echo $r->allergy?></td>
                        </tr>
                         <tr>
                            <td>General Health comment</td>
                            <td><?php echo $r->general_health ?></td>
                        </tr>

                        <tr>
                            <td>General Academic Performance</td>
                            <td><?php echo $r->general_academic ?></td>
                        </tr>

                        <tr>
                            <td>Feeding habit</td>
                            <td><?php echo $r->feeding_habit ?></td>
                        </tr>

                        <tr>
                            <td>Behavior</td>
                            <td><?php echo $r->behaviour ?></td>
                        </tr>

                        <tr>
                            <td>Co-curriculum Activities</td>
                            <td><?php echo $r->co_curriculum ?></td>
                        </tr>

                         <tr>
                            <td>Parental involvement</td>
                            <td><?php echo $r->parental_involvement ?></td>
                        </tr>

                        <tr>
                            <td>Transport - Private Transport</td>
                            <td><?php if($r->transport == "private"){ ?> <i class="glyphicon glyphicon-check btn btn-pink btn-circle"></i><?php }?></td>
                        </tr>
                        <tr>
                            <td>&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            School Transport</td>
                            <td><?php if($r->transport == "school") { ?> <i class="glyphicon glyphicon-check btn btn-circle"></i><?php }?></td>
                        </tr>
                        <tr>
                            <td>Any other information</td>
                            <td><?php echo $r->any_info?></td>
                        </tr>
                         
                    </tbody>
                </table>

                <table class="lower" width="100%" style="border:none"  >
                    <tr>
                        <td>Prepared By</td>
                        <td>
                            <abbr>
                                <strong>
                                <?php 
                                    $user =  $this->ion_auth->get_user($r->created_by);
                                    echo ucwords($user->first_name.' '.$user->last_name);
                                ?>
                                </strong>
                            </abbr>
                        </td>

                        <td>Sign</td>
                        <td>_____________________</td>
                    </tr>

                    <tr>
                        <td>Received By</td>
                        <td>
                            <abbr>
                                <strong>
                                 _______________________
                                </strong>
                            </abbr>
                        </td>

                        <td>Sign</td>
                        <td>_____________________</td>
                    </tr>
                </table>
                        
                             

                       
                    </div>
                    <div class="footer">
                        <div class="center" style="border-top:1px solid #ccc">      
                            <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                                <?php
                                if (!empty($this->school->tel))
                                {
                                    echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                }
                                else
                                {
                                    echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                }
                                ?></span>
                        </div>
                    </div>
                </div>

            </div>
        <?php } ?>
            </div>
    <?php } ?>



<style type="text/css">
    .actions{
        background-color: white;
    }
</style>