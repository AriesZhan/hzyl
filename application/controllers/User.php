<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
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
        $var['user'] = null;
        $var['error'] = null;
        $var['cart'] = array();
        $var['product_type_map'] = self::PRODUCT_TYPE_MAP;
        
        $login = $this->login();
        $user_data = $login->check_token_exists();
        if (count($user_data) > 0) {
            $var['user'] = $user = $user_data['user'];
            $var['user_detail'] = $user_data;
            $var['cart'] = array();
            $cart_items = $login->database_model->get_items_with_condition('cart', "user='$user'");
            if (count($cart_items) > 0) {
                    foreach ($cart_items as $row) {
                        $pics_array = explode(',', $row->pics);
                        $videos_array = explode(',', $row->videos);
                        $row->pics = $pics_array;
                        $row->videos = $videos_array;
                        array_push($var['cart'], $row);
                    }
            }
            $login->refresh_token_timeout($user_data['token'], 1800, '/');
            $this->load->view('User_nav_view', $var);
            $this->load->view('User_view', $var);
        } else {
            $this->load->view('Login_view', $var);
        }
	}
    
    public function cart() {
        $action = $this->uri->segment(3);
        $product_type = $this->uri->segment(4);
        $product_code = $this->uri->segment(5);
        $product_num_in_cart = $this->uri->segment(6);
        $this->load->helper('url');
        $login = $this->login();
        $user_data = $login->check_token_exists();
        if (count($user_data) > 0) {
            $var['user'] = $user = $user_data['user'];
            $var['user_detail'] = $user_data;
            $login->refresh_token_timeout($user_data['token'], 1800, '/');
        } else {
            $login->index();
            return;
        }
        
        if (strcmp($action, 'add') == 0) {
            $row = $login->database_model->query("select * from $product_type where code='$product_code'")->row();
            $data['user'] = $user;
            $data['type'] = $row->type;
            $data['code'] = $row->code;
            $data['name'] = $row->name;
            $data['description'] = $row->description;
            $data['pics'] = $row->pics;
            $data['videos'] = $row->videos;
            $data['price'] = $row->price;
            #$sql = 'insert into cart set ';
            #foreach ($data as $key => $value) {
            #    $sql .= $key.'='."'$value'".',';
            #}
            #$sql = trim($sql, ',');
            #$sql .= ' ON DUPLICATE KEY UPDATE count=count+1';
            #echo $sql;
            if($login->database_model->query("select * from cart where user='$user' and code='$product_code'")->num_rows() > 0) {
                if ($login->database_model->query("update cart set count=count+1 where user='$user' and code='$product_code'")) {
                    echo "更新购物车成功！";
                } else {
                    echo "更新购物车失败，请重试！";
                }
            } else {
                if ($login->database_model->insert_row('cart', $data)) {
                    echo "加入购物车成功！";
                } else {
                    echo "加入购物车失败，请重试！";
                }
            }
            
            
        } elseif (strcmp($action, 'delete') == 0 or $product_num_in_cart == 0) {
            if ($login->database_model->delete_row($product_type, array('user'=>$user, 'code'=>$product_code))) {
                echo "从购物车删除商品成功！";
            } else {
                echo "从购物车删除商品失败，请重试！";
            }
        } elseif (strcmp($action, 'reduce') == 0) {
            if ($login->database_model->update_row($product_type, array('count'=>$product_num_in_cart), array('user'=>$user, 'code'=>$product_code))) {
                echo "修改购物车商品数量成功！";
            } else {
                echo "修改购物车商品数量失败，请重试！";
            }
        } elseif (strcmp($action, 'modify') == 0) {
            if ($login->database_model->update_row($product_type, array('count'=>$product_num_in_cart), array('user'=>$user, 'code'=>$product_code))) {
                echo "修改购物车商品数量成功！";
            } else {
                echo "修改购物车商品数量失败，请重试！";
            }
        } elseif (strcmp($action, 'increase') == 0) {
            if ($login->database_model->update_row($product_type, array('count'=>$product_num_in_cart), array('user'=>$user, 'code'=>$product_code))) {
                echo "修改购物车商品数量成功！";
            } else {
                echo "修改购物车商品数量失败，请重试！";
            }
        }
    }

    public function modify() {
        $login = $this->login();
        $user_data = $login->check_token_exists();
        if (count($user_data) > 0) {
            $var['user'] = $user = $user_data['user'];
            $var['user_detail'] = $user_data;
            $login->refresh_token_timeout($user_data['token'], 1800, '/');
        } else {
            $login->index();
            return;
        }
        $update_data = array();
        foreach ($_POST as $key => $value) {
            if (trim($value) != '') {
                $update_data[$key] = $value;
            }
        }

        if ($login->database_model->update_row('user', $update_data, array('user'=>$update_data['user']))) {
            echo "修改用户信息成功！";
        } else {
            echo "修改用户信息失败，请重试！";
        }
    }
    
}
