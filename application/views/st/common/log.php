<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h3 class="m-b-10">My SMS Alerts</h3>
                            </div>
                            <div class="col-md-8">
                                <div class="pull-right">
                                    <div class="right">
                                          <?php echo anchor( 'admin#communication' , '<i class="fa fa-caret-left"></i> Exit', 'class="btn btn-danger"');?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>


                <?php if ($sms) : ?>
                    <div class="block-fluid">
                        <div class="timeline">
                         
                            <div class="list-group">
							
							 <div class="dt-responsive table-responsive">
                            <table id="dom-jqry" class="table table-striped table-bordered"> 
                                <thead>
								   <th>Time</th>
								   <th>Sender ID</th>
								   <th>Phone</th>
								   <th>Date</th>
								   <th>Sms</th>
								   <th>Sent By</th>
                                </thead>
                                <!-- </div> -->
                                <?php
                                $i = 0;
                          
                                $this->load->library('dates');
                                foreach ($sms as $p) :
                                    $i++;
                                   
                                    $dd = $p->created_on > 10000 ? date('d/m/Y H:i:s', $p->created_on) : '';
                                    $title = $p->dest . '- (' . $dd . ' ) - ' . $p->source;
                                    $user = $this->ion_auth->get_user($p->created_by)
                                ?>
								<tbody>
                                    <tr>       
                                        <td class="date red"><?php //echo $tp; ?><span>
                                                <?php //echo $tp1 . ' ' . $tp2; ?></span>
												</td>
										  
										  <td> <?php echo $p->source; ?></td>
										  <td> <?php echo $p->dest; ?></td>
										  <td> <?php echo $dd; ?></td>
										  
										 <td> <?php echo $p->message; ?></td>
                                         <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                    </tr>
								<tbody>
                                <?php endforeach ?>
							</table>
                               
                            </div>
                        </div>
                    <?php else : ?>
                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                    <?php endif ?>
                    <style>
                        blockquote p {
                            font-size: 12px;
                        }
                    </style>