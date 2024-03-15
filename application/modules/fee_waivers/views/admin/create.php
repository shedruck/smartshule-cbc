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
        $data = $this->ion_auth->students_full_details();
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>

        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN -->
                <thead>
                    <tr >
                        <th width="3%">#</th>
                        <th width="10%">Date</th>
                        <th width="32%">Student</th>
                        <th width="12%">Amount</th>
                        <th width="9%">Term</th>
                        <th width="9%">Year</th>
                        <th width="25%">Remarks</th>
                    </tr>
                </thead>
            </table>

            <div id="entry1" class="clonedInput">

                <table cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>
                        <tr>
                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>

                            <td width="10%">
                                <input id='date' type='text' name='date[]' style="" class='date   datepicker' value=""  />
                                <?php echo form_error('date'); ?>
                            </td>
                            <td width="32%">
                                <?php
                                echo form_dropdown('student[]', $data, (isset($result->student)) ? $result->student : '', ' class="xsel student" id="student" style="width:180px !important;" ');
                                echo form_error('student');
                                ?>
                            </td>

                            <td width="12%">

                                <input type="text" name="amount[]" id="amount" class="amount" value="<?php
                                if (!empty($result->amount))
                                {
                                    echo $result->amount;
                                }
                                ?>">
                                       <?php echo form_error('amount'); ?>
                            </td>
                            <td width="9%">
                                <?php
                                echo form_dropdown('term[]', $this->terms, (isset($result->term)) ? $result->term : '', ' id="term" class="xsel term" ');
                                echo form_error('term');
                                ?>

                            </td>
                            <td width="9%">
                                <?php
								 $time = strtotime('1/1/2010');
									$dates = array();

									for ($i=0; $i<29; $i++) {
										$dates[date('Y', mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time)+$i))] = date('Y', mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time)+$i));        
									}
									
                               
                                echo form_dropdown('year[]',array('2015'=>'2015')+ $dates, (isset($result->year)) ? $result->year : '', ' id="year" class="xsel year" ');
                                echo form_error('year');
                                ?>

                            </td>

                            <td width="25%">
                                <textarea name="remarks[]" cols="25" rows="1" class="col-md-12 remarks  validate[required]" style="resize:vertical;" id="remarks"><?php echo set_value('remarks', (isset($result->remarks)) ? htmlspecialchars_decode($result->remarks) : ''); ?></textarea>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="actions">
                <a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a> 
                <a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
            </div>
        </div>


        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/fee_waivers', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">

    $(function() {
        $('#btnAdd').click(function() {

            //$('input.timepicker').eq(0).clone().removeClass("hasTimepicker").prependTo('#entry2');
            var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                    newNum = new Number(num + 1), // the numeric ID of the new input field being added
                    newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
            // manipulate the name/id values of the input inside the new element
            // H2 - section
            newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);

            // subject - select
            newElem.find('.date').attr('id', 'ID' + newNum + '_date').val('').removeClass("hasDatepicker").datepicker({
                format: "dd MM yyyy",
            }).focus();

            newElem.find('.amount').attr('id', 'ID' + newNum + '_amount').val('');

            newElem.find('.student').attr('id', 'ID' + newNum + '_student').val('');
            newElem.find('.year').attr('id', 'ID' + newNum + '_year').val('');

            newElem.find('.remarks').attr('id', 'ID' + newNum + '_remarks').val('');

            // insert the new element after the last "duplicatable" input field
            $('#entry' + num).after(newElem);
            /********************BEGIN SELECT2 CLONE*******************************/
            newElem.find('.select2-container').remove();
            newElem.find('select').select2({'width': '100%'});
            /********************END SELECT2 CLONE*******************************/

            // enable the "remove" button
            $('#btnDel').attr('disabled', false);

            // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
            if (newNum == 100)
                $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
        });

        $('#btnDel').click(function() {
            // confirmation
            if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
            {
                var num = $('.clonedInput').length;
                // how many "duplicatable" input fields we currently have
                $('#entry' + num).slideUp('slow', function() {
                    $(this).remove();
                    // if only one element remains, disable the "remove" button
                    if (num - 1 === 1)
                        $('#btnDel').attr('disabled', true);
                    // enable the "add" button
                    $('#btnAdd').attr('disabled', false).prop('value', "add section");
                });
            }
            return false;
            // remove the last element

            // enable the "add" button
            $('#btnAdd').attr('disabled', false);
        });

        $('#btnDel').attr('disabled', true);

        $(".xsel").select2({'placeholder': 'Please Select', 'width': '100%'});
        $(".xsel").on("change", function(e) {
            notify('Select', 'Value changed: ' + e.val);
        });
    });


</script> 
