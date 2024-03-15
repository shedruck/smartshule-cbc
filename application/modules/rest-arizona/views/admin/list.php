<section>
    <div class="panel panel-success" data-sortable-id="ui-widget-16"> 
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <div class="btn-group">
                    <?php echo anchor('admin/adverts/create', '<span> Add Adverts</span>', 'class="btn btn-warning" '); ?> 
                    <?php echo anchor('admin/adverts', '<span> All Adverts' . '</span>', 'class="btn btn-primary"'); ?>
                </div>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default " data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title"> Adverts</h4>
        </div>
        <div class="panel-body" >   

            <?php if (!empty($adverts)): ?>
                    <div class='clearfix'></div>
                    <div class="table-responsive"> 							
                        <table id="table_id" class="table table-hover table-bordered table-striped table-advanced">         	
                            <thead>
                            <th>#</th>
                            <th>Road</th>
                            <th>Brand</th>
                            <th>Brand ID</th>
                            <th><?php echo lang('web_options'); ?></th>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                        $i = ($this->uri->segment(4) - 1) * $per;
                                }

                                foreach ($adverts as $p):
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i . '.'; ?></td>
                                            <td><?php echo $p->road; ?></td>
                                            <td><?php echo isset($brands[$p->brand]) ? $brands[$p->brand] : ''; ?></td>                                         
                                            <td><?php echo $p->brand_id; ?></td>
                                            <td width='28%'>
                                                <a class="btn btn-success " href="<?php echo site_url('ads/view/' . $p->qid); ?>" target="_blank"><span class="bold">View</span></a>
                                                <a class="btn btn-primary " href="<?php echo site_url('admin/adverts/edit/' . $p->id . '/' . $page); ?>"><span class="bold">Edit</span></a>
                                                <a class="btn btn-danger " href="<?php echo site_url('admin/adverts/delete/' . $p->id . '/' . $page); ?>" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')"><i class="fa fa-trash"></i>&nbsp;<span class="bold">Delete</span></a>
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

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?> 
</section>