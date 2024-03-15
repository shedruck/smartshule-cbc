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
        <h2>Add  Assessment  </h2>
        <div class="right">
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2">Student<span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => '') + $data, '', ' class="fsel placeholder="Segment"');
                ?>
            </div>
        </div>

        <table width="100%" class="score-table">
            <?php
            $i = 0;
            foreach ($units as $u)
            {
                    $i++;
                    ?>
                    <tr>
                        <td width="7%"><?php echo $i; ?>.</td>
                        <td width="40%"><?php echo $u->unit; ?></td>
                        <td width="20%" class="sc">
                            <?php
                            echo form_dropdown('grade[' . $u->id . ']', array('' => '') + $grades, '', ' class="fsel placeholder="Segment"');
                            ?></td>
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
                <textarea id="description"   style="height: 300px;" class=" wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
                <?php echo anchor('admin/assessment', 'Cancel', 'class="btn  btn-default"'); ?>
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