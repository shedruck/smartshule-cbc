<div class="col-md-12">
    <div class="head ruti" >
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>&nbsp; </h2> 
        <div class="right">
            <?php echo anchor('admin/transport/routes', '<i class="glyphicon glyphicon-circle-arrow-left"></i> Go Back', 'class="btn btn-primary cancel"'); ?>            
        </div>	
    </div>

    <div class="block-fluid col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Assign Bus</div>
            <div class="panel-body">
                <h3>Route: <?php echo $route->name; ?></h3>
                <?php echo form_open(current_url()) ?>
                <div class="form-group">
                    <label class="col-md-4">Transport Bus:</label>
                    <div class="col-md-8">
                        <?php echo form_dropdown('bus', ['' => ''] + $buses, $this->input->post('bus'), 'class ="tsel" placeholder="Select Bus" '); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6"></div>
                    <button class="btn btn-success" type="submit">Assign</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(
            function ()
            {
                $(".tsel").select2({'placeholder': 'Please Select', 'width': '100%'});
            });
</script>
