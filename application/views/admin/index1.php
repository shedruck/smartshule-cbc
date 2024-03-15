<div class="row">
    <a href="#" class="glyphicon glyphicon-btn glyphicon glyphicon-btn-green col-md-2 offset2">
        <i class="glyphicon glyphicon-dashboard glyphicon glyphicon-2x"></i>
        <div>Dashboard</div>
        <span class="badge label-warning">2</span>
    </a>
    <a href="charts.html" class="glyphicon glyphicon-btn col-md-2">
      <!-- <i class="glyphicon glyphicon-money glyphicon glyphicon-2x"></i> -->
        <span id="compositebar"></span>
        <div>Finances</div>
        <span class="badge  label-info badge-right">890$</span>
    </a>
    <a href="calendar.html" class="glyphicon glyphicon-btn glyphicon glyphicon-btn-blue col-md-2">
        <i class="glyphicon glyphicon-calendar glyphicon glyphicon-2x"></i>
        <div>Calendar</div>
        <span class="badge label-success">4</span>
    </a>
    <a href="pages/email-inbox.html" class="glyphicon glyphicon-btn glyphicon glyphicon-btn-orange col-md-2">
        <i class="glyphicon glyphicon-inbox glyphicon glyphicon-2x"></i>
        <div>Inbox</div>
        <span class="badge label-important badge-right">2</span>
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <!-- FLot example -->
        <section class="social-box social-bordered">
            <header class="header">
                <h4><i class="glyphicon glyphicon-bar-chart"></i> Visits by location</h4>
                <div class="tools">
                </div>
            </header>
            <div class="body">
                <div id="demo-plot" class="plot"></div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <!-- Feed list example -->
        <section id="feeds" class="feeds social-box social-bordered social-blue">
            <div class="header">
                <!-- BEGIN FEED TITLE  -->
                <h4>
                    <i class="glyphicon glyphicon-th-list"></i>
                    <span class="hidden-phone">Recent Activities</span>
                    <span class="visible-phone">Feeds</span>
                </h4>
                <!-- END FEED TITLE  -->
                <!-- BEGIN TABS TOGGLES -->
                <div class="tools">
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active">
                            <a class="active" href="#users" data-toggle="tab">Users</a>
                        </li>
                        <li>
                            <a href="#system" data-toggle="tab">System</a>
                        </li>
                    </ul>
                </div>
                <!-- BEGIN TABS TOGGLES -->
            </div>
            <!-- BEGIN FEED BODY -->
            <div class="body">
                <div class="tab-content">
                    <!-- BEGIN USERS FEEDS SECTION -->
                    <div class="tab-pane fade in users-feeds active" id="users">
                        <div class="content">
                            <!-- BEGIN ROW FEEDS -->
                            <div class="row">
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user3_55.jpg') ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">John Doe</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-info">new message</span>
                                    </div>
                                </div>
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user3_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">John Doe</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-info">new message</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END ROW FEEDS -->
                            <!-- BEGIN ROW FEEDS -->
                            <div class="row">
                                <!-- feed message -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user1_55.jpg') ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Yadra Abels</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-warning">confirming</span>
                                    </div>
                                </div>
                                <!-- feed message -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user4_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Tobei Tsumura</h6>
                                        <span><small>25 Sept 2013 3:46pm</small></span>
                                        <span class="label label-success">registered</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END ROW FEEDS -->
                            <!-- BEGIN ROW FEEDS -->
                            <div class="row">
                                <!-- feed essage -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user2_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Cesar Mendoza</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-warning">confirming</span>
                                    </div>
                                </div>
                                <!-- feed essage -->
                                <div class="feed col-md-6">
                                    <span></span><img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user5_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Tobei Tsumura</h6>
                                        <span><small>25 Sept 2013 3:46pm</small></span>
                                        <span class="label label-success">registered</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END ROW FEEDS -->
                            <!-- BEGIN ROW FEEDS -->
                            <div class="row">
                                <!-- feed message -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user1_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Yadra Abels</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-warning">confirming</span>
                                    </div>
                                </div>
                                <!-- feed message -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user4_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Tobei Tsumura</h6>
                                        <span><small>25 Sept 2013 3:47pm</small></span>
                                        <span class="label label-success">registered</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END ROW FEEDS -->
                            <!-- BEGIN ROW FEEDS -->
                            <div class="row">
                                <!-- feed essage -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user2_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Cesar Mendoza</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-warning">confirming</span>
                                    </div>
                                </div>
                                <!-- feed essage -->
                                <div class="feed col-md-6">
                                    <span></span><img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user5_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Tobei Tsumura</h6>
                                        <span><small>25 Sept 2013 3:47pm</small></span>
                                        <span class="label label-success">registered</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END ROW FEEDS -->
                            <!-- BEGIN ROW FEEDS -->
                            <div class="row">
                                <!-- feed message -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user1_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Yadra Abels</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-warning">confirming</span>
                                    </div>
                                </div>
                                <!-- feed message -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user4_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Tobei Tsumura</h6>
                                        <span><small>25 Sept 2013 3:48pm</small></span>
                                        <span class="label label-success">registered</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END ROW FEEDS -->
                            <!-- BEGIN ROW FEEDS -->
                            <div class="row">
                                <!-- feed essage -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user2_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Cesar Mendoza</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-warning">confirming</span>
                                    </div>
                                </div>
                                <!-- feed essage -->
                                <div class="feed col-md-6">
                                    <span></span><img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user5_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Tobei Tsumura</h6>
                                        <span><small>25 Sept 2013 3:48pm</small></span>
                                        <span class="label label-success">registered</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END ROW FEEDS -->
                            <!-- BEGIN ROW FEEDS -->
                            <div class="row">
                                <!-- feed message -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user1_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Yadra Abels</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-warning">confirming</span>
                                    </div>
                                </div>
                                <!-- feed message -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user4_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Tobei Tsumura</h6>
                                        <span><small>25 Sept 2013 3:49pm</small></span>
                                        <span class="label label-success">registered</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END ROW FEEDS -->
                            <!-- BEGIN ROW FEEDS -->
                            <div class="row">
                                <!-- feed essage -->
                                <div class="feed col-md-6">
                                    <img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user2_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Cesar Mendoza</h6>
                                        <span><small>25 Sept 2013 3:45pm</small></span>
                                        <span class="label label-warning">confirming</span>
                                    </div>
                                </div>
                                <!-- feed essage -->
                                <div class="feed col-md-6">
                                    <span></span><img class="feed-object" src="<?php echo base_url('assets/themes/admin/img/people-face/user5_55.jpg'); ?>" alt="John Doe">
                                    <div class="feed-body">
                                        <h6 class="feed-heading">Tobei Tsumura</h6>
                                        <span><small>25 Sept 2013 3:49pm</small></span>
                                        <span class="label label-success">registered</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END ROW FEEDS -->
                        </div>
                    </div>
                    <!-- END USERS FEEDS SECTION -->
                    <!-- BEGIN SYSTEM FEEDS SECTION -->
                    <div class="tab-pane fade in system-feeds" id="system">
                        <div class="content">
                            <ul class="unstyled">
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-warning"><i class="glyphicon glyphicon-warning-sign"></i></div>
                                        <span>System overload</span>
                                        <span class="label label-success">warning</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>5 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-important"><i class="glyphicon glyphicon-remove"></i></div>
                                        <a href="#">Emails couldn't be sent</a>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>6 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-info"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        <span>New user registered</span>
                                        <span class="label label-info">username</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>7 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-success"><i class="glyphicon glyphicon-check"></i></div>
                                        <span>The backup has been created</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>8 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        Success
                                    </div>
                                    <div class="feed-time">
                                        <span><em>9 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-warning"><i class="glyphicon glyphicon-warning-sign"></i></div>
                                        <span>System overload</span>
                                        <span class="label label-success">warning</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>10 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-important"><i class="glyphicon glyphicon-remove"></i></div>
                                        <a href="#">Emails couldn't be sent</a>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>11 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-info"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        <span>New user registered</span>
                                        <span class="label label-info">username</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>12 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-success"><i class="glyphicon glyphicon-check"></i></div>
                                        <span>The backup has been created</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>13 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        Success
                                    </div>
                                    <div class="feed-time">
                                        <span><em>14 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-warning"><i class="glyphicon glyphicon-warning-sign"></i></div>
                                        <span>System overload</span>
                                        <span class="label label-success">warning</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>14 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-important"><i class="glyphicon glyphicon-remove"></i></div>
                                        <a href="#">Emails couldn't be sent</a>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>16 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-info"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        <span>New user registered</span>
                                        <span class="label label-info">username</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>17 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-success"><i class="glyphicon glyphicon-check"></i></div>
                                        <span>The backup has been created</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>18 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        Success
                                    </div>
                                    <div class="feed-time">
                                        <span><em>19 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-warning"><i class="glyphicon glyphicon-warning-sign"></i></div>
                                        <span>System overload</span>
                                        <span class="label label-success">warning</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>19 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-important"><i class="glyphicon glyphicon-remove"></i></div>
                                        <a href="#">Emails couldn't be sent</a>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>21 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-info"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        <span>New user registered</span>
                                        <span class="label label-info">username</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>22 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-success"><i class="glyphicon glyphicon-check"></i></div>
                                        <span>The backup has been created</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>23 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        Success
                                    </div>
                                    <div class="feed-time">
                                        <span><em>24 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-warning"><i class="glyphicon glyphicon-warning-sign"></i></div>
                                        <span>System overload</span>
                                        <span class="label label-success">warning</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>24 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-important"><i class="glyphicon glyphicon-remove"></i></div>
                                        <a href="#">Emails couldn't be sent</a>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>25 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-info"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        <span>New user registered</span>
                                        <span class="label label-info">username</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>26 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-success"><i class="glyphicon glyphicon-check"></i></div>
                                        <span>The backup has been created</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>27 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        Success
                                    </div>
                                    <div class="feed-time">
                                        <span><em>28 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-warning"><i class="glyphicon glyphicon-warning-sign"></i></div>
                                        <span>System overload</span>
                                        <span class="label label-success">warning</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>29 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-important"><i class="glyphicon glyphicon-remove"></i></div>
                                        <a href="#">Emails couldn't be sent</a>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>30 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-info"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        <span>New user registered</span>
                                        <span class="label label-info">username</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>31 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-success"><i class="glyphicon glyphicon-check"></i></div>
                                        <span>The backup has been created</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>32 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        Success
                                    </div>
                                    <div class="feed-time">
                                        <span><em>33 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-warning"><i class="glyphicon glyphicon-warning-sign"></i></div>
                                        <span>System overload</span>
                                        <span class="label label-success">warning</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>33 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-important"><i class="glyphicon glyphicon-remove"></i></div>
                                        <a href="#">Emails couldn't be sent</a>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>35 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-info"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        <span>New user registered</span>
                                        <span class="label label-info">username</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>36 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-success"><i class="glyphicon glyphicon-check"></i></div>
                                        <span>The backup has been created</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>37 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        Success
                                    </div>
                                    <div class="feed-time">
                                        <span><em>38 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-warning"><i class="glyphicon glyphicon-warning-sign"></i></div>
                                        <span>System overload</span>
                                        <span class="label label-success">warning</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>38 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-important"><i class="glyphicon glyphicon-remove"></i></div>
                                        <a href="#">Emails couldn't be sent</a>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>40 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-info"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        <span>New user registered</span>
                                        <span class="label label-info">username</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>41 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label label-success"><i class="glyphicon glyphicon-check"></i></div>
                                        <span>The backup has been created</span>
                                    </div>
                                    <div class="feed-time">
                                        <span><em>42 minutes ago</em></span>
                                    </div>
                                </li>
                                <!-- feed message -->
                                <li class="feed">
                                    <div class="feed-message">
                                        <div class="label"><i class="glyphicon glyphicon-info-sign"></i></div>
                                        Success
                                    </div>
                                    <div class="feed-time">
                                        <span><em>43 minutes ago</em></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END SYSTEM FEEDS SECTION -->
                </div>
            </div>
            <!-- END FEED BODY -->
        </section>  </div>
</div>


<div class="row">
    <div class="col-md-6">
        <!-- Vector Map Example -->
        <section class="social-box social-bordered social-green">
            <header class="header">
                <h4><i class="glyphicon glyphicon-map-marker"></i> World Map</h4>
                <div class="tools">
                </div>
            </header>
            <div class="body">
                <div id="vmap-world" class="vmap"></div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <!-- justGauge Example -->
        <section class="social-box social-bordered social-orange">
            <div class="header">
                <h4><i class="glyphicon glyphicon-bar-chart"></i> Server Stats</h4>
            </div>
            <div id="justGaugeExamples" class="body">
                <div>
                    <div class="hidden-phone muted"><h3>Nice & clean Gauges</h3></div>
                    <div id="g1"></div>
                    <div id="g2"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!-- Chat example -->
        <!-- BEGIN CHAT BOX -->
        <div class="social-box social-blue social-bordered">
            <div class="header">
                <h4><i class="glyphicon glyphicon-bar-chart"></i> Chat</h4>


            </div>
            <!-- BEGIN CHAT WINDOW -->
            <div class="body chat">
                <!-- BEGIN CHAT MESSAGES LIST -->
                <div class="chat-messages-list" style="height:400px">
                    <div class="content">
                        <!-- BEGIN CHAT MESSAGE -->
                        <div class="chat-message">
                            <div class="chat-message-avatar">
                                <img width="55" height="55" src="<?php echo base_url('assets/themes/admin/img/people-face/user1_55.jpg'); ?>" alt="Friend">
                            </div>
                            <div class="chat-message-body">
                                <div class="chat-message-body-header">Yadra Abels <small>Yesterday, 23:00</small></div>
                                <div class="chat-message-body-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, eaque nobis natus odit reiciendis distinctio corporis optio suscipit. Suscipit, omnis, eum veniam animi est pariatur voluptate quo ab quaerat dolores.
                                </div>
                            </div>
                        </div>
                        <!-- END CHAT MESSAGE -->
                        <!-- BEGIN CHAT MESSAGE -->
                        <div class="chat-message pull-right">
                            <div class="chat-message-avatar">
                                <img width="55" height="55" src="<?php echo base_url('assets/themes/admin/img/avatar-55.png'); ?>" alt="Julio Marquez">
                            </div>
                            <div class="chat-message-body">
                                <div class="chat-message-body-header">Julio Marquez <small>Yesterday, 23:00</small></div>
                                <div class="chat-message-body-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, eaque nobis natus odit reiciendis distinctio corporis optio suscipit. Suscipit, omnis, eum veniam animi est pariatur voluptate quo ab quaerat dolores.

                                </div>
                            </div>
                        </div>
                        <!-- END CHAT MESSAGE -->
                        <!-- BEGIN CHAT MESSAGE -->
                        <div class="chat-message">
                            <div class="chat-message-avatar">
                                <img width="55" height="55" src="<?php echo base_url('assets/themes/admin/img/people-face/user1_55.jpg'); ?>" alt="Friend">
                            </div>
                            <div class="chat-message-body">
                                <div class="chat-message-body-header">Yadra Abels <small>Yesterday, 23:00</small></div>
                                <div class="chat-message-body-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, eaque nobis natus odit reiciendis distinctio corporis optio suscipit. Suscipit, omnis, eum veniam animi est pariatur voluptate quo ab quaerat dolores.
                                </div>
                            </div>
                        </div>
                        <!-- END CHAT MESSAGE -->
                        <!-- BEGIN CHAT MESSAGE -->
                        <div class="chat-message pull-right">
                            <div class="chat-message-avatar">
                                <img width="55" height="55" src="<?php echo base_url('assets/themes/admin/img/avatar-55.png'); ?>" alt="Julio Marquez">
                            </div>
                            <div class="chat-message-body">
                                <div class="chat-message-body-header">Julio Marquez <small>Yesterday, 23:00</small></div>
                                <div class="chat-message-body-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, eaque nobis natus odit reiciendis distinctio corporis optio suscipit. Suscipit, omnis, eum veniam animi est pariatur voluptate quo ab quaerat dolores.

                                </div>
                            </div>
                        </div>
                        <!-- END CHAT MESSAGE -->
                        <!-- BEGIN CHAT MESSAGE -->
                        <div class="chat-message">
                            <div class="chat-message-avatar">
                                <img width="55" height="55" src="<?php echo base_url('assets/themes/admin/img/people-face/user1_55.jpg'); ?>" alt="Friend">
                            </div>
                            <div class="chat-message-body">
                                <div class="chat-message-body-header">Yadra Abels <small>Yesterday, 23:00</small></div>
                                <div class="chat-message-body-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, eaque nobis natus odit reiciendis distinctio corporis optio suscipit. Suscipit, omnis, eum veniam animi est pariatur voluptate quo ab quaerat dolores.
                                </div>
                            </div>
                        </div>
                        <!-- END CHAT MESSAGE -->
                        <!-- BEGIN CHAT MESSAGE -->
                        <div class="chat-message pull-right">
                            <div class="chat-message-avatar">
                                <img width="55" height="55" src="<?php echo base_url('assets/themes/admin/img/avatar-55.png'); ?>" alt="Julio Marquez">
                            </div>
                            <div class="chat-message-body">
                                <div class="chat-message-body-header">Julio Marquez <small>Yesterday, 23:00</small></div>
                                <div class="chat-message-body-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, eaque nobis natus odit reiciendis distinctio corporis optio suscipit. Suscipit, omnis, eum veniam animi est pariatur voluptate quo ab quaerat dolores.

                                </div>
                            </div>
                        </div>
                        <!-- END CHAT MESSAGE -->
                        <!-- BEGIN CHAT MESSAGE -->
                        <div class="chat-message">
                            <div class="chat-message-avatar">
                                <img width="55" height="55" src="<?php echo base_url('assets/themes/admin/img/people-face/user1_55.jpg'); ?>" alt="Friend">
                            </div>
                            <div class="chat-message-body">
                                <div class="chat-message-body-header">Yadra Abels <small>Yesterday, 23:00</small></div>
                                <div class="chat-message-body-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, eaque nobis natus odit reiciendis distinctio corporis optio suscipit. Suscipit, omnis, eum veniam animi est pariatur voluptate quo ab quaerat dolores.
                                </div>
                            </div>
                        </div>
                        <!-- END CHAT MESSAGE -->
                        <!-- BEGIN CHAT MESSAGE -->
                        <div class="chat-message pull-right">
                            <div class="chat-message-avatar">
                                <img width="55" height="55" src="<?php echo base_url('assets/themes/admin/img/avatar-55.png'); ?>" alt="Julio Marquez">
                            </div>
                            <div class="chat-message-body">
                                <div class="chat-message-body-header">Julio Marquez <small>Yesterday, 23:00</small></div>
                                <div class="chat-message-body-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, eaque nobis natus odit reiciendis distinctio corporis optio suscipit. Suscipit, omnis, eum veniam animi est pariatur voluptate quo ab quaerat dolores.

                                </div>
                            </div>
                        </div>
                        <!-- END CHAT MESSAGE -->
                    </div>
                </div>
                <!-- END CHAT MESSAGES LIST -->
                <!-- BEGIN CHAT COMPOSER -->
                <div class="chat-composer">
                    <div class="chat-form">
                        <div class="chat-input">
                            <input id="composerMessage" type="text" placeholder="Type a message...">
                        </div>
                        <button class="btn btn-primary chat-sender" type="submit">
                            <span class="icon glyphicon glyphicon-share-alt "></span>
                        </button>
                    </div>
                </div>
                <!-- END CHAT COMPOSER -->
            </div>
            <!-- END CHAT WINDOW -->
        </div>
        <!-- END CHAT BOX -->  </div>
    <div class="col-md-6">
        <section class="social-box social-bordered">
            <div class="header">
                <h4><i class="glyphicon glyphicon-calendar"></i> Calendar</h4>
            </div>
            <div class="body">
                <div id="demo-calendar1" class="social-box-calendar"></div>
            </div>
        </section>
    </div>
</div>