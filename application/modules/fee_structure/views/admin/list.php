<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Fee Structure (Tuition Fee Only) </h2> 
    <div class="right">                            
        <?php echo anchor('admin/fee_structure/create/', '<i class="glyphicon glyphicon-plus"></i> Add New', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/fee_structure/', '<i class="glyphicon glyphicon-list"></i> List All', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/fee_structure/invoice', '<i class="glyphicon glyphicon-export"></i> Fee Structure Report', 'class="btn btn-success"'); ?>
    </div>    					
</div>
<?php if (!empty($fee)): ?>              
        <div class="block-fluid">
            <table  cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Class</th>
                <th colspan="3">Fee</th>
                <th>&nbsp;</th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    ksort($fee);
                    foreach ($fee as $c => $po):
                            ksort($po);
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>			
                                <td><?php echo isset($class[$c]) ? $class[$c] : ' '; ?></td>
                                <?php
                                foreach ($po as $key => $ff):
                                        $r = (object) $ff;
                                        ?>
                                        <td><?php echo ' Term ' . $key . ': <h3> <span  class="editable amt" id="amount__' . $r->id . ' ">' . number_format($r->amount) . '</span></h3>'; ?> </td>
                                <?php endforeach; ?>
                                <td width="20%"> </td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; ?> 
<style>
    h3{  line-height: 12px;  color: #42536d; font-size: 16px; } table td {padding:4px;}
</style>
<script type="text/javascript">
        $(function () {
            $.fn.editable.defaults.mode = 'popup';
            $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
            $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
                    '<button type="button" class="btn editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
            $('.amt').editable({
                type: 'text',
                title: 'Enter Amount',
                placement: 'right',
                pk: 2,
                url: '<?php echo base_url('admin/fee_structure/update_fee/'); ?>',
                defaultValue: '   ',
                success: function (response, newValue) {
                    notify('Fee Structure', 'Amount Updated: ' + newValue);
                }
            }
            );

        });
</script>