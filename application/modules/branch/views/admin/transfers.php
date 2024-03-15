<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Transfers </h2>
    <div class="right">


        <?php echo anchor('admin/branch', '<i class="glyphicon glyphicon-arrow-left">
                </i> Back', 'class="btn btn-danger"'); ?>
    </div>
</div>


<div class="block-fluid">

    <table id='transfered' class='table table-bordered' style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Class</th>
                <th>Transferred To</th>
                <th>Date</th>
                <th>Authorized By</th>
                <th>Action</th>
            </tr>
        </thead>

    </table>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#transfered').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?php echo  base_url('admin/branch/get_transfers') ?>'
            },
            dom: 'lBfrtip',
            'columns': [{
                    data: 'index'
                },
                {
                    data: 'name'
                },
                {
                    data: 'class'
                },
                {
                    data: 'to'
                },
                {
                    data: 'date'
                },
                {
                    data: 'user'
                },
                {
                    data: null,
                    className: "",
                    orderable: false,
                    "mRender": function(data, type, row) {
                        return '<a class="btn btn-info btn-sm" target="_blank"  href="<?php echo base_url('admin/admission/view') ?>/' + data.student + '"  >Profile <i class="fa fa-info"></i></a>  <a class="btn btn-success btn-sm" target="_blank"  href="<?php echo base_url('admin/fee_payment/statement') ?>/' + data.student + '"  >Fee Statement <i class="fa fa-file"></i></a>';
                    }
                }
            ],
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5'
            ]
        });


    });
</script>