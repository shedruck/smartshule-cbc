<?php
if ($this->input->get('sw'))
{
        $sel = $this->input->get('sw');
}
elseif ($this->session->userdata('pop'))
{
        $sel = $this->session->userdata('pop');
}
else
{
        $sel = 0;
}
?>
<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Generate Student Report Forms</h2>
        <div class="right">             
            <?php echo anchor('admin/exams/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        </div>    					
    </div>
    <div class="block-fluid">
        <table cellpadding="0" cellspacing="0" border="0" class='hover' id="adm_table" width="100%">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th >Student Name</th>
                    <th>Total Marks</th>
                    <th>Remarks</th>
                    <th width="5%"><input type="checkbox" class="checkall"/></th>
                    <th ><?php echo lang('web_options'); ?></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>


        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
                <?php //echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary' "); ?>
                <?php //echo anchor('admin/exams', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>
        <?php //echo form_close(); ?>
    </div>
</div>

<div class="col-md-4">

    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icosg-newtab"></span></div>
            <h2>Class</h2>
        </div>

        <div class="block-fluid">

            <ul class="list tickets">
                <?php
                $i = 0;
                foreach ($classes as $key => $cl)
                {
                        $i++;
                        $cc = (object) $cl;

                        $cll = ($sel == $key ) ? 'sel' : '';
                        ?> 
                        <li class = "<?php echo $cll; ?> clearfix" >
                            <div class = "title">
                                <a href= "<?php echo current_url() . '?sw=' . $key; ?>"><?php echo $cc->name; ?></a>
                                <p><?php echo $cc->size; ?> Students</p>
                            </div>
                        </li>
                <?php } ?>
            </ul>

        </div>
    </div>

</div>

<script type = "text/javascript">

        $(document).ready(function ()
        {
            var oTable;
            oTable = $('#adm_table').dataTable({
                "dom": 'TC lfrtip <"clear">',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/exams/get_table/' . $exam); ?>",
                "iDisplayLength": 50,
                "aLengthMenu": [[10, 25, 50, 250,500], [10, 25, 50, 250, 500]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:nth-child(5)", nRow).html('<input type="checkbox" name="sids[]" value="' + aData[0] + '"/>');
                    $("td:last", nRow).html("<a class='btn btn-success boxf' href ='<?php echo base_url('admin/exams/report/'); ?>" + "/<?php echo $exam; ?>" + "/" + aData[0] + "' >Preview</a>");
                    $(".boxf", nRow).boxer();
                    $("td:nth-child(3)", nRow).addClass('rttb');

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
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
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
