<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Fee Payment  </h2>
    <div class="right">  
        <?php echo anchor('admin/fee_payment/create/', '<i class="glyphicon glyphicon-plus"></i> Receive Payment', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/fee_payment/paid', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Payment')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/fee_payment/all_voided', '<i class="glyphicon glyphicon-list">
                </i> Voided Payments', 'class="btn btn-warning"'); ?>				
    </div>
</div>

<div class="block-fluid">
    <table id="feee" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th  width="10%">Date</th>
                <th>Student.</th>
                <th>Amount </th>
				 <th>Transaction No. </th>
                <th>Bank </th>
               
                <th>Type</th>
                <th>Details</th>
                <th width="17%" ><?php echo lang('web_options'); ?></th>
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
                dom: 'C lfrBtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5'
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sServerMethod": "GET",
                "sAjaxSource": "<?php echo base_url('admin/fee_payment/get_paid'); ?>",
                "iDisplayLength": <?php echo $this->list_size; ?>,
                "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, 'All']],
                "aaSorting": [[0, 'asc']],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html("  <div class='btn-group'><a class='btn btn-success' href ='<?php echo base_url('admin/fee_payment/receipt/'); ?>" + "/" + aData[0] + "' >Receipt</a><a class='btn btn-primary' href ='<?php echo base_url('admin/fee_payment/edit/'); ?>" + "/" + aData[0] + "' >Edit</a><a onClick='return confirm(\"Are you sure you want to void this payment? (IRREVERSIBLE)\")' class='btn btn-danger' href ='<?php echo base_url('admin/fee_payment/void/'); ?>" + "/" + aData[0] + "' >Void</a> " + '</div>');
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