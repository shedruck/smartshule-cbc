<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Class Performance Report</h2> 
    <div class="right">                       
    </div>    					
</div>

<div class="toolbar">
    <div class="left">
        <?php echo form_open(current_url()); ?>
        <div class="input-append input-prepend">
            <div class="add-on">Select Class  </div>
            <?php echo form_dropdown('class', $classes, $this->input->post('class'), 'style="width: 236px;"'); ?>
            <div class="add-on">Select Term  </div>
            <?php echo form_dropdown('term', $this->terms, $this->input->post('term'), 'style="width: 236px;"'); ?>
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
    <h3>Marks</h3>

    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="20%">Name</th>
                <?php foreach ($subjects as $sb):
                    ?> 
                    <th> <?php echo isset($list_subjects[$sb->subject_id]) ? $list_subjects[$sb->subject_id] : ''; ?> </th>
                <?php endforeach; ?>
                <th width="5%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($marks as $s)
            {
                $s = (object) $s;
                $i++;
                ?>
                <tr>
                    <td><?php echo $i . '. '; ?></td>
                    <td><?php echo isset($students[$s->student]) ? $students[$s->student] : ' - '; ?> </td>
                    <?php
                    foreach ($s->marks as $mk):
                        $mk = (object) $mk;
                        ?> 
                        <td><?php echo $mk->marks; ?></td>
                    <?php endforeach; ?>	
                    <td><?php echo $s->total; ?></td>
                </tr>
                <?php   }   ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>