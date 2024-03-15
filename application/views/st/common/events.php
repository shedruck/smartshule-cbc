<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <h4 class="m-b-10">  Events & Announcements   </h4>
                            </div>
                            <div class="col-md-8">
                                <div class="pull-right">
								 <?php echo anchor('st/events_calendar', '<i class="fa fa-calendar"></i> Events Calendar', 'class="btn btn-success"'); ?>
								 
                                <?php echo anchor( 'st#communication' , '<i class="fa fa-caret-left"></i> Exit', 'class="btn btn-danger"');?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<hr>


<?php if ($events): ?>
          <div class="dt-responsive table-responsive">
    <table id="dom-jqry" class="table table-striped table-bordered"> 
                <thead>
                <th>#</th>
				<th>Title</th>
				<th>Date</th>
				<th>Start</th>
				<th>End</th>
				<th>Description</th>
				<th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
             

                    foreach ($events as $p):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $p->title; ?></td>
                                <td><?php echo $p->date > 10000 ? date('d M Y', $p->date) : ''; ?></td>
                                <td><?php echo $p->start; ?></td>
                                <td><?php echo $p->end; ?></td>
                                <td width="32%"><?php echo substr(strip_tags($p->description),0,70) ?>..</td>
                                <td width='30'>
                                    <div class='btn-group'>
									   <a class='btn btn-primary' href='#<?php //echo site_url('admin/events/edit/' . $p->id . '/' . $page); ?>'><i class='fa fa-share'></i> View</a>
                                      
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
      </div>
     </div>
  </div>	