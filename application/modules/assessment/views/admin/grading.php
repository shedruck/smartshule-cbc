<div class="toolbar-fluid">
    <div class="information">
        <div class="item">
            <div class="rates">
                <div class="title">
                    <?php echo anchor('admin/assessment/', '<i class="glyphicon glyphicon-list"></i> Assessment ', 'class="btn btn-primary"'); ?>
                </div>
            </div>
        </div>                            
          <div class="item">
            <div class="rates">
                <div class="title">
                    <div class="btn-group">
                        <button class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Assessment</button>
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('admin/assessment/create/1'); ?>">Junior School</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('admin/assessment/create/2'); ?>">Primary</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('admin/assessment/create/3'); ?>">Senior School</a></li>
                            <li class="divider"></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>                             
        <div class="item">
            <div class="rates">
                <div class="title">
                    <?php echo anchor('admin/assessment/units/', '<i class="glyphicon glyphicon-list"></i>  Assessment Units', 'class="btn btn-primary"'); ?>
                </div>
            </div>
        </div>                         
        <div class="item">
            <div class="rates">
                <div class="title">
                    <?php echo anchor('admin/assessment/grading/', '<i class="glyphicon glyphicon-list"></i>  Assessment Grading', 'class="btn btn-primary"'); ?>
                </div>
            </div>
        </div>                         
    </div>
</div>
<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Assessment  Grading</h2>
    <div class="right"> </div>
</div>
<div class="slip">
    <?php echo form_open(current_url(), 'class="form-inline" id="fextra"'); ?>
    <table class="clon" width="100%">
        <?php
        $segments = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4
        );

        if ($this->input->post())
        {
                $len = count($this->input->post('title'));

                for ($ii = 2; $ii < $len; $ii++)
                {
                        ?>
                        <tr id="entry<?php echo $ii + 1; ?>" class="tr_clone">
                            <td width="15%">
                                <?php echo form_input('min[]', "", 'placeholder="Min Marks" class="desc" '); ?>
                                <?php echo form_error('min'); ?>
                            </td>
                            <td width="15%">
                                <?php echo form_input('max[]', "", 'placeholder="Max Marks" class="desc" '); ?>
                                <?php echo form_error('max'); ?>
                            </td>
                            <td width="10%">
                                <?php
                                echo form_dropdown('symbol[]', array('' => '') + $segments, "", ' class="fsel" ');
                                echo form_error('symbol');
                                ?>
                            </td>
                            <td width="10%">
                                <?php
                                echo form_dropdown('indicator[]', array('' => '') + $ind, "", ' class="ksel" ');
                                echo form_error('indicator');
                                ?>
                            </td>
                            <td>
                                <?php echo form_input('desc[]', "", 'placeholder="Description" class="desc" '); ?>
                                <?php echo form_error('desc'); ?>
                            </td>
                        </tr>
                        <?php
                }
        }
        else
        {
                ?>
                <tr class="entry1" class="tr_clone"> 
                    <td width="15%">
                        <?php echo form_input('min[]', "", 'placeholder="Min Marks" class="desc" '); ?>
                        <?php echo form_error('min'); ?>
                    </td>
                    <td width="15%">
                        <?php echo form_input('max[]', "", 'placeholder="Max Marks" class="desc" '); ?>
                        <?php echo form_error('max'); ?>
                    </td>
                    <td width="10%">
                        <?php
                        echo form_dropdown('symbol[]', array('' => '') + $segments, "", ' class="fsel" ');
                        echo form_error('symbol');
                        ?>
                    </td>
                    <td width="10%">
                        <?php
                        echo form_dropdown('indicator[]', array('' => '') + $ind, "", ' class="ksel" ');
                        echo form_error('indicator');
                        ?>
                    </td>
                    <td>
                        <?php echo form_input('desc[]', "", 'placeholder="Description" class="desc" '); ?>
                        <?php echo form_error('desc'); ?>
                    </td>
                </tr>
        <?php } ?>
    </table>
    <div class="actions">
        <a  id="btnAdd" class="btn btn-success clone">Add New Line</a> 
        <a  id="btnDel" class="btn btn-danger remove">Remove</a>
    </div>
    <div class='form-group'>
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary' "); ?>
            <?php echo anchor('admin/fee_structure/extras', 'Cancel', 'class="btn  btn-default"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?php
if ($grading)
{
        ?>
        <div class="block-fluid">
            <table class="table" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Symbol</th>
                        <th>Indicator</th>
                        <th>Description</th>
                        <th><?php echo lang('web_options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * 10;
                    }

                    foreach ($grading as $p):
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>		
                                <td><?php echo $p->symbol; ?></td>
                                <td><?php echo $p->indicator; ?></td>
                                <td><?php echo $p->description; ?></td>
                                <td width='30'>
                                    <div class='btn-group'>
                                        <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                        <ul class='dropdown-menu pull-right'>
                                            <li><a href='<?php echo site_url('admin/assessment/edit_grading/' . $p->id . '/' ); ?>'><i class='glyphicon glyphicon-eye-open'></i> Edit</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <?php
}else
{
        ?>
        <p class='text'>&nbsp;</p>
<?php } ?>
<style>
    .slip{background: #FFF;}
    .form-group {
        border: 0;
    }
</style>
<script type = "text/javascript">
        $(document).ready(function ()
        {
            $(".fsel").select2({'placeholder': 'Select Symbol', 'width': '100%'});
            $(".ksel").select2({'placeholder': 'Select Indicator', 'width': '100%'});

            var i = 2;
            $("#btnAdd").click(function () {
                var $tr = $("table.clon tr:first");
                var $tlast = $("table.clon tr:last");
                var $clone = $tr.clone();
                $clone.find(':text').val('');
                $clone.find('.select2-container').remove();
                $clone.find('select.ksel').select2({'placeholder': 'Select Indicator', 'width': '100%'});
                $clone.find('select.fsel').select2({'placeholder': 'Select Symbol', 'width': '100%'});
                $tlast.after($clone);
                i++;
            });
            $('#btnDel').click(function () {
                var num = $('.tr_clone').length;
                if (num == 1)
                {
                    alert("At least one Row Required.");
                }
                else
                {
                    // confirmation
                    if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
                    {
                        $('table.clon tr:last').remove().slideUp('slow');
                    }
                    return false;
                }
            });
        });
</script>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          