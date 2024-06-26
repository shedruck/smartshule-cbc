<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


<?php
if ($this->input->get()) {
    $get = (object) $this->input->get();
} else {
    $get = [];
}


if ($exam_type->type == 1) {
    $extype = 2;
} else if ($exam_type->type == 2) {
    $extype = 1;
} else {
    $extype = null; // Explicitly set $extype to null if it doesn't match 1 or 2
}


?>

<!-- Customized alert -->
<div class="card custom-alert" style="display: none;">
    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-1">
        <div class="d-sm-flex align-items-center">
            <span class="me-3"><svg xmlns="http://www.w3.org/2000/svg" height="50" width="50" viewBox="0 0 24 24">
                    <path fill="#f07f8f" d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z" />
                    <circle cx="12" cy="17" r="1" fill="#e62a45" />
                    <path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z" />
                </svg></span>
            <div>
                <h4 class="h4 mb-0">Warning</h4>
                <p class="card-text text-muted">Some scores exceed the Outof value.</p>
            </div>
        </div>
        <div class="text-end">
            <a href="javascript:void(0);" class="btn btn-danger me-2 mb-2 btn-cancel">Cancel</a>
        </div>
    </div>
</div>

<?php

?>




<?php echo form_open(current_url(), array('id' => 'myForm', 'onsubmit' => 'return validateForm()')); ?>
<div class="row ">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="col-lg-4 col-xl-4">
                    <!-- <img class="me-2 w-40p" src="../assets/images/icons/1.png" alt=""> -->
                    <div>
                        <h5 class="mb-0"><b><?php echo $class ?></b></h5>
                        <p class="mb-0 text-muted"><?php echo $subject ?></p>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-4">
                    <?php

                    echo form_dropdown('exam', ['' => 'Select Exam'] + $exams, $exam, 'class="js-example-placeholder-exam js-states form-control" id="exam"')
                    ?>
                </div>
                <div class="col-lg-4 col-xl-4">
                    <?php if (isset($students)) : ?>
                        <?php
                        $checkmarko = $this->cbc_tr->check_exists($sub, $exam, $cls);

                        echo form_dropdown('grading', ['' => 'Select Grading System'] + $gradings, $checkmarko->gid, 'class="js-example-placeholder-grading js-states form-control" id="grading" required')
                        ?>
                        <input type="number" id="input-placeholder" max="<?php echo $extype == 2 ? '4' : '100' ?>" name="outof" value="<?php echo $extype == 1 ? ($checkmarko) ? $checkmarko->outof : '' : '4' ?>" class="form-control mt-2" placeholder="Outof" <?php echo $extype == 2 ? 'readonly' : '' ?> required>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="d-lg-flex d-block">
                    <div class="p-4 border-end w-100">
                        <?php if (isset($students)) : ?>
                            <div class="table-responsive push">
                                <input type="number" name="extype" value="<?php echo $exam_type->type ?>" class="form-control" hidden>
                                <table class="table table-bordered text-nowrap">
                                    <tbody>
                                        <tr class="table-primary bg-primary">
                                            <th class="text-center tx-fixed-white">#</th>
                                            <th class="tx-fixed-white">Student</th>
                                            <?php if ($extype == 1) : ?>
                                                <th class="text-center tx-fixed-white">Score</th>
                                            <?php elseif ($extype == 2) : ?>
                                                <th class="text-center tx-fixed-white">EE - 4</th>
                                                <th class="text-center tx-fixed-white">ME - 3</th>
                                                <th class="text-center tx-fixed-white">AE - 2</th>
                                                <th class="text-center tx-fixed-white">BE - 1</th>

                                            <?php endif; ?>
                                        </tr>
                                        <?php
                                        $index = 1;

                                        if ($extype === "" || $extype === null) {
                                        ?>
                                            <tr>
                                                <td colspan="7">
                                                    <div class="alert alert-danger">Please do Exam Setting first!!!</div>
                                                </td>
                                            </tr>
                                            <?php
                                        } else {
                                            foreach ($students as $p) {
                                            ?>
                                                <tr>
                                                    <td class="">
                                                        <input type="hidden" name="student[<?php echo $p->id ?>]" value="<?php echo $p->id ?>">
                                                        <?php echo $index ?>
                                                    </td>
                                                    <td>
                                                        <p class="font-w600 mb-1"><?php echo $p->admission_number ?></p>
                                                        <div class="text"><?php echo $p->first_name . ' ' . $p->middle_name . ' ' . $p->last_name ?> </div>
                                                    </td>
                                                    <?php if ($extype == 1) : ?>
                                                        <td>
                                                            <?php
                                                            $score = $this->cbc_tr->get_stu_marks($sub, $exam, $p->id);
                                                            ?>
                                                            <input type="number" id="secondInput" name="score[<?php echo $p->id ?>]" value="<?php echo ($score) ? $score->score : '' ?>" class="form-control secondInput" id="input-placeholder" placeholder="Score">
                                                        </td>
                                                    <?php elseif ($extype == 2) :
                                                        $score = $this->cbc_tr->get_stu_marks($sub, $exam, $p->id);
                                                    ?>
                                                        <td style="text-align: center;"><input class="form-check-input custom-checkbox" type="checkbox" value="4" name="score[<?php echo $p->id ?>]" id="Checkbox-md_4_<?php echo $p->id ?>" <?php echo $score ? $score->score == 4 ? 'checked' : '' : '' ?>></td>
                                                        <td style="text-align: center;"><input class="form-check-input custom-checkbox" type="checkbox" value="3" name="score[<?php echo $p->id ?>]" id="Checkbox-md_3_<?php echo $p->id ?>" <?php echo $score ? $score->score == 3 ? 'checked' : '' : '' ?>></td>
                                                        <td style="text-align: center;"><input class="form-check-input custom-checkbox" type="checkbox" value="2" name="score[<?php echo $p->id ?>]" id="Checkbox-md_2_<?php echo $p->id ?>" <?php echo $score ? $score->score == 2 ? 'checked' : '' : '' ?>></td>
                                                        <td style="text-align: center;"><input class="form-check-input custom-checkbox" type="checkbox" value="1" name="score[<?php echo $p->id ?>]" id="Checkbox-md_1_<?php echo $p->id ?>" <?php echo $score ? $score->score == 1 ? 'checked' : '' : '' ?>></td>


                                                    <?php endif; ?>
                                                </tr>
                                        <?php $index++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <div class="tab-content terms" id="vertical-tabContent">
                            <div class="tab-pane fade show active" id="vertical-terms" role="tabpanel" aria-labelledby="vertical-terms-tab" tabindex="0">
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <div class="card border-top border-info">
                                        <div class="card-body text-center">
                                            <span class="avatar avatar-lg bg-info rounded-circle"><i class="fe fe-bell" aria-hidden="true"></i></span>
                                            <h4 class="fw-semibold mb-1 mt-3">Alert</h4>
                                            <p class="card-text text-muted">Please select Exam first!</p>
                                        </div>
                                        <div class="card-footer text-center border-0 pt-0">
                                            <div class="row">
                                                <div class="text-center">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-check d-inline-block">
                    <input class="form-check-input custom-checkbox" type="checkbox" value="" id="flexCheckChecked">
                    <label class="form-check-label" for="flexCheckChecked">
                        Confirm
                    </label>
                </div>
                <div class="float-end d-inline-block btn-list">
                    <button type="submit" class="btn btn-primary " id="submitButton"><i class="fe fe-check-square me-1 lh-base"></i>Submit</button>
                      <a class="btn btn-secondary" href="<?php echo base_url('cbc/trs/begin_summative_form/'); ?>"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close() ?>

<!-- // disable submit button before confirm -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var checkbox = document.getElementById("flexCheckChecked");
        var submitButton = document.getElementById("submitButton");

        var isChecked = localStorage.getItem("confirmCheckbox");
        checkbox.checked = isChecked === "true";
        submitButton.disabled = !checkbox.checked;

        checkbox.addEventListener("change", function() {
            localStorage.setItem("confirmCheckbox", checkbox.checked);
            submitButton.disabled = !checkbox.checked;
        });
    });
</script>

<script>
    $(document).ready(function() {
        var cls = '<?php echo $cls ?>';
        var sub = '<?php echo $sub ?>';
        var exam = '<?php echo $exam ?>';
        // Select Exam
        $("#exam").change(function() {
            var BASE_URL = "<?php echo base_url() ?>";
            // var link = BASE_URL + 'cbc/trs/do_formative/' + k + '/' + item.id;

            var val = $(this).val();

            $(".my_page").hide();
            $("#myloader").addClass("loader");
            $("#myload").show();

            setTimeout(function() {
                window.location.href = BASE_URL + 'cbc/trs/do_summative/' + cls + '/' + sub + '/' + val;
            }, 1000);

            // console.log(val);
        })
    });


    //cancel button
    var cancelButton = document.getElementById('cancelButton');
    cancelButton.onclick = function() {
        location.reload();
    };
</script>


<script>
    $(document).ready(function() {
        $('.secondInput').on('input', function() {
            var firstValue = parseFloat($('#input-placeholder').val());
            var secondValue = parseFloat($(this).val());


            if (secondValue > firstValue) {
                $('.custom-alert').show();
                $(this).val('');
            } else {
                $('.custom-alert').hide();
            }
        });

        $('.btn-cancel').click(function() {
            $('.custom-alert').hide();
        });
    });
</script>

<!-- prevent marks bigger then outof -->
<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            // Find the maximum value
            var maxValue = parseFloat($('#input-placeholder').val());

            // Check each input
            var invalidInputs = false;
            $('.secondInput').each(function() {
                var scoreValue = parseFloat($(this).val());
                if (scoreValue > maxValue) {
                    $(this).addClass('highlighted');
                    invalidInputs = true;
                } else {
                    $(this).removeClass('highlighted');
                }
            });

            // If there are invalid inputs, prevent form submission and show the alert
            if (invalidInputs) {
                $('.custom-alert').show();
                event.preventDefault(); // Prevent form submission
            } else {
                $('.custom-alert').hide();
            }
        });

        $('.btn-cancel').click(function() {
            $('.custom-alert').closest('.card').remove();
        });
    });
</script>

<!-- disable and clear radio buttons  -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php foreach ($students as $p) : ?>
            var checkbox_<?php echo $p->id ?> = document.getElementById("flexCheckChecked_<?php echo $p->id ?>");
            var radioButtons_<?php echo $p->id ?> = document.querySelectorAll('input[type="radio"][name="score[<?php echo $p->id ?>]"]');

            checkbox_<?php echo $p->id ?>.addEventListener("change", function() {
                // Uncheck the radio buttons
                radioButtons_<?php echo $p->id ?>.forEach(function(radioButton) {
                    radioButton.checked = false;
                    radioButton.disabled = checkbox_<?php echo $p->id ?>.checked; // Disable the radio buttons if checkbox is checked
                });
            });
        <?php endforeach; ?>
    });
</script>



<style>
    .word-wrap {
        word-wrap: break-word;
        /* Ensure long words are broken */
        overflow-wrap: break-word;
        /* Ensure breaks occur within words */
        word-break: break-all;
        /* Force break between every pair of letters */
    }

    /* Forcing word breaks after every third word */
    .word-wrap::after {
        content: '\A';
        white-space: pre;
    }

    .word-wrap-three {
        /* Ensure long words are broken */
        word-wrap: break-word;
        /* Ensure breaks occur within words */
        overflow-wrap: break-word;
        /* Force break between every pair of letters */
        word-break: break-all;
    }

    /* Forcing word breaks after every third word */
    .word-wrap-three::after {
        content: '\A';
        white-space: pre;
        /* Insert space after every third word */
        display: inline;
        width: 100%;
    }

    input[type="radio"] {
        transform: scale(2);

    }

    .highlighted {
        border-color: red !important;
    }

    .inserted-alert {
        position: fixed;
        top: 20px;
        /* Adjust as needed */
        right: 20px;
        /* Adjust as needed */
        z-index: 1000;
        /* Ensure it appears above other content */
    }

    .updated-alert {
        position: fixed;
        top: 70px;
        /* Adjust as needed */
        right: 20px;
        /* Adjust as needed */
        z-index: 1000;
        /* Ensure it appears above other content */
    }


    .alert {
        position: relative;
    }

    .custom-checkbox {
        width: 1.3em;
        /* Set the width of the checkbox */
        height: 1.3em;
        /* Set the height of the checkbox */
    }

    .custom-checkbox:checked {
        transform: scale(1.2);

    }
</style>

<script>
    // Get all checkboxes with the class "form-check-input"
    var checkboxes = document.querySelectorAll('.form-check-input');

    // Add an event listener to each checkbox
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('click', function() {
            // If the checkbox is checked, uncheck all other checkboxes in the same group
            if (this.checked) {
                checkboxes.forEach(function(otherCheckbox) {
                    if (otherCheckbox !== checkbox && otherCheckbox.name === checkbox.name) {
                        otherCheckbox.checked = false;
                    }
                });
            }
        });
    });
</script>

<?php if ($this->session->flashdata('updated_message')) : ?>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Retrieve the inserted message text
        var insertedMessage = "<?php echo $this->session->flashdata('updated_message')['text']; ?>";

        // Show toast notification
        Toastify({
            text: insertedMessage,
            duration: 3000, // Duration in milliseconds
            gravity: "top", // Position of the toast on the screen (top, bottom, left, right)
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)", // Background color
            stopOnFocus: true // Stop auto-hide on toast hover
        }).showToast();
    </script>
<?php endif; ?>

<?php if ($this->session->flashdata('inserted_message')) : ?>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Retrieve the inserted message text
        var insertedMessage = "<?php echo $this->session->flashdata('inserted_message')['text']; ?>";

        // Show toast notification
        Toastify({
            text: insertedMessage,
            duration: 3000, // Duration in milliseconds
            gravity: "top", // Position of the toast on the screen (top, bottom, left, right)
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)", // Background color
            stopOnFocus: true // Stop auto-hide on toast hover
        }).showToast();
    </script>
<?php endif; ?>