<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Files Uploader
*
*
*/
class Uploader
{
	private $ci; 
	public function __construct()
	{
		$this->ci= & get_instance();
		$this->ci->load->library('email');
		$this->ci->load->library('session');
 		//$this->ci->load->model('files/files_m');	
		$this->ci->load->helper('download');
		
		
	}
	/**
	 * Create new files
	 * @access public
	 * @return void
	 */
	public function upload($file = "")
	{
		if(!$file) return false;
		
		if ($_FILES[$file]['name'])
		{
			$document='';
			$config['upload_path'] = 'uploads/files';
			$config['allowed_types'] = 'pdf|doc|docx|jpg|png|gif|jpeg';
			$config['remove_spaces']= TRUE;
			/*
			$config['max_size']	= 0;
			$config['max_width']  = 1500;
			$config['max_height']  = 1500;*/
			$this->ci->load->library('upload', $config);
			$file_size ="";
			$file_type ="";
			$ud=array();
			if(!empty($_FILES[$file]['name'])){
				$this->ci->upload->do_upload($file);
				$upload_data =$this->ci->upload->data();
				$document=$upload_data['file_name'];	
				$file_type=$upload_data['file_type'];	
				$file_size=$upload_data['file_size'];	
				$ud=$upload_data;	
			}
		
		return $ud;
		}
		else{
			return false;
		}
	}
	
	

	
	public function get_file($file = "",$school_id=0)
	{
		if(file_exists('uploads/files'.$file)&&!empty($file)&&is_file('uploads/files'.$file)){
			$this->ci->load->model('files/files_m');
			return $this->ci->files_m->get_by_filename($file);
		}
		else{
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
	function _generate_image_thumbnail($source_image_path, $thumbnail_image_path,$thumbnail_image_width)
	{
	
		ini_set('max_execution_time', 300);
		ini_set('memory_limit','300M'); //you need much memory here
		
		list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
		switch ($source_image_type) {
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
		if ($source_gd_image === false) {
			return false;
		}
		
		if($thumbnail_image_width>=$source_image_width){
			imagedestroy($source_gd_image);
			return false;
		}
		$thumbnail_image_height = (int)($source_image_height*$thumbnail_image_width)/$source_image_width;
		
		$thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
		imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
		switch ($source_image_type) {
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