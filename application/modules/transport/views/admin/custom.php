
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Students in Custom Transport</h2> 
    <div class="right">  
        <div class='btn-grdoup'>    
            <?php echo anchor('admin/transport/invoice', '<i class="glyphicon glyphicon-arrow-up"></i> Invoice Students', 'class="btn btn-warning"'); ?> 
            <?php echo anchor('admin/transport', '<i class="glyphicon glyphicon-file"></i> Transport Report', 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/transport/add', '<i class="glyphicon glyphicon-list"></i> Add Students', 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/transport/routes/', '<i class="glyphicon glyphicon-thumbs-up"></i> Routes', 'class="btn btn-success"'); ?>
        </div>
    </div>
</div>
<div class="toolbar">
    <div class="col-md-12"><br/>
        <?php echo form_open(current_url()); ?>
        Zone
        <?php echo form_dropdown('route', array('' => 'All Zones') + $routes, $this->input->post('fee'), 'class ="tsel" '); ?>
        Routes
        <?php echo form_dropdown('stage', array('' => 'All Routes') + $stages, $this->input->post('stage'), 'class ="tsel" '); ?>
        Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $this->streams, $this->input->post('class'), 'class ="tsel" '); ?>
        Term
        <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
        Year 
        <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>
        <button class="btn btn-primary"  type="submit">Submit</button>
        <button class="btn btn-success" name="export"  type="submit" value="2"><i class="glyphicon glyphicon-download-alt"></i>Excel</button>
    <?php echo form_close(); ?>
    </div>
</div>
<div class="block invoice">
    <div class="row">
        <div class="col-md-12">
            <h3>Transport Report </h3>
          
            <hr/>
            <?php if (!empty($payload)): ?>
 
                    <table class="table" width="100%">
                        <thead>
                        <th>#</th>
                        <th>Adm</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Zone</th>
                        <th>Route</th>  
                        <th>Mode</th>    
                        <th>Period</th>   
                        <th>Description</th>
                        </thead>

                        <tbody>
                            <?php
                                $index =1;
                                $stotal = 0;
                                foreach($payload as $p)
                                {
                                    $st = $this->worker->get_student($p->student); 
                                    ?>
                                    <tr>
                                        <td><?php echo $index ?></td>
                                        <td><?php echo $st->admission_number ? $st->admission_number :$st->old_adm_no?></td>
                                        <td><?php echo strtoupper($st->first_name.' '.$st->middle_name.' '.$st->last_name) ?></td>
                                        <td><?php echo isset($this->streams[$st->class]) ? $this->streams[$st->class] : '' ?></td>
                                        <td><?php echo isset($routes[$p->route]) ? $routes[$p->route] : ' - ' ?></td>
                                        <td><?php echo isset($stage[$p->stage]) ? $stage[$p->stage] : ' - ' ?></td>
                                        <td><?php echo ($p->way == 1) ? 'One Way' : 'Two Way' ?></td>
                                        <td>Term <?php echo $p->term.' '.$p->year?></td>
                                        <td>
                                            <table style='border:0 !important;'>
                                                <tr>
                                                    <th><strong>Description</strong></th>
                                                    <th><strong>Created By</strong></th>
                                                    <th><strong>Amount</strong></th>
                                                </tr>
                                                <?php
                                                $cust = isset($custom[$p->student]) ? $custom[$p->student] :  '';
                                                    foreach($cust as $key => $row)
                                                    {
                                                        $t = (object) $row;
                                                        $stotal += $t->amount;
                                                ?>
                                                        <tr>
                                                            <td><?php echo $t->description?></td>
                                                             <td><?php echo $t->created_by ?></td>
                                                            <td><?php echo number_format($t->amount,2)?></td>
                                                           
                                                        </tr>

                                                <?php }?>
                                                <tr>
                                                    <td colspan="3" style="text-align:right">
                                                        <strong>
                                                    <?php echo  number_format((isset($total[$p->student]) ? $total[$p->student] : 0),2) ?>
                                                        </strong>
                                                </td>
                                                </tr>

                                            </table>
                                        </td>

                                    </tr>
                                    <?php
                                    $index++;
                                } ?>
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