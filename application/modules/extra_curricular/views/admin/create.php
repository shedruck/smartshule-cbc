<?php
if ($this->input->get('cc'))
{
        $sel = $this->input->get('cc');
}
elseif ($this->session->userdata('cc'))
{
        $sel = $this->session->userdata('cc');
}
else
{
        $sel = 0;
}
?>
<div class="col-md-8">

    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Add Students to Activities</h2>
        <div class="right">             
            <?php echo anchor('admin/extra_curricular/', '<i class="glyphicon glyphicon-list">  </i> Go Back', 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/activities/', '<i class="glyphicon glyphicon-pencil">  </i> Manage Activities', 'target="blank" class="btn btn-primary"'); ?>
        </div>			
    </div>
	
    <div class="block-fluid">
        <?php echo form_open(current_url(), 'class="form-inline" id="fextra"'); ?>
        <table class="clon" width="100%">
            <?php
            if ($this->input->post())
            {
                    ?>
                    <tr id="entry1" class="tr_clone">
                        <td width="47%"><?php
                            echo form_dropdown('activity', array('' => 'Select Activity') + $activity, $this->input->post('activity'), ' class="fsel validate[required]"');
                            echo form_error('activity');
                            ?>
                        </td>                       
                        <td><?php echo form_dropdown('term[]', array('' => ' Term') + $this->terms, $this->input->post('term'), 'class="xsel validate[required]" '); ?>
                            <?php echo form_error('term'); ?>
                        </td> 
                        <td> <?php
                            krsort($yrs);
                            echo form_dropdown('year[]', array('' => 'Year') + $yrs, $this->input->post('year'), 'class=" xsel validate[required]" ');
                            ?>
                            <?php echo form_error('year'); ?>
                        </td> 
                    </tr>

                    <?php
            }
            else
            {
                    ?>
                    <tr id="entry1" class="tr_clone"> 
                        <td width="47%"><?php
                            echo form_dropdown('activity', array('' => 'Select Activity') + $activity, '', ' class="fsel validate[required] fetcher"');
                            echo form_error('activity');
                            ?>
                        </td>
                        <td>
                            <?php echo form_dropdown('term', array('' => ' Term') + $this->terms, '', 'class="xsel validate[required]" '); ?>
                            <?php echo form_error('term'); ?>
                        </td> 

                        <td> <?php
                            krsort($yrs);
                            echo form_dropdown('year', array('' => 'Year') + $yrs, '', 'class=" xsel validate[required]" ');
                            echo form_error('year');
                            ?></td> 
                    </tr>
            <?php } ?>
        </table><hr/>
        <table cellpadding="0" cellspacing="0" border="0" class='hover' id="adm_table" width="100%">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th >Student Name</th>
                    <th>Class</th>
                    <th>ADM. No.</th>
                    <th width="5%"><input type="checkbox" class="checkall"/></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        <?php echo form_error('sids', '<p class="error" style="width:200px; margin: 15px auto;" >', '</p>'); ?>

        <div class='form-group'>
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <?php echo anchor('admin/extra_curricular', 'Cancel', 'class="btn  btn-default"'); ?>
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary' "); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
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
                foreach ($this->classlist as $cid => $cl)
                {
                        $i++;
                        $cc = (object) $cl;
                        $cll = $sel == $cid ? 'sel' : '';
                        ?> 
                        <li class = "<?php echo $cll; ?> clearfix" >
                            <div class = "title">
                                <a href = "<?php echo current_url() . '?cc=' . $cid; ?>"><?php echo $cc->name; ?></a>
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
                "dom": 'lfrti p <"clear">',
                "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/extra_curricular/get_table'); ?>",
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
                    {"bVisible": true, "bSearchable": false, "bSortable": false}
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": " "
                    }]
            }).fnSetFilteringDelay(700);

            $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});

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
