<div class="toolbar-fluid">
    <div class="information">
        <div class="item">
            <div class="rates">
                <div class="title">
                    <?php echo anchor('admin/assessment/', '<i class="glyphicon glyphicon-list"></i> List All ', 'class="btn btn-primary"'); ?>
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
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Assessment  </h2>
    <div class="right">  
    </div>
</div>
<?php
if ($assessment):
        ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th><?php echo lang('web_options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }

                    foreach ($assessment as $p):
                            $st = $this->worker->get_student($p->student);
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $st->first_name . ' ' . $st->last_name; ?></td>
                                <td><?php echo date('d M Y', $p->created_on); ?></td>
                                <td width='30'>
                                    <div class='btn-group'>
                                        <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a  href='<?php echo site_url('admin/assessment/view/' . $p->id . '/'); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>

            </table>


        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                                                                                                                                                         <?php endif ?>