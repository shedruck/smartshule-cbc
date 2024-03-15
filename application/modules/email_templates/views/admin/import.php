<div class="row">
    <div class="col-md-12">

        <!-- Page Heading and Search -->
        <div class="page-header">
            <h1>Email Templates</h1>
        </div>
    </div><!--/span-->
</div><!--/row-->

<div class="row">
    <div class="col-md-12">
        <!-- Buttons -->
        <?php echo anchor('admin/email_templates/create', '<i class="glyphicon glyphicon-plus-sign"></i> Add New Item', ' class="btn btn-large btn-success green " '); ?>
        <?php echo anchor('admin/email_templates', '<i class="glyphicon glyphicon-th-list"></i> List All Items', ' class="btn btn-large red" '); ?>
        <?php echo anchor('admin/email_templates/export', '<i class="glyphicon glyphicon-download"></i> Export Records', ' class="btn btn-large btn-info blue" '); ?>
        <?php echo anchor('admin/email_templates/import', '<i class="glyphicon glyphicon-upload"></i> Import Records', ' class="btn btn-large btn-warning red" '); ?>
    </div><!--/span-->
    <div class="col-md-12">
        <p>&nbsp;</p>
    </div><!--/span-->
</div><!--/row-->
<div class="row">
    <div class="col-md-12">
        <!-- Pagination Links -->
        <div class="pagination">
            <?php if (!empty($pagination['links'])): ?>
                <?php echo $pagination['links']; ?>
            <?php endif; ?>
        </div>
    </div><!--/span-->
</div><!--/row-->

<div class="row">
    <div class="col-md-12">
        <!-- Paging Description and Field Selector -->
        <p>Showing from <span class="badge">100</span> to <span class="badge badge-info">150</span> of <span class="badge badge-success">233</span> Items</p>
    </div><!--/span-->
</div><!--/row-->
<div class="row">
    <div class="col-md-12">
        <?php echo form_open('admin/email_templates/action', ' id="form"  class="form-horizontal"'); ?> 
        <table class="table table-striped table-bordered table-condensed"> 
            <thead>
                <tr>
                    <td align="center"><input type="checkbox" class="checkall" /></td>
                    <th>Title</th>											<th>Slug</th>
                    <th class="width-10"><span>Actions</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                </tr>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $post->id); ?></td>
                        <td><?php echo $post->title ?></td>											<td><?php echo $post->slug ?></td>
                        <td>

                            <?php echo anchor('admin/email_templates/delete/' . $post->id, '<i class="glyphicon glyphicon-remove-circle"></i> Delete', ' class="btn btn-small btn-danger red" onclick="return confirm(\'Are you sure?\nThis Action is not Reversible!\')" '); ?> |
                            <?php echo anchor('admin/email_templates/edit/' . $post->id, '<i class="glyphicon glyphicon-edit"></i> Edit', ' class="btn btn-small btn-info blue"'); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tr>
            </tr>
        </table>
        <div class="form-actions">
            <button type="submit" name="btnAction" value="delete" class="btn btn-danger">Delete</button>
            <button type="submit" name="btnAction" value="publish" class="btn btn-warning">Publish</button>

        </div>
        <?php echo form_close(); ?>    
    </div><!--/span-->
</div><!--/row-->
