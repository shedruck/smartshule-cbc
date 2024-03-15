<div class="row">
    <div class="colw-2">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">CBC Assessment</h4>
            <hr>
            <span class="pull-right">
                &nbsp;&nbsp;&nbsp;
            </span>
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">#</th>
                            <th>Class</th>
                            <th>Population</th>
                            <th>Assessment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($classes as $class)
                        {
                            $ppt = $this->portal_m->count_students_per_class($class->id);
                            $studis = ' Students';
                            if ($ppt == 1)
                            {
                                $studis = ' Student';
                            }

                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?>.</td>
                                <td><?php echo $class->name; ?></td>
                                <td><?php echo $ppt . ' ' . $studis; ?> </td>
                                <td>
                                    <a href="<?php echo base_url('trs/cbc/assess/' . $class->id) ?>" class="btn btn-custom">Formative <i class="mdi mdi-arrow-right"></i></a>
                                    <a href="<?php echo base_url('trs/cbc/summative/' . $class->id) ?>" class="btn btn-custom">Summative  <i class="mdi mdi-arrow-right"></i></a>
									
									<a  class="btn btn-success" href="<?php echo base_url('trs/cbc/social_report/' . $class->id . '?s=1') ?>">Social Behaviour</a>
									
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> Print Report <span class="caret"></span> </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo base_url('trs/cbc/assess_report/' . $class->id) ?>">Assessment</a></li>
                                            <li><a href="<?php echo base_url('trs/cbc/summative_report/' . $class->id) ?>">Summative</a></li>
                                            <li></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 