<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            <b> Lesson Plan </b>
        </h3>
        <div class="pull-right">
            <?php echo anchor('lesson_plan/trs/create', '<i class="fa fa-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('lesson_plan/trs', '<i class="fa fa-list">
                </i> ' . lang('web_list_all', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"'); ?>
            <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>

        <div class="clearfix"></div>
        <hr>
    </div>

    <?php if ($lesson_plan) : ?>
        <div class="block-fluid">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-bordered">
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

        </div>

    <?php else : ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
    <?php endif ?>