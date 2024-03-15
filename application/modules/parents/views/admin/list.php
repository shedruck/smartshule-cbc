<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Parents  </h2>
  
    <div class="right">  

                <a    href="<?php echo base_url('admin/users/parent_credentials'); ?>" class="btn btn-success"> <span class="glyphicon glyphicon-envelope"></span> Send Logins</a>
        <?php echo anchor('admin/parents', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Parents')), 'class="btn btn-primary"'); ?>


				<?php echo anchor('admin/parents/link', '<i class="glyphicon glyphicon-folder">
                </i> Manage Siblings', 'class="btn btn-warning"'); ?>
    </div>
</div>
<?php if ($parents): ?>
        <div class="block-fluid">
        <?php echo form_open('admin/parents/filterByStatus')?>
    <div class="row col-md-12">
        <div class="col-md-9 filter">
        <select class="form-control" name="status"  >
            <option>Filter Parents By Status</option>
            <?php
                foreach ($mzazi as $pero) {
                    if($pero->status ==1){
                        $status="Active";
                    }else{
                        $status="Inactive";
                    }
                    ?>
                <option value="<?php echo $pero->status?>" id="status"><?php echo $status?></option>
            <?php }?>
        </select>
        </div>
        <div class="col-md-3 filter">
            <button name="filter_t" type="post" class="btn btn-md btn-primary">Filter</button>
        </div>
    </div>
    </form>
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Passport</th>
                <th>Name</th>
                <th>Phone</th>	
                <th>Occupation</th>	
                <th>Second Parent</th>
                <th>Address</th>
                <th>Email</th>
                <th>Status</th>
                <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
		
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per;
                    }
//$ttl = $this->ion_auth->populate('titles','id','name');
                    foreach ($parents as $p):
                            $i++;
                            if (!empty($p->first_name))
                            {
                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>
                                        <td>
										   <?php
													if (!empty($p->father_photo)):
													$passport = $this->portal_m->parent_photo($p->father_photo);
													  if ($passport)
															{
																	?> 
																	<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="40" height="40" class="img-polaroid" >
													 <?php } ?>	

													<?php else: ?>   
															<?php echo theme_image("member.png", array('class' => "img-polaroid", "width"=>"40","height"=>"40")); ?>
													<?php endif; ?> 
										
										</td>
                                        <td><?php echo isset($p->f_title) ? $p->f_title.' ' : ''; ?> <?php echo $p->first_name; ?> <?php echo $p->last_name; ?></td>
                                        <td><?php echo $p->phone; ?></td>
                                        <td><?php echo $p->occupation; ?></td>
                                        <td><?php echo isset($p->m_title) ? $p->m_title.' ' : ''; ?> <?php echo $p->mother_fname.' '.$p->mother_lname; ?> <br><?php echo $p->mother_phone; ?></td>
                                        <td><?php echo $p->address; ?></td>
                                        <td><?php echo $p->email; ?></td>
                                        <td><?php
                                            if ($p->status == 1)
                                                    echo '<span class="label label-warning">Active</span>';
                                            else
                                                    echo '<span class="label label-danger">Inactive</span>';
                                            ?></td>

                                        <td width=''>
                                            <div class='btn-group'>
                                                <a  class='btn btn-success btn-sm' href='<?php echo site_url('admin/parents/view/' . $p->id . '/' . $p->id); ?>'>
                                                    <i class='glyphicon glyphicon-eye-open'></i> Profile</a>
													
													  <?php
                                                if ($p->status == 1)
                                                {
                                                        ?>
                                                        <a  class='btn btn-danger btn-sm' href='<?php echo site_url('admin/parents/deactivate/' . $p->id); ?>'>
                                                            <i class='glyphicon glyphicon-eye-open'></i> Deactivate</a>
                                                        <?php
                                                }
                                                else
                                                {
                                                        ?>
                                                        <a  class='btn btn-warning btn-sm' href='<?php echo site_url('admin/parents/activate/' . $p->id); ?>'>
                                                            <i class='glyphicon glyphicon-eye-open'></i> Activate</a>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                            <?php } endforeach ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                                         <?php endif ?>
