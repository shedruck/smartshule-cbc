<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();

                if (!$this->ion_auth->logged_in()) {
                        redirect('admin/login');
                }
                $this->load->model('transport_m');
                $this->load->model('fee_structure/fee_structure_m');
                if ($this->input->get('sw')) {
                        $valid = $this->portal_m->get_class_ids();
                        $pop = $this->input->get('sw');
                        //limit to available classes only
                        if (!in_array($pop, $valid)) {
                                $pop = $valid[0];
                        }
                        $this->session->set_userdata('pop', $pop);
                } else if ($this->session->userdata('pop')) {
                        $pop = $this->session->userdata('pop');
                } else {
                }
        }

        function add_route()
        {
                $name = $this->input->post('name');
                //validate the fields of form
                if (!empty($name)) {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                                'name' => $name,
                                'created_by' => $user->id,
                                'created_on' => time()
                        );

                        $ok = $this->transport_m->create_route($form_data);
                        if ($ok) {
                                $details = implode(' , ', $this->input->post());
                                $user = $this->ion_auth->get_user();
                                $log = array(
                                        'module' =>  $this->router->fetch_module(),
                                        'item_id' => $ok,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
                                        'details' => $details,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );

                                $this->ion_auth->create_log($log);

                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        } else {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }
                } else {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Route Name cannot be Blank'));
                }
                redirect('admin/transport/routes/');
        }

        function students($id)
        {
                $data['routes'] = $this->transport_m->get_routes();
                $data['students'] = $this->transport_m->get_route_students($id);
                $data['stages'] =  $this->transport_m->get_rt_stages();
                $data['top'] = 1;
                $data['row'] = $this->transport_m->find_route($id);
                $this->template->title('Transport Routes')->build('admin/routes', $data);
        }

        function remove_stds()
        {
                if ($this->input->post()) {
                        $students = $this->input->post('student');

                        foreach ($students as $s) {


                                $ok = $this->transport_m->remove_student($s, 'transport');

                                //get fee extra to remove_extras
                                $fee_ex = $this->transport_m->get_f_extras($s);

                                foreach ($fee_ex as $ex) {
                                        $id = $ex->id;
                                        $del = $this->transport_m->delete($id, 'fee_extra_specs');
                                }
                        }

                        if (($ok) && ($del)) {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Selected Students removed successfully "));
                        } else {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Something went wrong "));
                        }

                        redirect("admin/transport/");
                }
        }

        /**
         * transport
         * 
         */
        public function index_()
        {
                $res = array();
                $classes = $this->ion_auth->list_classes();
                $streams = $this->ion_auth->get_stream();
                if ($this->input->post()) {
                        $route = $this->input->post('route');
                        $class = $this->input->post('class');
                        $term = $this->input->post('term');
                        $year = $this->input->post('year');
                        $stage = $this->input->post('stage');
                        $res = $this->transport_m->filter_transport($route, $class, $term, $year, $stage);
                        foreach ($res as $r) {
                                $student = $this->worker->get_student($r->student);
                                $row = $this->portal_m->fetch_class($student->class);
                                $cl = isset($classes[$row->class]) ? $classes[$row->class] : ' - ';
                                $stream = isset($streams[$row->stream]) ? $streams[$row->stream] : ' - ';
                                $r->class = $cl . ' ' . $stream;
                                $r->student = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
                                $r->adm = $student->admission_number ? $student->admission_number : $student->old_adm_no;
                        }
                }



                $list = ($this->input->post()) ? $this->transport_m->filter_transport($route, $class, $term, $year, $stage) : [];
                if ($this->input->post('export')) {
                        if (empty($list)) {
                                return FALSE;
                        }
                        return $this->export_data($list);
                }


                $routes = $this->transport_m->get_routes();
                $list = array();
                foreach ($routes as $r) {
                        $list[$r->id] = $r->name;
                }
                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);

                $ccc = array();
                foreach ($this->classlist as $key => $value) {
                        $sp = (object) $value;
                        $ccc[$key] = $sp->name;
                }

                $data['classes'] = $ccc;

                $data['yrs'] = $yrs;
                $data['res'] = $res;
                $data['routes'] = $list;
                $data['stages'] = $this->transport_m->populate('transport_stages', 'id', 'stage_name');
                $data['amounts'] =  $this->transport_m->get_route_amount();
                //load view
                $this->template->title(' Transport')->build('admin/report', $data);
        }


        public function index()
        {
                $res = array();
                $classes = $this->ion_auth->list_classes();
                $streams = $this->ion_auth->get_stream();
                if ($this->input->post()) {
                        $route = $this->input->post('route');
                        $class = $this->input->post('class');
                        $term = $this->input->post('term');
                        $year = $this->input->post('year');
                        $stage = $this->input->post('stage');
                        $res = $this->transport_m->filter_transport($route, $class, $term, $year, $stage);
                        foreach ($res as $r) 
                        {
                                
                                        $student = $this->worker->get_student($r->student);
                                        $row = $this->portal_m->fetch_class($student->class);
                                        $cl = isset($classes[$row->class]) ? $classes[$row->class] : ' - ';
                                        $stream = isset($streams[$row->stream]) ? $streams[$row->stream] : ' - ';
                                        $r->class = $cl . ' ' . $stream;
                                        $r->student = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
                                        $r->adm = $student->old_adm_no ? $student->old_adm_no : $student->admission_number;
                                // }
                        }
                }



                $list = ($this->input->post()) ? $this->transport_m->filter_transport($route, $class, $term, $year, $stage) : [];
                if ($this->input->post('export')) {
                        if (empty($list)) {
                                return FALSE;
                        }
                        return $this->export_data($list);
                }


                $routes = $this->transport_m->get_routes();
                $list = array();
                foreach ($routes as $r) {
                        $list[$r->id] = $r->name;
                }
                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);

                $ccc = array();
                foreach ($this->classlist as $key => $value) {
                        $sp = (object) $value;
                        $ccc[$key] = $sp->name;
                }

                $data['classes'] = $ccc;

                $data['yrs'] = $yrs;
                $data['res'] = $res;
                // $data['routes'] = $list;
                $data['routes'] = $this->transport_m->populate('transport_routes', 'id', 'name');
                $data['stages'] = $this->transport_m->populate('transport_stages', 'id', 'stage_name');
                $data['amounts'] =  $this->transport_m->get_route_amount();
                //load view
                $this->template->title(' Transport')->build('admin/report', $data);
        }

        function custom_transport()
        {
                $payload = [];
                $total = [];
                $custom = [];
                if($this->input->post())
                {
                        $class = $this->input->post('class');
                        $term = $this->input->post('term');
                        $year = $this->input->post('year');
                        $stage = $this->input->post('stage');
                        $route = $this->input->post('route');

                        $payload = $this->transport_m->filter_custom($route, $class, $stage, $term, $year);
                        $custom = $this->transport_m->custom_std($route, $class, $stage, $term, $year);
                        $total = $this->transport_m->custom_prep_total($route, $class, $stage, $term, $year);
                }

                $list = ($this->input->post()) ? $this->transport_m->filter_custom($route, $class, $stage, $term, $year) : [];
                if ($this->input->post('export')) 
                {
                        if (empty($list)) {
                                return FALSE;
                        }
                        return $this->export_data($list);
                }

                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);

                $data['yrs'] = $yrs;
                $data['payload'] = $payload;
                $data['custom'] = $custom;
                $data['total'] = $total;
                $data['routes'] = $this->transport_m->populate('transport_routes', 'id', 'name');
                $data['stages'] = $this->transport_m->populate('transport_stages', 'id', 'stage_name');
                //load view
                $this->template->title(' Transport')->build('admin/custom', $data);
        }


        function export_data_($data)
        {
                $delimiter = ",";
                $filename = "Transport_students_" . date('Y-m-d') . ".csv";
                $f = fopen('php://memory', 'w');
                $fields = array('No', 'Adm', 'Student', 'Class', 'Zone', 'Route', 'Way', 'Amount', 'Term', 'Year');
                fputcsv($f, $fields, $delimiter);
                $index = 1;
                foreach ($data as $r) {
                        $student = $this->worker->get_student($r->student);
                        $row = $this->portal_m->fetch_class($student->class);
                        $cl = isset($classes[$row->class]) ? $classes[$row->class] : ' - ';
                        $r->class = isset($this->streams[$student->class]) ? $this->streams[$student->class] : '';
                        $r->student = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
                        $r->adm = $student->admission_number ? $student->admission_number : $student->old_adm_no;

                        $routes = $this->transport_m->populate('transport_routes', 'id', 'name');
                        $stages = $this->transport_m->populate('transport_stages', 'id', 'stage_name');

                        $amounts =  $this->transport_m->get_route_amount();
                        $rtt = $amounts[$r->route];
                        $am = '';
                        $tt = "";
                        if ($r->way == 1) {
                                $tt = "One Way";
                                $am = $rtt['one_way_charge'];
                        } elseif ($r->way == 2) {
                                $tt = "Two Way";
                                $am = $rtt['two_way_charge'];
                        } else {
                                $am = '-';
                        }

                        $amountt = number_format($r->amount, 2);

                        $lineData = array($index, $r->adm, $r->student, $r->class, isset($routes[$r->route]) ? $routes[$r->route] : ' - ',  isset($stages[$r->stage]) ? $stages[$r->stage] : '-', $tt, $amountt, 'Term ' . $r->term, $r->year);
                        fputcsv($f, $lineData, $delimiter);
                        $index++;
                }

                fseek($f, 0);

                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');

                fpassthru($f);
                // exit();
        }


        function export_data($data)
        {
                $delimiter = ",";
                $filename = "Transport_students_" . date('Y-m-d') . ".csv";
                $f = fopen('php://memory', 'w');
                $fields = array('No', 'Adm', 'Student', 'Class', 'Zone', 'Route', 'Way', 'Amount', 'Term', 'Year');
                fputcsv($f, $fields, $delimiter);
                $index = 1;
                foreach ($data as $r) {
                        $student = $this->worker->get_student($r->student);
                        $row = $this->portal_m->fetch_class($student->class);
                        $cl = isset($classes[$row->class]) ? $classes[$row->class] : ' - ';
                        $r->class = isset($this->streams[$student->class]) ? $this->streams[$student->class] : '';
                        $r->student = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
                        $r->adm = $student->admission_number ? $student->admission_number : $student->old_adm_no;

                        $routes = $this->transport_m->populate('transport_routes', 'id', 'name');
                        $stages = $this->transport_m->populate('transport_stages', 'id', 'stage_name');

                        $amounts =  $this->transport_m->get_route_amount();
                        $rtt = $amounts[$r->route];
                        $am = '';
                        $tt = "";
                        if ($r->way == 1) {
                                $tt = "One Way";
                                // $am = $rtt['one_way_charge'];
                        } elseif ($r->way == 2) {
                                $tt = "Two Way";
                                // $am = $rtt['two_way_charge'];
                        }
                        // else
                        // {
                        //     $am = '-';
                        // }

                        $amountt = number_format($r->amount, 2);

                        $lineData = array($index, $r->adm, $r->student, $r->class, isset($routes[$r->route]) ? $routes[$r->route] : ' - ',  isset($stages[$r->stage]) ? $stages[$r->stage] : '-', $tt, $amountt, 'Term ' . $r->term, $r->year);
                        fputcsv($f, $lineData, $delimiter);
                        $index++;
                }

                fseek($f, 0);

                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');

                fpassthru($f);
                // exit();
        }

        public function invoice()
        {
                $res = array();
                $classes = $this->ion_auth->list_classes();
                $streams = $this->ion_auth->get_stream();
                if ($this->input->post()) {
                        $route = $this->input->post('route');
                        $class = $this->input->post('class');
                        $term = $this->input->post('term');
                        $year = $this->input->post('year');
                        $stage = $this->input->post('stage');
                        $res = $this->transport_m->filter_transport($route, $class, $term, $year, $stage);

                        foreach ($res as $r) {
                                $student = $this->worker->get_student($r->student);
                                $row = $this->portal_m->fetch_class($student->class);
                                $cl = isset($classes[$row->class]) ? $classes[$row->class] : ' - ';
                                $stream = isset($streams[$row->stream]) ? $streams[$row->stream] : ' - ';
                                $r->class = $cl . ' ' . $stream;
                                $r->student = $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name;
                                $r->adm = $student->old_adm_no ? $student->old_adm_no : $student->admission_number;
                                $r->stud = $student->id;
                        }
                }
                $routes = $this->transport_m->get_routes();
                $list = array();
                foreach ($routes as $r) {
                        $list[$r->id] = $r->name;
                }
                $range = range(date('Y') - 15, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);

                $ccc = array();
                foreach ($this->classlist as $key => $value) {
                        $sp = (object) $value;
                        $ccc[$key] = $sp->name;
                }

                $data['classes'] = $ccc;

                $data['yrs'] = $yrs;
                $data['res'] = $res;
                $data['routes'] = $list;
                $data['njia'] = $this->transport_m->list_routes();
                $data['stages'] = $this->transport_m->populate('transport_stages', 'id', 'stage_name');
                //load view
                $this->template->title(' Transport')->build('admin/invoice', $data);
        }


        public function invoice_std_old()
        {
                $this->form_validation->set_rules($this->ex_validation());


                if ($this->input->post()) {
                        if ($this->form_validation->run()) {
                                $slist = $this->input->post('sids');
                                $route = $this->input->post('route');
                                $way = $this->input->post('way');
                                $term = $this->input->post('term');
                                $year = $this->input->post('year');
                                $stage = $this->input->post('stage');
                                $stagee = $this->input->post('stagee');


                                // print_r($way);die;
                                $i = 0;
                                $j = 0;


                                $fields = [1 => "one_way_charge", 2 => "two_way_charge"];
                                if (is_array($slist) && count($slist) && is_array($route) && count($route) && is_array($way) && count($way)) {

                                        $count = count($slist);
                                        for ($k = 0; $k < $count; $k++) {
                                                $amount = $this->transport_m->this_route_($fields[$way[$k]], $route[$k]);

                                                $am = isset($amount[$fields[$way[$k]]]) ? $amount[$fields[$way[$k]]] : '0';



                                                $f_ids = $this->transport_m->get_fee_extra_($way[$k], $route[$k]);


                                                $rt = array(
                                                        'student' => $slist[$k],
                                                        'term' => $term,
                                                        'year' => $year,
                                                        'route' => $route[$k],
                                                        'way' => $way[$k],
                                                        'status' => 1,
                                                        'created_on' => time(),
                                                        'created_by' => $this->ion_auth->get_user()->id,
                                                        'stage' => $stagee[$k]
                                                );


                                                // invoicing starts here
                                                $data = array(
                                                        'student' => $slist[$k],
                                                        'term' => $term,
                                                        'year' => $year,
                                                        'amount' => $am,
                                                        'description' => 'Transport',
                                                        'fee_id' => $f_ids,
                                                        'created_on' => time(),
                                                        'created_by' => $this->ion_auth->get_user()->id,
                                                        'qb_status' => 0,
                                                        'status' => 0,
                                                        'flagged' => 0,
                                                );
                                                $has_rt = $this->transport_m->has_route($route[$k], $slist[$k], $term, $year);
                                                if ($has_rt) {
                                                        $put = $this->transport_m->set_route_update($has_rt, $rt);
                                                        $j++;
                                                } else {
                                                        $put = $this->transport_m->create($rt);
                                                        $this->transport_m->invoice_rt($data);
                                                        if ($put) {
                                                                $i++;
                                                        }
                                                }
                                        }
                                }



                                $details = implode(' , ', $this->input->post());
                                $user = $this->ion_auth->get_user();
                                $log = array(
                                        'module' =>  $this->router->fetch_module(),
                                        'item_id' => $put,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $put,
                                        'details' => $details,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );

                                $this->ion_auth->create_log($log);


                                $mess = 'Status:  ' . $i . ' new and Updated ' . $j . ' Existing Routes ';
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                        }
                        redirect('admin/transport/');
                }
                $range = range(date('Y') - 1, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['list'] = $this->transport_m->populate('transport_routes', 'id', 'name');
                $data['stages'] = $this->transport_m->populate('transport_stages', 'id', 'stage_name');
                $data['rts'] = $this->transport_m->transport_routes();
                //load view
                $this->template->title(' Transport ')->build('admin/home', $data);
        }




        public function invoice_std()
        {
                $this->form_validation->set_rules($this->ex_validation());

                if ($this->input->post()) {
                        if ($this->form_validation->run()) {

                                $slist = $this->input->post('sids');
                                $route = $this->input->post('route');
                                $way = $this->input->post('way');
                                $term = $this->input->post('term');
                                $year = $this->input->post('year');
                                $stage = $this->input->post('stage');

                                $i = 0;
                                $j = 0;

                                $fields = [1 => "one_way_charge", 2 => "two_way_charge"];
                                if (is_array($slist) && count($slist) && is_array($route) && count($route) && is_array($way) && count($way)) {

                                        $invoice = $this->transport_m->get_series();
                                        $invoice_no = 'INMT' . $invoice;
                                        foreach ($slist as $ss) {
                                                $invoice_no++;
                                                $f_way = $way[$ss];
                                                $f_route = $route[$ss];
                                                $f_stage = isset($stage[$ss]) ? $stage[$ss] : '';



                                                $res = $this->transport_m->find_route($f_route);

                                                if ($f_way == 1) {
                                                        $am = $res->one_way_charge;
                                                } elseif ($f_way == 2) {
                                                        $am = $res->two_way_charge;
                                                }

                                               


                                                $rt = [
                                                        'student' => $ss,
                                                        'term' => $term,
                                                        'stage' => $f_stage,
                                                        'status' => 1,
                                                        'year' => $year,
                                                        'route' => $f_route,
                                                        'amount' => $am,
                                                        'way' => $f_way,
                                                        'qb_status' => 0,
                                                        'f_status' => 0,
                                                        'flagged' => 0,
                                                        'created_by' => $this->ion_auth->get_user()->id,
                                                        'created_on' => time(),
                                                        'invoice_no' => $invoice_no
                                                ];



                                                $has_rt = $this->transport_m->has_route($ss, $term, $year);
                                                if ($has_rt) {
                                                        $put = $this->transport_m->set_route_update($has_rt, $rt);
                                                        $j++;
                                                } else {
                                                        $put = $this->transport_m->create($rt);
                                                        if ($put) {
                                                                $i++;
                                                        }
                                                }
                                        }
                                }


                                $details = implode(' , ', $this->input->post());
                                $user = $this->ion_auth->get_user();
                                $log = array(
                                        'module' => $this->router->fetch_module(),
                                        'item_id' => $put,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $put,
                                        'details' => $details,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );

                                $this->ion_auth->create_log($log);

                                $mess = 'Status:  ' . $i . ' new and Updated ' . $j . ' Existing Routes ';
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                        }
                        redirect('admin/transport/');
                }
                $range = range(date('Y') - 1, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['list'] = $this->transport_m->populate('transport_routes', 'id', 'name');
                $data['stages'] = $this->transport_m->populate('transport_stages', 'id', 'stage_name');
                $data['rts'] = $this->transport_m->transport_routes();
                //load view
                $this->template->title(' Transport ')->build('admin/home', $data);
        }

        public function add_new()
        {
                $this->form_validation->set_rules($this->ex_validation());
                if ($this->input->post()) {
                        if ($this->form_validation->run()) {
                                $slist = $this->input->post('sids');
                                $route = $this->input->post('route');
                                $way = $this->input->post('way');
                                $term = $this->input->post('term');
                                $year = $this->input->post('year');
                                $stage = $this->input->post('stage');
                                $amount = $this->input->post('amount');

                                $res = $this->transport_m->find_route($route);

                                $i = 0;
                                $j = 0;

                                if (is_array($slist) && count($slist)) {
                                        $fee_id = $this->transport_m->get_fee_extra_($way, $route);
                                        // foreach($f_ids as $fids){
                                        //         $fee_id= $fids->id;
                                        // }

                                        foreach ($slist as $s) {
                                                $rt = array(
                                                        'student' => $s,
                                                        'term' => $term,
                                                        'year' => $year,
                                                        'route' => $route,
                                                        'way' => $way,
                                                        'status' => 1,
                                                        'created_on' => time(),
                                                        'created_by' => $this->user->id,
                                                        'stage' => $stage
                                                );

                                                $data = array(
                                                        'student' => $s,
                                                        'term' => $term,
                                                        'year' => $year,
                                                        'amount' => $amount,
                                                        'description' => 'Transport',
                                                        'fee_id' => $fee_id,
                                                        'created_on' => time(),
                                                        'created_by' => $this->user->id
                                                );

                                                $has_rt = $this->transport_m->has_route($route, $s, $term, $year);
                                                $has_id = $this->transport_m->is_invoiced($fee_id, $s, $term, $year);
                                                if ($has_rt || $has_id) {
                                                        $put = $this->transport_m->set_route_update($has_rt, $rt);
                                                        $this->transport_m->update_fee($has_id, $data);
                                                        $j++;
                                                } else {
                                                        $put = $this->transport_m->create($rt);
                                                        $this->transport_m->invoice_rt($data);
                                                        if ($put) {
                                                                $i++;
                                                        }
                                                }




                                                $this->transport_m->invoice_rt($data);
                                        }
                                }

                                $details = implode(' , ', $this->input->post());
                                $user = $this->ion_auth->get_user();
                                $log = array(
                                        'module' =>  $this->router->fetch_module(),
                                        'item_id' => $put,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $put,
                                        'details' => $details,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );

                                $this->ion_auth->create_log($log);


                                $mess = 'Status:  ' . $i . ' new and Updated ' . $j . ' Existing Routes ';
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                        }
                        redirect('admin/transport/add');
                }
                $range = range(date('Y') - 1, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['list'] = $this->transport_m->populate('transport_routes', 'id', 'name');
                $data['stages'] = $this->transport_m->populate('transport_stages', 'id', 'stage_name');
                $data['rts'] = $this->transport_m->transport_routes();
                //load view
                $this->template->title(' Transport ')->build('admin/home', $data);
        }
        public function add_()
        {
                $this->form_validation->set_rules($this->ex_validation());
                if ($this->input->post()) {
                        if ($this->form_validation->run()) {
                                $slist = $this->input->post('sids');
                                $route = $this->input->post('route');
                                $way = $this->input->post('way');
                                $term = $this->input->post('term');
                                $year = $this->input->post('year');
                                $stage = $this->input->post('stage');
                                $amount = $this->input->post('amount');
                                $res = $this->transport_m->find_route($route);

                                // echo '<pre>';
                                // print_r($this->input->post());
                                // echo '</pre>';
                                // die;

                                $i = 0;
                                $j = 0;

                                if (is_array($slist) && count($slist)) {
                                        $invoice = $this->transport_m->get_series();
                                        $invoice_no = 'INMT' . $invoice;

                                        foreach ($slist as $s) {

                                                $invoice_no++;

                                                $edit = 0;
                                                if ($way == 1) {
                                                        if ($amount != $res->one_way_charge) {
                                                                $edit = 1;
                                                        }
                                                }

                                                if ($way == 2) {
                                                        if ($amount != $res->two_way_charge) {
                                                                $edit = 1;
                                                        }
                                                }

                                                // echo $edit;die;


                                                $rt = [
                                                        'student' => $s,
                                                        'term' => $term,
                                                        'stage' => $stage,
                                                        'status' => 0,
                                                        'year' => $year,
                                                        'route' => $route,
                                                        'amount' => $amount,
                                                        'way' => $way,
                                                        'edited' => $edit,
                                                        'qb_status' => 0,
                                                        'f_status' => 0,
                                                        'flagged' => 0,
                                                        'created_by' => $this->ion_auth->get_user()->id,
                                                        'created_on' => time(),
                                                        'invoice_no' => $invoice_no
                                                ];


                                                $has_rt = $this->transport_m->has_route($s, $term, $year);
                                                if ($has_rt) {
                                                        $put = $this->transport_m->set_route_update($has_rt, $rt);
                                                        $j++;
                                                } else {
                                                        $put = $this->transport_m->create($rt);
                                                        if ($put) {
                                                                $i++;
                                                        }
                                                }
                                        }
                                }

                                $details = implode(' , ', $this->input->post());
                                $user = $this->ion_auth->get_user();
                                $log = array(
                                        'module' =>  $this->router->fetch_module(),
                                        'item_id' => $put,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $put,
                                        'details' => $details,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );

                                $this->ion_auth->create_log($log);


                                $mess = 'Status:  ' . $i . ' new and Updated ' . $j . ' Existing Routes ';
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                        }
                        redirect('admin/transport/add');
                }
                $range = range(date('Y') - 1, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['list'] = $this->transport_m->populate('transport_routes', 'id', 'name');
                $data['stages'] = $this->transport_m->populate('transport_stages', 'id', 'stage_name');
                $data['rts'] = $this->transport_m->transport_routes();
                //load view
                $this->template->title(' Transport ')->build('admin/home', $data);
        }

        public function add()
        {
                $this->form_validation->set_rules($this->ex_validation());
                if ($this->input->post()) {
                        if ($this->form_validation->run()) {
                                $slist = $this->input->post('sids');
                                $route = $this->input->post('route');
                                $way = $this->input->post('way');
                                $term = $this->input->post('term');
                                $year = $this->input->post('year');
                                $stage = $this->input->post('stage');
                                $amount = $this->input->post('amount');
                                $res = $this->transport_m->find_route($route);
                                $month = $this->input->post('month');
                                $day = $this->input->post('day');

                                

                                $i = 0;
                                $j = 0;

                                if (is_array($slist) && count($slist)) {
                                        $invoice = $this->transport_m->get_series();
                                        $invoice_no = 'INMT' . $invoice;

                                        foreach ($slist as $s) {

                                                $invoice_no++;

                                                $edit = 0;
                                                if ($way == 1)
                                                {
                                                    if ($amount != $res->one_way_charge)
                                                    {
                                                        $edit = 1;
                                                    }
                                                }
                        
                                                if ($way == 2)
                                                {
                                                    if ($amount != $res->two_way_charge)
                                                    {
                                                        $edit = 1;
                                                    }
                                                }

                                                $rt = [
                                                        'student' => $s,
                                                        'term' => $term,
                                                        'stage' => $stage,
                                                        'status' => 1,
                                                        'year' => $year,
                                                        'route' => $route,
                                                        'amount' => $amount,
                                                        'way' => $way,
                                                        'qb_status' => 0,
                                                        'f_status' => 0,
                                                        'flagged' => 0,
                                                        'created_by' => $this->ion_auth->get_user()->id,
                                                        'created_on' => time(),
                                                        'invoice_no' => $invoice_no,
                                                        'custom' => ($day || $month) ? 1 : 0,
                                                        'description' => $day ? $day : $month,
                                                        'edited' => $edit
                                                ];

                                                if($month || $day)
                                                {
                                                        $put = $this->transport_m->create($rt);
                                                        if ($put) 
                                                        {
                                                                $i++;
                                                        }   
                                                }
                                                else
                                                {
                                                        $has_rt = $this->transport_m->has_route($s, $term, $year);
                                                        if ($has_rt) 
                                                        {
                                                                $put = $this->transport_m->set_route_update($has_rt, $rt);
                                                                $j++;
                                                        } else 
                                                        {
                                                                $put = $this->transport_m->create($rt);
                                                                if ($put) 
                                                                {
                                                                        $i++;
                                                                }
                                                        }
                                                }
                                        }
                                }

                                $details = implode(' , ', $this->input->post());
                                $user = $this->ion_auth->get_user();
                                $log = array(
                                        'module' =>  $this->router->fetch_module(),
                                        'item_id' => $put,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $put,
                                        'details' => $details,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );

                                $this->ion_auth->create_log($log);


                                $mess = 'Status:  ' . $i . ' new and Updated ' . $j . ' Existing Routes ';
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                        }
                        redirect('admin/transport/add');
                }
                $range = range(date('Y') - 1, date('Y') + 1);
                $yrs = array_combine($range, $range);
                krsort($yrs);
                $data['yrs'] = $yrs;
                $data['list'] = $this->transport_m->populate('transport_routes', 'id', 'name');
                $data['stages'] = $this->transport_m->populate('transport_stages', 'id', 'stage_name');
                $data['rts'] = $this->transport_m->transport_routes();
                //load view
                $this->template->title(' Transport ')->build('admin/home', $data);
        }

        public function routes()
        {
                if ($this->input->post()) {
                        $name = $this->input->post('name');
                        //validate the fields of form
                        if (!empty($name)) {         //Validation OK!
                                $user = $this->ion_auth->get_user();
                                $one_way = $this->input->post('one_way_charge');
                                $two_way = $this->input->post('two_way_charge');

                                $form_data = array(
                                        'name' => $name,
                                        'one_way_charge' => $one_way,
                                        'two_way_charge' => $two_way,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                );





                                $ok = $this->transport_m->create_route($form_data);
                                if ($one_way) {
                                        $daata = array(
                                                'title' => $name . ' (One way-' . number_format($one_way) . ')',
                                                'ftype' => '1',
                                                'cycle' => '9999',
                                                'amount' => $one_way,
                                                'description' => '1',
                                                'created_by' => $user->id,
                                                'created_on' => time(),
                                                'f_id' => $ok
                                        );
                                        $this->transport_m->add_extras_1($daata);
                                }

                                if ($two_way) {
                                        $dataa = array(
                                                'title' => $name . ' (Two way-' . number_format($two_way) . ')',
                                                'ftype' => '1',
                                                'cycle' => '9999',
                                                'amount' => $two_way,
                                                'description' => '2',
                                                'created_by' => $user->id,
                                                'created_on' => time(),
                                                'f_id' => $ok
                                        );
                                        $this->transport_m->add_extras_2($dataa);
                                }
                                if ($ok) {
                                        $details = implode(' , ', $this->input->post());
                                        $user = $this->ion_auth->get_user();
                                        $log = array(
                                                'module' =>  $this->router->fetch_module(),
                                                'item_id' => $ok,
                                                'transaction_type' => $this->router->fetch_method(),
                                                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
                                                'details' => $details,
                                                'created_by' => $user->id,
                                                'created_on' => time()
                                        );

                                        $this->ion_auth->create_log($log);

                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                } else {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                }
                        } else {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Route Name cannot be Blank'));
                        }
                        redirect('admin/transport/routes/');
                }
                $data['routes'] = $this->transport_m->get_routes();
                //load view
                $this->template->title('Transport Routes')->build('admin/routes', $data);
        }

        function stages($id)
        {
                $user = $this->ion_auth->get_user();
                if ($this->input->post()) {
                        $data = array(
                                'route' => $id,
                                'stage_name' => $this->input->post('stage'),
                                'created_by' => $user->id,
                                'created_on' => time()
                        );
                        $ok = $this->transport_m->create_stage($data);
                        if ($ok) {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Stage added successfully "));
                                redirect("admin/transport/stages/$id");
                        }
                }
                $data['stages'] = $this->transport_m->get_stages($id);
                $this->template->title('Transport Stages')->build('admin/stages', $data);
        }


        function get_stages($id)
        {
                $stages = $this->transport_m->get_stages($id);
                $st = [];

                foreach ($stages as $stage) {
                        $st[$stage->id] = $stage->stage_name;
                }

                echo json_encode($st);
        }

        /**
         * Fetch Default Amount Route/way
         * 
         * @return string
         */
        function fetch_default()
        {
                $route = $this->input->post('route');
                $way = $this->input->post('way');
                if ($route && $way) {
                        $res = $this->transport_m->find_route($route);
                        if (!$res) {
                                echo '0';
                                exit();
                        }

                        echo $way == 1 ? $res->one_way_charge : $res->two_way_charge;
                } else {
                        echo '0';
                }
        }

        function edit_route($id = 0)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/transport/routes');
                }
                if (!$this->transport_m->route_exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/transport/routes');
                }
                $get = $this->transport_m->find_route($id);

                if ($this->input->post())
                {
                        if (empty($this->input->post('name')))
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Route name cannot be Blank"));
                                redirect("admin/transport/");
                        }
                        $user = $this->ion_auth->get_user();
                        // build array for the model



                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'one_way_charge' => $this->input->post('one_way_charge'),
                            'two_way_charge' => $this->input->post('two_way_charge'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //get_fee_extra to update
                        
                        $xtra_1 = $this->transport_m->get_fee_extra_(1, $id);
                        $xtra_2 = $this->transport_m->get_fee_extra_(2, $id);

                        $upx1 = [
                                'title' => $this->input->post('name').' (One way-'.number_format($this->input->post('one_way_charge')).')',
                                'ftype' => '1',
                                'cycle' => '9999',
                                'amount' => $this->input->post('one_way_charge'),
                                'description' => '1',
                                'modified_by' => $user->id,
                                'modified_on' => time(),
                                'f_id' => $id
                        ];

                        $upx2 = [
                                'title' => $this->input->post('name').' (Two way-'.number_format($this->input->post('two_way_charge')).')',
                                'ftype' => '1',
                                'cycle' => '9999',
                                'amount' => $this->input->post('two_way_charge'),
                                'description' => '2',
                                'modified_by' => $user->id,
                                'modified_on' => time(),
                                'f_id' => $id
                        ];

                    
                        $done = $this->transport_m->update_route($id, $form_data);
                        if ($done)
                        {
                                //update fee_extras
                                // $this->transport_m->update_extras($xtra_1, $upx1);
                                // $this->transport_m->update_extras($xtra_2, $upx2);

                                if(empty($xtra_1))
                                {
                                       $this->transport_m->add_extras_1($upx1); 
                                }
                                elseif(empty($xtra_2))
                                {
                                        $this->transport_m->add_extras_1($upx2); 
                                }
                                elseif(!empty($xtra_1) || !empty($xtra_2))
                                {
                                        $this->transport_m->update_extras($xtra_1, $upx1);
                                        $this->transport_m->update_extras($xtra_2, $upx2);

                                }
                                     


                                $details = implode(' , ', $this->input->post());
                                                                $user = $this->ion_auth->get_user();
                                                                        $log = array(
                                                                                'module' =>  $this->router->fetch_module(), 
                                                                                'item_id' => $done, 
                                                                                'transaction_type' => $this->router->fetch_method(), 
                                                                                'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
                                                                                'details' => $details,   
                                                                                'created_by' => $user -> id,   
                                                                                'created_on' => time()
                                                                        );

                                                                  $this->ion_auth->create_log($log);
                                                                
                                                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Error'));
                        }
                        redirect("admin/transport/routes");
                }
                $data['result'] = $get;

                //load the view and the layout
                $this->template->title('Edit Route ')->build('admin/routes', $data);
        }


        function delete_route($id = 0)
        {
                if (!$id || !$this->transport_m->route_exists($id)) {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/transport/routes');
                }
                //delete the item
                if ($this->transport_m->delete($id, 'transport_routes') == TRUE) {
                        // $details = implode(' , ', $this->input->post());
                        $user = $this->ion_auth->get_user();
                        $log = array(
                                'module' =>  $this->router->fetch_module(),
                                'item_id' => $id,
                                'transaction_type' => $this->router->fetch_method(),
                                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $id,
                                'details' => 'Record Deleted',
                                'created_by' => $user->id,
                                'created_on' => time()
                        );

                        $this->ion_auth->create_log($log);

                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                } else {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }
                redirect("admin/transport/routes/");
        }

        private function ex_validation()
        {
                $config = array(
                        array(
                                'field' => 'sids',
                                'label' => 'Student List',
                                'rules' => 'xss_clean|callback__valid_sid'
                        ),
                        array(
                                'field' => 'route',
                                'label' => 'Route',
                                'rules' => 'required|xss_clean'
                        ),
                        array(
                                'field' => 'year',
                                'label' => 'Year',
                                'rules' => 'required|xss_clean'
                        ),
                        array(
                                'field' => 'term',
                                'label' => 'Term',
                                'rules' => 'required|xss_clean'
                        )
                );
                $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
                return $config;
        }

        function _valid_sid()
        {
                $sid = $this->input->post('sids');
                if (is_array($sid) && count($sid)) {
                        return TRUE;
                } else {
                        $this->form_validation->set_message('_valid_sid', 'Please Select at least one Student.');
                        return FALSE;
                }
        }

        function get_transporters($id)
        {
                $students = $this->transport_m->fetch_stds($id);
                echo '<pre>';
                print_r($students);
                echo '</pre>';
        }

        function check_series()
        {
                echo '<pre>';
                print_r($this->transport_m->get_series());
                echo '</pre>';
                die;
        }

        function move_stds()
        {
                $extras = $this->transport_m->transport_heads();

                $payload = [];
                // die;
                foreach ($extras as $key => $x) {
                        $students = $this->transport_m->tx_stds($x);

                        $i = 0;

                        foreach ($students as $s) {
                                // $payload[] = $s;
                                $fee = $this->transport_m->get_fee($s->fee_id);

                                $payload[] = [
                                        'student' => $s->student,
                                        'term' => $s->term,
                                        'status' => $s->status,
                                        'year' => $s->year,
                                        'route' => $fee->f_id,
                                        'amount' => $s->amount,
                                        'way' => $fee->description,
                                        'edited' => $s->edited,
                                        'qb_status' => $s->qb_status,
                                        'f_status' => $s->f_status,
                                        'flagged' => $s->flagged,
                                        'created_by' => $s->created_by,
                                        'created_on' => $s->created_on,
                                        'invoice_no' => $s->invoice_no,
                                        'list_id' => $s->list_id,
                                        'edit_sequence' => $s->edit_sequence,
                                        'txn_id' => $s->txn_id
                                ];

                                //        if($this->transport_m->create($payload))
                                //        {
                                //                $i++;
                                //        }
                        }
                }


                echo '<pre> Success: Moved - ';
                print_r(count($payload));
                echo '</pre>';
                die;
        }

        function clean_stds()
        {
                $extras = $this->transport_m->transport_heads();

                $payload = [];
                // die;
                foreach ($extras as $key => $x) {
                        $students = $this->transport_m->tx_stds($x);

                        $i = 0;

                        foreach ($students as $s) {
                                $payload[] = $s;
                                $fee = $this->transport_m->get_fee($s->fee_id);



                                // if($this->fee_structure_m->remove_extras($s->id))
                                // {
                                //         $i++;
                                // }
                        }
                }


                echo '<pre> Removed - <br>';
                print_r($payload);
                echo '</pre>';
                die;
        }

        function move_payments()
        {
                $extras = $this->transport_m->transport_heads();

                $payload = [];
                // die;
                foreach ($extras as $key => $x) {
                        $payments = $this->transport_m->transport_pay($x);

                        $i = 0;

                        foreach ($payments as $s) {

                                $this->transport_m->do_update('fee_split', ['fee_id' => 8888], $s->id);
                                $i++;
                        }
                }


                echo '<pre> Success: Moved - ';
                print_r($i);
                echo '</pre>';
                die;
        }
}
