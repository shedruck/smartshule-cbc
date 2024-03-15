<?php
$class_id = $class ? $class->id : 0;
$teacher_id = $teacher ? $teacher->id : 0;
$class_name = '';
if ($this->session->flashdata('fill') == 2)
{
    $fill = $this->session->flashdata('form');

    $tr = $fill['teacher'];
    $cll = $fill['class'];
    $mode = $fill['type'];
}
else
{
    $tr = $this->input->post('teacher');
    $cll = $this->input->post('class');
    $mode = $this->input->post('mode') ? $this->input->post('mode') : 1;
}
$m1 = $mode == 1 ? 'checked' : '';
$m2 = $mode == 2 ? 'checked' : '';
?>
<div class="row hidden-print">
    <div class="btn-group pull-right" role="group">
        <button class="btn btn-success" onClick="window.location='<?php echo base_url('admin/teachers/allocation_report')?>'">Allocation Report</button>
        <a href="<?php echo base_url('admin/teachers'); ?>" class="btn btn-primary ">Back</a>&nbsp;
    </div>
</div>

<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Assign Subjects</h2> 
    <div class="right">
    </div>
</div>
<?php
$list = [];
foreach ($this->classlist as $cl_id => $l)
{
    $list[$cl_id] = $l['name'];
}
if ($class)
{
    $class_name = $list[$class->id];
}
?>
<div class="toolbar">

    <div class="col-md-9"><br/>

        <?php echo form_open(current_url()); ?>
        Teacher:
        <?php echo form_dropdown('teacher', ['' => 'Select Teacher'] + $teachers, $tr, 'class ="select" '); ?>
        Class:
        <?php echo form_dropdown('class', ['' => 'Select Class'] + $list, $cll, 'class ="select" '); ?>

        <div class=" twg"><br/>
            <div class="col-md-3">Subjects: </div>
            <input type="radio" id="s1" name="mode" value="1" <?php echo $m1; ?>>
            <label for="s2" class="small"> 8.4.4 / IGCSE</label>
            <input type="radio" id="s2" name="mode" value="2" <?php echo $m2; ?>>
            <label for="s2" class="small">CBC</label>
        </div>
        <hr>
        <button class="btn btn-primary" type="submit">Submit</button>
        <?php echo form_close(); ?>
    </div>

</div>
<?php
if ($teacher)
{
    ?>
    <div class="block invoice">
        <h1> </h1>
        <div class="row">
            <div class="col-md-10">
                <h3>Teacher: <?php echo $teacher ? $teachers[$teacher->id] : ''; ?></h3>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="col-lg-4 col-md-12 col-sm-12 p-1">
                    <div>
                        <h3 class="font-large-1 grey darken-1 text-bold-400 ">Assigned Classes</h3>
                    </div>
                    <div class="card-content overflow-hidden">
                        <hr>
                        <div class="list-group">
                            <?php
                            if (!count($assigned->mine))
                            {
                                ?>
                                <a href="javascript:void(0)" class="list-group-item">
                                    <div class="media">
                                        <div class="media-left pr-1">
                                            <div class="alert alert-warning mb-2" role="alert">
                                                <strong>No</strong> Class Subjects Assigned
                                            </div>

                                        </div>

                                    </div>
                                </a>
                                <?php
                            }
                            else
                            {
                                $j = 0;
                                foreach ($assigned->mine as $k)
                                {
                                    $opts = $k->type == 1 ? $subjects : $cbc;
                                    $j++;
                                    ?>
                                    <a href="javascript:void(0)" class="list-group-item">
                                        <div class="media">
                                            <div class="media-left pr-1">
                                                <span class="avatar avatar-sm avatar-online rounded-circle">
                                                    <?php echo $j; ?>.</span>
                                            </div>
                                            <div class="media-body w-100">
                                                <h6 class="media-heading mb-0"><?php echo isset($list[$k->class]) ? $list[$k->class] : ' '; ?></h6>
                                                <p class="font-small-2 mb-0 text-muted"><?php echo isset($opts[$k->subject]) ? $opts[$k->subject] : ' '; ?></p>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 col-sm-12 border-right-blue-grey border-right-lighten-5">
                    <div>
                        <h3 class="text-center">Assign Subjects: <?php echo $class_name; ?></h3>
                    </div>
                    <div class="card-content overflow-hidden">
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'id' => '');
                        echo form_open_multipart(base_url('admin/teachers/assign_teacher/' . $teacher_id . "/" . $class_id . '/' . $mode), $attributes);
                        ?>
                        <table id="users-contacts" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle dataTable" role="grid" aria-describedby="users-contacts_info">
                            <thead>
                                <tr role="row">
                                    <th>#</th>
                                    <th>Subject</th>
                                    <th class="text-center">Assigned</th>
                                </tr>
                            </thead>
                            <tbody>   
                                <?php
                                $i = 0;
                                foreach ($assigned->subjects as $s)
                                {
                                    $check = $s->has ? ' checked="checked" ' : '';
                                    $i++;
                                    ?>
                                    <tr role="row">
                                        <td class="">
                                            <?php echo $i ?>.
                                        </td>
                                        <td>
                                            <div class="media">
                                                <div class="media-left pr-1">
                                                    <span class="avatar avatar-sm avatar-online rounded-circle">
                                                    </span>
                                                </div>
                                                <div class="media-body media-middle">
                                                    <?php echo $s->subject; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="sorting_1">
                                            <div class="icheckbox_square">
                                                <input name="set[<?php echo $s->id ?>]" type="checkbox" class="input-chk" <?php echo $check; ?>>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button class="btn btn-primary pull-right" name="post" value="2" type="submit"> Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<style>
    a.list-group-item
    {
        color: #428bca;
        font-weight: bold;
    }
    input[type=radio]
    {
        margin: 0 4px 0px 13px;
    }
</style>
<script>
    $(document).ready(
            function ()
            {
                $(".tsel").select2({'placeholder': 'Please Select', 'width': '220px'});
                $(".tsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.target.value);
                });

                $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                $(".fsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.target.value);
                });
            });
</script>
