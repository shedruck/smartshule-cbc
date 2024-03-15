<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>School Classes</h2> 
    <div class="right">   
    <button class="btn btn-success" onclick="window.location='<?php echo base_url()?>admin/class_attendance/filter_attendance'">Filter Attendance</button>                         
    </div>    					
</div>
<?php if ($post): ?>               
         <div class="block-fluid">
             <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 <th>#</th>
                 <th>Class </th>
                 <th>Registered Students</th>
                 <th>Class Teacher</th>
                 <th><?php echo lang('web_options'); ?></th>
                 </thead>
                 <tbody>
                      <?php 
                      $i = 0;
                      if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                      {  
                           $i = ($this->uri->segment(4) - 1) * $per;
                      }
                      foreach ($post as $p):
                           $i++;
                           $cl = isset($classes[$p->class]) ? $classes[$p->class] : ' ';
                           $st = isset($streams[$p->stream]) ? $streams[$p->stream] : '  ';
                           
                           ?>
                          <tr>
                              <td><?php echo $i . '.'; ?></td>
                              <td><?php echo $cl . ' ' . $st ?></td>
                              <td><?php
                                   if ($p->size == 0)
                                   {
                                        echo '<i style="color:red">No Student Registered</i>';
                                   }
                                   elseif ($p->size == 1)
                                   {
                                        echo $p->size . ' Student';
                                   }
                                   else
                                   {
                                        echo $p->size . ' Students';
                                   }
                                   ?></td>
                              <td><?php //echo $user->first_name . ' ' . $user->last_name;       ?></td>
                              <td width="330" style="text-align:center">
                                   <?php if ($p->size == 0): ?>
                                       <a href="<?php echo site_url('admin/admission/create/'); ?>" > Register New Student</a>	
                                  <?php else: ?>
                                       <a href="<?php echo site_url('admin/class_attendance/create/' . $p->id); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> New Attendance</a>	
                                       <?php if (empty($p->checks)): ?>
                                       <?php else: ?>
                                            <a href="<?php echo site_url('admin/class_attendance/list_attendance/' . $p->id); ?>" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i> View Attendance</a>
                                       <?php endif; ?>
                                  <?php endif; ?>
                              </td>
                          </tr>
                     <?php endforeach ?>
                 </tbody>
             </table>
         </div>
    <?php else: ?>
         <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                              <?php endif ?>