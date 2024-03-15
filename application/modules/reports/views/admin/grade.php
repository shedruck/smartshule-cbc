<?php
$map_sc = array();
$map_tt = array();
if (!empty($res))
{
        $i = 0;
        foreach ($res as $key => $xgrades)
        {
                $i++;

                $gdtotal = 0;
                $cls = 0;
                foreach ($xgrades as $gkey => $collection)
                {
                        if (!isset($points[str_replace(' ', '', $gkey)]))
                        {
                                unset($xgrades[$gkey]);
                                continue;
                        }
                        $base = $points[str_replace(' ', '', $gkey)];
                        $ct = count($collection);
                        $gdtotal += $ct * $base;
                        $cls += $ct;
                }

                $pts = round($gdtotal / $cls, 3);
                $map_sc[] = $pts;
                $map_tt[] = $key;
        }
}
$temp_1 = array_combine($map_sc, $map_tt);
rsort($map_sc);
//$temp_2 = array_flip($map_sc);

$mapped = array();
foreach ($map_sc as $index => $m)
{
        $mapped[$temp_1[(string) $m]] = $index + 1;
}
?>
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Exams Report </h2>
    <div class="right"></div>
</div>
<div class="toolbar">
    <div class="noof">
        <div class="col-md-10"><?php echo form_open(current_url()); ?>
            <?php echo form_dropdown('class', $ccc, $this->input->post('class'), 'class ="selecte" '); ?>
            <?php echo form_dropdown('exam', array('' => 'Select Exam') + $exams, $this->input->post('exam'), 'class ="select" '); ?>
            <?php
            $s1 = $rank ? '' : ' checked="checked" ';
            $s2 = '';
            $s3 = '';
            if ($rank)
            {
                    $s1 = $rank == 1 ? ' checked="checked" ' : '';
                    $s2 = $rank == 2 ? ' checked="checked" ' : '';
                    $s3 = $rank == 3 ? ' checked="checked" ' : '';
            }
            ?>    
            <br>
            <br>
            <fieldset>
                <legend>Ranking Options</legend>
                <label class="radio-inline">
                    <input type="radio" name="rank" id="r1" value="1" <?php echo $s1; ?>>
                    All Subjects
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rank" id="r2" value="2" data-html="true" <?php echo $s2; ?>>
                    Best 7 - Option 1
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rank" id="r3" value="3" data-html="true" <?php echo $s3; ?>>
                    Best 7  - Option 2
                </label>
            </fieldset><br>
            <button class="btn btn-primary"  type="submit">View Results</button>
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-2"><div class="date  right" id="menus"> </div>
            <a href="" onClick="window.print(); return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
    </div>
</div>
<div class="block invoice">
    <?php
    if (!empty($res))
    {
            ?> <span class="left center titles">   
            <?php echo $this->school->school; ?>
                Grade Analysis Report  </span>
            <br/><br/>
            <?php
            if ($ex)
            {
                    echo $ex->title . ' - Term ' . $ex->term . ' ' . $ex->year;
            }
            echo isset($ccc[$class]) ? '  - ' . $ccc[$class] : '';
            ?><hr>
            <table cellpadding="0" cellspacing="0" width="100%" class="resot stt">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SUBJECT</th>
                        <?php
                        foreach ($titles as $t)
                        {
                                if (!isset($points[$t]))
                                {
                                        unset($titles[$t]);
                                        continue;
                                }
                                ?>
                                <th class="rttb"><?php echo $t; ?></th>           
                        <?php } ?>
                        <th>M/S</th>
                        <th>M/G</th>
                        <th>Pos.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($res as $key => $xgrades)
                    {
                            $i++;
                            ?>
                            <tr class="rtrep">
                                <td width="4%"><?php echo $i; ?>.</td>
                                <td><?php echo $key; ?></td>
                                <?php
                                $gdtotal = 0;
                                $cls = 0;
                                foreach ($xgrades as $gkey => $collection)
                                {
                                        if (!isset($points[str_replace(' ', '', $gkey)]))
                                        {
                                                unset($xgrades[$gkey]);
                                                continue;
                                        }
                                        $base = $points[str_replace(' ', '', $gkey)];
                                        $ct = count($collection);
                                        $gdtotal += $ct * $base;
                                        $cls += $ct;
                                        ?>
                                        <td class="rttb"><?php echo $ct; ?></td>                
                                        <?php
                                }
                                $mnpt = round($gdtotal / $cls);
                                $mn_grade = isset(array_flip($points)[$mnpt]) ? array_flip($points)[$mnpt] : '';
                                ?>
                                <td class="rttb"><?php echo number_format(round($gdtotal / $cls, 3), 3); ?></td>              
                                <td class="rttc"><?php echo $mn_grade; ?></td>                
                                <td class="rttc"><?php echo $mapped[$key]; ?></td>
                            </tr>
                    <?php } ?>
                    <tr class="rttbx">
                        <td class="rttb" colspan="3"> </td>                       
                        <td class="rttb">&nbsp; </td>
                        <td class="rttb">&nbsp; </td>
                        <td class="rttb" colspan="<?php echo count($titles); ?>"></td>                
                    </tr>
                </tbody>
            </table>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <table cellpadding="0" cellspacing="0" width="100%" class="table-hover">
                <thead>
                    <tr>
                        <th> </th>
                        <th colspan="<?php echo count($summary); ?>"> Class Mean : <?php
                            $mean = $ipoints / $size;
                            echo number_format(round($mean, 2), 2);
                            ?>
                            ( <?php
                            $mxgd = $this->ion_auth->remarks($grading, $mean);
                            $ms_grade = isset($mxgd->grade) && isset($titles[$mxgd->grade]) ? $titles[$mxgd->grade] : '';
                            echo $ms_grade;
                            ?> )
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Students </td>   
                        <?php
                        foreach ($summary as $ttl => $count)
                        {
                                ?>
                                <td>  <?php echo $ttl; ?> </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td><?php echo $size; ?> </td>                         
                        <?php
                        foreach ($summary as $tl => $xcount)
                        {
                                ?>
                                <td>  <?php echo $xcount; ?> </td>
                        <?php } ?>                        
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-9"></div> 
                <div class="col-md-3"><small><?php echo 'Report Generated at:' . date('d M Y H:i:s'); ?></small></div>
            </div>
    <?php } ?>
</div>
<script>
        $(document).ready(function ()
        {
            $(".selecte").select2({'placeholder': 'Select Option', 'width': '200px'});

            $('[id^="radio_2"]').popover({
                placement: "top",
                title: "Board & Occupancy",
                content: "Please choose a board & occupancy for this venue"
        });
        });
</script>
<style>
    .fless{width:100%; border:0;}
    .dropped
    {
        border-bottom: 3px solid silver;
    }
    legend
    {
        width: auto;
        padding: 4px;
        margin-bottom: 0;
        border: 0;
        font-size: 11px;
    }
    fieldset
    {
        padding: 5px;
        border: 1px solid silver;
        border-radius: 7px;
    }
    @media print
    {
        td.nob{ border:none !important; background-color:#fff !important;}
        .stt td, th {border: 1px solid #ccc; }
    }
</style>