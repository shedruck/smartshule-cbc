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
        <h2>  Fee Payment  </h2>
        <div class="right">  
            <?php echo anchor('admin/fee_payment/create/', '<i class="glyphicon glyphicon-plus"></i> Receive Payment', 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/fee_payment', '<i class="glyphicon glyphicon-list"></i> ' . lang('web_list_all', array(':name' => 'Fee Payment')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/fee_payment/bulk', '<i class="glyphicon glyphicon-envelope"></i> Bulk SMS Reminder', 'class="btn btn-warning" '); ?>
            <?php echo anchor('admin/fee_payment/refresh', '<i class="glyphicon glyphicon-cogs"></i> Refresh', 'class="btn btn-danger" '); ?>
        </div>
    </div>
    <div class="block-fluid">
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
                    <th width="13%"><?php echo lang('web_options'); ?></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            </tfoot>

        </table> 
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
        $(document).ready(function () {
            var oTable;
            oTable = $('#fee_bal').dataTable({
                dom: 'C lfrpBtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5'
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/fee_payment/get_by_student'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, 'All']],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html("<div class='btn-group'><a class='btn btn-success tip' data-original-title='View Statement' href ='<?php echo base_url('admin/fee_payment/statement/'); ?>" + "/" + aData[0] + "' ><i class='glyphicon glyphglyphicon glyphicon-list'></i></a> <a class='btn btn-warning tip'  onClick='return confirm(\"Are you sure you want to send SMS reminder to parent/guardian?\")' href ='<?php echo base_url('admin/fee_payment/reminder/'); ?>" + "/" + aData[0] + "' data-original-title='Send Reminder'  ><i class='glyphicon glyphicon-envelope'></i> </a>  " + '</div>');
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
                    }]
            }).fnSetFilteringDelay(700);
        });
</script>
