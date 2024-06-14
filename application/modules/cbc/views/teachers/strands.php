<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><b>Subject: <?php echo $la->name; ?></b></h6>
        <div>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>

      <div class="row justify-content-center"> <!-- Centering the content horizontally -->
        <div class="col-md-7"> <!-- Taking 7 columns in medium-sized screens -->
          <div class="card">
            <div class="card-body p-2">
              <!-- Form Section -->
              <h5 class="m-t-0 m-b-10 header-title text-center text-uppercase">Add Strands</h5>
              <form class="form-horizontal form-main" role="form" action="<?php echo current_url(); ?>" method="POST">
                <div class="form-group" id="clone">
                  <label class="col-sm-3 control-label"> <B>STRAND NAME</B></label>
                  <div class="col-sm-9 rows">
                    <input type="text" name="name[]" class="form-control m-b-10 mt-2" placeholder="Name">
                    <input type="text" name="name[]" class="form-control m-b-10 mt-2" placeholder="Name">
                  </div>
                  <div class="text-center"><a href="javascript:" id="adder" class="btn-link"><strong>+ Add New Row </strong></a></div>
                </div>
            </div>
          </div>
        </div>
      </div>


      <div class="card-footer">
        <div class="form-group m-b-0">
          <div class="col-sm-offset-3 col-sm-12 text-end"> <!-- Changed to text-end for Bootstrap 5, float-end for Bootstrap 4 -->
            <button type="submit" class="btn btn-info"> <i class="fe fe-check-square me-1 lh-base"></i> Submit</button>
          </div>
        </div>
      </div>

      </form>
    </div>
  </div>
</div>


<div class="row mt-4">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body p-2">
        <div class="block-fluid">
          <table class="table table-bordered" width="100%">
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
                      <?php foreach ($p->topics as $s) : ?>
                        <li class="mt-1">
                          <?php echo $s->name; ?>
                          <a class="btn-link" href='<?php echo site_url('admin/cbc/edit_sub/' . $s->id . '/' . $la->id); ?>'> Edit</a>
                          &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary btn-sm" title="Delete" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('cbc/trs/delete_substrand/' . $s->id . '/' . $la->id); ?>'> x </a>
                        </li>
                      <?php endforeach; ?>
                    </ol>
                  </td>
                  <td width='25%'>
                    <div class="btn-group" role="group" aria-label="Basic example">
                      <a class="btn btn-secondary btn-sm" href='<?php echo site_url('cbc/trs/delete_strand/' . $p->id . '/' . $la->id); ?>' onclick="return confirm('Are you sure to delete this record? It`s irreversible!!')">
                        <i class='glyphicon glyphicon-trash'></i> Delete
                      </a>
                      <a class="btn btn-info btn-sm" href='<?php echo site_url('cbc/trs/edit_strand/' . $p->id . '/' . $la->id); ?>'>
                        <i class='glyphicon glyphicon-edit'></i> Edit
                      </a>
                      <a class="btn btn-primary btn-sm" href='<?php echo site_url('admin/cbc/edit_la/' . $p->id); ?>'>
                        <i class='glyphicon glyphicon-edit'></i> Sub-Strands
                      </a>
                    </div>

                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  input.form-control {
    height: 36px !important;
  }

  .card-footer .text-end {}


  .card-footer .btn {
    margin-left: 10px;

  }
</style>
<script>
  $('#adder').click(function() {
    var clone = $('#clone .rows input.form-control:first').clone();
    clone.val('');
    $('#clone .rows').append(clone);
  });
</script>