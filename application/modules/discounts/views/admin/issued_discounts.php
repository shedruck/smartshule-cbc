
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Discounts</h2> 
    <div class="right">  
        <div class='btn-grdoup'>    
           
            <?php echo anchor('admin/discounts/assign_groups', '<i class="glyphicon glyphicon-plus"></i> Add Students', 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/discounts', '<i class="glyphicon glyphicon-list"></i> Discount Groups', 'class="btn btn-success"'); ?> 
        </div>
    </div>
</div>

<div class="toolbar">
    <div class="col-md-12"><br/>
        <?php echo form_open(current_url()); ?>
        Group
        <?php echo form_dropdown('group', array('' => 'Discount Groups') + $list, $this->input->post('group'), 'class ="tsel" '); ?>

        Term
        <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="tsel" '); ?>

        Year
        <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="tsel" '); ?>
        
        <button class="btn btn-primary"  type="submit">Submit</button>
        <!-- <button class="btn btn-success" name="export"  type="submit" value="2"><i class="glyphicon glyphicon-download-alt"></i>Excel</button> -->
    <?php echo form_close(); ?>
    </div>
</div>


<div class="block invoice">
    <div class="row">
        <div class="col-md-12">
            <h3>
             <?php  if($this->input->post()){

                $term = $this->input->post('term');
                $year = $this->input->post('year');
                $group = $this->input->post('group');

                if($group)
                {
                    $grp = isset($list[$group]) ? $list[$group] : '';
                    $gp = str_replace('discounts',' ',$grp);
                    echo  strtoupper($gp.' DISCOUNTS ');
                }

                if($term && !$year)
                {
                    echo ' FOR TERM '.$term;
                }

                if($year && !$term)
                {
                    echo ' FOR '.$year;
                }


                if($term && $year)
                {
                    echo 'FOR TERM '.$term.' '.$year; 
                }
                ?> 


             <?php } else { echo 'DISCOUNTS'; }?>
         </h3>
            <hr/>
            <?php if (!empty($discounts)): ?>
                    <table class="table" width="100%">
                        <thead>
                        <th>#</th>
                        <th>Adm</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Group</th>
                        <th>Percentage</th>  
                        <th>Invoiced Amt</th> 
                        <th>Discounted Amt</th> 
                        <th>Term</th> 
                        <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($discounts as $r):
                                    $i++;
                                    $p = (object)$r;
                                    
                                   

                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>
                                        <td><?php echo $p->adm?></td>
                                        <td><?php echo $p->student?></td>
                                        <td><?php echo $p->class?></td>
                                        <td><?php echo $p->group?></td>
                                        <td><?php echo $p->percentage?>%</td>
                                        <td><?php echo number_format($p->total,2)?></td>
                                        <td><?php echo number_format($p->amount,2)?></td>
                                        <td>Term <?php echo $p->term.' '.$p->year?></td>
                                        <td><a class="btn btn-sm btn-danger" onClick="return confirm('<?php echo 'Are you sure to void selected item ?';?>')" href="<?php echo base_url('admin/discounts/void/'.$p->id)?>">Void</a></td>
                                          
                            <?php endforeach ?>
                        </tbody>
                    </table>

            <?php else: ?>
                    <p class='text'>No Results Found</p>
            <?php endif ?>
        </div>
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