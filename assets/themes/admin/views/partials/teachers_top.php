<div class="header hidden-print">
    <h2 class="toplogo"><?php echo $this->school->school; ?> </h2>
    <div class="buttons">
        <div class="popup" id="subNavControll">
            <div class="label"><span class="icos-list"></span></div>
        </div>
        <div class="dropdown">
            <div class="label">
                <img style="padding:1px;"src="<?php echo base_url('assets/themes/admin/img/us.jpg'); ?>" width="20" height="20" /> 
                <?php
                    $user = $this->ion_auth->get_user();
                    echo trim($user->first_name);
                ?> 
                <span class="glyphicon glyphicon-chevron-down glyphicon glyphicon-white"> </span>
            </div>
            <div class="body" style="width: 160px;">
                <div class="itemLink">
                    <a href="<?php echo base_url('admin/change_password'); ?>"><span class="glyphicon glyphicon-cog glyphicon glyphicon-white"></span> Change Password</a>
                </div>
                <div class="itemLink">
                    <a href="<?php echo base_url('admin/logout'); ?>"><span class="glyphicon glyphicon-off glyphicon glyphicon-white"></span> Logout</a>
                </div>                                        
            </div>                
        </div>
        <div class="popup">
            <?php /* ?>
            <div class="label"> | Switch Class <span class="glyphicon glyphicon-chevron-down glyphicon glyphicon-white"></span></div>
            <div class="body">
                <div class="arrow"></div>
                <div class="row">
                    <!--
                    <?php
                        $i = 0;
                        $classes = $this->ion_auth->list_classes();
                        $streams = $this->ion_auth->get_stream();
                    ?>-->
                </div>
            </div><?php */ ?>
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
