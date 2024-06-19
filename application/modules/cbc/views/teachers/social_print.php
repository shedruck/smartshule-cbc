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
                echo $student;
                $options = array('' => 'Select student') + $students;
                $attributes = 'class="form-control js-example-basic-single" id="student" onchange="checkFields()"';
                echo form_dropdown('student', $options, $students[$student], $attributes);
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
                $attributes = 'class="form-control js-example-basic-single" id="term" onchange="checkFields()"';
                echo form_dropdown('term', $option, $term, $attributes);
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
                $attributes = 'class="form-control js-example-basic-single" id="years"'; // Adding the id attribute
                echo form_dropdown('year', $years, $year, $attributes);
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
                <button type="submit" class="btn btn-warning mb-1 d-inline-flex" id="submitButton" onclick="toggleDiv(event)" disabled>
                  <?php echo ($updType == 'edit') ? 'Update' : '<i class="fe fe-filter me-1 lh-base"></i> filter '; ?>

                </button>
                <button class="btn btn-info" onclick="printDiv('newDiv')"> <i class="bi bi-printer"></i> Print</button>
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
        <div class="card-header mt-4 ">
          <table cellpadding="0" cellspacing="0">
            <tr class="top">
              <td colspan="3">
                <table>
                  <tr>
                    <td class="title" style="width: 16%;">
                      <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" alt="header">
                    </td>
                    <td class="text-center">
                      <?php
                      $stu = $this->worker->get_student($stu);
                      $birthdateTimestamp = $stu->dob;
                      $birthDateTime = new DateTime();
                      $birthDateTime->setTimestamp($birthdateTimestamp);
                      $currentDateTime = new DateTime();
                      $ageInterval = $currentDateTime->diff($birthDateTime);

                      if ($stu->dob === "") {
                        $age = "---";
                      } else {
                        $age = $ageInterval->y;
                      }
                      $this->load->model('cbc_tr');
                      ?>
                      <h4>SOCIAL BEHAVIOR REPORT</h4>
                      <h6 class="upper_case"><b>NAME:</b> <u><?php echo htmlspecialchars($stu->first_name . ' ' . $stu->last_name) ?></u>&nbsp; <b>ADM NO:</b> <u><?php echo htmlspecialchars($stu->admission_number) ?></u>&nbsp; <b>AGE:</b> <u><?php echo htmlspecialchars($age); ?></u></h6>
                      <span class="upper_case"><?php echo strtoupper($stu->cl->name) . ", TERM " . $term . ' ' . $year ?></span><br>
                    </td>
                    <td style="width: 16%;">
                      <?php if ($passport) { ?>
                        <div class="img-container right">
                          <img src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" alt="header">
                        </div>
                      <?php } ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

        </div>
        <div class="card-body p-0">
          <?php
          // echo "<pre>";
          // print_r($rec);
          // echo "<pre>";
          ?>
          <div class="d-lg-flex d-block">
            <div class="p-4 border-end w-100">
              <div class="table-responsive push">
                <table class="table table-bordered text-nowrap">
                  <tbody>
                    <tr class="bg-primary">
                      <th class="text-center tx-fixed-white" style="width:34%">PERSONAL SKILLS</th>
                      <th class="text-center tx-fixed-white" style="width:13%">GRADE</th>
                      <th class="text-center tx-fixed-white">WORK HABITS</th>
                      <th class="text-center tx-fixed-white" style="width:13%">GRADE</th>

                    </tr>
                    <tr>
                      <td>Consideration for Others</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->cons) && $rec->cons !== '0') ? $rec->cons : '--'; ?>
                      </td>
                      <td>Works independently</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->ind) && $rec->ind !== '0') ? $rec->ind : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Organization</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->org) && $rec->org !== '0') ? $rec->org : '--'; ?>
                      </td>
                      <td>Completes assignments at school</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->school) && $rec->school !== '0') ? $rec->school : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Communication</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->comm) && $rec->comm !== '0') ? $rec->comm : '--'; ?>
                      </td>
                      <td>Completes Homework</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->home) && $rec->home !== '0') ? $rec->home : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Respect for School Property</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->property) && $rec->property !== '0') ? $rec->property : '--'; ?>
                      </td>
                      <td>Contribution in Group Work</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->groupw) && $rec->groupw !== '0') ? $rec->groupw : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Cooperation</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->coop) && $rec->coop !== '0') ? $rec->coop : '--'; ?>
                      </td>
                      <td>Uses Time Wisely</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->time_) && $rec->time_ !== '0') ? $rec->time_ : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Self Confidence</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->conf) && $rec->conf !== '0') ? $rec->conf : '--'; ?>
                      </td>
                      <td>Class Concentration</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->conce) && $rec->conce !== '0') ? $rec->conce : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Accepts responsibility</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->accept) && $rec->accept !== '0') ? $rec->accept : '--'; ?>
                      </td>
                      <td>Punctuality</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->punctual) && $rec->punctual !== '0') ? $rec->punctual : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Self Motivation</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->motivation) && $rec->motivation !== '0') ? $rec->motivation : '--'; ?>
                      </td>
                      <td style="text-align: center;"></td>
                      <td style="text-align: center;"></td>
                    </tr>


                  </tbody>
                </table>
              </div>


              <div class="table-responsive push">
                <table class="table table-bordered text-nowrap">
                  <tbody>
                    <tr class="bg-primary">
                      <th class="text-center tx-fixed-white" style="width:34%">ENGLISH READING PROGRESS</th>
                      <th class="text-center tx-fixed-white" style="width:13%">GRADE</th>
                      <th class="text-center tx-fixed-white">MAENDELEO NA MASOMO</th>
                      <th class="text-center tx-fixed-white" style="width:13%">GRADE</th>
                    </tr>
                    <tr>
                      <td>Read Fluently</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->fluent) && $rec->fluent !== '0') ? $rec->fluent : '--'; ?>
                      </td>
                      <td>Kusoma kwa Mtiririko</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->mtrr) && $rec->mtrr !== '0') ? $rec->mtrr : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Speed</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->speed) && $rec->speed !== '0') ? $rec->speed : '--'; ?>
                      </td>
                      <td>Kusoma kwa Kasi</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->kasi) && $rec->kasi !== '0') ? $rec->kasi : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Can Comprehend</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->compr) && $rec->compr !== '0') ? $rec->compr : '--'; ?>
                      </td>
                      <td>Kusoma na kuelewa</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->klw) && $rec->klw !== '0') ? $rec->klw : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Extensive Reading</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->exte) && $rec->exte !== '0') ? $rec->exte : '--'; ?>
                      </td>
                      <td>Kusoma kwa Ziada</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->ziada) && $rec->ziada !== '0') ? $rec->ziada : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Use of Tone Variation</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->tone) && $rec->tone !== '0') ? $rec->tone : '--'; ?>
                      </td>
                      <td>Mawimbi ya Sauti</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->sauti) && $rec->sauti !== '0') ? $rec->sauti : '--'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Spellings</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->spell) && $rec->spell !== '0') ? $rec->spell : '--'; ?>
                      </td>
                      <td>Hijai</td>
                      <td style="text-align: center;">
                        <?php echo (isset($rec->hj) && $rec->hj !== '0') ? $rec->hj : '--'; ?>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>

            </div>

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

  .top {
    width: 100%;
  }

  .title img {
    height: 68px;
  }

  .text-center {
    text-align: center;
    width: 68%;
  }

  .right img {
    height: 68px;
  }

  table {
    width: 100%;
  }

  td {
    vertical-align: top;
  }

  .upper_case {
    text-transform: uppercase;
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
  function printDiv(divId) {
    var divToPrint = document.getElementById(divId);
    var newWin = window.open('');
    newWin.document.write('<html><head><title>Print</title>');
    newWin.document.write('<style>');
    newWin.document.write('body { font-family: Arial, sans-serif; }');
    newWin.document.write('.top { width: 100%; }');
    newWin.document.write('.title img { height: 68px; }');
    newWin.document.write('.text-center { text-align: center; width: 68%; }');
    newWin.document.write('.right img { height: 68px; }');
    newWin.document.write('table { width: 100%; border-collapse: collapse; }');
    newWin.document.write('td { vertical-align: top; }');
    newWin.document.write('.upper_case { text-transform: uppercase; }');
    newWin.document.write('.bg-primary { background-color: #007bff; color: white; }');
    newWin.document.write('</style>');
    newWin.document.write('</head><body>');
    newWin.document.write(divToPrint.outerHTML);
    newWin.document.write('</body></html>');
    newWin.document.close();
    newWin.print();
  }
</script>