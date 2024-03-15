     <div class="row">
        <div class="content-wrap margin-reset">
            <!-- messages -->
            <div class="messages-box">
                <div class="borders">

                    <div class="col-md-4 listWrapper">
                        <div class="innerBox" id="contacts-search">
                            <form autocomplete="off" class="form-inline margin-none">
                                <div class="input-group input-group-sm">
                                    <input class="form-control" id="contacts-search-input" placeholder="Filter Contacts ..." type="text">
                                    <span class="input-group-btn">
                                         <button type="button" class="btn btn-primary btn-xs pull-right" style="display:none;"><i class="icon glyphicon glyphicon-search"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div id="tabs-control" class="bg-gray strong border-top border-bottom text-center">
                            <div class="col-md-6 padding-none"><a href="#" id="tab-chats" class="tab border-right active-tab">
                                    <div id="loadingDiv-chats"></div>
                                    <span class="glyphicon glyphglyphicon glyphicon-envelope"></span> Conversations</a>
                            </div>
                            <div class="col-md-6 padding-none"><a href="#" id="tab-contacts" class="tab">
                                    <div id="loadingDiv-contacts"></div>
                                    <span class="glyphicon glyphglyphicon glyphicon-user"></span> Parents Online (<?php echo count($staff); ?>)</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <ul class="list-unstyled p0" id="messages-stack-list" tabindex="5000" style="overflow: hidden; outline: none; cursor: -webkit-grab;">
                            <?php
                            foreach ($staff as $sid)
                            {
                                    $nm = $this->ion_auth->get_user($sid);
                                    $fnm = $nm->first_name;
                                    $avt = strtolower(substr($nm->first_name, 0, 1));
                                    ?>
                                    <li class="prepare-message border-bottom" id="<?php echo $sid; ?>">
                                        <div class="media innerBox">
                                            <div class="media-object pull-left hidden-phone">
                                                 <a href="#"><img src="<?php echo base_url('assets/themes/default/img/avatar/'. $avt . '/50.png');?>" alt="User">
                                                     <?php //echo theme_image('avatar/' . $avt . '/50.png', array('alt' => "User")); ?></a>
                                            </div>
                                            <div class="media-body">
                                                <div>
                                                    <span class="strong"><?php echo $fnm; ?> </span> 
                                                    <div class="pull-right">
                                                    </div>
                                                </div>
                                                <div id="type-status-<?php echo $sid; ?>"></div>
                                                <div id="unreader-counter<?php echo $sid; ?>"></div>
                                                <p>Online</p>  
                                            </div>
                                        </div>
                                    </li> 
                            <?php } ?>


                        </ul>
                    </div>

                    <div class="col-md-8 messageWrapper">
                        <div id="loadingDiv"></div>
                        <div id="errorDiv"></div>
                        <div id="text-messages-request" tabindex="5001" style="overflow: hidden; outline: none; cursor: -webkit-grab;">
                            <p class="placer innerBox">Start a Conversation by selecting a contact on the left</p>
                        </div>
                    </div>

                </div> 
            </div>
            <p style="padding-top: 5px; color: #aaa;"></p>
            <!-- // messages -->
        </div>
    </div><!-- // row -->
 

<!-- modal -->
<div id="generalModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="upload-tm" value="<?php echo now();?>">
<input type="hidden" id="upload-token" value="49305ebfcc14e084ac3632c02bb25e15">