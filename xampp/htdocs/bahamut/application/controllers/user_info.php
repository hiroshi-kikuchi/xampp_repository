<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_info extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_info_model');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		/* Update分の発行 */
		$this->user_info_model->_set_data();

		$this->user_info_model->_insert_data();
	
		/* 最新の情報を取得 */
		$data['user_info'] = $this->user_info_model->_get_data();
		$data['title'] = 'User info';

		$this->load->view('templates/header', $data);
		$this->load->view('user_info/index', $data);
		$this->load->view('templates/footer');
	}
}
