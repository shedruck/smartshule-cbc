<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Students  </h2>
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
                <div class="description">All Students</div>
            </div>
        </div>
        <div class="item">
            <div class="rates">
                <div class="title"><?php echo number_format($seen); ?> </div>
                <div class="description">Linked Students</div>
            </div>
        </div>
        <div class="item">
            <div class="rates">
                <div class="title"><?php echo number_format($all - $seen); ?> </div>
                <div class="description">Pending</div>
            </div>
        </div>

    </div>
</div>
<div class="block-fluid">
    <table cellpadding="0" cellspacing="0" width="100%" id="std">
        <thead>
        <th>#</th>
        <th>FullName</th>
        <th>ListID</th>
        <th>Acc. No</th>
        <th>QB Balance</th>
        <th>Seen</th>
        <th ><?php echo lang('web_options'); ?></th>
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
               "sAjaxSource": "<?php echo base_url('admin/quickbooks/get_students'); ?>",
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
