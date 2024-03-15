<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h3> Grading  Systems <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a></h3> 
      <hr>                   
 
       
     					
</div>
<?php if ($grading): ?>               
        <div class="block-fluid">
           <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                <th width="3">#</th>
                <th>Grading System</th>
                <th>Modified On</th>	
                <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }

                    foreach ($grading as $p):
                            $user = $this->ion_auth->get_user($p->created_by);
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $grading_system[$p->grading_system]; ?></td>

                              
                                <td><?php echo date('d/m/Y', $p->created_on); ?></td>
                                <td width="285px">
                                    <?php echo anchor('st/view_grades/' . $p->id, '<i class="fa  fa-share"></i> View Grades', 'class="btn btn-primary"'); ?>
                                  
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>



<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
         <?php endif ?>