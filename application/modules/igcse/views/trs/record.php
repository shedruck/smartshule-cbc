<?php
$this->load->model('igcse/igcse_m');
$teachers = $this->igcse_m->list_teachers();
$classes_with_teachers = $this->igcse_m->get_class_with_teacher();
$subs = $this->igcse_m->populate('subjects', 'id', 'name');

foreach ($classes as $keey => $clz) {

    $teacher = $this->user->id;
    $cls_tr = $this->igcse_m->class_teacher($clz->id);
    $trs = $this->igcse_m->get_teacher($teacher);

    // Checking if the current teacher is the class teacher
    $is_class_teacher = ($cls_tr->class_teacher == $teacher);

    if ($is_class_teacher) {

        // echo $clz->id;


    }
}
?>

<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            <b>Record Exam Marks</b>
        </h3>
        <div class="pull-right">


            <?php
            foreach ($classes as $keey => $clz) {

                $teacher = $this->user->id;
                $cls_tr = $this->igcse_m->class_teacher($clz->id);
                $trs = $this->igcse_m->get_teacher($teacher);

                // Checking if the current teacher is the class teacher
                $is_class_teacher = ($cls_tr->class_teacher == $teacher);

                if ($is_class_teacher) {

                    // echo $clz->id;
            ?>
                    <a class="btn btn-warning " href="<?php echo base_url('igcse/trs/addcomment/' . $clz->id); ?>"><i class="fa fa-star"></i> View Exam Results</a>

            <?php                                                                                                                                        }
            }
            ?>
            <a class="btn btn-success " href="<?php echo base_url('igcse/trs/view'); ?>"><i class="fa fa-eye"></i> View Subjects Marks</a>
            <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>

        <div class="clearfix"></div>
        <hr>
    </div>
    <div id="step1">

        <?php if ($this->session->flashdata('update_success')) : ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $this->session->flashdata('update_success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('insertion_success')) : ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $this->session->flashdata('insertion_success'); ?>
            </div>
        <?php endif; ?>


        <div class="panel panel-primary">
            <div class="panel-heading">Record Marks</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <?php
                        $subject = $this->input->post('subject');
                        echo form_open(base_url('igcse/trs/addmarks/' . $subject)); ?>
                        <div class="col-sm-3">
                            <label>Class</label>
                            <?php
                            // Initial options for the dropdown
                            $options = ['' => ''];
                            foreach ($classes_with_teachers as $class) {
                                if (isset($this->streams[$class->class])) {
                                    $options[$class->class] = $this->streams[$class->class];
                                }
                            }
                            echo form_dropdown('class', $options, $this->input->post('class'), 'class="select" id="class-dropdown" required');
                            ?>
                        </div>

                        <div class="col-sm-3">
                            <label>Exam</label>
                            <?php
                            $options = array('' => '');
                            foreach ($thread as $exam) {
                                // Add each exam title to the options array
                                $options[$exam->id] = $exam->title;
                            }
                            echo form_dropdown('thread', $options, $this->input->post('thread'), 'class="select" id="thread-dropdown" required');
                            ?>
                        </div>


                        <div class="col-sm-3">
                            <label>Category <i>(Main-exam/Opener/Mid)</i></label>
                            <?php
                            $options = array('' => '');
                            echo form_dropdown('exam', $options, $this->input->post('exam'), 'class="select" id="exam-dropdown" required');
                            ?>
                        </div>

                        <div class="col-sm-3">
                            <label>Subject</label>
                            <?php
                            $options = array('' => '');

                            echo form_dropdown('subject', $options, $this->input->post('subject'), 'class="select" id="sub-dropdown" required');
                            ?>
                        </div>


                        <div style="float: right;">
                            <br>
                            <button type="submit" class="btn btn-primary">Record</button>
                        </div>
                        <?php echo form_close() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('#thread-dropdown').change(function() {
            var selectedThreadId = $(this).val();

            var url = `<?php echo base_url("igcse/trs/fetch_exams/") ?>/${selectedThreadId}`;

            console.log(url);
            // console.log('Selected Thread ID:', selectedThreadId);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    populateExamDropdown(response);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            $.ajax({
                url: url2,
                type: 'GET',
                success: function(response) {
                    // Process response for the second data retrieval
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        function populateExamDropdown(examData) {
            var examDropdown = $('#exam-dropdown');
            examDropdown.empty(); // Clear existing options
            examDropdown.append($('<option>').text('').val('')); // Add default option
            $.each(JSON.parse(examData), function(index, exam) {
                examDropdown.append($('<option>').text(exam.title).val(exam.id));
            });
        }
    });
</script>


<script>
    $(document).ready(function() {
        // Attach change event listener to the class dropdown
        $('#class-dropdown').change(function() {
            var selectedClassId = $(this).val();
            var url2 = `<?php echo base_url("igcse/trs/fetch_data/") ?>/${selectedClassId}`;
            // console.log(selectedThreadId);
            $.ajax({
                url: url2,
                type: 'GET',
                success: function(response) {
                    displaySubjects(response);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });


    function displaySubjects(response) {
        var subjectsDropdown = $('#sub-dropdown');

        subjectsDropdown.empty();

        subjectsDropdown.append($('<option>').text('').attr('value', ''));

        var dataArray = JSON.parse(response);

        dataArray.forEach(function(item) {
            // Check if the item has a 'subject' property
            if (item.subject) {
                subjectsDropdown.append($('<option>').text(item.subject).attr('value', item.value));
            }
        });
    }
</script>



<script>
    $(document).ready(function() {
        $('#myForm').submit(function(event) {
            event.preventDefault(); // Prevent form submission and page reload

            // Your form processing code here

            // Show the table
            $('#dataTable').show();

            // Optionally, you can populate the table here if needed
            // fetchDataAndPopulateTable();
        });
    });
</script>