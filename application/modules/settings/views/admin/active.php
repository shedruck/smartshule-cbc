<div class="row">         
    <div class="col-md-4 middle">
        <div class="informer">
            <a href="#">
                <span class="title"><?php echo $ct->total_count; ?></span>
                <span class="text">SMS Available</span>
            </a>
        </div>
        <hr>
        <div class="informer  ">
            <a href="#">
                <span class="title">0<?php //echo $ct ? $ct : '0';  ?></span>
                <span class="text">Total SMS Sent</span>
            </a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="widget" >
            <div class="head dark">
                <div class="icon"><i class="icos-meter-fast"></i></div>
                <h2>Paste SMS CODE</h2>
                <ul class="buttons">                                                        
                    <li><a href="#"><span class="icos-cog"></span></a></li>
                </ul>                          
            </div>

            <div class="block-fluid"  style="height: 275px;   background: #FFF; border: 1px solid #CCC ;">
                <?php
                      $attributes = array('class' => 'form-horizontal', 'id' => '');
                      echo form_open_multipart('admin/settings/parse_sm', $attributes);
                ?>
                <div class='form-group'>
                    <hr>
                    <div class="col-md-10">
                        <?php
                              $data = array(
                                  'name' => 'sm_code',
                                  'id' => 'sm_code',
                                  'cols' => '160',
                                  'style' => 'height:160px;',
                                  'class' => 'form-control',
                              );
                              echo form_textarea($data);
                              echo form_error('sm_code');
                        ?>
                        <hr>
                        <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-blue btn-small'"); ?>
                    </div>
                </div>

                <?php echo form_close(); ?>
                <div class="clearfix"></div>            

            </div>                    
        </div>
    </div>

</div>