<?php
if ($this->input->get()) {
    $get = (object) $this->input->get();
} else {
    $get = [];
}

if ($exam == 1) {
    $extype = 1;
} else if ($exam == 2) {
    $extype = 2;
}

?>

<?php
 echo form_open(current_url()) 
?>
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
                        $exams = array(
                            1 => 'Opener Exam',
                            2 => 'Mid Term Exam',
                            3 => 'End Term Exam'
                        );

                        echo form_dropdown('exam', ['' => 'Select Exam'] + $exams, $exam, 'class="js-example-placeholder-exam js-states form-control" id="exam"')
                        ?>
                    </div>
                    <div class="col-lg-4 col-xl-4">
                        <?php if (isset($students)) : ?>
                            <?php
                            $checkmarko = $this->cbc_tr->check_exists($sub,$exam,$cls);

                            echo form_dropdown('grading', ['' => 'Select Exam'] + $gradings, $checkmarko->gid, 'class="js-example-placeholder-grading js-states form-control" id="grading" required')
                            ?>
                            <input type="number" max="<?php echo $extype == 2 ? '4' : '100' ?>" name="outof" value="<?php echo $extype == 1 ? ($checkmarko) ? $checkmarko->outof : '' : '4' ?>" class="form-control mt-2" id="input-placeholder" placeholder="Outof" <?php echo $extype == 2 ? 'readonly' : '' ?>>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="d-lg-flex d-block">
                        <div class="p-4 border-end w-100">
                            <?php if (isset($students)) : ?>
                                <div class="table-responsive push">
                                    <input type="number" name="extype" value="<?php echo $extype ?>" class="form-control" hidden>
                                    <table class="table table-bordered text-nowrap">
                                        <tbody>
                                            <tr class="table-primary bg-primary">
                                                <th class="text-center tx-fixed-white">#</th>
                                                <th class="tx-fixed-white">Student</th>
                                                <?php if ($extype == 1): ?>
                                                <th class="text-center tx-fixed-white">Score</th>
                                                <?php elseif ($extype == 2): ?>
                                                <th class="text-center tx-fixed-white">EE - 4</th>  
                                                <th class="text-center tx-fixed-white">ME - 3</th>
                                                <th class="text-center tx-fixed-white">AE - 2</th>
                                                <th class="text-center tx-fixed-white">BE - 1</th>
                                                <?php endif; ?>
                                            </tr>
                                            <?php
                                            $index = 1;
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
                                                    <?php if ($extype == 1): ?>
                                                    <td>
                                                        <?php 
                                                            $score = $this->cbc_tr->get_stu_marks($sub,$exam,$p->id);
                                                        ?>

                                                        <input type="number" name="score[<?php echo $p->id ?>]" value="<?php echo ($score) ? $score->score : '' ?>" class="form-control" id="input-placeholder" placeholder="Score">
                                                    </td>
                                                    <?php 
                                                        elseif ($extype == 2):
                                                        $score = $this->cbc_tr->get_stu_marks($sub,$exam,$p->id); 
                                                    ?>
                                                    <td style="text-align: center;"><input class="form-check-input" type="radio" value="4" name="score[<?php echo $p->id ?>]" id="Radio-md" <?php echo $score ? $score->score == 4 ? 'checked' : '' : '' ?>></td>
                                                    <td style="text-align: center;"><input class="form-check-input" type="radio" value="3" name="score[<?php echo $p->id ?>]" id="Radio-md" <?php echo $score ? $score->score == 3 ? 'checked' : '' : '' ?>></td>
                                                    <td style="text-align: center;"><input class="form-check-input" type="radio" value="2" name="score[<?php echo $p->id ?>]" id="Radio-md" <?php echo $score ? $score->score == 2 ? 'checked' : '' : '' ?>></td>
                                                    <td style="text-align: center;"><input class="form-check-input" type="radio" value="1" name="score[<?php echo $p->id ?>]" id="Radio-md" <?php echo $score ? $score->score == 1 ? 'checked' : '' : '' ?>></td>
                                                    <?php endif; ?>
                                                </tr>


                                            <?php $index++;
                                            } ?>
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
                                                <p class="card-text text-muted">Please select Strand and Substrand first!</p>
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
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            Confirm
                        </label>
                    </div>
                    <div class="float-end d-inline-block btn-list">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php echo form_close() ?>

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
</style>
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
</script>