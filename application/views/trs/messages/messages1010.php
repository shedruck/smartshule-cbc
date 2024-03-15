<main id="main">
    <div class="overlay"></div>
    <header class="headerx">
        <h3 class="page-title">Messages & Feedback</h3>
        <a class="btn btn-custom right" href="<?php echo base_url('trs/new_message'); ?>"> 
            <i class="glyphicon glyphicon-plus"></i>
            New Message
        </a>
    </header>
    <div id="main-nano-wrapper" class="nano card-box table-responsive">
        <div class="nanco-content">  
            <table class="table bordered">
			 <thead  class="active">
					
					<th>#</th>
					<th>Date</th>
					<th>Title</th>
					<th>Sent To</th>
					<th>Action</th>
				</thead>
				<tbody>
				   <?php
						$i = 0;
						foreach ($messages as $m)
						{
								$i++;
								$get = $m->seen ? '' : '/?st=' . rand(10, 3000);
								?>
							<tr>
								 <td>
								  <?php echo $i; ?>.
									  
								 </td>
								 <td>
								   <a href="<?php echo base_url('trs/view_message/' . $m->id . $get); ?>">
											<p class="title"><?php echo $m->seen ? $m->title : '<strong>' . $m->title . '</strong>'; ?></p>
										</a>
								 </td>
								 <td><?php echo $m->to; ?></td>
								 <td><?php echo date('d-m-Y h:i A', $m->last); ?></td>
								 <td>View</td>
							</tr>
						  <?php } ?>    
				</tbody>
			</table>

		
            <ul class="message-list">
                <li class="active">
                    <div class="col col-1">
                        <p class="title">Title</p>
                    </div>
                    <div class="col col-2 hidden-xs">
                        <div class="subject">Sent to</div>
                        <div class="date">Date</div>
                        <div class="date">Action</div>
                    </div>
                </li>
                <?php
                $i = 0;
                foreach ($messages as $m)
                {
                        $i++;
                        $get = $m->seen ? '' : '/?st=' . rand(10, 3000);
                        ?>
                        <li>
                            <div class="col col-1">
                                <?php echo $i; ?>.
                                <a href="<?php echo base_url('trs/view_message/' . $m->id . $get); ?>">
                                    <p class="title"><?php echo $m->seen ? $m->title : '<strong>' . $m->title . '</strong>'; ?></p>
                                </a>
                            </div>
                            <div class="col col-2 hidden-xs">
                                <div class="subject"><?php echo $m->to; ?></div>
                                <div class="date"><?php echo date('d-m-Y h:i A', $m->last); ?></div>
                            </div>
                        </li>
                <?php } ?>                
            </ul>
        </div>
    </div>
</main>  

<style>
    .form-group {
        margin-bottom: 15px;
    }
</style>