<?php

function filter_pos($array)
{
        return array_filter($array, function ($num)
        {
                return $num > 0;
        });
}
?>
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Fee Status Report</h2> 
    <div class="right">                       
    </div>    					
</div>
<div class="toolbar">
    <div class="noof">
        <div class="col-md-2">&nbsp;</div>
        <div class="col-md-7"><?php echo form_open(current_url()); ?>
            <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
            <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>
            <button class="btn btn-primary"  type="submit">View Report</button>
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-2"><div class="date  right" id="menus">
            </div>
            <a href="" onClick="window.print();
                        return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
        </div>
    </div>
</div>
<div class="block invoice">
    <?php
    $tyr = '';
    $term = '';
    if ($this->input->post('term'))
    {
            $term = $this->input->post('term');
    }
    $tm = $term == '' ? '' : 'Term ' . $term;
    if ($this->input->post('year'))
    {
            $tyr = $this->input->post('year');
    }
    ?>
    <div  class="hding">Fee Payment Summary Report  <?php echo $tm . ' ' . $tyr; ?></div>
    <?php
    $i = 0;

    $ibal = 0;
    krsort($payload);
    foreach ($payload as $yir => $tams)
    {
            ?><br>
            <div class="meter"><span class="highlight"><strong>Year: <span><?php echo $yir; ?></span>  </strong></span></div>
            <?php
            foreach ($tams as $trm => $groups)
            {
                    ksort($groups);
                    ?>
                    <br> 
                    <table class="nob" width="100%"> 
                        <tbody>
                            <tr>
                                <td width="59%" style="border:0 !important;"><b>Term <?php echo $trm; ?></b></td> 
                                <td width="41%" style="border:0 !important;" class="rttx">
                                </td>
                            </tr> 
                        </tbody>
                    </table>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th width="15%">Class</th>
                                <th width="15%">Invoiced Amt</th>
                                <th width="15%">Waivers</th>
                                <th width="15%">Received</th>
                                <th width="15%">Overall Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tm_inv = 0;
                            $tm_wv = 0;
                            $tm_pd = 0;
                            foreach ($groups as $class_group => $str_parts)
                            {
                                    foreach ($str_parts as $stream => $parts)
                                    {
                                            $pt = (object) $parts;
                                            $cl = isset($classes[$class_group]) ? $classes[$class_group] : $class_group . ' - ' . $class_group;
                                            $scl = isset($classes[$class_group]) ? class_to_short($cl) : $cl . ' - ' . $class_group;
                                            $strr = isset($streams[$stream]) ? $streams[$stream] : ' - ' . $stream;
                                            $i++;
                                            $paid = (isset($pt->credit) && is_array($pt->credit)) ? array_sum($pt->credit) : 0;
                                            $inv = (isset($pt->debit) && is_array($pt->debit)) ? array_sum($pt->debit) : 0;

                                            $bcg = (isset($pt->extra_c) && is_array($pt->extra_c)) ? array_sum($pt->extra_c) : 0;
                                            $bw = (isset($pt->extra_w) && is_array($pt->extra_w)) ? array_sum($pt->extra_w) : 0;

                                            $wiv = (isset($pt->waivers) && is_array($pt->waivers)) ? array_sum($pt->waivers) : 0;
                                            $dbal = (isset($pt->bal) && is_array($pt->bal)) ? array_sum(filter_pos($pt->bal)) : 0;

                                            $tm_inv += ($inv + $bcg);
                                            $tm_wv += ($wiv + $bw);
                                            $tm_pd += $paid;

                                            $ibal += $dbal;
                                            ?>
                                            <tr>
                                                <td><?php echo $i . '. '; ?></td>
                                                <td> <?php echo $scl . ' ' . $strr; ?></td>
                                                <td class="rttb"><?php echo number_format($inv + $bcg, 2); ?></td>
                                                <td class="rttb"><?php echo number_format($wiv + $bw, 2); ?></td>
                                                <td class="rttb"><?php echo number_format($paid, 2); ?></td>
                                                <td class="rttb"> <?php echo number_format($dbal, 2); ?></td>
                                            </tr>
                                            <?php
                                    }
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td>Totals</td>
                                <td class="rttbd"><?php echo number_format($tm_inv, 2); ?></td>
                                <td class="rttbd"><?php echo number_format($tm_wv, 2); ?></td>
                                <td class="rttbd"><?php echo number_format($tm_pd, 2); ?></td>
                                <td class="rttbd"><?php echo number_format($ibal, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    $ibal = 0;
                    $i = 0;
            }
    }
    ?>
    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-9"> <br/><small>Report Generated at : <?php echo date('jS M Y H:i:s'); ?></small> </div>
    </div>
</div>
<script type = "text/javascript">
        $(document).ready(function ()
        {
            $(".fsel").select2({'placeholder': 'Please Select', 'width': '170px'});
            $(".fsel").on("change", function (e)
            {
                notify('Select', 'Value changed: ' + e.val);
            });
        });
</script>
<style>
    .meter{margin: 5px;}
    @media print
    {
        .sbh{ display: none;}
        a {color: #000;}

        h3{border: none;}
    }
    .hding
    {
        width: 100%;
        margin: 15px auto;
        font-size: 20px; 
        text-shadow: 1px 1px 0px #FFF;
        color: #42536d;
        border-bottom: 1px solid #DDD; 
    }
</style>