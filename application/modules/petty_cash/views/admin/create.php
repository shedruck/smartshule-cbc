<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Petty Cash  </h2>
        <div class="right"> 
            <?php echo anchor('admin/petty_cash/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Petty Cash')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/petty_cash', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Petty Cash')), 'class="btn btn-primary"'); ?> 
         </div>
    </div>
 
    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='petty_date'>Petty Date <span class='required'>*</span></div>
            <div class="col-md-6">
			   <div id="datetimepicker1" class="input-group date form_datetime">
                <?php
                $dt = '';
                if ($result->petty_date)
                {
                    if ((!preg_match('/[^\d]/', $result->petty_date)))//if it contains digits only
                    {
                        $dt = date('d M Y', $result->petty_date);
                    }
                    else
                    {
                        $dt = $result->petty_date;
                    }
                }
                echo form_input('petty_date', $dt, 'class="validate[required] form-control datepicker col-md-6"');
				?>
				 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>

                </div>
              <?  echo form_error('petty_date'); ?>
             </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='description'>Description <span class='required'>*</span></div><div class="col-md-6">
                <textarea name="description" cols="100" rows="1" class="col-md-12 description  validate[required]" style="resize:vertical;" id="description"><?php echo set_value( (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='amount'>Amount <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('amount', $result->amount, 'id="amount_"  class="form-control" '); ?>
                <?php echo form_error('amount'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='person'>Person Responsible<span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_dropdown('person', array(''=>'Select')+$users, (isset($result->person)) ? $result->person : '', ' class="select" data-placeholder="Select  Options..." ');
                ?>		
                <?php echo form_error('person'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
 
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/petty_cash', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
