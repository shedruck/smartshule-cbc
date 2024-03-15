<div class="navigation hidden-print">

    <ul class="main" >
        <li><a 
            <?php
            if (preg_match('/^(admin)$/i', $this->uri->uri_string()) || preg_match('/^(admin)$/i', $this->uri->uri_string())
            )
                    echo 'class="active"';
            ?> href="<?php echo base_url('admin'); ?>"  >
                <span class="icom-screen"></span><span class="text">Dashboard</span></a>
        </li>

        <?php
        foreach ($this->scope as $gr => $ss)
        {
                foreach ($ss as $title => $arra)
                {
                        $links = array();
                        foreach ($arra as $mn)
                        {
                                $mm = (object) $mn;
                                if (!in_array($mm->module, $links))
                                {
                                        $links[] = $mm->module;
                                }
                        }
                        $str = implode('|', $links);
                        ?>
                        <li><a 
                            <?php
                            if (preg_match('/^(admin\/(' . $str . '))/i', $this->uri->uri_string()))
                                    echo 'class="active"';
                            ?> href="#<?php echo $title; ?>" class="<?php if (preg_match('/^(admin\/' . $mm->module . ')/i', $this->uri->uri_string())) echo 'active'; ?>">

                                <?php
                                if ($title == 'Academics')
                                {
                                        echo " <span class='icom-bookmark'></span>";
                                }
                                elseif ($title == 'Administration')
                                {
                                        echo " <span class='icom-pencil3'></span>";
                                }
                                elseif ($title == 'Accounts')
                                {
                                        echo " <span class='icom-database'></span>";
                                }
                                elseif ($title == 'Library')
                                {
                                        echo " <span class='icom-book'></span>";
                                }
                                elseif ($title == 'Communication')
                                {
                                        echo " <span class='icom-videos'></span>";
                                }
                                elseif ($title == 'Reports')
                                {
                                        echo " <span class='icom-stats-up'></span>";
                                }
                                elseif ($title == 'Users')
                                {
                                        echo " <span class='icom-user'></span>";
                                }
                                elseif ($title == 'Settings')
                                {
                                        echo " <span class='icom-cog'></span>";
                                }
                                ?>

                                <span class="text"><?php echo $title; ?></span></a>
                        </li>
                        <?php
                }
        }
        ?>

    </ul>

    <div class="control"></div>        
    <div class="submain">

        <div id="default">
            <div class="widget-fluid userInfo clearfix">
                <div class="image" >
                    <img style="padding:1px;"src="<?php echo base_url('assets/themes/admin/img/member.png'); ?>" width="60" height="60" />
                </div>              
                <div class="name"><?php
                    $user = $this->ion_auth->get_user();
                    echo trim($user->first_name . ' ' . $user->last_name);
                    ?> </div>
                <ul class="menuList">
                    <li><a href="<?php echo base_url('admin/settings'); ?>"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                    <li><a href="<?php echo base_url('admin/sms'); ?>"><span class="glyphicon glyphicon-comment"></span> Messaging</a></li>
                    <li><a href="<?php echo base_url('admin/help'); ?>" target="_blank"><span class="glyphicon glyphicon-question-sign"></span> Help</a></li>
                    <li><a href="<?php echo base_url('admin/logout'); ?>"><span class="glyphicon glyphicon-share-alt"></span> Logout</a></li>                        
                </ul>
                </div>
            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <?php
                if ($this->acl->is_allowed(array('admission', 'create'), 1))
                {
                        ?>
                        <li>
                            <a href="<?php echo base_url('admin/admission'); ?>">Total Students </a>
                            <span class="caption blue"><?php
                                $count = $this->ion_auth->count_students();
                                echo $count;
                                ?></span>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/teachers'); ?>">All Teachers</a>
                            <span class="caption blue"><?php
                                $count = $this->ion_auth->count_teachers();
                                echo $count;
                                ?>
                            </span>
                        </li> 
                        <li>
                            <a href="<?php echo base_url('admin/parents'); ?>">Registered Parents</a>
                            <span class="caption blue"><?php
                                $count = $this->ion_auth->count_parents();
                                echo $count;
                                ?></span>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/users'); ?>">Administration Staff</a>
                            <span class="caption blue"><?php
                                $count = $this->ion_auth->count_administration();
                                echo $count;
                                ?></span>

                        </li>                         
                        <li>
                            <a href="<?php echo base_url('admin/school_classes'); ?>" >All Classes</a>
                            <span class="caption blue"><?php
                                $count = $this->ion_auth->count_classes();
                                echo $count;
                                ?></span>

                        </li> 
                        <li>
                            <a href="<?php echo base_url('admin/subjects'); ?>">All Subjects</a>
                            <span class="caption blue"><?php
                                $count = $this->ion_auth->count_subjects();
                                echo $count;
                                ?></span>

                        </li>	
                        <li>
                            <a href="<?php echo base_url('admin/class_rooms'); ?>">All Class Rooms </a>
                            <span class="caption blue"><?php
                                $count = $this->ion_auth->count_class_rooms();
                                echo $count;
                                ?></span>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/admission'); ?>">All Events </a>
                            <span class="caption blue"><?php
                                $count = $this->ion_auth->count_events();
                                echo $count;
                                ?></span>
                        </li>                       
                                              <li>
                            <a href="<?php echo base_url('admin/sms'); ?>">All SMS'</a>
                            <span class="caption blue"><?php echo $this->ion_auth->count_sms(); ?></span>

                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/admission'); ?>">All Registered Users </a>
                            <span class="caption blue"><?php
                                $count = $this->ion_auth->count_users();
                                echo $count;
                                ?></span>
                        </li>
                <?php } ?>
            </ul>

            <div class="dr"><span></span></div>
        </div>

        <?php
        foreach ($this->scope as $gr => $ss)
        {
                foreach ($ss as $title => $arra)
                {
                        ?> <div id="<?php echo $title; ?>">                
                            <div class="menu">
                                <?php
                                if ($title == 'Administration')
                                {
                                        $links = array();
                                        $lib = array();
                                        $trans = array();
                                        foreach ($arra as $mn)
                                        {
                                                $mm = (object) $mn;
                                                if ((strpos($mm->module, 'book') !== FALSE ) || (strpos($mm->module, 'library') !== FALSE))
                                                {
                                                        $lib[] = $mm;
                                                }
                                                elseif ((strpos($mm->module, 'transport') !== FALSE))
                                                {
                                                        $trans[] = $mm;
                                                }
                                                else
                                                {
                                                        $links[] = $mm->module;
                                                        $soff = $mm->method == 'index' ? '' : '/' . $mm->method;
                                                        $preg = $mm->method == 'index' ? '' : '\/' . $mm->method;
                                                        ?>
                                                        <a <?php if (preg_match('/^(admin\/' . $mm->module . $preg . ')/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                                                            href="<?php echo base_url('admin/' . $mm->module . $soff); ?>">
                                                            <span class="<?php echo $mm->icon; ?> <?php if (preg_match('/^(admin\/' . $mm->module . '\/' . $mm->method . ')/i', $this->uri->uri_string())) echo 'glyphicon glyphicon-white'; ?>"></span> 
                                                            <?php echo $mm->title; ?></a>
                                                        <?php
                                                }
                                        }
                                        if (count($lib))
                                        {
                                                ?>
                                                <ul class="fmenu">
                                                    <li>
                                                        <a href="#"><span class="glyphicon glyphicon-folder-open"></span> Library <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                                                        <ul>
                                                            <?php
                                                            foreach ($lib as $bb)
                                                            {
                                                                    $boff = $bb->method == 'index' ? '' : '/' . $bb->method;
                                                                    $lpreg = $bb->method == 'index' ? '' : '\/' . $bb->method;
                                                                    ?>
                                                                    <li><a <?php if (preg_match('/^(admin\/' . $bb->module . $lpreg . ')/i', $this->uri->uri_string())) echo 'class="active"'; ?>href="<?php echo base_url('admin/' . $bb->module . $boff); ?>"><span class="glyphicon glyphicon-file-text"></span><?php echo $bb->title; ?></a></li>
                                                            <?php } ?>

                                                        </ul>
                                                    </li> 
                                                </ul>

                                                <?php
                                        }
                                        if (count($trans))
                                        {
                                                ?>
                                                <ul class="fmenu">
                                                    <li>
                                                        <a href="#"><span class="icosg-bus"></span> Transport <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                                                        <ul>
                                                            <?php
                                                            foreach ($trans as $tt)
                                                            {
                                                                    $boff = $tt->method == 'index' ? '' : '/' . $tt->method;
                                                                    $lpreg = $tt->method == 'index' ? '' : '\/' . $tt->method;
                                                                    ?>
                                                                    <li><a <?php if (preg_match('/^(admin\/' . $tt->module . $lpreg . ')/i', $this->uri->uri_string())) echo 'class="active"'; ?>href="<?php echo base_url('admin/' . $tt->module . $boff); ?>"><span class="glyphicon glyphicon-file-text"></span><?php echo $tt->title; ?></a></li>
                                                            <?php } ?>

                                                        </ul>
                                                    </li> 
                                                </ul>

                                                <?php
                                        }
                                }
                                else
                                {
                                        $links = array();
                                        $salo = array();
                                        $sales = array();
                                        $payr = array('salaries', 'record_salaries', 'advance_salary', 'deductions', 'allowances', 'tax_config');
                                        foreach ($arra as $mn)
                                        {
                                                $mm = (object) $mn;
                                                if (in_array($mm->module, $payr))
                                                {
                                                        $salo[] = $mm;
                                                }
                                                elseif ((strpos($mm->module, 'sales') !== FALSE))
                                                {
                                                        $sales[] = $mm;
                                                }
                                                else
                                                {
                                                        $links[] = $mm->module;
                                                        $soff = $mm->method == 'index' ? '' : '/' . $mm->method;
                                                        $preg = $mm->method == 'index' ? '' : '\/' . $mm->method;
                                                        ?>
                                                        <a  <?php if (preg_match('/^(admin\/' . $mm->module . $preg . ')/i', $this->uri->uri_string())) echo 'class="active"'; ?> 
                                                            href="<?php echo base_url('admin/' . $mm->module . $soff); ?>">
                                                            <span class="<?php echo $mm->icon; ?> <?php if (preg_match('/^(admin\/' . $mm->module . '\/' . $mm->method . ')/i', $this->uri->uri_string())) echo 'glyphicon glyphicon-white'; ?>"></span> 
                                                            <?php echo $mm->title; ?></a>
                                                        <?php
                                                }
                                        }

                                        if (count($sales))
                                        {
                                                ?>
                                                <ul class="fmenu">
                                                    <li>
                                                        <a href="#"><span class="glyphicon glyphicon-folder-open"></span> Sales <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                                                        <ul>
                                                            <?php
                                                            foreach ($sales as $slo)
                                                            {
                                                                    $sl = (object) $slo;
                                                                    $spoff = $sl->method == 'index' ? '' : '/' . $sl->method;
                                                                    $sreg = $sl->method == 'index' ? '' : '\/' . $sl->method;
                                                                    ?>
                                                                    <li><a <?php if (preg_match('/^(admin\/' . $sl->module . $sreg . ')/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/' . $sl->module . $spoff); ?>"><span class="glyphicon glyphicon-file-text"></span><?php echo $sl->title; ?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </li> 
                                                </ul>

                                                <?php
                                        }
                                        if (count($salo))
                                        {
                                                ?>
                                                <ul class="fmenu">
                                                    <li>
                                                        <a href="#"><span class="glyphicon glyphicon-folder-open"></span> Payroll <span style="background:none !important;" class="caption blue"><i class="glyphicon glyphicon-chevron-right"></i></span></a>
                                                        <ul>
                                                            <?php
                                                            foreach ($salo as $pnb)
                                                            {
                                                                    $pp = (object) $pnb;
                                                                    $poff = $pp->method == 'index' ? '' : '/' . $pp->method;
                                                                    $ppreg = $pp->method == 'index' ? '' : '\/' . $pp->method;
                                                                    ?>
                                                                    <li><a <?php if (preg_match('/^(admin\/' . $pp->module . $ppreg . ')/i', $this->uri->uri_string())) echo 'class="active"'; ?>href="<?php echo base_url('admin/' . $pp->module . $poff); ?>"><span class="glyphicon glyphicon-file-text"></span><?php echo $pp->title; ?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </li> 
                                                </ul>

                                                <?php
                                        }
                                }
                                ?></div>    
                            <div class="dr"><span></span></div>
                        </div>  
                        <?php
                }
        }
        ?> 

    </div>

</div> 
