<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Fee Extras  </h2>
    <div class="right">  
        <?php echo anchor('admin/fee_extras/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Fee Extras')), 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/fee_extras', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Extras')), 'class="btn btn-primary"'); ?> 

    </div>
</div>
 
<?php if ($fee_extras): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Payable</th>
                <th>Description</th>
                <th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }

                    foreach ($fee_extras as $p):
                        
                            // if(empty($p->f_id)){
                                    $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>				
                                <td><?php echo $p->title; ?></td>
                                <td class="rttb"><?php echo number_format($p->amount, 2); ?></td>
                                <td><?php echo $p->ftype == 1 ? 'Charge' : 'Waiver'; ?></td>
                                <td><?php 
								if($p->cycle==999){
									echo 'On Demand';
								}else{
									echo $p->cycle; 
								}
								?></td>
                                <td><?php echo $p->description; ?></td>

                                <td width='20%'>
                                    <div class='btn-group'>
                                        <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a href='<?php echo site_url('admin/fee_extras/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                                            <li><a  href='<?php echo site_url('admin/fee_extras/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
                                          <!--  <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/fee_extras/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>-->
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php /*}*/?>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                             <?php endif ?>