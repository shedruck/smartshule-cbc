<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>CBC Assessment  </h2>
    <div class="right">  
        <?php echo anchor('admin/invoices/create', '<i class="glyphicon glyphicon-list">
                </i> Create', 'class="btn btn-primary"'); ?> 
    </div>
</div>

<div class="block-fluid">
    <div class="row">
        <div class="col-md-4 st-t">
        </div>
        <div class="col-md-4 st-t p-10">
            <a href="<?php echo base_url('admin/cbc/summative'); ?>" class="btn btn-primary">Summative Report</a>
            <a href="<?php echo base_url('admin/cbc/assessment'); ?>" class="btn btn-info">Formative Report</a>
        </div>
        <div class="col-md-4 st-t">

        </div>
    </div>
    <table cellpadding="0" cellspacing="0" id="assess" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Class</th>
                <th>Term</th>
                <th>Year</th>
                <th width="20%"><?php echo lang('web_options'); ?></th>
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
        oTable = $('#assess').dataTable({
            "dom": 'TC lfrtip',
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/cbc/get_table'); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex)
            {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html('');
                $("td:last", nRow).html("<div class='btn-group'><a class='btn btn-primary' href ='<?php echo base_url('admin/cbc/assess_report'); ?>" + "/" + aData[4] + "/" + aData[2] + "/" + aData[3] + "' >View Assessment</a> " + '</div>');
                $("td:nth-child(3)", nRow).html('Term ' + aData[2]);

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
                {"bVisible": true, "bSearchable": true, "bSortable": false}
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
