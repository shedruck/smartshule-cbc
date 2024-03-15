<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SMS extends Public_Controller
{

        function __construct()
        {
                parent::__construct();
                /* $this->template->set_layout('default');
                  $this->template->set_partial('sidebar', 'partials/sidebar.php')
                  ->set_partial('top', 'partials/top.php'); */
                if (!$this->ion_auth->logged_in())
                {
                        // redirect('admin/login');
                }

                /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
                  {
                  $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                  redirect('admin');
                  } */

                $this->load->model('sms_m');
        }

        public function index()
        {
                $this->load->model('sms_m');
                $data['sms'] = $this->sms_m->my_sms();
                //load the view and the layout
                $this->template->title('My Messages ')->set_layout('portal')->build('index', $data);
        }

        function server()
        {
                $this->load->library('Guzzle');
                $this->load->library('Queue');

                $bean = ['host' => '127.0.0.1', 'port' => '11300'];
                $file = dirname(__FILE__) . '/log.png';

                $server = new Pheanstalk\Pheanstalk('127.0.0.1', '11300', 10);
                $worker = new Queue($bean);

                $this->asc($file);
                echo "Listening on {$bean['host']}:{$bean['port']} \n\n*********************\n\n";

                // pick a job and process it
                while ($job = $server->watch('kinder')->ignore('default')->reserve())
                {
                        $received = json_decode($job->getData(), true);

                        $action = $received['action'];
                        if (isset($received['data']))
                        {
                                $data = $received['data'];
                        }
                        else
                        {
                                $data = array();
                        }

                        echo "Received a Task: $action (at " . date('d M Y H:i:s') . ") ...\n";

                        if (method_exists($worker, $action))
                        {
                                $outcome = $worker->$action($data);
                                if ($outcome)
                                {
                                        echo "done \n";
                                        $server->delete($job);
                                }
                                else
                                {
                                        echo "failed \n";
                                        $server->bury($job);
                                }
                        }
                        else
                        {
                                echo "action not found\n";
                                $server->bury($job);
                        }
                }
        }

        function test()
        {
              /*  $this->load->model('sms/sms_m');
                $ls = $this->sms_m->send_sms('09', 'Hello,  sms has been configured');
                echo '<pre>';
                print_r($ls);
                print_r('sent');
                echo '</pre>';*/
        }

        function asc($file)
        {
                echo "get file " . $file;
                $img = imagecreatefromstring(file_get_contents($file));
                list($width, $height) = getimagesize($file);
                echo "lost file " . $file;
                $scale = 7;
                $chars = array('.', '\'', '.', '*', '|', '*', '*', '*', ' ',);
                $c_count = count($chars);
                for ($y = 0; $y <= $height - $scale - 1; $y += $scale)
                {
                        for ($x = 0; $x <= $width - ($scale / 2) - 1; $x += ($scale / 2))
                        {
                                $rgb = imagecolorat($img, $x, $y);
                                $r = (($rgb >> 16) & 0xFF);
                                $g = (($rgb >> 8) & 0xFF);
                                $b = ($rgb & 0xFF);
                                $sat = ($r + $g + $b) / (255 * 3);
                                echo $chars[(int) ( $sat * ($c_count - 1) )];
                        }
                        echo PHP_EOL;
                }
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/sms/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
                $config['total_rows'] = $this->sms_m->count();
                $config['uri_segment'] = 4;

                $config['first_link'] = lang('web_first');
                $config['first_tag_open'] = "<li>";
                $config['first_tag_close'] = '</li>';
                $config['last_link'] = lang('web_last');
                $config['last_tag_open'] = "<li>";
                $config['last_tag_close'] = '</li>';
                $config['next_link'] = FALSE;
                $config['next_tag_open'] = "<li>";
                $config['next_tag_close'] = '</li>';
                $config['prev_link'] = FALSE;
                $config['prev_tag_open'] = "<li>";
                $config['prev_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li class="active">  <a href="#">';
                $config['cur_tag_close'] = '</a></li>';
                $config['num_tag_open'] = "<li>";
                $config['num_tag_close'] = '</li>';
                $config['full_tag_open'] = "<div class='pagination  pagination-centered'><ul>";
                $config['full_tag_close'] = '</ul></div>';
                $choice = $config["total_rows"] / $config["per_page"];
                //$config["num_links"] = round($choice);

                return $config;
        }

}
