<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Lesson Plan</h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <?php echo anchor('lesson_plan/trs/create', '<i class="fa fa-square-plus">
                    </i> ' . lang('web_add_t', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"'); ?>
                    <?php echo anchor('lesson_plan/trs', '<i class="fa fa-list">
                    </i> ' . lang('web_list_all', array(':name' => 'Lesson Plan')), 'class="btn btn-warning"'); ?>
                    <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <!-- <div class="row justify-content-center"> -->
                <div class="table-responsive">
                    <table id="datatable-basic" class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Strand</th>
                            <th>Substrand</th>
                            <th><?php echo lang('web_options'); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
                                $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                            }

                            foreach ($lesson_plan as $p) :
                                $sub =  isset($subjects[$p->Scheme->subject]) ? $subjects[$p->Scheme->subject] : '';
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>
                                    <td><?php echo $sub; ?></td>
                                    <td><?php echo $p->Scheme->strand; ?></td>
                                    <td><?php echo $p->Scheme->substrand; ?></td>

                                    <td width='30'>
                                        <div class="btn-group my-2">
                                            <button type="button" class="btn btn-success-light dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href='<?php echo site_url('record_of_work_covered/trs/create/' . $p->id . '/' . $p->scheme); ?>'><i class='fa fa-folder'></i> Add Record of work</a></li>

                                                <li><a class="dropdown-item" href='<?php echo site_url('lesson_plan/trs/lesson_steps/' . $p->id . '/' . $p->scheme); ?>'><i class='fa fa-file'></i> Lesson Steps</a></li>

                                                <li><a class="dropdown-item" href='<?php echo site_url('lesson_plan/trs/view/' . $p->id . '/' . $p->scheme); ?>'><i class='fa fa-file'></i> Print </a></li>

                                                <li><a class="dropdown-item" href='<?php echo site_url('lesson_plan/trs/edit/' . $p->id . '/' . $page); ?>'><i class='fa fa-edit'></i> Edit</a></li>

                                                <li><a class="dropdown-item" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('lesson_plan/trs/delete/' . $p->id . '/' . $page); ?>'><i class='fa fa-trash'></i> Trash</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>

                    </table>


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

                </div>
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