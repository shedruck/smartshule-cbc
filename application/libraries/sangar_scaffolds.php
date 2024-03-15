<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

//require_once FCPATH . 'sparks/php-activerecord/0.0.2/vendor/php-activerecord/ActiveRecord.php';

    class Sangar_scaffolds
    {

        public $dbdriver;
        public $controller_name;
        public $model_name;
        public $model_name_for_calls;
        public $scaffold_code;
        public $scaffold_model_type;
        public $arrayjson;
        public $errors;
        public $actual_language;
        public $languages;
        public $scaffold_delete_bd;
        public $scaffold_bd;
        public $scaffold_routes;
        public $scaffold_menu;
        public $create_controller;
        public $create_model;
        public $create_view_create;
        public $create_view_list;
        public $tab;
        public $tabx2;
        public $tabx3;
        public $tabx4;
        public $tabx5;
        public $tabx6;
        public $tabx7;
        public $sl;
        public $there_is_an_image;
        public $there_is_a_file;
        public $there_is_a_multilanguage_field;
        public $array_thumbnails_uploads;
        public $array_required_fields_uploads;
        public $there_is_a_relational_field;
        public $relational_field;
        public $relational_controller;
        public $relational_model;

        public function __construct()
        {
            $this->ci = & get_instance();

            $this->ci->load->database();
            $this->dbdriver = $this->ci->db->dbdriver;

            $this->actual_language = $this->ci->config->item('prefix_language');
            $this->languages = $this->ci->config->item('languages');

            $this->errors = FALSE;

            $this->tab = chr(9);
            $this->tabx2 = chr(9) . chr(9);
            $this->tabx3 = chr(9) . chr(9) . chr(9);
            $this->tabx4 = chr(9) . chr(9) . chr(9) . chr(9);
            $this->tabx5 = chr(9) . chr(9) . chr(9) . chr(9) . chr(9);
            $this->tabx6 = chr(9) . chr(9) . chr(9) . chr(9) . chr(9) . chr(9);
            $this->tabx7 = chr(9) . chr(9) . chr(9) . chr(9) . chr(9) . chr(9) . chr(9);
            $this->sl = chr(13) . chr(10);
        }

        public function create($data)
        {
            //Extract & init vars
            $this->init($data);

            //Save elements code in a file
            $this->create_folder_if_no_exists(APPPATH . "modules/" . $data['controller_name']);
            $sv = $this->save_sql("json", "modules/" . $data['controller_name'] . "/sql/", serialize($data), ".txt");

            //Prepare JSON
            $result = $this->prepare_json();

            if ($result === FALSE)
            {
                return $this->errors;
            }

            //check if multilanguage is activated
            $result = $this->check_array_language();

            if ($result === FALSE)
            {
                return $this->errors;
            }
            //drop table
            if ($this->scaffold_delete_bd)
            {
                $result = $this->delete_table_bd();

                if ($result === FALSE)
                {
                    return $this->errors;
                }
            }


            //create table
            if ($this->scaffold_bd)
            {
                $result = $this->create_table_db();
                if ($result === FALSE)
                {
                    return $this->errors;
                }
            }


            //create controller
            if ($this->create_controller)
            {
                $result = $this->create_controller();
                if ($result === FALSE)
                {
                    return $this->errors;
                }
            }


            //create model
            if ($this->create_model)
            {
                if ($this->scaffold_model_type === "activerecord")
                {
                $sq = $this->gen_sql();
                $result = $this->create_model_ar($sq);
                }
                else if ($this->scaffold_model_type === "phpactiverecord")
                {
                    $result = $this->create_model();
                }
                if ($result === FALSE)
                {
                    return $this->errors;
                }
            }


            //create view create
            if ($this->create_view_create)
            {
                $result = $this->create_view_create();
                if ($result === FALSE)
                {
                    return $this->errors;
                }
            }


            //create view list
            if ($this->create_view_list)
            {
                $result = $this->create_view_list();
                if ($result === FALSE)
                {
                    return $this->errors;
                }
            }


            //modify routes.php
            if ($this->scaffold_routes)
            {
                $result = $this->modify_routes();
                if ($result === FALSE)
                {
                    return $this->errors;
                }
            }

            //modify _menu.php
            if ($this->scaffold_menu)
            {
                $result = $this->modify_menu();
                if ($result === FALSE)
                {
                    return $this->errors;
                }
            }


            if ($this->there_is_a_relational_field)
            {
                $result = $this->add_relational_link_to_list();
                if ($result === FALSE)
                {
                    return $this->errors;
                }
            }

            return TRUE;
        }

        private function init($data)
        {
            $this->controller_name = $data['controller_name'];
            $this->model_name = $data['model_name'] . '_m';
            $this->model_name_for_calls = ucfirst($data['model_name'] . '_m');
            $this->scaffold_code = $data['scaffold_code'];
            $this->scaffold_delete_bd = $data['scaffold_delete_bd'];
            $this->scaffold_bd = $data['scaffold_bd'];
            $this->scaffold_routes = $data['scaffold_routes'];
            $this->scaffold_menu = $data['scaffold_menu'];
            $this->create_controller = $data['create_controller'];
            $this->create_model = $data['create_model'];
            $this->create_view_create = $data['create_view_create'];
            $this->create_view_list = $data['create_view_list'];
            $this->scaffold_model_type = $data['scaffold_model_type'];
        }

        private function prepare_json()
        {
            $arrayjson = json_decode("{" . $this->scaffold_code . "}", TRUE);
            $this->there_is_an_image = FALSE;
            $this->there_is_a_file = FALSE;
            $this->there_is_a_multilanguage_field = FALSE;
            $this->there_is_a_relational_field = FALSE;
            $this->relational_field = FALSE;
            $this->relational_controller = FALSE;
            $this->relational_model = FALSE;
            $this->array_thumbnails_uploads = array();
            $this->array_required_fields_uploads = array();

            //evitamos que se puedan crear los nombres de los campos con mayúsculas
            //controlamos si hay imagenes o archivos que subir y miramos que campos tienen thumbnails y
            //cuales son required y los guardamos en un array
            //para manipular mas facilmente en el caso de que haya n uploads
            foreach ($arrayjson as $index => $value)
            {
                if (strtolower($index) !== $index)
                {
                    $arrayjson[strtolower($index)] = $arrayjson[$index];
                    unset($arrayjson[$index]);
                }

                if ($value['type'] == 'image')
                {
                    $this->there_is_an_image = TRUE;

                    if ($value['multilanguage'] === "TRUE")
                    {
                        foreach ($this->languages as $prefix => $language)
                        {
                            if (isset($value['thumbnail']))
                                if ($value['thumbnail'])
                                    array_push($this->array_thumbnails_uploads, $index . "_" . $prefix);

                            if ($value['required'] === 'TRUE')
                                array_push($this->array_required_fields_uploads, $index . "_" . $prefix);
                        }
                    }
                    else
                    {
                        if (isset($value['thumbnail']))
                            if ($value['thumbnail'])
                                array_push($this->array_thumbnails_uploads, $index);

                        if ($value['required'] === 'TRUE')
                            array_push($this->array_required_fields_uploads, $index);
                    }
                }

                if ($value['type'] == 'file')
                {
                    $this->there_is_a_file = TRUE;
                    if ($value['multilanguage'] === "TRUE")
                    {
                        foreach ($this->languages as $prefix => $language)
                        {
                            if (isset($value['thumbnail']))
                                if ($value['thumbnail'])
                                    array_push($this->array_thumbnails_uploads, $index . "_" . $prefix);

                            if ($value['required'] === 'TRUE')
                                array_push($this->array_required_fields_uploads, $index . "_" . $prefix);
                        }
                    }
                    else
                    {
                        if (isset($value['thumbnail']))
                            if ($value['thumbnail'])
                                array_push($this->array_thumbnails_uploads, $index);

                        if ($value['required'] === 'TRUE')
                            array_push($this->array_required_fields_uploads, $index);
                    }
                }

                if ($value['type'] == 'hidden')
                {
                    $this->there_is_a_relational_field = TRUE;
                    $this->relational_field = $index;
                    $this->relational_controller = $value['controller'];
                    $this->relational_model = $value['model'];
                }

                if (isset($value['multilanguage']))
                    if ($value['multilanguage'] === 'TRUE')
                        $this->there_is_a_multilanguage_field = TRUE;
            }

            if ($arrayjson)
            {
                $this->arrayjson = $arrayjson;
            }
            else
            {
                $this->errors = lang('scaffolds_error_json');
                return FALSE;
            }
        }

        private function check_array_language()
        {
            if ($this->there_is_a_multilanguage_field)
            {
                if ($this->languages == NULL or $this->actual_language == NULL)
                {
                    $this->errors = lang('scaffolds_not_array_languages');
                    return FALSE;
                }
                else
                {
                    return TRUE;
                }
            }
            else
            {
                return TRUE;
            }
        }

        private function delete_table_bd()
        {
            $sql = "DROP TABLE IF EXISTS " . $this->controller_name . ";";

            $result = $this->ci->db->query($sql);
            //$conn = ActiveRecord\ConnectionManager::get_connection("development");
            //$result = (object) $conn -> query($sql);

            if ($result)
                return TRUE;
            else
            {
                $this->errors = lang('scaffolds_error_del_bd') . "<br> <pre>$sql_table</pre>";
                return FALSE;
            }
        }

    private function gen_sql()
        {
        $sql_table = '';
            switch ($this->dbdriver)
            {
                case 'mysqli':
                case 'mysql':

                $sql_table = $this->tab . "CREATE TABLE IF NOT EXISTS  " . $this->controller_name . " (";
                $sql_table .= $this->sl . $this->tab . "id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,";

                    foreach ($this->arrayjson as $index => $value)
                    {
                        $sql_table_aux = "";

                        switch ($value['type'])
                        {
                            case 'text':
                            case 'image':
                            case 'file':

                                if ($value['multilanguage'] == "TRUE")
                                {
                                    foreach ($this->languages as $prefix => $language)
                                    {
                                        $sql_table_aux .= $index . "_" . $prefix . " varchar(256) DEFAULT '' ";

                                        if ($value['required'])
                                            $sql_table_aux .= "NOT NULL, ";
                                        else
                                            $sql_table_aux .= ", ";
                                    }

                                $sql_table .= $this->sl . $this->tab . $sql_table_aux;
                                }
                                else
                                {
                                $sql_table .= $this->sl . $this->tab . $index . "  varchar(256)  DEFAULT '' ";

                                    if ($value['required'])
                                        $sql_table .= "NOT NULL, ";
                                    else
                                    $sql_table .= ", " . $this->sl . $this->tab;
                                }

                                break;

                            case 'textarea':

                                if ($value['multilanguage'] == "TRUE")
                                {
                                    foreach ($this->languages as $prefix => $language)
                                    {
                                    $sql_table_aux .= $index . "_" . $prefix . " text";

                                    //   if ($value['required'])
                                    //  $sql_table_aux .= "NOT NULL, ";
                                    //else
                                            $sql_table_aux .= ", ";
                                    }

                                $sql_table .= $this->sl . $this->tab . $sql_table_aux;
                                }
                                else
                                {
                                $sql_table .= $this->sl . $this->tab . $index . "  text  ";

                                //  if ($value['required'])
                                //    $sql_table .= "NOT NULL, ";
                                //else
                                        $sql_table .= ", ";
                                }

                                break;

                            case 'checkbox':

                            $sql_table .= $this->sl . $this->tab . $index . " INT(1) ";

                                if ($value['required'])
                                    $sql_table .= "NOT NULL, ";
                                else
                                    $sql_table .= ", ";

                                break;

                            case 'select':
                            case 'radio':

                            $sql_table .=$this->sl . $this->tab . $index . "  varchar(32)  DEFAULT '' ";

                                if ($value['required'])
                                    $sql_table .= "NOT NULL, ";
                                else
                                    $sql_table .= ", ";
                                break;

                            case 'selectbd':

                            $sql_table .= $this->sl . $this->tab . $index . "  INT(9) ";

                                if ($value['required'])
                                    $sql_table .= "NOT NULL, ";
                                else
                                    $sql_table .= ", ";
                                break;

                            case 'datepicker':

                            $sql_table .= $this->sl . $this->tab . $index . "  INT(11), ";

                                break;

                            case 'hidden':

                            $sql_table .=$this->sl . $this->tab . $index . "  INT(9) NOT NULL, ";

                                break;
                        }
                    }

                $sql_table .=$this->sl . $this->tab . "created_by INT(11), ";
                $sql_table .=$this->sl . $this->tab . "modified_by INT(11), ";
                $sql_table .=$this->sl . $this->tab . "created_on INT(11) , ";
                $sql_table .= $this->sl . $this->tab . "modified_on INT(11) ";
                $sql_table .= $this->sl . $this->tab . ") ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

                    break;
            }
        return $sql_table;
    }

    private function create_table_db()
    {
        $sql_table = $this->gen_sql();  
            $result = $this->ci->db->query($sql_table);
            //$conn = ActiveRecord\ConnectionManager::get_connection("development");
            // $result = (object) $conn -> query($sql_table);
            $sv = $this->save_sql($this->controller_name, "modules/" . $this->controller_name . "/sql/", trim($sql_table), ".sql");
            if ($result && $sv)
            {
                return TRUE;
            }
            else
            {
                $this->errors = lang('scaffolds_error_bd') . "<br>$sql_table";
                return FALSE;
            }
        }

        private function create_controller()
        {
            $data = "";
            $data .= "
        <?php defined('BASEPATH') OR exit('No direct script access allowed');

        class Admin extends Admin_Controller
        {
        function __construct()
        {
        parent::__construct();";

            $data .= $this->sl . $this->tabx3 . "/*\$this->template->set_layout('default');";
            $data .= $this->sl . $this->tabx3 . "\$this->template->set_partial('sidebar','partials/sidebar.php')
                    -> set_partial('top', 'partials/top.php');*/ ";
            $data .= $this->sl . $this->tabx3 . "if (!\$this->ion_auth->logged_in())
	{
	redirect('admin/login');
	}";
            if ($this->scaffold_model_type == "activerecord")
            {
                $data .= $this->sl . $this->tabx3 . "\$this->load->model('" . $this->model_name . "');";
            }
            $data .= "
	}

	public function index()
	{	  ";
            if ($this->there_is_a_relational_field)
            {
                $data .= "

            \$data['" . $this->relational_field . "'] = (\$this->uri->segment(4)) ? \$this->uri->segment(4) : '';
                    
            //redirect if it´s no correct
            if (!\$data['" . $this->relational_field . "']){
                \$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/" . $this->relational_controller . "/');
            }
            \$config = \$this->set_paginate_options(\$data['" . $this->relational_field . "']); ";
            }
            else
            {
                $data .= " \$config = \$this->set_paginate_options(); ";
            }

            $data.="//Initialize the pagination class
                \$this->pagination->initialize(\$config);
                \$page = (\$this->uri->segment(" . (($this->there_is_a_relational_field) ? '4' : '4') . ")) ? \$this->uri->segment(" . (($this->there_is_a_relational_field) ? '4' : '4') . ") : 1;
                \$data['" . $this->controller_name . "'] = \$this->" . $this->model_name . "->paginate_all(\$config['per_page'], \$page" . ( ($this->there_is_a_relational_field) ? ", \$data['$this -> relational_field']" : "" ) . ");

            //create pagination links
            \$data['links'] = \$this->pagination->create_links();

	//page number  variable
	 \$data['page'] = \$page;
                \$data['per'] = \$config['per_page'];

            //load view
            \$this->template->title(' " . humanize($this->controller_name) . " ' )->build('admin/list', \$data);
	}

        function create(\$page = NULL)
        {
            //create control variables
            \$data['updType'] = 'create';
            \$form_data_aux  = array();
            ";

            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'selectbd':
                        $tdl = str_replace('_m', '', $value['options']['model']);
                        $data .=$this->sl . "\$data['" . $tdl . "'] = \$this->" . $this->model_name . "->populate('" . $tdl . "'" . ",'id'," . "'" . $value['options']['field_text'] . "');" . $this->sl;
                        break;
                }
            }

            if ($this->there_is_a_relational_field)
            {
                $data .= "\$data['" . $index . "'] = ( \$this->uri->segment(3) )  ? \$this->uri->segment(3) : \$this->input->post('" . $index . "', TRUE);";
                $data .= $this->sl . $this->tabx2 . "\$data['page'] = ( \$this->uri->segment(4) )  ? \$this->uri->segment(4) : \$page;";
            }
            else
            {
                $data .= "\$data['page'] = ( \$this->uri->segment(4) )  ? \$this->uri->segment(4) : \$page;";
            }

            $data .= "
 
        //Rules for validation
        \$this->form_validation->set_rules(\$this->validation());

            //validate the fields of form
            if (\$this->form_validation->run() )
            {         //Validation OK!
          ";

            if ($this->there_is_an_image or $this->there_is_a_file)
            {
                if (count($this->array_thumbnails_uploads))
                {
                    $data .= $this->sl . $this->tabx3 . "\$array_thumbnails = explode(\",\", \"" . implode(",", $this->array_thumbnails_uploads) . "\");";
                }
                else
                {
                    $data .= $this->sl . $this->tabx3 . "\$array_thumbnails = array();";
                }

                if (count($this->array_required_fields_uploads))
                {
                    $data .= $this->sl . $this->tabx3 . "\$array_required = explode(\",\", \"" . implode(",", $this->array_required_fields_uploads) . "\");";
                }
                else
                {
                    $data .= $this->sl . $this->tabx3 . "\$array_required = array();";
                }

                foreach ($this->arrayjson as $index => $value)
                {
                    switch ($value['type'])
                    {
                        case 'image':
                        case 'file':

                            $aux = "";
                            if ($value['multilanguage'] == "TRUE")
                            {
                                foreach ($this->languages as $prefix => $language)
                                {
                                    $aux .= $index . "_" . $prefix . ",";
                                }

                                $aux = substr($aux, 0, -1);

                                $data .="	//uploads fields for $index
			\$array_fields_" . $index . " = explode(\",\", \"$aux\"); ";
                            }

                            break;
                    }
                }

                $data .= "
               /*
               * TRY THIS FOR UPLOAD
                    \$file = '';

            if (!empty(\$_FILES['userfile']['name']))
            {
                \$this->load->library('files_uploader');
                \$upload_data = \$this->files_uploader->upload('userfile');
                \$file = \$upload_data['file_name'];
            } */
                \$this->load->library('upload');
                \$this->load->library('image_lib');

                foreach (\$_FILES as \$index => \$value)
                {
                        if (\$value['name'] != '')
                        {";


                foreach ($this->arrayjson as $index => $value)
                {
                    switch ($value['type'])
                    {
                        case 'image':
                        case 'file':

                            $aux = "";

                            if ($value['multilanguage'] == "TRUE")
                            {
                                foreach ($this->languages as $prefix => $language)
                                {
                                    $aux .= $index . "_" . $prefix . ", ";
                                }

                                $aux = substr($aux, 0, -2);

                                $data .="
                            //uploads rules for \$index
                            if (in_array(\$index, \$array_fields_" . $index . "))
                            {
                                    \$this->upload->initialize(\$this->set_upload_options('" . $this->controller_name . "', '" . $index . "'));
					} ";
                            }
                            else
                            {
                                $data .="
                        //uploads rules for \$index
                        if (\$index == '" . $index . "')
                        {
                                \$this->upload->initialize(\$this->set_upload_options('" . $this->controller_name . "', '" . $index . "'));
			}";
                            }

                            break;
                    }
                }


                $data .= "
                            //upload the image
                            if ( ! \$this->upload->do_upload(\$index))
                            {
                                    \$data['upload_error'][\$index] = \$this->upload->display_errors(\"<span class='error'>\", \"</span>\");

                                    //load the view and the layout
                                    \$this->template->build('admin/create', \$data);

                                    return FALSE;
                            }
                            else
                            {
                                    //create an array to send to image_lib library to create the thumbnail
                                    \$info_upload = \$this->upload->data();

                                    //Save the name an array to save on BD before
                                    \$form_data_aux[\$index] = \$info_upload['file_name'];


                                    if (in_array(\$index, \$array_thumbnails))
                                    {
                                            //Initializing the imagelib library to create the thumbnail
";

                foreach ($this->arrayjson as $index => $value)
                {
                    switch ($value['type'])
                    {
                        case 'image':

                            $aux = "";

                            if ($value['multilanguage'] == "TRUE")
                            {
                                foreach ($this->languages as $prefix => $language)
                                {
                                    $aux .= $index . "_" . $prefix . ", ";
                                }

                                $aux = substr($aux, 0, -2);

                                $data .="
                        //thumbnails rules for \$index
                        if (in_array(\$index, \$array_fields_" . $index . "))
                        {
                                \$this->image_lib->initialize(\$this->set_thumbnail_options(\$info_upload, '" . $this->controller_name . "', '" . $index . "'));
                        }
";
                            }
                            else
                            {
                                $data .="
            //thumbnails rules for \$index
            if (\$index == '" . $index . "')
            {
                    \$this->image_lib->initialize(\$this->set_thumbnail_options(\$info_upload, '" . $this->controller_name . "', '" . $index . "'));
            }
";
                            }

                            break;
                    }
                }

                $data .= "
        //create the thumbnail
        if ( ! \$this->image_lib->resize())
        {
                \$data['upload_error'][\$index] = \$this->image_lib->display_errors(\"<span class='error'>\", \"</span>\");

                //load the view and the layout
                \$this->template->build('admin/create', \$data);

                return FALSE;
            }
        }
    }
                }
                else
                {
                        if (in_array(\$index, \$array_required))
                        {
                                \$data['upload_error'][\$index] = \"<span class='error'>\".lang('upload_no_file_selected').\"</span>\";

                                //load the view and the layout
                                \$this->template->build('admin/create', \$data);

                                return FALSE;
                        }
                }
        }

";
            }

// build array for the model
            $data .= "\$user = \$this -> ion_auth -> get_user();";
            $data .= "
        \$form_data = array(";

            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'text':
                    case 'textarea':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            foreach ($this->languages as $prefix => $language)
                            {
                                $data .= $this->sl . $this->tabx4 . "'" . $index . "_" . $prefix . "' => \$this->input->post('" . $index . "_" . $prefix . "'), ";
                            }
                        }
                        else
                        {
                            $data .= $this->sl . $this->tabx4 . "'" . $index . "' => \$this->input->post('" . $index . "'), ";
                        }

                        break;

                    case 'datepicker':
                        $data .= $this->sl . $this->tabx4 . "'" . $index . "' => strtotime(\$this->input->post('" . $index . "')), ";
                        break;
                    case 'checkbox':
                    case 'select':
                    case 'selectbd':
                    case 'radio':
                    case 'hidden':
                        $data .= $this->sl . $this->tabx4 . "'" . $index . "' => \$this->input->post('" . $index . "'), ";
                        break;
                }
            }

            $data .= $this->sl . $this->tabx4 . " 'created_by' => \$user -> id ,   ";
            $data .= $this->sl . $this->tabx4 . " 'created_on' => time()  ";
            $data = substr($data, 0, -2);

            $data .=$this->sl . $this->tabx3 . ");";

            if ($this->there_is_an_image or $this->there_is_a_file)
                $data .= $this->sl . $this->tabx3 . "\$form_data = array_merge(\$form_data, \$form_data_aux);";

            // run insert model to write data to db
            if ($this->scaffold_model_type === 'phpactiverecord')
            {
                $data .= "

            \$" . $this->model_name . " =  \$this->" . $this->model_name . "->create(\$form_data);
                
            if ( \$" . $this->model_name . "->is_valid())
            {
                    \$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }

            if ( $" . $this->model_name . "->is_invalid() )
            {
                    \$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => \$ok->errors->full_messages() ));
            }

			";
            }
            else if ($this->scaffold_model_type === 'activerecord')
            {
                $data .= "

            \$ok=  \$this->" . $this->model_name . "->create(\$form_data);

            if ( \$ok)
            {
                    \$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    \$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			";
            }

            $data .= (($this->there_is_a_relational_field) ? "redirect(\"admin/" . $this->controller_name . "/\".\$this->input->post('" . $this->relational_field . "', TRUE));" : "redirect('admin/" . $this->controller_name . "/');") . "

	  	}else
                {
                \$get = new StdClass();
                foreach (\$this -> validation() as \$field)
                {   
                         \$get -> \$field['field']  = set_value(\$field['field']);
                 }
		 
                 \$data['result'] = \$get; 
		 //load the view and the layout
		 \$this->template->title('Add " . humanize($this->controller_name) . " ' )->build('admin/create', \$data);
		}		
	}

	function edit(\$id = FALSE, \$page = 0)
	{ 
          ";
            if ($this->there_is_a_relational_field)
            {
                $data .= "
            //get the \$id and sanitize
            \$id = ( \$id != 0 ) ? filter_var(\$id, FILTER_VALIDATE_INT) : NULL;

            //get the relation and sanitize
            \$data['" . $this->relational_field . "'] = (\$this->uri->segment(5)) ? \$this->uri->segment(5) : \$this->input->post('" . $this->relational_field . "', TRUE);
		\$data['" . $this->relational_field . "'] = ( \$data['" . $this->relational_field . "'] != 0 ) ? filter_var(\$data['" . $this->relational_field . "'], FILTER_VALIDATE_INT) : NULL;

            //get the \$page and sanitize
            \$page = ( \$page != 0 ) ? filter_var(\$page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no \$id
            if (!\$id or !\$data['" . $this->relational_field . "']){
            \$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect(\"admin/" . $this->controller_name . "/\".\$data['" . $this->relational_field . "']);
		} 
              if(!\$this->" . $this->model_name . "-> exists(\$id) ){
                 \$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/" . $this->controller_name . "');
              }
                    //search the item to show in edit form
            \$get =  \$this->" . $this->model_name . "->find(\$id);
            ";
            }
            else
            {
                $data .= "
            //get the \$id and sanitize
            \$id = ( \$id != 0 ) ? filter_var(\$id, FILTER_VALIDATE_INT) : NULL;

            \$page = ( \$page != 0 ) ? filter_var(\$page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no \$id
            if (!\$id){
                    \$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/" . $this->controller_name . "/');
            }
         if(!\$this->" . $this->model_name . "-> exists(\$id) )
             {
             \$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/" . $this->controller_name . "');
              }
        //search the item to show in edit form
        \$get =  \$this->" . $this->model_name . "->find(\$id); ";
            }
            $data .= "
            //variables for check the upload
            \$form_data_aux = array();
            \$files_to_delete  = array(); ";

            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'selectbd':
                        $tdl = str_replace('_m', '', $value['options']['model']);
                        $data .=$this->sl . "\$data['" . $tdl . "'] = \$this->" . $this->model_name . "->populate('" . $tdl . "'" . ",'id'," . "'" . $value['options']['field_text'] . "');" . $this->sl;
                        break;
                }
            }

            $data .= "
            //Rules for validation
            \$this->form_validation->set_rules(\$this->validation());

            //create control variables
            \$data['updType'] = 'edit';
            \$data['page'] = \$page;

            if (\$this->form_validation->run() )  //validation has been passed
             {";

            if ($this->there_is_an_image or $this->there_is_a_file)
            {
                if (count($this->array_thumbnails_uploads))
                {
                    $data .= $this->sl . $this->tabx3 . "\$array_thumbnails 	= explode(\",\", \"" . implode(",", $this->array_thumbnails_uploads) . "\");";
                }
                else
                {
                    $data .= $this->sl . $this->tabx3 . "\$array_thumbnails = array();";
                }

                if (count($this->array_required_fields_uploads))
                {
                    $data .= $this->sl . $this->tabx3 . "\$array_required = explode(\",\", \"" . implode(",", $this->array_required_fields_uploads) . "\");";
                }
                else
                {
                    $data .= $this->sl . $this->tabx3 . "\$array_required = array();";
                }

                foreach ($this->arrayjson as $index => $value)
                {
                    switch ($value['type'])
                    {
                        case 'image':
                        case 'file':

                            $aux = "";

                            if ($value['multilanguage'] == "TRUE")
                            {
                                foreach ($this->languages as $prefix => $language)
                                {
                                    $aux .= $index . "_" . $prefix . ",";
                                }

                                $aux = substr($aux, 0, -1);
                                $data .="

                    //uploads fields for $index
                    \$array_fields_" . $index . " = explode(\",\", \"$aux\"); ";
                            }

                            break;
                    }
                }

                $data .= "
                    \$data['" . $this->model_name . "'] = \$this->" . $this->model_name_for_calls . "->find(\$id);

                    \$this->load->library('upload');
                    \$this->load->library('image_lib');

                    foreach (\$_FILES as \$index => \$value)
                    {
                            if (\$value['name'] != '')
                            {";

                foreach ($this->arrayjson as $index => $value)
                {
                    switch ($value['type'])
                    {
                        case 'image':
                        case 'file':

                            $aux = "";

                            if ($value['multilanguage'] == "TRUE")
                            {
                                foreach ($this->languages as $prefix => $language)
                                {
                                    $aux .= $index . "_" . $prefix . ", ";
                                }

                                $aux = substr($aux, 0, -2);

                                $data .="
                    //uploads rules for \$index
                    if (in_array(\$index, \$array_fields_" . $index . "))
                    {
                            \$this->upload->initialize(\$this->set_upload_options('" . $this->controller_name . "', '" . $index . "'));
                    }
";
                            }
                            else
                            {
                                $data .="
                        //uploads rules for \$index
                        if (\$index == '" . $index . "')
                        {
                                \$this->upload->initialize(\$this->set_upload_options('" . $this->controller_name . "', '" . $index . "'));
                        }
";
                            }


                            break;
                    }
                }


                $data .= "
                                //upload the image
                                if ( ! \$this->upload->do_upload(\$index))
                                {
                                        \$data['upload_error'][\$index] = \$this->upload->display_errors(\"<span class='error'>\", \"</span>\");

                                        //load the view and the layout
                                        \$this->template->build('admin/create', \$data);

                                        return FALSE;
                                }
                                else
                                {
                                        //create an array to send to image_lib library to create the thumbnail
                                        \$info_upload = \$this->upload->data();

                                        //Save the name an array to save on BD before
                                        \$form_data_aux[\$index]		=	\$info_upload[\"file_name\"];

                                        //Save the name of old files to delete
                                        array_push(\$files_to_delete, \$data['" . $this->model_name . "']->\$index);

                                        //Initializing the imagelib library to create the thumbnail

                                        if (in_array(\$index, \$array_thumbnails))
                                        {
";
                foreach ($this->arrayjson as $index => $value)
                {
                    switch ($value['type'])
                    {
                        case 'image':

                            $aux = "";

                            if ($value['multilanguage'] == "TRUE")
                            {
                                foreach ($this->languages as $prefix => $language)
                                {
                                    $aux .= $index . "_" . $prefix . ", ";
                                }

                                $aux = substr($aux, 0, -2);

                                $data .="
                //thumbnails rules for \$index
                if (in_array(\$index, \$array_fields_" . $index . "))
                {
                        \$this->image_lib->initialize(\$this->set_thumbnail_options(\$info_upload, '" . $this->controller_name . "', '" . $index . "'));
                }
";
                            }
                            else
                            {
                                $data .="
            //thumbnails rules for \$index
            if (\$index == '" . $index . "')
            {
                    \$this->image_lib->initialize(\$this->set_thumbnail_options(\$info_upload, '" . $this->controller_name . "', '" . $index . "'));
            }
";
                            }

                            break;
                    }
                }

                $data .= "
                //create the thumbnail
                if ( ! \$this->image_lib->resize())
                {
                        \$data['upload_error'][\$index] = \$this->image_lib->display_errors(\"<span class='error'>\", \"</span>\");

                        //load the view and the layout
                        \$this->template->build('admin/create', \$data);

                        return FALSE;
                }
        }
}
}

			}
";
            }

            //fetch details of logged in user
            $data .=$this->sl . $this->tabx3 . "\$user = \$this -> ion_auth -> get_user();";
            $data .= "
            // build array for the model
            \$form_data = array( ";

            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'text':
                    case 'textarea':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            foreach ($this->languages as $prefix => $language)
                            {
                                $data .= $this->sl . $this->tabx7 . "'" . $index . "_" . $prefix . "' => \$this->input->post('" . $index . "_" . $prefix . "'), ";
                            }
                        }
                        else
                        {
                            $data .= $this->sl . $this->tabx7 . "'" . $index . "' => \$this->input->post('" . $index . "'), ";
                        }

                        break;

                    case 'datepicker':
                        $data .= $this->sl . $this->tabx4 . "'" . $index . "' => strtotime(\$this->input->post('" . $index . "')), ";
                        break;

                    case 'checkbox':
                    case 'select':
                    case 'selectbd':
                    case 'radio':
                    case 'hidden':
                        $data .= $this->sl . $this->tabx7 . "'" . $index . "' => \$this->input->post('" . $index . "'), ";
                        break;
                }
            }

            $data .= $this->sl . $this->tabx4 . " 'modified_by' => \$user -> id ,   ";
            $data .= $this->sl . $this->tabx4 . " 'modified_on' => time()  ";

            $data = substr($data, 0, -2);
            $data .= " );

        //add the aux form data to the form data array to save
        \$form_data = array_merge(\$form_data_aux, \$form_data);

        //find the item to update
        " . ( ($this->scaffold_model_type == 'phpactiverecord') ? "\$" . $this->model_name . " = " . $this->model_name_for_calls . "::find(\$id);" : "" ) . "
            " . ( ($this->scaffold_model_type == 'activerecord') ? "\$done = \$this->" . strtolower($this->model_name_for_calls) . "->update_attributes(\$id, \$form_data);" : "\$" . $this->model_name . '->update_attributes($form_data);' ) . "

        " . ( ($this->scaffold_model_type == 'phpactiverecord') ? "if ( \$" . $this->model_name . "->is_valid()) " : "if ( \$done) " ) . "
                {";
            if ($this->there_is_an_image or $this->there_is_a_file)
            {
                $data .= "
				//delete the old images
				foreach (\$files_to_delete as \$index)
				{";
                if ($this->there_is_an_image)
                {
                    $data .= "
					if ( is_file(FCPATH.'public/uploads/" . $this->controller_name . "/img/'.\$index) )
						unlink(FCPATH.'public/uploads/" . $this->controller_name . "/img/'.\$index);

					if ( is_file(FCPATH.'public/uploads/" . $this->controller_name . "/img/thumbs/'.\$index) )
						unlink(FCPATH.'public/uploads/" . $this->controller_name . "/img/thumbs/'.\$index);";
                }

                if ($this->there_is_a_file)
                {
                    $data .= "
					if ( is_file(FCPATH.'public/uploads/" . $this->controller_name . "/files/'.\$index) )
						unlink(FCPATH.'public/uploads/" . $this->controller_name . "/files/'.\$index);";
                }
                $data .= "
				}
";
            }
            $data .= "
				\$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect(\"admin/" . $this->controller_name . "/" . (($this->there_is_a_relational_field) ? "\".\$this->input->post('" . $this->relational_field . "', TRUE).\"/\"" : "\"") . ");
			}

			" . ( ($this->scaffold_model_type == 'phpactiverecord') ? "if ( \$" . $this->model_name . "->is_invalid()) " : "else" ) . "
			{
				\$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => \$done->errors->full_messages() ) );
				redirect(\"admin/" . $this->controller_name . "/" . (($this->there_is_a_relational_field) ? "\".\$this->input->post('" . $this->relational_field . "', TRUE).\"/\"" : "\"") . ");
			}
	  	}
             else
             {
                 foreach (array_keys(\$this -> validation()) as \$field)
                {
                        if (isset(\$_POST[\$field]))
                        {  
                                \$get -> \$field = \$this -> form_validation -> \$field;
                        }
                }
		}
               \$data['result'] = \$get;
             //load the view and the layout
             \$this->template->title('Edit " . humanize($this->controller_name) . " ' )->build('admin/create', \$data);
	}


	function delete(\$id = NULL, \$page = 1)
	{";
            if ($this->there_is_a_file or $this->there_is_an_image)
                $data.= $this->sl . $this->tabx2 . "\$files_to_delete = array();" . $this->sl;

            $data .= "
		//filter & Sanitize \$id
		\$id = (\$id != 0) ? filter_var(\$id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!\$id){
			\$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/" . $this->controller_name . "');
		}
";

            if ($this->scaffold_model_type == "phpactiverecord")
            {
                $data.="
		//search the item to delete
		if ( \$this->" . strtolower($this->model_name_for_calls) . "->exists(\$id) )
		{
			\$" . $this->model_name . " = \$this->" . strtolower($this->model_name_for_calls) . "->find(\$id);
		}
		else
		{
			\$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/" . $this->controller_name . "');
		}
";
            }
            else
            {
                $data .= "
		//search the item to delete
		if ( !\$this->" . strtolower($this->model_name_for_calls) . "->exists(\$id) )
		{
			\$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/" . $this->controller_name . "');
		}
";

                if ($this->there_is_an_image or $this->there_is_a_file)
                {
                    $data .= $this->tabx2 . "else
			\$" . $this->model_name . " = \$this->" . strtolower($this->model_name_for_calls) . "->find(\$id);
";
                }
            }

            if ($this->there_is_an_image or $this->there_is_a_file)
            {
                $data .= $this->sl . $this->tabx2 . "//Save the files into array to delete after";
            }

            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'image':
                    case 'file':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            foreach ($this->languages as $prefix => $language)
                            {
                                $aux = "_" . $prefix;
                                $data .= $this->sl . $this->tabx2 . "array_push(\$files_to_delete, \$" . $this->model_name . "->$index$aux);" . $this->sl;
                            }
                        }
                        else
                        {
                            $data .= $this->sl . $this->tabx2 . "array_push(\$files_to_delete, \$" . $this->model_name . "->$index);" . $this->sl;
                        }

                        break;
                }
            }


            $data .= " 
		//delete the item
		" . ( ($this->scaffold_model_type == 'phpactiverecord') ? "if ( \$" . $this->model_name . "->delete() == TRUE) " : "                     if ( \$this->" . strtolower($this->model_name_for_calls) . "->delete(\$id) == TRUE) " ) . "
		{
			\$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));";


            if ($this->there_is_an_image or $this->there_is_a_file)
            {
                $data .= "

			//delete the old images
			foreach (\$files_to_delete as \$index)
			{";
                if ($this->there_is_an_image)
                {
                    $data .= "
				if ( is_file(FCPATH.'public/uploads/" . $this->controller_name . "/img/'.\$index) )
					unlink(FCPATH.'public/uploads/" . $this->controller_name . "/img/'.\$index);

				if ( is_file(FCPATH.'public/uploads/" . $this->controller_name . "/img/thumbs/'.\$index) )
					unlink(FCPATH.'public/uploads/" . $this->controller_name . "/img/thumbs/'.\$index);";
                }

                if ($this->there_is_a_file)
                {
                    $data .= "
				if ( is_file(FCPATH.'public/uploads/" . $this->controller_name . "/files/'.\$index) )
					unlink(FCPATH.'public/uploads/" . $this->controller_name . "/files/'.\$index);";
                }
                $data .= "
			}
";
            }


            $data .="
		}
		else
		{
			\$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect(\"admin/" . $this->controller_name . "/\"" . ( ($this->there_is_a_relational_field) ? ".\$" . $this->model_name . "->" . $this->relational_field . "" : "" ) . ");
	}
  
    private function validation()
    {";

            $data .= $this->sl . "\$config = array(";
            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'text':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            foreach ($this->languages as $prefix => $language)
                            {
                                // $data .= $this->tabx2 . "\$this->form_validation->set_rules('" . $index . "_" . $prefix . "', '" . humanize($index) . " ($prefix)', '" . (($value['required'] == 'TRUE') ? 'required|' : '') . "trim|xss_clean|min_length[" . $value['minlength'] . "]|max_length[" . $value['maxlength'] . "]');" . $this->sl;

                                $data .= "
                array(" . $this->sl . $this->tabx2 . " 'field' =>'" . $index . "_" . $prefix . "',
                'label' => '" . humanize($index) . "_" . $prefix . "',
                'rules' =>'" . (($value['required'] == 'TRUE') ? 'required|' : '') . "trim|xss_clean|min_length[" . $value['minlength'] . "]|max_length[" . $value['maxlength'] . "]')," . $this->sl;
                            }
                        }
                        else
                        {
                            //$data .= $this->tabx2 . "\$this->form_validation->set_rules('$index', '$index', '" . (($value['required'] == 'TRUE') ? 'required|' : '') . "trim|xss_clean|min_length[" . $value['minlength'] . "]|max_length[" . $value['maxlength'] . "]');" . $this->sl;

                            $data .= "
                 array(" . $this->sl . $this->tabx2 . " 'field' =>'" . $index . "',
                'label' => '" . humanize($index) . "',
                'rules' => '" . (($value['required'] == 'TRUE') ? 'required|' : '') . "trim|xss_clean|min_length[" . $value['minlength'] . "]|max_length[" . $value['maxlength'] . "]')," . $this->sl;
                        }

                        break;

                    case 'textarea':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            foreach ($this->languages as $prefix => $language)
                            {
                                // $data .= $this->tabx2 . "\$this->form_validation->set_rules('" . $index . "_" . $prefix . "', '" . humanize($index) . " ($prefix)', '" . (($value['required'] == 'TRUE') ? 'required|' : '') . "trim|xss_clean|min_length[" . $value['minlength'] . "]|max_length[" . $value['maxlength'] . "]');" . $this->sl;

                                $data .= "
                 array(" . $this->sl . $this->tabx2 . " 'field' =>'" . $index . "_" . $prefix . "',
                'label' => '" . humanize($index) . "_" . $prefix . "',
                'rules' =>'" . (($value['required'] == 'TRUE') ? 'required|' : '') . "trim|xss_clean|min_length[" . $value['minlength'] . "]|max_length[" . $value['maxlength'] . "]')," . $this->sl;
                            }
                        }
                        else
                        {

                            $data .= "
                array(" . $this->sl . $this->tabx2 . " 'field' =>'" . $index . "',
                'label' => '" . humanize($index) . "',
                'rules' => '" . (($value['required'] == 'TRUE') ? 'required|' : '') . "trim|xss_clean|min_length[" . $value['minlength'] . "]|max_length[" . $value['maxlength'] . "]')," . $this->sl;
                        }

                        break;

                    case 'checkbox':
                    case 'select':
                    case 'selectbd':
                    case 'radio':
                    case 'datepicker':

                        $data .= "
                 array(" . $this->sl . $this->tabx2 . " 'field' =>'" . $index . "',
                 'label' => '" . humanize($index) . "',
                 'rules' =>'" . (($value['required'] == 'TRUE') ? 'required|' : '') . "xss_clean')," . $this->sl;
                        break;


                    case 'hidden':

                        $data .= "
                array(" . $this->sl . $this->tabx2 . " 'field' =>'" . $index . "',
                'label' => '" . humanize($index) . "',
                'rules' => 'required|trim|is_numeric|xss_clean')," . $this->sl;
                        break;
                }
            }

            $data .= $this->tabx2 . ");" . $this->sl;

            $data .= $this->tabx2 . "\$this->form_validation->set_error_delimiters(\"<br /><span class='error'>\", '</span>');";
            $data .=$this->sl . "return \$config; " . $this->sl . $this->tab . "}
        

	private function set_paginate_options(" . (($this->there_is_a_relational_field) ? "\$$this -> relational_field" : "") . ")
	{
		\$config = array();
		\$config['base_url'] = site_url() . 'admin/" . $this->controller_name . "/index/" . (($this->there_is_a_relational_field) ? "/'.\$$this -> relational_field" : "'") . ";
		\$config['use_page_numbers'] = TRUE;
	       \$config['per_page'] = 10;";

            if ($this->there_is_a_relational_field)
            {

                if ($this->scaffold_model_type == 'phpactiverecord')
                {
                    $data .= "
		\$config['total_rows'] = \$this->" . $this->model_name . "->count(array('conditions' => array('" . $this->relational_field . " = ?', \$" . $this->relational_field . ")));
		\$config['uri_segment'] = 4;";
                }
                else if ($this->scaffold_model_type == 'activerecord')
                {
                    $data .= "
		\$config['total_rows'] = \$this->" . $this->model_name . "->count(\$" . $this->relational_field . ");
		\$config['uri_segment'] = 4;";
                }
            }
            else
                $data .= "
            \$config['total_rows'] = \$this->" . $this->model_name . "->count();
            \$config['uri_segment'] = 4 ;";

            $data .= "

            \$config['first_link'] = lang('web_first');
            \$config['first_tag_open'] = \"<li>\";
            \$config['first_tag_close'] = '</li>';
            \$config['last_link'] = lang('web_last') ;
            \$config['last_tag_open'] = \"<li>\";
            \$config['last_tag_close'] = '</li>';
            \$config['next_link'] = FALSE;
            \$config['next_tag_open'] = \"<li>\";
            \$config['next_tag_close'] = '</li>';
            \$config['prev_link'] = FALSE;
            \$config['prev_tag_open'] = \"<li>\";
            \$config['prev_tag_close'] = '</li>';
            \$config['cur_tag_open'] = '<li class=\"active\">  <a href=\"#\">';
            \$config['cur_tag_close'] = '</a></li>';
            \$config['num_tag_open'] = \"<li>\";
            \$config['num_tag_close'] = '</li>';
            \$config['full_tag_open'] = '<div class=\"pagination pagination-centered\"><ul>';
            \$config['full_tag_close'] = '</ul></div>';
            \$choice = \$config[\"total_rows\"] / \$config[\"per_page\"];
            //\$config[\"num_links\"] = round(\$choice);

            return \$config;
	} ";


            if ($this->there_is_an_image or $this->there_is_a_file)
            {
                $data .= "
	private function set_upload_options(\$controller, \$field)
	{
		//upload an image options
		\$config = array(); ";
            }
            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'image':

                        $data .= "
		if (\$field == '$index')
		{
			\$config['upload_path'] 	= FCPATH.'assets/uploads/'.\$controller.'/img/';
			\$config['allowed_types'] 	= '" . $value['upload']['allowed_types'] . "';
			\$config['encrypt_name']	= " . $value['upload']['encrypt_name'] . ";
			\$config['max_width']  		= '" . $value['upload']['max_width'] . "';
			\$config['max_height']  	= '" . $value['upload']['max_height'] . "';
			\$config['max_size'] 		= '" . $value['upload']['max_size'] . "';
		}";
                        break;

                    case 'file':

                        $data .= "
		if (\$field == '$index')
		{
			\$config['upload_path'] 		= FCPATH.'assets/uploads/'.\$controller.'/files/';
			\$config['allowed_types'] 	= '" . $value['upload']['allowed_types'] . "';
			\$config['max_size'] 		= '" . $value['upload']['max_size'] . "';
			\$config['encrypt_name']		= " . $value['upload']['encrypt_name'] . ";
		} ";
                        break;
                }
            }


            if ($this->there_is_an_image or $this->there_is_a_file)
            {
                $data .= "
		//create controller upload folder if not exists
		if (!is_dir(\$config['upload_path']))
		{
			mkdir(FCPATH.\"public/uploads/\$controller/\");
			mkdir(FCPATH.\"public/uploads/\$controller/files/\");
			mkdir(FCPATH.\"public/uploads/\$controller/img/\");
			mkdir(FCPATH.\"public/uploads/\$controller/img/thumbs/\");
		}

		return \$config;
	} ";
            }


            if ($this->there_is_an_image)
            {
                $data .= "

	private function set_thumbnail_options(\$info_upload, \$controller, \$field)
	{
		\$config = array();
		\$config['image_library'] = 'gd2';
		\$config['source_image'] = FCPATH.'public/uploads/'.\$controller.'/img/'.\$info_upload[\"file_name\"];
		\$config['new_image'] = FCPATH.'public/uploads/'.\$controller.'/img/thumbs/'.\$info_upload[\"file_name\"];
		\$config['create_thumb'] = TRUE; ";
            }

            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'image':

                        $data .= "
		if (\$field == '$index')
		{
			\$config['maintain_ratio'] = " . $value['thumbnail']['maintain_ratio'] . ";
			\$config['master_dim'] = '" . $value['thumbnail']['master_dim'] . "';
			\$config['width'] = " . $value['thumbnail']['width'] . ";
			\$config['height'] = " . $value['thumbnail']['height'] . ";
			\$config['thumb_marker'] = '';
		} ";
                        break;
                }
            }

            if ($this->there_is_an_image)
            {
                $data .= "
		return \$config;
	} ";
            }


            $data .= "
}";
            if ($this->save_file("admin", "modules/" . $this->controller_name . "/controllers/", trim($data)) === TRUE)
                return TRUE;
            else
                return FALSE;
        }

        private function create_model()
        {
            $data = "
<?php
class " . $this->model_name_for_calls . " extends ActiveRecord\Model {


	static \$validates_presence_of = array(";

            $there_are_requireds = FALSE;

            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'text':
                    case 'textarea':

                        if ($value['required'] == "TRUE")
                        {
                            if ($value['multilanguage'] == "TRUE")
                            {
                                foreach ($this->languages as $prefix => $language)
                                {
                                    $data .= $this->sl . $this->tabx2 . "array('" . $index . "_" . $prefix . "'), ";
                                }
                            }
                            else
                            {
                                $data .= $this->sl . $this->tabx2 . "array('" . $index . "'), ";
                            }

                            $there_are_requireds = TRUE;
                        }

                        break;

                    case 'checkbox':
                    case 'select':
                    case 'selectbd':
                    case 'radio':
                    case 'datepicker':

                        if ($value['required'] == "TRUE")
                        {
                            $data .= $this->sl . $this->tabx2 . "array('" . $index . "'), ";
                            $there_are_requireds = TRUE;
                        }

                        break;

                    case 'hidden':

                        $data .= $this->sl . $this->tabx2 . "array('" . $index . "'), ";
                        $there_are_requireds = TRUE;

                        break;
                }
            }

            if ($there_are_requireds)
                $data = substr($data, 0, -2);

            $data .="
    );


	static function paginate_all(\$limit, \$page" . ( ($this->there_is_a_relational_field) ? ", \$$this -> relational_field" : "" ) . ")
	{
		\$offset = \$limit * ( \$page - 1) ;

		\$result = \$this->" . $this->model_name_for_calls . "->find('all', array(" . ( ($this->there_is_a_relational_field) ? "'conditions' => '$this -> relational_field = '.\$$this -> relational_field.'', " : "" ) . "'limit' => \$limit, 'offset' => \$offset, 'order' => 'id DESC' ) );

		if (\$result)
		{
			return \$result;
		}
		else
		{
			return FALSE;
		}
	}


}
		";


            if ($this->save_file($this->model_name, "models/", trim($data)) === TRUE)
                return TRUE;
            else
                return FALSE;
        }

    private function create_model_ar($sql)
        {
            $data = "
<?php
class " . $this->model_name_for_calls . " extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        \$this->db_set();
    }

    function create(\$data)
    {
        \$this->db->insert('" . $this->controller_name . "', \$data);
        return \$this->db->insert_id();
    }

    function find(\$id)
    {
        return \$this->db->where(array('id' => \$id))->get('" . $this->controller_name . "')->row();
     }


    function exists(\$id)
    {
          return \$this->db->where( array('id' => \$id))->count_all_results('" . $this->controller_name . "') >0;
    }


    function count(" . ( ($this->there_is_a_relational_field) ? "\$$this -> relational_field" : "" ) . ")
    {
        " . ( ($this->there_is_a_relational_field) ? "\$this->db->where('" . $this->relational_field . "', \$$this -> relational_field); " : "" ) . "
        return \$this->db->count_all_results('" . $this->controller_name . "');
    }

    function update_attributes(\$id, \$data)
    {
         return  \$this->db->where('id', \$id) ->update('" . $this->controller_name . "', \$data);
    }

function populate(\$table,\$option_val,\$option_text)
{
    \$query = \$this->db->select('*')->order_by(\$option_text)->get(\$table);
     \$dropdowns = \$query->result();
       \$options=array();
    foreach(\$dropdowns as \$dropdown) {
        \$options[\$dropdown->\$option_val] = \$dropdown->\$option_text;
    }
    return \$options;
}

    function delete(\$id)
    {
        return \$this->db->delete('" . $this->controller_name . "', array('id' => \$id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             \$this->db->query(\" " . $this->sl . $sql . " \");
      }
      
    function paginate_all(\$limit, \$page" . ( ($this->there_is_a_relational_field) ? ", \$$this -> relational_field" : "" ) . ")
    {
            \$offset = \$limit * ( \$page - 1) ;
            " . ( ($this->there_is_a_relational_field) ? "\$this->db->where('" . $this->relational_field . "', \$$this -> relational_field); " : "" ) . "
            \$this->db->order_by('id', 'desc');
            \$query = \$this->db->get('" . $this->controller_name . "', \$limit, \$offset);

            \$result = array();

            foreach (\$query->result() as \$row)
            {
                \$result[] = \$row;
            }

            if (\$result)
            {
                    return \$result;
            }
            else
            {
                    return FALSE;
            }
    }
} ";

            if ($this->save_file($this->model_name, "modules/" . $this->controller_name . "/models/", trim($data)) === TRUE)
                return TRUE;
            else
                return FALSE;
        }

        private function create_view_create()
        {
            $data = "";

            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'datepicker':

                        $data .= " ";
                        break;
                }
            }

            $data .= "
  <div class=\"col-md-8\">
        <div class=\"head\"> 
             <div class=\"icon\"><span class=\"icosg-target1\"></span></div>		
            <h2>  " . humanize($this->controller_name) . "  </h2>
             <div class=\"right\"> 
             <?php echo anchor( 'admin/" . $this->controller_name . "/create' , '<i class=\"glyphicon glyphicon-plus\">
                </i> '.lang('web_add_t', array(':name' => '" . humanize($this->controller_name) . "')), 'class=\"btn btn-primary\"');?> 
              <?php echo anchor( 'admin/" . $this->controller_name . "' , '<i class=\"glyphicon glyphicon-list\">
                </i> '.lang('web_list_all', array(':name' => '" . humanize($this->controller_name) . "')), 'class=\"btn btn-primary\"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class=\"block-fluid\">

<?php 
\$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), \$attributes); 
?>";
            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'text':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            foreach ($this->languages as $prefix => $language)
                            {
                                $data .="
                                
<div class='form-group'>
	<div class=\"col-md-3\" for='" . $index . "_" . $prefix . "'>" . humanize($index) . " ($prefix) " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div><div class=\"col-md-6\">
	<?php echo form_input('" . $index . "' ,\$result->" . $index . " , 'id=\"" . $index . "_" . $prefix . "\"  class=\"form-control\" ' );?>
 	<?php echo form_error('" . $index . "_" . $prefix . "'); ?>
</div>
</div>
";
                            }
                        }
                        else
                        {
                            $data .="
<div class='form-group'>
	<div class=\"col-md-3\" for='" . $index . "'>" . humanize($index) . " " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div><div class=\"col-md-6\">
	<?php echo form_input('" . $index . "' ,\$result->" . $index . " , 'id=\"" . $index . "_" . $prefix . "\"  class=\"form-control\" ' );?>
 	<?php echo form_error('" . $index . "'); ?>
</div>
</div>
";
                        }

                        break;

                    case 'textarea':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            foreach ($this->languages as $prefix => $language)
                            {
                                $data .="
<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>" . humanize($index) . " ($prefix) " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</h2></div>
	  <div class=\"block-fluid editor\">
    <textarea id=\"" . $index . "_" . $prefix . "\"  class=\" wysiwyg \"  name=\"" . $index . "_" . $prefix . "\"  /><?php echo set_value('" . $index . "_" . $prefix . "', (isset(\$result->" . $index . "_" . $prefix . ")) ? htmlspecialchars_decode(\$result->" . $index . "_" . $prefix . ") : ''); ?></textarea>
	<?php echo form_error('" . $index . "_" . $prefix . "'); ?>
</div>
</div>
";
                            }
                        }
                        else
                        {
                            $data .="
<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>" . humanize($index) . " " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</h2></div>
	 <div class=\"block-fluid editor\">
	<textarea id=\"" . $index . "\"   style=\"height: 300px;\" class=\" wysiwyg \"  name=\"" . $index . "\"  /><?php echo set_value('" . $index . "', (isset(\$result->" . $index . ")) ? htmlspecialchars_decode(\$result->" . $index . ") : ''); ?></textarea>
	<?php echo form_error('" . $index . "'); ?>
</div>
</div>
";
                        }

                        break;

                    case 'checkbox':
                        $data .= "
<div class='form-group'>
	<div class=\"col-md-6\"><input id='" . $index . "' " . (($value['checked'] == "TRUE") ? ' checked ' : '') . "type='checkbox' name='" . $index . "' value='1'  class=\"form-control\" <?php echo preset_checkbox('" . $index . "', '1', (isset(\$result->" . $index . ")) ? \$result->" . $index . " : ''  )?> />&nbsp;<div class='col-md-3inline' for='" . $index . "'>" . $value['label'] . " " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div>
	<?php echo form_error('" . $index . "'); ?>
</div>
</div>
";

                        break;

                    case 'select':
                        $data .="
<div class='form-group'>
	<div class=\"col-md-3\" for='" . $index . "'>" . humanize($index) . " " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div>
<div class=\"col-md-6\">";

                        $data .= "
                <?php \$items = array('' =>'', ";
                        foreach ($value['options'] as $index2 => $value2)
                        {
                            $data .= $this->sl . '"' . $index2 . '"=>"' . $value2['text'] . '",';
                        }

                        $data .= $this->sl . ");		
     echo form_dropdown('" . $index . "', \$items" . ',  (isset($result->' . $index . ")) ? \$result->" . $index . " : ''     ,   ' class=\"chzn-select\" data-placeholder=\"Select Options...\" ');
     echo form_error('" . $index . "'); ?>
</div></div>
";
                        break;

                    case 'selectbd':
                        $data .="
<div class='form-group'>
	<div class=\"col-md-3\" for='" . $index . "'>" . humanize($index) . " " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div>
	<div class=\"col-md-6\">
    <?php echo form_dropdown('" . $index . "', \$" . strtolower(str_replace('_m', '', $value['options']['model'])) . ',  (isset($result->' . $index . ")) ? \$result->" . $index . " : ''     ,   ' class=\"chzn-select\" data-placeholder=\"Select  Options...\" ');
                            ?>";


                        $data .="		
 	<?php echo form_error('" . $index . "'); ?>
</div>
</div>
";
                        break;

                    case 'radio':
                        $data .= "
<div class='form-group'>
	<div class='col-md-3'>" . humanize($index) . " " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div><div class=\"col-md-6\">";

                        $c = 0;
                        foreach ($value['options'] as $index2 => $value2)
                        {
                            $data .= $this->sl . $this->tab . "<input type='radio' name='" . $index . "' id='" . $index . "_$c' value='" . $value2['value'] . "' <?php echo preset_radio('" . $index . "', '" . $value2['value'] . "', (isset(\$result->" . $index . ")) ? \$result->" . $index . " : '" . $value['checked'] . "'  );?> > <div class='col-md-3 inline' for='" . $index . "_$c'> " . $value2['label'] . " </div>";
                            $c++;
                        }

                        $data .= "
	<?php echo form_error('" . $index . "'); ?>
</div>
</div>
";
                        break;

                    case 'datepicker':
                        $data .="
<div class='form-group'>
	<div class=\"col-md-3\" for='" . $index . "'>" . humanize($index) . " " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div><div class=\"col-md-6\">
	<input id='" . $index . "' type='text' name='" . $index . "' maxlength='' class='form-control datepicker' value=\"<?php echo set_value('" . $index . "', (isset(\$result->" . $index . ")) ? \$result->" . $index . " : ''); ?>\"  />
 	<?php echo form_error('" . $index . "'); ?>
</div>
</div>
";
                        break;

                    case 'image':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            foreach ($this->languages as $prefix => $language)
                            {
                                $data .= "
<div class='form-group'>
	<div class=\"col-md-3\" for='" . $index . "_" . $prefix . "'><?php echo lang( (\$updType == 'edit')  ? \"web_image_edit\" : \"web_image_create\" )?> [" . $index . " ($prefix)] " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div>
<div class=\"col-md-6\">
	<?php if (\$updType == 'edit'): ?>
		<p> <img src='/public/uploads/" . $this->controller_name . "/img/thumbs/<?php echo \$result->" . $index . "_" . $prefix . "?>' /> </p>
	<?php endif ?>
	<input id='" . $index . "_" . $prefix . "' type='file' name='" . $index . "_" . $prefix . "' />

	<br/><?php echo form_error('" . $index . "_" . $prefix . "'); ?>
	<?php  echo ( isset(\$upload_error['" . $index . "_" . $prefix . "'])) ?  \$upload_error['" . $index . "_" . $prefix . "']  : \"\"; ?>
</div>
</div>
";
                            }
                        }
                        else
                        {
                            $data .= "
<div class='form-group'>
	<div class=\"col-md-3\" for='" . $index . "'><?php echo lang( (\$updType == 'edit')  ? \"web_image_edit\" : \"web_image_create\" )?> (" . $index . ") " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div>
<div class=\"col-md-6\">
	<?php if (\$updType == 'edit'): ?>
		 <img src='/public/uploads/" . $this->controller_name . "/img/thumbs/<?php echo \$result->" . $index . "?>' /> 
	<?php endif ?>

	<input id='" . $index . "' type='file'  class=\"col-md-5\" name='" . $index . "' />

	<br/><?php echo form_error('" . $index . "'); ?>
	<?php  echo ( isset(\$upload_error['" . $index . "'])) ?  \$upload_error['" . $index . "']  : \"\"; ?>
</div>
</div>
";
                        }
                        break;

                    case 'file':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            foreach ($this->languages as $prefix => $language)
                            {
                                $data .= "
<div class='form-group'>
	<div class=\"col-md-3\" for='" . $index . "_" . $prefix . "'><?php echo lang( (\$updType == 'edit')  ? \"web_file_edit\" : \"web_file_create\" )?> [" . $index . " ($prefix)] " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div>
<div class=\"col-md-6\">
	<input id='" . $index . "_" . $prefix . "' type='file'  class=\"form-control\" name='" . $index . "_" . $prefix . "' />

	<?php if (\$updType == 'edit'): ?>
		<p> <a href='/public/uploads/" . $this->controller_name . "/files/<?php echo \$result->" . $index . "_" . $prefix . "?>' />Download actual file " . $index . " (" . $prefix . ")</a> </p>
	<?php endif ?>

	<br/><?php echo form_error('" . $index . "_" . $prefix . "'); ?>
	<?php  echo ( isset(\$upload_error['" . $index . "_" . $prefix . "'])) ?  \$upload_error['" . $index . "_" . $prefix . "']  : \"\"; ?>
</div>
</div>
";
                            }
                        }
                        else
                        {
                            $data .= "
<div class='form-group'>
	<div class=\"col-md-3\" for='" . $index . "'><?php echo lang( (\$updType == 'edit')  ? \"web_file_edit\" : \"web_file_create\" )?> (" . $index . ") " . (($value['required'] == "TRUE") ? "<span class='required'>*</span>" : "") . "</div>
 <div class=\"col-md-6\">
	<input id='" . $index . "' type='file' name='" . $index . "' />

	<?php if (\$updType == 'edit'): ?>
	<a href='/public/uploads/" . $this->controller_name . "/files/<?php echo \$result->" . $index . "?>' />Download actual file (" . $index . ")</a>
	<?php endif ?>

	<br/><?php echo form_error('" . $index . "'); ?>
	<?php  echo ( isset(\$upload_error['" . $index . "'])) ?  \$upload_error['" . $index . "']  : \"\"; ?>
</div>
</div>
";
                        }

                        break;

                    case 'hidden':

                        $data .= "
	<input id='" . $index . "' type='hidden' name='" . $index . "' value='<?php echo \$" . $index . "?>'/>
";
                        break;
                }
            }


            $data .= "
<div class='form-group'><div class=\"col-md-3\"></div><div class=\"col-md-6\">
    

    <?php echo form_submit( 'submit', (\$updType == 'edit') ? 'Update' : 'Save', ((\$updType == 'create') ? \"id='submit' class='btn btn-primary''\" : \"id='submit' class='btn btn-primary'\")); ?>
	<?php echo anchor('admin/" . $this->controller_name . "','Cancel','class=\"btn  btn-default\"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class=\"clearfix\"></div>
 </div>
            </div>
       
  
  ";

            $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name . "/views/admin");
            if ($this->save_file('create', "modules/" . $this->controller_name . "/views/admin/", trim($data)) === TRUE)
                return TRUE;
            else
            {
                $this->errors = lang('scaffolds_error_file') . " view/" . $this->controller_name . "/create.php";
                return FALSE;
            }
        }

        private function create_view_list()
        {
            $data = " ";
            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'text':
                    case 'textarea':
                    case 'image':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            $data .= "<?php \$" . $index . "_with_actual_language = '" . $index . "_'.\$this->config->item('prefix_language'); ?>" . $this->sl;
                        }

                        break;
                }
            }


            $data .= "
 
        <div class=\"head\"> 
			 <div class=\"icon\"><span class=\"icosg-target1\"></span> </div>
            <h2>  " . humanize($this->controller_name) . "  </h2>
             <div class=\"right\">  
             <?php echo anchor( 'admin/" . $this->controller_name . "/create/" . (($this->there_is_a_relational_field) ? "<?php echo \$this -> relational_field?>/" : "") . "'.\$page, '<i class=\"glyphicon glyphicon-plus\"></i> '.lang('web_add_t', array(':name' => '" . humanize($this->controller_name) . "')), 'class=\"btn btn-primary\"');?>
			 
			 <?php echo anchor( 'admin/" . $this->controller_name . "' , '<i class=\"glyphicon glyphicon-list\">
                </i> '.lang('web_list_all', array(':name' => '" . humanize($this->controller_name) . "')), 'class=\"btn btn-primary\"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if (\$" . $this->controller_name . "): ?>
                 <div class=\"block-fluid\">
				<table class=\"fpTable\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
	 <thead>
                <th>#</th>";
            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'text':
                    case 'textarea':
                    case 'image':
                    case 'file':

                        $data .="<th>" . humanize($index) . "</th>";

                        break;
                }
            }

            $data .="	<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             \$i = 0;
                                if (\$this->uri->segment(4) && ( (int) \$this->uri->segment(4) > 0))
                                {
                                    \$i = (\$this->uri->segment(4) - 1) * \$per; // OR  (\$this->uri->segment(4)  * \$per) -\$per;
                                }
                
            foreach (\$" . $this->controller_name . " as \$p ): 
                 \$i++;
                     ?>
	 <tr>
                <td><?php echo \$i . '.'; ?></td>";

            foreach ($this->arrayjson as $index => $value)
            {
                switch ($value['type'])
                {
                    case 'text':
                    case 'textarea':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            $data .= $this->tabx5 . "<td><?php echo \$p->\$" . $index . "_with_actual_language;?></td>" . $this->sl;
                        }
                        else
                        {
                            $data .= $this->tabx5 . "<td><?php echo \$p->" . $index . ";?></td>" . $this->sl;
                        }

                        break;


                    case 'image':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            $data .= $this->tabx5 . "<td><img src='/public/uploads/" . $this->controller_name . "/img/thumbs/<?php "
                                    . "echo \$p->\$" . $index . "_with_actual_language?>' border='0' /></td>" . $this->sl;
                        }
                        else
                        {
                            $data .= $this->tabx5 . "<td><img src='/public/uploads/" . $this->controller_name . "/img/thumbs/<?php "
                                    . "echo \$p->" . $index . "?>' border='0' /></td>" . $this->sl;
                        }

                        break;


                    case 'file':

                        if ($value['multilanguage'] == "TRUE")
                        {
                            $data .= $this->tabx5 . "<td>";
                            foreach ($this->languages as $prefix => $language)
                            {
                                $data .= $this->tabx6 . "<a href='/public/uploads/" . $this->controller_name . "/files/<?php echo \$p->" . $index . "_" . $prefix . "?>'/>Download " . $index . " (" . $prefix . ")</a></br></br>" . $this->sl;
                            }
                            $data .= $this->tabx5 . "</td>";
                        }
                        else
                        {
                            $data .= $this->tabx5 . "<td><a href='/public/uploads/" . $this->controller_name . "/files/<?php echo \$p->" . $index . "?>' />Download file (" . $index . ")</a></td>" . $this->sl;
                        }
                        break;
                }
            }

            $data .= "
			 <td width='30'>
						 <div class='btn-group'>
							<button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
							<ul class='dropdown-menu pull-right'>
								 <li><a href='<?php echo site_url('admin/" . $this->controller_name . "/edit/'.\$p->id.'/'.\$page);?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
								<li><a  href='<?php echo site_url('admin/" . $this->controller_name . "/edit/'.\$p->id.'/'.\$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>
							  
								<li><a  onClick=\"return confirm('<?php echo lang('web_confirm_delete')?>')\" href='<?php echo site_url('admin/" . $this->controller_name . "/delete/'.\$p->id.'/'.\$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
							</ul>
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?> ";

            $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name . "/views/admin");
            if ($this->save_file('list', "modules/" . $this->controller_name . "/views/admin/", trim($data)) === TRUE)
                return TRUE;
            else
            {
                $this->errors = lang('scaffolds_error_file') . " view/" . $this->controller_name . "/list.php";
                return FALSE;
            }
        }

        private function modify_routes()
        {
            $data = $this->sl . $this->sl;
            $data .="//Routes For " . $this->controller_name . $this->sl;
            $data .= "\$route['" . $this->controller_name . "/(:num)'] = '" . $this->controller_name . "/index/$1';";

            if ($this->there_is_a_relational_field)
            {
                $data .= $this->sl . "\$route['" . $this->controller_name . "/(:num)/(:num)'] = '" . $this->controller_name . "/index/$1/$2';";
            }

            if ($this->save_file('routes', "config/", $data, 'a') === TRUE)
                return TRUE;
            else
            {
                $this->errors = lang('scaffolds_error_modify') . " config/routes.php";
                return FALSE;
            }
        }

        private function modify_menu()
        {
            //No modificamos menu si es relacion
            if ($this->there_is_a_relational_field)
                return TRUE;


            $data = $this->sl . $this->sl;
            $data .= "<?php  \$mactive = (\$this->uri->rsegment(1) == '" . $this->controller_name . "')  ? \"class='selected'\" : \"\" ?>" . $this->sl;
            $data .= "<li <?php echo \$mactive?>><a href=\"" . $this->controller_name . "/\" style=\"background-position: 0px 0px;\">" . ucfirst($this->controller_name) . "</a></li>";

            if ($this->save_file('_menu', "views/partials/", $data, 'a') === TRUE)
                return TRUE;
            else
            {
                $this->errors = lang('scaffolds_error_modify') . " config/routes.php";
                return FALSE;
            }
        }

        private function add_relational_link_to_list()
        {
            $file = file(APPPATH . "views/" . $this->relational_controller . "/list.php");

            /*
              $tds = array_keys( $file, '<td' );
              $pos_to_insert = $tds[count($tds)-1];
             */
            $pos = count($file) - 1;
            $tds_found = 0;
            while ($pos > 0 and $tds_found < 2)
            {
                if (strpos($file[$pos], '<td') !== FALSE)
                {
                    $tds_found++;
                }
                $pos--;
            }

            for ($i = count($file); $i > $pos; $i--)
            {
                $file[$i] = $file[($i - 1)];
            }

            if ($this->scaffold_model_type == 'phpactiverecord')
                $file[$pos + 1] = $this->tabx5 . "<td><a href=\"/" . $this->controller_name . "/<?php echo \$" . $this->relational_model . "->id?>\">" . ucfirst($this->controller_name) . " (<?php echo  " . $this->model_name_for_calls . "::count(array('conditions' => array('" . $this->relational_field . " = ?', \$" . $this->relational_model . "->id)) )?>) </a></td>" . $this->sl;
            else if ($this->scaffold_model_type == 'activerecord')
                $file[$pos + 1] = $this->tabx5 . "<td><a href=\"/" . $this->controller_name . "/<?php echo \$" . $this->relational_model . "->id?>\">" . ucfirst($this->controller_name) . " (<?php echo  " . $this->model_name_for_calls . "::count(\$" . $this->relational_model . "->id)?>) </a></td>" . $this->sl;

            $result = file_put_contents(APPPATH . "views/" . $this->relational_controller . "/list.php", $file);


            if ($result)
                return TRUE;
            else
            {
                $this->errors = "Error modificando lista";
                return FALSE;
            }
        }

        private function create_folder_if_no_exists($path)
        {
            if (@mkdir($path))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }

        private function save_file($filename, $path, $data, $mode = "w")
        {
            if (!is_dir(APPPATH . $path))
            {
                $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name);
                $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name . "/controllers");
                $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name . "/models");
                $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name . "/views");
                $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name . "/config");
                $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name . "/sql");
                $this->create_folder_if_no_exists(APPPATH . $path);
            }
            $file = fopen(APPPATH . $path . $filename . ".php", $mode);

            if ($file)
            {
                $result = fputs($file, $data);
            }

            fclose($file);

            if ($result)
                return TRUE;
            else
            {
                $this->errors = lang('scaffolds_error_file') . " " . APPPATH . $path . $filename . ".php";
                return FALSE;
            }
        }

        private function save_sql($filename, $path, $data, $ext, $mode = "w")
        {
            if (!is_dir(APPPATH . $path))
            {
                $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name);
                $this->create_folder_if_no_exists(APPPATH . "modules/" . $this->controller_name . "/sql");
                $this->create_folder_if_no_exists(APPPATH . $path);
            }
            $file = fopen(APPPATH . $path . $filename . $ext, $mode);

            if ($file)
            {
                $result = fputs($file, $data);
            }

            fclose($file);

            if ($result)
                return TRUE;
            else
            {
                $this->errors = lang('scaffolds_error_file') . " " . APPPATH . $path . $filename . $ext;
                return FALSE;
            }
        }

    }
    