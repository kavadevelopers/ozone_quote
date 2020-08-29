<?php
class General_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getManufacturer($id)
	{
		return $this->db->get_where('manufacturer',['df' => '','id' => $id])->row_array();
	}

	public function _getManufacturer($id)
	{
		return $this->db->get_where('manufacturer',['id' => $id])->row_array();	
	}
}
?>