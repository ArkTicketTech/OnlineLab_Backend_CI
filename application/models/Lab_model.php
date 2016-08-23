<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lab_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function alltables(){
		$sql = "SELECT * FROM labtables";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function reserved(){
		$sql="SELECT * FROM labs LEFT JOIN labtables ON labs.labtable_id = labtables.id WHERE labs.student_id= ?";
		$query = $this->db->query($sql, array($this->session->id));
		return $query->result_array();
	}

	public function finished(){
		$sql="SELECT * FROM labs LEFT JOIN labtables ON labs.labtable_id = labtables.id WHERE labs.student_id= ? AND labs.finished=?";
		$query = $this->db->query($sql, array($this->session->id,1));
		return $query->result_array();
	}

}
