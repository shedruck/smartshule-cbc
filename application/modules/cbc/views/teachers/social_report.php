<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><b>SOCIAL BEHAVIOR REPORT</b></h6>
        <div>
          <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>

        </div>
      </div>


      <div class="card-body">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'form');
        echo form_open(current_url());
        ?>
        <div class="row">
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Student <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $options = array('' => 'Select student') + $students;
                $attributes = 'class="form-control js-example-basic-single" id="student" onchange="checkFields()"';
                echo form_dropdown('student', $options, '', $attributes);
                ?>
                <?php echo form_error('student'); ?>

              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Term <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $option = array('1' => 'Term 1', '2' => 'Term 2', '3' => 'Term 3');
                $attributes = 'class="form-control" id="term" onchange="checkFields()"';
                echo form_dropdown('term', $option, '', $attributes);
                ?>
                <?php echo form_error('term'); ?>
              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Year <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $years = range(2022, date('Y'));
                $years = array_combine($years, $years);
                $attributes = 'class="form-control" id="years"'; // Adding the id attribute
                echo form_dropdown('year', $years, '', $attributes);
                ?>
                <?php echo form_error('year'); ?>
              </div>

            </div>
          </div>
        </div>

        <div class="row">
          <!-- Second Row -->
          <div class="col-xl-12">
            <div class="row m-2 justify-content-end">

              <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-1 d-inline-flex" id="submitButton" onclick="toggleDiv(event)" disabled>
                  <?php echo ($updType == 'edit') ? 'Update' : '<i class="fe fe-check-square me-1 lh-base"></i> Add '; ?>

                </button>

              </div>
            </div>
          </div>
        </div>
        <?php echo form_close() ?>
      </div>

    </div>
  </div>
</div>
<!-- // Display the grouped results -->


<!-- second card -->
<?php if ($status == 1) { ?>

  <?php
  $attributes = array('class' => 'form-horizontal', 'id' => 'form');
  echo form_open(base_url('cbc/trs/save_social/' . $cls . '/' . $studentid . '/' . $t . '/' . $y));
  ?>

  <div class="row" id="newDiv">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">

        <?php  
        $stud = $this->worker->get_student($studentid);
        ?>

          <h6 class="mb-0 text-uppercase" id="studentDataContainer"> <b>SOCIAL BEHAVIOR REPORT <span class="text-secondary"> <?php echo ' - '.$stud->first_name.' '. $stud->last_name ?></span> TERM <?php echo $t.' - '.$y ?> </b></h6>

        </div>
        <div class="card-body p-0">
          <div class="d-lg-flex d-block">
            <div class="p-4 border-end w-100">
              <div class="table-responsive push">
                <table class="table table-bordered text-nowrap">
                  <tbody>
                    <tr class="bg-primary">
                      <th class="text-center tx-fixed-white">PERSONAL SKILLS</th>
                      <th class="text-center tx-fixed-white">EXCEPTIONAL</th>
                      <th class="text-center tx-fixed-white">VERY GOOD</th>
                      <th class="text-center tx-fixed-white">SATISFACTORY</th>
                      <th class="text-center tx-fixed-white">NEEDS IMPROVEMENT</th>
                    </tr>
                    <tr>
                      <td>Consideration for Others</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="cons" <?php echo (isset($rec->cons) && $rec->cons == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="cons" <?php echo (isset($rec->cons) && $rec->cons == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="cons" <?php echo (isset($rec->cons) && $rec->cons == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="cons" <?php echo (isset($rec->cons) && $rec->cons == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Organization</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="org" <?php echo (isset($rec->org) && $rec->org == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="org" <?php echo (isset($rec->org) && $rec->org == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="org" <?php echo (isset($rec->org) && $rec->org == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="org" <?php echo (isset($rec->org) && $rec->org == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Communication</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="comm" <?php echo (isset($rec->comm) && $rec->comm == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="comm" <?php echo (isset($rec->comm) && $rec->comm == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="comm" <?php echo (isset($rec->comm) && $rec->comm == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="comm" <?php echo (isset($rec->comm) && $rec->comm == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Respect for School Property</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="property" <?php echo (isset($rec->property) && $rec->property == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="property" <?php echo (isset($rec->property) && $rec->property == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="property" <?php echo (isset($rec->property) && $rec->property == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="property" <?php echo (isset($rec->property) && $rec->property == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Cooperation</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="coop" <?php echo (isset($rec->coop) && $rec->coop == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="coop" <?php echo (isset($rec->coop) && $rec->coop == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="coop" <?php echo (isset($rec->coop) && $rec->coop == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="coop" <?php echo (isset($rec->coop) && $rec->coop == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Self Confidence</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="conf" <?php echo (isset($rec->conf) && $rec->conf == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="conf" <?php echo (isset($rec->conf) && $rec->conf == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="conf" <?php echo (isset($rec->conf) && $rec->conf == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="conf" <?php echo (isset($rec->conf) && $rec->conf == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Accepts responsibility</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="accept" <?php echo (isset($rec->accept) && $rec->accept == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="accept" <?php echo (isset($rec->accept) && $rec->accept == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="accept" <?php echo (isset($rec->accept) && $rec->accept == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="accept" <?php echo (isset($rec->accept) && $rec->accept == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Self Motivation</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="motivation" <?php echo (isset($rec->motivation) && $rec->motivation == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="motivation" <?php echo (isset($rec->motivation) && $rec->motivation == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="motivation" <?php echo (isset($rec->motivation) && $rec->motivation == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="motivation" <?php echo (isset($rec->motivation) && $rec->motivation == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>

              <div class="table-responsive push">
                <table class="table table-bordered text-nowrap">
                  <tbody>
                    <tr class="bg-primary">
                      <th class="text-center tx-fixed-white">WORK HABITS</th>
                      <th class="text-center tx-fixed-white">EXCEPTIONAL</th>
                      <th class="text-center tx-fixed-white">VERY GOOD</th>
                      <th class="text-center tx-fixed-white">SATISFACTORY</th>
                      <th class="text-center tx-fixed-white">NEEDS IMPROVEMENT</th>
                    </tr>
                    <tr>
                      <td>Works independently</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="ind" <?php echo (isset($rec->ind) && $rec->ind == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="ind" <?php echo (isset($rec->ind) && $rec->ind == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="ind" <?php echo (isset($rec->ind) && $rec->ind == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="ind" <?php echo (isset($rec->ind) && $rec->ind == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Completes assignments at school</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="school" <?php echo (isset($rec->school) && $rec->school == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="school" <?php echo (isset($rec->school) && $rec->school == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="school" <?php echo (isset($rec->school) && $rec->school == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="school" <?php echo (isset($rec->school) && $rec->school == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Completes homework</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="home" <?php echo (isset($rec->home) && $rec->home == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="home" <?php echo (isset($rec->home) && $rec->home == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="home" <?php echo (isset($rec->home) && $rec->home == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="home" <?php echo (isset($rec->home) && $rec->home == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Contribution in Group Work</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="groupw" <?php echo (isset($rec->groupw) && $rec->groupw == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="groupw" <?php echo (isset($rec->groupw) && $rec->groupw == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="groupw" <?php echo (isset($rec->groupw) && $rec->groupw == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="groupw" <?php echo (isset($rec->groupw) && $rec->groupw == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Uses Time Wisely</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="time_" <?php echo (isset($rec->time_) && $rec->time_ == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="time_" <?php echo (isset($rec->time_) && $rec->time_ == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="time_" <?php echo (isset($rec->time_) && $rec->time_ == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="time_" <?php echo (isset($rec->time_) && $rec->time_ == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Class Concentration</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="conce" <?php echo (isset($rec->conce) && $rec->conce == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="conce" <?php echo (isset($rec->conce) && $rec->conce == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="conce" <?php echo (isset($rec->conce) && $rec->conce == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="conce" <?php echo (isset($rec->conce) && $rec->conce == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Punctuality</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="punctual" <?php echo (isset($rec->punctual) && $rec->punctual == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="punctual" <?php echo (isset($rec->punctual) && $rec->punctual == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="punctual" <?php echo (isset($rec->punctual) && $rec->punctual == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="punctual" <?php echo (isset($rec->punctual) && $rec->punctual == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>


                  </tbody>
                </table>
              </div>
              <div class="table-responsive push">
                <table class="table table-bordered text-nowrap">
                  <tbody>
                    <tr class="bg-primary">
                      <th class="text-center tx-fixed-white">ENGLISH READING PROGRESS</th>
                      <th class="text-center tx-fixed-white">EXCEPTIONAL</th>
                      <th class="text-center tx-fixed-white">VERY GOOD</th>
                      <th class="text-center tx-fixed-white">SATISFACTORY</th>
                      <th class="text-center tx-fixed-white">NEEDS IMPROVEMENT</th>
                    </tr>
                    <tr>
                      <td>Read Fluently</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="fluent" <?php echo (isset($rec->fluent) && $rec->fluent == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="fluent" <?php echo (isset($rec->fluent) && $rec->fluent == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="fluent" <?php echo (isset($rec->fluent) && $rec->fluent == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="fluent" <?php echo (isset($rec->fluent) && $rec->fluent == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Speed</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="speed" <?php echo (isset($rec->speed) && $rec->speed == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="speed" <?php echo (isset($rec->speed) && $rec->speed == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="speed" <?php echo (isset($rec->speed) && $rec->speed == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="speed" <?php echo (isset($rec->speed) && $rec->speed == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Can Comprehend</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="compr" <?php echo (isset($rec->compr) && $rec->compr == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="compr" <?php echo (isset($rec->compr) && $rec->compr == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="compr" <?php echo (isset($rec->compr) && $rec->compr == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="compr" <?php echo (isset($rec->compr) && $rec->compr == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Extensive Reading</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="exte" <?php echo (isset($rec->exte) && $rec->exte == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="exte" <?php echo (isset($rec->exte) && $rec->exte == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="exte" <?php echo (isset($rec->exte) && $rec->exte == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="exte" <?php echo (isset($rec->exte) && $rec->exte == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Use of Tone Variation</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="tone" <?php echo (isset($rec->tone) && $rec->tone == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="tone" <?php echo (isset($rec->tone) && $rec->tone == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="tone" <?php echo (isset($rec->tone) && $rec->tone == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="tone" <?php echo (isset($rec->tone) && $rec->tone == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Spellings</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="spell" <?php echo (isset($rec->spell) && $rec->spell == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="spell" <?php echo (isset($rec->spell) && $rec->spell == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="spell" <?php echo (isset($rec->spell) && $rec->spell == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="spell" <?php echo (isset($rec->spell) && $rec->spell == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>


                  </tbody>
                </table>
              </div>

              <div class="table-responsive push">
                <table class="table table-bordered text-nowrap">
                  <tbody>
                    <tr class="bg-primary">
                      <th class="text-center tx-fixed-white">MAENDELEO NA MASOMO</th>
                      <th class="text-center tx-fixed-white">EXCEPTIONAL</th>
                      <th class="text-center tx-fixed-white">VERY GOOD</th>
                      <th class="text-center tx-fixed-white">SATISFACTORY</th>
                      <th class="text-center tx-fixed-white">NEEDS IMPROVEMENT</th>
                    </tr>
                    <tr>
                      <td>Kusoma kwa Mtiririko</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="mtrr" <?php echo (isset($rec->mtrr) && $rec->mtrr == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="mtrr" <?php echo (isset($rec->mtrr) && $rec->mtrr == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="mtrr" <?php echo (isset($rec->mtrr) && $rec->mtrr == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="mtrr" <?php echo (isset($rec->mtrr) && $rec->mtrr == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Kusoma kwa Kasi</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="kasi" <?php echo (isset($rec->kasi) && $rec->kasi == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="kasi" <?php echo (isset($rec->kasi) && $rec->kasi == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="kasi" <?php echo (isset($rec->kasi) && $rec->kasi == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="kasi" <?php echo (isset($rec->kasi) && $rec->kasi == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Kusoma na kuelewa</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="klw" <?php echo (isset($rec->klw) && $rec->klw == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="klw" <?php echo (isset($rec->klw) && $rec->klw == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="klw" <?php echo (isset($rec->klw) && $rec->klw == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="klw" <?php echo (isset($rec->klw) && $rec->klw == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Kusoma kwa Ziada</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="ziada" <?php echo (isset($rec->ziada) && $rec->ziada == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="ziada" <?php echo (isset($rec->ziada) && $rec->ziada == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="ziada" <?php echo (isset($rec->ziada) && $rec->ziada == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="ziada" <?php echo (isset($rec->ziada) && $rec->ziada == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Mawimbi ya Sauti</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="sauti" <?php echo (isset($rec->sauti) && $rec->sauti == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="sauti" <?php echo (isset($rec->sauti) && $rec->sauti == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="sauti" <?php echo (isset($rec->sauti) && $rec->sauti == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="sauti" <?php echo (isset($rec->sauti) && $rec->sauti == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>
                    <tr>
                      <td>Hijai</td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="A" name="hj" <?php echo (isset($rec->hj) && $rec->hj == 'A') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="B" name="hj" <?php echo (isset($rec->hj) && $rec->hj == 'B') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="C" name="hj" <?php echo (isset($rec->hj) && $rec->hj == 'C') ? 'checked' : ''; ?>>
                      </td>
                      <td style="text-align: center;">
                        <input class="form-check-input r-size" type="radio" value="D" name="hj" <?php echo (isset($rec->hj) && $rec->hj == 'D') ? 'checked' : ''; ?>>
                      </td>
                    </tr>

                  </tbody>
                </table>

                <div class="col-xl-7">
                  <label for="remarks">
                    <h6> <strong> Student's General Conduct </strong> </h6>
                  </label>
                  <textarea class="form-control" name="remarks" rows="3"><?php echo isset($rec->remarks) ? $rec->remarks : ''; ?></textarea>
                </div>
              </div>


            </div>

          </div>
        </div>
        <div class="card-footer">
          <div class="form-check d-inline-block">

          </div>
          <div class="float-end d-inline-block btn-list">
            <button type="submit" class="btn btn-info mb-1 d-inline-flex" id="auto-disappear-save" onclick="return confirm('Are you sureAre you sure you want to save the changes?')">
              <i class="fe fe-check-square me-1 lh-base"></i>
              <?php echo ($updType == 'edit') ? 'Update' : 'Save'; ?>
            </button>
            <a class="btn btn-secondary" id="cancelButton" onclick="goBack()"><i class="fe fe-arrow-left-circle me-1 lh-base"></i>Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<?php echo form_close() ?>

<!-- <script>
  function toggleDiv(event) {
    // event.preventDefault();
    var div = document.getElementById('newDiv');
    div.style.display = div.style.display === 'none' ? 'block' : 'none';
  }
</script>

 -->


<style>
  body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    padding: 20px;
  }

  .invoice-box {
    max-width: 850px;
    margin: auto;
    padding: 30px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    font-size: 16px;
    color: #555;
    background-color: #fff;
    margin-bottom: 20px;
  }

  .invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
    border-collapse: collapse;
  }

  .invoice-box table td {
    padding: 5px;
    vertical-align: top;
  }

  .invoice-box table tr td:nth-child(2) {
    text-align: right;
  }

  .invoice-box table tr.top table td {
    padding-bottom: 20px;
  }

  .invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
  }

  .invoice-box table tr.information table td {
    padding-bottom: 40px;
  }

  .invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
  }

  .invoice-box table tr.details td {
    padding-bottom: 20px;
  }

  .invoice-box table tr.item td {
    border-bottom: 1px solid #eee;
  }

  .invoice-box table tr.item.last td {
    border-bottom: none;
  }

  .invoice-box table tr.total td:nth-child(2) {
    border-top: 2px solid #eee;
    font-weight: bold;
  }

  .r-size {
    width: 20px;
    height: 20px;
  }

  @media print {
    body * {
      visibility: hidden;
    }

    .invoice-box,
    .invoice-box * {
      visibility: visible;
    }

    .invoice-box {
      position: relative;
      page-break-before: always;
    }

    /* Optional: Ensure the first invoice does not break before */
    .invoice-box:first-of-type {
      page-break-before: auto;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
    }

  }
</style>

<script>
  function printInvoice(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    window.print(); // Trigger the print dialog
  }
</script>

<script>
  function checkFields() {
    var student = document.getElementById('student').value;
    var term = document.getElementById('term').value;
    var year = document.getElementById('years').value;

    console.log(year);

    var submitButton = document.getElementById('submitButton');

    if (student === '') {
      submitButton.disabled = true;
    } else {
      submitButton.disabled = false;
    }
  }
</script>

<script>
  $(document).ready(function() {
    $('#submitButton').click(function() {
      var student = $('#student').val();
      var term = $('#term').val();
      var year = $('#years').val();

      // AJAX request
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('cbc/trs/fetch_student'); ?>",
        data: {
          student: student,
          term: term,
          year: year
        },
        dataType: "json",
        success: function(response) {
          // Assuming response is JSON object with required data
          var studentData = response.student;
          var yr = response.year;
          var trm = response.term;
          // Concatenate and update HTML content
          var updatedContent = '<b>SOCIAL BEHAVIOR REPORT - <span class="text-secondary">' + studentData + '</span> TERM ' + trm + ' - ' + yr + '</b>';
          $('#studentDataContainer').html(updatedContent);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          // Handle error
        }
      });
    });
  });
</script>