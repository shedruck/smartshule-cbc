<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header" id="pagecardheader">
        <h6 class="float-start"></h6>
        <div class="btn-group btn-group-sm float-end" role="group">
          <a class="btn btn-danger hidden-print " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
          <a class="btn btn-info hidden-print " onclick="window.print()"><i class="fa fa-print"></i>Print</a>
        </div>
      </div>
      <div class="card-body p-3 mb-2">
        <!-- <div class="row justify-content-center"> -->
        <div class="block-fluid table-responsive">
          <div class="row">
            <div class="col-xm-12 m-2">
              <div class="col-xm-4"></div>
              <div class="col-xm-4">
                <center>
                  <h4> Payslip For The Period Of <strong><?php echo $post->month . ' ' . $post->year; ?> </strong></h4>
                </center>
              </div>
              <div class="col-xm-3"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-xm-12">
              <div class="col-xm-4">
                <div class="pull-left m-t-5">
                  <?php
                  $st = $this->ion_auth->get_user($post->employee);
                  ?>
                  <address>
                    <strong>Employee:</strong><br>
                    <?php echo $st->first_name . ' ' . $st->last_name; ?><br>
                    <?php echo $st->phone; ?><br>
                    <?php echo $st->email; ?>
                  </address>
                </div>
              </div>
              <div class="col-xm-4">

              </div>
              <div class="col-xm-3">
                <div class="col-xm-12">
                  <div class="pull-right m-t-5">
                    <span><?php echo $this->school->school; ?></span><br>
                    <span>P.O Box <?php echo $this->school->postal_addr; ?></span><br>
                    <span>Tel. <?php echo $this->school->cell; ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <table class="table top-align">
              <tr>
                <th>
                  <h5 class="text-uppercase"><b>EARNINGS (<?php echo $this->currency; ?>)</b></h5>
                </th>
                <th>
                  <h5 class="text-uppercase"><b>DEDUCTIONS(<?php echo $this->currency; ?>)</b></h5>
                </th>
                <th></th>
              </tr>
              <tr>
                <td>
                  <div class="col-xm-12">
                    <div class="row">
                      <div class="col-xm-6">
                        Basic Salary: <?php echo number_format($post->basic_salary, 2); ?>
                      </div>
                      <div class="col-xm-6">
                        <?php if (!empty($post->allowances)) : ?>
                          <?php
                          $alsum = 0;
                          $all = explode(',', $post->allowances);
                          foreach ($all as $l) :
                            $vals = explode(':', $l);
                            $alsum += $vals[1];
                          ?>
                            <div>
                              <?php echo $vals[0]; ?> Allowance: <?php echo number_format($vals[1], 2); ?>
                            </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>

                </td>
                <td>
                  <div class="col-xm-12">
                    Taxable Pay: <?php echo number_format(($post->basic_salary + $alsum) - $post->nssf, 2); ?>
                  </div>
                  <?php if (!empty($post->advance)) : ?>
                    <div class="col-xm-12">
                      Advance Salary: <?php echo number_format($post->advance, 2); ?>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($post->nhif)) : ?>
                    <div class="col-xm-12">
                      NHIF: <?php echo number_format($post->nhif, 2); ?>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($post->nssf)) : ?>
                    <div class="col-xm-12">
                      NSSF:<?php echo number_format($post->nssf, 2); ?>
                    </div>
                  <?php endif; ?>
                  <?php
                  if (isset($post->staff_deduction) && !empty($post->staff_deduction)) {
                  ?>
                    <div class="col-xm-12">
                      Staff Deduction: <?php echo number_format($post->staff_deduction, 2); ?>
                    </div>
                  <?php } ?>
                  <?php if (!empty($post->deductions)) : ?>
                    <?php
                    $dec = explode(',', $post->deductions);
                    foreach ($dec as $d) :
                      $vals = explode(':', $d);
                    ?>
                      <div class="col-xm-12">
                        <?php echo $vals[0]; ?>: <?php echo number_format($vals[1], 2); ?>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="right">
                    <table id="grid-example1" class="" border="0">
                      <tr style="border-bottom: 1px solid #edebeb;">
                        <th>From</th>
                        <th>To</th>
                        <th>Taxable Pay</th>
                        <th>Tax Rate</th>
                        <th>Tax Amt.</th>
                      </tr>
                      <?php
                      $relief = $this->school->relief;
                      $e = 0;
                      $poc_amt = 0;
                      $wtx = 0;
                      $taxable = ($post->basic_salary + $alsum) - $post->nssf;
                      foreach ($ranges as $R) {
                        $e++;
                        $amt = $e == 1 ? $R->amount : $taxable - $poc_amt;
                        if ($e == 1 && $taxable < $R->amount) {
                          $amt = $taxable;
                        }
                        if ($amt < 0) {
                          $amt = 0;
                        }
                        if ($amt >= $R->amount) {
                          $amt = $R->amount;
                        }
                        if ($e == count($ranges)) {
                          $amt = $taxable - $poc_amt;
                        }
                        $rtax = $amt * ($R->tax / 100);
                        $poc_amt += $amt;
                        $wtx += $rtax;
                      ?>
                        <tr>
                          <td><?php echo number_format($R->range_from); ?></td>
                          <td class="text-right"><?php echo $e == count($ranges) ? '- ' : number_format($R->range_to); ?></td>
                          <td class="text-right"><?php echo number_format($amt); ?></td>
                          <td class="text-right"><?php echo number_format($R->tax); ?>%</td>
                          <td class="text-right"><?php echo number_format($rtax, 1); ?></td>
                        </tr>
                      <?php } ?>
                      <tr>
                        <td colspan="2"></td>
                        <td colspan="2">PAYE before Relief</td>
                        <td class="text-right"><?php echo number_format($wtx, 2); ?></td>
                      </tr>
                      <tr>
                        <td colspan="2"></td>
                        <td colspan="2">Personal Relief</td>
                        <td class="text-right"><?php echo number_format($relief, 2); ?></td>
                      </tr>
                      <tr>
                        <td colspan="2"></td>
                        <td colspan="2">PAYE Due</td>
                        <td class="text-right bold"><?php echo $wtx > $relief ? number_format($wtx - $relief, 2) : 0; ?></td>
                      </tr>
                    </table>
                    <div class="clearfix"></div>
                  </div>
                </td>
              </tr>
              <t>
                <td>
                  <div class="item">
                    <b>Total Earnings</b>
                    <div class="right">
                      <?php
                      $t_earnings = ($post->basic_salary + $post->total_allowance);
                      echo number_format($t_earnings, 2);
                      ?>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="item">
                    <b>Total Deductions</b>
                    <div class="right"> <?php
                                        $minn = $wtx > $relief ? $wtx - $relief : 0;
                                        $t_deductions = ($post->advance + $minn + $post->total_deductions + $post->nhif + $post->nssf + $post->staff_deduction);
                                        echo number_format($t_deductions, 2);
                                        ?></div>
                  </div>
                </td>
                <?php
                $net = ($t_earnings - $t_deductions);
                $words = convert_number_to_words($net);
                  ?>
                <td>
                  <div class="float-right">
                    <b>Net Pay</b>
                    <div class="right"><?php echo $this->currency; ?> <?php echo number_format($net, 2); ?></div>
                  </div>
                </td>
                </tr>
            </table>
          </div>
        </div>
        <!-- </div> -->
      </div>
      <div class="card-footer">
        <div class="form-check d-inline-block">

        </div>
        <div class="float-end d-inline-block btn-list">

        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }

  .top-align td {
    vertical-align: top;
  }

  .float-right {
    position: relative;
  }

  .float-right b {
    position: absolute;
    top: 0;
    right: 0;
  }

  .float-right .right {
    position: absolute;
    top: 20px;
    /* Adjust this value to set the vertical distance */
    right: 0;
    border-bottom: 1px solid black;
    /* Add a bottom border */
  }
</style>