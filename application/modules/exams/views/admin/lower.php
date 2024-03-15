<div class="col-md-12">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <?php
        $std = $this->worker->get_student($student);
        $std->cls = $cls;
        ?>
        <h2>REPORT FORM For: <?php echo $std->first_name . ' ' . $std->last_name; ?></h2> 
        <div class="right">                            
            <?php echo anchor('admin/exams/rec_lower/' . $class . '/' . $id . '/1/', '<i class="glyphicon glyphicon-list"></i> < Go Back', 'class="btn btn-primary"'); ?>
            <button onClick="window.print();
                        return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
        </div>
    </div>
    <div class="block-fluid slip">
        <div id="invoice-top">
            <div class="logo"></div>
            <div class="info">
                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  alt="img" width="150" height="110" />
            </div><!--End Info-->
            <div class="title">
                <h3><?php echo strtoupper($this->school->school); ?></h3>
                <p><?php echo $this->school->postal_addr; ?><br>
                    Tel: <?php echo $this->school->tel; ?> <?php echo $this->school->cell; ?>
                </p>
            </div><!--End Title-->
        </div>
        <div class="row center">
            <table class="lethead" style="border:none !important">
                <?php
                $file = FCPATH . '/uploads/report.png';
                if (file_exists($file))
                {
                        ?>
                        <tr>
                            <td colspan="2">
                                <img src="<?php echo base_url('uploads/report.png'); ?>" class="left" alt="logo"/>
                            </td>
                        </tr>
                        <?php
                }
                else
                {
                        /*  ?>
                          <tr width="100%">
                          <td class="toppa">
                          <div style="clear: right"></div>
                          </td>
                          <td class="toppa">
                          <span class="stitle"></span>
                          <p class="redtop stitle">REPORT FORM</p>
                          </td>
                          </tr>
                          <?php */
                }
                ?>
            </table>
        </div>
        <hr>
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
        <div class='form-group'>
            <div class="col-md-10">
                <span style="line-height:20px; font-size:12px;">
                    Attendance: 
                    <span class="editable att editable-wrap" e-style="width:76%;"><?php echo empty($full) || !$full->att ? '   ' : $full->att; ?></span> 
                    Out of 
                    <span class="editable out editable-wrap" e-style="width:76%;"><?php echo empty($full) || !$full->out_of ? '   ' : $full->out_of; ?></span>
                    Sessions										  
                </span>
            </div>
        </div>
        <?php
        if (count($subjects) < 1)
        {
                ?>
                <div class="col-md-6">
                    <div class="alert alert-block">                
                        <strong>Error!</strong> You Must Add All Subjects First Before Recording Exam Marks 
                        <br><br>Add Subjects <?php echo anchor('admin/subjects', 'Here'); ?>
                    </div>
                </div>
                <?php
        }
        else
        {
                ?>
                <table width="100%">
                    <tr> 
                        <th colspan="2" width="40%"><strong>SUBJECTS</strong></th>
                        <th colspan="2" width="60%">
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
                                    <td colspan="2" class="bglite"><span  class="editable remarks" id="<?php echo $nm; ?>"><?php echo $mrmk; ?></span></td>
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
        <?php } ?> 
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
        $(function () {
            //editables on first profile page
            $.fn.editable.defaults.mode = 'inline';
            $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue glyphicon glyphicon-2x glyphicon glyphicon-spinner glyphicon glyphicon-spin'></i></div>";
            $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit" title="Submit"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i></button>' +
                    '<button type="button" class="btn btn-danger editable-cancel" title="Cancel"><i class="glyphicon glyphicon-remove"></i></button>';
            $('.remarks').editable({
                type: 'textarea',
                title: 'Enter Remarks',
                placement: 'right',
                pk: <?php echo $student; ?>,
                url: '<?php echo base_url('admin/exams/push_lower/' . $exam); ?>',
                defaultValue: '   ',
                success: function (response, newValue)
                {
                    notify('Report Form', 'Remarks Added: ' + newValue);
                }
            });
            $('.gen').editable({
                type: 'textarea',
                title: 'Enter Remarks',
                placement: 'right',
                inputclass: 'xxd',
                pk: <?php echo $student; ?>,
                url: '<?php echo base_url('admin/exams/push_remarks/' . $exam); ?>',
                defaultValue: '',
                success: function (response, newValue)
                {
                    notify('Report Form', 'Remarks Added: ' + newValue);
                }
            });
            $('.att').editable({
                type: 'text',
                title: 'Attendance',
                placement: 'right',
                inputclass: 'xxd',
                pk: <?php echo $student; ?>,
                url: '<?php echo base_url('admin/exams/push_attendance/' . $exam); ?>',
                emptytext: '---',
                success: function (response, newValue)
                {
                    notify('Report Form', 'Attendance: ' + newValue);
                }
            });
            $('.out').editable({
                type: 'text',
                title: 'Attendance',
                placement: 'right',
                inputclass: 'xxd',
                pk: <?php echo $student; ?>,
                url: '<?php echo base_url('admin/exams/save_total/' . $exam); ?>',
                emptytext: '---',
                success: function (response, newValue)
                {
                    notify('Report Form', 'Attendance: ' + newValue);
                }
            });

        });
</script>
<style>
    .editableform textarea {
        height: 150px !important; 
    }
    .topdets {
        width:89%;
        margin: 0 auto;
        border: 0;
    }
    .topdets th,  .topdets td ,.topdets 
    {
        border: 0;
    }
    .editable-container.editable-inline 
    {
        width: 89%;
    }

    .editable-input {
        display: inline; 
        width: 89%;
    }
    .editableform .form-control {
        width: 89%;
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
        padding: 4px;
    }
    .slip{padding: 20px;}
    p{margin: 0 !important;}
    .toppa span.stitle{font-size: 30.5px; font-family:  serif; font-weight: bold;}
    @media print{
        .out,.att{text-decoration: underline; margin-left: 12px;  margin-right: 12px; font-size: 15px; font-weight: bold;}
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