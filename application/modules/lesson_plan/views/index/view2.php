<a class="btn btn-danger hidden-print " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
<a class="btn btn-success hidden-print " onclick="window.print()"><i class="fa fa-print"></i>Print</a>

<div class="block-fluid table-responsive">
    <div class="row">
        <div class="col-xm-12">
            <div class="col-xm-4"></div>
            <div class="col-xm-4">
                <center>
                    <img src="<?php echo base_url('uploads/files/' . $this->school->document) ?>" style="width:80px">
                    <h4><?php echo $this->school->school ?></h4>
                    <h3>LESSON PLAN</h3>
                </center>
            </div>
            <div class="col-xm-3"></div>
        </div>
    </div>

    <?php if ($post) {
        $pop = $this->lesson_plan_m->count_students($post->Scheme->level);
    ?>
        <div class="row">
            <table width="100%" class="table table-bordered">
                <thead>
                    <tr>
                        <th>LEVEL/GRADE</th>
                        <th>LEARNING AREA/SUBJECT</th>
                        <th>DATE</th>
                        <th>TIME</th>
                        <th>ROLL</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="bb"><?php echo isset($this->classes[$post->Scheme->level]) ? $this->classes[$post->Scheme->level] : '' ?></td>
                        <td class="bb"><?php echo isset($subjects[$post->Scheme->subject]) ? $subjects[$post->Scheme->subject] : '' ?></td>
                        <td class="bb"><?php echo date('dS M Y', $post->created_on) ?></td>
                        <td class="bb"></td>
                        <td class="bb">
                            <table class="table table-bordered">
                                <tr>
                                    <td class="bb">Present</td>
                                    <td class="bb">Actual</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="bb"><?php echo $pop ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="">
                <table class="table table-bordered">
                    <tr>
                        <th>STRAND:</th>
                        <td><?php echo $post->Scheme->strand ?></td>
                    </tr>

                    <tr>
                        <th>SUB-STRAND:</th>
                        <td><?php echo $post->Scheme->substrand ?></td>
                    </tr>

                    <tr>
                        <th>SPECIFIC LEARNING OUTCOME:</th>
                        <td><?php echo $post->Scheme->specific_learning_outcomes ?></td>
                    </tr>

                    <tr>
                        <th>KEY ENQUIRY QUESTION(S):</th>
                        <td><?php echo $post->Scheme->key_inquiry_question ?></td>
                    </tr>

                    <tr>
                        <th>CORE COMPETENCES:</th>
                        <td><?php echo $post->core_competences ?></td>
                    </tr>

                    <tr>
                        <th>LEARNING RESOURCES:</th>
                        <td><?php echo $post->Scheme->learning_resources ?></td>
                    </tr>

                    <tr>
                        <th>ORGANISATION OF LEARNING:</th>
                        <td><?php echo $post->organisation ?></td>
                    </tr>

                    <tr>
                        <th>INTRODUCTION:</th>
                        <td><?php echo $post->introduction ?></td>
                    </tr>

                    <tr>
                        <th>LESSON DEVELOPMENT:</th>
                        <td>
                            <table class="table table-bordered">
                                <?php
                                foreach ($post->steps as $s) {
                                ?>
                                    <tr>
                                        <td>Step <?php echo $s->step ?></td>
                                        <td class="lt"><?php echo $s->description ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <th>Extended activity:</th>
                        <td><?php echo $post->extended_activity ?></td>
                    </tr>

                    <tr>
                        <th>CONCLUSION:</th>
                        <td><?php echo $post->conclusion ?></td>
                    </tr>

                    <tr>
                        <th>REFLECTION ON THE LESSON:</th>
                        <td><?php echo $post->reflection ?></td>
                    </tr>





                </table>
            </div>
        </div>
    <?php } else { ?>
        <pre>No lesson plan available!!</pre>
    <?php } ?>
</div>

<style>
    .bb {
        text-align: center;
    }

    .lt {
        text-align: left;
    }

    .phead {
        opacity: 0%;
    }
</style>