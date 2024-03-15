<?php echo $template['partials']['perms']; ?>
        <div class="head"> 
            <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Fix Resources </h2>
            <div class="right">  
            </div>
        </div>
<div class="row">
    <div class="block-fluid">
         <div class="scrolld" style="/*height:500px*/">
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo form_open_multipart(current_url(), $attributes);
            ?>

            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th width="6%">#</th>
                    <th colspan="2" width="20%">Resource</th>
                    <th colspan="2" width="20%">Category</th>
                    <th colspan="2" width="40%">Title</th>
                </tr>
                <?php
                $i = 0;
                foreach ($result as $r):
                        $i++;
                        ?>
                        <tr>
                            <?php
                            $nm = 'cat_' . $r->id;
                            $des = 'description_' . $r->id;
                            ?>
                            <td > <?php echo $i . '. '; ?></td>
                            <td colspan="2"> <?php echo $r->resource; ?></td>
                            <td colspan="2" class="bglite"><span  class="editable remarks" id="<?php echo $nm; ?>"><?php echo $r->cat; ?></span></td>
                            <td colspan="2"><span  class="editable remarks" id="<?php echo $des; ?>"><?php echo $r->description; ?></span></td>
                        </tr>
                <?php endforeach; ?>         

            </table>

            <?php echo form_close(); ?>

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
                title: 'Enter Title',
                placement: 'right',
                pk: 2,
                url: '<?php echo base_url('admin/permissions/mend_resources/'); ?>',
                defaultValue: '   ',
                success: function (response, newValue) {
                   notify('Route Fixer', 'Route Updated: ' + newValue);
                }
            }
            );

        });
</script>
<style>
    .bglite{background-color: #fff;}
</style>