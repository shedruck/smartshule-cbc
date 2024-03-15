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
<div class="col-md-9">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Charge Student Fee Structure Extras</h2>
        <div class="right">  
            <a href="<?php echo base_url('admin/fee_structure/filter_extras')?>" class="btn btn-warning"> <i class="glyphicon glyphicon-upload">  </i> Bulk Invoice</a>           
            <?php echo anchor('admin/fee_structure/my_extras', '<i class="glyphicon glyphicon-list">  </i> Manage Fee Extras', 'target="blank" class="btn btn-primary"'); ?>
        </div>			
    </div>
    <div class="block-fluid">
        <?php echo form_open(current_url(), 'class="form-inline" id="fextra"'); ?>
		
		 
		
		
        <table cellpadding="0" cellspacing="0" border="0" class='hover' id="adm_table" width="100%">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th >Student Name</th>
                    <th>Class</th>
                    <th>ADM. No.</th>
                    <th width="5%"><input type="checkbox" class="checkall"/></th>
                    <th ><?php echo lang('web_options'); ?></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        <?php echo form_error('sids', '<p class="error" style="width:200px; margin: 15px auto;" >', '</p>'); ?>
		<div class='form-group'>
            <div class="col-md-12" for='inv_date'>Invoice Date </div><div class="col-md-12">
                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('inv_date', $result->inv_date > 0 ? date('d M Y', $result->inv_date) : date('d M Y'), 'class="validate[required] form-control datepicker col-md-4"'); ?>
                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>

                </div>
                <?php echo form_error('inv_date'); ?>
            </div>
        </div>
        <table class="clon" width="100%">
            <?php
            if ($this->input->post())
            {
                    $len = count($this->input->post('fee'));

                    for ($ii = 0; $ii < $len; $ii++)
                    {
                            $amval = '';
                            if ($this->input->post('amount'))
                            {
                                    $mval = $this->input->post('amount');
                                    $amval = $mval[$ii];
                            }
                            $ffval = '';
                            if ($this->input->post('fee'))
                            {
                                    $fval = $this->input->post('fee');
                                    $ffval = $fval[$ii];
                            }
                            $ttval = '';
                            if ($this->input->post('term'))
                            {
                                    $tval = $this->input->post('term');
                                    $ttval = $tval[$ii];
                            }
                            $yyval = '';
                            if ($this->input->post('year'))
                            {
                                    $yval = $this->input->post('year');
                                    $yyval = $yval[$ii];
                            }
                            $descval = '';
                            if ($this->input->post('description'))
                            {
                                    $ddval = $this->input->post('description');
                                    $descval = $ddval[$ii];
                            }
                            ?>
                            <tr id="entry<?php echo $ii + 1; ?>" class="tr_clone"> 
                                <td width="25%">
                                    
                                    <?php
                                    echo form_dropdown('fee[]', array('' => 'Select Fee') + $list, $ffval, ' class="fsel validate[required]"');
                                    echo form_error('fee');
                                    ?>
                                </td> 
                                <td>
                                    <?php echo form_input('description[]', $descval, 'placeholder="Description" class="desc" style="width:200px;" '); ?>
                                    <?php echo form_error('description'); ?>
                                </td>  
                                <td><?php echo form_input('amount[]', $amval, 'placeholder="Amount" class="amt" style="width:92px;" '); ?>
                                    <?php echo form_error('amount'); ?></td> 
                                <td><?php echo form_dropdown('term[]', array('' => ' Term') + $this->terms, $ttval, 'class="xsel validate[required]" '); ?>
                                    <?php echo form_error('term'); ?></td> 
                                <td> <?php
                                    krsort($yrs);
                                    echo form_dropdown('year[]', array('' => 'Year') + $yrs, $yyval, 'class=" xsel validate[required]" ');
                                    ?>
                                    <?php echo form_error('year'); ?></td> 
                            </tr>
                            <?php
                    }
            }
            else
            {
                    ?>
                    <tr id="entry1" class="tr_clone"> 
                        <td width="25%"><?php
                            echo form_dropdown('fee[]', array('' => 'Select Fee') + $list, '', ' class="fsel validate[required] fetcher"');
                            echo form_error('fee');
                            ?>
                        </td>
                        <td><?php echo form_input('description[]', '', 'placeholder="Description" class="desc" style="width:200px;" '); ?>
                            <?php echo form_error('description'); ?>
                        </td>  

                        <td><?php echo form_input('amount[]', '', 'placeholder="Amount" class="amt" style="width:92px;" '); ?>
                            <?php echo form_error('amount'); ?>
                        </td> 
                        <td>
                            <?php echo form_dropdown('term[]', array('' => ' Term') + $this->terms, '', 'class="xsel validate[required]" '); ?>
                            <?php echo form_error('term'); ?>
                        </td> 

                        <td> <?php
                            krsort($yrs);
                            echo form_dropdown('year[]', array('' => 'Year') + $yrs, '', 'class=" xsel validate[required]" ');
                            echo form_error('year');
                            ?></td> 
                    </tr>
            <?php } ?>
        </table>
        <div class="actions">
            <a  id="btnAdd" class="btn btn-success clone">Add New Line</a> 
            <a  id="btnDel" class="btn btn-danger remove">Remove</a>
        </div>

        <div class='form-group'>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary' "); ?>
                <?php echo anchor('admin/fee_structure/extras', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
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
                                <a href = "<?php echo current_url() . '?sw=' . $cid; ?>"><?php echo $cc->name; ?></a>
                                <p><?php echo $cc->size; ?> Students</p>
                            </div>
                        </li>
                <?php } ?>
                <li class = "clearfix" >
                    <div class = "title">
                        <a class="hidden" href = "<?php echo current_url() . '?sw=0'; ?>"></a>
                    </div>
                    <button class="btn btn-rounded btn-default" id="rsession" type="button"><span class="glyphicon glyphicon-remove"></span> Clear Selection</button>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    .btn-rounded{ border-radius: 30px;}
</style>
<script type = "text/javascript">
        $(document).ready(function ()
        {
            var oTable;
            oTable = $('#adm_table').dataTable({
                "dom": 'TC plfrtip <"clear">',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/fee_structure/get_table'); ?>",
                "iDisplayLength": 50,
                "aLengthMenu": [[10, 25, 50, 250], [10, 25, 50, 250]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:nth-child(5)", nRow).html('<input type="checkbox" name="sids[]" value="' + aData[0] + '"/>');
                    $("td:last", nRow).html("<a class='btn btn-success' href ='<?php echo base_url('admin/fee_payment/statement/'); ?>" + "/" + aData[0] + " ' >Statement</a>");
                    return nRow;
                },
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
                },
                "aoColumns": [
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": " "
                    }]
            }).fnSetFilteringDelay(700);

            $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
            $(" .fetcher").live("change", function (e)
            {
                var def = $(this).closest('tr').find("input.amt");
                $.ajax({
                    url: "<?php echo base_url('admin/fee_structure/fetch_default'); ?>",
                    type: "post",
                    data: {fee: e.val},
                    success: function (data)
                    {
                        //set amount
                        def.val(data);
                    }
                });

                notify('Select', 'Value changed: ' + e.val);
            });

            $(".xsel").select2({'placeholder': 'Please Select', 'width': '90px'});
            $(".xsel").on("change", function (e)
            {
                notify('Select', 'Value changed: ' + e.val);
            });

            $("#rsession").on("click", function ()
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('admin/fee_structure/remove_session'); ?>",
                    data: {'class': ''},
                    success: function (data)
                    {
                        console.log('Selection was Cleared ');
                        window.history.replaceState(null, null, window.location.pathname);
                        window.location.reload();
                    }
                });
            });
        });
</script>

<script type="text/javascript">
        $(function () {
            $("#entry1").find('select').select2({'width': '100%'});
            var i = 1;
            $("#btnAdd").click(function () {
                var $tr = $("table.clon tr:first");
                var $tlast = $("table.clon tr:last");
                var $clone = $tr.clone();
                $clone.find(':text').val('');
                $clone.find('.select2-container').remove();
                $clone.find('select').addClass('fsel').select2({'width': '100%'});
                $tlast.after($clone);
                i++;
            });
            $('#btnDel').click(function () {
                var num = $('.tr_clone').length;
                if (num == 1)
                {
                    alert("At least one Row Required.");
                }
                else
                {
                    // confirmation
                    if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
                    {
                        $('table.clon tr:last').remove().slideUp('slow');
                    }
                    return false;
                }
            });
        });
</script>
