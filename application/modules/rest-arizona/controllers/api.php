<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Public_Controller
{

        public $user;

        public function __construct()
        {
                parent::__construct();
                header("Access-Control-Allow-Origin:*");
                header('Content-type: application/json');
                header("Access-Control-Allow-Methods:GET,OPTIONS");
                header("Access-Control-Allow-Methods:POST");
                header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding,Authorization,X-API-Version");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400');

                if ($this->ion_auth->logged_in())
                {
                        $this->user = $this->ion_auth->user()->row();
                }
                $this->load->model('api_m');
                $this->load->library('Guzzle');
        }

        /**
         * Fetch Stats For Selected Group
         */
        function students()
        {
                $stats = [];
                $students = $this->api_m->count_students();
                $recent = $this->api_m->get_recent_students();
                $classes = $this->portal_m->get_class_options();
                $classlist = $this->portal_m->get_all_classes();
                $streams = $this->portal_m->get_all_streams();
                $stats['total'] = $students;
                $stats['classes'] = $classes;
                $stats['classlist'] = $classlist;
                $stats['streams'] = $streams;
                $stats['recent'] = $recent;

                $path = FCPATH . 'uploads/Dropbox/' . date('Y') . '/' . date('M') . '/';
                if (!file_exists($path))
                {
                        $old = umask(0);
                        mkdir($path, 0777, true);
                        umask($old);
                }
                $fname = 'adm-' . date('d') . '.json';
                $file = fopen($path . $fname, 'w');
                fwrite($file, json_encode($stats));
                fclose($file);
                //chmod($path . $fname, 0777);

                echo json_encode($stats, JSON_NUMERIC_CHECK);
        }

        function paid()
        {
                $this->load->model('fee_payment/fee_payment_m');
                $this->load->model('expenses/expenses_m');
                $this->load->model('fee_waivers/fee_waivers_m');
                $fee = [];
                $fee['paid'] = $this->fee_payment_m->full_total_fees()->total ? $this->fee_payment_m->full_total_fees()->total : 0;
                $fee['expenses'] = $this->expenses_m->total_expenses()->total ? $this->expenses_m->total_expenses()->total : 0;
                $fee['waiver'] = $this->fee_waivers_m->total_waiver()->total ? $this->fee_waivers_m->total_waiver()->total : 0;
                ///Salaries Balances
                $basic = $this->expenses_m->total_basic();
                $allowances = $this->expenses_m->total_allowances();
                $deductions = $this->expenses_m->total_deductions();
                $nhif = $this->expenses_m->total_nhif();
                $total_paid = ($basic->basic + $allowances->allowance + $nhif->nhif + $deductions->total);
                $fee['payroll'] = $total_paid;
                $fee['recent'] = $this->api_m->get_payments();

                $path = FCPATH . 'uploads/Dropbox/' . date('Y') . '/' . date('M') . '/';
                if (!file_exists($path))
                {
                        $old = umask(0);
                        mkdir($path, 0777, true);
                        umask($old);
                }
                $fname = 'pay-' . date('d') . '.json';
                $file = fopen($path . $fname, 'w');
                fwrite($file, json_encode($fee));
                fclose($file);
                //chmod($path . $fname, 0777);

                echo json_encode($fee, JSON_NUMERIC_CHECK);
        }

        function poll()
        {
                $data = array('now' => time());
                echo json_encode($data, JSON_NUMERIC_CHECK);
        }

        function fee()
        {
                $this->load->model('reports/reports_m');
                $yr = date('Y');
                $term = get_term(date('m'));
                $feed = array();

                $arrs = $this->fee_payment_m->fetch_total_arrears();
                $classes = $this->portal_m->get_class_options();
                $streams = $this->reports_m->populate('class_stream', 'id', 'name');
                $fee = $this->reports_m->fee_summary($term, $yr);
                $ffin = array();
                $ibal = $arrs;

                if (empty($fee) || !isset($fee[$yr]) || !isset($fee[$yr][$term]))
                {
                        $feed['invoices'] = 0;
                        $feed['waivers'] = 0;
                        $feed['paid'] = 0;
                        $feed['bal'] = 0;
                        $feed['time'] = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end') . ' sec';
                        $feed['list'] = array();
                }
                else
                {
                        krsort($fee);
                        $groups = $fee[$yr][$term];
                        ksort($groups);

                        $tm_inv = 0;
                        $tm_wv = 0;
                        $tm_pd = 0;
                        foreach ($groups as $class_group => $str_parts)
                        {
                                foreach ($str_parts as $stream => $parts)
                                {
                                        $pt = (object) $parts;
                                        $cl = isset($classes[$class_group]) ? $classes[$class_group] : $class_group . ' - ' . $class_group;
                                        $scl = isset($classes[$class_group]) ? class_to_short($cl) : $cl . ' - ' . $class_group;
                                        $strr = isset($streams[$stream]) ? $streams[$stream] : ' - ' . $stream;
                                        $paid = (isset($pt->credit) && is_array($pt->credit)) ? array_sum($pt->credit) : 0;
                                        $inv = (isset($pt->debit) && is_array($pt->debit)) ? array_sum($pt->debit) : 0;

                                        $wiv = (isset($pt->waivers) && is_array($pt->waivers)) ? array_sum($pt->waivers) : 0;
                                        $dbal = (isset($pt->bal) && is_array($pt->bal)) ? array_sum($this->filter_pos($pt->bal)) : 0;

                                        $tm_inv += $inv;
                                        $tm_wv += $wiv;
                                        $tm_pd += $paid;

                                        $ibal += $dbal;
                                        $ffin[$scl . ' ' . $strr]['class'] = $class_group;
                                        $ffin[$scl . ' ' . $strr]['stream'] = $stream;
                                        $ffin[$scl . ' ' . $strr]['inv'] = $inv;
                                        $ffin[$scl . ' ' . $strr]['wiv'] = $wiv;
                                        $ffin[$scl . ' ' . $strr]['paid'] = $paid;
                                        $ffin[$scl . ' ' . $strr]['bal'] = $dbal;
                                }
                        }

                        $feed['invoices'] = $tm_inv;
                        $feed['waivers'] = $tm_wv;
                        $feed['paid'] = $tm_pd;
                        $feed['bal'] = $ibal;
                        $feed['time'] = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end') . ' sec';
                        $feed['list'] = $ffin;
                }
                $path = FCPATH . 'uploads/Dropbox/' . date('Y') . '/' . date('M') . '/';
                if (!file_exists($path))
                {
                        $old = umask(0);
                        mkdir($path, 0777, true);
                        umask($old);
                }
                $fname = 'fee-' . date('d') . '.json';
                $file = fopen($path . $fname, 'w');
                fwrite($file, json_encode($feed));
                fclose($file);
                //chmod($path . $fname, 0777);

                echo json_encode($feed, JSON_NUMERIC_CHECK);
        }

        function filter_pos($array)
        {
                return array_filter($array, function ($num)
                {
                        return $num > 0;
                });
        }

        function asc($file)
        {
                $img = imagecreatefromstring(file_get_contents($file));
                list($width, $height) = getimagesize($file);
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

        function index()
        {
                die();
        }

}
