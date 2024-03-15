<div class="col-md-12">
  <div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Transport Drivers </h2>
    <div class="right">
      <?php echo anchor('admin/transport_drivers/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Transport Drivers')), 'class="btn btn-primary"'); ?>
      <?php echo anchor('admin/transport_drivers', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Transport Drivers')), 'class="btn btn-primary"'); ?>

    </div>
  </div>


  <div class="block-fluid">

    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo   form_open_multipart(current_url(), $attributes);
    ?>
    <div class="col-md-12 form-group">

      <div class=' col-md-6'>
        <div class="col-md-3" for='fname'>First Name </div>
        <div class="col-md-9">
          <?php echo form_input('first_name', $result->first_name, 'id="name_"  class="form-control" '); ?>
          <?php echo form_error('first_name'); ?>
        </div>
      </div>

      <div class=' col-md-6'>
        <div class="col-md-3" for='fname'>Middle Name </div>
        <div class="col-md-9">
          <?php echo form_input('middle_name', $result->middle_name, 'id="name_"  class="form-control" '); ?>
          <?php echo form_error('middle_name'); ?>
        </div>
      </div>
    </div>

    <div class="col-md-12 form-group">

      <div class=' col-md-6'>
        <div class="col-md-3" for='fname'>Last Name </div>
        <div class="col-md-9">
          <?php echo form_input('last_name', $result->last_name, 'id="name_"  class="form-control" '); ?>
          <?php echo form_error('last_name'); ?>
        </div>
      </div>

      <div class=' col-md-6'>
        <div class="col-md-3" for='fname'>Phone Number </div>
        <div class="col-md-9">
          <?php echo form_input('phone', $result->phone, 'id="name_"  class="form-control" '); ?>
          <?php echo form_error('phone'); ?>
        </div>
      </div>
    </div>

    <div class="col-md-12 form-group">
      <div class=' col-md-6'>
        <div class="col-md-3" for='fname'>Email </div>
        <div class="col-md-9">
          <?php echo form_input('email', $result->email, 'id="email"  class="form-control" '); ?>
          <?php echo form_error('email'); ?>
        </div>
      </div>

      <div class=' col-md-6'>
        <div class="col-md-3" for='fname'>Driving License No. </div>
        <div class="col-md-9">
          <?php echo form_input('driving_license', $result->driving_license, 'id="name_"  class="form-control" '); ?>
          <?php echo form_error('driving_license'); ?>
        </div>
      </div>


    </div>

    <div class="col-md-12 form-group">

      <div class=' col-md-6'>
        <div class="col-md-3" for='fname'>Driving License Exp Date </div>
        <div class="col-md-9">
          <input id='expiry_date' type='text' name='expiry_date' maxlength='' class='form-control datepicker' value="<?php echo set_value('expiry_date', (isset($result->expiry_date)) ? $result->expiry_date : ''); ?>" />
          <?php echo form_error('expiry_date'); ?>
        </div>
      </div>
      <div class=' col-md-6'>
        <div class="col-md-3" for='fname'>Category </div>
        <div class="col-md-9">
          <?php
          echo form_dropdown('category', $categories, (isset($result->category)) ? $result->category : '', ' class="select" ');
          ?>

          <?php echo form_error('category') ?>
        </div>
      </div>
    </div>

    <?php
      if($updType == 'create'){
      ?>
    <div class="col-md-12 form-group">
      <div class=' col-md-6'>
        <div class="col-md-3" for='fname'>User Group </div>
        <div class="col-md-9">
          <?php
          echo form_dropdown('group', $groups_list, (isset($result->group)) ? $result->group : '', ' class="select" required ');
          ?>

        </div>
      </div>
    </div>
    <?php }?>

    <div class='form-group'>
      <div class="col-md-3"></div>
      <div class="col-md-6">


        <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
        <?php echo anchor('admin/transport_drivers', 'Cancel', 'class="btn  btn-default"'); ?>
      </div>
    </div>

    <?php echo form_close(); ?>
    <div class="clearfix"></div>
  </div>
</div>