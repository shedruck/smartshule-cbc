<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Admission  </h2>
    <div class="right">  
       
        <?php echo anchor('admin/admission/my_students', '<i class="glyphicon glyphicon-list"></i> ' . lang('web_list_all', array(':name' => 'Students')), 'class="btn btn-primary"'); ?> 
          </div>
</div>

<div class="block-fluid">

    <table cellpadding="0" cellspacing="0" border="0" class='hover' id="adm_table" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>ADM Number</th>
                <th>Parent Name</th>
                <th>Parent Phone</th>
                <th>Parent Email</th>
                <th>Address</th>	
                <th ><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var oTable;
        oTable = $('#adm_table').dataTable({
            "dom": 'TC lfrtip',//'TC<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/admission/get_teachers_student'); ?>",
            "iDisplayLength": <?php echo $this->list_size;?>,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("  <div class='btn-group'><a class='btn btn-success' href ='<?php echo base_url('admin/admission/my_student_details/'); ?>" + "/" + aData[0] + "' >Full Profile</a> " + '</div>');
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
