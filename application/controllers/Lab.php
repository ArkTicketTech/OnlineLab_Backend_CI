<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lab extends CI_Controller {

	public function index($id=false)
	{
		if(!$this->session->id) {
			redirect('user/login');
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
		if(!$this->session->id) {
			redirect('user/login');
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

	public function reserved()
	{
		if(!$this->session->id) {
			redirect('user/login');
		} else {
			$data['student_id']=$this->session->studentid;
			$data['lab_time']='预约时间';
			$data['type']='reserved';
			$this->load->model('lab_model');
			$data['list']=$this->lab_model->reserved();
			$this->load->view('header', $data);
			$this->load->view('lab_table', $data);
		}
	}

	public function finished()
	{
		if(!$this->session->id) {
			redirect('user/login');
		} else {
			$data['student_id']=$this->session->studentid;
			$data['lab_time']='预约时间';
			$data['type']='finished';
			$this->load->model('lab_model');
			$data['list']=$this->lab_model->finished();
			$this->load->view('header', $data);
			$this->load->view('lab_table', $data);
		}
	}

}
