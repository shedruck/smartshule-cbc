<?php $st = $this->portal_m->find($stud); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">
                    <b><?php echo $st->first_name . ' ' . $st->middle_name . ' ' . $st->last_name; ?></b>
                    <b>ADM No:</b> <?php echo isset($st->old_adm_no) ? $st->old_adm_no : $st->admission_number; ?>
                    <b class="pull-right1">Posted on:</b> <?php echo date('d/m/Y', $p->date); ?>
                </h6>
                <div class="float-end">
                    <a onclick="goBack()" href="#" class="btn btn-primary btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-edit"></i> Mark Next</a>

                    <a onclick="goBack()" href="#" class="btn btn-danger btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>

            </div>
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xl-8 col-sm-12">
                        <?php if ($p->status == 1) { ?>

                            <div class="">
                                <h6>DONE ASSIGNMENTS</h6>
                                <embed src="<?php echo base_url('uploads/' . $p->path . '' . $p->file); ?>" width="100%" height="400" class="tr_all_hover" type='application/pdf'>
                            </div>
                            <hr>

                            <div class="p-10">
                                <h6> MARKED ASSIGNMENTS</h6>
                                <?php if ($p->result) { ?>
                                    <embed src="<?php echo base_url('uploads/' . $p->result_path . '' . $p->result); ?>" width="100%" height="400" class="tr_all_hover" type='application/pdf'>
                                <?php } else { ?>
                                    <i> No file attached </i>
                                <?php } ?>
                            </div>

                            
                            <div class="p-20">
                                <h6>POINTS AWARDED</h6>
                                <div class='row'>
                                    <table class="table">
                                        <tr>
                                            <td><strong>Points Awarded</strong></td>
                                            <td> <?php echo $p->points ?> </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Out of</strong></td>
                                            <td> <?php echo $p->out_of ?> </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Percentage</strong></td>
                                            <td> <b class="text-red"><?php echo round(((float)$p->points * 100 / (float)$p->out_of), 2) ?> %</b> </td>
                                        </tr>
                                    </table>

                                </div>

                                <div class='form-group row'>
                                    <div class="col-md-12"><strong>Educator Comment: </strong></div>
                                    <hr>
                                    <div class="col-md-12">
                                        <?php echo $p->comment ?>
                                    </div>
                                </div>

                            </div>

                        <?php } else { ?>
                            <h6>
                                Done Assignments
                            </h6>
                            <embed src="<?php echo base_url('uploads/' . $p->path . '' . $p->file); ?>" width="100%" height="550" class="tr_all_hover" type='application/pdf'>

                        <?php } ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-12">
                        <h6>Assignment Marks</h6>
                        <?php
                        $attributes = array('class' => '', 'id' => '');
                        echo   form_open_multipart('assignments/trs/set_as_marked/' . $p->id . '/' . $st->id . '/' . $class . '/' . $this->session->userdata['session_id'], $attributes);
                        ?>
                        <div class='row m-2'>
                            <div class="col-md-12">Upload Marked: (Optional)</div>
                            <div class="col-md-12">
                                <input id='file' type='file' class="form-control" name='file' />
                            </div>
                        </div>
                        
                        <div class='row m-2'>
                            <div class="col-md-12">Points Awarded</div>
                            <div class="col-md-12">
                                <input type='text' name='points' id="points" value="<?php echo $p->points ?>" placeholder="E.g 20" class="form-control" required="required" />
                            </div>
                            
                            <div class="col-md-12">Out of </div>

                            <div class="col-md-12">
                                <input type='text' id="out_of" name='out_of' value="<?php echo $p->out_of ?>" placeholder="" class="form-control" required="required" />
                            </div>


                        </div>

                        <div class='row m-2'>
                            <div class="col-md-12">Comment: </div>
                            <div class="col-md-12">
                                <input type='text' name='ass_id' required="required" style="display:none" value="<?php echo $p->id ?>" />
                                <input type='text' name='student' required="required" style="display:none" value="<?php echo $p->student ?>" />
                                <textarea id="comment" rows="5" class="form-control " style="color:red" name="comment" /><?php echo $p->comment ?></textarea>
                            </div>
                        </div>


                        <div class="text-center">
                            <?php if ($p->status == 1) { ?>
                                <button type="submit1" class="btn btn-primary waves-effect ">Update</button>
                            <?php } else { ?>
                                <button type="submit1" class="btn btn-success waves-effect ">Submit</button>
                            <?php } ?>

                        </div>


                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!-- Card Closure down here -->
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>

<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>
<script>
    $(document).ready(function() {
        $("form").submit(function() {
            var points = $('#points').val();
            var out_of = $('#out_of').val();

            if (points > out_of) {

                swal({
                    title: "Hey Sorry!! ",
                    text: "Marks awaded can not be greater the total marks",
                    icon: "warning",
                    button: "Close",
                });

                return false;
            } else {
                var chk = confirm('Are you sure you want to submit your assignment?');
                if (chk == true) {
                    return true;
                } else {
                    return false;
                }

            }
        });


    })
</script>