<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parents extends Public_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->template->set_layout('default');
                $this->template
                             ->set_layout('default.php')
                             ->set_partial('meta', 'partials/meta.php')
                             ->set_partial('header', 'partials/header.php')
                             ->set_partial('sidebar', 'partials/sidebar.php')
                             ->set_partial('footer', 'partials/footer.php');

                $this->load->model('parents_m');
        }

        function chat()
        {
                if (!$this->parent)
                {
                        redirect('account');
                }
                $users = $this->ion_auth->fetch_logged_in();
                $gs = array();
                foreach ($users as $key => $uid)
                {
                        if ($this->ion_auth->is_in_group($uid, 1))
                        {
                                $gs[] = $uid;
                        }
                }

                $data['staff'] = $gs;
                $this->template->title('Message Centre')->build('index/message', $data);
        }

        function send()
        {
                $id = $this->input->post('id');
                $message = $this->input->post('message');

                $user = $this->ion_auth->get_user($id);
                $me = $this->ion_auth->get_user();
                $side = $this->input->post('side');
                if ($side == 1)
                {
                        $user_1 = $user->id;
                        $user_2 = $me->id;
                        $rc = 'row';
                        $sc = 'span';
                }
                else
                {
                        $user_1 = $me->id;
                        $user_2 = $user->id;
                        $rc = 'row';
                        $sc = 'col-sm-';
                }
                $row_con = $this->parents_m->has_talked($user_1, $user_2);

                if ($row_con)
                {
                        $con_id = $row_con;
                }
                else
                {
                        $conv = array(
                            'user_1' => $user_1,
                            'user_2' => $user_2,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                        $con_id = $this->parents_m->make_converse($conv);
                }

                if ($con_id)
                {
                        $chat = array(
                            'text' => $message,
                            'sender' => ($side == 1) ? $user_2 : $user_1,
                            'receiver' => ($side == 1) ? $user_1 : $user_2,
                            'image' => '',
                            'conversation' => $con_id,
                            'seen' => 0,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $mess = $this->parents_m->save_chat($chat);
                        if ($mess)
                        {
                                $avt = strtolower(substr($user->first_name, 0, 1));
                                $this->load->library('Dates');
                                $log = $this->parents_m->fetch_latest($con_id);
                                $feed = '';
                                $last = 0;
                                foreach ($log as $msg)
                                {
                                        $sender = $this->ion_auth->get_user($msg->sender);
                                        $feed_avt = strtolower(substr($sender->first_name, 0, 1));
                                        $ago = $this->dates->createFromTimeStamp($msg->created_on)->diffForHumans();
                                        $dt = date('d M Y, H:i', $msg->created_on);
                                        if ($msg->sender == $me->id)
                                        {
                                                $niem = 'You';
                                        }
                                        else
                                        {
                                                $niem = $sender->first_name . ' ' . $sender->last_name;
                                        }
                                        $feed .= '
                          <div class="media innerBox msg-div" id="msg' . $msg->id . '"  data-id="' . $msg->id . '">
                         <a href="profile/?id=' . $me->id . '" class="pull-left hidden-xs">' . theme_image('avatar/' . $feed_avt . '/50.png', array('alt' => "User", 'class' => "media-object", "width" => "50", 'height' => "50")) . ' </a>
                           <div class="media-body">
                              <div class="' . $rc . '">
                                  <div class="' . $sc . '9">
                                      <div class="chat-style">
                                          <div class="media">
                                               <div class="media-body">
                                                  <a href="profile/?id=' . $msg->sender . '" class="strong text-inverse">' . $niem . '</a><br />
                                                  ' . nl2br($msg->text) . ' </div>
                                          </div>
                                      </div>	
                                  </div>
                                  <div class="' . $sc . '3 hidden-xs">
                                      <span class="pull-right innerBox-right text-muted" title="' . $dt . '">'
                                                     . '<i class="pull-right remove-message" id="' . $msg->id . '" data-user="' . $msg->sender . '">&times;</i>' . $ago . '</span>
                                  </div>
                              </div>
                          </div>
                       </div>';
                                        $last = $msg->id;
                                }
                                echo '<div id="more0" class="more-messages-parent bg-gray innerBox innerBox-half text-center margin-none border-top border-bottom">
                                <a href="#" class="load-more-messages text-muted" id="0" rel="' . $last . '">View older messsages (<span id="count-old-messages">0</span>)</a>
                            </div>';

                                echo ' <div class="border-top" id="text-messages" style="overflow: hidden;">';
                                echo $feed . '   
                            </div>
               
                <div class="active-message">
                  <div class="media">
                      <a href="#" class="pull-left">' . theme_image('avatar/' . $avt . '/50.png', array('alt' => "User", 'class' => "media-object", "width" => "65", 'height' => "65")) . ' </a>
                      <div class="media-body innerBox-topbottom innerBox-right">
                          <div class="innerBox-top innerBox-half pull-right message-btn-target">
                          <a href="#type" class="btn btn-default btn-sm" id="type-a-message" data-toggle="collapse">
                              <i class="glyphicon glyphglyphicon glyphicon-pencil"></i> Write
                          </a>
                          </div>
                          <h4 class="pull-left strong no-margin"> ' . $user->first_name . ' <br />
                              <span id="last-seen"> last seen today at -:-   </span>
                          </h4>
                      </div>
                  </div>
              </div>

              <div id="type" class="collapse border-top">
                      <div id="chat-toolbar">
                      <a id="emoticons" href="#"><span class="glyphicon glyphglyphicon glyphicon-tree-deciduous" title="emoticons"></span></a>
                      <a id="send-photo" href="#"><span class="glyphicon glyphglyphicon glyphicon-camera" title="send photo"></span></a>
                      <a id="send-location" href="#"><span class="glyphicon glyphglyphicon glyphicon-asterisk" title="send location"></span></a>
                      <a id="send-file" class="pull-right" href="#"><span class="glyphicon glyphglyphicon glyphicon-upload" title="send file"></span></a>
                      <div class="clearfix"></div>
                  </div>
                  <textarea type="text" class="composer form-control border-none" id="' . $id . '" placeholder="Write a message"></textarea>
              </div>
              
              <div id="type" class="collapse border-top">
                  <textarea type="text" class="form-control border-none" id="composer" placeholder="New Message"></textarea>
              </div>
                    ';
                        }
                }
        }

        function ajax_last_seen()
        {
                
        }

        function chat_type_ajax()
        {
                
        }

        function list_contacts()
        {
                $side = $this->input->post('side');
                $grp = 1;
                if ($side == 1)
                {
                        $grp = 6;
                }
                $users = $this->ion_auth->fetch_logged_in();
                $staff = array();
                foreach ($users as $key => $uid)
                {
                        if ($this->ion_auth->is_in_group($uid, $grp))
                        {
                                $staff[] = $uid;
                        }
                }
                $htm = '';
                foreach ($staff as $sid)
                {
                        $nm = $this->ion_auth->get_user($sid);
                        $fnm = $nm->first_name . ' ' . $nm->last_name;
                        $avt = strtolower(substr($nm->first_name, 0, 1));
                        $htm .= '<li class="prepare-message border-bottom" id="' . $sid . '">
                                         <div class="media innerBox">
                                         <div class="media-object pull-left hidden-phone">
                                        <a href="#">' . theme_image('avatar/' . $avt . '/50.png', array('alt' => "User")) . '</a>
                                        </div>
                                    <div class="media-body">
                                        <div>
                                                <span class="strong">' . $fnm . '</span> 
                                                <div class="pull-right">
                                          </div>
                                        </div>
                                        <div id="type-status-' . $sid . '"></div>
                                        <div id="unreader-counter' . $sid . '"></div>
                                        <p>Online</p>
                                        </div>
                                </div>
                                </li>';
                }

                echo $htm;
        }

        function refresh_unreadMessages_ajax()
        {
                
        }

        function real_time()
        {
                $side = $this->input->post('side');
                $last = $this->input->post('last');
                $id = $this->input->post('id');
                $me = $this->ion_auth->get_user();
                $feed = $this->parents_m->fetch_new($id, $last);

                $rc = ($side == 1) ? 'row' : 'row';
                $sc = ($side == 1) ? 'span' : 'col-sm-';
                $this->load->library('Dates');
                $tl = '';
                foreach ($feed as $f)
                {
                        $sender = $this->ion_auth->get_user($f->sender);
                        $f_avt = strtolower(substr($sender->first_name, 0, 1));
                        $ago = $this->dates->createFromTimeStamp($f->created_on)->diffForHumans();
                        $dt = date('d M Y, H:i', $f->created_on);
                        if ($f->sender == $me->id)
                        {
                                $niem = 'You';
                        }
                        else
                        {
                                $niem = $sender->first_name;
                        }
                        $tl .= '<div class="media innerBox msg-div" id="msg' . $f->id . '" data-id="' . $f->id . '">
                         <a href="profile/?id=' . $me->id . '" class="pull-left hidden-xs">' . theme_image('avatar/' . $f_avt . '/30.png', array('alt' => "User", 'class' => "media-object", "width" => "30", 'height' => "30")) . ' </a>
                           <div class="media-body">
                              <div class="' . $rc . '">
                                  <div class="' . $sc . '9">
                                      <div class="chat-style">
                                          <div class="media">
                                              <div class="media-body">
                                                  <a href="profile/?id=' . $f->sender . '" class="strong text-inverse">' . $niem . '</a><br />
                                                  ' . nl2br($f->text) . ' </div>
                                          </div>
                                      </div>	
                                  </div>
                                  <div class="' . $sc . '3 hidden-xs">
                                      <span class="pull-right innerBox-right text-muted" title="' . $dt . '">'
                                     . '<i class="pull-right remove-message" id="' . $f->id . '" data-user="' . $f->sender . '">&times;</i><small>' . $ago . '</small></span>
                                  </div>
                              </div>
                          </div>
                       </div>';
                }
                echo $tl;
        }

        function chat_last_id()
        {
                
        }

        function contacts_more_ajax()
        {
                
        }

        /**
         * Fetch Chat History
         * 
         */
        function fetch_log()
        {
                $id = $this->input->post('id');

                $user = $this->ion_auth->get_user($id);
                $me = $this->ion_auth->get_user();
                $side = $this->input->post('side');

                if ($side == 1)
                {
                        $user_1 = $user->id;
                        $user_2 = $me->id;
                        $rc = 'row';
                        $sc = 'span';
                }
                else
                {
                        $user_1 = $me->id;
                        $user_2 = $user->id;
                        $rc = 'row';
                        $sc = 'col-sm-';
                }
                $con_id = $this->parents_m->has_talked($user_1, $user_2);

                $avt = strtolower(substr($user->first_name, 0, 1));
                $this->load->library('Dates');
                $feed = '';
                $last = 0;
                if ($con_id)
                {
                        $log = $this->parents_m->fetch_latest($con_id);
                        foreach ($log as $msg)
                        {
                                $sender = $this->ion_auth->get_user($msg->sender);
                                $feed_avt = strtolower(substr($sender->first_name, 0, 1));
                                $ago = $this->dates->createFromTimeStamp($msg->created_on)->diffForHumans();
                                $dt = date('d M Y, H:i', $msg->created_on);
                                if ($msg->sender == $me->id)
                                {
                                        $niem = 'You';
                                }
                                else
                                {
                                        $niem = $sender->first_name;
                                }
                                $feed .= '     
                        <div class="media innerBox msg-div" id="msg' . $msg->id . '" data-id="' . $msg->id . '">
                         <a href="profile/?id=' . $me->id . '" class="pull-left hidden-xs">' . theme_image('avatar/' . $feed_avt . '/30.png', array('alt' => "User", 'class' => "media-object", "width" => "30", 'height' => "30")) . ' </a>
                           <div class="media-body">
                              <div class="' . $rc . '">
                                  <div class="' . $sc . '9">
                                      <div class="chat-style">
                                          <div class="media">
                                             
                                              <div class="media-body">
                                                  <a href="profile/?id=' . $msg->sender . '" class="strong text-inverse">' . $niem . '</a><br />
                                                  ' . nl2br($msg->text) . ' </div>
                                          </div>
                                      </div>	
                                  </div>
                                  <div class="' . $sc . '3 hidden-xs">
                                      <span class="pull-right innerBox-right text-muted" title="' . $dt . '">'
                                             . '<i class="pull-right remove-message" id="' . $msg->id . '" data-user="' . $msg->sender . '">&times;</i><small>' . $ago . '</small></span>
                                  </div>
                              </div>
                          </div>
                       </div>';
                                $last = $msg->id;
                        }
                }
                echo '<div id="more0" class="more-messages-parent bg-gray innerBox innerBox-half text-center margin-none border-top border-bottom">
              <a href="#" class="load-more-messages text-muted" id="0" rel="' . $last . '">View older messsages (<span id="count-old-messages">0</span>)</a>
              </div>';
                echo ' <div class="border-top" id="text-messages" style="overflow: hidden;">';
                echo $feed . '   
               </div>

               <div class="active-message">
                  <div class="media">
                      <a href="#" class="pull-left">' . theme_image('avatar/' . $avt . '/30.png', array('alt' => "User", 'class' => "media-object", "width" => "45", 'height' => "45")) . ' </a>
                      <div class="media-body innerBox-topbottom innerBox-right">
                          <div class="innerBox-top innerBox-half pull-right message-btn-target">
                          <a href="#type" class="btn btn-default btn-sm" id="type-a-message" data-toggle="collapse">
                              <i class="glyphicon glyphglyphicon glyphicon-pencil"></i> Write
                          </a>
                          </div>
                          <h4 class="pull-left strong no-margin"> ' . $user->first_name . ' <br />
                              <span id="last-seen"> last seen today at -:-   </span>
                          </h4>
                      </div>
                  </div>
              </div>

              <div id="type" class="collapse border-top">
                      <div id="chat-toolbar">
                      <a id="emoticons" href="#"><span class="glyphicon glyphglyphicon glyphicon-tree-deciduous" title="emoticons"></span></a>
                      <a id="send-photo" href="#"><span class="glyphicon glyphglyphicon glyphicon-camera" title="send photo"></span></a>
                      <a id="send-location" href="#"><span class="glyphicon glyphglyphicon glyphicon-asterisk" title="send location"></span></a>
                      <a id="send-file" class="pull-right" href="#"><span class="glyphicon glyphglyphicon glyphicon-upload" title="send file"></span></a>
                      <div class="clearfix"></div>
                  </div>
                  <textarea type="text" class="composer form-control border-none" id="' . $id . '" placeholder="Write a message"></textarea>
              </div>

               <div id="type" class="collapse border-top">
                  <textarea type="text" class="form-control border-none" id="composer" placeholder="New Message"></textarea>
              </div>
                    ';
        }

        function chat_more_ajax()
        {
                
        }

        function chat_remove_ajax()
        {
                
        }

}
