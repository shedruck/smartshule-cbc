<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>  Expenses </h2> 
    <div class="right">                            
         <?php echo anchor('admin/expenses/create/' . $page, '<i class="glyphicon glyphicon-plus"> </i>' . lang('web_add_t', array(':name' => 'Expenses')), 'class="btn btn-primary"'); ?>
         <?php echo anchor('admin/expenses/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
         <?php echo anchor('admin/expenses/voided', '<i class="glyphicon glyphicon-list">
                </i> Voided Expenses', 'class="btn btn-warning"'); ?>
    </div>    					
</div>

<div class="toolbar-fluid">
    <div class="information">
        <div class="item">
            <div class="rates">
                <div class="title"><?php
                         if (empty($total_exp_day->total))
                              echo '0.00';
                         else
                              echo number_format($total_exp_day->total, 2);
                     ?> </div>
                <div class="description">Total Expenses Today (<?php echo $this->currency; ?>)</div>
            </div>
        </div>
        <div class="item">
            <div class="rates">
                <div class="title">
                     <?php
                         $t = $total_petty_cash->total + $wages + $total_exp_month->total;
                         if ($t == 0)
                              echo '0.00';
                         else
                              echo number_format($t, 2);
                     ?>

                </div>
                <div class="description">Total Expenses This Term (<?php echo $this->currency; ?>)</div>
            </div>
        </div>


        <div class="item">
            <div class="rates">
                <div class="title">


                    <?php
                        if (empty($total_petty_cash->total))
                             echo '0.00';
                        else
                             echo number_format($total_petty_cash->total, 2);
                    ?></div>
                <div class="description"> Total  Petty Cash This Term (<?php echo $this->currency; ?>)</div>
            </div>
        </div>	

        <div class="item">
            <div class="rates">
                <div class="title">
                     <?php
                         $t = $wages + $total_exp_year->total + $total_petty_cash->total;
                         if ($t == 0)
                              echo '0.00';
                         else
                              echo number_format($t, 2);
                     ?>
                </div>
                <div class="description">Total Expenses This Year (<?php echo $this->currency; ?>)</div>
            </div>
        </div> 
    </div>
</div>

<div class="block-fluid">

    <table cellpadding="0" cellspacing="0" border="0" class='hover' id="exx_table" width="100%">
        <thead>
        <th>#</th>
        <th>Date</th>
        <th>Item</th>
        <th>Category</th>
        <th>Amount</th>
        <th>Person<br>Responsible</th>
        <th>Bank Account</th>
        <th width="28%">Particulars</th>
        <th width="22%"><?php echo lang('web_options'); ?></th>
        </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
</div>
<script type="text/javascript">
     $(document).ready(function () {
          var oTable;
          oTable = $('#exx_table').dataTable({
               "dom": 'TC lfrtip', //'TC<"clear">lfrtip',
               "tableTools": {
                    "sSwfPath": "<?php echo js_path('plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf') ?>"
               },
               "bProcessing": true,
               "bServerSide": true,
               "sServerMethod": "GET",
               "sAjaxSource": "<?php echo base_url('admin/expenses/get_table'); ?>",
               "iDisplayLength": <?php echo $this->list_size; ?>,
               "aLengthMenu": [[10, 25, 50, 200], [10, 25, 50, 200]],
               "aaSorting": [[0, 'asc']],
               "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    var preff = oSettings._iDisplayStart + iDisplayIndex + 1;
                    $("td:first", nRow).html(preff + '. ');
                    $("td:last", nRow).html("  <div class='btn-group'> <a class='btn btn-primary' href ='<?php echo base_url('admin/expenses/edit/'); ?>" + "/" + aData[0] + "' >Edit</a> <a onClick='return confirm(\"Are you sure?\")' class='kftt btn btn-danger' href ='<?php echo base_url('admin/expenses/void/'); ?>" + "/" + aData[0] + "' ' >Void</a>" + '</div>');
                    $("td:nth-child(5)", nRow).addClass('rttb');
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
