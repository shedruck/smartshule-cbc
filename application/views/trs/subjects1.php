<div class="row card-box table-responsive">
    
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">Subject Assigned</h4>
            <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject Code </th>
                            <th>Subject Name</th>
                            <th>Class</th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php
                            $index=1;
                            foreach($subjects as $value){
                                $class_id= $value->class;
                                $class= $this->streams[$class_id];
                                ?>
                            <tr>
                                <td><?php echo $index;?></td>
                                <td><?php echo $value->code?></td>
                                <td><?php echo ucfirst($value->name)?></td>
                                <td><?php echo $class?></td>
                               
                            </tr>
                        <?php $index++; }?>
                    </tbody>
                </table>
            </div> <!-- table-responsive -->
        </div> <!-- end card -->
    </div>
    <!-- end col -->
</div>


