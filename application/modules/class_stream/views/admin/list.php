<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>School Classes</h2> 
        <div class="right">
            <?php echo anchor('admin/class_stream/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Stream')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/class_stream/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        </div>    					
    </div>
    <?php if ($class_stream): ?>               
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">   
                <thead>
                <th>#</th>
                <th>Name</th>
                <th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                        $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }

                    foreach ($class_stream as $p):
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i . '.'; ?></td>					
                            <td><?php echo $p->name; ?></td>
                            <td>
                                <div class="btn-group">
                                  <a class="btn btn-info"  href="<?php echo site_url('admin/class_stream/edit/' . $p->id . '/' . $page); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>
    </div>

    <?php //echo $links; ?>

<?php else: ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
     <?php endif ?>