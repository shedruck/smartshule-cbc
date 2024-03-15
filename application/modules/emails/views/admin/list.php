<div class="innerLR">

 <div class="col-md-11">
                    <div class="widget widget-gray widget-body-black">
                        <div class="widget-head">
                              <h4 class="heading">Emails </h4>
                               
                        </div>
                        <div class="widget-body" style="padding: 10px 0;">
                       <?php echo anchor( 'admin/emails/create/'.$page, 'Send Email', 'class="btn btn-success pull-right" ');?>
        	 <br>
        	 <br>
                 <?php if ($emails): ?>
               
                 <div class='space-6'></div>
                  <div class="table-responsive" style="">
 <table class="dynamicTable table table-striped table-bordered  table-condensed">
		<thead>
			<th>#</th>
			<th>Subject</th>
			<th>Sent By</th>
			<th>Sent on</th>
			<th>Description</th>
		<th ></th>
		</thead>
		<tbody>
		<?php $i=1; foreach ($emails as $emails_m): $user=$this->ion_auth->get_user($emails_m->created_by)?>
		<tr>					
				<td><?php echo $i;?></td>
				<td><?php echo $emails_m->subject;?></td>
				<td><?php echo $user->first_name.' '.$user->last_name;?></td>
				<td><?php echo date('d M Y',$emails_m->created_on);?></td>
				<td><?php echo $emails_m->description;?></td>
				<td >
							
				<a class='btn btn-small' onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url();?>admin/emails/delete/<?php echo $emails_m->id;?>/<?php echo $page;?>'><?php echo lang('web_delete')?></a>
				</td>
		</tr>
 			<?php $i++; endforeach ?>
		</tbody>

	</table>
       

	<?php echo $links; ?>
       

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?> 
 
 </div>
                    </div>
                </div>  
                </div>  
</div>