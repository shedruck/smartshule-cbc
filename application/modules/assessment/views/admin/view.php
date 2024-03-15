<div class="col-md-12">
    <div class="toolbar-fluid">
        <div class="information">
            <div class="item">
                <div class="rates">
                    <div class="title">
                        <?php echo anchor('admin/assessment/', '<i class="glyphicon glyphicon-list"></i> Assessment ', 'class="btn btn-primary"'); ?>
                    </div>
                </div>
            </div>                            
            <div class="item">
                <div class="rates">
                    <div class="title">
                        <div class="btn-group">
                            <button class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Assessment</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url('admin/assessment/create/1'); ?>">Junior School</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url('admin/assessment/create/2'); ?>">Primary</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url('admin/assessment/create/3'); ?>">Senior School</a></li>
                                <li class="divider"></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>                         
            <div class="item">
                <div class="rates">
                    <div class="title">
                        <?php echo anchor('admin/assessment/units/', '<i class="glyphicon glyphicon-list"></i>  Assessment Units', 'class="btn btn-primary"'); ?>
                    </div>
                </div>
            </div>                         
            <div class="item">
                <div class="rates">
                    <div class="title">
                        <?php echo anchor('admin/assessment/grading/', '<i class="glyphicon glyphicon-list"></i>  Assessment Grading', 'class="btn btn-primary"'); ?>
                    </div>
                </div>
            </div>                         
        </div>
    </div>
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>View  Assessment  </h2>
        <div class="right">
        </div>
    </div>
    <div class="block-fluid">

        <div class='form-group'>
            <div class="col-md-2"></div>
            <div class="col-md-6">
                <?php
                $st = $this->worker->get_student($assess->student);
                ?>
                <h2><?php echo $st->first_name . ' ' . $st->last_name; ?></h2>
            </div>
        </div>

        <table width="100%" class="score-table">
            <?php
            $i = 0;
            foreach ($assess->grades as $u)
            {
                    $i++;
                    ?>
                    <tr>
                        <td width="7%"><?php echo $i; ?>.</td>
                        <td width="40%"><?php echo isset($units[$u->unit]) ? $units[$u->unit] : ''; ?></td>
                        <td width="20%" class="sc">
                            <?php echo isset($grades[$u->grade]) ? $grades[$u->grade] : ''; ?>
                         </td>
                    </tr>
                    <?php
            }
            ?>
        </table>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Teacher's Comment </h2></div>
            <div class="block-fluid editor">
                <h4><?php echo $assess->comment; ?></h4>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                 <?php echo anchor('admin/assessment', 'Back', 'class="btn  btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<script type = "text/javascript">
        $(document).ready(function ()
        {
            $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
        });
</script>