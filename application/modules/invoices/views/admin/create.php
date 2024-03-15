<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Invoices  </h2>
        <div class="right">
            <?php echo anchor('admin/invoices', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Invoices')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='term'>Term </div>
            <div class="col-md-10">
                <?php
                echo form_dropdown('term', array("" => "") + $this->terms, (isset($result->term)) ? $result->term : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('term');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2">Year </div>
            <div class="col-md-10">
                <?php
                $range = range(date('Y')-1, date('Y') + 2);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                echo form_dropdown('year', array("" => "") + $yrs, (isset($result->year)) ? $result->year : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('year');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2">Classes</div>
            <div class="col-md-10">
                <?php echo form_dropdown('classes[]', $this->classes, $this->input->post('class'), 'class ="select" data-placeholder="Leave blank to invoice all Classes" multiple '); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
                <?php echo anchor('admin/invoices', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>