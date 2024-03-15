
<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Fee Structure  </h2> 
        <div class="right">                            
            <?php echo anchor('admin/fee_structure/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> Add New Fee Structure', 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/fee_structure/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        </div>    					
    </div>

    <div class="block-fluid"> 
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>  
        <div class='form-group'>
            <div class="col-md-3" for='term'>School Term </div>
            <div class="col-md-9">
                <?php
                echo form_dropdown('term[]', $this->terms, $this->input->post('term'), ' class="select" multiple="multiple" ');
                echo form_error('term');
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='school_class'>School Class </div>
            <div class="col-md-9">
                <?php
                echo form_dropdown('school_class[]', $class, $this->input->post('school_class'), ' class="select" multiple="multiple" ');
                echo form_error('school_class');        
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='tuition'>Tuition Fee Amount</div>
            <div class="col-md-9">
                     <?php echo form_input('tuition', $this->input->post('tuition'), 'class=" form-control col-md-4"'); ?>
                 <?php echo form_error('tuition'); ?>
            </div>
        </div> 
        <div class='form-group'><div class="control-div"></div>
            <div class="col-md-9"> 
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/fee_structure', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>


        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
        $(function () {
            $('#btnAdd').click(function ()
            {
                //$('input.timepicker').eq(0).clone().removeClass("hasTimepicker").prependTo('#entry2');
                var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
                var newNum = new Number(num + 1 + '.'), // the numeric ID of the new input field being added
                        newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
                // manipulate the name/id values of the input inside the new element
                // H2 - section
                newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum + '. ');

                // subject - select
                //   newElem.find('.ftype').removeClass("select").attr('id', 'ID' + newNum + '_ftype').select2({'placeholder': 'Please Select', 'width': '300px'});

                // subject - select
                newElem.find('.title').attr('id', 'ID' + newNum + '_title').val('').focus();
                newElem.find('.amount').attr('id', 'ID' + newNum + '_amount').val('');
                newElem.find('.ftype').attr('id', 'ID' + newNum + '_ftype').val('');

                // insert the new element after the last "duplicatable" input field
                $('#entry' + num).after(newElem);

                // enable the "remove" button
                $('#btnDel').attr('disabled', false);

                // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
                if (newNum == 100)
                    $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
            });

            $('#btnDel').click(function () {
                var num = $('.clonedInput').length;
                if (num == 1)
                {
                    // if only one element remains, disable the "remove" button
                    alert("At least one Row Required.");
                    $('#btnDel').attr('disabled', true);
                } else
                {
                    // confirmation
                    if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
                    {
                        // how many "duplicatable" input fields we currently have
                        $('#entry' + num).slideUp('slow', function () {
                            $(this).remove();

                            // enable the "add" button
                            $('#btnAdd').attr('disabled', false).prop('value', "add section");
                        });
                    }
                    return false;
                    // remove the last element

                    // enable the "add" button
                    $('#btnAdd').attr('disabled', false);
                }
            });

            $('#btnDel').attr('disabled', true);
        });

</script> 