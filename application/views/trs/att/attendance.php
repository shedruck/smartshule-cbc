<?php $avt = strtolower(substr($this->user->first_name, 0, 1)); ?>
<div class="row card-box table-responsive">
   

    <div class="col-md-12">
        <div class="card-bsox">
            <h4 class="header-title m-t-0 m-b-20">Record Attendance </h4>
			<hr>
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Population</th>
                        <th class="text-center" width=""> Option  </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($classes as $p):
					$ppt = $this->portal_m->count_students_per_class($p->id);
					 $studis = ' Students';
                        if ($ppt == 1)
                        {
                                $studis = ' Student';
                        }
					
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>	
                                <td><?php echo $p->name; ?> </td>
                                <td><?php echo $ppt.' '.$studis; ?> </td>
                                <td class="text-center">
                                    <a href="<?php echo base_url('trs/register/' . $p->id); ?>" class="btn btn-primary  waves-effect"><i class="mdi mdi-plus"></i>  Add New </a>
                                    <a href="<?php echo base_url('trs/list_register/' . $p->id); ?>" class="btn btn-warning  waves-effect"><i class="mdi mdi-account-search"></i> View </a>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>
</div>