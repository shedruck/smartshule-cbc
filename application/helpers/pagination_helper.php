<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
  * The Pagination helper cuts out some of the bumf of normal pagination with the Paging Meta of To and From Added to the array
  * @author		Philip Sturgeon
  * @filename	pagination_helper.php
  * @title		Pagination Helper
  * @version	1.0
 **/

function create_pagination($uri, $total_rows, $limit = NULL, $uri_segment = 4, $full_tag_wrap = TRUE)
{
	$ci =& get_instance();
	$ci->load->library('pagination');

	$current_page = $ci->uri->segment($uri_segment, 0);

	// Initialize pagination
	$config['suffix']				= $ci->config->item('url_suffix');
	$config['base_url']				= $config['suffix'] !== FALSE ? rtrim(site_url($uri), $config['suffix']) : site_url($uri);
	$config['total_rows']			= $total_rows; // count all records
	$config['per_page']				= $limit === NULL ? 25 : $limit;
	$config['uri_segment']			= $uri_segment;
	
	
	$config['page_query_string']	= FALSE;
	$config['num_links'] = 4;
	$config['full_tag_open'] = '<div class="pagination"><ul class="pagination">';
	$config['first_link'] = '&laquo; First';
	$config['last_link'] = 'Last &raquo;';
	$config['next_link'] = 'Next &rsaquo;';
	$config['prev_link'] = '&lsaquo; Prev';
	$config['cur_tag_open'] = '<li><a href="" class="active">';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['prev_tag_open'] = '<li class="prev">';
	$config['prev_tag_close'] = '</li>';
	$config['first_tag_open'] = '<li class="first">';
	$config['first_tag_close'] = '</li>';
	$config['last_tag_open'] = '<li class="last">';
	$config['last_tag_close'] = '</li>';
	$config['next_tag_open'] = '<li class="next">';
	$config['next_tag_close'] = '</li>';
	$config['full_tag_close'] = '</ul></div>';
	$ci->pagination->initialize($config); // initialize pagination
	$to_page=$current_page+$config['per_page'];
	if($to_page>$total_rows) $to_page=$total_rows;
	
	return array(
		'total' 	=> $total_rows,
		'to' 	=> $to_page,
		'from' 	=> ($total_rows>0)?($current_page+1):0,
		'current_page' 	=> $current_page,
		'per_page' 		=> $config['per_page'],
		'limit'			=> array($config['per_page'], $current_page),
		'links' 		=> $ci->pagination->create_links($full_tag_wrap)
	);
}