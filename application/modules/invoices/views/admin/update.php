<?php
$range = range(date('Y') - 3, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);
$months = ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];

$t1 = $this->input->post('f1') ? 'nav-active active' : '';
$t2 = $this->input->post('f2') ? 'nav-active active' : '';
$t3 = $this->input->post('f3') ? 'nav-active active' : '';
$t4 = $this->input->post('f4') ? 'nav-active active' : '';
$t5 = $this->input->post('f5') ? 'nav-active active' : '';
if (!$this->input->post())
{
    $t1 = 'active';
}
?>

<div class="block-fluid tabbable">
    <ul class="nav nav-tabs">
        <li class="<?php echo $t1; ?>"><a href="#t1"  data-toggle="tab"><i class="glyphicon glyphicon-file"></i> Edit Payments </a></li>
        <li class="<?php echo $t2; ?>"><a href="#t2" data-toggle="tab"><i class="glyphicon glyphicon-file"></i> Edit Invoices</a></li>
        <li class="<?php echo $t3; ?>"><a href="#t3" data-toggle="tab"><i class="glyphicon glyphicon-file"></i> Fee Extras</a></li>
        <li class="<?php echo $t4; ?>"><a href="#t4" data-toggle="tab"><i class="glyphicon glyphicon-file"></i> Uniform Invoices</a></li>
        <li class="<?php echo $t5; ?>"><a href="#t5" data-toggle="tab"><i class="glyphicon glyphicon-file"></i> Voided Invoices</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane <?php echo $t1; ?>" id="t1">
            <?php echo form_open(current_url(), 'class="form-inline" '); ?>
            <div class="toolbar">
                <div class="row">
                    <div class="col-md-3" >&nbsp;</div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('month', ["" => ""] + $months, $this->input->post('month'), ' class="xsel" data-placeholder="Select Month..." ');
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('yr', ["" => ""] + $yrs, $this->input->post('yr'), ' class="xsel" data-placeholder="Select Year..." ');
                        ?>
                    </div>
                    <button class="btn btn-primary" type="submit" name="f1" value="11">Filter List</button>
                </div>
            </div>
            <table class="table table-hover table-bordered" id="ptable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Term</th>
                        <th width="13%"><input type="checkbox" class="checkall"/> Check All</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
            <hr>
            <table class="table">
                <tr>
                    <td>Term:
                        <?php
                        echo form_dropdown('term', ['' => ' Term'] + $this->terms, '', 'class="xsel" ');
                        echo form_error('term');
                        ?>
                    </td>
                    <td>Year: 
                        <?php
                        krsort($yrs);
                        echo form_dropdown('year', ['' => 'Year'] + $yrs, '', 'class=" xsel" ');
                        echo form_error('year');
                        ?>
                    </td>
                </tr>
            </table>
            <hr>
            <div class='form-g row'>
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <?php echo form_submit('p1', 'Save', "id='submit' class='btn btn-primary' "); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="tab-pane <?php echo $t2; ?>" id="t2">
            <?php echo form_open(current_url(), 'class="form-inline" '); ?>
            <div class="toolbar">
                <div class="row">
                    <div class="col-md-3" >&nbsp;</div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('month', ["" => ""] + $months, $this->input->post('month'), ' class="xsel" data-placeholder="Select Month..." ');
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('yr', ["" => ""] + $yrs, $this->input->post('yr'), ' class="xsel" data-placeholder="Select Year..." ');
                        ?>
                    </div>
                    <button class="btn btn-primary" type="submit" name="f2" value="22">Filter List</button>
                </div>
            </div>
            <table class="table table-hover" width="100%" id="ivtable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Amount</th>
                        <th>Term</th>
                        <th width="13%"><input type="checkbox" class="checkall"/> Check All </th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
            <hr>
            <table class="table">
                <tr>
                    <td>Term:
                        <?php
                        echo form_dropdown('term', ['' => ' Term'] + $this->terms, '', 'class="xsel" ');
                        echo form_error('term');
                        ?>
                    </td> 
                    <td>Year: 
                        <?php
                        krsort($yrs);
                        echo form_dropdown('year', ['' => 'Year'] + $yrs, '', 'class=" xsel" ');
                        echo form_error('year');
                        ?>
                    </td>
                </tr>
            </table>
            <hr>
            <div class='form-g row'>
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <?php echo form_submit('e1', 'Save', "id='ep' class='btn btn-primary' "); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="tab-pane <?php echo $t3; ?>" id="t3">
            <?php echo form_open(current_url(), 'class="form-inline" '); ?>
            <div class="toolbar">
                <div class="row">
                    <div class="col-md-3" >&nbsp;</div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('month', ["" => ""] + $months, $this->input->post('month'), ' class="xsel" data-placeholder="Select Month..." ');
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('yr', ["" => ""] + $yrs, $this->input->post('yr'), ' class="xsel" data-placeholder="Select Year..." ');
                        ?>
                    </div>
                    <button class="btn btn-primary" type="submit" name="f3" value="33">Filter List</button>
                </div>
            </div>
            <table class="table table-hover" width="100%" id="extable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Desc.</th>
                        <th>Amount</th>
                        <th>Term</th>
                        <th width="13%"><input type="checkbox" class="checkall"/> Check All </th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
            <hr>
            <table class="table">
                <tr>
                    <td>Term:
                        <?php
                        echo form_dropdown('term', ['' => ' Term'] + $this->terms, '', 'class="xsel" ');
                        echo form_error('term');
                        ?>
                    </td> 
                    <td>Year: 
                        <?php
                        krsort($yrs);
                        echo form_dropdown('year', ['' => 'Year'] + $yrs, '', 'class=" xsel" ');
                        echo form_error('year');
                        ?>
                    </td>
                </tr>
            </table>
            <hr>
            <div class='form-g row'>
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <?php echo form_submit('x1', 'Save', "id='xp' class='btn btn-primary' "); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="tab-pane <?php echo $t4; ?>" id="t4">
            <?php echo form_open(current_url(), 'class="form-inline" '); ?>
            <div class="toolbar">
                <div class="row">
                    <div class="col-md-3" >&nbsp;</div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('month', ["" => ""] + $months, $this->input->post('month'), ' class="xsel" data-placeholder="Select Month..." ');
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('yr', ["" => ""] + $yrs, $this->input->post('yr'), ' class="xsel" data-placeholder="Select Year..." ');
                        ?>
                    </div>
                    <button class="btn btn-primary" type="submit" name="f4" value="44">Filter List</button>
                </div>
            </div>
            <table class="table table-hover" width="100%" id="uftable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Desc.</th>
                        <th>Amount</th>
                        <th>Term</th>
                        <th width="13%"><input type="checkbox" class="checkall"/> Check All </th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
            <hr>
            <table class="table">
                <tr>
                    <td>Term:
                        <?php
                        echo form_dropdown('term', ['' => ' Term'] + $this->terms, '', 'class="xsel" ');
                        echo form_error('term');
                        ?>
                    </td> 
                    <td>Year: 
                        <?php
                        krsort($yrs);
                        echo form_dropdown('year', ['' => 'Year'] + $yrs, '', 'class=" xsel" ');
                        echo form_error('year');
                        ?>
                    </td>
                </tr>
            </table>
            <hr>
            <div class='form-g row'>
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <?php echo form_submit('u1', 'Save', "id='fp' class='btn btn-primary' "); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="tab-pane <?php echo $t5; ?>" id="t5">
            <?php echo form_open(current_url(), 'class="form-inline" '); ?>
            <div class="toolbar">
                <div class="row">
                    <div class="col-md-3" >&nbsp;</div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('month', ["" => ""] + $months, $this->input->post('month'), ' class="xsel" data-placeholder="Select Month..." ');
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('yr', ["" => ""] + $yrs, $this->input->post('yr'), ' class="xsel" data-placeholder="Select Year..." ');
                        ?>
                    </div>
                    <button class="btn btn-primary" type="submit" name="f5" value="27">Filter List</button>
                </div>
            </div>
            <table class="table table-hover" width="100%" id="voided">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Amount</th>
                        <th>Term</th>
                        <th width="13%"><input type="checkbox" class="checkall"/> Check All </th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
            <hr>
            <table class="table">
                <tr>
                     
                </tr>
            </table>
            <hr>
            <div class='form-g row'>
                <div class="col-md-4"></div>
                <div class="col-md-8">xxx
                    <?php echo form_submit('p7', 'Save', "id='e7p' class='btn btn-primary' "); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        var payTable = $('#ptable').dataTable({
            "dom": 'TC lfrptip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/invoices/get_paid/' . $month . '/' . $yr); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex)
            {
                var oSettings = payTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<div class='btn-group'>  " + '&nbsp; <input type="checkbox" name="sids[]" value="' + aData[0] + '"/></div>');

                $("td:nth-child(5)", nRow).addClass('rttb');
                return nRow;
            },
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
            },
            "aoColumns": [
                {"bVisible": true, "bSearchable": false, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": false, "bSortable": false}
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": " "
                }
            ]
        });
        var oTable = $('#ivtable').dataTable({
            "dom": 'TC lfrptip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/invoices/get_table/' . $month . '/' . $yr); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex)
            {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<div class='btn-group'>  " + '&nbsp; <input type="checkbox" name="sids[]" value="' + aData[0] + '"/></div>');

                $("td:nth-child(5)", nRow).addClass('rttb');
                return nRow;
            },
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
            },
            "aoColumns": [
                {"bVisible": true, "bSearchable": false, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": false, "bSortable": false}
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": " "
                }
            ]
        });
        var exTable = $('#extable').dataTable({
            "dom": 'TC lfrptip',
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/invoices/get_extras/' . $month . '/' . $yr); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex)
            {
                var oSettings = exTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<div class='btn-group'>  " + '&nbsp; <input type="checkbox" name="sids[]" value="' + aData[0] + '"/></div>');

                $("td:nth-child(5)", nRow).addClass('rttb');
                return nRow;
            },
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
            },
            "aoColumns": [
                {"bVisible": true, "bSearchable": false, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": false, "bSortable": false}
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": " "
                }
            ]
        });
        var ufTable = $('#uftable').dataTable({
            "dom": 'TC lfrptip',
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/invoices/get_unf/' . $month . '/' . $yr); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex)
            {
                var oSettings = ufTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<div class='btn-group'>  " + '&nbsp; <input type="checkbox" name="sids[]" value="' + aData[0] + '"/></div>');

                $("td:nth-child(5)", nRow).addClass('rttb');
                return nRow;
            },
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
            },
            "aoColumns": [
                {"bVisible": true, "bSearchable": false, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": false, "bSortable": false}
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": " "
                }
            ]
        });
        var oTable = $('#voided').dataTable({
            "dom": 'TC lfrptip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/invoices/get_table/' . $month . '/' . $yr . '/1'); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex)
            {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<div class='btn-group'>  " + '&nbsp; <input type="checkbox" name="sids[]" value="' + aData[0] + '"/></div>');

                $("td:nth-child(5)", nRow).addClass('rttb');
                return nRow;
            },
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
            },
            "aoColumns": [
                {"bVisible": true, "bSearchable": false, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": false, "bSortable": false}
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": " "
                }
            ]
        });
    });
</script>
<script type="text/javascript">
    $(function ()
    {
        $(".xsel").select2({'width': '100%', 'placeholder': 'Select', 'allowClear': true});
    });
</script>