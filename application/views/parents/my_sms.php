

	<div class="row">
				<div class="card shadow-sm ctm-border-radius grow">
			<div class="card-header d-flex align-items-center justify-content-between">
				<h4 class="card-title mb-0 d-inline-block">My SMSs</h4>
			
			</div>
			
			
    <div class="col-sm-12">
        <div class="widget">
            
            <div class="block-fluid">
                <?php if ($sms): ?>
                        <table cellpadding="0" cellspacing="0" width="100%" class="display" style="">
                            <thead>
                                <tr>
                                    <th width="30%">Sent By</th>
                                    <th width="55%">Message</th>
                                    <th width="15%">Date/Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($sms as $sms_m):
                                        $user = $this->ion_auth->get_user($sms_m->created_by)
                                        ?>
                                        <tr class="new">                                           
                                            <td>
                                                <?php echo $user->first_name . ' ' . $user->last_name; ?></a> <a href="#"><?php echo $user->email; ?>
                                            </td>
                                            <td><a href="#" class="subject"><?php echo $sms_m->relay; ?></a></td>
                                            <td><?php echo time_ago($sms_m->created_on); ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                endforeach
                                ?>                                                                       
                            </tbody>
                        </table>
                        <div class="toolbar bottom">
                        </div>
                <?php else: ?>
                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                <?php endif ?> 
            </div>
        </div>
    </div>
</div>

<script>
        function show_field(item) {
            //hide all
            //document.getElementById('cc').style.display='none';
            document.getElementById('rc_staff').style.display = 'none';
            document.getElementById('rc_parent').style.display = 'none';
            if (item == 'Staff')
                document.getElementById('rc_staff').style.display = 'block';
            if (item == 'Parent')
                document.getElementById('rc_parent').style.display = 'block';
            return;
        }
<?php
if ($this->uri->segment(3) == 'create')
{
        ?>
                show_field('None');
<?php } ?>
</script>