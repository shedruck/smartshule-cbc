<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Exams Report </h2>
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
        <?php echo form_open(current_url()); ?>
        <div class="col-md-10">
            <?php echo form_dropdown('group', array("" => " Select Class Group") + $this->classes, $this->input->post('group'), 'class ="selecte" '); ?> or
            <?php echo form_dropdown('class', array("" => " Select Stream") + $ccc, $this->input->post('class'), 'class ="selecte" '); ?>
            <?php echo form_dropdown('exam', array('' => 'Select Exam') + $exams, $this->input->post('exam'), 'class ="select" '); ?>
            <?php echo form_checkbox('grade', '1', 0, 'title="Show Grades" ') ?>Grades
            <?php
            $s1 = $rank ? '' : ' checked="checked" ';
            $s2 = '';
            $s3 = '';
            if ($rank) {
                $s1 = $rank == 1 ? ' checked="checked" ' : '';
                $s2 = $rank == 2 ? ' checked="checked" ' : '';
                $s3 = $rank == 3 ? ' checked="checked" ' : '';
                $s4 = $rank == 4 ? ' checked="checked" ' : '';
            }
            ?>
            <br>
            <hr>
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
                    Best 7 - Option 2
                </label>

                <label class="radio-inline">
                    <input type="radio" name="rank" id="r4" value="4" data-html="true" <?php echo $s4; ?>>
                    Best 8
                </label>
            </fieldset>
        </div>
        <div class="col-md-2">
            <div class="date  right" id="menus"> </div>
            <button class="btn btn-primary" type="submit">View Results</button>
            <a href="" onClick="window.print(); return false" class="btn btn-warning"><i class="icos-printer"></i> Print</a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="block invoice">
    <div class="row-fluid center">
        <div class="col-sm-12">
            <span class="" style="text-align:center">
                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center" width="50" height="50" />
            </span>
            <h3>
                <span style="text-align:center !important;font-size:15px;"><?php echo strtoupper($this->school->school); ?></span>
            </h3>
            <small style="text-align:center !important;font-size:12px; line-height:2px;">
                <?php
                if (!empty($this->school->tel)) {
                    echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                } else {
                    echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                }
                ?>
            </small>
            <h3>
                <span style="text-align:center !important;font-size:13px; font-weight:700; border:double; padding:5px;">MOTTO: <?php echo strtoupper($this->school->motto); ?></span>
            </h3>
            <br>
            <small style="text-align:center !important;font-size:20px; line-height:2px; border-bottom:2px solid  #ccc;">Exams Performance Terminal Report</small>
            <br>
            <h4>
                <?php
                $c_t = '';
                if ($class) {
                    $c_t = isset($this->streams[$class]) ? $this->streams[$class] . ' - ' : ' - ';
                }
                if ($ex) {
                    echo $c_t . '  ' . $ex->title . ' - Term ' . $ex->term . ' ' . $ex->year;
                }
                ?>
            </h4>
            <br>
        </div>
    </div>
    <hr>
    <table cellpadding="0" cellspacing="0" width="100%" class="resot stt">
        <thead>
            <?php
            if (isset($res['xload']) && isset($res['max']) && $subjects) {
                $xload = $res['xload'];
                $maxw = $res['max'];

                $sorter = $rank == 1 ? 'tots' : 'total_ranked';
                aasort($xload, $sorter, TRUE);

                foreach ($xload as $kky => $dd) {
            ?><tr>
                        <th></th>
                        <td></td><?php
                                    $add = 0;
                                    foreach ($subjects as $sbj => $dtls) :
                                        $dts = (object) $dtls;
                                        $sttr = '';
                                        if (isset($dts->units)) {
                                            foreach ($dts->units as $utk => $utt) {
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
                                    <?php echo isset($dts->units) ? $dts->full : $dts->title; ?>
                                </span>
                            </th>
                        <?php
                                    endforeach;
                                    if ($show) {
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
                $i = 0;
                $fav = array();
                $ftos = array();
                $ft_mean = array();
                $spans = array();

                foreach ($xload as $kky => $dd) {
                    $i++;
                    $my_subs = 0;
            ?>
                <tr>
                    <th width="3%"><?php echo $i . '. '; ?> </th>
                    <td width="16%"><?php echo isset($adm[$kky]) ? $adm[$kky] : ' - '; ?> </td>
                    <?php
                    $rem = 0;
                    $tadd = 0;
                    $tott = 0;
                    $hs_points = 0;
                    $lastgs = 0;

                    foreach ($subjects as $ksub => $mkkd) {
                        $hap = isset($dd['mks'][$ksub]) ? $dd['mks'][$ksub] : array();
                        if (empty($hap)) {
                            $fav[$ksub][$jj] = 'n'; //mark the blanks
                            //no results put a blank
                            if (isset($mkkd['units']) && count($mkkd['units'])) {
                                foreach ($mkkd['units'] as $fkey => $ffmk) {
                                    $fav[$fkey . '000'][$jj] = 0;
                    ?>
                                    <td width="5%" class="rttk">_</td>
                            <?php
                                }
                            }
                            ?><td width="5%" style="text-align:center;">_</td>
                            <?php
                        } else {
                            $mkf = (object) $hap;

                            if ($mkf->opt == 2 && $mkf->inc) {
                                $my_subs++;
                            } else {
                                if ($mkf->opt == 0) {
                                    $my_subs++;
                                }
                            }
                            $ksp = 0;
                            $tott += $mkf->marks;
                            $c = 0;
                            if (isset($mkf->units) && count($mkf->units)) {
                                foreach ($mkf->units as $fkey => $ffmk) {
                                    $c++;
                                    $tadd++;
                                    $ksp++;
                                    $fav[$fkey . '000'][$jj] = $ffmk;
                            ?>
                                    <td width="5%" class="rttk"><?php echo $ffmk; ?></td>
                            <?php
                                    if ($c == count($mkkd['units'])) {
                                        break;
                                    }
                                }
                            }
                            $spans[$ksub] = $ksp;
                            $fav[$ksub][$jj] = $mkf->marks;

                            $rgd = $this->ion_auth->remarks($mkf->grading, $mkf->marks);
                            $hs_grade = isset($rgd->grade) && isset($grades[$rgd->grade]) ? $grades[$rgd->grade] : ' ';

                            $mk_grade = str_replace(' ', '', $hs_grade);
                            $pt = !empty($mk_grade) && isset($points[$mk_grade]) ? $points[$mk_grade] : 0;
                            if ($rank > 1) {
                                if (in_array($ksub, $dd['ranked'])) {
                                    $hs_points += $pt;
                                }
                            } else {
                                $hs_points += $pt;
                            }
                            $dr = 0;
                            if ($rank > 1 && in_array($ksub, $dd['dropped'])) {
                                $dr = 1;
                            }
                            ?>
                            <td width="5%" class="rttk <?php echo $dr ? 'dropped' : ''; ?>">
                                <?php
                                echo $mkf->marks;
                                echo $show ? $hs_grade : '';
                                ?>
                            </td>
                        <?php
                            $lastgs = $mkf->grading;
                        }
                    }
                    $mnmaks = $rank > 1 && count($dd['ranked']) ? ($dd['total_ranked'] / count($dd['ranked'])) : ($tott / $my_subs);
                    $mrgd = $this->ion_auth->remarks($lastgs, $mnmaks);
                    $ms_grade = isset($mrgd->grade) && isset($grades[$mrgd->grade]) ? $grades[$mrgd->grade] : '';
                    $mnpt = $rank > 1 && count($dd['ranked']) ? $hs_points / count($dd['ranked']) : $hs_points / count($subjects);
                    $mn_grade = isset(array_flip($points)[$mnpt]) ? array_flip($points)[$mnpt] : '';

                    if ($show) {
                        ?>
                        <td width="5%" style="text-align:center;">
                            <?php
                            $pt_row = $this->ion_auth->remarks($lastgs, $hs_points);
                            $pt_grade = isset($pt_row->grade) && isset($grades[$pt_row->grade]) ? $grades[$pt_row->grade] : '';
                            echo $hs_points; // .' '.$pt_grade;
                            ?>
                        </td>
                    <?php } ?>
                    <td class="rttb"><?php echo $rank > 1 ? $dd['total_ranked'] : $tott - $rem; ?></td>
                    <td class="rttc">
                        <?php
                        echo $mnmaks ? number_format($mnmaks, 1) . ' ' : ' ';
                        echo $show ? $ms_grade : '';
                        ?>
                    </td>
                </tr>
            <?php
                    $jj++;
                    $ft_mean[] = $mnmaks;
                    $ftos[] = isset($dd['tots']) ? $dd['tots'] - $rem : 0;
                }
            ?>
            <tr class="rttbx">
                <th>&nbsp;</th>
                <td class="rttb">Grand Total</td>
                <?php
                foreach ($fav as $avv) {
                    $tot = array_sum($avv);
                ?>
                    <td class="rttb"><?php echo $tot; ?></td>
                <?php
                }
                if ((count($dd['mks']) + $tadd) < $maxw) {
                    $dff = $maxw - (count($dd['mks']) + $tadd);
                    for ($b = 0; $b < $dff; $b++) {
                        /* ?>
                              <td width="5%"></td>
                              <?php */
                    }
                }
                if ($show) {
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
                $draww = array();
                foreach ($fav as $yk => $avv) {
                    $filtered = array_filter($avv, function ($var) {
                        return $var != 'n';
                    });
                    $draww[$yk] = $filtered;
                    $tot = array_sum($filtered);
                    $len = count($filtered);
                    $avg = 0;
                    if ($tot && $len) {
                        $avg = round($tot / $len, 1);
                    }
                ?>
                    <td class="rttb"><?php echo number_format($avg, 1); ?></td>
                <?php
                }
                $vtot = array_sum($ftos);
                $vlen = count($ftos);
                $vavg = 0;
                if ($vtot && $vlen) {
                    $vavg = round($vtot / $vlen, 1);
                }
                $ft_tot = array_sum($ft_mean);
                $ftlen = count($ft_mean);
                $vmean = 0;
                if ($ft_tot && $ftlen) {
                    $ft_mean = round($ft_tot / $ftlen, 2);
                }
                ?>
                <?php
                if ($show) {
                ?>
                    <td class="rttb"></td>
                <?php } ?>
                <td class="rttb"><?php echo $vavg; ?></td>
                <td class="rttb"><?php echo $ft_mean; ?></td>

            </tr>
            <tr class="rttbx">
                <th>&nbsp;</th>
                <td class="rttb">Subject Position</td>
                <?php
                $pos = array();
                $prev = array();
                $reff = $fav;

                foreach ($draww as $idx => $avv) {
                    if (strpos($idx, '000') == FALSE) {
                        $tot = array_sum($avv);
                        $len = count($avv);
                        $avg = 0;
                        if ($tot && $len) {
                            $avg = round($tot / $len, 1);
                            $pos[] = $avg;
                            $prev[$idx] = $avg;
                        }
                    }
                }
                rsort($pos);

                foreach ($prev as $pkey => $pv) {
                    $colsp = isset($spans[$pkey]) ? $spans[$pkey] : FALSE;
                    $offset = array_search($pv, $pos);
                ?>
                    <td class="rttbc" <?php echo $colsp ? 'colspan="' . ($colsp + 1) . '"' : ''; ?>>
                        <?php echo $offset + 1; ?></td>
                <?php } ?>

                <?php
                if ((count($dd['mks']) + $tadd) < $maxw) {
                    $dff = $maxw - (count($dd['mks']) + $tadd);
                    for ($b = 0; $b < $dff; $b++) {
                        /* ?>
                              <td width="5%"></td>
                              <?php */
                    }
                }
                ?>
                <td class="rttb"><?php //echo $vavg;                                                     
                                    ?></td>
                <?php
                if ($show) {
                ?>
                    <td class="rttb"></td>
                <?php } ?>
                <td class="rttb"> </td>
            </tr>
            <tr>
                <td colspan="100%">&nbsp;</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9">

        </div>
        <div class="col-md-3"> <small><?php echo 'Report Generated at:' . date('d M Y H:i:s'); ?></small></div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $(".selecte").select2({
            'placeholder': 'Select Option',
            'width': '200px'
        });

        $('[id^="r2"]').popover({
            placement: "top",
            title: "Best 7 - Option 1",
            content: "3 Compulsory <br> 2 Sciences <br>1 Humanity , <br>1 best from any category "
        });
        $('[id^="r3"]').popover({
            placement: "top",
            title: "Best 7 - Option 2",
            content: "4 Compulsory (including Chem.) <br>3 best subjects from all others"
        });

        $('[id^="r4"]').popover({
            placement: "top",
            title: "Best 8",
            content: "7 Compulsory <br>1 best subject from 2 optional subjects"
        });
    });
</script>
<style>
    .fless {
        width: 100%;
        border: 0;
    }

    .dropped {
        border-bottom: 3px solid silver;
    }

    legend {
        width: auto;
        padding: 4px;
        margin-bottom: 0;
        border: 0;
        font-size: 11px;
    }

    fieldset {
        padding: 5px;
        border: 1px solid silver;
        border-radius: 7px;
    }

    @media print {
        td.nob {
            border: none !important;
            background-color: #fff !important;
        }

        .stt td,
        th {
            border: 1px solid #ccc;
        }

        .dropped {
            border-bottom: 3px solid silver !important;
        }
    }
</style>