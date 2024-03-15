<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Payments  </h2>
    <div class="right">  
        <?php echo anchor('admin/quickbooks/payments', '<i class="glyphicon glyphicon-list glyphicon glyphicon-white">
                </i>Quick Payments', 'class="btn btn-primary"'); ?> 
    </div>
</div>

<div class="block-fluid">
    <table cellpadding="0" cellspacing="0" width="100%" id="std">
        <thead>
            <tr>
                <th>#</th>
                <th>FullName</th>
                <th>TXN</th>
                <th>Amount</th>
                <th>Reg</th>
                <th>Created on</th>
                <th ><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody>

        </tbody>

    </table> 
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var oTable;
        oTable = $('#std').dataTable({
            "dom": 'TC lfrtip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/quickbooks/get_real_vs'); ?>",
            "iDisplayLength": 100,
            "aLengthMenu": [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
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