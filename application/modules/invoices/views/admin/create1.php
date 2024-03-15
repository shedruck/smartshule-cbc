<?php $term = get_term(date('m')); ?>
<div class="col-md-6">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2> Invoices For Tuition Fee </h2>
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
                $range = range(date('Y'), date('Y') + 1);
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
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-10">
                <input type="checkbox" name="transport" class="form-control" value="1" checked/> Invoice Transport Fee
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <button type="submit" class="btn btn-primary" value="2" name="tuition">Create Invoices</button>
                <?php echo anchor('admin/invoices', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<div class="col-md-6">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2> Invoices For Other Fees </h2>
        <div class="right">
            <?php echo anchor('admin/invoices', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Invoices')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <div class="alert alert-info">
            <span>This option replicates Fee Extras Invoices for Term 1 in the current year into the selected term</span>
        </div>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='term'>Term </div>
            <div class="col-md-10">
                <?php
                $list = $this->terms;
                unset($list[1]);

                echo form_dropdown('term', array("" => "") + $list, (isset($result->term)) ? $result->term : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('term');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <button type="submit" class="btn btn-primary" value="4" name="extras">Create Invoices</button>
                <?php echo anchor('admin/invoices', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
