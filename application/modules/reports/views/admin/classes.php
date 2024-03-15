<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>View Class Report</h2> 
    <div class="right">                       
    </div>    					
</div>

<div class="toolbar">
    <div class="left">
        <?php echo form_open(current_url()); ?>
        <div class="input-append input-prepend">
            <div class="add-on">Select Class  </div>
            <?php echo form_dropdown('class', $classes, $this->input->post('class'), 'style="width: 236px;"'); ?>
            <button class="btn btn-primary"  type="submit">View Report</button>
        </div>
        <?php echo form_close(); ?>
    </div>

</div>
<div class="block invoice">
    <h1><?php
        if (!empty($streams))
        {
            $strt = isset($streams[$post->stream]) ? $streams[$post->stream] : '';
        }
        else
        {
            $strt = '';
        }
        echo $post->class_name . '  ' . $strt;
        ?></h1>
    <span class="date">Class Profile as at : <?php echo date('jS M Y'); ?></span>

    <div class="row">
        <div class="col-md-6">
            <h3>Class Teacher: <?php echo isset($teachers[$post->class_teacher]) ? $teachers[$post->class_teacher] : ''; ?></h3>
        </div>
        <div class="col-md-6">
            <h4>No. of students (<?php echo $size; ?>)</h4>
        </div>

    </div>

    <?php
    if ($post->description)
    {
        ?>
        <h3>Summary</h3>
        <p><?php echo $post->description; ?></p>
<?php } ?>

    <h3>Students</h3>

    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="30%">Name</th>
                <th width="20%">Admission Number</th>
                <th width="10%">Gender</th>
                <th width="5%"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $gender = array(1 => 'Male', 2 => 'Female');
            $i = 0;
            foreach ($students as $s)
            {
                $i++;
                if (!empty($s->old_adm_no))
                {
                    $adm = $s->old_adm_no;
                }
                else
                {
                    $adm = $s->admission_number;
                }
                ?>
                <tr>
                    <td><?php echo $i . '. '; ?></td>
                    <td><?php echo $s->first_name . ' ' . $s->last_name; ?></td>
                    <td><?php echo $adm; ?></td>
                    <td><?php echo isset($gender[$s->gender]) ? $gender[$s->gender] : ' '; ?></td>
                    <td> </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>