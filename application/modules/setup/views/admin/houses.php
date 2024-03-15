<div class="block-fluid">
    <div class="head dark"> 
        <div class="icon"><span class="icosg-target1"></span> </div>
        <h2>  Houses  </h2>
        <div class="right">  
            <?php echo anchor('admin/setup/new_house/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'House')), 'class="btn btn-primary"'); ?>

        </div>
    </div>

    <?php if ($house): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Name</th>
                <th>Slogan</th>
                <th>Leader</th>
                <th>Description</th>	
                <th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                     $ts = $this->ion_auth->get_teachers();
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                        $i = ($this->uri->segment(4) - 1) * $per; 
                    }

                    foreach ($house as $p):
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i . '.'; ?></td>	
                            <td><?php echo $p->name; ?></td>
                            <td><?php echo $p->slogan; ?></td>
                            <td><?php echo isset($ts[$p->leader])?$ts[$p->leader] : ' -  '; ?></td>
                            <td><?php echo $p->description; ?></td>
                            <td width='90'>
                                <a href='<?php echo site_url('admin/setup/edit_house/' . $p->id . '/' . $page); ?>' class="btn btn-primary"><i class='glyphicon glyphicon-pencil'></i> Edit</a> 
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>

    <?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
    <?php endif ?>
</div>

<div class="pagination pagination-centered pagination-large">
    <?php echo anchor('admin/setup/subjects', '<i class="glyphicon glyphicon-circle-arrow-left"></i> Previous', 'class="btn btn-primary  btn-large"'); ?> 
    <?php echo anchor('admin/setup/finish', '<i class="glyphicon glyphicon-circle-arrow-right"></i> Next', 'title="5" id="nexti" class="btn btn-success  btn-large"'); ?>    
</div>

 