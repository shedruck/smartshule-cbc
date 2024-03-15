<div class="row">  
    <div class="profile clearfix col-md-4 botfix">
        <div class="image">
            <?php
            $dys = 0;
            $padl = new Padl\License(true, true, true, true);
            if ($key)
            {
                    $license = $padl->validate($key->license);
                    
                    $lc = (object) $license;
                    if ($lc->RESULT == 'OK')
                    {
                            $this->load->library('Dates');
                            $first = $this->dates->createFromTimeStamp(now());
                            $dt = $this->dates->createFromTimeStamp($lc->DATE['END']);
                            $dys = $dt->diffInDays($first);
                    }
            }

            echo theme_image('us.jpg', array('class' => "img-polaroid"));
            ?> 
        </div>                        
        <div class="info-s">
            <h2>License Status</h2>
            <?php
            if (isset($lc) && $lc->RESULT == 'OK')
            {
                    ?>
                    <p><strong>Start:</strong> <?php echo $lc->DATE['HUMAN']['START']; ?></p>
                    <p><strong>Expiry:</strong><?php echo $lc->DATE['HUMAN']['END']; ?></p>
                    <p><strong>Key:</strong> <?php echo $lc->ID; ?></p>
            <?php } ?>
            <div class="status"><?php echo isset($lc->RESULT) ? $lc->RESULT : ' Key not Found'; ?></div>
        </div>

    </div>
    <div class="col-md-8 middle">
        <div class="informer">
            <a href="#">
                <span class="title"><?php echo $dys; ?></span>
                <span class="text">Days Remaining</span>
            </a>
        </div>  

    </div>

</div>
<div class="row">

    <div class="col-md-6">
        <div class="widget" >
            <div class="head dark">
                <div class="icon"><i class="icos-star3"></i></div>
                <h2>My Licenses</h2>
                <ul class="buttons">                                                        
                    <li>
                        <a href="#"><span class="icos-cog"></span></a>
                        <ul class="dropdown-menu">
                            <li> <?php echo $padl->id_me() ?> </li>

                        </ul>                                
                    </li>
                </ul>

            </div>

            <div class="block-fluid"  style="height: 355px;   background: #FFF; border: 1px solid #CCC ;">

                <ul class="list tickets">
                    <?php
                    foreach ($keys as $k)
                    {
                            $lcc = $padl->validate($k->license);
                            $ccs = '';
                            $xt = 0;
                            if ($key && $key->id == $k->id)
                            {
                                    $ccs = 'done';
                                    $xt = 1;
                            }
                            $lck = (object) $lcc;
                            ?>
                            <li class="<?php echo $lck->RESULT == 'OK' ? $ccs : 'new'; ?> clearfix" id="T213">
                                <div class="title">
                                    <a href="#"><?php
                                        echo 'License-' . str_pad($k->id, 3, '0', 0);
                                        echo ' ' . $lck->RESULT
                                        ?>
                                    </a>
                                    <p><?php
                                        if (isset($lck->DATE['HUMAN']['END']))
                                        {

                                                if ($lck->RESULT == 'ILLEGAL')
                                                {
                                                        echo 'License Cant be used on this Client';
                                                }
                                                elseif ($lck->RESULT == 'OK')
                                                {
                                                        echo 'Valid Upto: ' . $lck->DATE['HUMAN']['END'];
                                                }
                                                else
                                                {
                                                        echo 'This key is Invalid';
                                                }
                                        }
                                        else
                                        {
                                                echo 'This key is Invalid';
                                        }
                                        ?>
                                    </p>
                                </div>
                                <?php
                                if (!$xt)
                                {
                                        ?>
                                        <div class="actions">
                                            <a href="#" class="tip" title="" data-original-title="Make Default"><span class="glyphicon glyphicon-pencil"></span></a> 
                                        </div>
                                <?php } ?>
                            </li>
                    <?php } ?>
                </ul>                        

            </div>                    
        </div>

    </div>

    <div class="col-md-6">
        <div class="widget" >
            <div class="head dark">
                <div class="icon"><i class="icos-meter-fast"></i></div>
                <h2>Add New License  </h2>
                <ul class="buttons">                                                        
                    <li><a href="#"><span class="icos-cog"></span></a></li>
                </ul>                          
            </div>

            <div class="block-fluid"  style="height: 355px;   background: #FFF; border: 1px solid #CCC ;">

                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open_multipart(current_url(), $attributes);
                ?>
                <div class='form-group'>
                    <hr>
                    <div class="col-md-10">
                        <?php
                        $data = array(
                            'name' => 'license',
                            'id' => 'license',
                            'cols' => '160',
                            'style' => 'height:210px;',
                            'class' => 'form-control',
                        );
                        echo form_textarea($data);
                        echo form_error('license');
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