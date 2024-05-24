<?php

$rankings = array('1' => 'BE', '2' => 'AE', '3' => 'ME', '4' => 'EE');


?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6><b>CBC Summative Report</b></h6>
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
                $options = array('' => 'Select Student') + $stud;
                $attributes = 'class="form-control js-example-basic-single"';
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
                $attributes = 'class="form-control"';
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

                $attributes = 'class="form-control"';
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
                <button type="submit" class="btn btn-primary mb-1 d-inline-flex">
                  <i class="fe fe-check-square me-1 lh-base"></i>
                  <?php echo ($updType == 'edit') ? 'Update' : 'Submit'; ?>
                </button>
                <button class="btn btn-info" onclick="printInvoice(event)"> <i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>

      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- // Display the grouped results -->

<?php
// echo "<pre>";

// $firstElement = $exams[0];
// echo $firstElement;

// print_r($exams);
// print_r($grouped_marks);
// echo "<pre>";
if ($grouped_marks) {
  foreach ($grouped_marks as $ky => $st) {


?>
    <div class="invoice-box">
      <table cellpadding="0" cellspacing="0">
        <tr class="top">
          <td colspan="2">
            <table>

              <tr>
                <td class="title" style="width: 16%;">
                  <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" style="height:68px;" alt="header">
                </td>

                <td style=" width: 66%;" class="text-center">
                  <?php
                  $stu = $this->worker->get_student($ky);
                  $birthdateTimestamp = $stu->dob;

                  $birthDateTime = new DateTime();
                  $birthDateTime->setTimestamp($birthdateTimestamp);

                  $currentDateTime = new DateTime();

                  // Calculate the difference
                  $ageInterval = $currentDateTime->diff($birthDateTime);


                  if ($stu->dob === "") {
                    $age = "---";
                  } else {
                    $age = $ageInterval->y;
                  }

                  $this->load->model('cbc_tr');


                  ?>
                  <h4>SUMMATIVE REPORT</h4>
                  <h6 class="upper-casr"><b>NAME:</b> <u><?php echo $stu->first_name . ' ' . $stu->last_name ?> </u>&nbsp; <b>ADM NO:</b> <u><?php echo $stu->admission_number ?> </u> &nbsp; <b>AGE:</b> <u><?php echo  $age; ?></u></h6>
                  <span class="upper_case"><?php echo strtoupper($stu->cl->name) . ", TERM " . $this->school->term . ' ' . $this->school->year ?></span><br>
                </td>
                <td style=" width: 16%;">
                  <?php if ($passport) { ?>
                    <div class="img-container right">
                      <img src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" style="height:68px;" alt="header">
                    </div>
                  <?php } ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>


      <table class="table table-bordered">
        <tr class="table-success">
          <th>#</th>
          <th>Subject</th>
          <?php if ($exams[0]) { ?><th><?php $exm = $this->cbc_tr->get_exam($exams[0]);
                                        echo ucwords($exm->exam); ?></th> <?php  } ?>
          <?php if ($exams[1]) { ?><th><?php $exm = $this->cbc_tr->get_exam($exams[1]);
                                        echo ucwords($exm->exam); ?></th> <?php  } ?>
          <?php if ($exams[2]) { ?><th><?php $exm = $this->cbc_tr->get_exam($exams[2]);
                                        echo ucwords($exm->exam); ?></th> <?php  } ?>
          <th>Terms Average</th>
          <th>Teacher</th>
        </tr>
        <tbody>
          <?php
          $i = 1;
          foreach ($st as $sub => $subs) {


          ?>
            <tr style="font-size: 14px; text-align:center">
              <td><?php echo $i++ ?></td>
              <td style="text-align:left"><?php echo $subjects[$sub] ?></td>
              <?php if ($exams[0]) { ?><td><?php foreach ($subs as $is => $ex) {

                                              foreach ($ex as $key => $v) {

                                                if ($v['exam'] == $exams[0]) {
                                                  $m0 = $v['score'];
                                                  echo $m0;
                                                  echo ' (' . $rankings[$m0] . ')';
                                                }
                                              }
                                            } ?></td>
                </th> <?php  } ?>
              <?php if ($exams[1]) { ?><td>
                  <?php foreach ($subs as $is => $ex) {

                    foreach ($ex as $key => $v) {

                      if ($v['exam'] == $exams[1]) {
                        $m1 = $v['score'];
                        echo  $m1;
                        echo ' (' . $rankings[$m1] . ')';
                      }
                    }
                  } ?>
                </td>
                </th> <?php  } ?>
              <?php if ($exams[2]) { ?><td>
                  <?php foreach ($subs as $is => $ex) {

                    foreach ($ex as $key => $v) {

                      if ($v['exam'] == $exams[2]) {
                        $m2 = $v['score'];
                        echo $m2;
                        echo ' (' . $rankings[$m2] . ')';
                      }
                    }
                  } ?>
                </td>
                </th> <?php  } ?>
              <td>
                <!-- Average -->
                <?php
                if (!$m2) {
                  $avg = ($m0 + $m1) / 2;
                } else {
                  $avg = ($m1 + $m2 + $m0) / 3;
                }
                $av = round($avg);
                echo $av;
                echo ' (' . $rankings[$av] . ')';
                ?>
              </td>
              <!-- teacher -->
              <td> <?php
                    $this->load->model('teachers/teachers_m');
                    $trs = $this->cbc_tr->get_teachers($stu->cl->id, $term,  $year, $sub);
                    $td = $this->teachers_m->find($trs->teacher);
                    echo $td->first_name . ' ' . $td->last_name;

                    ?></td>
            </tr>
          <?php

          }
          ?>
        </tbody>
      </table>


      <hr>
      <div class="col-xl-12">
        <h6 style="font-size:13px;"><strong>GENERAL REMARKS ON SUMMATIVE ASSESSMENT</strong></h6>
        <p>Here </p>
      </div>

      <div class="col-xl-12">
        <h6 style="font-size:13px;"><strong>Class teacher’s comments:</strong></h6>
        <p>Here </p>
      </div>

    </div>


  <?php
  }
} else {
  ?>
  <div class="row">
    <p class="alert alert-danger">No results found !</p>
  </div>
<?php
}
?>

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



  }
</style>

<script>
  function printInvoice(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    window.print(); // Trigger the print dialog
  }
</script>