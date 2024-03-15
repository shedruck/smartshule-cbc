<div><div class="col-md-2 hidden-xs">&nbsp;</div>
    <div class="col-md-8">
        <div class="head">
            <div class="icon"><span class="icosg-target1"></span></div>
            <?php
            $std = $this->worker->get_student($student);
            $std->cls = $cls;
            ?>
            <div class="text-right hidden-print">                            
                <h4>REPORT FORM For: <?php echo $std->first_name . ' ' . $std->last_name; ?></h4> 
                <?php echo anchor('trs/remarks/' . $exam . '/' . $id . '/1/', '<i class="mdi mdi-list"></i> < Go Back', 'class="btn btn-xs btn-primary"'); ?>
                <button onClick="window.print();
                            return false" class="btn btn-xs btn-primary" type="button"><span class="mdi mdi-printer"></span> Print </button>
            </div>
        </div>
        <div class="block-fluid slip">
            <div id="invoice-top">
                <div class="info">
                    <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  alt="img"  height="80" />
                </div><!--End Info-->
                <div class="title">
                    <h3><?php echo strtoupper($this->school->school); ?></h3>
                    <p><?php echo $this->school->postal_addr; ?><br>
                        Tel: <?php echo $this->school->tel; ?> <?php echo $this->school->cell; ?>
                    </p>
                </div><!--End Title-->
            </div>
            <div class="row">        
                <table class="topdets">
                    <tr>
                        <td><strong>Name : </strong>
                            <abbr><?php echo $std->first_name . ' ' . $std->last_name; ?> </abbr>
                        </td>
                        <td><strong>Exam : </strong> <abbr><?php echo strtoupper($row->title); ?></abbr>
                        </td>
                        <td><strong>Term : </strong> <abbr><?php echo $row->term; ?></abbr> <strong> Year : </strong> <abbr><?php echo $row->year; ?></abbr></td>
                        <td><strong>ADM No : </strong>
                            <abbr><?php
                                echo (!empty($std->old_adm_no)) ? $std->old_adm_no : $std->admission_number;
                                ?>
                            </abbr>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Class : </strong>
                            <abbr><?php echo $std->cl->name; ?></abbr>
                        </td>
                        <td>
                            <strong>Age : </strong> 
                            <abbr>
                                <?php echo (!empty($std->dob) && $std->dob > 10000) ? $this->dates->createFromTimeStamp($std->dob)->diffInYears() : '-'; ?>
                            </abbr>
                        </td> 
                        <td></td>
                        <td><strong>Class Teacher : </strong>
                            <abbr><?php
                                $cc = '';
                                if (!empty($std->cl->class_teacher))
                                {
                                        $ctc = $this->ion_auth->get_user($std->cl->class_teacher);
                                        if ($ctc)
                                        {
                                                $cc = $ctc->first_name . ' ' . $ctc->last_name;
                                        }
                                }
                                echo $cc;
                                ?>
                            </abbr>
                        </td>
                    </tr>
                </table>
                <hr>
            </div>
            <div class="col-md-9">
                <h4 align="center"> REPORT FORM </h4> 
            </div>
            <?php
            $frm = array();
            $frmw = array();
            foreach ($remarks as $rm)
            {
                    if ($rm->sub_id == 9999)
                    {
                            $frmw[$rm->parent] = $rm->remarks;
                    }
                    else
                    {
                            $frm[$rm->parent][$rm->sub_id] = $rm->remarks;
                    }
            }
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo form_open_multipart(current_url(), $attributes);
            ?>

            <?php
            if (count($subjects) < 1)
            {
                    ?>
                    <div class="col-md-9">
                        <div class="alert alert-danger">                
                            <strong>Error!</strong> No Subjects Have been added for this Class
                        </div>
                    </div>
                    <?php
            }
            else
            {
                    ?>
                    <table class="table table-striped table-bordered" width="100%">
                        <tr> 
                            <th colspan="2" width="30%"><strong>SUBJECTS</strong></th>
                            <th colspan="2" width="70%">
                                <strong>CLASS TEACHER'S REMARKS</strong></th>
                        </tr>
                        <?php
                        foreach ($subjects as $key => $post):
                                $pp = (object) $post;
                                if ($pp->opt == 3)
                                {
                                        continue;
                                }
                                ?>
                                <tr> 
                                    <?php
                                    if (isset($subtests[$key]))
                                    {
                                            $tts = $subtests[$key];
                                            ?>
                                            <td rowspan="<?php echo count($tts); ?>"> <?php echo $full_subjects[$key]; ?>  </td>
                                            <?php
                                            foreach ($tts as $tid => $ttl)
                                            {
                                                    $nm = 'rmk_' . $key . '_' . $tid;
                                                    $srmk = isset($frm[$key]) && isset($frm[$key][$tid]) ? $frm[$key][$tid] : '';
                                                    ?>
                                                    <td><?php echo $ttl; ?></td><td colspan="2" class="bglite"><span class="editable remarks" id="<?php echo $nm; ?>" ><?php echo $srmk; ?></span></td> </tr>
                                                <?php
                                        }
                                }
                                else
                                {
                                        $nm = 'rmk_' . $key;
                                        $mrmk = isset($frmw[$key]) ? $frmw[$key] : ' ';
                                        ?>
                                        <td colspan="2"> <?php echo $full_subjects[$key]; ?> </td>
                                        <td colspan="2" class="bglite"><span class="editable remarks" id="<?php echo $nm; ?>"><?php echo trim($mrmk); ?></span></td>
                                        </tr>
                                <?php } ?>
                        <?php endforeach; ?>
                    </table>
                    <div class='form-group'>
                        <div class="col-md-3 genn">GENERAL REMARKS </div>
                        <div class="col-md-9">
                            <span class="editable gen editable-wrap" e-style="width:76%;"><?php echo empty($full) ? '' : $full->remarks; ?></span>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class="col-md-10">
                            <span style="line-height:30px; font-size:12px;">
                                Attendance: ...................................................................................................										  
                            </span>
                        </div>
                    </div>
            <?php } ?> 
            <?php echo form_close(); ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function () {
            $.fn.editable.defaults.mode = 'inline';
            $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
            $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="mdi mdi-check-circle mdi-24px "></i></button>' +
                    '<button type="button" class="btn btn-danger editable-cancel"><i class="mdi mdi-close-circle  mdi-24px"></i></button>';
            $('.remarks').editable({
                emptytext: '        ',
                type: 'textarea',
                title: 'Enter Remarks',
                placement: 'right',
                pk: <?php echo $student; ?>,
                url: '<?php echo base_url('admin/exams/push_lower/' . $exam); ?>',
                defaultValue: '',
                success: function (response, newValue)
                {
                    notify('Report Form', 'Remarks Updated: ');
                }
            });
            $('.gen').editable({
                emptytext: '        ',
                type: 'textarea',
                title: 'Enter Remarks',
                placement: 'right',
                inputclass: 'xxd',
                pk: <?php echo $student; ?>,
                url: '<?php echo base_url('admin/exams/push_remarks/' . $exam); ?>',
                defaultValue: '',
                success: function (response, newValue)
                {
                    notify('Report Form', 'General Remarks Updated: ');
                }
            });
        });
</script>
<style>
    .editable-cancel, .editable-submit{margin-top: 5px; padding: 1px 14px;}
    .topdets {
        width:100%;
        margin: 0 auto;
        border: 0;
    }
    .topdets th,  .topdets td ,.topdets 
    {
        border: 0;
    }
    .editable-container.editable-inline {
        width: 100%;
    }

    .editable-input {
        display: inline; 
        width: 100%;
    }
    .editableform .form-control{
        width: 100%; 
    }
    .editableform .form-group{
        width: 100%; 
    }
    .bglite{background-color: #fff;}
    .toppa img{
        width:150px;
        height:80px;
    }

    .toppa{
        text-align: right;
        color: #66B0EA;
        padding-top: 0;
    }
    .lethead
    {
        border: 0;
    }
    .info {
        display: block;
        float: left;
        margin-left: 20px;
    }
    .title {
        float: right;
    }
    hr {
        margin-top: 1px;
        margin-bottom: 1px;
    }
    table td, table th {
        padding: 4px; font-size: 12px;
    }
    .slip{padding: 20px;}
    p{margin: 0 !important;}
    .toppa span.stitle{font-size: 30.5px; font-family:  serif; font-weight: bold;}
    @media print{
        td.toppa ,  .lethead th
        {
            border: 0;
        }
        .slip{padding-top: 0 !important;}
        td.toppa 
        {
            border-right: none !important;
            border-bottom: none !important;
        }
        .toppa img{
            width:150px;
            height:80px;
        }
        .editable-click, a.editable-click, a.editable-click:hover {
            text-decoration: none;
            border-bottom: none !important;
        }
        .genn{text-decoration: underline;}
    }
</style>