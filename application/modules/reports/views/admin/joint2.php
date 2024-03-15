<div class="head">
    <div class="icon"></div>
    <h2></h2>
    <div class="right"></div>    					
</div>
<?php

	$sslist = array();
		foreach ($this->classlist as $ssid => $s)
		{
			$sslist[$ssid] = $s['name'];
		}

	$s1 = $rank ? '' : ' checked="checked" ';
	$s2 = '';
	$s3 = '';
		if ($rank)
		{
			$s1 = $rank == 1 ? ' checked="checked" ' : '';
			$s2 = $rank == 2 ? ' checked="checked" ' : '';
			$s3 = $rank == 3 ? ' checked="checked" ' : '';
		}

?>

<div class="toolbar">
    <div class="row row-fluid">
        <div class="col-md-12 span12">
            <?php echo form_open(current_url()); ?>
            Class  <?php echo form_dropdown('group', array("" => " Select ") + $this->classes, $this->input->post('group'), 'class ="tsel" '); ?> or 
            Stream
            <?php echo form_dropdown('class', array('' => 'Select') + $sslist, $this->input->post('class'), 'class ="tsel" '); ?>
            Exam(s) 
            <?php echo form_dropdown('exams[]', $exams, $this->input->post('exams'), 'class ="fsel" multiple placeholder="Select Exams" '); ?>
            Show Units <input type="checkbox"  name="show" value="1"/>
            Custom <input type="checkbox"  name="custom" value="1"/>
            <br>
            <fieldset>
                <legend>Ranking Options</legend>
                <label class="radio-inline">
                    <input type="radio" name="rank" id="r1" value="1" <?php echo $s1; ?>/>
                    All Subjects
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rank" id="r2" value="2" data-html="true" <?php echo $s2; ?>/>
                    Best 7 - Option 1
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rank" id="r3" value="3" data-html="true" <?php echo $s3; ?>/>
                    Best 7  - Option 2
                </label>
				
            </fieldset>
            <br>
            <button class="btn btn-primary"  type="submit">View Report</button>
            <div class="pull-right">
                <a href="" onClick="window.print(); return false" class="btn btn-warning"><i class="icos-printer"></i> Print </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php
$chart = FALSE;
$ij = 0;
$bars = array();
$ties = array();
$keys = array_keys($mks);

foreach ($mks as $student => $pyl)
{
    $ij++;
    $st = $this->worker->get_student($student);
    $cst = ' - ';

    if (isset($st->cl))
    {
        $crr = isset($this->classes[$st->cl->class]) ? $this->classes[$st->cl->class] : '';
        $ctr = isset($streams[$st->cl->stream]) ? $streams[$st->cl->stream] : '';
        $cst = $crr . $ctr;
    }
    $p = (object) $pyl;
    ?>
    <div class="invoice">
        <div class="row row-fluid">
            <div class="row-fluid center">
                <?php
                $file = FCPATH . '/uploads/joint-header.png';
                if (file_exists($file))
                {
                    ?>
                    <span class="col-sm-2" style="text-align:center"></span>
                    <span class="col-sm-8" style="text-align:center">
                        <img src="<?php echo base_url('uploads/joint-header.png'); ?>" class="center"    />
                    </span>
                    <span class="col-sm-2" style="text-align:center">
					<!--
                        <?php
                        if (!empty($st->photo)):
                            $passport = $this->ion_auth->passport($st->photo);
                            if ($passport)
                            {
                                ?> 
                                <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                            <?php } ?>	

                        <?php else: ?>   
                            <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                        <?php endif; ?>
						-->
                    </span>
                    <?php
                }
                else
                {
                    ?>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <span class="" style="text-align:center">
                            <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="120" height="120" />
                        </span>
                        <h3>
                            <span style="text-align:center !important;font-size:15px;"><?php echo strtoupper($this->school->school); ?></span>
                        </h3>
                        <small style="text-align:center !important;font-size:12px; line-height:2px;">
                            <?php
                            if (!empty($this->school->tel))
                            {
                                echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                            }
                            else
                            {
                                echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                            }
                            ?>
                        </small>
                        <h3>
                            <span style="text-align:center !important;font-size:13px; font-weight:700; border:double; padding:5px;">MOTTO: <?php echo strtoupper($this->school->motto); ?></span>
                        </h3>
                        <small style="text-align:center !important;font-size:20px; line-height:2px; border-bottom:2px solid  #ccc;">Student Performance Terminal Report</small>
                    </div>		
                    <div class="col-sm-2">
					<!--
                        <?php
                        if (!empty($st->photo)):
                            $passport = $this->ion_auth->passport($st->photo);
                            if ($passport)
                            {
                                ?> 
                                <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                            <?php } ?>	

                        <?php else: ?>   
                            <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                        <?php endif; ?>
						-->
                    </div>	
                <?php } ?>                              
            </div>


            <table class="topdets">
                <tr>
                    <td><strong>NAME: </strong>
                        <abbr><?php echo strtoupper($st->first_name . ' ' . $st->middle_name. ' ' . $st->last_name); ?>  </abbr>
                    </td>
                    <td style="display:none"><strong> Age: </strong> <?php echo (!empty($st->dob) && $st->dob > 10000) ? $this->dates->createFromTimeStamp($st->dob)->diffInYears() : '-'; ?> </td>
                    <td><strong> CLASS : </strong> <abbr><?php echo strtoupper($st->cl->name); ?></abbr></td>
                    <td><strong>ADM NO : </strong>
                        <abbr><?php echo isset($st->old_adm_no) && !empty($st->old_adm_no) ? $st->old_adm_no : $st->admission_number; ?></abbr>
                        <span class="hidden">  &nbsp;&nbsp;&nbsp; <strong>KCPE Marks:  </strong><?php echo $st->entry_marks; ?></span>
                    </td>
                    <td> <strong>ClASS TEACHER : </strong>
                        <abbr>
                            <?php
                            $cc = '';
                            if (!empty($st->cl->class) && !empty($st->cl->class_teacher))
                            {
                                $ctc = $this->ion_auth->get_user($st->cl->class_teacher);
                                if ($ctc)
                                {
                                    $cc = $ctc->first_name . ' ' . $ctc->last_name;
                                }
                            }
                            echo strtoupper($cc);
                            ?>
                        </abbr>
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="hidden">
                    <?php
                    if (!empty($st->pass))
                    {/*
                      ?>
                      <img src="<?php echo base_url('uploads/' . $st->pass->fpath . '/' . $st->pass->filename); ?>" alt="">
                      <?php */
                    }
                    ?>
                </div>                   
            </div>
        </div>
        <br/>
        <table class="tablex table-bordered">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th><b>SUBJECT</b></th>
                    <th><b>TEACHER</b></th>
                    <?php
                    $tf = 0;

                    foreach ($list as $l)
                    {
                        $tf++;
                        $pref = str_ireplace('Exams', '', $l->title);
                        $pref = str_ireplace('Exam', '', $pref);
                        $tt = trim($pref) . ' ' . $l->term . ' ' . $l->year;
                        ?>
                        <th><b><?php echo $tt; ?></b></th>
                        <th><b>EFFORT</b></th>
                        <?php
                    }
                    ?>
                    <?php
                    if (count($list) > 1)
                    {
                        ?>
                        <th><b>AVERAGE.</b></th>
                    <?php } ?>
                    <th><b>CLASS AVG.</b></th>
                    <th><b>GRADE</b></th>
                    <th><b>REMARKS</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $is_opt = array();
                $i = 0;
                $grading = 0;
                foreach ($p->res as $sub => $spms)
                {
					//print_r($p->res);
                    $sp = (object) $spms;

                    $i++;
                    $grading = $sp->grading;

                    $dr = 0;

                    if (isset($sp->units) && !empty($sp->units))
                    {
                        if ($show)
                        {
                            foreach ($sp->units as $uxid => $uxres)
                            {
                                //these are sub units
                                if ($uxid == '-')
                                {
                                    continue;
                                }
                                ?>
                                <tr>
                                    <td class="text-center"></td>
                                    <td><?php echo $uxid; ?></b></td>
									   <td></td>
                                    <?php
                                    foreach ($uxres as $e)
                                    {
                                        $rs = (object) $xres;
                                        ?>
                                        <td><small><?php echo $e; ?></small></td>
                                    <?php } ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i; ?></td>
                            <td><b><?php echo $sp->subject; ?></b></td>
                            <td><b><?php //echo $sp->created_by; ?></b></td>
                            <?php
                            /****
							****
							*** These are exams WITH sub units
							****
							****/
							
                            $k = 0;
                            foreach ($sp->maks as $xid => $xres)
                            {
                                $k++;
                                $rs = (object) $xres;
                                if ($rs->opt == 1 && $k == 1)//insert once only
                                {
                                    $is_opt[] = $rs->marks;
                                }
                                if ($rank > 1 && in_array($rs->sub_id, $ranked[$student][$xid]['dropped']))
                                {
                                    $dr = 1;
                                }
                                ?>
                                <td class="text-right <?php echo $dr ? 'dropped' : ''; ?>"><b><?php echo $rs->marks; ?>(<?php $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : '';
                                ?>)</b></td>
								<td></td>
                                <?php
                                if (count($list) == 1)
                                {
                                    break;  //hide avg column if single exam
                                }
                            }
                            ?>
                            <td style="text-align:center"><?php echo isset($class_avg[$sp->sub_id]) ? $class_avg[$sp->sub_id] : '-'; ?></td>
                            <td style="text-align:center">
                                <strong>
                                    <?php
                                    $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                                    echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : '';
                                    ?> 
                                </strong> 
                            </td>
                            <td style="text-align:center"><strong> <?php
                                    $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                                    echo isset($rmks->grade) && isset($grades[$rmks->grade]) ? $grades[$rmks->grade] : '';
                                    ?> </strong> 
                            </td>
                        </tr>
                        <tr>
						 <td colspan="8"><?php echo $rs->remarks; ?></td>
                        </tr>
                        <?php
                    }
                    else
                    {
                        /*****
						******
						****** These are exams WITHOUT sub units
						******
						*****/
						
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i; ?></td>
                            <td><b><?php echo $sp->subject; ?> <?php //echo $sp->sub_id; ?></b></td>
                          
                            <?php
                            $k = 0;
							
                            foreach ($sp->maks as $xid => $xres)
                            {   
                                $k++;
                                $rs = (object) $xres;
								
                                if ($rs->opt == 1 && $k == 1)//insert once only
                                {
                                    $is_opt[] = $rs->marks;
                                }


                                if ($rank > 1 && $xid != 999999 && in_array($rs->sub_id, $ranked[$student][$xid]['dropped']))
                                {
                                    $dr = 1;
                                }
                                ?>
								
								  <td>
									 <b>
										<?php  
										
										 if(!empty($rs->created_by)){
										   $t = $this->portal_m->get_teacher_profile($rs->created_by); 
										  echo $t->first_name.' '.$t->middle_name.' '.$t->last_name ;
										    }
											/* if($class_group){
												
												 $tt = $this->portal_m->get_subject_teacher($class_group, $rs->sub_id); 
												  
												  if(!empty($tt->teacher)){
													   $t = $this->portal_m->get_teacher_details($tt->teacher); 
													   echo $t->first_name.' '.$t->middle_name.' '.$t->last_name ;
												  }

											} */
										   
											?>
										</b>
								</td>
							
							
                                <td class="text-right <?php echo $dr ? 'dropped' : ''; ?>"><b><?php echo $rs->marks; ?>
                                        (<?php $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                                echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : '';
                                ?>)</b>
                                </td>
								<td><?php echo $rs->effort?></td>
                                <?php
                                if (count($list) == 1)
                                {
                                    break;
                                }
                            }
                            ?>
                            <td style="text-align:center"><?php echo isset($class_avg[$sp->sub_id]) ? $class_avg[$sp->sub_id] : '-'; ?></td>
                            <td style="text-align:center">
                                <strong> 
                                    <?php
                                    $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                                    echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : '';
                                    ?> 
                                </strong>
                            </td>
                            <td style="text-align:center">
                                <strong> <?php
                                    $rmks = $this->ion_auth->remarks($sp->grading, $rs->marks);
                                    echo isset($rmks->grade) && isset($grades[$rmks->grade]) ? $grades[$rmks->grade] : '';
                                    ?> 
                                </strong> 
                            </td>
                        </tr>
						<!---- REMARKS  ----->
						<tr>
						   <td colspan="8"><?php echo $rs->remarks; ?></td>
                        </tr>
						
						
                        <?php
                    }
                }
                ?>
                <tr class="rttbx">
                    <td class="text-center"> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <?php
                    foreach ($p->tots as $gd)
                    {
                        ?>
                        <td class="text-right"></td>  
                        <?php
                    }
                    if (count($list) > 1)
                    {
                        ?>
                        <td class="">  </td>
                    <?php } ?>
                    <td class="">  </td>
                    <?php
                    if (count($this->input->post('exams')))
                    {
                        echo '<td colspan="' . (count($this->input->post('exams')) - 2) . '" class="bltop"> </td>';
                    }
                    ?>
                </tr>
                <tr class="rttbx">
                    <td class="text-center"> </td>
					
                    <td> <strong> Class Average  </strong></td>
                    <?php
                    $iii = 0;
                    $ix = 0;
                    foreach ($tot_avg as $gd)
                    {
                        $iii++;
                        ?>
                        <td class="text-right"><?php echo round($gd / (count($p->res) - count($is_opt) )); ?></td> 
                        <?php
                        if (count($list) == 1)
                        {
                            $ix++;
                            ?>
                            <td class="">  </td>
                            <?php
                            break;
                        }
                        ?>
                    <?php } ?>
                    <?php
                    if (count($list) > 1)
                    {
                        ?>
                        <td>  </td>
                    <?php } ?>


                    <?php
                    if (count($this->input->post('exams')))
                    {
                        echo '<td colspan="' . (count($this->input->post('exams')) - 2) . '" class="bltop"> </td>';
                    }
                    ?>
					  <td> </td>
					  <td> </td>
                </tr>                   
                <tr class="rttbx">
                    <td class="text-center"> </td>
                    <td> <strong> Student Average  </strong></td>
                    <?php
                    $average = 0;
                    foreach ($p->tots as $tid => $gd)
                    {
                        $average = $rank > 1 ? round($ranked[$student][$tid]['total_ranked'] / 7, 2) : round($gd / (count($p->res) - count($is_opt) )); //access the value of avg for average column by overwriting until the end
                        ?>
                        <td class="text-right">
                            <?php
                            $all_mkrs = $rank > 1 ? round($ranked[$student][$tid]['total_ranked'] / 7, 2) : round($gd / (count($p->res) - count($is_opt) ));
                            echo $all_mkrs;
                            ?>
                            (<?php
                            $avg_rw = $this->ion_auth->remarks($grading, $all_mkrs);
                            $avg_grade = isset($avg_rw->grade) && isset($grade_title[$avg_rw->grade]) ? $grade_title[$avg_rw->grade] : '';

                            echo $avg_grade;
                            ?>)
                        </td>
                        <?php
                        if (count($list) == 1)
                        {
                            ?>
                            <td class="">  </td>
                            <?php
                            break;
                        }
                        ?>
                        <?php } ?>
                    <td class="text-center">
                        <?php
                        $avg_rw = $this->ion_auth->remarks($grading, $average);
                        $avg_grade = isset($avg_rw->grade) && isset($grade_title[$avg_rw->grade]) ? $grade_title[$avg_rw->grade] : '';
                        if (empty($avg_grade))
                        {
                            $avg_grade = ' - ';
                        }
                        //echo $avg_grade;
                        ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <?php
                    if (count($list) > 1)
                    {
                        ?>
                        <td class="">  </td>
    <?php } ?>
                </tr>
				<!--
                <tr class="rttbx">
                    <td class="text-center"> </td>
                    <td> <strong> Total </strong></td>
                    <?php
                    $t = 0;
                    foreach ($p->tots as $xid => $gd)
                    {
                        $t++;
                        ?>
                        <td class="text-right">
                            <?php
                            if (count($list) == 1)
                            {
                                if ($t == 1)
                                {
                                    echo $rank > 1 ? $ranked[$student][$xid]['total_ranked'] : $gd;
                                }
                            }
                            else
                            {
                                echo $rank > 1 ? $ranked[$student][$xid]['total_ranked'] : $gd;
                            }
                            ?></td>  
                    <?php } ?>
                    <?php
                    if (count($list) > 1)
                    {
                        ?>
                        <td class="">  </td>
                    <?php } ?>
                    <td class="">  </td>
                    <?php
                    if (count($this->input->post('exams')))
                    {
                        echo '<td colspan="' . (count($this->input->post('exams')) - 2) . '" class="bltop"> </td>';
                    }
                    ?>
                </tr>
				-->
                <tr>
                    <td> </td>
                    <?php
                    if (count($this->input->post('exams')))
                    {
                        echo '<td colspan="' . count($this->input->post('exams')) . '" class="bltop"> </td>';
                    }

                    if ($ij > 1)
                    {
                        $prevk = $mks[$keys[array_search($student, $keys) - 1]];
                        $pxvg = $prevk['avg'];

                        if ($pxvg == $p->avg) //if previous == current, maintain pos
                        {
                            $ties[] = $p->avg;
                            $poss = $ij - (count($ties) );
                        }
                        else
                        {
                            if (!empty($ties))
                            {
                                // $ij = $ij- count($ties); //uncomment to disable skipping the tied positions
                            }
                            $ties = array(); //clear 
                            $poss = $ij;
                        }
                    }
                    else
                    {
                        $poss = $ij;
                        $pxvg = '';
                    }
                    ?>
                    <?php
                    if (count($list) > 1)
                    {
                        $chart = 1;
                        ?>
                        <td class="bltop">  </td>
    <?php } ?>
                    <td class="bltop" colspan='3'>
					 <?php
                    if (count($list) > 1)
                    {
                        ?>
					POS.: <strong><?php echo $poss; ?></strong> <strong>OUT OF: <?php echo count($mks); ?></strong>
					<?php } ?>
					
					</td>
                    <td class="">  </td>
                    <td class="">  </td>
                    <td class="">  </td>
                </tr>
            </tbody>
        </table>
        <?php
        $ex_string = implode('_', $exlist);
        if ($chart)
        {
            ?>
           
            <div class="row">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-8"> <div id="pxbar<?php echo $ij; ?>" class="grapdh" style="width:82%; height:200px;"></div></div>
             </div>
            <?php
        }
        $conduct = '';
        $tr = '';
        $hr = '';
        if ($xterm && $xyear)
        {
            $rremarks = $this->worker->get_joint_remarks($xterm, $xyear, $student, $ex_string);
            $conduct = empty($rremarks) ? '' : $rremarks->conduct;
            $tr = empty($rremarks) ? '' : $rremarks->tr_remarks;
            $hr = empty($rremarks) ? '' : $rremarks->ht_remarks;
        }
        ?>
        <div>						 
            <div class="foo"> <br> </div>
			<!--
            <div class="foo col-sm-12" style="display:none">
                <strong><span ><b style="text-decoration:underline">Next Term Commences on:</b> &nbsp;&nbsp; _______________________ &nbsp;&nbsp; </span></strong>
                <span  ><strong>&nbsp;&nbsp; Attendance:&nbsp;&nbsp; ___________ &nbsp;&nbsp; Out of  &nbsp;&nbsp; ____________ &nbsp;&nbsp; Sessions</strong></span>
                <br>
            </div>
     
            <div class="foo col-sm-12">
                <strong><span style="text-decoration:underline">Student's Conduct:</span></strong>
                <br>
                <span class="col-sm-12">
                    <span class="editable conduct<?php echo $student; ?> editable-wrap" e-style="width:100%;"><?php echo $conduct; ?></span>
                </span>
            </div>
			-->
            <div class="foo col-sm-12">
                <strong><span style="text-decoration:underline">CLASS TEACHER'S COMMENT:</span></strong>
                <br>
                <span class="col-sm-12">
                    <span class="editable teacher<?php echo $student; ?> editable-wrap" ><?php echo $tr; ?></span>
                </span>
				<p>&nbsp;</p>
            </div>
			<!--	
            <div class="foo col-sm-12">
                <strong>
                    <span style="text-decoration:underline" >Principal's Comment:</span>
                </strong>
                <br/>
                <span class="editable ht<?php echo $student; ?> editable-wrap" e-style="width:100%"><?php echo $hr; ?>
                    <?php
                    $file = FCPATH . '/uploads/files/headteacher-signature.jpg';
                    if (file_exists($file))
                    {
                        ?>
                        <img class = "pull-right" src = "<?php echo base_url('uploads/files/headteacher-signature.jpg'); ?>" width = "200" height = "80" class = "img-polaroid" >
    <?php } ?>
                </span>
            </div>
			-->

			<!--- EFFORT ---->
			
			<table width="100%">
			 <tr>
				<td style="background:#00DAED; color:#fff;">EFFORT</td>
				<?php foreach($effort as $f){?>
				<td><?php echo $f->value;?> : <?php echo $f->remarks;?> <?php //echo $sp->grading;?></td>
                <?php } ?>
			 </tr>
			</table>
		
			<table width="100%">
			 
				<tr >
					<?php foreach($igcse_grading as $g){?>
					
						 <td style="background:#00DAED !important; color:#fff;"><?php echo $grades[$g->grade];?> </td>
				   
					<?php } ?>
				</tr>
				<tr>
			    <?php foreach($igcse_grading as $g){?>
				
					 <td>
						<?php echo $g->maximum_marks.' - '.$g->minimum_marks;?>
					</td>
				<?php } ?> 
				
				</tr>
				
				<tr>
					<?php foreach($igcse_grading as $g){?>
					
						 <td><?php echo $grade_title[$g->grade];?> </td>
				   
					<?php } ?>
				</tr>
               
			</table>
        </div>

        <div class="clearfix" style="clear:both"></div>
        <div class="center" style="border-top:1px solid #ccc">		
            <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                This document was produced without any alteration. For any question please contact our office 
                <?php
                echo ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                ?>
            </span>
        </div>
        <div class="margin"></div>            
    </div>
    <?php
    $scores = array();
    foreach ($p->tots as $tid => $gd)
    {
        if ($tid == '999999')
        {
            continue;
        }
        $roxx = $rank > 1 ? $ranked[$student][$tid]['total_ranked'] : $gd;
        $rtt = (object) $titles[$tid];
        $rm_title = str_replace('EXAMS', '', $rtt->title);
        $title = str_replace('EXAM', '', $rm_title);
        $scores[] = array('marks' => $roxx, 'title' => $title);
    }

    if ($chart)
    {
        ?>
        <script>
            $(document).ready(
                    function ()
                    {
                        Morris.Bar({
                            element: 'pxbar<?php echo $ij; ?>',
                            data: <?php echo json_encode($scores); ?>,
                            xkey: 'title',
                            ykeys: ['marks'],
                            labels: ['Marks'],
                            barSizeRatio: 0.55,
                            barSize: 50,
                            xLabelAngle: 35,
                            hideHover: 'auto',
                            grid: true
                        });
                    });
        </script>
    <?php } ?>
    <?php
    if ($xterm && $xyear)
    {
        ?>
        <script type="text/javascript">
            $(function () {
                //editables on first profile page
                $.fn.editable.defaults.mode = 'inline';
                $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
                $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit" title="Submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
                        '<button type="button" class="btn btn-danger editable-cancel" title="Cancel"><i class="glyphicon glyphicon-remove"></i></button>';
                $('.conduct<?php echo $student; ?>').editable({
                    type: 'textarea',
                    title: 'Enter Remarks',
                    pk: <?php echo $student; ?>,
                    url: '<?php echo base_url('admin/reports/save_remarks/' . $xterm . '/' . $xyear . '/' . $ex_string . '/1'); ?>',
                    emptytext: '----------------------------------------------------',
                    success: function (response, newValue)
                    {
                        notify('Report Form', 'Remarks Added: ' + newValue);
                    }
                });
                $('.teacher<?php echo $student; ?>').editable({
                    type: 'textarea',
                    title: 'Teacher Remarks',
                    pk: <?php echo $student; ?>,
                    url: '<?php echo base_url('admin/reports/save_remarks/' . $xterm . '/' . $xyear . '/' . $ex_string . '/2'); ?>',
                    emptytext: '----------------------------------------------------',
                    success: function (response, newValue)
                    {
                        notify('Report Form', 'Remarks: ' + newValue);
                    }
                });
                $('.ht<?php echo $student; ?>').editable({
                    type: 'textarea',
                    title: 'Headteacher Remarks',
                    pk: <?php echo $student; ?>,
                    url: '<?php echo base_url('admin/reports/save_remarks/' . $xterm . '/' . $xyear . '/' . $ex_string . '/3'); ?>',
                    emptytext: '----------------------------------------------------',
                    success: function (response, newValue)
                    {
                        notify('Report Form', 'Remarks: ' + newValue);
                    }
                });

            });
        </script>
    <?php } ?>
    <div class="page-break"></div>
    <?php
}
?>
<script>
    $(document).ready(
            function ()
            {
                $(".tsel").select2({'placeholder': 'Please Select', 'width': '200px'});
                $(".tsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.added.text);
                });
                $(".fsel").select2({'placeholder': 'Please Select', 'width': '400px'});
                $(".fsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.added.text);
                });
            });
</script>

<style>
    .xxd, .editableform textarea {
        height: 150px !important; 
    }
    .editable-container.editable-inline 
    {
        width: 89%;
    }
    .col-sm-2{
        width: 16.66666667%;
    }
    .col-sm-8{
        width: 66.66666667%;
    }

    .editable-input {
        display: inline; 
        width: 89%;
    }
    .editableform .form-control {
        width: 89%;
    }
    .invoice{padding: 20px;}
    .topdets {
        width:85%;
        margin: 6px auto;
        border: 0;
    }
    .topdets th,  .topdets td ,.topdets 
    {
        border: 0;
    }
    .morris-hover{position:absolute;z-index:1000;}.morris-hover.morris-default-style{border-radius:10px;padding:6px;color:#666;background:rgba(255, 255, 255, 0.8);border:solid 2px rgba(230, 230, 230, 0.8);font-family:sans-serif;font-size:12px;text-align:center;}.morris-hover.morris-default-style .morris-hover-row-label{font-weight:bold;margin:0.25em 0;}
    .morris-hover.morris-default-style .morris-hover-point{white-space:nowrap;margin:0.1em 0;}
    .tablex{ width: 95% !important; margin: auto 15px  !important; border:1px solid #000 !important;}
    .tablex tr{
        border:1px solid #000 !important;
    }
    .tablex td{
        border:1px solid #000;
    }
    .tablex th{
        border:1px solid #000 !important;
    }
    .page-break{margin-bottom: 15px;}
    .dropped
    {
        border-bottom: 3px solid silver !important;
    }
    legend{
        width: auto;
        padding: 4px;
        margin-bottom: 0;
        border: 0;
        font-size: 11px;
    }
    fieldset {
        padding: 5px;
        border: 1px solid silver;
        border-radius: 7px;
    }
    @media print 
    {
        .invoice{padding: 20px !important;}
        .topdets {
            width: 85% !important; margin: auto 15px  !important;
            border: 0;
        }
        .tablex{ width: 100%;}
        .page-break{ display: block; page-break-after: always; position: relative;}
        table td, table th { padding: 4px; }
        .editable-click, a.editable-click, a.editable-click:hover {
            text-decoration: none;
            border-bottom: none !important;
        }
        .dropped
        {
            border-bottom: 3px solid silver !important;
        }
    }
</style>
