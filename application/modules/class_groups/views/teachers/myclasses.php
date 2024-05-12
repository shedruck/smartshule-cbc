<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">MY ASSIGNED CLASSES</h6>
                <div class="btn-group btn-group-sm float-end" role="group">

                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <!-- <div class="row justify-content-center"> -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-default">
                            <th>#</th>
                            <th>Class</th>
                            <th>Subjects Assigned</th>
                            <th>Students</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($students as $s) {
                                $i++;
                                $ct = $this->trs_m->get_teacher_classes();
                                $classteacherbg = "";
                                $classteachertxt = "";
                                if (in_array($s->id, $ct)) {
                                    $classteacherbg = "bg-default";
                                    $classteachertxt = ' - <b class="btn-danger btn-sm"> Class Teacher</b>'; 
                                }
                            ?>
                                <tr class="<?php echo $classteacherbg ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo strtoupper($s->name).$classteachertxt; ?></td>
                                    <td>
                                        <?php echo trim($s->title, ', '); ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('class_groups/trs/students/' . $s->id); ?>" class="btn btn-success btn-sm"><?php echo number_format($s->count); ?> Student<?php echo $s->count > 1 ? 's' : ''; ?> </a>
                                    </td>
                                </tr>
                            <?php } ?>
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