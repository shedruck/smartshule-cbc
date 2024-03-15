
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Discounted Students</h2> 
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
        <?php echo form_dropdown('group', array('' => 'Discount Groups') + $groups, $this->input->post('group'), 'class ="tsel" '); ?>

        Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $this->streams, $this->input->post('class'), 'class ="tsel" '); ?>
        
        <button class="btn btn-primary"  type="submit">Submit</button>
        <!-- <button class="btn btn-success" name="export"  type="submit" value="2"><i class="glyphicon glyphicon-download-alt"></i>Excel</button> -->
    <?php echo form_close(); ?>
    </div>
</div>


<div class="block invoice">
    <div class="row">
        <div class="col-md-12">
            <h3>Discounted Students </h3>
            <hr/>
            <?php if (!empty($res)): ?>
                    <table class="table" width="100%">
                        <thead>
                        <th>#</th>
                        <th>Adm</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Group</th>
                        <th>Percentage</th>  
                        <th>Status</th> 
                        <th>Action</th>   
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $url = base_url();
                            foreach ($res as $r):
                                    $i++;
                                    $std = $this->worker->get_student($r->student);
                                    $st = [1 => '<span class="label label-success">Active</span>',2 => '<span class="label label-warning">Inactive</span>'];

                                   

                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>
                                        <td><?php echo $std->admission_number ? $std->admission_number : $std->old_adm_no ?></td>
                                        <td><?php echo strtoupper($std->first_name.' '.$std->middle_name.' '.$std->last_name); ?></td>
                                        <td><?php echo isset($this->streams[$std->class]) ? $this->streams[$std->class] : ''; ?></td>
                                        <td><?php echo isset($groups[$r->discount_id]) ? $groups[$r->discount_id] : ' - '; ?></td>
                                        <td><?php echo $r->percentage ?> %</td>
                                         <td><?php echo isset($st[$r->status]) ? $st[$r->status] : ' - '; ?></td>
                                         <td> <?php
                                                if($r->status ==1){?>
                                                    <a href="<?php echo base_url('admin/discounts/change_status/disable/'.$r->id)?>" class="btn btn-danger" onClick="return confirm('<?php echo 'Are you sure ?';?>')">Disable</a>
                                                <?php 
                                            }else
                                                { ?>
                                                    <a href="<?php echo base_url('admin/discounts/change_status/activate/'.$r->id)?>" class="btn btn-success" onClick="return confirm('<?php echo 'Are you sure ?';?>')">Activate</a>
                                               <?php } ?>
                                            
                                        </td>
                                          
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