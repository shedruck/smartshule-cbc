<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Cbc Fxx</h2>
    <div class="right">


        <?php echo anchor('admin/cbc/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Cbc')), 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/cbc', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Cbc')), 'class="btn btn-primary"'); ?>

    </div>
</div>


<?php if ($payload) : ?>
    <div class="block-fluid">
        <h2><?php 
            $id = $this->uri->segment(4);
        echo isset($subjects[$id]) ?  $subjects[$id] : ''?></h2>
        <?php echo form_open(current_url())?>
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Classes</th>
                    <th>ID</th>
                    <th><?php echo lang('web_options'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;

                foreach ($payload as $p) {
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>
                        <td><?php echo isset($this->classes[$p->class_id]) ? $this->classes[$p->class_id] : ''; ?></td>
                        <td><?php echo $p->id; ?></td>

                        <td width='30'>
                            <input type="checkbox"  name="items[<?php echo $p->id ?>]" value="<?php echo $p->id ?>">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>

        <hr>
        <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure?')">Remove Selected</button>

        <?php echo form_close()?>
    </div>

<?php else : ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>