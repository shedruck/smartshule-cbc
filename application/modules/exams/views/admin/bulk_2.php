<div class="row-fluid actions">
    <div class="  right" id="menus">
        <h4>Generate Per Class Or Per Student</h4>	
        <?php echo form_open(current_url()); ?>
        Select a Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $this->streams, $this->input->post('class'), 'class="select"') ?> 
        or
        <select name="student" class="select" tabindex="-1">
            <option value="">Select Student</option>
            <?php
                $data = $this->ion_auth->students_full_details();
                foreach ($data as $key => $value):
                     ?>
                     <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                <?php endforeach; ?>
        </select>
        <div class="control-group"></div>
        <input type="radio" name="opt" value="1" checked="checked" class="radio-inline">Option 1
        <input type="radio" name="opt" value="2" class="radio-inline">Option 2
        <button class="btn btn-warning"  style="height:30px;" type="submit">View Report Forms</button>
        <a href="" onClick="window.print();
                  return false" class="btn btn-primary"><i class="icos-printer"></i> Print
        </a>
        <?php echo form_close(); ?>
        <br>
        <br>
    </div>
</div>

<div class="widget">
     <?php
         $opt = $this->input->post('opt');
         $this->load->library('Dates');
         $pref = '';
         if ($flag)
         {//multiple
              $j = 0;
              foreach ($payload as $row)
              {
                   $j++;
                   $rw = (object) $row;
                   if ($opt == 1)
                   {
                        ?>
                       <div class="docpg">
                           <div class="row-fluid">
                               <div class="col-xs-2">
                                   <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="50">
                               </div>
                               <div class="col-xs-8 center">
                                   <h4><?php echo $this->school->school; ?></h4>
                                   <h5><?php echo $this->school->postal_addr; ?>, TEL: <?php
                                        echo $this->school->tel;
                                        echo $this->school->cell;
                                        ?>
                                   </h5>                 
                                   <h5><?php echo $this->school->email; ?> <?php echo $this->school->website; ?></h5>
                                   <h4><em>ACADEMIC REPORT – TERM <?php echo $exam->term; ?></em></h4>
                               </div>
                               <div class="col-xs-2 hpe">
                                    <?php
                                    if (!empty($rw->student->pass))
                                    {
                                         ?>
                                        <img src="<?php echo base_url('uploads/' . $rw->student->pass->fpath . '/' . $rw->student->pass->filename); ?>" width="100" height="60">
                                   <?php } ?>
                               </div>
                           </div>
                           <div class="row-fluid">
                               <table class="topdets table">
                                   <tr>
                                       <td> <strong><em>NAME:</em> </strong>
                                           <abbr><?php echo $rw->student->first_name . ' ' . $rw->student->last_name; ?> </abbr>
                                       </td>
                                       <td> <strong><em>ADMIN NO: </em> </strong> <abbr title="Reg No">
                                               <?php echo (!empty($rw->student->old_adm_no)) ? $rw->student->old_adm_no : $rw->student->admission_number; ?> </abbr> </td>                                      
                                       <td> <strong><em>CLASS : </em> </strong>
                                            <?php
                                            $crr = isset($this->classes[$rw->cls->class]) ? $this->classes[$rw->cls->class] : '';
                                            $ctr = isset($streams[$rw->cls->stream]) ? $streams[$rw->cls->stream] : '';
                                            echo $crr . ' ' . $ctr;
                                            ?>
                                       </td> 
                                       <td></td>
                                   </tr>
                                   <?php
                                   $stot = 0;
                                   $ix = 0;
                                   $pvalues = array();
                                   $labels = array();
                                   if (isset($rw->marks))
                                   {
                                        $mks = $rw->marks;
                                        foreach ($mks as $ps)
                                        {
                                             $p = (object) $ps;
                                             if ($p->opt)
                                             {
                                                  $alts[] = $p;
                                             }
                                             else
                                             {
                                                  $ix++;
                                                  $stot += $p->marks;
                                                  $pvalues[] = $p->marks;
                                             }
                                        }
                                   }
                                   ?>
                                   <tr>
                                       <td><strong><em>Class POS:</em> </strong> <?php echo $j; ?></td>
                                       <td>
                                           <strong><em>Out of : </em></strong><?php echo count($payload); ?>
                                           <?php ?>
                                       </td>
                                       <td><strong><em>T.MARKS: </em></strong><?php echo $stot ?></td>
                                       <td>
                                           <strong><em>M.MARK:</strong></em> <?php echo round($stot / $ix); ?>
                                           <?php ?>
                                       </td>
                                   </tr>
                               </table>
                           </div>
                           <table class="table" width="100%">
                               <tr>
                                   <th width='3%'>#</th>
                                   <th width='19%'>SUBJECT</th>
                                   <th>CAT</th>
                                   <th>EXAM</th>
                                   <th>MEAN</th>
                                   <th>GRADE</th>
                                   <th width='33%'> REMARKS</th>
                               </tr>
                               <tbody  id="sort_1">
                                    <?php
                                    $i = 0;
                                    $hol = array();
                                    foreach ($subjects as $kp => $arr)
                                    {
                                         $ob = (object) $arr;
                                         if (isset($ob->units))
                                         {
                                              $hol[$ob->title] = $ob->units;
                                         }
                                    }

                                    $alts = array();
                                    $sm = 0;
                                    if (isset($rw->marks))
                                    {
                                         $mks = $rw->marks;
                                         foreach ($mks as $ps):
                                              $p = (object) $ps;
                                              if ($p->opt)
                                              {
                                                   $alts[] = $p;
                                              }
                                              else
                                              {
                                                   $i++;
                                                   $sm += $p->marks;
                                                   $stitle = '';
                                                   $pos = array();
                                                   if (isset($subjects[$p->subject]))
                                                   {
                                                        $topl = $subjects[$p->subject];
                                                        $gt = (object) $topl;
                                                        $stitle = $gt->title;
                                                        if (isset($gt->units))
                                                        {
                                                             $pos = $gt->units;
                                                        }
                                                   }
                                                   elseif (isset($p->subject))
                                                   {
                                                        $stitle = isset($full[$p->subject]) ? $full[$p->subject] : '-';

                                                        if ($stitle != '-' && isset($hol[$stitle]))
                                                        {
                                                             $pos = $hol[$stitle];
                                                        }
                                                   }
                                                   else
                                                   {
                                                        
                                                   }
                                                   $labels[] = $stitle;
                                                   if (isset($p->units))
                                                   {
                                                        $funits = array_values($p->units);
                                                        $fnl = array_combine($pos, $funits);
                                                        ?>
                                                       <tr>
                                                           <td rowspan="<?php echo count($p->units); ?>"><?php echo $i . '.'; ?></td>
                                                           <td rowspan=""><?php echo $stitle ?></td>
                                                           <?php
                                                           foreach ($fnl as $key => $value)
                                                           {
                                                                ?>
                                                                <td><?php echo $key; ?> 
                                                                <?php
                                                                break;
                                                           }
                                                           ?>
                                                           <td rowspan=""><span class="strong" ><?php echo $p->marks; ?></span></td>
                                                       
                                                       </tr>
                                                       <?php
                                                       $x = 0;
                                                       foreach ($fnl as $key => $value)
                                                       {
                                                            $x++;
                                                            if ($x == 1)
                                                            {
                                                                 continue;
                                                            }
                                                            ?>
                                                            <tr> <td><?php echo $key; ?> </td>  </tr>
                                                            <?php
                                                       }
                                                  }
                                                  else
                                                  {
                                                       ?> <tr class="new">
                                                           <td><?php echo $i . '.'; ?></td>
                                                           <td colspan="">
                                                                <?php
                                                                echo $stitle;
                                                                echo isset($p->units) ? ' TOTAL' : '';
                                                                ?>
                                                           </td>
														    <td>-</td>
                                                           <td><span class="strong" ><?php echo ($p->marks >0) ? $p->marks :'-'; ?></span></td>
                                                          <td><?php echo ($p->marks >0) ? $p->marks :'-'; ?></td>
                                                          <td>
														   <?php  if($p->marks==0){ echo 'Not Done';}
													  else {$rmks = $this->ion_auth->remarks($exam->grading,$p->marks); echo $grade_title[$rmks->grade];}?>
														  </td>
                                                          <td>
														  <?php  if($p->marks==0){ echo 'Not Done';}
													  else {$rmks = $this->ion_auth->remarks($exam->grading,$p->marks); echo $grades[$rmks->grade];}?>
														  </td>
                                                       </tr>
                                                       <?php
                                                  }
                                                  ?> 
                                                  <?php
                                             }
                                        endforeach;
                                   }
                                   ?>        
                                   <tr class="new">
                                      
                                         <td> </td>
                                       <td class="rightb" colspan="">  <strong>TOTAL:</strong></td>
									    <td> -</td>
                                       <td class="rightb"><strong><?php echo $sm; ?></strong></td>
                                      
                                         <td class="rightb"><strong><?php echo $sm; ?></strong></td>
                                       <td> </td>
                                       <td> </td>
                                   </tr>
                                   <?php
                                   if (count($alts))
                                   {
                                        foreach ($alts as $a)
                                        {
                                             $stio = isset($full[$a->subject]) ? $full[$a->subject] : 'Other';
                                             ?>
                                             <tr>
                                                 <td> </td>
                                                 <td> <strong><?php echo $stio; ?></strong></td>
                                                 <td> <strong><?php echo $a->marks; ?></strong>  </td>
                                                 <td> </td>
                                                 <td>  </td>
                                                 <td></td>
                                                 <td> </td>
                                             </tr>
                                             <?php
                                        }
                                   }
                                   ?>
                               </tbody>
                           </table>
                           <table class="lower" width="100%" border="0">
                               <tr>
                                   <td class="nob">
                                       <div>						 
                                           <div class="foo">
                                               <span style="text-decoration:underline">Teacher's Remarks:</span>
                                               <br>
											   <span><?php echo isset($rw->report['remarks']) && $rw->report['remarks'] != '' ? $rw->report['remarks'] : '<hr style="border-bottom:dotted; white-space: pre;"/>'; ?> </span>
											   <br>
											   <span><?php echo isset($rw->report['remarks']) && $rw->report['remarks'] != '' ? $rw->report['remarks'] : '<hr style="border-bottom:dotted; white-space: pre;"/>'; ?> </span>
											   <br>
                                           </div>
                                           <br>
                                           <br>
										   <span style="text-decoration:underline">Head Teacher’s Remarks:</span>
                                           <hr style="text-decoration: underline; border-bottom:dotted; white-space: pre;"/>
                                           <hr style="text-decoration: underline; border-bottom:dotted; white-space: pre;"/>
                                       </div>
                                   </td>
                                   <?php $div = 'Div' . $j; ?>
                                   <td class="nob" width="60%">
                                       <div class="right"> 
                                           <div id="<?php echo $div; ?>" style="width: 400px; height: 220px;">
                                           </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td class="nob" width="60%">
                                       <div>	<span style="text-decoration:underline">School Closed on:</span>
                                           <br><span><hr style="border-bottom:dotted; white-space: pre;"/></span>
                                           <br><span style="text-decoration:underline">Parent’s Sign:</span>
                                           <hr style="border-bottom:dotted; white-space: pre;"/>
                                       </div>
                                   </td>
                                   <td class="nob">
                                       <div>						 
                                          <span style="text-decoration:underline">Next Term begins on:</span>
                                           <br><span><hr style="border-bottom:dotted; white-space: pre;"/></span>
                                           <br><span style="text-decoration:underline">Date:</span>
                                          <hr style="border-bottom:dotted; white-space: pre;"/>
                                       </div>
                                   </td>
                               </tr>
                           </table>
                       </div>
                       <script>
                            $(document).ready(function ()
                            {
                                 var data = [{
                                           values:<?php echo json_encode($pvalues);?>,// [19, 26, 55],
                                           labels: <?php echo json_encode($labels);?>,//['Residential', 'Non-Residential', 'Utility'],
                                           type: 'pie'
                                      }];
                                 var layout = {
                                      height: 220,
                                      width: 400,
                                      margin: {l: 2, t: 0, b: 0}
                                 };
                                 Plotly.newPlot(<?php echo $div; ?>, data, layout, {displayModeBar: false});
                            });
                       </script>
                       <?php
                  }
                  else
                  {
                       ?>
                       <div class="slip">
                           <div class="row-fluid center"> 
                               <table class="lethead" >
                                    <?php
                                    $file = FCPATH . '/uploads/report.png';
                                    if (file_exists($file))
                                    {
                                         ?>
                                        <tr>
                                            <td colspan="2">
                                                <img src="<?php echo base_url('uploads/report.png'); ?>" class="left" />
                                                <p class="redtop">REPORT FORM</p>
                                            </td>
                                        </tr>
                                        <?php
                                   }
                                   else
                                   {
                                        ?>
                                        <tr width="100%">
                                            <td class="toppa">
                                                <span class="stitle"><?php echo strtoupper($this->school->school); ?></span>
                                            </td>
                                            <td class="toppa">
                                                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="80" />
                                                <div style="clear: right"> </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tocent" >
                                                <span class="centre"><?php echo nl2br($this->school->postal_addr); ?></span>
                                                <p class="celll"><?php echo $this->school->cell; ?></p>
                                                <p class="redtop">REPORT FORM</p>
                                            </td>
                                        </tr>
                                   <?php } ?>                            
                               </table>
                           </div>
                           <div class="row-fluid">
                               <table class="topdets">
                                   <tr>
                                       <td><strong>Name : </strong>
                                           <abbr><?php echo $rw->student->first_name . ' ' . $rw->student->last_name; ?> </abbr>
                                       </td>
                                       <td> <strong>Term : </strong> <abbr title="Term"><?php echo $exam->term; ?></abbr>
                                       </td>
                                       <td><strong>Year : </strong> <abbr title="Year"><?php echo $exam->year; ?></abbr> 
                                       </td>
                                       <td><strong>ADM No : </strong>
                                           <abbr title="ADM No."><?php
                                                echo (!empty($rw->student->old_adm_no)) ? $rw->student->old_adm_no : $rw->student->admission_number;
                                                ?>
                                           </abbr>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td><strong>Class : </strong>
                                           <abbr title="Class"><?php
                                                $crr = isset($this->classes[$rw->cls->class]) ? $this->classes[$rw->cls->class] : '';
                                                $ctr = isset($streams[$rw->cls->stream]) ? $streams[$rw->cls->stream] : '';
                                                echo $crr . ' ' . $ctr;
                                                ?></abbr>
                                       </td>
                                       <td> <strong>Age : </strong> <abbr title="Age">
                                                 <?php
                                                 echo (!empty($rw->student->dob)) ? $this->dates->createFromTimeStamp($rw->student->dob)->age : '-';
                                                 ?></abbr>
                                       </td>
                                       <td><strong>Exam : </strong> <abbr title="Exam"><?php echo $exam->title; ?></abbr> 
                                       </td>
                                       <td> <strong>Class Teacher : </strong>
                                           <abbr title="Class Teacher"><?php
                                                $cc = '';
                                                if (!empty($rw->cls->class_teacher))
                                                {
                                                     $ctc = $this->ion_auth->get_user($rw->cls->class_teacher);
                                                     if ($ctc)
                                                     {
                                                          $cc = $ctc->first_name . ' ' . $ctc->last_name;
                                                     }
                                                }
                                                echo $cc;
                                                ?></abbr>
                                       </td>
                                   </tr>

                               </table>
                           </div>
                           <table class="ptable" width="100%">
                               <tr>
                                   <th width='3%'>#</th>
                                   <th>SUBJECT</th>
                                   <th colspan="3">SCORE</th>
                                   <th>%</th>
                                   <th> REMARKS</th>
                               </tr>
                               <tbody  id="sort_1">
                                    <?php
                                    $i = 0;
                                    $hol = array();
                                    foreach ($subjects as $kp => $arr)
                                    {
                                         $ob = (object) $arr;
                                         if (isset($ob->units))
                                         {
                                              $hol[$ob->title] = $ob->units;
                                         }
                                    }

                                    $alts = array();
                                    $sm = 0;
                                    if (isset($rw->marks))
                                    {
                                         $mks = $rw->marks;
                                         foreach ($mks as $ps):
                                              $p = (object) $ps;
                                              if ($p->opt)
                                              {
                                                   $alts[] = $p;
                                              }
                                              else
                                              {
                                                   $i++;
                                                   $sm += $p->marks;
                                                   $stitle = '';
                                                   $pos = array();
                                                   if (isset($subjects[$p->subject]))
                                                   {
                                                        $topl = $subjects[$p->subject];
                                                        $gt = (object) $topl;
                                                        $stitle = $gt->title;
                                                        if (isset($gt->units))
                                                        {
                                                             $pos = $gt->units;
                                                        }
                                                   }
                                                   elseif (isset($p->subject))
                                                   {
                                                        $stitle = isset($full[$p->subject]) ? $full[$p->subject] : '-';

                                                        if ($stitle != '-' && isset($hol[$stitle]))
                                                        {
                                                             $pos = $hol[$stitle];
                                                        }
                                                   }
                                                   else
                                                   {
                                                        
                                                   }

                                                   if (isset($p->units))
                                                   {
                                                        $funits = array_values($p->units);
                                                        $fnl = array_combine($pos, $funits);
                                                        ?>
                                                       <tr>
                                                           <td rowspan="<?php echo count($p->units); ?>"><?php echo $i . '.'; ?></td>
                                                           <td rowspan="<?php echo count($p->units); ?>"><?php echo $stitle ?></td>
                                                           <?php
                                                           foreach ($fnl as $key => $value)
                                                           {
                                                                ?>
                                                                <td><?php echo $key; ?> </td> <td> <?php echo $value; ?> </td> <td> </td>
                                                                <?php
                                                                break;
                                                           }
                                                           ?>
                                                           <td rowspan="<?php echo count($p->units); ?>"><span class="strong" ><?php echo $p->marks; ?></span></td>
                                                           <td> </td>
                                                       </tr>
                                                       <?php
                                                       $x = 0;
                                                       foreach ($fnl as $key => $value)
                                                       {
                                                            $x++;
                                                            if ($x == 1)
                                                            {
                                                                 continue;
                                                            }
                                                            ?>
                                                            <tr> <td><?php echo $key; ?> </td> 
															<td> <?php echo $value; ?> </td>
															<td> </td>
															<td> </td> 
															</tr>
                                                            <?php
                                                       }
                                                  }
                                                  else
                                                  {
                                                       ?> <tr class="new">
                                                           <td><?php echo $i . '.'; ?></td>
                                                           <td colspan="4">
                                                                <?php
                                                                echo $stitle;
                                                                echo isset($p->units) ? ' TOTAL' : '';
                                                                ?>
                                                           </td>
                                                           <td><span class="strong" ><?php echo $p->marks; ?></span></td>
                                                           <td> </td>
                                                       </tr>
                                                       <?php
                                                  }
                                                  ?> 
                                                  <?php
                                             }
                                        endforeach;
                                   }
                                   ?>        
                                   <tr class="new">
                                       <td> </td>
                                       <td> </td>
                                       <td> </td>
                                       <td> </td>
                                       <td class="rightb">  <strong>Total:</strong></td>
                                       <td class="rightb"><strong><?php echo $sm; ?></strong></td>
                                       <td> </td>
                                   </tr>
                                   <?php
                                   if (count($alts))
                                   {
                                        foreach ($alts as $a)
                                        {
                                             $stio = isset($full[$a->subject]) ? $full[$a->subject] : 'Other';
                                             ?>
                                             <tr>
                                                 <td> </td>
                                                 <td> <strong><?php echo $stio; ?></strong></td>
                                                 <td> <strong><?php echo $a->marks; ?></strong>  </td>
                                                 <td> </td>
                                                 <td>  </td>
                                                 <td></td>
                                                 <td> </td>
                                             </tr>
                                             <?php
                                        }
                                   }
                                   ?>
                                   <tr>
                                       <td> </td>
                                       <td> </td>
                                       <td class="rttb"> <strong>POSITION:</strong></td>
                                       <td class="bltop"> <strong><?php echo $j; ?></strong>  </td>
                                       <td></td>
                                       <td class="rttb"> <strong>Out of:</strong></td>
                                       <td class="bltop"> <?php echo count($payload); ?></td>
                                   </tr>
                               </tbody>
                           </table>

                           <table class="lower" width="100%" border="0">
                               <tr>
                                   <td class="nob" width="60%">
                                       <div>						 
                                           <div class="foo"> </div>
                                           <div class="foo">
                                               <strong><span style="text-decoration:underline">Teacher's Remarks:</span></strong>
                                               <br><span><?php echo isset($rw->report['remarks']) && $rw->report['remarks'] != '' ? $rw->report['remarks'] : '<hr style="border-top: 2px dotted black"/>'; ?> </span>
                                           </div>
                                           <strong><span style="text-decoration:underline">Additional Remarks:</span></strong>
                                           <hr style="border-top: 2px dotted black"/>
                                       </div>
                                   </td>
                                   <td class="nob">
                                       <div class="right">  
                                           <br>
                                           <?php
                                           if (!empty($grading))
                                           {
                                                ?>
                                                <strong style="font-size:.8em"><?php echo $grading->title; ?> <br>
                                                    Pass Mark: <?php echo $grading->pass_mark; ?> </strong>
                                           <?php } ?> </div>
                                   </td></tr>
                           </table>

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
                  <?php } ?>
                  <?php
             }
        }
        else
        {//single
             if (isset($report) && !empty($report))
             {
                  ?>
                  <div class="slip ">
                      <div class="row-fluid center"> 
                          <table class="lethead" >
                               <?php
                               $file = FCPATH . '/uploads/report.png';
                               if (file_exists($file))
                               {
                                    ?>
                                   <tr>
                                       <td colspan="2">
                                           <img src="<?php echo base_url('uploads/report.png'); ?>" class="left" />
                                           <p class="redtop">REPORT FORM</p>
                                       </td>
                                   </tr>
                                   <?php
                              }
                              else
                              {
                                   ?>
                                   <tr width="100%">
                                       <td class="toppa">
                                           <span class="stitle"><?php echo strtoupper($this->school->school); ?></span>
                                       </td>
                                       <td class="toppa">
                                           <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="80" />
                                           <div style="clear: right"> </div> 
                                       </td>
                                   </tr>
                                   <tr>
                                       <td class="tocent" >
                                           <span class="centre"><?php echo nl2br($this->school->postal_addr); ?></span>
                                           <p class="celll"><?php echo $this->school->cell; ?></p>
                                           <p class="redtop">REPORT FORM</p>
                                       </td>
                                   </tr>
                              <?php } ?>                            
                          </table>
                      </div>
                      <div class="row-fluid">
                          <table class="topdets">
                              <tr>
                                  <td><strong>Name : </strong>
                                      <abbr><?php echo $student->first_name . ' ' . $student->last_name; ?> </abbr>
                                  </td>
                                  <td> <strong>Term : </strong> <abbr title="Term"><?php echo $exam->term; ?></abbr>
                                  </td>
                                  <td><strong>Year : </strong> <abbr title="Year"><?php echo $exam->year; ?></abbr> 
                                  </td>
                                  <td><strong>ADM No : </strong>
                                      <abbr title="ADM No."><?php
                                           echo (!empty($student->old_adm_no)) ? $student->old_adm_no : $student->admission_number;
                                           ?>
                                      </abbr>
                                  </td>
                              </tr>
                              <tr>
                                  <td><strong>Class : </strong>
                                      <abbr title="Class"><?php
                                           $crr = isset($this->classes[$cls->class]) ? $this->classes[$cls->class] : '';
                                           $ctr = isset($streams[$cls->stream]) ? $streams[$cls->stream] : '';
                                           echo $crr . ' ' . $ctr;
                                           ?></abbr>
                                  </td>
                                  <td> <strong>Age : </strong> <abbr title="Age">
                                            <?php
                                            $this->load->library('Dates');
                                            echo (!empty($student->dob)) ? $this->dates->createFromTimeStamp($student->dob)->age : '-';
                                            ?></abbr>
                                  </td>
                                  <td><strong>Exam : </strong> <abbr title="Exam"><?php echo $exam->title; ?></abbr> 
                                  </td>
                                  <td> <strong>Class Teacher : </strong>
                                      <abbr title="Class Teacher"><?php
                                           $cc = '';
                                           if (!empty($cls->class_teacher))
                                           {
                                                $ctc = $this->ion_auth->get_user($cls->class_teacher);
                                                if ($ctc)
                                                {
                                                     $cc = $ctc->first_name . ' ' . $ctc->last_name;
                                                }
                                           }
                                           echo $cc;
                                           ?></abbr>
                                  </td>
                              </tr>

                          </table>
                      </div>
                      <table class="ptable" width="100%"  >
                          <thead>
                              <tr>
                                  <th width='3%'>#</th>
                                  <th>SUBJECT</th>
                                  <th colspan="3">SCORE</th>
                                  <th>%</th>
                                  <th> REMARKS</th>
                              </tr>
                          </thead>
                          <tbody  id="sort_1">
                               <?php
                               $i = 0;
                               $hol = array();
                               foreach ($subjects as $kp => $arr)
                               {
                                    $ob = (object) $arr;
                                    if (isset($ob->units))
                                    {
                                         $hol[$ob->title] = $ob->units;
                                    }
                               }

                               $alts = array();
                               $sm = 0;
                               if ($report && isset($report['marks']))
                               {
                                    $mks = $report['marks'];

                                    foreach ($mks as $ps):
                                         $p = (object) $ps;
                                         if ($p->opt)
                                         {
                                              $alts[] = $p;
                                         }
                                         else
                                         {
                                              $i++;
                                              $sm += $p->marks;
                                              $stitle = '';
                                              $pos = array();
                                              if (isset($subjects[$p->subject]))
                                              {
                                                   $topl = $subjects[$p->subject];
                                                   $gt = (object) $topl;
                                                   $stitle = $gt->title;
                                                   if (isset($gt->units))
                                                   {
                                                        $pos = $gt->units;
                                                   }
                                              }
                                              elseif (isset($p->subject))
                                              {
                                                   $stitle = isset($full[$p->subject]) ? $full[$p->subject] : '-';

                                                   if ($stitle != '-' && isset($hol[$stitle]))
                                                   {
                                                        $pos = $hol[$stitle];
                                                   }
                                              }
                                              else
                                              {
                                                   
                                              }

                                              if (isset($p->units))
                                              {
                                                   $funits = array_values($p->units);
                                                   $fnl = array_combine($pos, $funits);
                                                   ?>
                                                  <tr>
                                                      <td rowspan="<?php echo count($p->units); ?>"><?php echo $i . '.'; ?></td>
                                                      <td rowspan="<?php echo count($p->units); ?>"><?php echo $stitle ?></td>
                                                      <?php
                                                      foreach ($fnl as $key => $value)
                                                      {
                                                           ?>
                                                           <td><?php echo $key; ?> </td> <td> <?php echo $value; ?> </td> <td> </td>
                                                           <?php
                                                           break;
                                                      }
                                                      ?>
                                                      <td rowspan="<?php echo count($p->units); ?>"><span class="strong" ><?php echo $p->marks; ?></span></td>
                                                      <td>  </td>
                                                  </tr>
                                                  <?php
                                                  $x = 0;
                                                  foreach ($fnl as $key => $value)
                                                  {
                                                       $x++;
                                                       if ($x == 1)
                                                       {
                                                            continue;
                                                       }
                                                       ?>
                                                       <tr> <td><?php echo $key; ?> </td> <td> <?php echo $value; ?> </td> <td> </td><td> </td>  </tr>
                                                       <?php
                                                  }
                                             }
                                             else
                                             {
                                                  ?> <tr class="new">
                                                      <td><?php echo $i . '.'; ?></td>
                                                      <td colspan="4">
                                                           <?php
                                                           echo $stitle;
                                                           echo isset($p->units) ? ' TOTAL' : '';
                                                           ?>
                                                      </td>
                                                      <td><span class="strong" ><?php echo $p->marks; ?></span></td>
                                                      <td> </td>
                                                  </tr>
                                                  <?php
                                             }
                                             ?> 
                                             <?php
                                        }
                                   endforeach;
                              }
                              // $total = isset($report['total']) ? $report['total'] : 0;
                              ?>        
                              <tr class="new">
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  <td class="rightb">  <strong>Total:</strong></td>
                                  <td class="rightb"><strong><?php echo $sm; ?></strong></td>
                                  <td> </td>
                              </tr>
                              <?php
                              if (count($alts))
                              {
                                   foreach ($alts as $a)
                                   {
                                        $stio = isset($full[$a->subject]) ? $full[$a->subject] : 'Other';
                                        ?>
                                        <tr>
                                            <td> </td>
                                            <td> <strong><?php echo $stio; ?></strong></td>
                                            <td> <strong><?php echo $a->marks; ?></strong>  </td>
                                            <td> </td>
                                            <td>  </td>
                                            <td></td>
                                            <td> </td>
                                        </tr>
                                        <?php
                                   }
                              }
                              ?>
                          </tbody>
                      </table>

                      <table class="lower" width="100%" border="0"  >
                          <tr><td class="nob" width="60%">
                                  <div>						 
                                      <div class="foo"> </div>
                                      <div class="foo">
                                          <strong><span style="text-decoration:underline">Teacher's Remarks:</span></strong>
                                          <br><span><?php echo isset($report['remarks']) && $report['remarks'] != '' ? $report['remarks'] : '<hr style="border-top: 2px dotted black"/>'; ?> </span>
                                      </div>
                                      <strong><span style="text-decoration:underline">Additional Remarks:</span></strong>
                                      <hr style="border-top: 2px dotted black"/>
                                  </div>
                              </td>
                              <td class="nob">
                                  <div class="right">  
                                      <br>
                                      <?php
                                      if (!empty($grading))
                                      {
                                           ?>
                                           <strong style="font-size:.8em"><?php echo $grading->title; ?> <br>
                                               Pass Mark: <?php echo $grading->pass_mark; ?> </strong>
                                      <?php } ?>
                                  </div>
                              </td></tr>
                      </table>

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
                  <?php
             }
             else
             {
                  ?>

                  <?php
             }
        }
    ?>

</div>

<style>
    .docpg  {
         background: #FFF;
         padding: 8px;          
         min-height: 29.7cm;
         border-radius: 5px;
         margin: 1cm auto;
    }
    .docpg table {
         margin: 5px 0 3px 0;
    }

    .docpg .hpe strong 
    {
         margin-right: 5px;
    }

    .docpg hr{ width: 85%;margin: 9px 0; float:  right;}
    .docpg img
    {
         height:110px;
         margin-left: 25%;
    }  
    .docpg center{ padding: 10px;}
    .col-xs-8{width:66.66666667%;}
    .col-xs-4 
    {
         width: 33.33333333%;
    }
    td.nob{border: 0;}
    .col-xs-6 
    {
         width: 50%;
    }
    .col-xs-3{width:25%}.col-xs-2{width:16.66666667%}
    .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
         float: left;
    }
    .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
         position: relative;
         min-height: 1px;
    }
    @media print
    {
         .docpg  {
              background: #FFF;
              padding: 8px;                                 
              min-height: 26.7cm;              
              border: 0 !important;
              page-break-after: always;

         }  
         .docpg:last-child {
              page-break-after: avoid;
         }
         .docpg center{ padding: 10px;}
         #scrollUp{display: none;}
    }
</style>
<?php
    if ($opt != 1)
    {
         ?>
         <style>
             .amt{text-align: right;}
             .fless{width:100%; border:0;}
             .slip {
                  width: 21cm;
                  min-height: 29.7cm;
                  padding: 2cm;
                  margin: 1cm auto;
                  border: 0 !important;
                  border-radius: 5px;
                  background: white;        
             }  

             .actions{background-color: #fff; padding: 8px}
             .lower{margin-top: 6px;}
             .lethead
             {
                  border: 0;
             } 
             .topdets {
                  width:100%;
                  margin: 0 auto;
                  border: 0;
             }
             .topdets th,  .topdets td ,.topdets 
             {
                  border: 0;
             }
             .toppa img{
                  width:150px;
                  height:80px;
             }
             .toppa{
                  text-align: right;
                  color: #66B0EA;
                  padding-top: 0;
             }
             .toppa span.stitle{font-size: 40.5px; font-family: "Times New Roman", Times, serif; font-weight: bold;}
             .redtop{color: #f00;
                     font-size: 20px;
                     text-decoration: underline;}
             .bltop{color: #0000ff; font-size: 20px;}
             .tocent{text-align: center;}
             .celll{margin: 0;}
             * { margin: 0; padding: 0; border: 0; }
             .slip{ background-color: #fff; }
             .strong{font-weight: bold;}
             .right{text-align: right;}
             .rightb{text-align: right; border-bottom: 3px double #000;}
             .center{text-align: center;}
             .green{color: green;}
             .ptable td, table th {
                  padding: 4px; font-size: 12px;
             }  .nob{border-right:0 !important;}
             @media print{       
                  .slip{
                       width: 21cm;
                       padding: 2cm;
                       min-height: 26.7cm;              
                       border: 0 !important;
                       page-break-after: always;
                  }  
                  .slip:last-child {
                       page-break-after: avoid;
                  }
                  .lethead img {width: 96%;}

                  .toppa img{
                       width:150px;
                       height:80px;
                  }
                  body{background: #fff;font-family: OpenSans;}

                  /**********/
                  .ptable{ border: 1px solid #DDD;
                           border-collapse: collapse; }
                  .ptable td, th {
                       border: 1px solid #ccc;
                  }
                  .ptable th {
                       background-color:  #ccc;
                       text-align: center;
                  }
                  .ptable td.nob{  border:none !important; background-color:#fff !important;}
                  /**********/
                  .navigation{
                       display:none;
                  }
                  .alert{
                       display:none;
                  }
                  .alert-success{
                       display:none;
                  } 
                  .img{
                       align:center !important;
                  } 
                  .print{
                       display:none !important;
                  }
                  .bank{
                       float:right;
                  }
                  .view-title h1{border:none !important; text-align:center }
                  .view-title h3{border:none !important; }

                  .split{
                       float:left;
                  }
                  .right{
                       float:right;
                  }
                  #scrollUp{display:none}
                  .header{display:none}
                  .center, .slip {
                       border: 0;
                       width:100%;
                       margin: 2px !important;
                       padding: 0px !important;
                  }

                  .smf .content {
                       margin-left: 0px;
                  }
             }
         </style>  
         <?php
    }
         