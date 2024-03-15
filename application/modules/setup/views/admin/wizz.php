<div class="block-fluid"> 
<div class="head dark"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Teachers  </h2>
    <div class="right">  
        <?php echo anchor('admin/setup/new_teacher/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Teachers')), 'class="btn btn-primary"'); ?>
    </div>
</div>

<div class="block-fluid">
    <table id="ModeTable" cellpadding="0" cellspacing="0" width="100%">
        <thead>
        <th>#</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>	
        <th ><?php echo lang('web_options'); ?></th>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

</div>
</div>

<div class="pagination pagination-centered pagination-large">
    <?php echo anchor('admin/setup/', '<i class="glyphicon glyphicon-circle-arrow-left"></i> Previous', 'class="btn btn-primary  btn-large"'); ?> 
    <?php echo anchor('admin/setup/classes', '<i class="glyphicon glyphicon-circle-arrow-right"></i> Next', 'title="2" id="nexti" class="btn btn-success  btn-large"'); ?>    
</div>

<script type="text/javascript">
    $(document).ready(function() {
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
            "iDisplayLength": <?php echo $this->list_size;?>,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
               // $("td:last", nRow).html(" <a class='btn btn-primary' href ='<?php //echo base_url('admin/teachers/edit/'); ?>"  + "/" + aData[0] + "'  >Edit</a>  ");
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
