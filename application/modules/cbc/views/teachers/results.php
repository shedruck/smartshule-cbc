<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start"><?php echo $thread->name ?></h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <a href="<?php echo base_url('cbc/trs/joint_reports') ?>" class="btn btn-sm btn-primary">All Threads</a>
                    <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <!-- <div class="row justify-content-center"> -->
                <div class="table-responsive">
                    <table id="datatable-basic" class="table table-bordered">
                        <thead class="bg-light">
                            <th>#</th>
                            <th>Class</th>
                            <th><?php echo lang('web_options'); ?></th>
                        </thead>
                        <tbody>
                           <?php 
                                $i = 0;
                                foreach ($this->classes as $key => $level) {
                                $i++;
                           ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $level ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a type="button" class="btn btn-info">Reports Forms</a>
                                            <a type="button" class="btn btn-primary">Analyze</a>
                                            <a type="button" href="<?php echo base_url('cbc/trs/sync/'.$key.'/'.$thread->id) ?>" class="btn btn-success">Synchronize</a>
                                        </div>
                                    </td>
                                </tr>
                           <?php } ?>
                        </tbody>

                    </table>
                </div>
                <!-- </div> -->

                <!-- Add Modal Start -->
                <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="inputModalLabel">Add Results Thread</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                $attributes = array('class' => 'form-horizontal', 'id' => '');
                                echo   form_open_multipart(current_url(), $attributes);
                                ?>
                                <div class="row m-2">
                                    <label class="col-md-3 form-label" for='title'>Title <span class='required'>*</span></label>
                                    <div class="col-md-9">
                                        <?php echo form_input('exam', $result->exam, 'id="exam"  class="form-control" required'); ?>
                                        <?php echo form_error('exam'); ?>

                                    </div>
                                </div>


                                <div class="row m-2">
                                    <label for='term' class="col-md-3 form-label"> Term <span class='required'>*</span></label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <?php
                                            $terms = array('1' => 'Term 1', '2' => 'Term 2', '3' => 'Term 3');
                                            echo form_dropdown('term', array('' => 'Select Term') + $terms, (isset($result->term)) ? $result->term : '', ' class="form-control select" id="term" data-placeholder="" required');
                                            ?>
                                            <?php echo form_error('term'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-2">
                                    <label for='year' class="col-md-3 form-label"> Year <span class='required'>*</span></label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <?php

                                            $currentYear = date('Y');
                                            $years = range(2022, $currentYear);
                                            $years = array_reverse($years);


                                            $yearsAssoc = array_combine($years, $years);

                                            // Add default option
                                            $options = array('' => 'Select Year') + $yearsAssoc;

                                            echo form_dropdown('year', array('' => 'Select Year') + $options, (isset($result->year)) ? $result->year : '', ' class="form-control select" id="term" data-placeholder="" required');
                                            ?>
                                            <?php echo form_error('year'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <!-- Add Modal End -->

                <!-- Edit Thread Modal -->
                <?php
                foreach ($threads as $th) {
                ?>
                    <div class="modal fade" id="editModal_<?php echo $th->id ?>" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="inputModalLabel">Edit Result Thread</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                        $attributes = array('class' => 'form-horizontal', 'id' => '');
                                        echo   form_open_multipart('cbc/trs/edit_thread', $attributes);
                                    ?>
                                    <input type="hidden" value="<?php echo $th->id ?>" name="tid" id="tid">
                                    <div class="row m-2">
                                        <label class="col-md-3 form-label" for='title'>Title <span class='required'>*</span></label>
                                        <div class="col-md-9">
                                            <?php echo form_input('exam', $th->name, 'id="exam"  class="form-control" required'); ?>
                                            <?php echo form_error('exam'); ?>
                                        </div>
                                    </div>


                                    <div class="row m-2">
                                        <label for='term' class="col-md-3 form-label"> Term <span class='required'>*</span></label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <?php
                                                $terms = array('1' => 'Term 1', '2' => 'Term 2', '3' => 'Term 3');
                                                echo form_dropdown('term', array('' => 'Select Term') + $terms, (isset($th->term)) ? $th->term : '', ' class="form-control select" id="term" data-placeholder="" required');
                                                ?>
                                                <?php echo form_error('term'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2">
                                        <label for='year' class="col-md-3 form-label"> Year <span class='required'>*</span></label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <?php

                                                $currentYear = date('Y');
                                                $years = range(2022, $currentYear);
                                                $years = array_reverse($years);


                                                $yearsAssoc = array_combine($years, $years);

                                                // Add default option
                                                $options = array('' => 'Select Year') + $yearsAssoc;

                                                echo form_dropdown('year', array('' => 'Select Year') + $options, (isset($th->year)) ? $th->year : '', ' class="form-control select" id="term" data-placeholder="" required');
                                                ?>
                                                <?php echo form_error('year'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <!-- Edit Thread Modal End -->

            </div>
            <div class="card-footer">
                <div class="form-check d-inline-block">
                    <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
                </div>
                <div class="float-end d-inline-block btn-list">

                </div>
            </div>
        </div>
    </div>

    <!-- Offright Canvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
        <div class="offcanvas-header">
            <h6 class="fw-bold offcanvas-title">Assigned <span id="cls"></span> Subjects</h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fe fe-x fs-18"></i></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <h6 class="mb-3 fw-bold" id="class_name"></h6>
                <ul class="list-group list-group-flush border">
                    <div class=" mb-2" id="myload" style="display: none; border:none">
                        <div class="s-body d-flex justify-content-center align-items-center flex-wrap gap-1">
                            <span class="me-0">
                                <svg id="myloader" xmlns="http://www.w3.org/2000/svg" height="60" width="60" data-name="Layer 1" viewBox="0 0 24 24">
                                    <path fill="#05c3fb" d="M12 1.99951a.99974.99974 0 0 0-1 1v2a1 1 0 1 0 2 0v-2A.99974.99974 0 0 0 12 1.99951zM12 17.99951a.99974.99974 0 0 0-1 1v2a1 1 0 0 0 2 0v-2A.99974.99974 0 0 0 12 17.99951zM21 10.99951H19a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2zM6 11.99951a.99974.99974 0 0 0-1-1H3a1 1 0 0 0 0 2H5A.99974.99974 0 0 0 6 11.99951zM17.19629 8.99951a1.0001 1.0001 0 0 0 .86719.5.99007.99007 0 0 0 .499-.13428l1.73145-1a.99974.99974 0 1 0-1-1.73144l-1.73145 1A.9993.9993 0 0 0 17.19629 8.99951zM6.80371 14.99951a.99936.99936 0 0 0-1.36621-.36572l-1.73145 1a.99974.99974 0 1 0 1 1.73144l1.73145-1A.9993.9993 0 0 0 6.80371 14.99951zM15 6.80371a1.0006 1.0006 0 0 0 1.36621-.36621l1-1.73193a1.00016 1.00016 0 1 0-1.73242-1l-1 1.73193A1 1 0 0 0 15 6.80371zM3.70605 8.36523l1.73145 1a.99007.99007 0 0 0 .499.13428.99977.99977 0 0 0 .501-1.86572l-1.73145-1a.99974.99974 0 1 0-1 1.73144zM9 17.1958a.99946.99946 0 0 0-1.36621.36621l-1 1.73194a1.00016 1.00016 0 0 0 1.73242 1l1-1.73194A1 1 0 0 0 9 17.1958zM20.294 15.63379l-1.73145-1a.99974.99974 0 1 0-1 1.73144l1.73145 1a.99.99 0 0 0 .499.13428.99977.99977 0 0 0 .501-1.86572zM16.36621 17.562a1.00016 1.00016 0 1 0-1.73242 1l1 1.73194a1.00016 1.00016 0 1 0 1.73242-1z"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div id="data-container">
                        <li class="list-group-item d-flex justify-content-between align-items-center pe-2">
                            <span class="d-inline-flex align-items-center">
                                <i class="fe fe-check text-primary me-2" aria-hidden="true"></i><?php echo strtoupper($cl->name); ?></span>
                            <div class="form-check form-switch</a>">

                            </div>
                        </li>


                    </div>

                </ul>
            </div>

        </div>
    </div>
    <!-- Offright Canvas End-->
</div>
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
</style>
<script>
    $(document).ready(function() {
        <?php
        $i = 0;
        foreach ($students as $s) {
        ?>
            $("#clsbtn_<?php echo $s->id ?>").click(function() {
                var val = $(this).val();
                $("#cls").text(val);

                $("#data-container").html('<?php echo $s->title; ?>');

                $('#data-container li').removeClass('text-black');
                $('#data-container li').addClass('list-group-item d-flex justify-content-between align-items-center pe-2');
            });

        <?php } ?>
    });

    // function showClass(cls) {
    //     console.log(cls);
    // }
</script>