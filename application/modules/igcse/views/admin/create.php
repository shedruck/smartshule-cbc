<div class="col-md-8">
  <div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Igcse </h2>
    <div class="right">
      <?php echo anchor('admin/igcse/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Igcse')), 'class="btn btn-primary"'); ?>
      <?php echo anchor('admin/igcse', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Igcse')), 'class="btn btn-primary"'); ?>

    </div>
  </div>


  <div class="block-fluid">

    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo   form_open_multipart(current_url(), $attributes);
    ?>
    <div class='form-group'>
      <div class="col-md-3" for='name'>Exam Thread</div>
      <div class="col-md-6">
        <?php echo form_input('title', $result->title, 'id="title_"  class="form-control" '); ?>
        <?php echo form_error('title'); ?>
      </div>
    </div>

    <div class='form-group'>
      <div class="col-md-3" for='term'>Term <span class='required'>*</span></div>
      <div class="col-md-9">
        <?php
        echo form_dropdown('term', $this->terms, (isset($result->term)) ? $result->term : '', ' class="select" data-placeholder="Select Options..." ');
        echo form_error('term');
        ?>
      </div>
    </div>

    <div class='form-group'>
      <div class="col-md-3" for='year'>Year <span class='required'>*</span></div>
      <div class="col-md-9">
        <?php
        krsort($yrs);
        echo form_dropdown('year', $yrs, $result->year, 'id="year_"  class="select" ');
        echo form_error('year');
        ?>
      </div>
    </div>

    <div class='form-group'>
      <div class="col-md-3">CATS Weight</div>
      <div class="col-md-9">
        <?php echo form_input('cats_weight', $result->cats_weight, ' class="form-control" '); ?>
        <?php echo form_error('cats_weight'); ?>
      </div>
    </div>

    <div class='form-group'>
      <div class="col-md-3">Main Exam Weight</div>
      <div class="col-md-9">
        <?php echo form_input('main_weight', $result->main_weight, ' class="form-control" '); ?>
        <?php echo form_error('main_weight'); ?>
      </div>
    </div>

    <div class='widget'>
      <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
        <h2>Description </h2>
      </div>
      <div class="block-fluid editor">
        <textarea id="description" style="height: 300px;" class=" wysiwyg " name="description" /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
        <?php echo form_error('description'); ?>
      </div>
    </div>

    <div class='form-group'>
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
        <?php echo anchor('admin/igcse', 'Cancel', 'class="btn  btn-default"'); ?>
      </div>
    </div>

    <?php echo form_close(); ?>
    <div class="clearfix"></div>
  </div>
</div>