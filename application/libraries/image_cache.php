<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Files Uploader
 *
 *
 */
class Image_cache
{

    private $ci;

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    function _get_path($image_http_path, $is_u = 0)
    {

        $data_array = explode("/", strrev($image_http_path));
        $a = strrev($data_array[3]);
        $w = strrev($data_array[2]);
        $h = strrev($data_array[1]);
        $filename = strrev($data_array[0]);
        if ($is_u)
        {
            if (!defined('DIR_CACHE'))
                define('DIR_CACHE', './cache');
            if (!defined('IMAGE_DIR'))
                define('IMAGE_DIR', './files');
            if (!defined('MEM_LIMIT'))
                define('MEM_LIMIT', '300M');
        }
        else
        {
            if (!defined('DIR_CACHE'))
                define('DIR_CACHE', './uploads/cache');
            if (!defined('IMAGE_DIR'))
                define('IMAGE_DIR', './uploads/files');
            if (!defined('MEM_LIMIT'))
                define('MEM_LIMIT', '300M');
        }
        $align = $a;

        $filename = IMAGE_DIR . '/' . $filename;
        //echo $filename; die;
        ini_set('memory_limit', MEM_LIMIT);
        if (!file_exists(DIR_CACHE))
        {
            // give 777 permissions so that developer can overwrite
            // files created by web server user
            mkdir(DIR_CACHE);
            chmod(DIR_CACHE, 0777);
        }
        if (!file_exists($filename))
        {
            die("Invalid Image specified " . $filename);
        }

        if ($w == 0 && $h == 0)
        {
            return $filename;
        }

        if (!preg_match("/jpg|jpeg|gif|png/i", basename($filename)))
        {
            die('Invalid image type');
        }

        //generate cache name
        //define the cached file name
        $image_string_path = str_replace(base_url(), '', $image_http_path); //$this->uri->uri_string();
        $cache_file = DIR_CACHE . '/' . md5($image_string_path) . preg_replace('/\h|\v/', '_', basename($filename));


        //display cache file if present
        if (file_exists($cache_file))
        {
            return $cache_file;
        }
        $new_width = 0;
        $new_height = 0;

        //set the get vars for timthumb.php
        if ($w)
            $new_width = $w;
        if ($h)
            $new_height = $h;
        $quality = 100;
        $zoom_crop = 2;
        if ($filename)
            $src = $filename;

        if (!$w && !$h)
            $new_width = 100;
        //include("timthumb.php");


        if (file_exists($src))
        {
            $mime_type = $this->_mime_type($src);
            // open the existing image
            $image = $this->_open_image($mime_type, $src);
            if ($image === false)
            {
                display_error('Unable to open image : ' . $src);
            }
            // Get original width and height
            $width = imagesx($image);
            $height = imagesy($image);
            $origin_x = 0;
            $origin_y = 0;
            // generate new w/h if not provided
            if ($new_width && !$new_height)
            {
                $new_height = floor($height * ($new_width / $width));
            }
            else if ($new_height && !$new_width)
            {
                $new_width = floor($width * ($new_height / $height));
            }
            // scale down and add borders
            if ($zoom_crop == 3)
            {
                $final_height = $height * ($new_width / $width);
                if ($final_height > $new_height)
                {
                    $new_width = $width * ($new_height / $height);
                }
                else
                {
                    $new_height = $final_height;
                }
            }
            // create a new true color image
            $canvas = imagecreatetruecolor($new_width, $new_height);
            imagealphablending($canvas, false);
            // Create a new transparent color for image
            $color = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            // Completely fill the background of the new image with allocated color.
            imagefill($canvas, 0, 0, $color);
            // Restore transparency blending
            imagesavealpha($canvas, true);
            if ($zoom_crop > 0)
            {
                $src_x = $src_y = 0;
                $src_w = $width;
                $src_h = $height;
                $cmp_x = $width / $new_width;
                $cmp_y = $height / $new_height;
                // calculate x or y coordinate and width or height of source
                if ($cmp_x > $cmp_y)
                {
                    $src_w = round($width / $cmp_x * $cmp_y);
                    $src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
                }
                else if ($cmp_y > $cmp_x)
                {
                    $src_h = round($height / $cmp_y * $cmp_x);
                    $src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
                }
                // positional cropping!
                switch ($align)
                {
                    case 't':
                    case 'tl':
                    case 'lt':
                    case 'tr':
                    case 'rt':
                        $src_y = 0;
                        break;
                    case 'b':
                    case 'bl':
                    case 'lb':
                    case 'br':
                    case 'rb':
                        $src_y = $height - $src_h;
                        break;
                    case 'l':
                    case 'tl':
                    case 'lt':
                    case 'bl':
                    case 'lb':
                        $src_x = 0;
                        break;
                    case 'r':
                    case 'tr':
                    case 'rt':
                    case 'br':
                    case 'rb':
                        $src_x = $width - $new_width;
                        $src_x = $width - $src_w;
                        break;
                    default:
                        break;
                }
                imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
            }
            else
            {
                // copy and resize part of an image with resampling
                imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            }
            if (preg_match('/png/', $mime_type))
            {
                //save to cache
                imagepng($canvas, $cache_file);
                return $cache_file;
                //header("content-type: image/png");
                //imagepng($canvas);
            }
            else if (preg_match('/gif/', $mime_type))
            {
                //save to cache
                imagegif($canvas, $cache_file);
                return $cache_file;
                //header("content-type: image/png");
                //imagepng($canvas);
            }
            else
            {
                //save to cache
                imagejpeg($canvas, $cache_file);
                // output image to browser based on mime type
                return $cache_file;
                //header("content-type: image/jpeg");
                //imagejpeg($canvas);
            }
            // remove image from memory
            imagedestroy($canvas);
        }
    }

    function _open_image($mime_type, $src)
    {
        if (strpos($mime_type, 'jpeg') !== false)
        {
            $image = imagecreatefromjpeg($src);
        }
        elseif (strpos($mime_type, 'png') !== false)
        {
            $image = imagecreatefrompng($src);
        }
        elseif (strpos($mime_type, 'gif') !== false)
        {
            $image = imagecreatefromgif($src);
        }
        return $image;
    }

    function _mime_type($file)
    {
        $file_infos = getimagesize($file);
        $mime_type = $file_infos['mime'];
        // no mime type
        if (empty($mime_type))
        {
            display_error('no mime type specified');
        }
        // use mime_type to determine mime type
        if (!preg_match("/jpg|jpeg|gif|png/i", $mime_type))
        {
            display_error('Invalid src mime type: ' . $mime_type);
        }
        return strtolower($mime_type);
    }

    public function get_embed($content, $is_ = 0)
    {
        preg_match_all('/(?<!_)src=([\'"])?(.*?)\\1/', $content, $matches);
        $embed_array = array();
        foreach ($matches[2] as $path)
        {
            if ($is_)
            {
                if (!preg_match('/files/', $path))
                    continue;
            }
            else
            {
                if (!preg_match('/files/', $path))
                    continue;
            }

            $cid = rand(111, 999) . '_' . basename($path);
            $cid = str_replace('.', '_', $cid);
            $cid = str_replace(' ', '_', $cid);
            $embed_array[$cid] = $this->_get_path($path, $is_);
            $content = str_replace($path, 'cid:' . $cid, $content);
        }
        return array('content' => $content, 'embed' => $embed_array);
    }

}
