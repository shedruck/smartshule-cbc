<h1><?php lang('web_welcome') ?></h1><br>

<?php lang('web_home_lang') ?>: <?php $this->config->item('language') ?>

<div class="dashboard-widget">
  <div class="row">
    <div class="col-md-2">
      <div class="dashboard-wid-wrap">
        <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors graphic_design_sl"></i> <span class="dasboard-glyphicon glyphicon-title">Dashboard</span> </a> </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="dashboard-wid-wrap">
        <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors settings_sl"></i> <span class="dasboard-glyphicon glyphicon-title">Settings</span> </a> </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="dashboard-wid-wrap">
        <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors customers_sl"></i> <span class="dasboard-glyphicon glyphicon-title">Users Lits</span> </a> </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="dashboard-wid-wrap">
        <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors current_work_sl"></i> <span class="dasboard-glyphicon glyphicon-title">Statistics</span> </a> </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="dashboard-wid-wrap">
        <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors archives_sl"></i> <span class="dasboard-glyphicon glyphicon-title">Content</span> </a> </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="dashboard-wid-wrap">
        <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors lightbulb_sl"></i> <span class="dasboard-glyphicon glyphicon-title">Suport</span> </a> </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="switch-board-round">
    <ul class="clearfix">
      <li><a href="#" class="tip-top" title="Add User"><span class="srabon-sprite plus_sl"></span></a></li>
      <li><a href="#" class="tip-top" title="Add Post"><span class="srabon-sprite cv_sl"></span></a></li>
      <li><a href="#" class="tip-top" title="Recent Order"><span class="srabon-sprite bank_sl"></span></a></li>
      <li><a href="#" class="tip-top" title="Address Book"><span class="srabon-sprite address_sl"></span></a></li>
      <li><a href="#" class="tip-top" title="Advance Search"><span class="srabon-sprite search_sl"></span></a></li>
      <li><a href="#" class="tip-top" title="Events"><span class="srabon-sprite full_time_sl"></span></a></li>
      <li><a href="#" class="tip-top" title="Upload Files"><span class="srabon-sprite upcoming_work_sl"></span></a></li>
      <li><a href="#" class="tip-top" title="File Explorer "><span class="srabon-sprite category_sl"></span></a></li>
      <li><a href="#" class="tip-top" title="Print"><span class="srabon-sprite print_sl"></span></a></li>
    </ul>
  </div>
</div>
<div class="row">
  <div class="col-md-3 ">
    <div class="stat-block">
      <ul>
        <li class="stat-count"><span>Weekly Visit</span><span>14000</span></li>
        <li class="stat-percent"><span><img src="<?php echo base_url('assets/img/green-arrow.png'); ?>" width="20" height="20" alt="Increased"></span><span class="label-green">20%</span></li>
      </ul>
    </div>
  </div>
  <div class="col-md-3 ">
    <div class="stat-block">
      <ul>

        <li class="stat-count"><span>New Visits</span><span>6000</span></li>
        <li class="stat-percent"><span><img src="<?php echo base_url('assets/img/red-arrow.png'); ?>" width="20" height="20" alt="Decrease"></span><span class="label-red">15%</span></li>
      </ul>
    </div>
  </div>
  <div class="col-md-3 ">
    <div class="stat-block">
      <ul>

        <li class="stat-count"><span>Unique Visits</span><span>3000</span></li>
        <li class="stat-percent"><span><img src="<?php echo base_url('assets/img/green-arrow.png'); ?>" width="20" height="20" alt="Increased"></span><span class="label-green">10%</span></li>
      </ul>
    </div>
  </div>
  <div class="col-md-3 ">
    <div class="stat-block">
      <ul>

        <li class="stat-count"><span>Weekly Sales</span><span>$25,000.00</span></li>
        <li class="stat-percent"><span><img src="<?php echo base_url('assets/img/green-arrow.png'); ?>" width="20" height="20" alt="Increased"></span><span class="label-green">20%</span></li>
      </ul>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-6  ">
    <div class="widget-block">
      <div class="widget-head">
        <h5><i class="black-icons money"></i> Recent Orders</h5>

      </div>
      <div class="widget-content">
        <div class="widget-box">
          <div class="white-box ">
            <pre> Allowed URL Characters
                                           This lets you specify with a regular expression which characters are permitted
                                            | within your URLs.  When someone tries to submit a URL with disallowed
                                            | characters they will get a warning message.
                                            |
                                            | As a security measure you are STRONGLY encouraged to restrict URLs to
                                            | as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
                                            |
                                            | Leave blank to allow all characters -- but only if you are insane.
                                            |
            </pre></div></div>
      </div>
    </div>
  </div>

  <div class="col-md-6  ">
    <div class="widget-block">
      <div class="widget-head">
        <h5><i class="black-icons money"></i> Recent Orders</h5>

      </div>
      <div class="widget-content">
        <div class="widget-box">
          <div class="white-box ">
            <pre> Allowed URL Characters
                                          This lets you specify with a regular expression which characters are permitted
                                            | within your URLs.  When someone tries to submit a URL with disallowed
                                            | characters they will get a warning message.
                                            |
                                            | As a security measure you are STRONGLY encouraged to restrict URLs to
                                            | as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
                                            |
                                            | Leave blank to allow all characters -- but only if you are insane.
                                            |
            </pre></div></div>
      </div>
    </div>
  </div>

</div>


