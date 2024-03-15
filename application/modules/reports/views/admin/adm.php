<div class="head">
    <div class="icon">
        <span class="icosg-target1"></span></div>
    <h2>Admission Report</h2>
    <div class="right">                       
    </div>    					
</div>

<div class="toolbar">
    <div class="noof">
         <?php echo form_open(current_url()); ?>
        <fieldset>
            Name<input type="checkbox" name="cols[sname]" value="1"/>
            Class<input type="checkbox" name="cols[class]" value="1"/>
            Adm.<input type="checkbox" name="cols[adm]" value="1"/>
            DoB<input type="checkbox" name="cols[dob]" value="1"/>
            House<input type="checkbox" name="cols[hse]" value="1"/>
            Parent<input type="checkbox" name="cols[par]" value="1"/>
            Tel<input type="checkbox" name="cols[tel]" value="1"/>
        </fieldset>
        Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $this->classes, $this->input->post('class'), 'class ="tsel" '); ?>
        Year 
        <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>
        <button class="btn btn-primary"  type="submit">View Report</button>
        <div class="pull-right"> 
            <a href="" onClick="window.print();
                      return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="block invoice">
    <h1> </h1>

    <div class="row">
        <div class="col-md-10">
             <?php
                 $ystr = '';
                 $cstr = '';
                 if ($year)
                 {
                      $ystr = ' -  ' . $year;
                 }
                 if ($class)
                 {
                      $cstr = isset($this->classes[$class]) ? $this->classes[$class] : ' ';
                 }
             ?>
            <h3> <?php echo $this->school->school; ?> <?php echo $cstr . ' ' . $ystr; ?> Students</h3>
        </div>

    </div>
    <?php
        if (!empty($cols))
        {
             ?>
             <table cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                     <tr>
                         <th width="3%">#</th>
                         <?php
                         if (isset($cols['sname']))
                         {
                              ?>
                              <th width="20%">Name</th>
                              <?php
                         } if (isset($cols['class']))
                         {
                              ?>
                              <th width="10%">Class</th>
                              <?php
                         } if (isset($cols['adm']))
                         {
                              ?>
                              <th width="11%">ADM</th>
                              <?php
                         } if (isset($cols['dob']))
                         {
                              ?>
                              <th width="11%">D.o.B</th>
                              <?php
                         } if (isset($cols['hse']))
                         {
                              ?>
                              <th width="15%">House</th>
                              <?php
                         } if (isset($cols['par']))
                         {
                              ?>
                              <th width="20%">Parent</th>
                              <?php
                         }
                         if (isset($cols['tel']))
                         {
                              ?>
                              <th width="10%">Parent Tel.</th>
                         <?php } ?>
                     </tr>
                 </thead>
                 <tbody>
                      <?php
                      ksort($adm);

                      $i = 0;
                      $s = 0;

                      foreach ($adm as $kl => $strpecs)
                      {
                           $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
                           ?>
                          <tr>
                              <td> </td>
                              <td colspan="<?php echo count($cols); ?>"><strong><?php echo $cname; ?>  </strong></td>
                          </tr>
                          <?php
                          foreach ($strpecs as $str => $kids)
                          {
                               foreach ($kids as $kid)
                               {
                                    $kstr = isset($str_opts[$str]) ? $str_opts[$str] : ' ';
                                    $i++;
                                    $s++;
                                    $stu = $this->worker->get_student($kid->student);
                                    ?> 
                                    <tr>
                                        <td><?php echo $i . '. '; ?></td>
                                        <?php
                                        if (isset($cols['sname']))
                                        {
                                             ?>
                                             <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?></td>
                                             <?php
                                        }
                                        if (isset($cols['class']))
                                        {
                                             ?>
                                             <td><?php echo $cname . ' ' . $kstr; ?></td>
                                             <?php
                                        } if (isset($cols['adm']))
                                        {
                                             ?>
                                             <td><?php echo $kid->old_adm_no ? $kid->old_adm_no : $kid->admission_number; ?> </td>
                                             <?php
                                        } if (isset($cols['dob']))
                                        {
                                             ?><td> <?php echo $kid->dob > 10000 ? date('d M Y', $kid->dob) : ''; ?></td>
                                             <?php
                                        } if (isset($cols['hse']))
                                        {
                                             ?> <td> <?php echo isset($houses[$kid->house]) ? $houses[$kid->house] : ' - '; ?></td>
                                             <?php
                                        }
                                        if (isset($cols['par']))
                                        {
                                             ?> <td> <?php echo $kid->parent_fname . ' ' . $kid->parent_lname; ?></td>
                                             <?php
                                        }
                                        if (isset($cols['tel']))
                                        {
                                             ?><td><?php echo $kid->phone; ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                               }
                          }
                          ?> <tr>
                              <td colspan="<?php echo count($cols) + 1; ?>"> &nbsp;</td>
                          </tr>
                          <?php
                          $i = 0;
                     }
                     ?>
                     <tr>
                         <td> </td>
                         <td> </td>
                         <td colspan="<?php echo count($cols) - 1; ?>" ><strong>Total Students:<?php echo number_format($s); ?></strong></td>
                     </tr>
                     <tr>
                         <td> </td>
                         <td> </td>
                         <td colspan="<?php echo count($cols) - 1; ?>"> &nbsp;</td>
                     </tr>

                 </tbody>
             </table><?php
        }
        else
        {
             ?>
             <table cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                     <tr>
                         <th width="3%">#</th>
                         <th width="20%">Name</th>
                         <th width="10%">Class</th>
                         <th width="11%">ADM</th>
                         <th width="11%">D.o.B</th>
                         <th width="15%">House</th>
                         <th width="20%">Parent</th>
                         <th width="10%">Parent Tel.</th>
                     </tr>
                 </thead>
                 <tbody>
                      <?php
                      ksort($adm);

                      $i = 0;
                      $s = 0;

                      foreach ($adm as $kl => $strpecs)
                      {
                           $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
                           ?>
                          <tr>
                              <td> </td>
                              <td colspan="7"><strong><?php echo $cname; ?>  </strong></td>
                          </tr>
                          <?php
                          foreach ($strpecs as $str => $kids)
                          {
                               foreach ($kids as $kid)
                               {
                                    $kstr = isset($str_opts[$str]) ? $str_opts[$str] : ' ';
                                    $i++;
                                    $s++;
                                    $stu = $this->worker->get_student($kid->student);
                                    ?> 
                                    <tr>
                                        <td><?php echo $i . '. '; ?></td>
                                        <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?></td>
                                        <td><?php echo $cname . ' ' . $kstr; ?></td>
                                        <td><?php echo $kid->old_adm_no ? $kid->old_adm_no : $kid->admission_number; ?> </td>
                                        <td> <?php echo $kid->dob > 10000 ? date('d M Y', $kid->dob) : ''; ?></td>
                                        <td> <?php echo isset($houses[$kid->house]) ? $houses[$kid->house] : ' - '; ?></td>
                                        <td> <?php echo $kid->parent_fname . ' ' . $kid->parent_lname; ?></td>
                                        <td><?php echo $kid->phone; ?></td>
                                    </tr>
                                    <?php
                               }
                          }
                          ?> <tr>
                              <td colspan="8"> &nbsp;</td>
                          </tr>
                          <?php
                          $i = 0;
                     }
                     ?>
                     <tr>
                         <td> </td>
                         <td> </td>
                         <td colspan="4" ><strong>Total Students:<?php echo number_format($s); ?></strong></td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                     </tr>
                     <tr>
                         <td colspan="5"> </td>
                         <td>&nbsp; </td>
                         <td>&nbsp; </td>
                         <td></td>
                     </tr>

                 </tbody>
             </table>
        <?php } ?>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>

<script>
     $(document).ready(
             function ()
             {
                  $(".tsel").select2({'placeholder': 'Please Select', 'width': '140px'});
                  $(".tsel").on("change", function (e) {

                       notify('Select', 'Value changed: ' + e.added.text);
                  });

                  $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                  $(".fsel").on("change", function (e) {
                       notify('Select', 'Value changed: ' + e.added.text);
                  });
             });
</script>