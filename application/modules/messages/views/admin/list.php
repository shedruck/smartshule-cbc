<div class="col-md-12">
    <div class="widget">                    
        <div class="head dark">
            <div class="icon"><span class="icos-box-add"></span></div>
            <h2>Messages & Feedback</h2>
			
			 <div class="right">  
        <?php echo anchor('admin/messages/assign_users', '<i class="glyphicon glyphicon-user"></i> Assign Permissions', 'class="btn btn-primary"'); ?>

    </div>
			
			
        </div>
        <div class="toolbar">
            <div class="left"></div>
            <div class="right TAR">
                <a class="btn btn-primary hidden" href="<?php echo base_url('admin/messages/create'); ?>"> 
                    <i class="glyphicon glyphicon-plus"></i>
                    New Message
                </a>
            </div>
        </div>
        <div class="block-fluid">
            <table class="table-hover mailbox" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="35%">Title</th>
                        <th width="25%">From</th>
                        <th width="25%">To</th>
                        <th width="15%">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($messages as $m)
                    {
                            $i++;
                            ?>
                            <tr class="new">
                                <td><?php echo $i; ?>.</td>
                                <td><a href="<?php echo base_url('admin/messages/view/' . $m->id); ?>" class="subject"><?php echo $m->title; ?></a></td>
                                <td>  <?php echo $m->from; ?></td>
                                <td>  <?php echo $m->to; ?></td>
                                <td><?php echo date('d-m-Y h:i A', $m->last); ?></td>
                            </tr>
                    <?php } ?>        
                </tbody>
            </table>
        </div>
        <div class="toolbar bottom">
            <div class="left">
            </div>
            <div class="right">
                <!--<ul class="pagination pull-right pagination-sm">
                    <li class="disabled"><a href="#">«</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                 </ul>-->
            </div>

        </div>
    </div>

</div>

<style>
    .form-group {
        margin-bottom: 15px;
    }
</style>