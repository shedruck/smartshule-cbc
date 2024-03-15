<?php echo form_open_multipart('admin/users/filtered_users'); ?>
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Users Management</h2> 
    <div class="right">
        <?php echo form_dropdown('group_id', array('' => 'Filter Users Per Group...') + (array) $groups_list, (isset($result->group_id)) ? $result->group_id : '', ' class="select" '); ?>
        <button class='btn btn-success' type="submit">  <i class="glyphicon glyphicon-search" style="color:#fff;"></i> Filter Users</button>
        <?php echo anchor('admin/users/create/' . $page, '<i class="glyphicon glyphicon-plus"></i>' . lang('web_add_t', array(':name' => 'New User')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/users/', '<i class="glyphicon glyphicon-list"></i> List All', 'class="btn btn-info"'); ?>	
    </div>					
</div>
<?php echo form_close(); ?>
<div class="block-fluid">
    <table cellpadding="0" cellspacing="0" width="100%" id="users_tbb">
        <thead>
            <tr>                    
                <th>#</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>User Roles</th>
                <th width="110">Last Login</th>
                <th width="170"><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody> </tbody>
        <tfoot></tfoot>
    </table>

</div>
<script type="text/javascript">
        $(document).ready(function () {
            var oTable;
            oTable = $('#users_tbb').dataTable({
                destroy: true,
                "dom": 'TC lfrtip',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/users/get_table'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    if (aData[5] == 'Active')
                    {
                        $("td:last", nRow).html(" <a class='btn btn-primary' href ='<?php echo base_url('admin/users/edit/'); ?>" + "/" + aData[0] + "' >Edit</a> <a onClick='return confirm(\"Are you sure you want to suspend this user?\")' class='kftt btn btn-danger' href='<?php echo base_url('admin/users/suspend/'); ?>" + "/" + aData[0] + "' ' >Suspend</a>");
                    }
                    else
                    {
                        $("td:last", nRow).html(" <a class='btn btn-primary' href ='<?php echo base_url('admin/users/edit/'); ?>" + "/" + aData[0] + "' >Edit</a> <a onClick='return confirm(\"Are you sure you want to Activate this user?\")' class='kftt btn btn-danger' href='<?php echo base_url('admin/users/activate/'); ?>" + "/" + aData[0] + "' ' >Activate</a>");
                    }
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
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": true},
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
