<div class="head">
    <div class="icon">
        <span class="icosg-target1"></span></div>
    <h2>Sales Ledger</h2>
    <div class="right"> </div>
</div>

<div class="block invoice">
    <div class="row hidden-print">
        <?php
        $attributes = ['class' => 'form-horizontal', 'id' => 'fm-sl'];
        echo form_open_multipart(current_url(), $attributes);
        $mode = $this->input->post('mode') ? $this->input->post('mode') : 1;
        ?>
        <div class="col-xs-3 col-md-3 twg small m-b-0 m-t-0">
            <div class="custom-control custom-radio">
                <input type="radio" id="m1" name="mode" class="custom-control-input" value="1" <?php echo $mode == 1 ? 'checked' : ''; ?>>
                <label class="custom-control-label" for="m1">Daily</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" name="mode" id="m2"class="custom-control-input" value="2" <?php echo $mode == 2 ? 'checked' : ''; ?>>
                <label class="custom-control-label" for="m2">Monthly</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" name="mode" id="m3" class="custom-control-input" value="3" <?php echo $mode == 3 ? 'checked' : ''; ?>>
                <label class="custom-control-label" for="m3">Date Range</label>
            </div>
        </div>
        <div class="col-xs-6 col-md-6">
            <div id="daily" <?php echo $mode == 1 ? 'style="display:block" ' : 'style="display:none" '; ?>>
                <div class="form-group">
                    <div class="col-md-3" for="dt">Date:</div>
                    <div class="col-md-8">
                        <?php echo form_input('date', $this->input->post('date'), ' id="dt" class="form-control datepicker col-md-4" autocomplete="off" placeholder="Date.."'); ?>
                    </div>
                </div>
            </div>
            <div id="monthly" <?php echo $mode == 2 ? 'style="display:block" ' : 'style="display:none" '; ?>>
                <div class="form-group">
                    <div class="col-md-3" for="mt">Month /Year:</div>
                    <div class="col-md-4">
                        <?php echo form_dropdown('month', ['' => ''] + $months, $this->input->post('month'), ' class="fsel" id="mt" data-placeholder="Month.." '); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo form_dropdown('year', array('' => '') + $yrs, $this->input->post('year'), 'class ="fsel"  data-placeholder="Year.." '); ?>
                    </div>
                </div>
            </div>
            <div id="range" <?php echo $mode == 3 ? 'style="display:block" ' : 'style="display:none" '; ?>>
                <div class="form-group">
                    <div class="col-md-3" for="rt">Date Range:</div>
                    <div class="col-md-4">
                        <?php echo form_input('from', $this->input->post('from'), 'class="form-control datepicker col-md-4" placeholder="Date From" autocomplete="off"'); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo form_input('to', $this->input->post('to'), 'class="form-control datepicker col-md-4" placeholder="Date To" autocomplete="off"'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-3 col-md-3 pt-10">
            <input type="submit" class="btn btn-primary" value="View"  name="view" /> &nbsp;&nbsp;&nbsp;
            <input type="submit" class="btn btn-success" value="Export Excel" name="export"/>
        </div>
        </form>
    </div>
    <hr>
    <?php
    if ($this->input->post() && empty($post))
    {
        ?>
        <div class="alert alert-warning border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
            </button> <strong>!</strong> No Records Found
        </div>
        <?php
    }
    if ($this->input->post() && !empty($post))
    {
        if ($this->input->post('mode') == 1)
        {
            ?>
            <h4> Sales Ledger Report - Date: <?php echo $this->input->post('date') ? date('d M Y', strtotime($this->input->post('date'))) : ' - '; ?></h4>
            <?php
        }
        if ($this->input->post('mode') == 2)
        {
            ?>
            <h4> Sales Ledger Report - Month: <?php
                echo $this->input->post('month') ? $months[$this->input->post('month')] : ' - ';
                echo '&nbsp;' . $year;
                ?></h4>
            <?php
        }
        if ($this->input->post('mode') == 3)
        {
            ?>
            <h4>
                Sales Ledger Report - Date Range: <?php echo $this->input->post('from') ? date('d M Y', strtotime($this->input->post('from'))) : ' - '; ?>
                - <?php echo $this->input->post('to') ? date('d M Y', strtotime($this->input->post('to'))) : ' - '; ?>
            </h4>
        <?php } ?>
        <table class="table">
            <thead>
                <tr>
                    <th width="3%">#</th>
                    <th width="18%">Name</th>
                    <th width="10%">Class</th>
                    <th width="11%">Adm. No.</th>
                    <th width="11%">Tuition Fee</th>
                    <th width="30%">Fee Extras</th>
                    <th width="13%">Totals</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $totals = 0;
                foreach ($post as $sid => $fees)
                {
                    $st = $this->worker->get_student($sid);
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i . '. '; ?></td>
                        <td><?php echo $st->first_name . ' ' . $st->middle_name. ' '.$st->last_name; ?></td>
                        <td><?php echo $st->cl->name; ?></td>
                        <td><?php echo $st->admission_number ? $st->admission_number : $st->old_adm_no; ?> </td>
                        <td>
                            <?php
                            $sum = 0;
                            foreach ($fees as $fw)
                            {
                                $sum += $fw->amount;
                                $totals += $fw->amount;
                                if ($fw->cat != 'tuition')
                                {
                                    continue;
                                }
                                echo '<p>' . number_format($fw->amount, 2) . '</p>';
                            }
                            ?>
                        </td>
                        <td>
                            <table style='border:0 !important;'>
                                <?php
                                foreach ($fees as $f)
                                {
                                    if ($f->cat != 'extras')
                                    {
                                        continue;
                                    }
                                    echo '<tr><td class="r-0">' . $f->title . ':</td><td class="r-0 rttx"> ' . number_format($f->amount, 2) . '</td></tr>';
                                }

                                foreach($fees as $t)
                                {
                                    if ($t->cat != 'transport')
                                    {
                                        continue;
                                    }
                                    echo '<tr><td class="r-0">' . $t->title . ':</td><td class="r-0 rttx"> ' . number_format($t->amount, 2) . '</td></tr>';
                                }
                                ?>
                            </table>
                        </td>
                        <td class="rttb"><?php echo number_format($sum, 2); ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="7"> </td>
                </tr>
                <tr>
                    <td colspan="5"> </td>
                    <td>
                        <span class="pull-right"> <strong>Total</strong></span>
                    </td>
                    <td class="rttbx"><?php echo number_format($totals, 2); ?></td>
                </tr>
            </tbody>
        </table>
        <?php
    }
    ?>
</div>
<script>
    $(document).ready(function ()
    {
        $('#m1').click(function () {
            document.getElementById('daily').style.display = 'block';
            document.getElementById('monthly').style.display = 'none';
            document.getElementById('range').style.display = 'none';
        });
        $('#m2').click(function () {
            document.getElementById('monthly').style.display = 'block';
            document.getElementById('daily').style.display = 'none';
            document.getElementById('range').style.display = 'none';
        });
        $('#m3').click(function () {
            document.getElementById('monthly').style.display = 'none';
            document.getElementById('daily').style.display = 'none';
            document.getElementById('range').style.display = 'block';
        });

        $(".tsel").select2({'placeholder': 'Please Select', 'width': '140px'});
        $(".tsel").on("change", function (e) {
            notify('Select', 'Value changed: ' + e.target.value);
        });

        $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
        $(".fsel").on("change", function (e) {
            notify('Select', 'Value changed: ' + e.target.value);
        });
    });
</script>

<style>
    .r-0{border-right:0 !important; }
    .form-group 
    {
        border-radius: 4px;
        border: 1px solid #dddddd75 !important;
    }
    input[type=radio], input[type=checkbox] 
    {
        margin: 1px 0 0 !important;
    }
    .pt-10
    {
        padding-top: 12px;
    }
</style>