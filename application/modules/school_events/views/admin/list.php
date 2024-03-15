<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> School Events</h2> 
    <div class="right">                            
        <?php if (!$this->ion_auth->is_in_group($this->user->id, 3))
        { ?>     
                <?php echo anchor('admin/school_events/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Event')), 'class="btn btn-primary"'); ?>
        <?php } ?>
        <?php echo anchor('admin/school_events/calendar', '<i class="glyphicon glyphicon-list"> </i> Full Calendar', 'class="btn btn-primary"'); ?>
<?php echo anchor('admin/school_events/list_view', '<i class="glyphicon glyphicon-list"> </i> List All', 'class="btn btn-primary"'); ?>

    </div>    					
</div>
<?php if ($school_events): ?>              
        <div class="block-fluid">

            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">

                <thead> 
                <th>#</th>
                <th>Title</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Venue</th>
                <th>Description</th>

                <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }

                    foreach ($school_events as $p):

                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->title; ?></td>
                                <td><?php echo date('d/m/Y', $p->start_date); ?></td>
                                <td><?php echo date('d/m/Y', $p->end_date); ?></td>
                                <td><?php echo $p->venue; ?></td>
                                <td><?php echo substr($p->description, 0, 30) . '...'; ?></td>


                                <td width='20%'>

                                    <div class='btn-group'>
                                        <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a href="<?php echo site_url('admin/school_events/view/' . $p->id . '/' . $page); ?>"><i class="glyphicon glyphicon-eye-open"></i> View Details</a></li>
                                            <li><a href="<?php echo site_url('admin/school_events/edit/' . $p->id . '/' . $page); ?>"><i class="glyphicon glyphicon-edit"></i> Edit Details</a></li>

                                            <li><a onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/school_events/delete/' . $p->id . '/' . $page); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a></li>
                                        </ul>
                                    </div>
                                </td>

                            </tr>
        <?php endforeach ?>
                </tbody>

            </table>
        </div>

        <?php echo $links; ?>
        </div>
        </div>
        </div>
        </div>

        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
         <?php endif ?>