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
			if (!!$id) {
				$this->load->view('lab_page');
			} else {
				$this->load->view('header', $data);
				$this->load->view('lab_table', $data);
			}
		}
	}

	public function ongoing($id)
	{
		if(!$this->session->id) {
			redirect('user/login');
		} else {
			$data['student_id']=$this->session->studentid;
			$this->load->model('lab_model');
			$data['detail']=$this->lab_model->labdetail($id);
			
			$this->load->view('lab_page', $data);
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

	public function upload_report($id){
		if($this->session->id){
			$type=$_FILES["file"]["type"];

			move_uploaded_file($_FILES["file"]["tmp_name"],"./public/labreport/".$id);
			echo "<script>alert('success');window.location.href='".base_url('lab/finished')."'</script>";

		}
	}

	public function toreserve(){
		if($this->session->id){
			$id = $this->session->id;
			$this->load->model('lab_model');
			$time = $_POST['time'];

			$date = $_POST['date'];
			$labid = $_POST['lab'];
			// echo $labid;
			// echo date("Y-m-d h:i:sa", strtotime($date)+$time*3600);
			if($this->lab_model->toreserve(date("Y-m-d H:i:s", strtotime($date)+$time*3600),$id,$labid)){
				// var_dump($time);
				// var_dump($date);
				// var_dump(date("Y-m-d h:i:sa", strtotime($date)+intval($time)*3600));
				redirect('lab/reserved');
			} else {
				$temp = base_url("lab/all");
				echo "<script>alert('该时间段已有人预约');window.location.href='".$temp."'</script>";
			}
		}
	}

}
