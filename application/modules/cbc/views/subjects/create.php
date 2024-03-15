<div class="col-md-9">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2> CBC Subjects  </h2>
        <div class="right"> 
            <?php echo anchor('admin/cbc/subjects', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='name'>Name <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('name', $result->name, 'id="name_"  class="form-control" '); ?>
                <?php echo form_error('name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='cat'>Type <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $ifr = [
                    '' => '',
                    0 => "Regular Subject",
                    1 => "Optional Subject",
                    2 => "Elective Subject"
                ];
                echo form_dropdown('cat', $ifr, (isset($result->cat)) ? $result->cat : '', ' class="qsel" placeholder="Select Subject Type" ');
                echo form_error('cat');
                ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-8  col-md-offset-3" ><h4>Assign Subject to Classes  </h4></div>
        </div>
        <div id="entry1" class="clonedInput"> 
            <div class='form-group '>
                <div class="col-md-6 col-md-offset-3">
                    <?php echo form_dropdown('class[]', $this->classes, '', 'id="class_" multiple class="xsel class_" placeholder="Select Classes" '); ?>
                    <?php echo form_error('class'); ?>
                </div>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
                <?php echo anchor('admin/cbc/subjects', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<script>
    $(document).ready(
            function ()
            {
                $(".qsel").select2({'placeholder': 'Please Select', 'width': '100%'});
                $(".fsel").select2({'placeholder': 'Please Select', 'width': '100%'});
                $(".fsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.target.value);
                });

                $(".xsel").select2({'placeholder': 'Please Select', 'width': '100%'});
                $(".xsel").on("change", function (e)
                {
                    notify('Select', 'Value changed: ' + e.target.value);
                });

            });
</script>