<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Requisitions </h2> 
    <div class="right">
        <?php
        if ($this->acl->is_allowed(array('admin', 'expenses', 'create_req'), 1))
        {
                ?>
                <?php echo anchor('admin/expenses/create_req', '<i class="glyphicon glyphicon-plus"> </i>' . lang('web_add_t', array(':name' => 'Requisitions')), 'class="btn btn-primary"'); ?>
                <?php echo anchor('admin/expenses/requisitions', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>              
        <?php } ?>
    </div>   					
</div>
<div class="block-fluid">
    <table cellpadding="0" cellspacing="0" border="0" class='hover' id="exx_table" width="100%">
        <thead>
        <th>#</th>
        <th>Requisition Date</th>
        <th>Items</th>
        <th>Amount</th>
        <th>Created by</th>
        <th width="24%"><?php echo lang('web_options'); ?></th>
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
            oTable = $('#exx_table').dataTable({
                "dom": 'TC lfrtip',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/expenses/get_reqs'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, 200], [10, 25, 50, 200]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex)
                {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html("<div class='btn-group'><a class='btn btn-primary' href ='<?php echo base_url('admin/expenses/view_req/'); ?>" + "/" + aData[0] + "' >View</a><a class='btn btn-info' href ='<?php echo base_url('admin/expenses/edit_req/'); ?>" + "/" + aData[0] + "' >Edit</a><a onClick='return confirm(\"Are you sure?\")' class='kftt btn btn-danger' href ='<?php echo base_url('admin/expenses/void_req/'); ?>" + "/" + aData[0] + "' ' >Void</a>" + '</div>');
                    $("td:nth-child(4)", nRow).addClass('rttb');
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
                    {"bVisible": true, "bSearchable": true, "bSortable": true}
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": "null"
                    }
                ]
            }).fnSetFilteringDelay(700);
        });
</script>
<style>
    .caption{color: #fff;}
</style>