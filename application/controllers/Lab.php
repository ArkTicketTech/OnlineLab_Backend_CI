<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lab extends CI_Controller {

	public function index($id=false)
	{
		if($id) {
			$this->load->view('welcome_message');
		} else {
			$data['student_id']=$this->session->studentid;
			$data['lab_time']=null;
			$data['type']='all';
			$this->load->model('lab_model');
			$data['list']=$this->lab_model->alltables();
			$this->load->view('header', $data);
			$this->load->view('lab_table', $data);
		}
	}

	public function all()
	{
		$data['student_id']=$this->session->studentid;
		$data['lab_time']=null;
		$data['type']='all';
		$this->load->model('lab_model');
		$data['list']=$this->lab_model->alltables();
		$this->load->view('header', $data);
		$this->load->view('lab_table', $data);
	}

	public function reserved()
	{
		$data['student_id']=$this->session->studentid;
		$data['lab_time']='预约时间';
		$data['type']='reserved';
		$this->load->model('lab_model');
		$data['list']=$this->lab_model->reserved();
		$this->load->view('header', $data);
		$this->load->view('lab_table', $data);
	}

	public function finished()
	{
		$data['student_id']=$this->session->studentid;
		$data['lab_time']='预约时间';
		$data['type']='finished';
		$this->load->view('header', $data);
		$this->load->view('lab_table', $data);
	}

}
