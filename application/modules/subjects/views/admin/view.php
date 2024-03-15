<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Subject Overview  </h2>
        <div class="right"> 
             <?php echo anchor('admin/subjects/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?> 
             <?php echo anchor('admin/subjects', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>

    <div class="block">
        <div class="widget">
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="20%"> </th>
                        <th width="70"> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                         <?php
                             if ($result->sub_units)
                             {
                                  ?>
                                 <td rowspan="<?php echo count($result->subs); ?>">Sub Units</td>
                                 <?php
                                 foreach ($result->subs as $key => $varr)
                                 {
                                      ?>
                                      <td> <?php echo isset($varr['title']) ? $varr['title'] : ''; ?></td> </tr>
                                  <?php
                             }
                        }
                        else
                        {
                             ?> <td>Sub Units</td>
                                 <?php ?>
                         <td>0</td> </tr>        
                    <?php }
                ?>
                <tr>

                    <?php
                        if (count($result->classign))
                        {
                             ?>
                             <td rowspan="<?php echo count($result->classign); ?>">Classes</td>
                             <?php
                             foreach ($result->classign as $key => $value)
                             {
                                  ?>
                                  <td> <?php echo isset($this->classes[$key]) ? $this->classes[$key] : '-'; ?></td> </tr>
                              <?php
                         }
                    }
                    else
                    {
                         ?> <td>Classes</td>
                             <?php ?>
                         <td>0</td> </tr>        
                    <?php } ?>
                </tbody>
            </table>                    
        </div>

        <div class="clearfix"></div>
    </div>
</div>
