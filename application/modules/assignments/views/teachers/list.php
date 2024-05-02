<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Class Assignments</h6>

            </div>
            <div class="card-body p-2">
                <!-- <table id="datatable-buttons" class="table table-striped table-bordered"> -->
                <table id="responsiveDataTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Class</th>
                            <th>Population</th>
                            <th class=""> Option </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($classes as $p) :
                            $ppt = $this->portal_m->count_students_per_class($p->id);
                            $studis = ' Students';
                            if ($ppt == 1) {
                                $studis = ' Student';
                            }
                            $i++;
                        ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>
                                <td><?php echo $p->name; ?></td>
                                <td><?php echo $ppt . ' ' . $studis; ?> </td>
                                <td class="">
                                    <a href="<?php echo base_url('assignments/trs/assign/' . $p->id); ?>" class="btn btn-primary  waves-effect"><i class="mdi mdi-plus"></i> Add New </a>
                                    <a href="<?php echo base_url('assignments/trs/list_assign/' . $p->id); ?>" class="btn btn-warning  waves-effect"><i class="mdi mdi-account-search"></i> View </a>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        $j = $i;
                        foreach ($extras as $e) :
                            $j++;
                        ?>
                            <tr>
                                <td><?php echo $j . '.'; ?></td>
                                <td><?php echo $e->title; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url('trs/assign_extra/' . $e->id); ?>" class="btn btn-primary  waves-effect"><i class="mdi mdi-plus"></i> Add New </a>
                                    <a href="<?php echo base_url('trs/list_extras/' . $e->id); ?>" class="btn btn-warning  waves-effect"><i class="mdi mdi-account-search"></i> View </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
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