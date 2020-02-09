<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_model extends CI_Model {
    function insert_row($table, $row_data) {
        $this->load->database('default');
        if ($this->db->insert($table, $row_data)) {
            #print "insert row of product data success.";
            return 1;
        } else {
            #print "insert row of product data failed, please check.";
            return -1;
        }
    }
    
    function update_row($table, $row_data, $condition_array) {
        $this->load->database('default');
        if (count($condition_array) > 0) {
            foreach($condition_array as $key => $value) {
                $this->db->where($key, $value);
            }
        } else {
            #echo "condition of database update cmd is not correct, please check.";
            return 0;
        }
        if ($this->db->update($table, $row_data)) {
            #echo "update row of product data success.";
            return 1;
        } else {
            #echo "update row of product data failed, please check.";
            return -1;
        }
    }

    function delete_row($table, $condition_array) {
        $this->load->database('default');
        if (count($condition_array) > 0) {
            foreach($condition_array as $key => $value) {
                $this->db->where($key, $value);
            }
        } else {
            #echo "condition of database update cmd is not correct, please check.";
            return 0;
        }
        if ($this->db->delete($table)) {
            #echo "delete row of product data success.";
            return 1;
        } else {
            #echo "delete row of product data failed, please check.";
            return -1;
        }
    }
    
    function get_items_all($table) {
        $this->load->database('default');
        $product_all = $this->db->get($table);
        if ($product_all->num_rows() > 0) {
			foreach ($product_all->result() as $row) {
				$data[]=$row;
			}
			return $data;
		} else {
            return array();
        }
    }
    
	function get_items_with_condition($table, $condition_str) {
        $this->load->database('default');
        if (strlen($condition_str) < 3) {
            echo "condition of database query cmd is not correct, please check.";
            return array();
        }
		$query = $this->db->query("SELECT * FROM $table WHERE $condition_str");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[]=$row;
			}
			return $data;
		} else {
            return array();
        }
	}
    
	function search_items_with_regexp($table, $fields, $regexp_str) {
        $this->load->database('default');
        if (strlen($regexp_str) < 1) {
            echo "condition of database query cmd is not correct, please check.";
            return array();
        }
		$query = $this->db->query("SELECT * FROM $table WHERE CONCAT($fields) REGEXP '$regexp_str'");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[]=$row;
			}
			return $data;
		} else {
            return array();
        }
	}
    
    function query($query_str) {
        if (strlen($query_str) > 0) {
            return $this->db->query($query_str);
        }
    }
	
/*	function getMods($data) {
		$mods =[];
		if (count($data) > 0) {
			foreach ($data as $row) {
				$model = $row->model;
				if (array_key_exists($model, $mods)) {
					$mods[$model]['count'] ++;
				} else {
					$mods[$model]['count'] = 1;
				}
				$r = strlen($model) * rand(1,1000) % 255;
				$g = strlen($model) * rand(1,1000) % 255;
				$b = strlen($model) * rand(1,1000) % 255;
				#$rgb_num = sprintf("%02d", dechex($rgb_num));
				#$mods[$row->model]['rgb'] = "#" . $rgb_num. $rgb_num. $rgb_num;
				$mods[$model]['rgb'] = "rgba($r,$g,$b,0.5)";
			}
			ksort($mods);
			return $mods;
		}
	}

	function getRacks($data) {
		if (count($data) > 0) {
			foreach ($data as $row) {
				$row->rack = str_replace('.0', "", $row->rack);
				if (preg_match('/_/', $row->rack)) {
					$id = explode('_', $row->rack);
					$rackId = $id[0];
					$unitId = $id[1];
					$racks[$rackId][$unitId][]= $row;
				}
			}
			ksort($racks);
			return $racks;
		}
	}
*/

}
