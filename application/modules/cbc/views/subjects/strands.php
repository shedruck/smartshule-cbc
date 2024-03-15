<div class="col-md-12">
    <div class="page-header row">
        <div class="col-md-8">
            <h4 class="text-uppercase black"><b>Subject:</b> <?php echo $la->name; ?> </h4>
        </div>
        <div class="col-md-4">
            <a href="<?php echo base_url('admin/cbc/subjects'); ?>" class="pull-right btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
        </div>
    </div>
</div>
<div class="card-box">
    <h4 class="m-t-0 m-b-10 header-title text-center text-uppercase">Add Strands</h4>
    <form class="form-horizontal form-main" role="form" action="<?php echo current_url(); ?>" method="POST">
        <div class="form-group" id="clone">
            <label class="col-sm-3 control-label"> Name</label>
            <div class="col-sm-9 rows">
                <input type="text" name="name[]" class="form-control m-b-10" placeholder="Name">
                <input type="text" name="name[]" class="form-control m-b-10" placeholder="Name">
            </div>
            <div class="text-center"><a href="javascript:" id="adder" class="btn-link"><strong>+ Add New Row </strong></a></div>
        </div>

        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </div>
    </form>
</div>

<div class="block-fluid">
    <table class="table" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th colspan="2">Strands</th>
                <th></th>
                <th><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;

            
            foreach ($post as $p) :
                $i++;
            ?>
                <tr>
                    <td><?php echo $i . '.'; ?></td>
                    <td colspan="2"><?php echo $p->name; ?></td>
                    <td>
                        <ol>
                            <?php
                            foreach ($p->topics as $s) {
                            ?>
                                <li>
                                    <?php echo $s->name; ?>
                                    <a class="btn-link" href='<?php echo site_url('admin/cbc/edit_sub/' . $s->id . '/' . $la->id); ?>'> Edit</a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger btn-sm" title="Delete" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/cbc/delete_substrand/' . $s->id . '/' . $la->id); ?>'> X</a>
                                </li>
                            <?php } ?>
                        </ol>
                    </td>
                    <td width='20%'>
                        <a class="btn btn-danger" href='<?php echo site_url('admin/cbc/delete_strand/' . $p->id . '/' . $la->id); ?>' onclick="return confirm('Are you sure to delete this record? It`s irriversable!!')"><i class='glyphicon glyphicon-trash'></i> Delete</a>
                        <a class="btn btn-info" href='<?php echo site_url('admin/cbc/edit_strand/' . $p->id . '/' . $la->id); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
                        <div class='btn-group'>
                            <a class="btn btn-primary" href='<?php echo site_url('admin/cbc/edit_la/' . $p->id); ?>'><i class='glyphicon glyphicon-edit'></i> Sub-Strands</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<style>
    input.form-control {
        height: 36px !important;
    }
</style>
<script>
    $('#adder').click(function() {
        var clone = $('#clone .rows input.form-control:first').clone();
        clone.val('');
        $('#clone .rows').append(clone);
    });
</script>