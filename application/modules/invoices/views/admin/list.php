<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>Fee  Invoices  </h2>
    <div class="right">
        <?php echo anchor('admin/invoices/create', '<i class="glyphicon glyphicon-plus">
                </i> Process Invoices', 'class="btn btn-primary"'); ?> 
        <?php echo anchor('admin/fee_structure/invoice', '<i class="glyphicon glyphicon-print">
                </i> Print Invoices', 'class="btn btn-warning"'); ?> 
    </div>
</div>

<div class="block-fluid">
    <table cellpadding="0" cellspacing="0" id="ivtable" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Invoice No</th>
                <th>Invoice Date</th>
                <th>Amount</th>
                <th>Term</th>
                <th><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

</div>

<script type="text/javascript">
        $(document).ready(function ()
        {
            var oTable;
            oTable = $('#ivtable').dataTable({
                "dom": 'TC lfrtip',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/invoices/get_table'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex)
                {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html('');
<?php
if ($this->worker->get_version() == 1)
{
        ?>
                            $("td:last", nRow).html("<div class='btn-group'><a class='btn btn-success'  onClick='return confirm(\"Are you sure you want to Void This Invoice?\")'  href ='<?php echo base_url('admin/invoices/void/'); ?>" + "/" + aData[0] + "' >Void</a> " + '</div>');
<?php } ?>
                    $("td:nth-child(5)", nRow).addClass('rttb');
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
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": " "
                    }
                ]
            }).fnSetFilteringDelay(700);
        });
</script>
