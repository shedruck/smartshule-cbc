
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Students in Transport</h2> 
    <div class="right">  
        <div class='btn-grdoup'>    
            <?php echo anchor('admin/transport/invoice', '<i class="glyphicon glyphicon-arrow-up"></i> Invoice Students', 'class="btn btn-warning"'); ?> 
            <?php echo anchor('admin/transport/custom_transport', '<i class="glyphicon glyphicon-file"></i> Custom Students', 'class="btn btn-primary"'); ?> 
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
        <?php echo form_dropdown('class', array('' => 'Select Class') + $classes, $this->input->post('class'), 'class ="tsel" '); ?>
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
            <?php if (!empty($res)): ?>
                    <table class="table" width="100%">
                        <thead>
                        <th>#</th>
                        <th>Adm</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Zone</th>
                        <th>Route</th>  
                        <th>Mode</th>    
                        <th>Amount</th> 
                        <th>Term</th>   
                        <th>Year</th>   
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($res as $r):
                                if($r->custom == 0 || empty($r->custom))
                                {
                                    $i++;
                                    $rtt = $amounts[$r->route];
                                    $am = '';
                                    $tt = "";
                                    if($r->way == 1)
                                    {
                                        $tt = "One Way";
                                        // $am = $rtt['one_way_charge'];
                                    }
                                    elseif($r->way == 2)
                                    {
                                        $tt = "Two Way";
                                        // $am = $rtt['two_way_charge'];
                                    }
                                     
                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>
                                        <td><?php echo $r->adm?></td>                   
                                        <td><?php echo $r->student; ?></td>
                                        <td><?php echo $r->class; ?></td>
                                        <td><?php echo isset($routes[$r->route]) ? $routes[$r->route] : ' - '; ?></td>
                                        <td><?php echo isset($stages[$r->stage]) ? $stages[$r->stage] : '-' ; ?></td>
                                        <td><?php echo $tt ?></td>
                                        <td><?php echo number_format($r->amount, 2) ?></td>
                                        <td>Term <?php echo $r->term; ?></td>
                                        <td><?php echo $r->year; ?></td>
                                    </tr>
                            <?php  } endforeach ?>
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