<div class="col-md-6">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>View Class</h2> 
        <div class="right">
            <a href="<?php echo base_url('admin/class_groups/classes'); ?>" class="btn btn-primary"><i class="glyphicon glyphicon-list">
                </i> List All</a>   
        </div>					
    </div>
    <div class="block invoice">
        <h1><?php
            $cc = isset($classes[$class->class]) ? $classes[$class->class] : ' -';
            $ss = isset($streams[$class->stream]) ? $streams[$class->stream] : ' -';
            echo $cc . ' ' . $ss;
            ?></h1>
        <span class="date">&nbsp;</span>
        <div class="block-fluid">
            <div class="widget">
                <div class="head dark">
                    <div class="icon"></div>
                    <h2>Number of registered students in this class - <?php echo count($post); ?></h2>
                </div>
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open_multipart(current_url(), $attributes);
                ?>
                <div class='form-group'>
                    <div class="col-md-2" for='class_teacher'>Class Teacher  </div>
                    <div class="col-md-6">
                        <?php
                        $items = $this->ion_auth->get_teachers();
                         echo form_dropdown('class_teacher', array('' => 'Select Teacher') + (array) $items, (isset($class->class_teacher)) ? $class->class_teacher : '', ' class="select" data-placeholder="Select Options..." ');
                        echo form_error('class_teacher');
                        ?>
                    </div></div>
                <div class='form-group'><div class="col-md-2"></div>
                    <div class="col-md-6">
                        <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                        <?php echo anchor('admin/class_groups/classes', 'Cancel', 'class="btn btn-danger"'); ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="block-fluid">
            <div class="widget">
                <div class="head dark">
                    <div class="icon"></div>
                    <h2>Exam Recording</h2>
                </div>
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open_multipart(current_url(), $attributes);
                ?>
                <div class='form-group'>
                    <div class="col-md-2">Method </div>
                    <div class="col-md-6">
                        <?php
                        $methods = array(1 => 'Marks', 2 => 'Remarks');
                        echo form_dropdown('rec', array('' => 'Select Option') + $methods, (isset($class->rec)) ? $class->rec : '', ' class="select" data-placeholder="Select Options..." ');
                        echo form_error('rec');
                        ?>
                    </div>
                </div>
                <div class='form-group'><div class="col-md-2"></div>
                    <div class="col-md-6">
                        <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                        <?php echo anchor('admin/class_groups/classes', 'Cancel', 'class="btn btn-danger"'); ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="widget">
        <div class="head dark">
            <div class="icon"></div>
            <h2>Classes</h2>
        </div>
        <div class="block-fluid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="3%">#</th>
                        <th width="30%">Class</th>
                        <th width="20%">Class Teacher</th>
                        <th width="5%">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($all as $s)
                    {
                            $cc = isset($classes[$s->class]) ? $classes[$s->class] : ' -';
                            $ss = isset($streams[$s->stream]) ? $streams[$s->stream] : ' -';

                            $i++;
                            ?>

                            <tr>
                                <td><?php echo $i . '. '; ?></td>
                                <td><?php echo $cc . ' ' . $ss; ?></td>
                                <td>
                                    <?php
                                    $u = $this->ion_auth->get_user($s->class_teacher);
                                    $tr = '<i style="color:red"> No Class Teacher</i>';
                                    if ($s->class_teacher > 0)
                                    {

                                            $tr = $u->first_name . ' ' . $u->last_name;
                                    }
                                    echo $tr;
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn "  href="<?php echo site_url('admin/class_groups/class_teacher/' . $s->id); ?>"><i class="glyphicon glyphicon-edit"> </i> Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
