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
<div class="col-md-9">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Assign Elective Subjects</h2>
        <div class="right">             
            <?php echo anchor('admin/fee_structure/my_extras', '<i class="glyphicon glyphicon-list">  </i> Manage Fee Extras', 'target="blank" class="btn btn-primary"'); ?>
        </div>			
    </div>
    <div class="block-fluid">
        <?php echo form_open(current_url(), 'class="form-inline" id="list"'); ?>
        <?php echo form_error('sids', '<p class="error" style="width:200px; margin: 15px auto;" >', '</p>'); ?>
        <table class="clon" width="100%">
            <?php
            if ($this->input->post())
            {
                    ?>
                    <tr id="entry1" class="tr_clone"> 
                        <td width="50%"><?php
                            echo form_dropdown('subject', array('' => '') + $list, $this->input->post('subject'), ' class="fsel validate[required]" data-placeholder="Select Subject" ');
                            echo form_error('subject');
                            ?>
                        </td>
                        <td> <?php
                            krsort($yrs);
                            echo form_dropdown('year', array('' => '') + $yrs, $this->input->post('year'), 'class=" xsel validate[required]" data-placeholder="Year" ');
                            echo form_error('year');
                            ?></td> 
                    </tr>

                    <?php
            }
            else
            {
                    ?>
                    <tr id="entry1" class="tr_clone"> 
                        <td width="50%"><?php
                            echo form_dropdown('subject', array('' => '') + $list, '', ' class="fsel validate[required] fetcher" data-placeholder="Select Subject" ');
                            echo form_error('subject');
                            ?>
                        </td>
                        <td> <?php
                            krsort($yrs);
                            echo form_dropdown('year', array('' => '') + $yrs, '', 'class=" xsel validate[required]" data-placeholder=" Year"');
                            echo form_error('year');
                            ?></td> 
                    </tr>
            <?php } ?>
        </table>

        <table cellpadding="0" cellspacing="0" border="0" class='hover' id="adm_table" width="100%">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th >Student Name</th>
                    <th>Class</th>
                    <th>ADM. No.</th>
                    <th width="5%"><input type="checkbox" class="checkall"/></th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        <div class='form-group'>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary' "); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<div class="col-md-3">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icosg-newtab"></span></div>
            <h2>Class</h2>
        </div>

        <div class="block-fluid">
            <ul class="list tickets">
                <?php
                $i = 0;
                foreach ($this->classlist as $cid => $cl)
                {
                        $i++;
                        $cc = (object) $cl;
                        $cll = $sel == $cid ? 'sel' : '';
                        ?> 
                        <li class = "<?php echo $cll; ?> clearfix" >
                            <div class = "title">
                                <a href = "<?php echo current_url() . '?sw=' . $cid; ?>"><?php echo $cc->name; ?></a>
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
                "sAjaxSource": "<?php echo base_url('admin/fee_structure/get_table'); ?>",
                "iDisplayLength": 50,
                "aLengthMenu": [[10, 25, 50, 250], [10, 25, 50, 250]],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:nth-child(5)", nRow).html('<input type="checkbox" name="sids[]" value="' + aData[0] + '"/>');
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
                    {"bVisible": true, "bSearchable": false, "bSortable": false}
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": " "
                    }]
            }).fnSetFilteringDelay(700);

            $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
            $(" .fetcher").live("change", function (e)
            {
                var def = $(this).closest('tr').find("input.amt");
                $.ajax({
                    url: "<?php echo base_url('admin/fee_structure/fetch_default'); ?>",
                    type: "post",
                    data: {fee: e.val},
                    success: function (data)
                    {
                        //set amount
                        def.val(data);
                    }
                });

                notify('Select', 'Value changed: ' + e.val);
            });

            $(".xsel").select2({'placeholder': 'Please Select', 'width': '90px'});
            $(".xsel").on("change", function (e) {
                notify('Select', 'Value changed: ' + e.val);
            });
        });
</script>

<script type="text/javascript">
        $(function () {
            $("#entry1").find('select').select2({'width': '100%'});
        });

</script>