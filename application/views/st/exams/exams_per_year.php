<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h4 class="m-b-10"> Exams   </h4>
                            </div>
                            <div class="col-md-8">
                                <div class="pull-right">
                           
				 <a href="<?php echo base_url('common/index/exams/'); ?>" class="btn btn-danger"><i class="fa fa-caret-left">
                                                  </i> Exit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<hr>


<?php if ($exams): ?>
       <div class="dt-responsive table-responsive">
    <table id="dom-jqry" class="table table-striped table-bordered"> 
                <thead>
                <th>#</th>
                <th>Title</th>
                <th>Term</th>
                <th>Year</th>
                <th>Start</th>
                <th>End</th>
                <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
               

                    foreach ($exams as $p):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>	
                                <td><?php echo strtoupper($p->title); ?></td>
                                <td> <?php echo isset($this->terms[$p->term]) ? $this->terms[$p->term] : ' '; ?></td>
                                <td><?php echo $p->year; ?></td>
                                <td><?php echo $p->start_date ? date('d M Y', $p->start_date) : ''; ?></td>
                                <td><?php echo $p->end_date ? date('d M Y', $p->end_date) : ''; ?></td>
                                <td class="text-center">
                                   <a href="<?php echo base_url('st/results/'.$p->id); ?>" class="btn btn-success"><i class="fa fa-share">   </i> View Report</a>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; ?>

   </div>
      </div>
     </div>
  </div>	