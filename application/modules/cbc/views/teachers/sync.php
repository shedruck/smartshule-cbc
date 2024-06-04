<?php
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes);
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Compute <?php echo $thread->name ?> for <b><?php echo $this->classes[$level] ?></b></h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <a href="<?php echo base_url('cbc/trs/joint_reports') ?>" class="btn btn-sm btn-primary">All Threads</a>
                    <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <input type="hidden" name="level" value="<?php echo $level ?>" id="level">
                <!-- <div class="row justify-content-center"> -->
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-xl-3" id="selexamsdiv">
                        <h6 class="">Select Exams</h6>
                        <hr>
                        <?php 
                            foreach ($exams as $ex) {
                        ?>
                        <div class="form-check form-check-md">
                            <input class="form-check-input" examname="<?php echo $ex->exam ?>" examtype="<?php echo $ex->type ?>" type="checkbox" value="<?php echo $ex->id ?>" name="exam[]" id="selex_<?php echo $ex->id ?>">
                            <label class="form-check-label" for="">
                                <?php echo $ex->exam ?>
                            </label>
                        </div>
                        <?php
                            }
                        ?>
                        <button id="selectexambtn" class="btn btn-success">Select</button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3" id="selectedexams">
                        <h6>Selected Exams</h6>
                        <hr>
                        <?php 
                            foreach ($exams as $ex) {
                        ?>
                        <div class="row d-none" id="exrow_<?php echo $ex->id ?>">
                            <!-- <label class="form-label"><?php echo $ex->exam ?></label> -->
                            <input type="text" name="exams[]" value="<?php echo $ex->id ?>" class="form-control d-none" id="exam_<?php echo $ex->id ?>" disabled>
                            
                            <label class="form-label">Subjects Weight <b>(<?php echo $ex->exam ?>)</b></label>
                            <input type="text" name="weight[]" class="form-control" id="weight_<?php echo $ex->id ?>" id="input" disabled required>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <h6>Select Grading System</h6>
                        <hr>
                        <?php
                            echo form_dropdown('grading', array('' => 'Select Grading System') + $gradings, '', ' class="form-control select" id="grading" data-placeholder="" required');
                        ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <h6>Arithmetic Operation</h6>
                        <hr>
                        <?php
                            $arithmetics = array(
                                1 => 'Average',
                                2 => 'Summation'
                            );

                            echo form_dropdown('operation', array('' => 'Select Computation') + $arithmetics, '', ' class="form-control select" id="operation" data-placeholder="" required');
                        ?>
                    </div>
                </div>
                <!-- </div> -->

            </div>
            <div class="card-footer">
                <div class="form-check d-inline-block">
                    <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
                </div>
                <div class="float-end d-inline-block btn-list">
                    <button class="btn btn-primary">Compute</button>
                    <?php echo anchor('cbc/trs/results/'.$thread->id, 'Cancel', 'class="btn btn-secondary"'); ?>
                </div>
            </div>
        </div>
    </div>

   
</div>
<?php echo form_close(); ?>
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>
<script>
    $(document).ready(function() {
        $("#selectexambtn").click(function(e){
            e.preventDefault();

            var selectedExams = [];
            var selectedTypes = [];
            var selectedNames = [];
            var examsData = [];

             // Loop through each checkbox
            $("input[name='exam[]']:checked").each(function() {
                var val = $(this).val();
                var extype = $(this).attr("examtype");
                var exname = $(this).attr('examname');

                var examData = {
                    id: $(this).val(),
                    type: $(this).attr("examtype")
                };

                selectedExams.push(val);
                selectedTypes.push(extype);
                selectedNames.push(exname);
                examsData.push(examData);
            });

            //Check Populated Values
            if (selectedExams.length == 0) {
                alert('Please Select Some Exams');
            } else {
                var allSame = selectedTypes.every(element => element === selectedTypes[0]);

                if (allSame) {
                    //Show Exams Selected
                    selectedExams.forEach(function(id) {
                        // $('#exrow_' + id).removeClass('d-none');
                        const row = $('#exrow_' + id);
                        row.removeClass('d-none');

                        // Remove the 'disabled' attribute from input fields inside the row
                        row.find('input').removeAttr('disabled')
                    });
                } else {
                    alert('You Selected incompatible exams. Rubrics and Marks cannot be combined.');
                }
            }

            // console.log(selectedExams);
            // console.log(selectedTypes);
            // console.log(selectedNames);

        });

        //Find if Exam is Unselected and removed it
        <?php 
            foreach ($exams as $ex) {
        ?>
            $("#selex_<?php echo $ex->id ?>").change(function(e){
                if ($(this).prop('checked')) {
                        
                } else {
                    const row = $('#exrow_<?php echo $ex->id ?>');
                    row.addClass('d-none');
                    // Add the 'disabled' attribute from input fields inside the row
                    row.find('input').attr('disabled', 'disabled');
                }
            }); 
        <?php } ?>
    });

</script>