<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>  Expenses </h2> 
        <div class="right">         
            <?php echo anchor('admin/expenses/create/' . $page, '<i class="glyphicon glyphicon-plus">                </i>' . lang('web_add_t', array(':name' => 'Expenses')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/expenses/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?> 
        </div>					
    </div>
    <div class="block-fluid"> 
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>

        <div class='form-group'>
            <div class="col-md-2" for='expense_date'>Expense Date </div><div class="col-md-10">

                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('expense_date', $result->expense_date > 0 ? date('d M Y', $result->expense_date) : $result->expense_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
                </div>
                <?php echo form_error('expense_date'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2" for='title'>Title </div><div class="col-md-10">
                <?php
                echo form_dropdown('title', $items, (isset($result->title)) ? $result->title : '', ' class=" title" id="title"   data-placeholder="Select Options..." ');
                echo form_error('title');
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='category'>Category </div>
            <div class="col-md-10">
                <?php
                echo form_dropdown('category', $cats, (isset($result->category)) ? $result->category : '', ' class="chzn-select" data-placeholder="Select Options..." ');
                echo form_error('category');
                ?>
            </div></div>
        <div class='form-group'>
            <div class="col-md-2" for='amount'>Amount </div><div class="col-md-10">
                <?php echo form_input('amount', $result->amount, 'id="amount_"  class="form-control" '); ?>
                <?php echo form_error('amount'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='person_responsible'>Person Responsible </div>
            <div class="col-md-10">
                <?php
                $staff = $this->ion_auth->list_staff();
                echo form_dropdown('person_responsible', array('' => 'Select Staff') + $staff, (isset($result->person_responsible)) ? $result->person_responsible : '', ' class="chzn-select" data-placeholder="Select Options..." ');
                echo form_error('person_responsible');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2" for='receipt'>Upload Receipt </div>
            <div class="col-md-10">
                <input id='receipt' type='file' name='receipt' />
                <?php if ($updType == 'edit'): ?>
                        <a href='<?php echo base_url('uploads/files/' . $result->receipt); ?>' >Download actual file (receipt)</a>
                <?php endif ?>

                <br/><?php echo form_error('receipt'); ?>
                <?php echo ( isset($upload_error['receipt'])) ? $upload_error['receipt'] : ""; ?>
            </div>
        </div>

        <div class='form-group'>
         <div class="col-md-2" for='bank'>Bank Account </div><div class="col-md-10">
         <?php
            echo form_dropdown('bank_id', array('' => 'Select Bank Account') + $bank, (isset($result->bank_id)) ? $result->bank_id : '', ' class="bank_id Select select-2" id="bank_id" ');
                                ?>
            </div>
        </div
        <div class="widget">
            <div class="head dark">
                <div class="icon"><i class="icos-pencil"></i></div>
                <h2>Description</h2>
            </div>
            <div class="block-fluid editor">
                <textarea id="wysiwyg"  name="description" style="height: 300px;">
                    <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>
            </div>
        </div>
        <div class='form-group'><div class="control-div"></div>
            <div class="col-md-10">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/expenses', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-4">
    <div class="widget ">
        <div class="head dark">
            <div class="icon"><span class="icosg-list "></span></div>
            <h2>Add Expense Item</h2>
        </div>
        <div class="block-fluid">
            <?php echo form_open('admin/expense_items/quick_add', 'class=""'); ?>
            <div class="form-group">
                <div class="col-md-3">Name:</div>
                <div class="col-md-6">                                      
                    <?php echo form_input('name', '', 'id="title_1"  placeholder=" E.g Rice, Fuel, Pens, Electricity etc."'); ?>
                    <?php echo form_error('name'); ?>
                </div>
            </div>
            <div class="toolbar TAR">
                <button class="btn btn-primary">Add Item</button>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>
    <div class="widget">
        <div class="head dark">
            <div class="icon"></div>
            <h2>Add Item Category</h2>
        </div>
        <div class="block-fluid">
            <?php echo form_open('admin/expenses_category/quick_add', 'class=""'); ?>
            <div class="form-group">
                <div class="col-md-3">Name:</div>
                <div class="col-md-9">                                      
                    <?php echo form_input('title', '', 'id="title_1"  placeholder=" e.g Stationary, Water, Electricity etc."'); ?>
                    <?php echo form_error('title'); ?>
                </div>
            </div>
            <div class="toolbar TAR">
                <button class="btn btn-primary">Add Category</button>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>
</div>