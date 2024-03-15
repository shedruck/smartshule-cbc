<div class="col-md-12">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Fee Waivers  </h2>
        <div class="right"> 
            <?php echo anchor('admin/fee_waivers/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Fee Waivers')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/fee_waivers', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Waivers')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>

    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>

        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN -->
                <thead>
                    <tr role="row">
                        <th width="3%">#</th>
                        <th width="10%">Date</th>
                        <th width="22%">Student</th>
                        <th width="12%">Amount</th>
                        <th width="9%">Term</th>
                        <th width="9%">Year</th>
                        <th width="35%">Remarks</th>
                    </tr>
                </thead>
            </table>

            <div id="entry1" class="clonedInput">

                <table cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>
                        <tr >
                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>

                            <td width="10%">
                                <?php echo form_input('date', $result->date > 0 ? date('d M Y', $result->date) : $result->date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
                            </td>
                            <td width="22%">
                                <?php
                                $data = $this->ion_auth->students_full_details();
                                echo form_dropdown('student', array('' => 'Select Student') + $data, (isset($result->student)) ? $result->student : '', ' class="xsel student" id="student" data-placeholder="Select Options..." ');
                                echo form_error('student');
                                ?>
                            </td>

                            <td width="12%">
                                <input type="text" name="amount" id="amount" class="amount" value="<?php
                                if (!empty($result->amount))
                                {
                                    echo $result->amount;
                                }
                                ?>">
                                       <?php echo form_error('amount'); ?>
                            </td>
                            <td width="9%">
                                <?php
                                echo form_dropdown('term', $this->terms, (isset($result->term)) ? $result->term : '', ' id="term" class="xsel term" ');
                                echo form_error('term');
                                ?>

                            </td>
                            <td width="9%">

                                <?php
                                $years = array_combine(range(date("Y"), 2005), range(date("Y"), 2005));
                                echo form_dropdown('year', $years, (isset($result->year)) ? $result->year : '', ' id="year" class="xsel year" ');
                                echo form_error('year');
                                ?>
                            </td>

                            <td width="35%">
                                <textarea name="remarks" cols="25" rows="1" class="col-md-12 remarks" style="resize:vertical;" id="remarks"><?php echo set_value('remarks', (isset($result->remarks)) ? htmlspecialchars_decode($result->remarks) : ''); ?></textarea>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div> 
        </div>

        <div class='form-group'><div class="col-md-12">

                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/fee_waivers', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<script type="text/javascript">

    $(function() {
        $(".xsel").select2({'placeholder': 'Please Select', 'width': '100%'});
        $(".xsel").on("change", function(e) {
            notify('Select', 'Value changed: ' + e.val);
        });
    });
</script>