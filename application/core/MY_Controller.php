<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Code here is run before ALL controllers
class MY_Controller extends CI_Controller
{

    // Deprecated: No longer used globally
    protected $data;
    public $module;
    public $controller;
    public $method;

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        if (!defined('ADDONPATH'))
            define('ADDONPATH', base_url() . 'assets/');
        //define('BASE_URI',BASEPATH);
        define('BASE_URL', '');
        $this->template->add_theme_location(FCPATH . 'assets/themes/');
        $slug = "default";
        $theme = new stdClass();
        $theme->slug = $slug;
        $theme->is_core = 1;
        $theme->path = base_url() . 'assets/themes/' . $slug;
        $theme->web_path = FCPATH . 'assets/themes/' . $slug;
        $theme->screenshot = $theme->web_path . '/screenshot.png';
        // Load the admin theme so things like partials and assets are available everywhere

        $this->theme = $theme;
        $admin_theme = new stdClass();
        $admin_theme->slug = 'admin';
        $admin_theme->is_core = 1;
        $admin_theme->path = base_url() . 'assets/themes/' . $admin_theme->slug;
        $admin_theme->web_path = FCPATH . 'assets/themes/' . $slug;
        $admin_theme->screenshot = $admin_theme->web_path . '/screenshot.png';
        $this->admin_theme = $admin_theme;
        // Load the current theme so we can set the assets right away
        // Work out module, controller and method and make them accessable throught the CI instance
        $this->module = $this->router->fetch_module();
        $this->controller = $this->router->fetch_class();
        $this->method = $this->router->fetch_method();

        // make a constant as this is used in a lot of places
        define('ADMIN_THEME', $this->admin_theme->slug);
 
    }

}

/**
 * Returns the CI object.
 *
 * Example: ci()->db->get('table');
 *
 * @static var object	$ci
 * @return object
 */
function ci()
{
    return get_instance();
}
