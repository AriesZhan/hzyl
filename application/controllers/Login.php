<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
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
    
	public function index()
	{
        $this->load->helper('url');
        $var['user'] = null;
        $var['error'] = null;
        $var['product_type_map'] = self::PRODUCT_TYPE_MAP;
         
        $user_data = $this->check_token_exists();
        if (count($user_data) > 0) {
            $var['user'] = $user_data['user'];
            $this->load->view('User_nav_view', $var);
            $this->load->view('Main_view', $var);
        } else {
            $this->load->view('Login_view', $var);
        }
	}
    
    public function auth()
	{
        $this->load->helper('url');
        $this->load->model('database_model');
        $var['user'] = $user = $_POST['username'];
        $c_passwd = $_POST['password'];
        $token = null;
        $var['error'] = null;
        $s_passwd = "";
        $s_uid = null;
        $var['product_type_map'] = self::PRODUCT_TYPE_MAP;
        
        
        $data = $this->database_model->get_items_with_condition('user', "user='$user'");
        if (count($data) == 1) {
            $s_passwd = $data[0]->passwd;
            $s_uid = $data[0]->id;
        } else {
            $var['error'] = "用户名不存在，请确认你输入的用户名是否正确。";
            $this->load->view('Login_view', $var);
            return;
        }
        
        if (password_verify($c_passwd, $s_passwd)) {
            $token_timeout = 1800;
            $token = $this->set_token(array($s_uid, $user, $s_passwd));
            $this->refresh_token_timeout($token, $token_timeout, "/");
            #setcookie('user', $user, $expired, "/");
            $this->load->view('User_nav_view', $var);
            $this->load->view('Main_view', $var);
        } else {
            $var['error'] = "用户认证失败，请确认您输入的用户名和密码";
            $this->load->view('Login_view', $var);
        }
	}
    
    public function regist_form()
	{
        $this->load->helper('url');
        $var['user'] = null;
        $var['token'] = null;
        $var['error'] = null;
		$this->load->view('Regist_view', $var);
	}
    
    public function regist_submit()
	{
        $this->load->helper('url');
        $this->load->model('database_model');
        
        $var['user'] = $user = $_POST['username'];
        $c_passwd = $_POST['password'];
        $var['tel'] = $tel = $_POST['tel'];
        $var['address'] = $address = $_POST['address'];
        $var['token'] = null;
        $var['error'] = null;
        $user_data = array();
        
        $query_result = $this->database_model->get_items_with_condition('user', "user='$user'");
        if (count($query_result) > 0) {
            $var['error'] = "您所选择的用户名已存在，请重新选择其他用户名进行注册。";
            $this->load->view('Regist_view', $var);
            return;
        }
        $query_result = $this->database_model->get_items_with_condition('user', "tel='$tel'");
        if (count($query_result) > 0) {
            $var['error'] = "手机号已注册，请更换其他手机号注册。";
            $this->load->view('Regist_view', $var);
            return;
        }
        $s_passwd = password_hash($c_passwd, PASSWORD_BCRYPT);
        
        $user_data += ['user'=>$user, 'passwd'=>$s_passwd, 'tel'=>$tel, 'address'=>$address];
        
        $this->database_model->insert_row('user', $user_data);
        
        $this->load->view('User_view', $var);
	}
    
    public function set_token($str_array) {
        $str_mix = "";
        foreach ($str_array as $seg) {
            $str_mix .= $seg;
        }
        $token = md5($str_mix);
        # here still need to enhance codes to add token in database.
        $this->load->model('database_model');
        $this->database_model->update_row('user', array('token'=>$token), array('user', $str_array[1]));
        return $token;
    }
    
    public function refresh_token_timeout($token, $timeout, $path) {
        if ($token and $timeout and $path) {
            $expired = time()+$timeout;
            setcookie('token', $token, $expired, $path);
        }
    }
    
    public function get_user_info_by_token($token) {
        $user_data = array();
        $this->load->model('database_model');
        $user_info = $this->database_model->get_items_with_condition('user', "token='$token'");
        if (count($user_info) > 0) {
            foreach ($user_info as $index => $row) {
                $user_data['id'] = $row->id;
                $user_data['user'] = $row->user;
                $user_data['passwd'] = $row->passwd;
                $user_data['tel'] = $row->tel;
                $user_data['tag'] = $row->tag;
                $user_data['address'] = $row->address;
                $user_data['authority'] = $row->authority;
                $user_data['token'] = $row->token;
                $user_data['cart'] = $row->cart;
            }
        }
        return $user_data;
    }
    
    public function check_token_exists() {
        $user_info = array();
        if(key_exists('token', $_COOKIE)) {
            $user_info = $this->get_user_info_by_token($_COOKIE['token']);
        }
        return $user_info;
    }
}
