<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>LPO </h2>
    <div class="right">
        <?php
        if ($this->acl->is_allowed(array('admin', 'lpo'), 1))
        {
            echo anchor('admin/lpo/create', '<i class="glyphicon glyphicon-plus"> </i> New LPO', 'class="btn btn-primary"');
            echo "&nbsp;&nbsp;&nbsp;&nbsp;". anchor('admin/lpo/suppliers', '<i class="glyphicon glyphicon-list"> </i> Suppliers List', 'class="btn btn-success"');
        }
        ?>
    </div>
</div>
<div class="block-fluid">
    <table class='hover' id="lpo" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>LPO Date</th>
                <th>Supplier</th>
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
        oTable = $('#lpo').dataTable({
            "dom": 'TC lfrtip',
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/lpo/list_lpo'); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, 200], [10, 25, 50, 200]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex)
            {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<div class='btn-group'><a class='btn btn-primary' href ='<?php echo base_url('admin/lpo/view/'); ?>" + "/" + aData[0] + "' >View</a><a onClick='return confirm(\"Are you sure?\")' class='kftt btn btn-danger hidden' href ='<?php echo base_url('admin/lpo/void/'); ?>" + "/" + aData[0] + "' ' >Void</a>" + '</div>');
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
                    "data": '',
                    "defaultContent": ""
                }
            ]
        });
    });
</script>
<style>
    .caption{color: #fff;}
</style>