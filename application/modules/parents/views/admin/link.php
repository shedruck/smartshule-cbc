<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Parents Link to Students </h2> 
    <div class="right">  
        <div class='btn-grdoup'>	
            <?php echo anchor('admin/parents', '<i class="glyphicon glyphicon-thumbs-up"></i> Parents', 'class="btn btn-success"'); ?>
        </div>
    </div>
</div>
<div class="toolbar">
    <div class="col-md-12"><br/>
        <?php
        echo form_open(current_url());
        ?>
        Parent
        <?php echo form_dropdown('parent', array('' => '') + $parents, $this->input->post('parent'), 'class ="select" '); ?>
        <button class="btn btn-primary" type="submit" name="view" value="1">View Parent</button>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="margin-5 ">
    <div class="row">
        <?php
        if (isset($row))
        {
            ?>
            <div class="col-lg-12 col-xl-8 user-details-card">
                <div class="card widget-user-details">
                    <div class="card-header">
                        <div class="card-title-details d-flex align-items-center">

                            <div>
                                <h5>Id.<?php echo $row->id; ?></h5>
                                <h5><?php echo $row->first_name . ' ' . $row->last_name; ?></h5>
                                <div class="card-subtitle"><?php echo $row->phone ?> </div>
                                <h5>User: <?php echo $row->user_id; ?></h5>
                            </div>
                        </div>
                        <div class="heading-elements">
                            <i class="bx bx-dots-vertical-rounded font-medium-3 align-middle"></i>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive ps ps--active-x">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td><strong>Student</strong></td>
                                            <td><strong>Admission No.</strong></td>
                                            <td>Class</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($row->kids as $k)
                                        {
                                            $i++;
                                            $st = $this->worker->get_student($k->student_id);
                                            $us = $st->parent_user ? $this->ion_auth->get_user($st->parent_user) : [];
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?>.</td>
                                                <td>
                                                    <h4 style="margin:2px" class="text-primary text-uppercase"><?php echo $st->first_name . ' ' . $st->last_name; ?></h4>
                                                    <p>parent_user:  <?php echo $st->parent_user ? $us->first_name . ' ' . $us->last_name : ' - '; ?> 
                                                    <br>parent_id:  <?php echo isset($parents[$st->parent_id]) ? $parents[$st->parent_id] : ' - ' ?></p>
                                                </td>
                                                <td><?php echo $st->old_adm_no ? $st->old_adm_no : $st->admission_number; ?>  </td>
                                                <td><?php echo $st->cl->name; ?> </td>
                                                <td>
                                                    <a href="<?php echo base_url('admin/parents/unlink/' . $row->id . '/' . $k->student_id); ?>" class="btn btn-danger glow">Remove</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between border-top">
                        <div class="d-flex">
                            <?php
                            echo form_open(current_url() . '/' . $row->id);
                            $data = $this->ion_auth->students_full_details();
                            ?>
                            <div class='form-group'>
                                <div class="col-md-3" >Select Student:</div>
                                <div class="col-md-6">
                                    <?php echo form_dropdown('student', array('' => '') + $data, $this->input->post('student'), 'class ="select" '); ?>
                                </div>
                                <br>
                                <button type="submit" name="add" value="2" class="btn btn-primary glow margin-5"> <i class="glyphicon glyphicon-plus"></i> Add Student</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div>
                            <?php
                            echo form_open(current_url() . '/' . $row->id);
                            ?>
                            <div class='form-group'>
                                <div class="col-md-3" >Select User:</div>
                                <div class="col-md-6">
                                    <?php echo form_dropdown('user', array('' => '') + $users, $this->input->post('user'), 'class ="select" '); ?>
                                </div>
                                <br>
                                <button type="submit" name="lnk" value="3" class="btn btn-primary glow margin-5"> <i class="glyphicon glyphicon-link"></i> Link User ID</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(
            function ()
            {
                $(".tsel").select2({'placeholder': 'Please Select', 'width': '140px'});
                $(".tsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.target.value);
                });

                $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                $(".fsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.target.value);
                });
            });
</script>
<style>
    .margin-5{margin-top: 20px;}
    .card{display:-webkit-flex;-webkit-box-orient:vertical;}
    .card{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#FFF;background-clip:border-box;border:0 solid #DFE3E7;border-radius:.267rem;}
    .card-body{-webkit-box-flex:1;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;padding:1.7rem;}
    .card-footer,.card-header{padding:1.4rem 1.7rem;background-color:transparent;}
    .card-header,.card-subtitle{margin-bottom:0;}
    .card-subtitle{margin-top:-.7rem;}
    .card-header{border-bottom:0 solid #DFE3E7;}
    .card-header:first-child{border-radius:calc(.267rem - 0px) calc(.267rem - 0px) 0 0;}
    .card-footer{border-top:0 solid #DFE3E7;}
    .card-footer:last-child{border-radius:0 0 calc(.267rem - 0px) calc(.267rem - 0px);}
    .badge{line-height:1;}
    .badge{display:inline-block;padding:.34rem 1.11rem;font-size:.8rem;text-align:center;vertical-align:baseline;border-radius:.267rem;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
    @media (prefers-reduced-motion:reduce){
        .badge{-webkit-transition:none;transition:none;}
    }
    .badge:empty{display:none;}
    .align-middle{vertical-align:middle!important;}
    .border-top{border-top:1px solid #DFE3E7!important;}
    .d-flex{display:-webkit-box!important;display:-webkit-flex!important;display:-ms-flexbox!important;display:flex!important;}
    .d-inline-flex{display:-webkit-inline-box!important;display:-webkit-inline-flex!important;display:-ms-inline-flexbox!important;display:inline-flex!important;}
    .justify-content-between{-webkit-box-pack:justify!important;-webkit-justify-content:space-between!important;-ms-flex-pack:justify!important;justify-content:space-between!important;}
    .align-items-center{-webkit-box-align:center!important;-webkit-align-items:center!important;-ms-flex-align:center!important;align-items:center!important;}
    .ml-0{margin-left:0!important;}
    .mr-2{margin-right:1.5rem!important;}
    .mr-25{margin-right:.25rem!important;}
    .pb-0{padding-bottom:0!important;}
    .pl-0{padding-left:0!important;}
    .p-25{padding:.25rem!important;}
    .py-50{padding-top:.5rem!important;}
    .py-50{padding-bottom:.5rem!important;}

    .btn-primary{border-color:#2C6DE9!important;background-color:#5A8DEE!important;color:#FFF;}
    .btn-primary:hover{background-color:#719DF0!important;color:#FFF;}
    .btn-primary:hover.glow{box-shadow:0 4px 12px 0 rgba(90,141,238,.6)!important;}
    .btn-primary:active,.btn-primary:focus{background-color:#437DEC!important;color:#FFF!important;}
    .btn-primary.glow{box-shadow:0 2px 4px 0 rgba(90,141,238,.5)!important;}
    .btn-primary:disabled{color:#FFF!important;}
    .badge.badge-light-danger{background-color:#FFDEDE;color:#FF5B5C!important;}

</style>