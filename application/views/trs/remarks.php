<div class="col-md-2 hidden-xs">&nbsp;</div>
<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Record Exams</h2>
    </div>
    <div class="block-fluid">

        <table class="table table-striped table-bordered  " >
            <!-- BEGIN -->
            <thead>
                <tr> 
                    <th width="3%">#</th>
                    <th width="">Student</th>
                    <th width="" >Action</th>
                </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
                <?php
                $i = 1;
                foreach ($students as $post):
                        $std = $this->worker->get_student($post->id)
                        ?>  
                        <tr>
                            <td>
                                <span id="reference" name="reference" class="heading-reference"><?php echo $i . '. '; ?></span>
                            </td> 
                            <td>
                                <?php echo $std->first_name . ' ' . $std->last_name; ?>
                            </td>
                            <td colspan="2">
                                <?php
                                echo anchor('trs/report/' . $exm . '/' . $class . '/' . $post->id, 'Edit Report', 'class="btn btn-primary"');
                                ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                endforeach;
                ?>		
            </tbody>
        </table>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
