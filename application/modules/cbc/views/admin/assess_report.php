<?php
$range = range(date('Y') - 30, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);

$y_opt = [];
foreach ($yrs as $k => $v) {
    $y_opt[] = ['id' => $k, 'text' => $v];
}


$darasa = $this->uri->segment(4);
$tam = $this->uri->segment(5);
$mwaka = $this->uri->segment(6);


?>

<div id="assess" class="block-fluid mb-20 hidden-print">
    <div class="row">
        <div class="col-md-7">
            <h4 class="text-uppercase">Assessment Report: &nbsp; &nbsp; &nbsp; <?php echo $class->name ?></h4>
            <h4 class="text-uppercase">Term: &nbsp; &nbsp; &nbsp; Term <?php echo $term ?></h4>
            <h4 class="text-uppercase">Year: &nbsp; &nbsp; &nbsp; <?php echo $year ?></h4>

        </div>
        <div class="col-md-3">
            <?php echo form_open(base_url('admin/cbc/send_reminder/' . $darasa . '/' . $tam . '/' . $mwaka)) ?>
            <button class="btn btn-success" type="submit" value="1" onClick="return confirm('<?php echo 'Are you sure ?'; ?>')"><i class="glyphicon glyphicon-envelope"></i> Notify Parents</button>
            <?php echo form_close() ?>
        </div>
        <div class="col-md-1">
            <a href="<?php echo base_url('admin/cbc/assessment'); ?>" class="pull-right btn btn-primary"><i class="mdi mdi-reply"></i> Back</a>
        </div>
        <div class="clearfix"></div>
        <hr>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'sp');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class="form-group row">
            <div class="col-sm-4">
                Student: <br>
                <div>
                    <?php echo form_dropdown('student', ['' => ''] + $students, $this->input->post('student'), ' class="select" data-placeholder="Select Options..." '); ?>
                </div>
            </div>
            <div class="col-sm-4">
                Learning Area: <br>
                <div>
                    <?php echo form_dropdown('subject', ['' => ''] + $subjects, $this->input->post('subject'), ' class="select" data-placeholder="Select Options..." '); ?>
                </div>
            </div>
            <div class="col-sm-4">
                Rating Option: <br>
                <div class="form-control">
                    <div class="col-md-6">
                        <input type="radio" id="mn" name="format" value="1" class="custom-control-input">
                        <label class="custom-control-label" for="mn">1 - 4</label>
                    </div>
                    <div class="col-md-6">
                        <input type="radio" id="abbr" name="format" value="2" class="custom-control-input">
                        <label class="custom-control-label" for="abbr">EE, ME,AE ,BE </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="offset-md-3 col-sm-4">&nbsp;</div>
            <div class="offset-md-3 col-sm-4">
                <br>
                <button type="submit" class="btn btn-info btn-lg"><i class="mdi mdi-check"></i> Submit</button>
                <?php
                if ($this->input->post() && !empty($result)) {
                ?>
                    <a class="btn btn-success btn-lg" onclick="javascript:window.print();"><i class="mdi mdi-printer"></i> Print</a>
                <?php } ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="block-fluid">
    <div class="clearfix"></div>
    <?php
    if ($this->input->post()) {
        if (empty($result)) {
    ?><div class="alert alert-warning" role="alert">
                <strong>No result found.</strong>
            </div>
        <?php
        } else {
        ?>
            <div class="row page-break">
                <div class="img-container">
                    <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" style="height:68px;" alt="header">
                </div>
                <div class="text-center">
                    <h4><strong>ASSESSMENT REPORT</strong></h4>
                    <h4 class="text-uppercase"><ins>NAME:</ins> <?php echo $result->student; ?> &nbsp;&nbsp;&nbsp;<ins>ADM.</ins> &nbsp;&nbsp;&nbsp; <?php echo $result->adm; ?> &nbsp;&nbsp;&nbsp; <ins>Age:</ins> <?php echo $result->age; ?></h4>
                    <p>
                        <span class="text-uppercase"><?php echo $class->name ?> Term <?php echo $term; ?> - <?php echo $year; ?></span>
                    </p>
                </div>

                <div class="clearfix"></div>
                <hr>
                <div class="">
                    <center><img src="<?php echo base_url('/uploads/files/key.png'); ?>"></center>
                </div>
                <div>
                    <table class="table table-bordered">
                        <?php
                        $j = 0;

                        foreach ($result->strands as $rs) {
                            $j++;
                        ?>
                            <tbody>
                                <tr class="fbg">
                                    <td><?php echo $j; ?>.0 </td>
                                    <td class="text-uppercase"><?php echo $rs->name; ?></td>
                                    <td width="8%" class="text-center"><strong><?php echo $rs->rating; ?> </strong></td>
                                    <td width='30%'> <span>Teacher Comments</span> </td>
                                </tr>
                                <?php
                                $k = 0;
                                foreach ($rs->subs as $sb) {
                                    $k++;
                                ?>

                                    <tr>
                                        <td :class="{ 'fbg': sub.tasks.length}"><?php echo $j; ?>.<?php echo $k; ?></td>
                                        <td :class="{ 'fbg': sub.tasks.length}"><strong><?php echo $sb->name; ?></strong></td>
                                        <td :class="{ 'fbg': sub.tasks.length}" class="text-center"> <?php echo $sb->rating; ?></td>
                                        <?php
                                        if ($k != 1) {
                                        ?>
                                            <td :class="{ 'fbg': sub.tasks.length}"></td>
                                       <?php }?>
                                    </tr>
                                    <?php
                                    $t = 0;

                                   
                                    foreach ($sb->tasks as $tsk) {
                                        $t++;

                                       
                                    ?>
                                        <tr v-for="(t, tx) in sub.tasks">
                                            <td> </td>
                                            <td><?php echo $tsk->task; ?> </td>
                                            <?php
                                            if ($k == 1) {
                                            ?>
                                                <td class="text-center"><?php echo $tsk->rating; ?></td>
                                            <?php }
                                            
                                            ?>
                                                <td >
                                                    <?php echo $tsk->remarks; ?>
                                                </td>
                                            <?php   ?>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        <?php } ?>
                    </table>
                    <hr>
                    <div class="foo col-sm-12">
                        <strong><span style="text-decoration:underline; font-size:15px;">Head Teacher's Comment:</span></strong> <br>


                        <span class="editable remks" id="item_<?php echo $payload->id; ?>" data-rec="<?php echo $payload->id; ?>">
                            <?php echo  $payload->headteacher_remarks ?>
                        </span>



                        <img class="pull-right" src="<?php echo base_url('uploads/headteacher-signature.png'); ?>" width="200" height="80">
                        <!-- </span> -->
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>
<style>
    div.radio span {
        margin-top: -4px !important;
    }

    .img-container {
        text-align: center;
        display: block;
    }

    .fbg {
        background: #f5f6fa;
        font-weight: bold;
    }

    .panel .panel-body p {
        line-height: 14px;
    }

    .p-10 {
        padding: 10px !important;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .mb-2 {
        margin-bottom: 5px;
    }

    .mb-20 {
        margin-bottom: 20px !important;
    }

    .underline {
        text-decoration: underline;
    }

    @media print {
        .page-break {
            page-break-after: always;
        }

        .page-break:last-child {
            page-break-after: avoid;
        }
    }

    table.table-bordered th:last-child,
    table.table-bordered td:last-child {
        border-right-width: 1px;
    }
</style>

<script>
    $(function() {
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
            '<button type="button" class="btn editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
        var fpk;
        $('.remks').each(function(i, obj) {
            var $px = $(this);
            fpk = $px.attr('data-rec');
            $px.editable({
                type: 'text',
                title: 'Enter Remarks',
                placement: 'right',
                pk: fpk,
                url: '<?php echo base_url('admin/cbc/save_remarks'); ?>',
                defaultValue: '   ',
                success: function(response, newValue) {
                    notify('CBC', 'Remarks Posted Successfully:  ' + newValue);
                }
            });
        });
    })
</script>