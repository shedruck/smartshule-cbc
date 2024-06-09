<?php

$rankings = array('1' => 'BE', '2' => 'AE', '3' => 'ME', '4' => 'EE');

?>

<div class="row hidden-print">
  <div class="col-md-12">
    <div class="card">
      
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6><b>CBC Formative Report</b></h6>
        <div>
          <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>
      <div class="card-body">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'form');
        echo form_open(current_url());

        $selected_term = isset($term) ? $term : '';
        $selected_student = isset($student) ? $student : '';
        $selected_year = isset($year) ? $year : '';
        $selected_subject = isset($subject) ? $subject : '';
        ?>
        <div class="row">
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Student <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $options = array('' => 'Select Student') + $stud;
                $attributes = 'class="form-control js-example-basic-single" id="classDropdown"';
                echo form_dropdown('student', $options, $selected_student, $attributes);
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
                $attributes = 'class="form-control js-example-basic-single"';
                echo form_dropdown('term', $option, $selected_term, $attributes);
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

                $attributes = 'class="form-control js-example-basic-single"';
                echo form_dropdown('year', $years, $selected_year, $attributes);
                ?>
                <?php echo form_error('year'); ?>
              </div>
            </div>
          </div>

        </div>

        <div class="row">
          <!-- Second Row -->
          <div class="col-xl-12">
            <div class="row m-1">
              <!-- First Column -->
              <div class="col-xl-4 d-flex justify-content-start">
                <div class="row m-2 w-100">
                  <label class="col-md-3 form-label" for='title'>Subject <span class='required'>*</span></label>
                  <div class="col-md-9">
                    <?php
                    $options = array('' => 'Select Subject') + $subs;
                    $attributes = 'class="form-control js-example-basic-single" id="subjectDropdown"';
                    echo form_dropdown('subject', $options, $selected_subject, $attributes);
                    ?>
                    <?php echo form_error('subject'); ?>
                  </div>
                </div>
              </div>

              <!-- Second Column (Empty, can be removed if not needed) -->
              <div class="col-xl-4">
              </div>

              <!-- Third Column -->
              <div class="col-xl-4 d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-warning mb-1 d-inline-flex me-2">
                  <i class="fas fa-filter me-1 lh-base"></i>
                  <?php echo ($updType == 'edit') ? 'Update' : 'Filter'; ?>
                </button>
                <button class="btn btn-info" onclick="printPage()">
                  <i class=" fas fa-print"></i> Print
                </button>
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

if ($this->input->post()) {

  if ($report) {
    foreach ($report as $ky => $st) {

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
                    <h5><b>FORMATIVE REPORT - <?php echo $subjects[$subject]; ?></b></h5>
                    <h6 class="upper-casr"><b>NAME:</b> <u><?php echo htmlspecialchars($stu->first_name . ' ' . $stu->last_name) ?> </u>&nbsp; <b>ADM NO:</b> <u><?php echo htmlspecialchars($stu->admission_number) ?> </u> &nbsp; <b>AGE:</b> <u><?php echo  htmlspecialchars($age); ?></u></h6>
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
          <thead>
            <tr class="bg-primary">
              <th class="tx-fixed-white">#</th>
              <th class="tx-fixed-white">Remarks</th>
              <th class="tx-fixed-white">Rating</th>
              <th class="tx-fixed-white">Teacher's Comment</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $i = 1;
            foreach ($st as $key => $strand) { ?>
              <tr class="font-weight-bold text-uppercase" style="background-color:#f5f5f5 ">
                <td style="font-size: 15px; text-align: left;"><?php echo number_format($i++, 1) ?></td>
                <td colspan="4" style="font-size: 13px; text-align: left;"><?php echo htmlspecialchars($strandz[$key]); ?></td>
              </tr>
              <?php
              $j = 1; // Counter for the inner loop
              foreach ($strand as $k => $sub_strnd) {
                $rowCount = count($sub_strnd); ?>
                <tr class="font-weight-bold" style="background-color:#f9f9f9">
                  <td style="font-size: 13px; text-align: left;"><?php echo number_format($i - 1 + ($j++ / 10), 1); ?></td>
                  <td colspan="3" style="font-size: 13px; text-align: left;"> <?php echo htmlspecialchars($subz[$k]); ?></td>
                </tr>
                <?php foreach ($sub_strnd as $y => $r) { ?>
                  <tr>
                    <td></td>
                    <td style="font-size: 13px; text-align: left;">
                      <?php echo htmlspecialchars($task[$r['task']]); ?>
                    </td>
                    <td style="font-size: 13px; text-align: left;">
                      <?php echo htmlspecialchars($r['rating'] . '  (' . $rankings[$r['rating']]) . ')'; ?>
                    </td>
                    <td style="font-size: 13px; text-align: left;"><?php echo htmlspecialchars($r['remarks']);   ?></td>
                    <?php if ($y == 0) : ?>
                      <!-- <td rowspan="<?php echo $rowCount; ?>">Comment</td> -->
                    <?php endif; ?>
                  </tr>
                <?php } ?>
              <?php } ?>
            <?php } ?>
          </tbody>
        </table>



        <hr>
        <?php
        $updated_value = $this->cbc_tr->get_rmk($r['assess_id'], $ky, $subject);

        $teacher_comment = $this->cbc_tr->get_tr_rmks($r['assess_id'], $ky, $subject);
        ?>
        <div class="col-xl-12 mt-2">
          <div class="row">
            <div class="col-xl-7">
              <h6 style="font-size:13px;"><strong>GENERAL REMARKS ON SUMMATIVE ASSESSMENT</strong></h6>
              <p>
                <textarea class="inputField dotted-underline" data-ky="<?php echo $ky; ?>" data-assess="<?php echo $r['assess_id']; ?>" placeholder="Type remarks here..." style="max-width: 400px; width: 100%; overflow: hidden; resize: none; height: auto; line-height: 1.5;"><?php echo $updated_value ?></textarea>
              </p>
            </div>
            <div class="col-xl-5">
              <h6 style="font-size:13px;"><strong>Signiture</strong></h6>
            </div>

          </div>
        </div>

        <div class="col-xl-12">
          <h6 style="font-size:13px;"><strong>Class teacher’s comments:</strong></h6>
          <p>
            <textarea class="commentField dotted-underline" data-ky="<?php echo $ky; ?>" data-assess="<?php echo $r['assess_id']; ?>" placeholder="Type your comment..." style="max-width: 400px; width: 100%; overflow: hidden; resize: none; height: auto; line-height: 1.5;"><?php echo $teacher_comment ?></textarea>
          </p>
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
}
?>

<style>
  body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    padding: 20px;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
  }

  .table-bordered th,
  .table-bordered td {
    border: 1px solid #ddd;
    padding: 12px;
  }



  .table-success {
    background-color: #d4edda;
  }

  .font-weight-bold {
    font-weight: bold;
  }


  th[colspan="4"],
  th[colspan="3"] {
    text-align: left;
    padding-left: 16px;
  }

  td {
    vertical-align: top;
  }

  td[rowspan] {
    vertical-align: middle;
  }

  /* Custom dotted background for rows */
  .dotted-bg {
    background: radial-gradient(circle, #000 1px, rgba(255, 255, 255, 0) 1px);
    background-size: 10px 10px;
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
    padding: 9px;
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

  .inputField {
    border: none;
    outline: none;
    background-color: transparent;
    font-size: 13px;
    color: black;
    width: 400px;

  }

  .commentField {
    border: none;
    outline: none;
    background-color: transparent;
    font-size: 13px;
    color: black;
    width: 400px;

  }

  .dotted-underline {
    border: none;
    border-bottom: 1px dotted black;
    outline: none;
    padding-bottom: 2px;
    background: transparent;
    /* Ensures no background color */
  }

  .dotted-underline:focus {
    border-bottom: 1px solid black;

  }


  /* Define a media query to show elements only on print */
  @media print {

    .invoice-box {
      box-shadow: none;
      margin: 0;
      border: none;
      margin: auto;
      min-width: 1000px;
      height: auto;


    }

  }
</style>




<script>
  // Define the debounce function
  function debounce(func, wait) {
    let timeout;
    return function(...args) {
      const context = this;
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(context, args), wait);
    };
  }

  // Attach the event listener with debounce
  $('.inputField, .commentField').on('change', debounce(function() {
    var input = $(this).val();
    var ky = $(this).data('ky');
    var subject = '<?php echo $subject; ?>';
    var assess = $(this).data('assess');
    var term = '<?php echo $term; ?>';
    var year = '<?php echo $year; ?>';
    var fieldType = $(this).hasClass('inputField') ? 'input' : 'comment';

    console.log({
      input,
      ky,
      subject,
      assess,
      term,
      year,
      fieldType
    }); // Log data for debugging

    $.ajax({
      url: '<?php echo base_url("cbc/trs/save_comments"); ?>',
      method: 'POST',
      data: {
        input: input,
        ky: ky,
        subject: subject,
        assess: assess,
        term: term,
        year: year,
        field: fieldType
      },
      success: function(response) {
        var data = JSON.parse(response);
        if (fieldType === 'input') {
          $('.inputField[data-ky="' + ky + '"]').val(data.updated_value);
        } else if (fieldType === 'comment') {
          $('.commentField[data-ky="' + ky + '"]').val(data.updated_value);
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error: ' + status + error);
      }
    });
  }, 300)); // Adjust the debounce time as needed, here it's set to 300ms
</script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea.commentField');

    textareas.forEach(textarea => {
      // Adjust the height of the textarea based on its content
      function adjustHeight() {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
      }

      // Initial adjustment on page load
      adjustHeight();

      // Adjust height on input
      textarea.addEventListener('input', adjustHeight);
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea.inputField');

    textareas.forEach(textarea => {
      // Adjust the height of the textarea based on its content
      function adjustHeight() {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
      }

      adjustHeight();

      // Adjust height on input
      textarea.addEventListener('input', adjustHeight);
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const editableDivs = document.querySelectorAll('div.inputField');

    editableDivs.forEach(div => {

      function adjustHeight() {
        div.style.height = 'auto';
        div.style.height = div.scrollHeight + 'px';
      }

      adjustHeight();


      div.addEventListener('input', adjustHeight);

      div.addEventListener('input', function() {

        const text = div.innerText;
        div.innerHTML = text.replace(/(.)/g, '<span style="text-decoration: underline;">$1</span>');
      });
    });
  });
</script>