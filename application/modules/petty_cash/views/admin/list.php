<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Petty Cash  </h2>
    <div class="right">  
        <?php echo anchor('admin/petty_cash/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Petty Cash')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/petty_cash', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Petty Cash')), 'class="btn btn-primary"'); ?> 
    </div>
</div>

<div class="block-fluid">

    <table cellpadding="0" cellspacing="0" border="0" class='hover' id="pettable" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
				<th>Description</th>
				<th>Amount (<?php echo $this->currency;?>)</th>
                <th>Responsible</th>
                <th>Recorded By</th>
                <th width="20%">Options</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var oTable;

        oTable = $('#pettable').dataTable({
            "dom": 'TC<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/petty_cash/get_table'); ?>",
             "iDisplayLength": <?php echo $this->list_size;?>,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                 $("td:nth-child(4)", nRow).addClass('rttb');
                $("td:last", nRow).html( "<div class='btn-group'> <a class='btn btn-primary' href ='<?php echo base_url('admin/petty_cash/edit/'); ?>" + "/" + aData[0] + "' ><i class='glyphicon glyphicon-edit'></i> Edit Details</a></div> ");
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
                {"bVisible": true, "bSearchable": true, "bSortable": true}
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": " "
                }
                //{"visible": false, "targets": [-4]}
            ]
        }).fnSetFilteringDelay(700);

    });
</script>
