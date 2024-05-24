<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="float-start">Messages & Feedback</h6>
                <div class="float-end" >
                    <a class="btn btn-primary btn-sm" href="<?php echo base_url('messages/trs/new_message'); ?>">
                        <i class="glyphicon glyphicon-plus"></i>
                        New Message
                    </a>
                    <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>

            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table id="datatable-basic" class="table table-bordered">
                        <thead class="bg-default">
                            <th>#</th>
                            <th>Title</th>
                            <th>Sent To</th>
                            <th>Date</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($messages as $m) {
                                $i++;
                                $get = $m->seen ? '' : '/?st=' . rand(10, 3000);
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>.

                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('messages/trs/view_message/' . $m->id . $get); ?>">
                                            <p class="title"><?php echo $m->seen ? $m->title : '<strong>' . $m->title . '</strong>'; ?></p>
                                        </a>
                                    </td>
                                    <td><?php echo $m->to; ?></td>
                                    <td><?php echo date('d-m-Y h:i A', $m->last); ?></td>
                                    <td>
                                        <a class="btn btn-info" href="<?php echo base_url('messages/trs/view_message/' . $m->id . $get); ?>"> View Responses</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
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