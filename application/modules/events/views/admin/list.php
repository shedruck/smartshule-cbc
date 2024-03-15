<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Events & Announcements </h2>
    <div class="right">  
        <?php echo anchor('admin/events/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Events')), 'class="btn btn-primary"'); ?>
    </div>
</div>
<?php if ($events): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th><th>Title</th><th>Date</th><th>Start</th><th>End</th><th>Description</th>	<th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }

                    foreach ($events as $p):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->title; ?></td>
                                <td><?php echo $p->date > 10000 ? date('d M Y', $p->date) : ''; ?></td>
                                <td><?php echo $p->start; ?></td>
                                <td><?php echo $p->end; ?></td>
                                <td width="32%"><?php echo $p->description; ?></td>
                                <td width='30'>
                                    <div class='btn-group'>
                                        <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a href='<?php echo site_url('admin/events/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> Edit</a></li>
                                            <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/events/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
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