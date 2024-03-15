<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                          
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="pull-right">
								<a class="btn btn-sm btn-primary " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>		
                                <?php echo anchor( 'st/landing/e-classroom' , '<i class="fa fa-caret-left"></i> Exit', 'class="btn btn-sm btn-danger"');?>
 						
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
	

<?php if ($borrowed_books): ?>
  <!------------Book Funds HISTORY--------------------->
                            <div class="col-md-12 card-box table-responsive">

                                <span class="title-block">
                                    <h3 > Library Book Status</h3>
                                </span>
                            <?php if ($borrowed_books): ?>              

                                        <table  cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-colored table-success m-0">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Book</th>
                                            <th>Borrowed Date</th>
                                            <th>Status</th>
                                            <th>Remarks</th>	
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($borrowed_books as $p):
                                                        $i++;
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>	
                                                            <td><?php echo isset($lib_books[$p->book]) ? $lib_books[$p->book] : ''; ?></td>
                                                            <td><?php echo date('d/m/Y', $p->borrow_date); ?></td>
                                                            <td>
                                                                <?php
                                                                if ($p->status == 2)
                                                                {
                                                                        echo '<span style="color:green">Book Returned</span>';
                                                                }
                                                                elseif ($p->status == 1)
                                                                {
                                                                        echo '<span style="color:red">Not Returned</span>';
                                                                }
                                                                ?> </td>
                                                            <td><?php echo $p->remarks; ?></td>
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
										<?php else: ?>
												<p class='text'><?php echo lang('web_no_elements'); ?></p>
										<?php endif ?>

                            </div>



<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                                 <?php endif ?>
												 
  </div>
      </div>
     </div>
  </div>	