<?php
if ($this->input->get()) {
    $arg = $this->input->get('arg');
}
?>
<div class="row ">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center m-2">
                    <img class="me-2 w-40p" src="../assets/images/icons/1.png" alt="">
                    <div>
                        <h5 class="mb-0"><b><?php echo $class_name ?></b></h5>
                        <p class="mb-0 text-muted"><?php echo $subject_name ?></p>
                        <p class="mb-0 text-muted"><?php echo $task->name ?></p>
                    </div>


                </div>
            </div>

            <div class="card-body p-0">
                <div class="d-lg-flex d-block">
                    <div class="table-responsive push">
                        <?php echo form_open(base_url('cbc/trs/save_assesment')) ?>
                        <input type="hidden" name="params" value="<?php echo $arg ?>">
                        <table class="table table-bordered text-nowrap">
                            <tbody>
                                <tr class="table-primary bg-primary">
                                    <th class="text-center tx-fixed-white">#</th>
                                    <th class="tx-fixed-white">Student</th>
                                    <th class="text-center tx-fixed-white">1</th>
                                    <th class="text-center tx-fixed-white">2</th>
                                    <th class="text-center tx-fixed-white">3</th>
                                    <th class="text-center tx-fixed-white">4</th>
                                </tr>
                                <?php
                                $index = 1;
                                foreach ($students as $p) {

                                    $done =  isset($payload[$p->id]) ? $payload[$p->id] : [];



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

                                        <td class="text-center">
                                            <div class="checkbox-wrapper-23">
                                                <label for="ID_1_<?php echo $p->id ?>" style="--size: 30px">
                                                    BE
                                                </label>
                                                <input type="checkbox" name="score[<?php echo $p->id ?>]" value="1" class="chb" id="ID_1_<?php echo $p->id ?>" <?php echo (isset($done->rating) && $done->rating == 1) ? 'checked' : '' ?>>

                                            </div>

                                        </td>
                                        <td class="text-center">
                                            <div class="checkbox-wrapper-23">
                                                <label for="ID_2_<?php echo $p->id ?>">
                                                    AE
                                                </label>
                                                <input type="checkbox" name="score[<?php echo $p->id ?>]" value="2" class="chb" id="ID_2_<?php echo $p->id ?>" <?php echo (isset($done->rating) && $done->rating == 2) ? 'checked' : '' ?>>

                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="checkbox-wrapper-23">
                                                <label for="ID_3_<?php echo $p->id ?>" style="--size: 30px">
                                                    ME
                                                </label>
                                                <input type="checkbox" name="score[<?php echo $p->id ?>]" value="3" class="chb" id="ID_3_<?php echo $p->id ?>" <?php echo (isset($done->rating) && $done->rating == 3) ? 'checked' : '' ?>>

                                            </div>
                                        </td>


                                        <td class="text-center">
                                            <div class="checkbox-wrapper-23">
                                                <label for="ID_4_<?php echo $p->id ?>" style="--size: 30px">
                                                    EE
                                                </label>
                                                <input type="checkbox" name="score[<?php echo $p->id ?>]" value="4" class="chb" id="ID_4_<?php echo $p->id ?>" <?php echo (isset($done->rating) && $done->rating == 4) ? 'checked' : '' ?>>

                                            </div>
                                        </td>


                                    </tr>
                                    <tr>
                                        <td></td>
                                        <!-- <td></td> -->
                                        <td colspan="5">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <label for="text-area" class="form-label">Remarks</label>
                                                <textarea class="form-control" id="ID_<?php echo $p->id ?>" rows="4" name="remarks[<?php echo $p->id ?>]"><?php echo isset($done->remarks) ? $done->remarks : '' ?></textarea>
                                            </div>
                                        </td>
                                    </tr>

                                <?php $index++;
                                } ?>


                            </tbody>
                        </table>


                        <div class="card-footer">
                            <div class="form-check d-inline-block">
                                <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" name="publish" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Publish to main report?
                                </label>
                            </div>
                            <div class="float-end d-inline-block btn-list">
                                <button type="button" class="btn btn-secondary mb-1 d-inline-flex go_back" onclick="return confirm('Are you sure?')"><i class="fe fe-arrow-left-circle me-1 lh-base"></i> Cancel</button>
                                <button type="submit" class="btn btn-info mb-1 d-inline-flex" id="auto-disappear-save" onclick="return confirm('Are you sure?')"><i class="fe fe-check-square me-1 lh-base"></i> Save</button>
                            </div>
                        </div>

                        <?php echo form_close() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- <script>
    $(document).ready(function() {
        // Click event for radio buttons
        $('.chb').click(function() {
            var id = event.target.id;
            if ($(id).prop('checked'))
            {
                alert('i was cliekd');
            }
        });
    });
</script> -->


<script>
    $(document).ready(function() {
        // Click event for checkboxes
        $('.chb').click(function() {

            var parentRow = $(this).closest('tr');

            // Check if the clicked checkbox is checked
            if ($(this).prop('checked')) {
                // Disable other checkboxes in the same row
                parentRow.find('.chb').not(this).prop('disabled', true);
            } else {
                // Enable all checkboxes in the same row
                parentRow.find('.chb').prop('disabled', false);

                var id = event.target.id;



                var parts = id.split('_');
                var number = parts[parts.length - 1];

                var rmk_id = '#ID_' + number;

                $(rmk_id).text();
            }
        });
    });


    // populate comments
    $('.chb').click(function() {
        var id = event.target.id;



        var parts = id.split('_');
        var number = parts[parts.length - 1];

        var rmk_id = '#ID_' + number;



        var score = $('#' + id).val();
        var endpoint = "<?php echo base_url('cbc/trs/get_comments') ?>";
        var BASE_URL = "<?php echo base_url() ?>";
        $.ajax({
            url: endpoint,
            method: 'POST',
            dataType: 'json',
            data: {
                post_data: <?php echo json_encode($post); ?>,
                score: score
            },
            success: function(data) {
                $(rmk_id).text(data);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });


    });
</script>