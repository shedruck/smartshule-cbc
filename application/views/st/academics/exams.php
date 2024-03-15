
<div class="row card-box1 table-responsive">
 
    <div class="col-md-12">
        <div class="card-bsox">
		
            <h4 class="header-title m-t-0 m-b-20"> Exam Results <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a></h4>
            <?php if (isset($exams)): ?>
                   <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Term</th>
                                <th>Year</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th class="text-center" > Option  </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                      
                            foreach ($exams as $p):
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>	
                                        <td><?php echo $p->title; ?></td>
                                        <td> <?php echo isset($this->terms[$p->term]) ? $this->terms[$p->term] : ' '; ?></td>
                                        <td><?php echo $p->year; ?></td>
                                        <td class="text-green"><?php echo date('d M Y',$p->start_date); ?></td>
                                        <td class="text-red"><?php echo date('d M Y',$p->end_date); ?></td>
                                        <td class="text-center">
                                          
                                            <div class="btn-group">
											  <a href="<?php echo base_url('st/results/' . $p->id)?>" class="btn btn-primary btn-sm">View Results</a>
                                               
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
            <?php else: ?>
                    <div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <i class="mdi mdi-alert"></i>
                        No Exams Have been Added Yet.
                    </div>
            <?php
            endif;
            
            ?>            
        </div>
    </div>
</div>