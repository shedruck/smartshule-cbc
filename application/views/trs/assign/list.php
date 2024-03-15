

<div class="row card-box table-responsive"> 
<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Assignments  
        <div class="pull-right">  
            <?php echo anchor('trs/assignments', '<i class="fa fa-reply"></i> Back ', 'class="btn btn-primary"'); ?>
        </div>
    </h2>
</div>
<?php if ($assignments): ?>
        <div class="table-responsive card-box table-responsive">
           <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                <th>#</th>
                <th>Title</th>
                <th>Subject</th>
                <th>Start Date</th>
                <th>End Date</th>
				<th>Done</th>
                <th>Attachment</th>
               
                <th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }
                   $sub = $this->portal_m->get_subject($ref);
                    foreach ($assignments as $p):
					
					$dd = $this->portal_m->count_done_attachments($p->id);
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->title; ?></td>
                                <td><?php echo $sub[$p->subject]; ?></td>
                                <td><?php echo date('d/m/Y', $p->start_date); ?></td>
                                <td><?php echo date('d/m/Y', $p->end_date); ?></td>
                                <td><?php echo number_format($dd); ?> <i class="text-blue">Submitted</i> </td>
                                <td width="180" style="text-align:center">
                                    <?php
                                    if (!empty($p->document))
                                    {
                                            ?>
                                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('uploads/files/' . $p->document); ?>"><i class="fa fa-download"></i> Download </a>
                                            <?php
                                    }
                                    else
                                    {
                                            ?>
                                            <b> - </b>
                                    <?php } ?>
                                </td>
                                <td width=''>
                                    <div class='btn-group'>
                                       
                                        <?php
                                        if ($extras)
                                        {
                                                ?>
                                          <a class="btn btn-sm btn-success" href='<?php echo site_url('trs/view_assign/' . $p->id . '/' . $ref . '/?x=3'); ?>'><i class='fa fa-share'></i> View</a>
											 
                                          <a class="btn btn-sm btn-info" href='<?php echo site_url('trs/edit_assign/' . $p->id . '/' . $ref . '/?x=3'); ?>'><i class='fa fa-edit'></i> Edit</a>
                                            
										<a class="hidden" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('trs/' . $p->id . '/' . $ref); ?>'><i class='fa fa-trash'></i>Delete</a>
                                             
                                                <?php
                                        }
                                        else
                                        {
                                                ?>
                                              <a class="btn btn-sm btn-success" href='<?php echo site_url('trs/view_assign/' . $p->id . '/' . $ref.'/'.$this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View</a>
											  
                                                <a class="btn btn-sm btn-info" href='<?php echo site_url('trs/edit_assign/' . $p->id . '/' . $ref.'/'.$this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a>
												
                                             <a class="hidden " onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('trs/' . $p->id . '/' . $ref); ?>'><i class='fa fa-trash'></i>Delete</a>
											 
                                        <?php } ?>
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
</div>




