<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');
class User extends CI_Controller {

	public function index()
	{
		if($this->session->id){
			redirect('lab');
		}else{
			redirect('user/login');
		}
	}

	public function login()
	{
		if($this->session->id){
			redirect('lab');
		}else{
			$data['login_error']='';
			if($this->input->method()=='get'){
				$this->load->view('login',$data);
			}else{
				$this->load->model('user_model');
				if($res=$this->user_model->login()){
					$this->session->set_userdata($res);
					redirect('lab');
				}else{
					$data['login_error']='Error Username or Password';
					$this->load->view('login',$data);
				}
			}
		}
	}

	public function signup()
	{
			$data['login_error']='';
			if($this->input->method()=='get'){
				$this->load->view('login');
			}else{
				$this->load->model('user_model');
				if($this->user_model->signup()){
					if($res=$this->user_model->login()){
						$this->session->set_userdata($res);
						redirect('lab');
					}
				}else{
					$this->load->view('login',$data);
				}
			}
	}

	public function logout()
	{
		session_destroy();
		redirect('user/login');
	}

}
