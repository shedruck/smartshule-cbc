<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Exams Report   </h2> 
    <div class="right">                    
    </div> 
    <div class="toolbar">
        <div class="left TAR">
            <div class="btn-group" data-toggle="buttons-radio">
                <a href="<?php echo base_url('admin/reports/sms_exam/'); ?>" class="btn btn-primary "><span class="glyphicon glyphicon-comment"></span> SMS Results</a>
                <a href="<?php echo base_url('admin/reports/grade_analysis/'); ?>" class="btn btn-warning "><span class="glyphicon glyphicon-signal"></span> Grade Analysis</a>                                
            </div>           
        </div>
    </div>
</div>
<div class="toolbar">
    <div class="noof">
        <div class="col-md-10"><?php echo form_open(current_url()); ?>
            <?php echo form_dropdown('class', $ccc, $this->input->post('class'), 'class ="selecte" '); ?>
            <?php echo form_dropdown('exam', array('' => 'Select Exam') + $exams, $this->input->post('exam'), 'class ="select" '); ?>
            <?php echo form_checkbox('grade', '1', 0, 'title="Show Grades" ') ?>Grades 
            <button class="btn btn-primary"  type="submit">View Results</button>
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-2"><div class="date  right" id="menus"> </div>
            <a href="" onClick="window.print();
                        return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
    </div>
</div>
<div class="block invoice">
    <span class="left center titles">   
        <?php echo $this->school->school; ?>
        Exams Report <?php
        if ($ex)
        {
                echo ' - ' . $ex->title . ' - Term ' . $ex->term . ' ' . $ex->year;
        }
        ?></span><hr>
    <table cellpadding="0" cellspacing="0" width="100%" class="resot stt">
        <thead>
            <?php
            $i = 1;
            if (isset($res['xload']) && isset($res['max']) && $subjects)
            {
                    $xload = $res['xload'];
                    $maxw = $res['max'];
                    foreach ($xload as $kla => $specs)
                    {
                            foreach ($specs as $str => $sp)
                            {
                                    aasort($sp, 'tots', TRUE);
                                    $cl = isset($classes[$kla]) ? $classes[$kla] : ' - ';
                                    $scl = isset($classes[$kla]) ? class_to_short($cl) : ' - ' . $kla;
                                    $strr = isset($streams[$str]) ? $streams[$str] : ' - ' . $str;
                                    ?>
                                    <tr>
                                        <th></th>
                                        <td colspan="<?php echo $maxw + 3; ?>"> <strong> <?php echo $scl . ' ' . $strr; ?></strong></td>

                                    </tr>
                                    <?php
                                    foreach ($sp as $kky => $dd)
                                    {
                                            ?><tr> <th></th><td></td><?php
                                                $add = 0;
                                                foreach ($subjects as $sbj => $dtls):
                                                        $dts = (object) $dtls;
                                                        $sttr = '';
                                                        if (isset($dts->units))
                                                        {
                                                                foreach ($dts->units as $utk => $utt)
                                                                {
                                                                        $sttr .= ' ' . $utt . ', ';
                                                                        ?>
                                                                        <th><span title=" <?php echo $utt; ?>">
                                                                                <?php echo $utt; ?>
                                                                            </span>
                                                                        </th>
                                                                        <?php
                                                                }
                                                                $sttr = rtrim($sttr, ', ');
                                                        }
                                                        ?>
                                                        <th>
                                                            <span title="<?php echo isset($dts->units) ? 'Total For :' . $sttr : $dts->title; ?>">
                                                                <?php echo isset($dts->units) ? 'TOTAL ' : $dts->title; ?>
                                                            </span>
                                                        </th>
                                                        <?php
                                                endforeach;
                                                if ($show)
                                                {
                                                        ?>  
                                                        <th class="rttb" width="5%">Points</th>
                                                <?php } ?>
                                                <th class="rttb" width="5%">Total</th>
                                                <th class="rttb" width="5%">Mean</th>
                                            </tr>
                                            <?php
                                            break;
                                    }
                                    ?>
                                </thead>
                                <tbody>
                                    <?php
                                    $jj = 0;
                                    $fav = array();
                                    $ftos = array();
                                    $spans = array();
                                    foreach ($sp as $kky => $dd)
                                    {
                                            ?>
                                            <tr>
                                                <th width="3%"><?php echo $i . '. '; ?> </th>
                                                <td width="16%"><?php echo isset($adm[$kky]) ? $adm[$kky] : ' - '; ?></td>
                                                <?php
                                                $rem = 0;
                                                $tadd = 0;
                                                $tott = 0;
                                                $hs_points = 0;
                                                $lastgs = 0;
                                                foreach ($subjects as $ksub => $mkkd)
                                                {
                                                        $hap = isset($dd['mks'][$ksub]) ? $dd['mks'][$ksub] : array();
                                                        if (empty($hap))
                                                        {
                                                                continue;
                                                        }
                                                        $mkf = (object) $hap;
                                                        $ksp = 0;
                                                        $tott += $mkf->marks;
                                                        if (isset($mkf->units) && count($mkf->units))
                                                        {
                                                                foreach ($mkf->units as $fkey => $ffmk)
                                                                {
                                                                        $tadd++;
                                                                        $ksp++;
                                                                        $fav[$fkey . '000'][$jj] = $ffmk;
                                                                        ?>
                                                                        <td width="5%" class="rttk"><?php echo $ffmk; ?></td>
                                                                        <?php
                                                                }
                                                        }
                                                        $spans[$ksub] = $ksp;
                                                        $fav[$ksub][$jj] = $mkf->marks;

                                                        $rgd = $this->ion_auth->remarks($mkf->grading, $mkf->marks);
                                                        $hs_grade = isset($rgd->grade) && isset($grades[$rgd->grade]) ? $grades[$rgd->grade] : '';

                                                        $mk_grade = str_replace(' ', '', $hs_grade);
                                                        $pt = !empty($mk_grade) && isset($points[$mk_grade]) ? $points[$mk_grade] : 0;
                                                        $hs_points += $pt;
                                                        ?>
                                                        <td width="5%" class="rttk"> <?php
                                                            echo $mkf->marks;
                                                            echo $show ? $hs_grade : '';
                                                            ?>
                                                        </td>
                                                        <?php
                                                        $lastgs = $mkf->grading;
                                                }
                                                $mnmaks = round($tott / count($subjects));
                                                $mrgd = $this->ion_auth->remarks($lastgs, $mnmaks);
                                                $ms_grade = isset($mrgd->grade) && isset($grades[$mrgd->grade]) ? $grades[$mrgd->grade] : '';
                                                $mnpt = round($hs_points / count($subjects));
                                                $mn_grade = isset(array_flip($points)[$mnpt]) ? array_flip($points)[$mnpt] : '';
                                                if ($show)
                                                {
                                                        ?>
                                                        <td width="5%" class="rttk"> <?php echo $hs_points; ?></td>
                                                <?php } ?>
                                                <td class="rttb"><?php echo $tott - $rem; ?></td>
                                                <td class="rttc">
                                                    <?php
                                                    echo $mnmaks . ' ';
                                                    echo $show ? $ms_grade : '';
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                            $jj++;
                                            $ftos[] = isset($dd['tots']) ? $dd['tots'] - $rem : 0;
                                    }
                                    $i = 1;
                                    ?>
                                    <tr class="rttbx">
                                        <th>&nbsp;</th>
                                        <td class="rttb">Grand Total</td>
                                        <?php
                                        foreach ($fav as $avv)
                                        {
                                                $tot = array_sum($avv);
                                                ?>
                                                <td class="rttb"><?php echo $tot; ?></td>
                                                <?php
                                        }
                                        if ((count($dd['mks']) + $tadd) < $maxw)
                                        {
                                                $dff = $maxw - (count($dd['mks']) + $tadd);
                                                for ($b = 0; $b < $dff; $b++)
                                                {
                                                        /* ?>
                                                          <td width="5%"></td>
                                                          <?php */
                                                }
                                        }
                                        if ($show)
                                        {
                                                ?>
                                                <td class="rttb"></td>
                                        <?php } ?>
                                        <td class="rttb"></td>
                                        <td class="rttb"></td>
                                    </tr>
                                    <tr class="rttbx">
                                        <th>&nbsp;</th>
                                        <td class="rttb">Mean Score </td>
                                        <?php
                                        foreach ($fav as $avv)
                                        {
                                                $tot = array_sum($avv);
                                                $len = count($avv);
                                                $avg = 0;
                                                if ($tot && $len)
                                                {
                                                        $avg = round($tot / $len, 1);
                                                }
                                                ?>
                                                <td class="rttb"><?php echo number_format($avg, 1); ?></td>
                                                <?php
                                        }
                                        if ((count($dd['mks']) + $tadd) < $maxw)
                                        {
                                                $dff = $maxw - (count($dd['mks']) + $tadd);
                                                for ($b = 0; $b < $dff; $b++)
                                                {
                                                        /* ?>
                                                          <td width="5%"></td>
                                                          <?php */
                                                }
                                        }
                                        $vtot = array_sum($ftos);
                                        $vlen = count($ftos);
                                        $vavg = 0;
                                        if ($vtot && $vlen)
                                        {
                                                $vavg = round($vtot / $vlen, 1);
                                        }

                                        if ($show)
                                        {
                                                ?>
                                                <td class="rttb"></td>
                                        <?php } ?>
                                        <td class="rttb"></td>
                                        <td class="rttb"> </td>
                                    </tr>
                                    <tr class="rttbx">
                                        <th>&nbsp;</th>
                                        <td class="rttb">Subject Position</td>
                                        <?php
                                        $pos = array();
                                        $prev = array();
                                        $reff = $fav;

                                        foreach ($fav as $idx => $avv)
                                        {
                                                if (strpos($idx, '000') == FALSE)
                                                {
                                                        $tot = array_sum($avv);
                                                        $len = count($avv);
                                                        $avg = 0;
                                                        if ($tot && $len)
                                                        {
                                                                $avg = round($tot / $len, 1);
                                                                $pos[] = $avg;
                                                                $prev[$idx] = $avg;
                                                        }
                                                }
                                        }
                                        rsort($pos);

                                        foreach ($prev as $pkey => $pv)
                                        {
                                                $colsp = isset($spans[$pkey]) ? $spans[$pkey] : FALSE;
                                                $offset = array_search($pv, $pos);
                                                ?>
                                                <td class="rttbc" <?php echo $colsp ? 'colspan="' . ($colsp + 1) . '"' : ''; ?>>
                                                    <?php echo $offset + 1; ?></td>
                                        <?php } ?>

                                        <?php
                                        if ((count($dd['mks']) + $tadd) < $maxw)
                                        {
                                                $dff = $maxw - (count($dd['mks']) + $tadd);
                                                for ($b = 0; $b < $dff; $b++)
                                                {
                                                        /* ?>
                                                          <td width="5%"></td>
                                                          <?php */
                                                }
                                        }
                                        ?>
                                        <td class="rttb"><?php //echo $vavg;                                                     ?></td>
                                        <?php
                                        if ($show)
                                        {
                                                ?>
                                                <td class="rttb"></td>
                                        <?php } ?>
                                        <td class="rttb"> </td>
                                    </tr>
                                    <tr> <td>&nbsp;</td> <td colspan="<?php echo $maxw + 2 + 4; ?>"> &nbsp;  </td> </tr>
                                    <?php
                            }
                            break;
                    }
            }
            ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9">

        </div> 
        <div class="col-md-3"> <small><?php echo 'Report Generated at:' . date('d M Y H:i:s'); ?></small></div>
    </div>

</div>
<script>
        $(document).ready(function ()
        {
            $(".selecte").select2({'placeholder': 'Select Option', 'width': '200px'});
        });
</script>
<style>
    .fless{width:100%; border:0;}

    @media print{
        td.nob{  border:none !important; background-color:#fff !important;}
        .stt td, th {
            border: 1px solid #ccc;
        }  
    }
</style>

