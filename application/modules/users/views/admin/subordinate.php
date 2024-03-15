
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Users Management</h2> 
    <div class="right">                            

        <?php echo anchor('admin/users/create/' . $page, '<i class="glyphicon glyphicon-plus"></i>' . lang('web_add_t', array(':name' => 'New User')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/users/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
    </div>    					
</div>

<?php if ($subs): ?>

    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>User Roles</th>
            <th><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($subs as $us)
                {
                    $i++;
                    $usr = $this->ion_auth->get_user($us->user_id);
                    $gs = '';
                    if (count($usr->groups))
                    {
                        $gs = array();
                        foreach ($usr->groups as $g)
                        {
                            $gs[] = $g->name;
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo $i . '. '; ?></td>
                        <td><?php echo $usr->first_name . ' ' . $usr->last_name ?></td>
                        <td><?php echo $usr->email; ?></td>
                        <td><?php
                              echo $usr->phone;
                                ?> 
                        </td>
                        <td> 
                            <?php
                            echo ($usr->active) ? anchor("admin/users/deactivate/" . $usr->id, 'Deactivate', 'class="btn btn-mini btn-gold"') :
                                    anchor("admin/users/activate/" . $usr->id, 'Activate', 'class="btn btn-mini btn-orange"');
                            ?></td>
                        </td>

                        <td>
                            <?php
                            if (!is_array($gs))
                            {
                                echo $gs;
                            }
                            else
                            {
                                foreach ($gs as $vtag):
                                    ?>
                                    <span class="ptags "><?php echo $vtag; ?></span>
                                    <?php
                                endforeach;
                            }
                            ?> 
						</td>
                        <td width="20%">
                            <div class="btn-group">
                                <button class="btn dropdown-toggle" data-toggle="dropdown">Action <i class="glyphicon glyphicon-caret-down"></i></button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="<?php echo site_url('admin/users/edit/' . $usr->id); ?>"><i class="glyphicon glyphicon-eye-open"></i> View</a></li>
                                    <li><a href="<?php echo site_url('admin/users/edit/' . $usr->id); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a></li>

                                    <!--<li><a onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/users/delete/' . $us->id); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a></li>-->
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>

        </table>

    </div>


<?php else: ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                 <?php endif; ?>