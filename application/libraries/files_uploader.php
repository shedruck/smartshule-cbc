<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

/**
 * Name:  Files Uploader
 *
 *
 */
class Files_uploader
{

        private $ci;
        public $error_msg = array();
		
        public function __construct()
        {
                $this->ci = & get_instance();
                $this->ci->load->library('email');
                $this->ci->load->library('session');
                $this->ci->load->library('ion_auth');
                $this->ci->load->helper('download');
        }

        /**
         * Create new files
         * @access public
         * @return void
         */
        public function upload($file = "")
        {
                if (!$file)
                        return false;

                if ($_FILES[$file]['name'])
                {
                        $document = '';
                        $config['upload_path'] = 'uploads/files';
                        $config['allowed_types'] = 'pdf|doc|docx|jpg|png|gif';
                        $config['remove_spaces'] = TRUE;
                        /*
                          $config['max_size']	= 0;
                          $config['max_width']  = 1500;
                          $config['max_height']  = 1500; 
						  */
                        $this->ci->load->library('upload', $config);
                        $file_size = "";
                        $file_type = "";
                        $ud = array();
                        if (!empty($_FILES[$file]['name']))
                        {
                                $this->ci->upload->do_upload($file);
                                $upload_data = $this->ci->upload->data();
                                $document = $upload_data['file_name'];
                                $file_type = $upload_data['file_type'];
                                $file_size = $upload_data['file_size'];
                                $ud = $upload_data;
                        }


                        if (isset($ud['is_image']) && $ud['is_image'])
                        {
                                $path = 'uploads/files/' . $document;
                                $ok = $this->_generate_image_thumbnail($path, $path, 1400);
                                if ($ok)
                                {
                                        
                                }
                        }
                        return $ud;
                }
                else
                {
                        return false;
                }
        }
		
 public function data()
    {
        return array(
            'file_name' => $this->file_name,
            'file_type' => $this->file_type,
            'file_path' => $this->upload_path,
            'full_path' => $this->upload_path . $this->file_name,
            'raw_name' => str_replace($this->file_ext, '', $this->file_name),
            'orig_name' => $this->orig_name,
            'client_name' => $this->client_name,
            'file_ext' => $this->file_ext,
            'file_size' => $this->file_size,
            'is_image' => $this->is_image(),
            'image_width' => $this->image_width,
            'image_height' => $this->image_height,
            'image_type' => $this->image_type,
            'image_size_str' => $this->image_size_str,
        );
    }
		
		 /**
			 * Display the error message
			 *
			 * @param	string
			 * @param	string
			 * @return	string
			 */
			public function display_errors($open = '<p>', $close = '</p>')
			{
				$str = '';
				foreach ($this->error_msg as $val)
				{
					$str .= $open . $val . $close;
				}

				return $str;
			}

        public function get_school_file($file = "", $school_id = 0)
        {
                if (file_exists('school_uploads/files/' . $file) && !empty($file) && is_file('school_uploads/files/' . $file))
                {
                        $this->ci->load->model('school_files/school_files_m');
                        return $this->ci->school_files_m->get_by_filename($file);
                }
                else
                {
                        return false;
                }
        }

        public function get_school_file_by_id($id, $school_id = 0)
        {
                $this->ci->load->model('school_files/school_files_m');
                return $this->ci->school_files_m->get($id);
        }

        public function get_file($file = "", $school_id = 0)
        {
                if (file_exists('uploads/files' . $file) && !empty($file) && is_file('uploads/files' . $file))
                {
                        $this->ci->load->model('files/files_m');
                        return $this->ci->files_m->get_by_filename($file);
                }
                else
                {
                        return false;
                }
        }

        /*
         * PHP function to resize an image maintaining aspect ratio
         * http://salman-w.blogspot.com/2008/10/resize-images-using-phpgd-library.html
         *
         * Creates a resized (e.g. thumbnail, small, medium, large)
         * version of an image file and saves it as another file
         */

        function _generate_image_thumbnail($source_image_path, $thumbnail_image_path, $thumbnail_image_width)
        {

                ini_set('max_execution_time', 300);
                ini_set('memory_limit', '300M'); //you need much memory here

                list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
                switch ($source_image_type)
                {
                        case IMAGETYPE_GIF:
                                $source_gd_image = imagecreatefromgif($source_image_path);
                                break;
                        case IMAGETYPE_JPEG:
                                $source_gd_image = imagecreatefromjpeg($source_image_path);
                                break;
                        case IMAGETYPE_PNG:
                                $source_gd_image = imagecreatefrompng($source_image_path);
                                break;
                }
                if ($source_gd_image === false)
                {
                        return false;
                }

                if ($thumbnail_image_width >= $source_image_width)
                {
                        imagedestroy($source_gd_image);
                        return false;
                }
                $thumbnail_image_height = (int) ($source_image_height * $thumbnail_image_width) / $source_image_width;

                $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
                imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
                switch ($source_image_type)
                {
                        case IMAGETYPE_GIF:
                                imagegif($thumbnail_gd_image, $thumbnail_image_path, 90);
                                break;
                        case IMAGETYPE_JPEG:
                                imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 90);
                                break;
                        case IMAGETYPE_PNG:
                                imagepng($thumbnail_gd_image, $thumbnail_image_path, 9);
                                break;
                }

                imagedestroy($source_gd_image);
                imagedestroy($thumbnail_gd_image);
                return $thumbnail_image_height;
        }

}
