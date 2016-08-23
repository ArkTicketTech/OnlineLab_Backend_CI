<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function login(){
		$this->form_validation->set_rules('s', 'Username', 'required|max_length[255]');
		$this->form_validation->set_rules('p', 'Password', 'required|min_length[6]|max_length[255]');
		if($this->form_validation->run()){
			$sql = "SELECT * FROM students WHERE studentid = ? AND password = password( ? ) limit 1";
			$query = $this->db->query($sql, array( $_POST['s'] , $_POST['p'] ));
			if ($query->num_rows() > 0){
				$temp = $query->result_array();
				return $temp[0];
			}
		}
		return 0;
	}

	public function signup(){
		$this->form_validation->set_rules('s', 'Studentid', 'required|max_length[255]|is_unique[students.studentid]');
		$this->form_validation->set_rules('p', 'Password', 'required|min_length[6]|max_length[255]');
		if($this->form_validation->run()){
			$sql = "INSERT INTO students (studentid, password) values (? , password( ? ));";
			$sql = $this->db->query($sql, array($_POST['s'],$_POST['p']));
			return $sql;
		}
		return FALSE;
	}

	public function signid(){
		$tmp = $_POST['s'];
		$sql = "SELECT * FROM students WHERE studentid=?";
		$query = $this->db->query($sql, $tmp);
		if ($query->num_rows() > 0){
			$temp = $query->result_array();
			return $temp[0];
		}
		return $tmp;
	}

}
