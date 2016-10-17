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
		$sql="SELECT labs.id as lab_id, labtables.id as id, student_id, labtable_id, start_time, name FROM labs LEFT JOIN labtables ON labs.labtable_id = labtables.id WHERE labs.student_id= ? AND labs.finished=?";
		$query = $this->db->query($sql, array($this->session->id,0));
		// var_dump($query->result_array());
		return $query->result_array();
	}

	public function finished(){
		$sql="SELECT labs.id as lab_id, labtables.id as id, student_id, labtable_id, start_time, name FROM labs LEFT JOIN labtables ON labs.labtable_id = labtables.id WHERE labs.student_id= ? AND labs.finished=?";
		$query = $this->db->query($sql, array($this->session->id,1));
		return $query->result_array();
	}

	public function toreserve($time, $id, $labid){

		$sql="SELECT * FROM labs WHERE start_time = ? AND labtable_id = ?";
		$sql=$this->db->query($sql, array($time, $labid));
		if (count($sql->result_array())>0)
			return false;
		$sql = "INSERT INTO labs (student_id, labtable_id, start_time) values (? , ?, ?);";
		$sql = $this->db->query($sql, array($id,$labid,$time));
		return $sql;
	}

	public function labdetail ($id) {
		$sql = "SELECT * FROM labs WHERE labs.id = ?";
		$sql = $this->db->query($sql, array($id));
		return $sql->result_array();
	}

}
