<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Subject Categories </h2>
    <div class="right">
        <?php echo anchor('admin/subject_categories/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Subject Categories')), 'class="btn btn-primary"'); ?>
    </div>
</div>


<?php if ($subject_categories) : ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Category</th>
                    <th><?php echo lang('web_options'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
                    $i = ($this->uri->segment(4) - 1) * $per;
                }

                foreach ($subject_categories as $p) :
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>
                        <td><?php echo isset($this->classes[$p->class]) ? $this->classes[$p->class] : 'No class'?></td>
                        <td><?php echo isset($subjects[$p->subject]) ? $subjects[$p->subject] : '- '; ?></td>
                        <td><span class="label label-primary"><?php echo isset($categories[$p->category]) ? $categories[$p->category] : '- '; ?></span></td>
                        <td width='30'>
                            <div class='btn-group'>
                                <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                <ul class='dropdown-menu pull-right'>
                                    <li><a href='<?php echo site_url('admin/subject_categories/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
                                    <li><a onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/subject_categories/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

<?php else : ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>