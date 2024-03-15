<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Add Grades </h2>
    <div class="right">

    </div>
</div>

<div class="block-fluid">
    <h5 class="text center"><b> ADD Grades for <span class="text-danger"><?php echo $gradingsys->title; ?></span></b></h5>
    <hr>
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => 'gradesform');
    echo   form_open_multipart(current_url(), $attributes);
    ?>
    <div id="gradesdiv">
        <div class="row">
            <div class="col-sm-2 p-2">
                <h6><b>Remove</b></h6>
            </div>
            <div class="col-sm-2 p-2">
                <h6><b>Grade</b></h6>
            </div>
            <div class="col-sm-2 p-2">
                <h6><b>Minimum Marks</b></h6>
            </div>
            <div class="col-sm-2 p-2">
                <h6><b>Maximum Marks</b></h6>
            </div>
            <div class="col-sm-2 p-2">
                <h6><b>Points</b></h6>
            </div>
            <div class="col-sm-2 p-2">
                <h6><b>Comment</b></h6>
            </div>
        </div>
        <?php if ($grades) : ?>
            <?php foreach ($grades as $grade) : ?>
                <div class="row justify-content-center" style="margin-bottom: 10px;">
                    <div class="col-sm-2 p-2">
                        <div class="">
                            <button disabled class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
                            <input type="number" value="<?php echo $grade->id ?>" name="gid[]" id="gid" style="display: none;">
                        </div>
                    </div>
                    <div class="col-sm-2 p-2">
                        <div class="">
                            <?php echo form_input('grade[]', isset($grade->grade) ? $grade->grade : '', 'id="grade_"  class="form-control" placeholder="E.g A" '); ?>
                            <?php echo form_error('grade'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 p-2">
                        <div class="">
                            <input type="number" name="minimum_marks[]" min="0" max="100" value="<?php echo isset($grade->minimum_marks) ? $grade->minimum_marks : '' ?>" class="form-control" id="">

                            <?php echo form_error('minimum_marks'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 p-2">
                        <div class="">
                            <input type="number" min="0" max="100" name="maximum_marks[]" value="<?php echo isset($grade->maximum_marks) ? $grade->maximum_marks : '' ?>" class="form-control" id="">

                            <?php echo form_error('maximum_marks'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 p-2">
                        <div class="">
                            <input type="number" min="0" max="12" name="points[]" value="<?php echo isset($grade->points) ? $grade->points : '' ?>" class="form-control" id="">

                            <?php echo form_error('points'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 p-2">
                        <div class="">
                            <?php echo form_input('comment[]', isset($grade->comment) ? $grade->comment : '', 'id="comment_"  class="form-control" placeholder="E.g Excellent" '); ?>
                            <?php echo form_error('comment'); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <div class="row justify-content-center" style="margin-bottom: 10px;">
                <div class="col-sm-2 p-2">
                    <div class="">
                        <button disabled class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
                        <input type="number" name="gid[]" id="gid" style="display: none;">
                    </div>
                </div>
                <div class="col-sm-2 p-2">
                    <div class="">
                        <?php echo form_input('grade[]', isset($result->grade) ? $result->grade : '', 'id="grade_"  class="form-control" placeholder="E.g A" '); ?>
                        <?php echo form_error('grade'); ?>
                    </div>
                </div>
                <div class="col-sm-2 p-2">
                    <div class="">
                        <input type="number" name="minimum_marks[]" min="0" max="100" value="<?php echo isset($result->minimum_marks) ? $result->minimum_marks : '' ?>" id="">
                        <?php echo form_error('minimum_marks'); ?>
                    </div>
                </div>
                <div class="col-sm-2 p-2">
                    <div class="">
                        <input type="number" name="maximum_marks[]" min="0" max="100" value="<?php echo isset($result->maximum_marks) ? $result->maximum_marks : '' ?>" class="form-control" id="">

                        <?php echo form_error('maximum_marks'); ?>
                    </div>
                </div>
                <div class="col-sm-2 p-2">
                    <div class="">
                        <input type="number" min="0" max="12" name="points[]" value="<?php echo isset($result->points) ? $result->points : '' ?>" class="form-control" id="">

                        <!-- <?php echo form_input('points[]', isset($result->points) ? $result->points : '', 'id="points_"  class="form-control" placeholder="E.g 12" '); ?> -->
                        <?php echo form_error('points'); ?>
                    </div>
                </div>
                <div class="col-sm-2 p-2">
                    <div class="">
                        <?php echo form_input('comment[]', isset($result->comment) ? $result->comment : '', 'id="comment_"  class="form-control" placeholder="E.g Excellent" '); ?>
                        <?php echo form_error('comment'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6">
            <div class="btn-group float-end">
                <button id="fieldaddbtn" type="button" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> ADD NEW LINE</button>
            </div>
        </div>
    </div>


    <div class='form-group row justify-content-center'>
        <div class="col-sm-6">
            <?php echo form_submit('submit', 'Add Grades', 'class="btn btn-success"'); ?>
            <?php echo anchor('admin/grading_system', 'Cancel', 'class="btn btn-danger"'); ?>
        </div>
    </div>


    <?php echo form_close(); ?>

</div>

</div>
</div>
</div>
</div>

</div>

<script>
    $(document).ready(function() {
        var i = 1;

        <?php
        $i = 1;
        ?>

        $("#fieldaddbtn").click(function(e) {
            e.preventDefault();

            var delid = i++;

            <?php
            $i = $i++;
            ?>

            var html = '<div id="del' + delid + '" class="row justify-content-center w3-animate-left" style="margin-bottom: 10px;">\
                <div class="col-sm-2 p-2">\
                    <div class="">\
                        <button id="delbtn" did="del' + delid + '" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></button>\
                    </div>\
                </div>\
                <div class="col-sm-2 p-2">\
                    <div class="">\
                        <?php echo form_input('grade[]', isset($result->grade) ? $result->grade : '', 'id="grade_"  class="form-control" placeholder="E.g A" did="del' . $i . '" '); ?>\
                        <?php echo form_error('grade'); ?>\
                    </div>\
                </div>\
                <div class="col-sm-2 p-2">\
                    <div class="">\
                        <input type="number" name="minimum_marks[]" min="0" max="100" value="<?php echo isset($result->minimum_marks) ? $result->minimum_marks : '' ?>" class="form-control" id="minimum_marks_">\
                        <?php echo form_error('minimum_marks'); ?>\
                    </div>\
                </div>\
                <div class="col-sm-2 p-2">\
                    <div class="">\
                        <input type="number" name="maximum_marks[]" min="0" max="100" value="<?php echo isset($result->maximum_marks) ? $result->maximum_marks : '' ?>" class="form-control" id="maximum_marks_">\
                        <?php echo form_error('maximum_marks'); ?>\
                    </div>\
                </div>\
                <div class="col-sm-2 p-2">\
                    <div class="">\
                        <input type="number" min="0" max="12" name="points[]" value="<?php echo isset($result->points) ? $result->points : '' ?>" class="form-control" id="points_">\
                        <?php echo form_error('points'); ?>\
                    </div>\
                </div>\
                <div class="col-sm-2 p-2">\
                    <div class="">\
                        <?php echo form_input('comment[]', isset($result->comment) ? $result->comment : '', 'id="comment_"  class="form-control" placeholder="E.g Excellent" did="del' . $i . '" '); ?>\
                        <?php echo form_error('comment'); ?>\
                    </div>\
                </div>\
            </div>';

            $("#gradesdiv").append(html);
        })

        //Handle removal of grade fileds
        $(document).on('click', '#delbtn', function(e) {
            var selected = $(this).attr('did');
            // console.log(selected);

            e.preventDefault();
            // $('#gradesform').find(`input[did='${selected}']`).each(function(i){
            //     console.log($(this).attr('did'));
            //     // $(this).hide();
            // })

            $('#gradesform').find(`div[id='${selected}']`).each(function(i) {
                console.log($(this).attr('id'));
                $(this).hide();
            })

        })

    })
</script>