<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_info_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function _get_data()
	{
		$config = array(
			'hostname'	=> 'localhost',
			'database'	=> 'user_info',
		);
	
		// slave
		$this->load->database('slave');

		// SELECT * FROM user_info
		$query = $this->db->get('user_info');
		//$query = $this->db->query('select * from user_info');

		// Œ‹‰Ê‚ð”z—ñ‚ÅŽæ“¾‚·‚é
		return $query->result_array();
	}
	
	public function _set_data()
	{
		// master
		$this->load->database('master');

		$sql = 'UPDATE user_info SET update_time = now()';

		if ( $this->db->query($sql) )
		{
		}
		else
		{
			return NULL;
		}
	}

	public function _insert_data()
	{
		// master
		$this->load->database('master');

		$sql = 'INSERT INTO user_info(name,update_time) values( "saitou", now() )';

		if ( $this->db->query($sql) )
		{
		}
		else
		{
			return NULL;
		}
	}
}
