<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Settings  </h2>
        <div class="right"> 

        </div>
    </div>

    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='school'>School Name<span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('school', $result->school, 'id="school_"  class="form-control" '); ?>
                <?php echo form_error('school'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='postal_addr'>Postal Address <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('postal_addr', $result->postal_addr, 'id="postal_addr_"  class="form-control" '); ?>
                <?php echo form_error('postal_addr'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='email'>Email <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('email', $result->email, 'id="email_"  class="form-control" '); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='email'>Telephone(landlines) </div><div class="col-md-6">
                <?php echo form_input('tel', $result->tel, 'id="tel" placeholder="E.g 020 89758" class="form-control" '); ?>
                <?php echo form_error('tel'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='email'>Cell Numbers <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('cell', $result->cell, 'id="cell"  placeholder="E.g 0721341214,0720000 etc" class="form-control" '); ?>
                <?php echo form_error('cell'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='email'>School Motto <span class='required'>*</span></div><div class="col-md-6">
                <textarea name="motto" cols="70" rows="1" class="col-md-12 motto  validate[required]" style="resize:vertical;" id="motto"><?php echo set_value('motto', (isset($result->motto)) ? htmlspecialchars_decode($result->motto) : ''); ?></textarea>

            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='website'>Website </div><div class="col-md-6">
                <?php echo form_input('website', $result->website, 'id="website_"  class="form-control" '); ?>
                <?php echo form_error('website'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='fax'>Fax </div><div class="col-md-6">
                <?php echo form_input('fax', $result->fax, 'id="fax_"  class="form-control" '); ?>
                <?php echo form_error('fax'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='town'>Town <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('town', $result->town, 'id="town_"  class="form-control" '); ?>
                <?php echo form_error('town'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='school_code'>School Code </div><div class="col-md-6">
                <?php echo form_input('school_code', $result->school_code, 'id="school_code_"  class="form-control" '); ?>
                <?php echo form_error('school_code'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='list_size'>Default Lists Size </div>
            <div class="col-md-6">
                <?php
                $tems = array('' => '', '10' => '10', '25' => '25', '50' => '50', '100' => '100', '200' => '200', '300' => '300');
                echo form_dropdown('list_size', $tems, (isset($result->list_size)) ? $result->list_size : '', ' id="list_size_" class="select" ');
                echo form_error('list_size');
                ?>
            </div>
        </div>
		  <div class='form-group'>
            <div class="col-md-3" for='school_code'>Default Message Initial <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('message_initial', $result->message_initial, 'id="message_initial" placeholder=" E.g Hello, Hi, A.A, Habari e.t.c" class="form-control" '); ?>
                <?php echo form_error('message_initial'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2" for='document'>Upload Logo </div>
            <div class="col-md-10">
                <input id='document' type='file' name='document' />

                <?php if ($updType == 'edit'): ?>
                    <a href='<?php echo base_url('uploads/files/' . $result->document); ?>' >Download actual file (logo)</a>
                <?php endif ?>

                <br/><?php echo form_error('document'); ?>
                <?php echo ( isset($upload_error['document'])) ? $upload_error['document'] : ""; ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-3"></div><div class="col-md-6">


                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/settings', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>