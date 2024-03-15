<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Suppliers</h2>
    <div class="right">  
        <?php echo anchor('admin/lpo/add_supplier', '<i class="glyphicon glyphicon-plus"></i> Add Supplier', 'class="btn btn-primary"'); ?>
    </div>
</div>

<div class="block-fluid">
    <table class="table" id="suppliers">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        var oTable;
        oTable = $('#suppliers').dataTable({
            "dom": 'C lfrtip',
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/lpo/list_suppliers'); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                //$("td:last", nRow).html("<a class='btn btn-success' href='<?php echo base_url('admin/enquiries/suppliers_status/'); ?>" + "/" + aData[0] + "'>Status</a> ");
                //$(".tip", nRow).tooltip({placement: 'top', trigger: 'hover'});
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
                {"bVisible": true, "bSearchable": false, "bSortable": false}
            ],
            "columnDefs": [{
                    "targets": -1,
                    //   "data": '',
                    //  "defaultContent": " "
                }
            ]
        });
    });
</script>