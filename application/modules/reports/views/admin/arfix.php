<div class="col-md-12">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>

        <h2>Fix Starting Balances </h2> 
        <div class="right">                            
            <button onClick="window.print();
                        return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span>
                Print </button>
        </div>    					
    </div>
    <div class="block-fluid invoice">
        <div class="col-md-9">
            <h3 align="center"> <?php echo $this->school->school; ?></h3> 
            <h4 align="center"> Fix </h4> 
            <span class="right">
                <b>Year :</b>
                <abbr title="Class"><?php echo date('Y'); ?></abbr>
            </span>
        </div>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        
        <table width="100%">
            <tr>
                <th width="20%">#</th>
                <th colspan="2" width="40%">Student</th>
                <th colspan="2" width="40%">  </th>
            </tr>
            <?php
            $i = 0;
            foreach ($result as $r):
                    $std = $this->worker->get_student($r->student);
                    $i++;
                    ?>
                    <tr>
                        <?php
                        $nm = 'arr_' . $r->id;
                        ?>
                        <td > <?php echo $i . '. '; ?></td>
                        <td colspan="2"> <?php echo $std->first_name . ' ' . $std->last_name; ?></td>
                        <td colspan="2"  class="bglite">
                            <span  class="editable remarks" id="<?php echo $nm; ?>">
                                <?php echo $r->amount; ?></span>
                        </td>
                    </tr>
            <?php endforeach; ?>         

        </table>
        <div class='form-group'>
            <div class="col-md-10"> 
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
        $(function () {
            $.fn.editable.defaults.mode = 'inline';
            $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
            $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
                    '<button type="button" class="btn editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
            $('.remarks').editable({
                type: 'text',
                title: 'Enter Amount',
                placement: 'right',
                pk: 2,
                url: '<?php echo base_url('admin/reports/put_arrear/'); ?>',
                defaultValue: '   ',
                success: function (response, newValue) {
                    notify('Progress Record', 'Remarks Added: ' + newValue);
                }
            }
            );

        });
</script>
<style>
    .bglite{background-color: #fff;}
</style>