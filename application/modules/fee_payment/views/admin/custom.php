<div class="row">
    <?php echo form_open(current_url(), 'class="form-inline" id="fextra"'); ?>
    <div class="col-md-12">
        <div class="widget">
            <div class="head dark">
                <div class="icon"><span class="icosg-newtab"></span></div>
                <h2>  Fee Balance Reminder</h2>
            </div>
            <div class="block-fluid">
                <div class='form-group'>
                    <div class="col-md-3">Minimum Balance<span class='required'>*</span></div>
                    <div class="col-md-9">
                        <?php
                        $bals = array(
                            '999999' => 'Any Balance',
                            '1000' => '1,000',
                            '2000' => '2,000',
                            '5000' => '5,000',
                            '8000' => '8,000',
                            '10000' => '10,000',
                            '12000' => '12,000',
                            '15000' => '15,000',
                            '18000' => '18,000',
                            '20000' => '20,000',
                            '25000' => '25,000',
                            '30000' => '30,000',
                            '35000' => '35,000',
                            '40000' => '40,000',
                            '45000' => '45,000',
                            '50000' => '50,000',
                            '60000' => '60,000',
                            '80000' => '80,000',
                            '100000' => '100,000'
                        );
                        echo form_dropdown('bal', array('' => '') + $bals, '', ' class="select" data-placeholder="Select Minimum Balance" ');
                        echo form_error('bal');
                        ?>
                    </div>
                </div>

                <div class='form-group'>
                    <div class="col-md-3">Maximum Balance</div>
                    <div class="col-md-9">
                        <?php
                        $max = array(
                            '0' => 'Select Maximum Balance',
                            '10000' => '10,000',
                            '12000' => '12,000',
                            '15000' => '15,000',
                            '18000' => '18,000',
                            '20000' => '20,000',
                            '25000' => '25,000',
                            '30000' => '30,000',
                            '35000' => '35,000',
                            '40000' => '40,000',
                            '45000' => '45,000',
                            '50000' => '50,000',
                            '60000' => '60,000',
                            '80000' => '80,000',
                            '100000' => '100,000'
                        );
                        echo form_dropdown('max', $max, '', ' class="select" data-placeholder="Select Maximum Balance" ');
                        echo form_error('max');
                        ?>
                    </div>
                </div>
                <div class="p-action">
                    <input type="submit" class="btn  btn-success text-center" value="SEND REMINDER" onClick="return confirm('Confirm Send SMS?')" />
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?php
if ($this->input->get('pw'))
{
    $sel = $this->input->get('pw');
}
elseif ($this->session->userdata('pw'))
{
    $sel = $this->session->userdata('pw');
}
else
{
    $sel = 0;
}
?>
<div class="col-md-10">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span> </div>
        <h2>  Fee Balance Reminder by SMS</h2>
        <div class="right">  
            <?php echo anchor('admin/fee_payment', '<i class="icon- active  icosg-undo"></i> ' . lang('web_list_all', array(':name' => 'Back')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <div class="block-fluid">
        <?php echo form_open(base_url('admin/fee_payment/multiple_reminder'), 'class="form-inline" id="fsra"'); ?>
        <table id="fee_bal" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Class </th>
                    <th>Adm. #</th>
                    <th>Payable </th>
                    <th>Paid </th>
                    <th>Balance </th>
                    <th width="13%"><?php echo lang('web_options'); ?> <input type="checkbox" class="checkall"/></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
        <?php echo form_error('sids', '<p class="error" style="width:200px; margin: 15px auto;" >', '</p>'); ?>
        <div class='clearfix'></div>
        <div class='row'>
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <?php echo form_submit('export', ' Export List', " class='btn btn-success btn-lg' "); ?>
                <?php echo form_submit('send', 'Send Reminders', "id='submit' onClick='return confirm(\"Confirm Send Reminders? \") '  class='btn btn-info btn-lg pull-righft' "); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<div class="col-md-2">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icosg-newtab"></span></div>
            <h2>Filter by Class</h2>
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
                            <a href = "<?php echo current_url() . '?pw=' . $cid; ?>"><?php echo $cc->name; ?></a>
                            <p><?php echo $cc->size; ?> Students</p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        var oTable;
        oTable = $('#fee_bal').dataTable({
            "dom": 'TC lfrptip',
            "tableTools": {
                "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url('admin/fee_payment/get_by_student'); ?>",
            "iDisplayLength": <?php echo $this->list_size; ?>,
            "aLengthMenu": [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
            "aaSorting": [[0, 'asc']],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                $("td:first", nRow).html(preff + '. ');
                $("td:last", nRow).html("<div class='btn-group'> <a class='btn btn-warning tip'  onClick='return confirm(\"Are you sure you want to send SMS reminder to parent/guardian?\")' href ='<?php echo base_url('admin/fee_payment/reminder/'); ?>" + "/" + aData[0] + "' data-original-title='Send Reminder'  ><i class='glyphicon glyphicon-envelope'></i> </a>  " + '&nbsp; <input type="checkbox" name="sids[]" value="' + aData[0] + '"/></div>');
                $("td:nth-child(5)", nRow).addClass('rttb');
                $("td:nth-child(6)", nRow).addClass('rttb');
                $("td:nth-child(7)", nRow).addClass('rttb');
                $(".tip", nRow).tooltip({placement: 'top', trigger: 'hover'});
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

<style>
    .p-action{margin: 7px;}
</style>
