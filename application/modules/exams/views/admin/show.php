<?php
    if (!$proc)
    {
         echo 'Marks Not Found';
         exit();
    }
    $settings = $this->ion_auth->settings();
?>
<div class="slip ">
    <div class="row"> 
        <div class="pull-right print">
            <button onClick="window.print();
                      return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
        </div>
    </div>

    <div class="clear"></div>
    <div class="row center"> 
        <table class="lethead">
            <tr>
                <td class="toppa center" width="100%">
                    <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="80" />
                    <br>
                    <span class="stitle"><?php echo strtoupper($this->school->school); ?></span>
                </td>

            </tr>
            <tr>
                <td class="tocent" >
                    <span class="centre"><?php echo nl2br($this->school->postal_addr); ?></span>
                    <p class="celll"><?php echo $this->school->cell; ?></p>
                    <p class="redtop">REPORT FORM</p>
                </td>
            </tr>
        </table>
    </div>
    <div class="row">
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
                 if ($report && isset($report['marks']) && isset($report['total']))
                 {
                      $mks = $report['marks'];

                      foreach ($mks as $ps):
                           $p = (object) $ps;
                           if ($p->opt==1)
                           {
                                $alts[] = $p;
                           }
                           else
                           {
                                $i++;
                                $sm+=$p->marks;
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
                                        <td class="right" rowspan="<?php echo count($p->units); ?>"><span class="strong" ><?php echo $p->marks; ?></span></td>
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
                                        <td class="right"><span class="strong" ><?php echo $p->marks; ?></span></td>
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
                              <td class="right"> <strong><?php echo $a->marks; ?></strong>  </td>
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
                    <div class="foo">

                    </div>
                    <div class="foo">
                        <strong><span style="text-decoration:underline">Teacher's Remarks:</span></strong>
                        <br><span class="green"><?php echo isset($report['remarks']) && $report['remarks'] != '' ? $report['remarks'] : '<hr style="border-top: 2px dotted black"/>'; ?> </span>
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
                 if (!empty($settings->tel))
                 {
                      echo $settings->postal_addr . ' Tel:' . $settings->tel . ' ' . $settings->cell;
                 }
                 else
                 {
                      echo $settings->postal_addr . ' Cell:' . $settings->cell;
                 }
             ?></span>
    </div>

</div>

<style>
    .lower{margin-top: 6px;}
    .lethead th,  .lethead td ,.lethead 
    {
         margin: 0 auto;
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
         height:100px;
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
    .tocent{text-align: center;}
    .celll{margin: 0;}
    * { margin: 0; padding: 0; border: 0; }
    .slip{ background-color: #fff; }
    .strong{font-weight: bold;}
    .right{text-align: right;}
    .rightb{text-align: right; border-bottom: 3px double #000;}
    .center{text-align: center;}
    .green{color: green;}
    table td, table th {
         padding: 4px; font-size: 12px;
    }  .nob{border-right:0 !important;}
    @media print{
         body{background: #fff;font-family: OpenSans;}

         /**********/
         .ptable{ border: 1px solid #DDD;
                  border-collapse: collapse; }
         td, th {
              border: 1px solid #ccc;
         }
         th {
              background-color:  #ccc;
              text-align: center;
         }
         td.nob{  border:none !important; background-color:#fff !important;}
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
         .header{display:none}
         .center, .slip {
              width:100%;
              margin: 15px !important;
              padding: 0px !important;
         }

         .smf .content {
              margin-left: 0px;
         }

    }
</style>     