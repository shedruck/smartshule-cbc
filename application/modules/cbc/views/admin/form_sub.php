<div>
    <div class="col-md-12 hidden-print">
        <div class="page-header row">
            <div class="col-md-11">
                <p> </p>
            </div>
            <div class="col-md-1">
                <a href="<?php echo base_url('admin/cbc/subjects'); ?>" class="pull-right btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="card-box hidden-print">
        <h4 class="m-t-0 m-b-10 header-title text-center">Edit Subject</h4>
        <form class="form-horizontal form-main" role="form" action="<?php echo current_url(); ?>" method="POST">
            <div class="form-group">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9 rows">
                    <?php echo form_input('name', $post->name, 'id="name_"  class="form-control" '); ?>
                    <?php echo form_error('name'); ?>
                </div>
            </div>
            <div class='form-group'>
                <div class="col-md-3" for='cat'>Type <span class='required'>*</span></div>
                <div class="col-md-6">
                    <?php
                    $ifr = [
                        '' => '',
                        0 => "Regular Subject",
                        1 => "Optional Subject",
                        2 => "Elective Subject"
                    ];
                    echo form_dropdown('cat', $ifr, (isset($post->cat)) ? $post->cat : '', ' class="select" placeholder="Select Subject Type" ');
                    echo form_error('cat');
                    ?>
                </div>
            </div>
            <div class='form-group'>
                <div class="col-md-8  col-md-offset-3" ><h4>Assign Subject to Classes  </h4></div>
            </div>
            <div  class="clonedInput"> 
                <div class='form-group '>
                    <div class="col-md-6 col-md-offset-3">
                        <?php echo form_dropdown('class[]', $this->classes, $assigned, '  class="select " placeholder="Select Classes" '); ?>
                        <?php echo form_error('class'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group m-b-0">
                <div class="col-sm-offset-3 col-sm-9">
                    <a href="<?php echo base_url('admin/cbc/subjects') ?>" class="btn btn-default ">Go Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>