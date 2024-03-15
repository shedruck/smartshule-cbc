<div class="col-sm-12">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span> </div>
        <h2> Student Assignments / Homework
            <div class="pull-right"> 
            </div>
        </h2>
    </div>
    <hr>
    <?php if (count($post)): ?>
            <div class="block-fluid">
                <table cellpadding="0" cellspacing="0" width="100%" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th>Assignment</th>	
                            <th><?php echo lang('web_options'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $len = 21;
                        foreach ($post as $p):
                                $i++;
                                $suff = '';
                                if (strlen($p->assignment) > $len)
                                {
                                        $suff = '...';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>					
                                    <td><?php echo $p->title; ?></td>
                                    <td><?php echo $p->start_date > 10000 ? date('d M Y', $p->start_date) : ' - '; ?></td>
                                    <td><?php echo $p->end_date > 10000 ? date('d M Y', $p->end_date) : ' - '; ?></td>
                                    <td title=""><?php echo substr($p->assignment, 0, $len) . $suff; ?></td>
                                    <td width='20%'>
                                        <div class='btn-group'>
                                            <a href='<?php echo site_url('assignments/view/' . $p->id); ?>' class="btn btn-custom"><i class='glyphicon glyphicon-eye-open'></i> View</a>
                                        </div>
                                    </td>
                                </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
    <?php else: ?>
            <p class='text'>No Assignments Available</p>
    <?php endif ?>
</div>