<?php
if ($this->input->get('sw'))
{
        $sel = $this->input->get('sw');
}
elseif ($this->session->userdata('pop'))
{
        $sel = $this->session->userdata('pop');
}
else
{
        $sel = 0;
}
?>
<style>
    .editable-input
    {
        width: 90px;
    }
</style>
<div class="col-md-9">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Manage Fee Extras  & Invoice</h2> 
        <div class="right">                            
            <?php echo anchor('admin/fee_structure/extras', '<i class="glyphicon glyphicon-list">
                </i> Fee Extras', 'class="btn btn-primary"'); ?>
        </div>    					
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='student'>Select Student</div>
            <div class="col-md-9">
                <?php echo form_input('student', '', 'class=" form-control sella  " data-context="student,list" '); ?>
                <?php echo form_error('student'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='term'>Term</div>
            <div class="col-md-9">
                <?php
                echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), ' class="fsel validate[required]"');
                echo form_error('term');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='year'>Year</div>
            <div class="col-md-9">
                <?php
                $yrange = range(date('Y') - 2, date('Y') + 1);
                $yrs = array_combine($yrange, $yrange);
                krsort($yrs);
                echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), ' class="fsel validate[required]"');
                echo form_error('year');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='fee'>Select Fee</div>
            <div class="col-md-9">
                <?php
                echo form_dropdown('fee', array('' => 'Select Fee') + $extras, $this->input->post('fee'), ' class="fsel validate[required]"');
                echo form_error('fee');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="control-div"></div>
            <div class="col-md-3">
                <?php echo form_submit('extras', 'Fee Extras', "id='submit-ex'  class='btn btn-primary'"); ?>
            </div>
            <div class="col-md-3">
                <?php echo form_submit('invoices', 'Tuition Fee Invoices', "id='invoices_t' class='btn btn-primary '"); ?>
            </div>
            <div class="col-md-3">
                <?php //echo form_submit('uniform', 'Uniform Invoices', "id='invoices' class='btn btn-primary '"); ?>
        </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
        <?php
        if ($show && isset($feex))
        {
                ?>
            <h3> Fee Extras </h3>
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => 'bx');
            echo form_open_multipart(base_url('admin/fee_structure/delete_bulk_extras'), $attributes);
            ?>
                <table width="100%" class="fxtbl invoice">
                    <thead>
                        <tr>
                            <th width="6%">#</th>
                            <th width="18%">Name</th>
                            <th width="20%">Fee</th>
                            <th width="7%">Term</th>
                            <th width="7%">Year</th>
                        <th width="34%"> Amount</th>
                        <th width="4%"> <input type="checkbox" class="checkall"/></th>
                            <th width="4%"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($feex as $key => $rspecs)
                        {
                                foreach ($rspecs as $r)
                                {
                                        $fxname = isset($extras[$r->fee_id]) ? $extras[$r->fee_id] : '';
                                        $std = $this->worker->get_student($r->student);
                                        $i++;
                                        ?>
                                        <tr class="trf" id="xf<?php echo $r->id; ?>">
                                            <?php
                                            $nm = 'fee_' . $r->id;
                                            ?>
                                            <td> <?php echo $i . '. '; ?></td>
                                            <td> <?php echo $std->first_name . ' ' . $std->last_name; ?></td>
                                            <td> <?php echo $fxname; ?></td>
                                <td>
                                    <span class="editable fxt" id="t_<?php echo $r->id; ?>" data-rec="<?php echo $r->student; ?>">
                                        <?php echo $r->term; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="editable fxy" id="y_<?php echo $r->id; ?>" data-rec="<?php echo $r->student; ?>">
                                        <?php echo $r->year; ?>
                                    </span>
                                </td>
                                            <td class="bglite">
                                                <span class="editable fxamount" id="<?php echo $nm; ?>" data-rec="<?php echo $r->student; ?>">
                                        <?php echo $r->amount; ?>
                                    </span>
                                            </td>
                                <td> <input type="checkbox" name="sids[<?php echo $r->student; ?>][]" value="<?php echo $r->id; ?>"/></td>
                                            <td> <button data-id="<?php echo $r->id; ?>" data-content="<?php echo $r->student; ?>" class="fxdel btn-danger">X</button></td>
                                        </tr>
                                        <?php
                                }
                        }
                        ?>         
                    <tr class="trf">
                        <td colspan="6">  </td>
                        <td colspan="2"><?php echo form_submit('extras', 'Remove Selected', "id='submit'  class='btn btn-warning pull-right'"); ?></td>
                    </tr>
                    </tbody>
                </table>

            <?php echo form_close(); ?>
        <?php } ?>
        <?php
        if ($iv)
        {
                ?>
                <h3> Invoices</h3>
                <table width="100%" class="fxtbl invoice">
                    <thead>
                        <tr>
                            <th width="6%">#</th>
                            <th width="18%">Name</th>
                            <th width="20%">Fee</th>
                            <th width="7%">Term</th>
                            <th width="7%">Year</th>
                            <th width="38%"> Amount</th>
                            <th width="4%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($invoices as $v)
                        {
                                $i++;
                                ?>
                                <tr class="trf" id="xf<?php echo $v->id; ?>">
                                    <td> <?php echo $i . '. '; ?></td>
                                    <td> <?php echo $v->student; ?></td>
                                    <td>Tuition Fee</td>
                            <td>
                                <span class="editable xterm" data-rec="<?php echo $v->id; ?>">
                                    <?php echo $v->term; ?>
                                </span>
                            </td>
                            <td>
                                <span class="editable xyear" data-rec="<?php echo $v->id; ?>">
                                    <?php echo $v->year; ?>
                                </span>
                            </td>
                                    <td class="bglite">
                                        <span class="editable ixamount" data-rec="<?php echo $v->id; ?>">
                                            <?php echo $v->amount; ?>
                                        </span>
                                    </td>
                                    <td> <button data-id="<?php echo $v->id; ?>" data-content="<?php echo $v->student_id; ?>" class="idel btn-danger">X</button></td>
                                </tr>
                                <?php
                        }
                        ?>         
                    </tbody>
                </table>
        <?php } ?>
        <?php
        if ($unf)
        {
            ?>
            <h3>Uniform Invoices</h3>
            <table width="100%" class="fxtbl invoice">
                <thead>
                    <tr>
                        <th width="6%">#</th>
                        <th width="30%">Name</th>
                        <th width="33%">Fee</th>
                        <th width="7%">Term</th>
                        <th width="7%">Year</th>
                        <th width="12%"> Amount</th>
                        <th width="4%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($uniform as $v)
                    {
                        $i++;
                        ?>
                        <tr class="trf" id="xf<?php echo $v->id; ?>">
                            <td> <?php echo $i . '. '; ?></td>
                            <td> <?php echo $v->student; ?></td>
                            <td><?php echo isset($sale_items[$v->item_id]) ? $sale_items[$v->item_id] : ''; ?></td>
                            <td> <?php echo $v->term; ?></td>
                            <td> <?php echo $v->year; ?></td>
                            <td class="bglite">
                                <span class="editable ufamount" data-rec="<?php echo $v->id; ?>">
                                    <?php echo $v->amount; ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo base_url('admin/fee_structure/void_sales/' . $v->id); ?>" target="_blank" class="hidden btn btn-danger">View</a>
                                <button data-id="<?php echo $v->id; ?>" data-content="<?php echo $v->student; ?>" class="fdel btn-danger">X</button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
<div class="col-md-3">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icosg-newtab"></span></div>
            <h2>Class</h2>
        </div>
        <div class="block-fluid">
            <ul class="list tickets">
                <?php
                $i = 0;
                foreach ($this->classlist as $cid => $cl)
                {
                        $i++;
                        $cc = (object) $cl;
                        $cll = $sel == $cid ? 'sel' : '';
                        ?> 
                        <li class = "<?php echo $cll; ?> clearfix" >
                            <div class = "title">
                                <a href="javascript:" class="classget" data-rec="<?php echo $cid; ?>"><?php echo $cc->name; ?></a>
                                <p><?php echo $cc->size; ?> Students</p>
                            </div>
                        </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div id="confirm" title="Delete This Record?">Are you sure you want to remove this Fee?</div>
<div id="void" title="Void Invoice">Are you sure you want to void this Invoice?</div>
<div id="ufdel" title="Delete This Record?">Are you sure you want to remove this Fee?</div>
<script type="text/javascript">
<?php
if ($show && isset($feex))
{
        ?>
                $(function ()
                {
                    $.fn.editable.defaults.mode = 'inline';
                    $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
                    $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
                            '<button type="button" class="btn editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
                    var fpk;
                    $('.fxamount').each(function (i, obj)
                    {
                        var $px = $(this);
                        fpk = $px.attr('data-rec');
                        $px.editable({
                            type: 'text',
                            title: 'Enter Amount',
                            placement: 'right',
                            pk: fpk,
                            url: '<?php echo base_url('admin/fee_structure/put_extras/'); ?>',
                            defaultValue: '   ',
                            success: function (response, newValue)
                            {
                                notify('Fee Extra', 'Amount Updated: ' + newValue);
                            }
                        });
                    });
            $('.fxt').each(function (i, obj)
            {
                var $px = $(this);
                fpk = $px.attr('data-rec');
                $px.editable({
                    type: 'text',
                    //title: 'Enter',
                    placement: 'right',
                    pk: fpk,
                    url: '<?php echo base_url('admin/fee_structure/put_extras/2'); ?>',
                    defaultValue: '   ',
                    success: function (response, newValue)
                    {
                        notify('Fee Extra', 'Updated: ' + newValue);
                    }
                });
            });
            $('.fxy').each(function (i, obj)
            {
                var $px = $(this);
                fpk = $px.attr('data-rec');
                $px.editable({
                    type: 'text',
                    //title: 'Enter',
                    placement: 'right',
                    pk: fpk,
                    url: '<?php echo base_url('admin/fee_structure/put_extras/1'); ?>',
                    defaultValue: '   ',
                    success: function (response, newValue)
                    {
                        notify('Fee Extra', 'Updated: ' + newValue);
                    }
                });
            });

                });
<?php } ?>
<?php
if ($iv)
{
        ?>
                $(function ()
                {
                    $.fn.editable.defaults.mode = 'inline';
                    $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
                    $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
                            '<button type="button" class="btn editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
            var fpk;
                    $('.ixamount').each(function (i, obj)
                    {
                        var $px = $(this);
                        fpk = $px.attr('data-rec');
                         $px.editable({
                            type: 'text',
                            title: 'Enter Amount',
                            placement: 'right',
                            pk: fpk,
                            url: '<?php echo base_url('admin/fee_structure/edit_invoice/'); ?>',
                            defaultValue: '   ',
                            success: function (response, newValue)
                            {
                                notify('Tuition Fee Amount', 'Amount Updated: ' + newValue);
                            }
                        });
                    });
            $('.xterm').each(function (i, obj)
            {
                var $px = $(this);
                fpk = $px.attr('data-rec');
                $px.editable({
                    type: 'text',
                    title: 'Term',
                    placement: 'right',
                    pk: fpk,
                    url: '<?php echo base_url('admin/fee_structure/edit_invoice/1'); ?>',
                    defaultValue: '   ',
                    success: function (response, newValue)
                    {
                        notify('Invoice', 'Successfully Updated: ' + newValue);
                    }
                });
            });
            $('.xyear').each(function (i, obj)
            {
                var $px = $(this);
                fpk = $px.attr('data-rec');
                $px.editable({
                    type: 'text',
                    title: 'Year',
                    placement: 'right',
                    pk: fpk,
                    url: '<?php echo base_url('admin/fee_structure/edit_invoice/2'); ?>',
                    defaultValue: '   ',
                    success: function (response, newValue)
                    {
                        notify('Invoice', 'Successfully Updated: ' + newValue);
                    }
                });
            });

                });
<?php } ?>
<?php
if ($unf)
{
    ?>
        $(function ()
        {
            $.fn.editable.defaults.mode = 'inline';
            $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
            $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
                    '<button type="button" class="btn editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
            var fpk, fst;
            $('.ufamountx').each(function (i, obj)
            {
                var $px = $(this);
                fpk = $px.attr('data-rec');
                $px.editable({
                    type: 'text',
                    title: 'Enter Amount',
                    placement: 'right',
                    pk: fpk,
                    url: '<?php echo base_url('admin/fee_structure/edit_sales/'); ?>',
                    defaultValue: '   ',
                    success: function (response, newValue)
                    {
                        notify('Fee Amount', 'Amount Updated: ' + newValue);
                    }
                });
            });

        });
<?php } ?>
    $(function ()
    {
            $(".fsel").select2({'placeholder': 'Please Select', 'width': '70%'});
            $('.sella').select2({
                placeholder: 'Search for Student',
                minimumInputLength: 3,
                width: '70%',
                multiple: true,
                ajax: {
                    url: "<?php echo base_url('admin/admission/pick_students'); ?>",
                    dataType: 'json',
                    quietMillis: 250,
                    data: function (term, page)
                    {
                        return {
                            term: term, //search term
                            page_limit: 50 // page size
                        };
                    },
                    results: function (data, page)
                    {
                        return {results: data};
                    }
                }

            });
            $(".classget").on("click", function ()
            {
                var rec = $(this).attr('data-rec');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('admin/fee_structure/get_class_targets'); ?>",
                    data: {'class': rec},
                    success: function (data)
                    {
                        var json = JSON.parse(data);
                        $('.sella').select2('data', json, true);
                    }
                });
            });
        });
        $(function ()
        {
        var frow, ivr, ufr;
            $('.fxdel').on('click', function ()
            {
                frow = $(this).closest('tr');
                frow.data('id', $(this).attr('data-id'));
                frow.data('sid', $(this).attr('data-content'));
                $("#confirm").dialog('open');
            });
            $('.idel').on('click', function ()
            {
                ivr = $(this).closest('tr');
                ivr.data('id', $(this).attr('data-id'));
                ivr.data('sid', $(this).attr('data-content'));
                $("#void").dialog('open');
            });
        $('.fdel').on('click', function ()
        {
            ufr = $(this).closest('tr');
            ufr.data('id', $(this).attr('data-id'));
            ufr.data('sid', $(this).attr('data-content'));
            $("#ufdel").dialog('open');
        });
            $("#confirm").dialog({
                resizable: false,
                height: "auto",
                modal: true,
                autoOpen: false,
                buttons: {
                    'Remove': function ()
                    {
                        $.post("<?php echo base_url('admin/fee_structure/remove_extra/'); ?>", {"id": frow.data('id'), "rec": frow.data('sid')}, function (msg)
                        {
                            notify('Fee Extra', 'Value changed: ');
                            frow.fadeOut(function ()
                            {
                                $('table.fxtbl > tbody > tr').each(function (i)
                                {
                                    $(this).children('td:nth-child(1)').text(i + 1 + '.');
                                });
                            });
                        });
                        $(this).dialog('close');
                    },
                    Cancel: function ()
                    {
                        $(this).dialog('close');
                    }
                }
            });
            $("#void").dialog({
                resizable: false,
                height: "auto",
                modal: true,
                autoOpen: false,
                buttons: {
                    'Remove': function ()
                    {
                        $.post("<?php echo base_url('admin/fee_structure/void_invoice'); ?>" + "/" + ivr.data('id'), {"id": ivr.data('id')}, function (msg)
                        {
                            notify('Invoice', 'Voided ');
                            frow.fadeOut(function ()
                            {
                                $('table.fxtbl > tbody > tr').each(function (i)
                                {
                                    $(this).children('td:nth-child(1)').text(i + 1 + '.');
                                });
                            });
                        });
                        $(this).dialog('close');
                    },
                    Cancel: function ()
                    {
                        $(this).dialog('close');
                    }
                }
            });

        $("#ufdel").dialog({
            resizable: false,
            height: "auto",
            modal: true,
            autoOpen: false,
            buttons: {
                'Remove': function ()
                {
                    $.post("<?php echo base_url('admin/fee_structure/void_uniform'); ?>" + "/" + ufr.data('id'), {"id": ufr.data('id')}, function (msg)
                    {
                        notify('Uniform', 'Voided ');
                        ufr.fadeOut(function ()
                        {
                            $('table.fxtbl > tbody > tr').each(function (i)
                            {
                                $(this).children('td:nth-child(1)').text(i + 1 + '.');
        });
                        });
                    });
                    $(this).dialog('close');
                },
                Cancel: function ()
                {
                    $(this).dialog('close');
                }
            }
        });
    });
</script> 