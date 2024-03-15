<div class="head">
    <div class="icon"></div>
    <h2>Class Average Report</h2>
    <div class="right"></div>    					
</div>
<?php
$sslist = [];
foreach ($this->classlist as $ssid => $s)
{
    $sslist[$ssid] = $s['name'];
}
?>
<div class="toolbar">
    <div class="row row-fluid">
        <div class="col-md-12">
            <?php echo form_open(current_url()); ?>
            Class
            <?php echo form_dropdown('class', ['' => 'Select'] + $sslist, $this->input->post('class'), 'class ="tsel" '); ?>
            Exam(s) 
            <?php echo form_dropdown('exams[]', $exams, $this->input->post('exams'), 'class ="fsel" multiple placeholder="Select Exams" '); ?>
            &nbsp;&nbsp;&nbsp;<button class="btn btn-primary"  type="submit">View Report</button>
            <div class="pull-right"><br>
                <a href="" onClick="window.print(); return false" class="btn btn-warning"><i class="icos-printer"></i> Print </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php
$chart = FALSE;
$ij = 0;
if ($exams && $class)
{
?>
<div class="invoice">
    <h3 class="text-center">Class Average Report <?php echo isset($sslist[$class]) ? ' - ' . $sslist[$class] : ''; ?></h3>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th><b>Subject</b></th>
                <?php
                foreach ($list as $l)
                {
                    $pref = str_ireplace('Exams', '', $l->title);
                    $pref = str_ireplace('Exam', '', $pref);
                    $tt = trim($pref) . ' ' . $l->term . ' ' . $l->year;
                    ?>
                    <th><b><?php echo $tt; ?></b></th>
                    <?php
                }
                ?>
                <th> <span class="text-center">Average</span> </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $imx = 0;

            foreach ($sub_avgs as $sub => $spms)
            {
                $imx++;
                ?>
                <tr>
                    <td class="text-center"><?php echo $imx; ?>.</td>
                    <td><b><?php echo isset($titles[$sub]) ? $titles[$sub] : ' - '; ?></b></td>
                    <?php
                    foreach ($spms as $sid => $xmk)
                    {
                        ?>
                        <td class="text-center"><?php echo $xmk; ?></td>
                    <?php } ?>
                    <td class="text-center"> <strong><?php echo isset($class_avg[$sub]) ? $class_avg[$sub] : '-'; ?></strong></td>
                </tr>
                <?php
            }
            ?>
            <tr class="rttbx">
                <td colspan="<?php echo count($exlist) + 3; ?>"> &nbsp; </td>
            </tr>

            <tr class="rttbx">
                <td class="text-center"> </td>
                <td> <strong>Total: </strong></td>
                <?php
                foreach ($matrix as $exm => $gd)
                {
                    $mkt = array_sum($gd);
                    ?>
                    <td class="text-center"><?php echo round($mkt, 2); ?></td>  
                <?php } ?>               
                <td class="">  </td>
            </tr>
            <tr class="rttbx">
                <td class="text-center"> </td>
                <td> <strong> Average:  </strong></td>
                <?php
                foreach ($matrix as $eex => $fgd)
                {
                    $a_vg = array_sum($fgd) / count($sub_avgs);
                    ?>
                    <td class="text-center"><strong><?php echo round($a_vg, 2); ?></strong></td> 
                <?php } ?>
                <td> </td>
            </tr>

            <tr>
                <td> </td>
                <td> </td>
                <td colspan="<?php echo count($exlist); ?>"> &nbsp; </td>
                <td class="">  </td>
            </tr>
        </tbody>
    </table>

    <div class="clearfix" style="clear:both"></div>
</div>

<div class="page-break"></div>
<?php } ?>
<script>
    $(document).ready(
            function ()
            {
                $(".tsel").select2({'placeholder': 'Please Select', 'width': '200px'});
                $(".tsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.added.text);
                });
                $(".fsel").select2({'placeholder': 'Please Select', 'width': '400px'});
                $(".fsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.added.text);
                });
            });
</script>

<style>
    th{text-align: center !important;}
    .invoice{padding: 20px;}
    .page-break{margin-bottom: 15px;}

    @media print 
    {
        .invoice{padding: 20px !important;}
    }
</style>
