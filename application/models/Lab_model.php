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

}
