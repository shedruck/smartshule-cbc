<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Teaching Staff </h2>
   <div class="right">
        <?php echo anchor('admin/teachers/assign', '<i class="glyphicon glyphicon-list">
                </i> Assign Classes', 'class="btn btn-success"'); ?> 

        <?php echo anchor('admin/teachers/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Teachers')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/teachers', '<i class="glyphicon glyphicon-list">
                </i> Teachers Grid View', 'class="btn btn-success"'); ?> 

        <?php echo anchor('admin/teachers/list_view', '<i class="glyphicon glyphicon-list">
                </i> Teachers List View', 'class="btn btn-info"'); ?>

        <?php echo anchor('admin/teachers/inactive', '<i class="glyphicon glyphicon-list">
                </i> Inactive Teachers', 'class="btn btn-warning"'); ?>
    </div>
</div>

<div class="block-fluid">
    <?php echo form_open('admin/teachers/filterByStatus')?>
    <div class="row col-md-12">
        <div class="col-md-9 filter">
        <select class="form-control" name="status"  >
            <option>Filter Teacher By Status</option>
            <?php
                foreach ($mwalimu as $teacher) {
                    if($teacher->status ==1){
                        $status="Active";
                    }else{
                        $status="Inactive";
                    }
                    ?>
                <option value="<?php echo $teacher->status?>" id="status"><?php echo $status?></option>
            <?php }?>
        </select>
        </div>
        <div class="col-md-3 filter">
            <button name="filter_t" type="post" class="btn btn-md btn-primary">Filter</button>
        </div>
    </div>
    </form>
  
    <table id="ModeTable" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Passport</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>	
                <th>Status</th>	
                <th>Designation</th>	
                <th width="20%"><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
            

</div>


<script type="text/javascript">
    $(document).ready(function () {
        var oTable;
        oTable = $('#ModeTable').dataTable({
            "dom": 'TC lfrtip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/teachers/get_table'); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<div class='btn-group'> <a class='btn btn-success btn-sm' href='<?php echo site_url('admin/teachers/profile/'); ?>" + "/" + aData[0] + "'> Profile</a><a class='btn btn-primary btn-sm' href='<?php echo site_url('admin/teachers/edit/'); ?>" + "/" + aData[0] + "'>Edit</a><a class='btn btn-danger btn-sm'  href='#' data-toggle='modal'> Exit</a> </div>");
                return nRow;
            },
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url('assets/ico/ajax-loader.gif'); ?>'>"
            },
            "aoColumns": [
                {"bVisible": true, "bSearchable": false, "bSortable": false},
                {"bVisible": true, "bSearchable": false, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": false, "bSortable": false},
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
<script src="<?php echo base_url('assets/themes/admin/js/teachers.js')?>"></script>