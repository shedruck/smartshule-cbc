<div class="col-md-12">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2> Assign Users </h2>
        <div class="right">            
            <?php echo anchor('admin/messages', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Messages')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" >Headteacher User(s)<span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $teachers = $this->ion_auth->get_teachers_and_title();
                $adm = $this->ion_auth->get_admins();
                echo form_dropdown('head[]', $teachers + $adm, (isset($result->head)) ? $result->head : '', ' class="select" multiple data-placeholder="Select user..." ');
                echo form_error('head');
                ?>
                <hr/>
                <table width="100%" class="table" style="margin-bottom: 6px;">
                    <tbody>
                        <?php
                        if (isset($roster['head']))
                        {
                                $x = 0;
                                foreach ($roster['head'] as $h)
                                {
                                        $x++;
                                        $us = $this->ion_auth->get_user($h->user);
                                        ?>

                                        <tr>
                                            <td><?php echo $x; ?>. </td>
                                            <td><?php echo $us->first_name . ' ' . $us->last_name; ?></td>
                                            <td ><a href="<?php echo base_url('admin/messages/remove_user/' . $h->id); ?>" class="btn btn-warning" title="Remove User" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')">X</a></td>
                                        </tr>

                                        <?php
                                }
                        }
                        ?> 
                    </tbody>
                </table>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3">Front Office Users <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('front[]', $teachers + $adm, (isset($result->front)) ? $result->front : '', ' class="select" multiple data-placeholder="Select users..." ');
                ?>
                <hr/>
                <table width="100%" class="table" style="margin-bottom: 6px;">
                    <tbody>
                        <?php
                        if (isset($roster['front']))
                        {
                                $i = 0;
                                foreach ($roster['front'] as $f)
                                {
                                        $i++;
                                        $ush = $this->ion_auth->get_user($f->user);
                                        ?>                                
                                        <tr>
                                            <td><?php echo $i; ?>. </td>
                                            <td><?php echo $ush->first_name . ' ' . $ush->last_name; ?></td>
                                            <td><a href="<?php echo base_url('admin/messages/remove_user/' . $f->id); ?>" class="btn btn-warning" title="Remove User" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')">X</a></td>
                                        </tr>
                                        <?php
                                }
                        }
                        ?>                                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
                <?php echo anchor('admin/messages', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>    
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>