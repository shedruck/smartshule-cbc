<?php echo $template['partials']['perms']; ?>
<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Fix Routes </h2>
    <div class="right">  
    </div>
</div>
<div class="row">
    <div class="block-fluid">
        <div class="scssroll" >
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo form_open_multipart(current_url(), $attributes);
            ?>
             <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th width="6%">#</th>
                    <th colspan="2" width="20%">Module</th>
                    <th colspan="2" width="20%">Route</th>
                    <th width="30%">Title</th>
                    <th width="24%">Menu</th>
                </tr>
                <?php
                $i = 0;
                foreach ($result as $r):
                        $snam = isset($resources[$r->resource]) ? $resources[$r->resource] : '-';
                        $i++;
                        ?>
                        <tr>
                            <?php
                            $nm = 'description__' . $r->id;
                            ?>
                            <td > <?php echo $i . '. '; ?></td>
                            <td colspan="2"> <?php echo $snam; ?></td>
                            <td colspan="2"> <?php echo $r->method; ?></td>
                            <td class="bglite">
                                <span  class="editable remarks" id="<?php echo $nm; ?>"> <?php echo $r->description; ?></span>
                            </td>
                            <td colspan="2"  class="bglite">
                                <input type="checkbox" class="switchx" name="menu<?php echo $r->id; ?>" <?php echo $r->is_menu==1 ? 'checked="checked"' : ''; ?>>
                            </td>
                        </tr>
                <?php endforeach; ?>         

            </table>
             <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
        new DG.OnOffSwitchAuto({
            cls: '.switchx',
            textOn: "YES",
            height: 25,
            textOff: "NO",
             listener: function (name, checked) {
                console.log("Listener called for " + name + ", checked: " + checked);
                $.ajax({
                    url: "<?php echo base_url('admin/permissions/set_menu'); ?>",
                    type: "post",
                    data: {name: name, val: checked},
                    success: function (data)
                    {

                    }
                });
            }
        });
</script>
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
                url: '<?php echo base_url('admin/permissions/mend_routes/'); ?>',
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
    .on-off-switch{
        position:relative;
        cursor:pointer;
        overflow:hidden;
        user-select:none;
    }

    .on-off-switch-track{
        position:absolute;
        border : solid #888;
        z-index:1;
        background-color: #fff;
        overflow:hidden;
    }

    /* semi transparent white overlay */
    .on-off-switch-track-white{
        background-color:#FFF;
        position:absolute;
        opacity:0.2;
        z-index:30;
    }
    /* Track for "on" state */
    .on-off-switch-track-on{
        background-color:#009966;
        border-color:#008844;
        position:absolute;
        z-index:10;
        overflow:hidden;
    }
    /* Track for "off" state */
    .on-off-switch-track-off{
        position:absolute;
        border-color:#CCC;
        z-index:1;
    }

    .on-off-switch-thumb{
        position:absolute;
        z-index:2;
        overflow:hidden;
    }

    .on-off-switch-thumb-shadow{
        opacity:0.5;
        border:1px solid #000;
        position:absolute;
    }

    .track-on-gradient, .track-off-gradient{

        background: -webkit-linear-gradient(180deg,rgba(0,0,0,0.2), rgba(0,0,0,0)); /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(180deg, rgba(0,0,0,0.2), rgba(0,0,0,0)); /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(180deg, rgba(0,0,0,0.2), rgba(0,0,0,0)); /* For Firefox 3.6 to 15 */
        background: linear-gradient(180deg, rgba(0,0,0,0.2), rgba(0,0,0,0)); /* Standard syntax */
        position:absolute;
        width:100%;
        height:5px;
    }


    .on-off-switch-thumb-color{
        background: -webkit-linear-gradient(45deg, #BBB, #FFF); /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(45deg, #BBB, #FFF); /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(45deg, #BBB, #FFF); /* For Firefox 3.6 to 15 */
        background: linear-gradient(45deg, #BBB, #FFF); /* Standard syntax */
        background-color:#F0F0F0;
        position:absolute;
    }

    .on-off-switch-thumb-off{
        border-color:#AAA;
        position:absolute;
    }
    .on-off-switch-thumb-on{
        border-color:#008855;
        z-index:10;
    }
    .on-off-switch-text{
        width:100%;
        position:absolute;
        font-family:arial;
        user-select:none;
        font-size:10px;
    }

    .on-off-switch-text-on{
        color:#FFF;
        text-align:left;
    }
    .on-off-switch-text-off{
        color:#000;
        text-align:right;
    }
    /* Mouse over thumb effect */
    .on-off-switch-thumb-over{
        background-color:#F5F5F5;
        background: -webkit-linear-gradient(45deg, #CCC, #FFF); /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(45deg, #CCC, #FFF); /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(45deg, #CCC, #FFF); /* For Firefox 3.6 to 15 */
        background: linear-gradient(45deg, #CCC, #FFF); /* Standard syntax */

    }
</style>