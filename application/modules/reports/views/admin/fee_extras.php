<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Fee Extras Report</h2> 
    <div class="right">
    </div>
</div>

<div class="toolbar">
    <div class="col-md-10"><br/>
        <?php echo form_open(current_url()); ?>
        Fee
        <?php echo form_dropdown('fee[]', $list, $this->input->post('fee'), 'class ="tsel " multiple'); ?>
        Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $this->streams, $this->input->post('class'), 'class ="tsel" '); ?>
        Term
        <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
        Year 
        <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>
        <br/>
        <div class="cklist">
            <div class="checker"><span><input type="checkbox" name="show" value="1" <?php echo $this->input->post('show') ? 'checked' : ''; ?>></span></div>
            Show Payments
            <div class="checker"><span><input type="checkbox" name="bals" value="1" <?php echo $this->input->post('bals') ? 'checked' : ''; ?> /></span></div>
            Show Only Unpaid
        </div>
    </div>
    <div class="col-md-2"><br/>
        <button class="btn btn-primary"  type="submit">View Report</button>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="block invoice">
    <h1> </h1>
    <div class="row">
        <div class="col-md-10">
            <?php
            $fstr = '';

            if ($class == '' || !$class)
            {
                    $clstr = ' For All Classes ';
            }
            elseif (isset($this->classes[$class]))
            {
                    $clstr = ' For ' . $this->classes[$class];
            }
            else
            {
                    $clstr = '';
            }

            if ($term == '' || !$term)
            {
                    $tstr = ' ';
            }
            elseif (isset($this->terms[$term]))
            {
                    $tstr = '  ' . $this->terms[$term];
            }
            else
            {
                    $tstr = '';
            }
            $ystr = '';
            if ($yr)
            {
                    $ystr = $yr;
            }
            ?>
            <h3>Fee Extras   Report <?php echo $clstr . ' ' . $tstr . ' ' . $ystr; ?></h3>
        </div>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="20%">Name</th>
                <th width="20%">Title</th>
                <th width="20%">Amount</th>
                <?php
                if ($show)
                {
                        ?>
                        <th width="8%">Payments</th>
                <?php } ?>
                <th width="8%">Fee Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $fsum = 0;
            $tsum = 0;
            $pdsum = 0;
            foreach ($roster as $kl => $specs)
            {
                    $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
                    ?>
                    <tr>
                        <td> </td>
                        <td colspan="5" ><strong><?php echo $cname; ?>  </strong></td>
                    </tr>
                    <?php
                    foreach ($specs as $ky => $det)
                    {
                            $s = (object) $det;
                            $has = FALSE;
                            if ((isset($paid[$s->student])) && (isset($paid[$s->student][$s->fee])))
                            {
                                    $has = TRUE;
                                    $pays = $paid[$s->student][$s->fee];
                                    $paid_amt = array_sum($pays);
                                    if ($paid_amt > 0)
                                    {
                                            if ($bals)
                                            {
                                                    continue;
                                            }
                                    }
                            }
                            $i++;
                            $fsum += $s->amount;
                            $stu = $this->worker->get_student($s->student);
                            $fee = $this->worker->fetch_balance($s->student);
                            ?>
                            <tr>
                                <td><?php echo $i . '. '; ?></td>
                                <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?> </td>
                                <td><?php echo isset($list[$s->fee]) ? $list[$s->fee] : '-'; ?></td>
                                <td class="rttx"><?php echo number_format($s->amount, 2); ?></td>
                                <?php
                                if ($show)
                                {
                                        if ((isset($paid[$s->student])) && (isset($paid[$s->student][$s->fee])))
                                        {
                                                $pays = $paid[$s->student][$s->fee];
                                                $pdsum += array_sum($pays);
                                                ?>
                                                <td>  
                                                    <ul class="sList">
                                                        <li> <?php echo number_format(array_sum($pays), 2); ?> </li> 
                                                    </ul>
                                                </td>
                                                <?php
                                        }
                                        else
                                        {
                                                echo "<td> - </td>";
                                        }
                                }
                                ?>
                                <td class="rttb"> <?php echo number_format($fee->balance, 2) ?></td>
                            </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3" ><span class="pull-right"> Totals:</span></td>
                        <td class="rttb"><strong><?php //echo $cname;                 ?>   <?php echo number_format($fsum, 2); ?></strong></td>
                        <td class="rttb"> <strong><?php echo number_format($pdsum, 2); ?></strong></td>
                        <?php
                        if ($show)
                        {
                                ?>
                                <td></td>
                        <?php } ?>
                    </tr>
                    <?php
                    $i = 0;
                    $tsum += $fsum;
                    $fsum = 0;
            }
            if (count($roster) > 1)
            {
                    ?>
                    <tr>
                        <td colspan="3" > </td>
                        <td>&nbsp;</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td colspan="3" > </td>
                        <td class="rttbd"><?php echo $fstr; ?> Totals: </td>
                        <td class="rttbd"><?php echo number_format($tsum, 2); ?></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>
</div>
<style>
    .cklist{padding: 12px;}
</style>
<script>
        $(document).ready(
                function ()
                {
                    $(".tsel").select2({'placeholder': 'Please Select', 'width': '220px'});
                    $(".tsel").on("change", function (e)
                    {
                        notify('Select', 'Value changed: ' + e.added.text);
                    });

                    $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                    $(".fsel").on("change", function (e)
                    {
                        notify('Select', 'Value changed: ' + e.added.text);
                    });
                });
</script>