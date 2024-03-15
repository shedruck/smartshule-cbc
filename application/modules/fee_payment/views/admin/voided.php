<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Fee Payment  </h2>
    <div class="right">  
        <?php echo anchor('admin/fee_payment/create/', '<i class="glyphicon glyphicon-plus"></i> Receive Payment', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/fee_payment/paid', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Payment')), 'class="btn btn-primary"'); ?>
  <?php echo anchor('admin/fee_payment/all_voided', '<i class="glyphicon glyphicon-list">
                </i> Voided Payments', 'class="btn btn-warning"'); ?>				
    </div>
</div>

<div class="block-fluid">
    <table id="feee" cellpadding="0" cellspacing="0" width="100%">
        <thead>
        <th>#</th>
        <th  width="10%">Date</th>
        <th>Student.</th>
        <th>Amount </th>
        <th>Bank </th>
        <th>Payment<br> Method </th>
        <th>Details</th>
        <th> Voided On</th>
        <th> Voided By</th>
        <th width="1%"> </th>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        </tfoot>
    </table> 
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var oTable;
        oTable = $('#feee').dataTable({
            "dom": 'TC lfrtip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/fee_payment/get_voided'); ?>",
            "iDisplayLength": <?php echo $this->list_size;?>,
            "aLengthMenu": [10, 25, 50, 100, 200],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow);
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
                {"bVisible": true, "bSearchable": true, "bSortable": true},
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
        }).fnSetFilteringDelay(700);
    });
</script>
