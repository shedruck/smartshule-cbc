
<div class="navigation">

    <ul class="main" >
        <li><a 
            <?php
            if (preg_match('/^(admin)$/i', $this->uri->uri_string()))
                echo 'class="active"';
            ?> href="<?php echo base_url('admin'); ?>" class="<?php if (preg_match('/^(admin)$/i', $this->uri->uri_string())) echo 'active'; ?>">
                <span class="icom-screen"></span><span class="text">Dashboard</span></a></li>
        <li>
            <a href="#ui" 
            <?php
            if (preg_match('/^(admin\/parent\/fees)/i', $this->uri->uri_string()) ||
                    preg_match('/^(admin\/parent\/performance)/i', $this->uri->uri_string()))
                echo 'class="active"';
            ?>>
                <span class="icom-bookmark"></span><span class="text">Academics</span></a></li>

        <li><a  class=" <?php
            if (preg_match('/^(admin\/parent\/sms)/i', $this->uri->uri_string()) ||
                    preg_match('/^(admin\/parent\/email)/i', $this->uri->uri_string())
            )
                echo 'active';
            ?>" href="#comm"><span class="icom-comments"></span><span class="text">Communication</span></a></li>
        <li><a  class = " <?php
            if (preg_match('/^(admin\/parent\/settings)/i', $this->uri->uri_string()))
                echo 'active';
            ?>" href="#other"><span class="icom-cog"></span><span class="text">Settings</span></a></li>
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
                    ?> </div>
                <ul class="menuList">
                    <!--<li><a href="<?php // echo base_url('logout');  ?>"><span class="glyphicon glyphicon-share-alt"></span> Logoff</a></li>                        -->
                </ul>
                <div class="text">
                    
                </div>
            </div>

            <div class="dr"><span></span></div>
            <ul class="fmenu">
                <li>
                    <a href="#">Total Students </a>
                    <span class="caption blue"><?php
                    $count = $this->ion_auth->count_students();
                    echo $count;
                    ?></span>
                </li>
            </ul>
            <div class="dr"><span></span></div>

        </div>

        <div id="ui">                
            <div class="menu">
                <a  <?php if (preg_match('/^(admin\/parent\/fee)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/parent/fee'); ?>"><span class="glyphicon glyphicon-home"></span> Classes</a>
                <a  <?php if (preg_match('/^(admin\/parent\/performance)/i', $this->uri->uri_string())) echo 'class="active"'; ?> href="<?php echo base_url('admin/parent/performance'); ?>"><span class="glyphicon glyphicon-calendar "></span> Full Calendar</a>
            </div>                                
        </div> 

        <div id="comm">
            <div class="menu">
                <a href="<?php echo base_url('admin/parent/sms'); ?>"><span class="glyphicon glyphicon-plus"></span> Add User</a>
                <a href="<?php echo base_url('admin/parent/email'); ?>"><span class="glyphicon glyphicon-list-alt"></span> list all Users</a>
            </div>
            <div class="dr"><span></span></div>

        </div>            
        <div id="other">
            <div class="dr"><span></span></div>
            <div class="menu">
                <a href="<?php echo base_url('admin/settings'); ?>"><span class="glyphicon glyphicon-off"></span> Settings</a>

            </div>
            <div class="dr"><span></span></div>
        </div>            

    </div>

</div>