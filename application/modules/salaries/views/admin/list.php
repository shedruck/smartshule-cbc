<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Salaried Employees  </h2>
    <div class="right">  
        <?php echo anchor('admin/salaries/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Employee to Salary')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/salaries', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Salaried Employees')), 'class="btn btn-primary"'); ?> 
    </div>
</div>

<div class="block-fluid">
    <table id="feee" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee</th>
                <th>Basic Salary (<?php echo $this->currency; ?>)</th>
                <th>Deductions (<?php echo $this->currency; ?>)</th>
                <th>Allowances (<?php echo $this->currency; ?>)</th>
                <th>Bank</th>
                <th>NHIF/NSSF</th>
                <th><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        </tfoot>
    </table> 
</div>

<script type="text/javascript">
        $(document).ready(function () {
            var oTable;
            oTable = $('#feee').dataTable({
                "dom": 'TC lfrtip',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/salaries/list_employees'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, 'All']],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html("  <div class='btn-group'><a class='btn btn-primary' href ='<?php echo base_url('admin/salaries/edit/'); ?>" + "/" + aData[0] + "' >Edit</a><a onClick='return confirm(\"Are you sure you want to remove Employee? \")' class='btn btn-danger' href ='<?php echo base_url('admin/salaries/delete/'); ?>" + "/" + aData[0] + "' >Remove</a> " + '</div>');
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
