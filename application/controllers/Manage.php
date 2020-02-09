<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller {
    const PRODUCT_TYPE_MAP = array(
        "dresses" => "长裙",
        "coats" => "外套",
        "jeans" => "牛仔裤",
        "skirts" => "短裙",
        "trousers" => "长裤",
        "pants" => "短裤",
        "jackets" => "夹克",
        "socks" => "袜子",
        "hoses" => "长筒袜",
        "bras" => "纹胸",
        "underwears" => "内衣"
    );

    public function login() {
        require_once('Login.php');
        $obj = new Login;
        return $obj;
    }

	public function index()
	{
        $this->load->helper('url');
        $var['product_type_map'] = self::PRODUCT_TYPE_MAP;
        
        $var['user'] = null;
        $var['error'] = null;
        $login = $this->login();
        $user_data = $login->check_token_exists();
        if (count($user_data) > 0) {
            $var['user'] = $user_data['user'];
            $var['user_detail'] = $user_data;
            $login->refresh_token_timeout($user_data['token'], 1800, '/');
        
            if ($user_data['tag'] == 'admin' and $user_data['authority'] == 31) {
                $this->load->view('Manage_view');
            }
        } else {
            $var['error'] = "您没有足够的权限访问该页面，请联系网站管理员。";
            $this->load->view('User_nav_view', $var);
            $this->load->view('Main_view', $var);
        }
        
	}
    
    public function nav()
	{
        $this->load->helper('url');
        $var['product_type_map'] = self::PRODUCT_TYPE_MAP;
        
        $this->load->view('Manage_nav_view', $var);
	}
}
