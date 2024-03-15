<div class="col-md-12">
    <div class="head ruti" hidden>
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>  Transport Routes </h2> 
        <div class="right">
           <button class="btn btn-primary cancel"><i class="glyphicon glyphicon-circle-arrow-left"></i> Go Back</button>
            <!-- <?php echo anchor('admin/transport/', '<i class="glyphicon glyphicon-circle-arrow-left"></i> Go Back', 'class="btn btn-primary cancel"'); ?>             -->
        </div>					
    </div>
    <div class="block-fluid">
        <?php if($this->uri->segment(3) =="edit_route"){ ?>
        <div class="widget col-md-6 ruti">
            <?php }else{?>
                <div class="widget col-md-6 ruti" hidden>
            <?php }?>
            <?php
            if ($this->uri->segment(3) !== 'students')
            {
                    ?>
                    <div class="head black" >
                        <div class="icon"><span class="icosg-list "></span></div>
                        <h2>New Route</h2>
                    </div>
                    <div class="block-fluid">
                        <?php echo form_open(current_url(), 'class=""'); ?>
                        <div class="form-group">
                            <div class="col-md-3">Name:</div>
                            <div class="col-md-9">                                      
                                <?php echo form_input('name', isset($result->name) ? $result->name : '', 'id="title_1"  placeholder="Name"'); ?>
                                <?php echo form_error('name'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3">One Way Charge:</div>
                            <div class="col-md-9">                                      
                                <?php echo form_input('one_way_charge', isset($result->one_way_charge) ? $result->one_way_charge : '', 'id="title_1"  placeholder="One way charge"'); ?>
                                <?php echo form_error('one_way_charge'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3">Two Way Charge:</div>
                            <div class="col-md-9">                                      
                                <?php echo form_input('two_way_charge', isset($result->one_way_charge) ? $result->two_way_charge : '', 'id="title_1"  placeholder="Two way charge"'); ?>
                                <?php echo form_error('two_way_charge'); ?>
                            </div>
                        </div>
                            <div class="col-md-3"> 
                                <button type="submit" class="btn btn-primary">Save</button>
                                
                                <?php if($this->uri->segment(3) =="edit_route"){ ?>
                                    <button type="button" class="btn btn-primary" onClick="window.history.back()">Cancel</button>
                                    <?php }else{?>
                                        <button type="button" class="btn btn-primary cancel">Cancel</button>
                                    <?php }?>
                        </div>
                        </div>

                        <?php echo form_close(); ?> 
                    </div>
            <?php } ?>
        </div> 
        <div class="clearfix"></div>
        <?php
        if (isset($routes))
        {
                ?>
                <div class="head list_ruti">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Route List</h2> 
                     
                     
                    <div class="right back_btn">
                    <?php
                    if(!isset($students)){
                    ?>
                    <button class="btn btn-success add_route"> <i class="glyphicon glyphicon-plus"></i>Add Routes</button>
                    <?php }?>
            <?php echo anchor('admin/transport/', '<i class="glyphicon glyphicon-circle-arrow-left"></i> Go Back', 'class="btn btn-primary"'); ?>            
        </div>
                </div>        
                <table cellpadding="0" cellspacing="0" width="100%" class="list_ruti">
                    <!-- BEGIN -->
                    <thead>
                        <tr role="row">
                            <th width="3%">#</th>
                            <th>Name</th>
                            <th>One Way Charge</th>
                            <th>Two Way Charge</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($routes as $r):
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>	
                                    <td width="50%"><?php echo $r->name; ?></td>
                                    <td width="25%">Ksh <?php echo number_format($r->one_way_charge,2) ?></td>
                                    <td width="25%">Ksh <?php echo number_format($r->two_way_charge,2) ?></td>
                                    <td >
                                        

                                        <div class="btn-group">
                                        <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action <i class="glyphicon glyphicon-caret-down"></i></button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a  href="<?php echo site_url('admin/transport/stages/' . $r->id); ?>"  > Stages </a></li>
                                            <li><a  href="<?php echo site_url('admin/transport/students/' . $r->id); ?>"  > Students </a></li>
                                            <li> <a  href="<?php echo site_url('admin/transport/edit_route/' . $r->id); ?>"  > Edit </a></li>
                                            <li> <a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/transport/delete_route/' . $r->id); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a></li>
                                        </ul>
                                    </div>
                                    </td>
                                </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
        <?php } ?>
        <div class="clearfix"></div>

        <?php
        if (isset($students))
        {
                ?>
                <div class="head list_head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Route : <?php echo $row->name ?></h2>  
                     <button class="btn btn-sm btn-success hide_ruti">Gen Report</button>
                </div>
                
                <button onClick="window.print()" class="btn btn-success print_report"><i class="glyphicon glyphicon-print"></i> Print</button>
                <button  class="btn btn-danger exit_report"> Back</button>
                <h3><center>Students In Route <?php echo $row->name ?></center></h3>       
                <?php echo form_open(base_url('admin/transport/remove_stds'))?> 
                <table cellpadding="0" cellspacing="0" width="100%">
                    <!-- BEGIN -->
                    <thead>
                        <tr role="row">
                            <th width="3%">#</th>
                            <th>Adm No</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Term</th>
                            <th>Year</th>
                            <th>Charge</th>
                            <th>Stage</th>
                            <th>Way</th>
                            <th ><input type="checkbox" class="checkall" /></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        
                        foreach ($students as $s):
                                $st = $this->worker->get_student($s->student);
                                $stg = isset($stages[$s->stage]) ? $stages[$s->$stage] : '';
                                $i++;
                               
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>	
                                    <td> <?php echo $st->admission_number?></td>
                                    <td>
                                        <?php echo $st->first_name . ' ' . $st->last_name; ?>  
                                    </td>
                                    <td><?php echo isset($st->cl->name) ? $st->cl->name : '-'; ?></td>
                                    <td><?php echo isset($this->terms[$s->term]) ? $this->terms[$s->term] : ' -'; ?></td>
                                    <td><?php echo $s->year; ?></td>	
                                    <td><?php
                                        if($s->way==1){
                                            echo number_format($s->one_way_charge,2);
                                        }else{
                                            echo number_format($s->two_way_charge,2);
                                        }
                                    ?></td>
                                    <td><?php echo ucfirst($stg)?></td>
                                    <td><?php
                                        if($s->way==1){
                                            echo 'One Way';
                                        }else{
                                            echo 'Two Way';
                                        }
                                    ?></td>

                                    
                                    <td>
                                        <input type="checkbox" name="student[]" value="<?php echo $s->student?>" class="switchx check-lef">
                                    
                                    </td>
                                    
                                </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-sm btn-danger pull-right">Remove Selected</button>
                <?php form_close()?>
        <?php } ?>
        <div class="clearfix"></div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(".print_report").hide("slow"); 
    $(".exit_report").hide("slow"); 

    $(".add_route").click(function(){        
        $(".ruti").show("slow");
        $(".list_ruti").hide("slow"); 
    });

    $(".cancel").click(function(){        
        $(".ruti").hide("slow");
        $(".list_ruti").show("slow"); 
    });

    $(".hide_ruti").click(function(){        
        $(".hide_ruti").hide("slow");
        $(".print_report").show("slow"); 
        $(".list_ruti").hide("slow"); 
        $(".options").hide("slow"); 
        $(".list_head").hide("slow"); 
        $(".exit_report").show("slow"); 
    });
    
    $(".exit_report").click(function(){        
        $(".hide_ruti").show("slow");
        $(".print_report").hide("slow"); 
        $(".list_ruti").show("slow"); 
        $(".options").show("slow"); 
        $(".list_head").show("slow"); 
        $(".exit_report").hide("slow");  
    });


    $(".checks").on('change', function ()
            {
                $("input.check-lef").each(function ()
                {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });

            $(".checkall").on('change', function ()
            {
                $("input.check").each(function ()
                {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });
            $.uniform.update();
    
});
</script>
