<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Invoices  </h2>
    <div class="right">  
         <?php echo anchor('admin/quickbooks/students', '<i class="glyphicon glyphicon-list glyphicon glyphicon-white">
                </i>Quick Students', 'class="btn btn-primary"'); ?> 
    </div>
</div>
<div class="toolbar-fluid">
    <div class="information">
        <div class="item">
            <div class="rates">
                <div class="title"><?php echo number_format($all); ?> </div>
                <div class="description">All Invoices</div>
            </div>
        </div>
        <div class="item">
            <div class="rates">
                <div class="title"><?php echo number_format($seen); ?> </div>
                <div class="description">Linked Invoices</div>
            </div>
        </div>
        <div class="item">
            <div class="rates">
                <div class="title"><?php echo number_format($all - $seen); ?> </div>
                <div class="description">Pending Invoices</div>
            </div>
        </div>
        <div class="item">
            <div class="rates">
                <div class="title"><?php echo number_format($sum, 2); ?> </div>
                <div class="description">Pending Amt.</div>
            </div>
        </div>

    </div>
</div>
<div class="block-fluid">
    <table id="ivd" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Linked Name</th>
                <th>QB Name</th>
                <th>ListID - Txid</th>
                <th>Amount</th>
                <th>Seen</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        </tbody>

    </table>  
</div>

<script type="text/javascript">
     $(document).ready(function () {
          var oTable;
          oTable = $('#ivd').dataTable({
               "dom": 'TC lfrtip',
               "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
               },
               "bProcessing": true,
               "bServerSide": true,
               "sServerMethod": "GET",
               "sAjaxSource": "<?php echo base_url('admin/quickbooks/get_invoices'); ?>",
               "iDisplayLength": 100,
               "aLengthMenu": [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
               "aaSorting": [[0, 'asc']],
               "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. (' + aData[0] + ')');
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
