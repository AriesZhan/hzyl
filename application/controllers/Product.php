<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
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

    public function main($product_type)
	{
        $var['product_type_map'] = self::PRODUCT_TYPE_MAP;
        $this->load->helper('url');
        $this->load->model('database_model');
        
        $var['product_type_en'] = $product_type;
        $var['product_type_cn'] = $var['product_type_map'][$product_type];
        $var['product_data'] = $this->database_model->get_items_all($product_type);
        if (count($var['product_data']) > 0) {
            foreach ($var['product_data'] as $index => $row_data) {
                $pics_array = explode(',', $row_data->pics);
                $videos_array = explode(',', $row_data->videos);
                $row_data->pics = $pics_array;
                $row_data->videos = $videos_array;
                $var['product_data'][$index] = $row_data;
            }

            $this->load->view('Product_view', $var);
        }
	}
    
	public function manage($product_type)
	{
        $var['product_type_map'] = self::PRODUCT_TYPE_MAP;
        $this->load->helper('url');
        $var['product_type_en'] = $product_type;
        $var['product_type_cn'] = $var['product_type_map'][$product_type];
        $var['error'] = null;
        $var['user'] = null;
        
        $login = $this->login();
        $user_data = $login->check_token_exists();
        if (count($user_data) > 0) {
            $var['user'] = $user_data['user'];
            $var['user_detail'] = $user_data;
            $login->refresh_token_timeout($user_data['token'], 1800, '/');
        }
        if (count($user_data) > 0 and $user_data['tag'] == 'admin' and $user_data['authority'] == 31) {
            $var['product_data'] = $login->database_model->get_items_all($product_type);
            if (count($var['product_data']) > 0) {
                foreach ($var['product_data'] as $index => $row_data) {
                    $pics_array = explode(',', $row_data->pics);
                    $videos_array = explode(',', $row_data->videos);
                    $row_data->pics = $pics_array;
                    $row_data->videos = $videos_array;
                    $var['product_data'][$index] = $row_data;
                }

                $this->load->view('Product_manage_view', $var);
            }
        } else {
            $var['error'] = "您没有足够的权限访问该页面，请联系网站管理员。";
            $this->load->view('User_nav_view', $var);
            $this->load->view('Main_view', $var);
        }
	}
    
    public function modify_submit($product_type, $product_id) {
        $this->load->helper('url');
        $this->load->model('database_model');
        
        $table = $product_type;
        $update_data = $_POST;
        if ($this->database_model->update_row($table, $update_data, array('id'=>$product_id))) {
            echo "编码".$update_data['code']."的产品更新数据库成功！";
        }
    }
    
    public function delete($product_type, $product_code) {
        $this->load->helper('url');
        $this->load->model('database_model');
        $table = $product_type;
        
        $data = $this->database_model->get_items_with_condition($table, "code='$product_code'");
        $media_array = array();
        
        if (count($data) > 0) {
            foreach (explode(',', $data[0]->pics) as $media) {
                $media_array[] = $media;
            }
            foreach (explode(',', $data[0]->videos) as $media) {
                $media_array[] = $media;
            }
        }
        
        if ($this->database_model->delete_row($table, array('code'=>$product_code))) {
            echo "删除产品".$product_code."的数据库信息成功！";
            foreach ($media_array as $media_name) {
                $path = "upload/$product_type/$media_name";
                if (unlink($path)) {
                    echo "图片".$media_name."删除成功！";
                } else {
                    echo "图片".$media_name."删除失败！";
                }
            }
        } else {
            echo "删除产品".$product_code."的数据库信息失败，请检查！";
        }
        
    }
    
    public function add()
	{
		$this->load->helper('url');
        $var['product_type_map'] = self::PRODUCT_TYPE_MAP;
        
		$this->load->view('Add_product_view', $var);
	}
    
    public function submit()
	{
		$this->load->helper('url');
        $this->load->model('database_model');
        $var['files'] = $_FILES;
        $var['post'] = $_POST;
        $var['uploaded_list'] = array();
        $product_type = $_POST['product_type'];
        $product_code = $_POST['product_code'];
        $product_data = array();
        $picture_list = array();
        $video_list = array();
        $time = new DateTime();
        $timef = $time->format('YmdHis');
        
        if ($_FILES['product_pictures']['tmp_name'][0]) {
            foreach ($_FILES['product_pictures']['tmp_name'] as $index => $tmp_name) {
                $new_file_name = "$product_type-pn$product_code-$timef-$index.jpeg";
                $path = "upload/$product_type/$product_type-pn$product_code-$timef-$index.jpeg";
                if (move_uploaded_file($tmp_name, $path)) {
                    echo "File $new_file_name is valid, and was successfully uploaded.<br />";
                    array_push($var['uploaded_list'], $_FILES['product_pictures']['name'][$index]);
                    array_push($picture_list, $new_file_name);
                } else {
                    echo "Possible file upload attack!\n";
                }
            }
        }
        if ($_FILES['product_videos']['tmp_name'][0]) {
            foreach ($_FILES['product_videos']['tmp_name'] as $index => $tmp_name) {
                $new_file_name = "$product_type-pn$product_code-$timef-$index.mp4";
                $path = "upload/$product_type/$product_type-pn$product_code-$timef-$index.mp4";
                if (move_uploaded_file($tmp_name, $path)) {
                    echo "File $new_file_name is valid, and was successfully uploaded.\n";
                    array_push($var['uploaded_list'], $_FILES['product_videos']['name'][$index]);
                    array_push($video_list, $new_file_name);
                } else {
                    echo "Possible file upload attack!\n";
                }
            }
        }
        $picture_str = join(',', $picture_list);
        $video_str = join(',', $video_list);
        
        $product_data += ['type' => $product_type, 'code' => $product_code, 'name' => $_POST['product_title'], 'description' => $_POST['product_description'], 'pics' => $picture_str, 'videos' => $video_str];
        $var['product_data'] = $product_data;
        
        $this->database_model->insert_row($product_type, $product_data);
        
		$this->load->view('Submit_view', $var);
	}
    
    public function search($manage) {
        $this->load->helper('url');
        $var['error'] = null;
        $login = $this->login();
        $user_data = $login->check_token_exists();
        if (count($user_data) > 0) {
            $var['user'] = $user_data['user'];
            $var['user_detail'] = $user_data;
            $login->refresh_token_timeout($user_data['token'], 1800, '/');
        }
        $var['product_type_map'] = self::PRODUCT_TYPE_MAP;
        
        $var['post'] = $_POST;
        $var['product_type_en'] = 'search_results';
        $var['product_type_cn'] = "搜索结果";
        if (key_exists('search_pattern', $_POST) and $_POST['search_pattern'] != '') {
            $var['search_pattern'] = $_POST['search_pattern'];
        } else {
            return;
        }
        $var['product_data'] = array();
        $fields = 'type, name, code, description';
        $regexp_str = str_replace('\s+', '|', $var['search_pattern']);
        
        foreach (array_keys($var['product_type_map']) as $table) {
            $data = $login->database_model->search_items_with_regexp($table, $fields, $regexp_str);
            if (count($data) > 0) {
                foreach ($data as $index => $row) {
                    $pics_array = explode(',', $row->pics);
                    $videos_array = explode(',', $row->videos);
                    $row->pics = $pics_array;
                    $row->videos = $videos_array;
                    array_push($var['product_data'], $row);
                }
            }
        }

        if (strcmp($manage, 'mng') == 0 and count($user_data) > 0 and $user_data['tag'] == 'admin' and $user_data['authority'] == 31) {
            $this->load->view('Product_manage_view', $var);
        } elseif (strcmp($manage, 'ls') == 0) {
            $this->load->view('Product_view', $var);
        } else {
            $var['error'] = "您没有足够的权限访问该页面，请联系网站管理员。";
            $this->load->view('Product_view', $var);
        }
    }
    
    public function get_media($type, $media_name) {
        $this->load->helper('url');
        $new_file_name = base_url("upload/$type/$media_name");
        header('Content-Disposition: inline; filename="' . $new_file_name . '"');
        header('Content-type: image/png');
        readfile($new_file_name);
        $this->autoRender == false;
        #echo "<img src='$new_file_name' />";
    }
    
    
    public function get_icon($media_name) {
        $this->load->helper('url');
        $icon_name = base_url("upload/icons/$media_name");
        header('Content-Disposition: inline; filename="' . $icon_name . '"');
        header('Content-type: image/png');
        readfile($icon_name);
        $this->autoRender == false;
        #echo "<img src='$new_file_name' />";
    }
    
    public function upload_files() {
        $this->load->helper('url');
        $this->load->model('database_model');
        
        $table = $product_type = $_POST['type'];
        $product_code = $_POST['code'];
        $file_name = $_FILES['file']['name'];
        $file_type = explode('/', $_FILES['file']['type'])[0];
        $file_suffix = explode('/', $_FILES['file']['type'])[1];
        $tmp_name = $_FILES['file']['tmp_name'];
        //echo "$file_type, $file_suffix ";
        //print_r($_FILES);
        
        $update_data = array();
        $row = $this->database_model->get_items_with_condition($table, "code='$product_code'")[0];
        $time = new DateTime();
        $timef = $time->format('YmdHis');
        $new_file_name = "$product_type-pn$product_code-$timef.$file_suffix";
        $path = "upload/$product_type/$new_file_name";
        
        if (strcmp($file_type, 'image') == 0) {
            $update_data['pics'] = $row->pics . ',' . $new_file_name;
        } elseif (strcmp($file_type, 'video') == 0) {
            $update_data['videos'] = $row->videos . ',' . $new_file_name;
        }
        
        if (move_uploaded_file($tmp_name, $path)) {
            echo "File $new_file_name is valid, and was successfully uploaded.";
            if ($this->database_model->update_row($table, $update_data, array('code'=>$product_code))) {
                echo "编码".$product_code."的产品更新数据库成功！";
            } else {
                echo "编码".$product_code."的产品更新数据库失败！";
            }
        } else {
            echo "Possible file upload attack!";
        }
    }
    
    public function remove_files($media_name) {
        $this->load->helper('url');
        $this->load->model('database_model');
        
        
        $type = str_replace('pn', '', explode('-', $media_name)[0]);
        $product_code = str_replace('pn', '', explode('-', $media_name)[1]);
        $update_data = array();
        if (preg_match('/.jpeg|.gif|.png/', $media_name, $matches)) {
            $result = $this->database_model->search_items_with_regexp($type, 'pics', $media_name)[0];
            $update_data['pics'] = str_replace($media_name, '', $result->pics);
            $update_data['pics'] = str_replace(',,', ',', $update_data['pics']);
            $update_data['pics'] = trim($update_data['pics'], ',');
        } elseif (preg_match('/.mp4/', $media_name, $matches)) {
            $result = $this->database_model->search_items_with_regexp($type, 'videos', $media_name)[0];
            $update_data['videos'] = str_replace($media_name, '', $result->videos);
            $update_data['videos'] = str_replace(',,', ',', $update_data['videos']);
            $update_data['videos'] = trim($update_data['videos'], ',');
        }
        
        if ($this->database_model->update_row($type, $update_data, array('code'=>$product_code))) {
            echo "编码".$product_code."的产品更新数据库成功！";
            $path = "upload/$type/$media_name";
            if (unlink($path)) {
                echo "编码".$product_code."的产品删除图片成功！";
            } else {
                echo "编码".$product_code."的产品删除图片失败！";
            }
        } else {
            echo "编码".$product_code."的产品更新数据库失败！";
        }
    }
}
