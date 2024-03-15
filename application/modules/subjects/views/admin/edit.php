<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Subjects </h2>

        <div class="right">
            <?php echo anchor('admin/subjects/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/subjects', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?>
        </div>
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='name'>Name <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('name', $result->name, 'id="name_"  class="form-control" '); ?>
                <?php echo form_error('name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='code'>Code</div>
            <div class="col-md-6">
                <?php echo form_input('code', $result->code, 'id="code_"  class="form-control" '); ?>
                <?php echo form_error('code'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='short_name'>Short Name <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('short_name', $result->short_name, 'id="short_name_"  class="form-control" '); ?>
                <?php echo form_error('short_name'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='priority'>Priority <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('priority', $result->priority, 'id="priority"  class="form-control" '); ?>
                <?php echo form_error('priority'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='is_optional'>Type <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $ifr = array(
                    "0" => "Regular Subject",
                    "1" => "Optional Subject",
                    "2" => "Elective Subject",
                    "3" => "Inactive"
                );
                echo form_dropdown('is_optional', $ifr, (isset($result->is_optional)) ? $result->is_optional : '', ' class="qsel" placeholder="Is Subject Optional?" ');
                echo form_error('is_optional');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='sub_units'>Sub Units <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $items = array(
                    '' => '',
                    "1" => "Yes",
                    "0" => "No"
                );
                echo form_dropdown('sub_units', $items, (isset($result->sub_units)) ? $result->sub_units : '', ' class="qsel" placeholder="Does Subject have Sub Units?" ');
                echo form_error('sub_units');
                ?>
            </div>
        </div>
		
		

        <?php
        if ($this->input->post())
        {
                $flag = $this->input->post('sub_units') == 1 ? '' : ' style="display: none" ';
        }
        elseif (isset($result->subs) && !empty($result->subs))
        {
                $flag = '';
        }
        else
        {
                $flag = ' style="display: none" ';
        }
        ?>
		
		<div class="form-group">
				<div class="col-md-3">Custom Subject: <span class='required'>*</span></div>
				<div class="col-md-6"> 
				   
					<div class = "radio"> <input type = "radio" <?php echo $result->custom ?> value="1" name = "custom" class = "validate[required]" > </div>Yes
					<div class = "radio"> <input type = "radio" <?php echo $result->custom ?> value="0" checked name = "custom"  class = "validate[required]"> </div>No
				</div>
			</div>

        <div class='form-group'>
            <div class="col-md-12">Assign Subject to Classes</div>
            <div class="col-md-6"></div>
        </div>
        <?php
        if ($this->input->post())
        {
                $len = count($this->input->post('class'));
                for ($ii = 0; $ii < $len; $ii++)
                {
                        $amval = '';
                        $ffval = '';
                        if ($this->input->post('class'))
                        {
                                $fval = $this->input->post('class');
                                $ffval = $fval[$ii];
                        }
                        $ttval = '';
                        if ($this->input->post('term'))
                        {
                                $tval = $this->input->post('term');
                                $ttval = $tval[$ii];
                        }
                        ?>
                        <div id="entry<?php echo $ii + 1; ?>" class="clonedInput">
                            <div class='form-group '>
                                <div class="col-md-3">
                                    <?php echo form_dropdown('class[]', array('' => 'Select class') + $this->classes, $ffval, ' class="xsel validate[required]"'); ?>
                                    <?php echo form_error('class'); ?>
                                </div>
                                <div class="col-md-5">
                                    <?php echo form_dropdown('term[' . $ii . '][]', array('' => '') + $this->terms, $ttval, 'id="term_" multiple  class="fsel validate[required]" placeholder="Select Terms" '); ?>
                                    <?php echo form_error('term'); ?>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger dello"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>

                            </div>
                        </div>
                        <?php
                }
        }
        else
        {
                if (isset($result->classign) && !empty($result->classign))
                {
                        $t = 0;
                        foreach ($result->classign as $tcl => $tmr)
                        {
                                ?>
                                <div id="entry<?php echo $t; ?>" class="clonedInput">
                                    <div class='form-group '>
                                        <div class="col-md-3">
                                            <?php echo form_dropdown('class[]', array('' => 'Select class') + $this->classes, $tcl, 'id="class_" class="xsel validate[required] class_"'); ?>
                                            <?php echo form_error('class'); ?>
                                        </div>
                                        <div class="col-md-5">
                                            <?php echo form_dropdown('term[' . $t . '][]', $this->terms, $tmr, 'id="term_" multiple  class="fsel validate[required] term_" placeholder="Select Terms" '); ?>
                                            <?php echo form_error('term'); ?>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger dello"><span class="glyphicon glyphicon-remove"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $t++;
                        }
                }
                else
                {
                        ?>
                        <div id="entry0" class="clonedInput">
                            <div class='form-group '>
                                <div class="col-md-3">
                                    <?php echo form_dropdown('class[]', array('' => 'Select class') + $this->classes, '', 'id="class_" class="xsel validate[required] class_"'); ?>
                                    <?php echo form_error('class'); ?>
                                </div>
                                <div class="col-md-5">
                                    <?php echo form_dropdown('term[0][]', $this->terms, '', 'id="term_" multiple  class="fsel validate[required] term_" placeholder="Select Terms" '); ?>
                                    <?php echo form_error('term'); ?>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger dello"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>

                            </div>
                        </div>
                <?php } ?>
        <?php } ?>
        <div class="actions">
            <a id="btnAdd" class="btn btn-success clone">Add New Line</a>
        </div>
        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/subjects', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<script>
        $(document).ready(
                function ()
                {
                    $(".qsel").select2({'placeholder': 'Please Select', 'width': '100%'});
                    $(".qsel").on("change", function (e)
                    {
                        if (e.val == 1)
                        {
                            $('#show_subs').show();
                        }
                        else
                        {
                            $('#show_subs').hide();
                        }

                    });
                    $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
                    $(".xsel").select2({'placeholder': 'Please Select', 'width': '100%'});
                    $('#btnAdd').click(function ()
                    {
                        var num = $('.clonedInput:last').attr('id');
                        num = num.replace('entry', '');
                        var newNum = new Number(num) + 1; // the numeric ID of the new input field being added
                        var newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow');
                        newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum + '. ');
                        // subject - select
                        newElem.find('table tr td select.class_').attr('id', 'class_' + newNum);
                        newElem.find('.term_').attr('id', 'term_' + newNum).val('').focus();
                        newElem.find('.term_').attr('name', 'term[' + newNum + '][]').val('');
                        newElem.find('.xsel').val('');
                        $('#entry' + num).after(newElem);
                        /********************BEGIN SELECT2 CLONE*******************************/
                        newElem.find('.select2-container').remove();
                        newElem.find('select').select2({'width': '100%'});
                        /********************END SELECT2 CLONE*******************************/

                        if (newNum == 30)
                        {
                            $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
                        }
                    });
                    $(document).on('click', '.dello', function ()
                    {
                        var num = $('.clonedInput').length;
                        var cc = $(this).parent('.col-md-1').parent('.form-group');
                        var class_id = cc.children('div.col-md-3').children('select.xsel').val();
                        // confirmation
                        if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
                        {
                            $.ajax({
                                url: "<?php echo base_url('admin/subjects/remove_class/' . $id); ?>",
                                type: "post",
                                data: {class: class_id},
                                success: function (data)
                                {
                                    cc.slideUp('slow', function ()
                                    {
                                        cc.remove();
                                    });
                                }
                            });
                        }
                    });

                });
</script>