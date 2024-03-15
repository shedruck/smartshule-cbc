<div class="header">
    <h2 class="toplogo"><?php echo $this->school->school;?> - School System</h2>
    <div class="buttons">
        <div class="popup" id="subNavControll">
            <div class="label"><span class="icos-list"></span></div>
        </div>
        <div class="dropdown">
            <div class="label">Account  <span class="glyphicon glyphicon-chevron-down glyphicon glyphicon-white"></span></div>
            <div class="body" style="width: 160px;">
                <div class="itemLink">
                    <a href="<?php echo base_url('admin/change_password');?>"><span class="glyphicon glyphicon-cog glyphicon glyphicon-white"></span> Change Password</a>
                </div>
                               
                <div class="itemLink">
                    <a href="<?php echo base_url('admin/logout'); ?>"><span class="glyphicon glyphicon-off glyphicon glyphicon-white"></span> Logout</a>
                </div>                                        
            </div>                
        </div>            

        <div class="popup">
            <div class="label">Switch Kid <span class="glyphicon glyphicon-chevron-down glyphicon glyphicon-white"></span></div>
            <div class="body">
                <div class="arrow"></div>
                <div class="row">
                    <?php
                    $i = 0;
                   // $picks = array('alexey', 'dmitry' );
                    $classes = $this->ion_auth->list_classes();
                    $streams = $this->ion_auth->get_stream();
                    foreach ($this->parent->kids as $k)
                    {
                        $usr = $this->ion_auth->get_user($k->user_id);
                        $ct = isset($classes[$k->class]) ? $classes[$k->class] : ' - ';
                        $st = isset($streams[$k->stream]) ? $streams[$k->stream] : ' - ';
                        ?>
                        <div class="userCard">
                            <div class="image">
                                <?php echo theme_image('examples/users/alexey.jpg', array('class' => "img-polaroid")); ?>
                            </div>
                            <div class="info-s">
                                <h3><?php echo trim($usr->first_name . ' ' . $usr->last_name); ?></h3>
                                <p>&nbsp;</p>
                                <a href="<?php echo base_url('admin/?switch=' . $k->user_id); ?>" class="btn btn-primary" >  View</a>
                                <div class="informer">
                                    <?php echo $ct.' '.$st;   ?>
                                    <span>Adm. No. <?php echo $k->admission_number; ?></span>
                                </div>
                            </div>
                        </div> 
                        <?php
                        $i++;
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="popup">
            <div class="label"><span class="icos-cog"></span></div>
            <div class="body">
                <div class="arrow"></div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="top">Themes:</span>
                            <div class="themes">
                                <a href="#" data-theme="" class="tip" title="Default"><img src="<?php echo base_url('assets/themes/admin/img/themes/default.jpg'); ?>" /></a>                                    
                                <a href="#" data-theme="ssDaB" class="tip" title="DaB"><img src="<?php echo base_url('assets/themes/admin/img/themes/dab.jpg'); ?>" /></a>
                                <a href="#" data-theme="ssTq" class="tip" title="Tq"><img src="<?php echo base_url('assets/themes/admin/img/themes/tq.jpg'); ?>" /></a>
                                <a href="#" data-theme="ssGy" class="tip" title="Gy"><img src="<?php echo base_url('assets/themes/admin/img/themes/gy.jpg'); ?>" /></a>
                                <a href="#" data-theme="ssLight" class="tip" title="Light"><img src="<?php echo base_url('assets/themes/admin/img/themes/light.jpg'); ?>" /></a>
                                <a href="#" data-theme="ssDark" class="tip" title="Dark"><img src="<?php echo base_url('assets/themes/admin/img/themes/dark.jpg'); ?>" /></a>
                                <a href="#" data-theme="ssGreen" class="tip" title="Green"><img src="<?php echo base_url('assets/themes/admin/img/themes/green.jpg'); ?>" /></a>
                                <a href="#" data-theme="ssRed" class="tip" title="Red"><img src="<?php echo base_url('assets/themes/admin/img/themes/red.jpg'); ?>" /></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="top">Backgrounds:</span>
                            <div class="backgrounds">
                                <a href="#" data-background="bg_default" class="bg_default"></a>
                                <a href="#" data-background="bg_mgrid" class="bg_mgrid"></a>
                                <a href="#" data-background="bg_crosshatch" class="bg_crosshatch"></a>
                                <a href="#" data-background="bg_hatch" class="bg_hatch"></a>                                    
                                <a href="#" data-background="bg_light_gray" class="bg_light_gray"></a>
                                <a href="#" data-background="bg_dark_gray" class="bg_dark_gray"></a>
                                <a href="#" data-background="bg_texture" class="bg_texture"></a>
                                <a href="#" data-background="bg_light_orange" class="bg_light_orange"></a>
                                <a href="#" data-background="bg_yellow_hatch" class="bg_yellow_hatch"></a>                        
                                <a href="#" data-background="bg_green_hatch" class="bg_green_hatch"></a>                        
                            </div>
                        </div>          
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="top">Navigation:</span>
                            <input type="radio" name="navigation" id="fixedNav"/> Fixed 
                            <input type="radio" name="navigation" id="collapsedNav"/> Collapsible
                            <input type="radio" name="navigation" id="hiddenNav"/> Hidden
                        </div>                                
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>