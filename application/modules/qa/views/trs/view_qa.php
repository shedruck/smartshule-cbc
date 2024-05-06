<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start"><?php echo $post->title ?> - Question and Answers</h6>
                <div class="float-end">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-folder"></i> Post Quiz to Students <span class="caret"></span> </button>
                        <ul class="dropdown-menu">
                            <h5 class="text-center"> MY CLASSES</h5>
                            <?php
                            foreach ($classes as $cl) {
                            ?>
                                <li>

                                    <button class="btn col-md-12 btn-sm " style="width:100% !important" width="100%" id="post_<?php echo $cl->id; ?>" value="<?php echo base_url('qa/trs/post_qa/' . $post->id . '/' . $cl->id . '/' . $this->session->userdata['session_id']) ?>"><i class='fa fa-caret-right'></i> <?php echo strtoupper($cl->name); ?></button>
                                    <hr>
                                </li>


                                <script>
                                    $(document).ready(function() {
                                        $("#post_<?php echo $cl->id; ?>").click(function() {

                                            var url = $("#post_<?php echo $cl->id; ?>").val();


                                            swal({
                                                    title: "Post Assignemnt",
                                                    text: "Are you sure you want to Post this assignment to the learners?",
                                                    icon: "warning",
                                                    buttons: true,
                                                    dangerMode: true,
                                                })
                                                .then((willDelete) => {
                                                    if (willDelete) {
                                                        window.location = url;
                                                        swal("Posting assignment please wait....");
                                                    } else {
                                                        //swal("Your imaginary file is safe!");
                                                    }
                                                });

                                        });



                                    })
                                </script>

                            <?php } ?>
                        </ul>
                    </div>

                    <?php echo anchor('qa/trs/given_quiz/' . $post->id . '/' . $this->session->userdata['session_id'], '<i class="fa fa-thumbs-up"></i> View Given Quiz', 'class="btn btn-primary btn-sm "'); ?>
                    <?php echo anchor('qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "'); ?>
                    <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>

            </div>
            <div class="card-body p-2">


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