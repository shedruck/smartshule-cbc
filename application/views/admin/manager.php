<div id="user-profile-2" class="user-profile row">
    <div class="tabbable">
        <ul class="nav nav-tabs padding-18">
            <li class="active">
                <a data-toggle="tab" href="#search">
                    <i class="green glyphicon glyphicon-search bigger-120"></i>
                    Quick Search
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#feed">
                    <i class="green glyphicon glyphicon-time bigger-120"></i>
                    Recent Activity
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#clips">
                    <i class="blue glyphicon glyphicon-film bigger-120"></i>
                    Radio & TV
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#print_media">
                    <i class="pink glyphicon glyphicon-paper-clip bigger-120"></i>
                    Print Media
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#client">
                    <i class="green glyphicon glyphicon-user bigger-120"></i>
                    Client Profile
                </a>
            </li>

        </ul>

        <div class="tab-content no-border padding-24">
            <div id="search" class="tab-pane in active">
                <div class="profile-feed row">

                    <div class="col-md-8">
                        <div class="widget-box">
                            <div class="widget-header no-border">
                                <h4>Quick Search</h4>

                                <span class="widget-toolbar transparent">
                                    <a href="#" data-action="collapse">    <i class="glyphicon glyphicon-chevron-up"></i>  </a>
                                </span>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <?php
                                    $attributes = array('class' => 'form-inline', 'id' => '');
                                    form_open_multipart(current_url(), $attributes);
                                    ?>
 
                                        <input type="text" class="input-small" placeholder="Email">
                                        <input type="password" class="input-small" placeholder="Password">
                                         <input data-rel="tooltip" type="text" id="form-field-6" placeholder="Tooltip on hover" 
                                                title="" data-placement="bottom" data-original-title="Hello Tooltip!">
                                        <button onclick="return false;" class="btn btn-info btn-small">
                                            <i class="glyphicon glyphicon-key bigger-110"></i>
                                            Login
                                        </button>
                                  <?php echo form_close();?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/span-->

                    <div class="col-md-4">
                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-edit btn-pink no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>
                                published a new blog post.
                                <a href="#">Read now</a>

                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    11 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
<?php echo theme_image('avatars/avatar5.png', array('class' => 'pull-left')); ?>
                                <a class="user" href="#"> Alex Doe </a>
                                upgraded his skills.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    12 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-key btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged in.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    12 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-off btn-inverse no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged out.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    16 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-key btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged in.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    16 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>
                    </div><!--/span-->
                </div><!--/row-->

                <div class="space-12"></div>

                <div class="center">
                    <a href="#" class="btn btn-small btn-blue">
                        <i class="glyphicon glyphicon-rss bigger-150 middle"></i>

                        View more activities
                        <i class="glyphicon glyphicon-on-right glyphicon glyphicon-arrow-right"></i>
                    </a>
                </div>
            </div><!--/#search-->

            <div id="client" class="tab-pane ">
                <div class="row">
                    <div class="col-md-3 center">
                        <span class="profile-picture">
<?php echo theme_image('avatars/profile-pic.jpg'); ?>
                        </span>

                        <div class="space space-4"></div>

                        <a href="#" class="btn btn-small btn-block btn-success">
                            <i class="glyphicon glyphicon-plus-sign bigger-110"></i>
<?php //echo $this->clientelle[$this->me_client]; ?>
                        </a>

                        <a href="#" class="btn btn-small btn-block btn-blue">
                            <i class="glyphicon glyphicon-envelope-alt"></i>
                            Client
                        </a>
                    </div><!--/span-->

                    <div class="col-md-9">
                        <h4 class="blue">
                            <span class="middle"><?php //echo $this->clientelle[$this->me_client]; ?></span>

                            <span class="label label-success arrowed-in-right">
                                <i class="glyphicon glyphicon-circle smaller-80"></i>
                                online
                            </span> 
                        </h4>

                        <div class="profile-user-info">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Username </div>

                                <div class="profile-info-value">
                                    <span>alexdoe</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Location </div>

                                <div class="profile-info-value">
                                    <i class="glyphicon glyphicon-map-marker light-orange bigger-110"></i>
                                    <span>Netherlands</span>
                                    <span>Amsterdam</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Age </div>

                                <div class="profile-info-value">
                                    <span>38</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Joined </div>

                                <div class="profile-info-value">
                                    <span>20/06/2010</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Last Online </div>

                                <div class="profile-info-value">
                                    <span>3 hours ago</span>
                                </div>
                            </div>
                        </div>

                        <div class="hr hr-8 dotted"></div>

                        <div class="profile-user-info">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Website </div>

                                <div class="profile-info-value">
                                    <a href="#" target="_blank">www.alexdoe.com</a>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">
                                    <i class="middle glyphicon glyphicon-facebook-sign bigger-150 blue"></i>
                                </div>

                                <div class="profile-info-value">
                                    <a href="#">Find me on Facebook</a>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">
                                    <i class="middle glyphicon glyphicon-twitter-sign bigger-150 light-blue"></i>
                                </div>

                                <div class="profile-info-value">
                                    <a href="#">Follow me on Twitter</a>
                                </div>
                            </div>
                        </div>
                    </div><!--/span-->
                </div><!--/row-->

                <div class="space-20"></div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-small">
                                <h4 class="smaller">
                                    <i class="glyphicon glyphicon-check bigger-110"></i>
                                    Little About Us
                                </h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <p>
<?php //echo $this->clientelle[$this->me_client]; ?> is a PR Company with a wide client base. We specialize in Brand 
                                        Creation, Advertising and Nextgen Marketing.
                                    </p>
                                    <p>
                                        The best thing about our job is that clients keep coming back with bigger commitments and thus we always have a lot to write home about.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-small header-color-blue2">
                                <h4 class="smaller">
                                    <i class="glyphicon glyphicon-windows bigger-120"></i>
                                    Monitored Companies
                                </h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main padding-16">
                                    <div class="row">


                                        <div class="grid3 center">
                                            <i class="glyphicon glyphicon-briefcase bigger-300 blue"></i>

                                            <div class="space-2"></div>
                                            Javascript/jQuery            Javascript/jQuery           Javascript/jQuery
                                        </div> 
                                        <div class="grid3 center">
                                            <i class="glyphicon glyphicon-briefcase bigger-300 blue"></i>

                                            <div class="space-2"></div>
                                            Javascript/jQuery            Javascript/jQuery           Javascript/jQuery
                                        </div> 
                                    </div>

                                    <div class="hr hr-16"></div>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!--#client-->

            <div id="feed" class="tab-pane">
                <div class="profile-feed row">
                    <div class="col-md-6">
                        <div class="profile-activity clearfix">
                            <div>
                                <img class="pull-left" alt="Alex Doe's avatar" src="assets/avatars/avatar5.png" />
                                <a class="user" href="#"> Alex Doe </a>
                                changed his profile photo.
                                <a href="#">Take a look</a>

                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    an hour ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <img class="pull-left" alt="Susan Smith's avatar" src="assets/avatars/avatar1.png" />
                                <a class="user" href="#"> Susan Smith </a>

                                is now friends with Alex Doe.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    2 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-ok btn-success no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>
                                joined
                                <a href="#">Country Music</a>

                                group.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    5 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-picture btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>
                                uploaded a new photo.
                                <a href="#">Take a look</a>

                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    5 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <img class="pull-left" alt="David Palms's avatar" src="assets/avatars/avatar4.png" />
                                <a class="user" href="#"> David Palms </a>

                                left a comment on Alex's wall.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    8 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>
                    </div><!--/span-->

                    <div class="col-md-6">
                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-edit btn-pink no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>
                                published a new blog post.
                                <a href="#">Read now</a>

                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    11 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <img class="pull-left" alt="Alex Doe's avatar" src="assets/avatars/avatar5.png" />
                                <a class="user" href="#"> Alex Doe </a>

                                upgraded his skills.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    12 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-key btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged in.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    12 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-off btn-inverse no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged out.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    16 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-activity clearfix">
                            <div>
                                <i class="pull-left thumbicon glyphicon glyphicon-key btn-info no-hover"></i>
                                <a class="user" href="#"> Alex Doe </a>

                                logged in.
                                <div class="time">
                                    <i class="glyphicon glyphicon-time bigger-110"></i>
                                    16 hours ago
                                </div>
                            </div>

                            <div class="tools action-buttons">
                                <a href="#" class="blue">
                                    <i class="glyphicon glyphicon-pencil bigger-125"></i>
                                </a>

                                <a href="#" class="red">
                                    <i class="glyphicon glyphicon-remove bigger-125"></i>
                                </a>
                            </div>
                        </div>
                    </div><!--/span-->
                </div><!--/row-->

                <div class="space-12"></div>

                <div class="center">
                    <a href="#" class="btn btn-small btn-blue">
                        <i class="glyphicon glyphicon-rss bigger-150 middle"></i>

                        View more activities
                        <i class="glyphicon glyphicon-on-right glyphicon glyphicon-arrow-right"></i>
                    </a>
                </div>
            </div><!--/#feed-->

            <div id="clips" class="tab-pane">
                <div class="profile-users clearfix">

                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>Domain</th>
                                <th>Price</th>
                                <th class="hidden-480">Clicks</th>

                                <th class="hidden-phone">
                                    <i class="glyphicon glyphicon-time bigger-110 hidden-phone"></i>
                                    Update
                                </th>
                                <th class="hidden-480">Status</th>

                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </td>

                                <td>
                                    <a href="#">ace.com</a>
                                </td>
                                <td>$45</td>
                                <td class="hidden-480">3,330</td>
                                <td class="hidden-phone">Feb 12</td>

                                <td class="hidden-480">
                                    <span class="label label-warning">Expiring</span>
                                </td>

                                <td>
                                    <div class="hidden-phone visible-desktop btn-group">
                                        <button class="btn btn-mini btn-success">
                                            <i class="glyphicon glyphicon-ok bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-info">
                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-danger">
                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-warning">
                                            <i class="glyphicon glyphicon-flag bigger-120"></i>
                                        </button>
                                    </div>

                                    <div class="hidden-desktop visible-phone">
                                        <div class="inline position-relative">
                                            <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                                <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                <li>
                                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                        <span class="blue">
                                                            <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                        <span class="green">
                                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                        <span class="red">
                                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </td>

                                <td>
                                    <a href="#">base.com</a>
                                </td>
                                <td>$35</td>
                                <td class="hidden-480">2,595</td>
                                <td class="hidden-phone">Feb 18</td>

                                <td class="hidden-480">
                                    <span class="label label-success">Registered</span>
                                </td>

                                <td>
                                    <div class="hidden-phone visible-desktop btn-group">
                                        <button class="btn btn-mini btn-success">
                                            <i class="glyphicon glyphicon-ok bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-info">
                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-danger">
                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-warning">
                                            <i class="glyphicon glyphicon-flag bigger-120"></i>
                                        </button>
                                    </div>

                                    <div class="hidden-desktop visible-phone">
                                        <div class="inline position-relative">
                                            <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                                <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                <li>
                                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                        <span class="blue">
                                                            <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                        <span class="green">
                                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                        <span class="red">
                                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </td>

                                <td>
                                    <a href="#">max.com</a>
                                </td>
                                <td>$60</td>
                                <td class="hidden-480">4,400</td>
                                <td class="hidden-phone">Mar 11</td>

                                <td class="hidden-480">
                                    <span class="label label-warning">Expiring</span>
                                </td>

                                <td>
                                    <div class="hidden-phone visible-desktop btn-group">
                                        <button class="btn btn-mini btn-success">
                                            <i class="glyphicon glyphicon-ok bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-info">
                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-danger">
                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-warning">
                                            <i class="glyphicon glyphicon-flag bigger-120"></i>
                                        </button>
                                    </div>

                                    <div class="hidden-desktop visible-phone">
                                        <div class="inline position-relative">
                                            <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                                <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                <li>
                                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                        <span class="blue">
                                                            <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                        <span class="green">
                                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                        <span class="red">
                                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </td>

                                <td>
                                    <a href="#">best.com</a>
                                </td>
                                <td>$75</td>
                                <td class="hidden-480">6,500</td>
                                <td class="hidden-phone">Apr 03</td>

                                <td class="hidden-480">
                                    <span class="label label-inverse arrowed-in">Flagged</span>
                                </td>

                                <td>
                                    <div class="hidden-phone visible-desktop btn-group">
                                        <button class="btn btn-mini btn-success">
                                            <i class="glyphicon glyphicon-ok bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-info">
                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-danger">
                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-warning">
                                            <i class="glyphicon glyphicon-flag bigger-120"></i>
                                        </button>
                                    </div>

                                    <div class="hidden-desktop visible-phone">
                                        <div class="inline position-relative">
                                            <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                                <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                <li>
                                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                        <span class="blue">
                                                            <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                        <span class="green">
                                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                        <span class="red">
                                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </td>

                                <td>
                                    <a href="#">pro.com</a>
                                </td>
                                <td>$55</td>
                                <td class="hidden-480">4,250</td>
                                <td class="hidden-phone">Jan 21</td>

                                <td class="hidden-480">
                                    <span class="label label-success">Registered</span>
                                </td>

                                <td>
                                    <div class="hidden-phone visible-desktop btn-group">
                                        <button class="btn btn-mini btn-success">
                                            <i class="glyphicon glyphicon-ok bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-info">
                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-danger">
                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                        </button>

                                        <button class="btn btn-mini btn-warning">
                                            <i class="glyphicon glyphicon-flag bigger-120"></i>
                                        </button>
                                    </div>

                                    <div class="hidden-desktop visible-phone">
                                        <div class="inline position-relative">
                                            <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                                <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                <li>
                                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                        <span class="blue">
                                                            <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                        <span class="green">
                                                            <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                        <span class="red">
                                                            <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="hr hr10 hr-double"></div>

                <ul class="pager pull-right">
                    <li class="previous disabled">
                        <a href="#">&larr; Prev</a>
                    </li>

                    <li class="next">
                        <a href="#">Next &rarr;</a>
                    </li>
                </ul>
            </div><!--/#clips-->

            <div id="print_media" class="tab-pane">
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="center">
                                <label>
                                    <input type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>Domain</th>
                            <th>Price</th>
                            <th class="hidden-480">Clicks</th>

                            <th class="hidden-phone">
                                <i class="glyphicon glyphicon-time bigger-110 hidden-phone"></i>
                                Update
                            </th>
                            <th class="hidden-480">Status</th>

                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </td>

                            <td>
                                <a href="#">ace.com</a>
                            </td>
                            <td>$45</td>
                            <td class="hidden-480">3,330</td>
                            <td class="hidden-phone">Feb 12</td>

                            <td class="hidden-480">
                                <span class="label label-warning">Expiring</span>
                            </td>

                            <td>
                                <div class="hidden-phone visible-desktop btn-group">
                                    <button class="btn btn-mini btn-success">
                                        <i class="glyphicon glyphicon-ok bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-info">
                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-danger">
                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-warning">
                                        <i class="glyphicon glyphicon-flag bigger-120"></i>
                                    </button>
                                </div>

                                <div class="hidden-desktop visible-phone">
                                    <div class="inline position-relative">
                                        <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                            <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                            <li>
                                                <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                    <span class="blue">
                                                        <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                    <span class="green">
                                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                    <span class="red">
                                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </td>

                            <td>
                                <a href="#">base.com</a>
                            </td>
                            <td>$35</td>
                            <td class="hidden-480">2,595</td>
                            <td class="hidden-phone">Feb 18</td>

                            <td class="hidden-480">
                                <span class="label label-success">Registered</span>
                            </td>

                            <td>
                                <div class="hidden-phone visible-desktop btn-group">
                                    <button class="btn btn-mini btn-success">
                                        <i class="glyphicon glyphicon-ok bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-info">
                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-danger">
                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-warning">
                                        <i class="glyphicon glyphicon-flag bigger-120"></i>
                                    </button>
                                </div>

                                <div class="hidden-desktop visible-phone">
                                    <div class="inline position-relative">
                                        <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                            <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                            <li>
                                                <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                    <span class="blue">
                                                        <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                    <span class="green">
                                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                    <span class="red">
                                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </td>

                            <td>
                                <a href="#">max.com</a>
                            </td>
                            <td>$60</td>
                            <td class="hidden-480">4,400</td>
                            <td class="hidden-phone">Mar 11</td>

                            <td class="hidden-480">
                                <span class="label label-warning">Expiring</span>
                            </td>

                            <td>
                                <div class="hidden-phone visible-desktop btn-group">
                                    <button class="btn btn-mini btn-success">
                                        <i class="glyphicon glyphicon-ok bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-info">
                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-danger">
                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-warning">
                                        <i class="glyphicon glyphicon-flag bigger-120"></i>
                                    </button>
                                </div>

                                <div class="hidden-desktop visible-phone">
                                    <div class="inline position-relative">
                                        <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                            <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                            <li>
                                                <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                    <span class="blue">
                                                        <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                    <span class="green">
                                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                    <span class="red">
                                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </td>

                            <td>
                                <a href="#">best.com</a>
                            </td>
                            <td>$75</td>
                            <td class="hidden-480">6,500</td>
                            <td class="hidden-phone">Apr 03</td>

                            <td class="hidden-480">
                                <span class="label label-inverse arrowed-in">Flagged</span>
                            </td>

                            <td>
                                <div class="hidden-phone visible-desktop btn-group">
                                    <button class="btn btn-mini btn-success">
                                        <i class="glyphicon glyphicon-ok bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-info">
                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-danger">
                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-warning">
                                        <i class="glyphicon glyphicon-flag bigger-120"></i>
                                    </button>
                                </div>

                                <div class="hidden-desktop visible-phone">
                                    <div class="inline position-relative">
                                        <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                            <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                            <li>
                                                <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                    <span class="blue">
                                                        <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                    <span class="green">
                                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                    <span class="red">
                                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </td>

                            <td>
                                <a href="#">pro.com</a>
                            </td>
                            <td>$55</td>
                            <td class="hidden-480">4,250</td>
                            <td class="hidden-phone">Jan 21</td>

                            <td class="hidden-480">
                                <span class="label label-success">Registered</span>
                            </td>

                            <td>
                                <div class="hidden-phone visible-desktop btn-group">
                                    <button class="btn btn-mini btn-success">
                                        <i class="glyphicon glyphicon-ok bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-info">
                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-danger">
                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                    </button>

                                    <button class="btn btn-mini btn-warning">
                                        <i class="glyphicon glyphicon-flag bigger-120"></i>
                                    </button>
                                </div>

                                <div class="hidden-desktop visible-phone">
                                    <div class="inline position-relative">
                                        <button class="btn btn-minier btn-blue dropdown-toggle" data-toggle="dropdown">
                                            <i class="glyphicon glyphicon-cog glyphicon glyphicon-only bigger-110"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-glyphicon glyphicon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                            <li>
                                                <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                    <span class="blue">
                                                        <i class="glyphicon glyphicon-zoom-in bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                    <span class="green">
                                                        <i class="glyphicon glyphicon-edit bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                    <span class="red">
                                                        <i class="glyphicon glyphicon-trash bigger-120"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><!--/#print_media-->
        </div>
    </div>
</div>