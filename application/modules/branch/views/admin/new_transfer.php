<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Branch </h2>
    <div class="right">

        <?php echo anchor('admin/branch', '<i class="glyphicon glyphicon-list">
        </i> ' . lang('web_list_all', array(':name' => 'Branch')), 'class="btn btn-primary"'); ?>

    </div>
</div>
<div class="block-fluid">
    <?php echo form_open(current_url()) ?>
    Select a Class
    <?php echo form_dropdown('class', array('' => '') + $classes, $this->input->post('class'), 'class="select select-2"') ?>
    <button class="btn btn-sm btn-primary">List Students</button>
    <?php echo form_close() ?>

    <?php if ($this->input->post()) {

        $user =  $this->ion_auth->get_user();
        $created_by = $user->first_name . ' ' . $user->last_name;
        echo form_open(base_url('admin/branch/send'));
    ?>

        <center>
            <h3>Transfer of Learners to <?php echo $branch->name ?></h3>
        </center>
        <input type="hidden" name="created_by" value="<?php echo $created_by ?>">
        <input type="hidden" name="branch" value="<?php echo $branch->id ?>">
        <table class="table table" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Admission No#</th>
                    <th>Student</th>
                    <th>Class</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($students as $s) {
                    $cl = $classes[$s->class] ? $classes[$s->class] : '';
                ?>

                    <tr>

                        <th><?php echo $index?></th>
                        <td><?php echo $s->admission_number ?></td>
                        <td><?php echo ucwords($s->first_name . ' ' . $s->middle_name . ' ' . $s->last_name) ?></td>
                        <td> <?php echo $cl ?></td>
                        <td>
                            <input type="checkbox" name="stds[]" value="<?php echo $s->id ?>" class="switchx check-lef">
                        </td>
                    </tr>
                <?php $index++;
                } ?>
            </tbody>

        </table>
        <hr>
        <input type="hidden" name="url" value="<?php echo base_url()?>" id="">
        <div class="col-md-12">
            <div class="col-md-4">
                <label>New Class (New Branch)</label>
                <select id="classes" class="select select-2" name="new_class">
                    <option>Please select...</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Term (New Branch)</label>
                <select class="select select-2" name="term">
                    <option>Please select...</option>
                    <?php
                    foreach ($this->terms as $key => $term) {
                        echo '<option value="' . $key . '">' . $term . '</option>';
                    }
                    ?>
                </select>
            </div>



            <div class="col-md-4">
                <label>Year</label>
                <?php
                echo form_dropdown('year', array('' => '') + $yrs, $this->input->post('year') ? $this->input->post('year') : date('Y'), ' class="select select-2" placeholder="Select Year" required ');
                ?>
            </div>

        </div>
        <br>
        <br>

        <button class="btn  btn-success right" type="submit" onclick="return confirm('Are you sure ?')">Transfer</button>
    <?php echo form_close();
    } ?>
</div>

<script>
    $(document).ready(
        function() {
            $(".tsel").select2({
                'placeholder': 'Please Select',
                'width': '140px'
            });
            $(".tsel").on("change", function(e) {

                notify('Select', 'Value changed: ' + e.added.text);
            });

            $(".fsel").select2({
                'placeholder': 'Please Select',
                'width': '100px'
            });
            $(".fsel").on("change", function(e) {

                notify('Select', 'Value changed: ' + e.added.text);
            });

            $(".checks").on('change', function() {
                $("input.check-lef").each(function() {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });

            $(".checkall").on('change', function() {
                $("input.check").each(function() {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });
            $.uniform.update();



            $.ajax({
                url: "<?php echo $branch->url . '/branch/classes' ?>",
                type: "POST",
                data: {
                    'branch': <?php echo $branch->id ?>
                },
                success: function(data) {
                    var res = $.parseJSON(data);

                    //append to class list
                    $('#classes').append(`${res}`);
                }
            });

        });
</script>

<style>
    .selected_rt {
        color: navy;
        background-color: green;
    }
</style>