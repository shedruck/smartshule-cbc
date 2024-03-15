<?php
$range = range(date('Y') - 10, date('Y'));
$yrs = array_combine($range, $range);
krsort($yrs);

$y_opt = [];
foreach ($yrs as $k => $v)
{
    $y_opt[$k] = $v;
}
?>
<div class="cr bg-white">
    <div class="card-body">
        <div class="row hidden-print">
            <div class="col-md-10">
                <h4 class="text-uppercase">Summative Report: &nbsp; &nbsp; &nbsp; <?php echo $student->cl->name ?></h4>
            </div>
            <div class="col-md-2">
             
                    <button type="button"class="btn btn-info" onclick="window.print(); return false"><i class="fa fa-print"></i> Print</button>
               
            </div>
        </div>
        <hr class="hidden-print">
        <?php echo form_open(current_url(), 'class="horizontal form-main p-10 hidden-print" '); ?>
        <div class="form-group row">
            <div class="offset-md-1 col-sm-4">
                Term: <br>
                <div>
                    <?php echo form_dropdown('term', ['' => ''] + $this->terms, $term, ' class="fsel form-control" '); ?>
                </div>
            </div>
            <div class="col-sm-4">
                Year: <br>
                <div>
                    <?php echo form_dropdown('year', ['' => ''] + $y_opt, $year, ' class="fsel form-control" '); ?>
                </div>
            </div>             
        </div>
        <div class='clearfix'></div>
        <div class="row">
            <div class="offset-md-3 col-sm-4">
                <button type="submit" class="btn btn-info" ><i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp; Submit</button>
                <?php
                if ($this->input->get('p'))
                {
                    ?>
                    <button type="button"class="btn btn-info" onclick="window.print(); return false"><i class="fa fa-print"></i> Print</button>
                <?php }?>
            </div>
        </div>
        </form>
        <hr class="hidden-print"> 
        <div class="clearfix"></div>
        <div class="page-break">
            <div class="img-container">
                 <img src="<?php echo base_url('uploads/files/'. $this->school->document); ?>" style="width:158px;" alt="header">
            </div>
            <div class="text-center">
                <h4><strong>SUMMATIVE REPORT</strong></h4>
                <h4 class="text-uppercase"><ins>NAME:</ins> <?php echo $student->first_name . ' ' . $student->last_name; ?>  &nbsp;&nbsp;&nbsp;<ins>ADM.</ins> &nbsp;&nbsp;&nbsp; <?php echo $student->admission_number; ?> &nbsp;&nbsp;&nbsp; <ins>Age:</ins> <?php echo $student->age; ?></h4>
                <p>
                    <span class="text-uppercase"><?php echo $student->cl->name ?> <?php echo $term; ?> - <?php echo $year; ?></span>
                </p>
            </div>

            <div class="clearfix"></div>
            <?php
            if (empty($assess))
            {
                ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Sorry!</strong> No result found.
                </div>
                <?php
            }
            else
            {
                ?>
                <div class="">
                    <center><img src="<?php echo base_url('/uploads/files/key.png'); ?>"></center>
                </div>
                <div>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="fbg">
                                <td>#</td>
                                <td class="text-uppercase">SUBJECT</td>
                                <td>Opener Exam </td>
                                <td> Mid Term</td>
                                <td>End of Term </td>
                                <td> Term Average</td>
                            </tr>
                            <?php
                            $k = 0;
                            foreach ($assess as $sr)
                            {
                                $s = (object) $sr;
                                $k++;
                                ?>
                                <tr>
                                    <td><?php echo $k ?>.</td>
                                    <td class="text-uppercase"><?php echo $s->subject; ?></td>
                                    <td><?php echo isset($s->exams['exam_1']) ? $s->exams['exam_1'] : ''; ?></td>
                                    <td><?php echo isset($s->exams['exam_2']) ? $s->exams['exam_2'] : ''; ?></td>
                                    <td><?php echo isset($s->exams['exam_3']) ? $s->exams['exam_3'] : ''; ?></td>
                                    <td><?php echo isset($s->exams['exam_4']) ? $s->exams['exam_4'] : ''; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <hr>                    
                    <div class="form-group fl">
                        <ins>GENERAL REMARKS ON SUMMATIVE ASSESMENT</ins><br>
                        <?php echo $summ->gen_remarks; ?>
                    </div>
                    <hr>
                    <div class="form-group fl">
                        <ins>Class teacher’s comments:</ins><br>
                        <?php echo $summ->tr_remarks; ?>
                    </div>
                    <hr>
                    <table class="table  m_0">
                        <tbody>
                            <tr>
                                <th>&nbsp;</th>
                                <td></td>
                                <td>
                                    <span class=""></span>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6"><span class="pull-right">Closing Date:</span></div>
                                        <div class="col-md-6"><?php echo $summ->closing; ?></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td></td>
                                <td>&nbsp; </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6"><span class="pull-right">Opening Date:</span></div>
                                        <div class="col-md-6"> <?php echo $summ->opening; ?></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(function ()
    {
        $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
    });
</script>
<style>
    .img-container
    {
        text-align: center;
        display: block;
    } 
    .btn-xs{margin-top: 3px;}
    .fbg{background: #f5f6fa; font-weight: bold;}
    .panel .panel-body p { line-height: 14px;}
    .p-10 {padding: 10px !important;}
    .mb-0{margin-bottom: 0;}
    .mb-2{margin-bottom: 5px;}
    .underline{text-decoration: underline;}
    .fl{margin-left:8px;}
   @media print {
        .inner-wrapper .header, .theiaStickySidebar, .hidden-print, .hidden-print * { display: none !important; }
        .page-wrapper { padding: 0px 15px 0 15px;   margin-top: 0px; }
    }
</style>