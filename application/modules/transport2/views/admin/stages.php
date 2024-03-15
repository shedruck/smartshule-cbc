<div class="col-md-12">
    <div class="head ruti" >
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>  Transport Stages </h2> 
        <div class="right">
            <?php echo anchor('admin/transport/routes', '<i class="glyphicon glyphicon-circle-arrow-left"></i> Go Back', 'class="btn btn-primary cancel"'); ?>            
        </div>	
        
       
    </div>
    
    <div class="block-fluid col-md-6">
      
        <div class="clearfix"></div>
      
                     
                <table cellpadding="0" cellspacing="0" width="100%" class="list_ruti">
                    <!-- BEGIN -->
                    <thead>
                        <tr role="row">
                            <th width="3%">#</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($stages as $r):
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>	
                                    <td width="50%"><?php echo $r->stage_name; ?></td>
                                    
                                </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
     
        <div class="clearfix"></div>

        
        <div class="clearfix"></div>
    </div>
    <div class="block-fluid col-md-6">
    <div class="panel panel-primary">
            <div class="panel-heading">Add Stage</div>
            <div class="panel-body">
                <?php echo form_open(current_url())?>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-4">Stage Name</label>
                        <div class="col-md-6">
                            <input type="text" name="stage" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success" type="submit">Add</button>
                        </div>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>


