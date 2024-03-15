<div class="col-md-9">
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
            <div class="col-md-4" for='school'>School Name<span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('school', $result->school, 'id="school_"  class="form-control" '); ?>
                <?php echo form_error('school'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='postal_addr'>Address <span class='required'>*</span></div><div class="col-md-6">
                <?php
                $data = array(
                    'name' => 'postal_addr',
                    'id' => 'postal_addr_',
                    'value' => $this->input->post('postal_addr') ? $this->input->post('postal_addr') : $result->postal_addr,
                    'rows' => '2',
                    'cols' => '10',
                    'class' => 'form-control',
                );
                echo form_textarea($data);
                ?>
                <?php echo form_error('postal_addr'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='email'>Email <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('email', $result->email, 'id="email_"  class="form-control" '); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='email'>Telephone(landlines) </div><div class="col-md-6">
                <?php echo form_input('tel', $result->tel, 'id="tel" placeholder="E.g 020 89758" class="form-control" '); ?>
                <?php echo form_error('tel'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='email'>Cell Numbers <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('cell', $result->cell, 'id="cell"  placeholder="E.g 0721341214,0720000 etc" class="form-control" '); ?>
                <?php echo form_error('cell'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='email'>School Motto <span class='required'>*</span></div><div class="col-md-6">
                <textarea name="motto" cols="70" rows="1" class="col-md-12 motto  validate[required]" style="resize:vertical;" id="motto"><?php echo set_value('motto', (isset($result->motto)) ? htmlspecialchars_decode($result->motto) : ''); ?></textarea>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='website'>Website </div><div class="col-md-6">
                <?php echo form_input('website', $result->website, 'id="website_"  class="form-control" '); ?>
                <?php echo form_error('website'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='fax'>Fax </div><div class="col-md-6">
                <?php echo form_input('fax', $result->fax, 'id="fax_"  class="form-control" '); ?>
                <?php echo form_error('fax'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='town'>Town <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('town', $result->town, 'id="town_"  class="form-control" '); ?>
                <?php echo form_error('town'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='school_code'>School Code </div><div class="col-md-6">
                <?php echo form_input('school_code', $result->school_code, 'id="school_code_"  class="form-control" '); ?>
                <?php echo form_error('school_code'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='school_code'>Default SMS Sender ID </div><div class="col-md-6">
                <?php echo form_input('sender_id', $result->sender_id, 'id="school_code_"  class="form-control" '); ?>
                <?php echo form_error('sender_id'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='school_code'>Employees Time In <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('employees_time_in', $result->employees_time_in, 'id="employees_time_in"  class="form-control time_in col-md-12 input_ed timepicker" '); ?>
                <?php echo form_error('employees_time_in'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='school_code'>Employees Time Out <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('employees_time_out', $result->employees_time_out, 'id="employees_time_out"  class="form-control time_in col-md-12 input_ed timepicker" '); ?>
                <?php echo form_error('employees_time_out'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='list_size'>Default Lists Size </div>
            <div class="col-md-6">
                <?php
                $tems = array('' => '', '10' => '10', '25' => '25', '50' => '50', '100' => '100', '200' => '200', '300' => '300');
                echo form_dropdown('list_size', $tems, (isset($result->list_size)) ? $result->list_size : '', ' id="list_size_" class="select" ');
                echo form_error('list_size');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='message_initial'>Default Message Initial <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('message_initial', $result->message_initial, 'id="message_initial" placeholder=" E.g Hello, Hi, A.A, Habari e.t.c" class="form-control" '); ?>
                <?php echo form_error('message_initial'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='currency'>Default Currency <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('currency', $result->currency, 'id="currency" placeholder=" E.g Ksh., Tsh., USD, EURO e.t.c" class="form-control" '); ?>
                <?php echo form_error('currency'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='pre_school'>Use Remarks for Pre-School<span class='required'>*</span></div><div class="col-md-6">
                <?php
                $ops = array('1' => 'Yes', '0' => 'No');
                echo form_dropdown('pre_school', $ops, (isset($result->pre_school)) ? $result->pre_school : '', ' id="pre_school" class="select" ');
                echo form_error('pre_school');
                ?>
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
        <div class='form-group'>
            <div class="col-md-4" for='prefix'>Admission No. Prefix<span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_input('prefix', (isset($result->prefix)) ? $result->prefix : '', ' id="prefix" class="form-control" ');
                echo form_error('prefix');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='relief'>Tax Relief<span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_input('relief', (isset($result->relief)) ? $result->relief : '', ' id="relief" class="form-control" ');
                echo form_error('relief');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-4" for='mobile_pay'>Mobile Payment Info </div>
            <div class="col-md-6">
                <?php
                $arr = array(
                    'name' => 'mobile_pay',
                    'id' => 'mobile_pay',
                    'value' => $this->input->post('mobile_pay') ? $this->input->post('mobile_pay') : $result->mobile_pay,
                    'rows' => '2',
                    'cols' => '10',
                    'class' => 'form-control'
                );
                echo form_textarea($arr);
                ?>
                <?php echo form_error('mobile_pay'); ?>
            </div>
        </div>
        <div class='form-group'><div class="col-md-4"></div><div class="col-md-6">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/settings', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
