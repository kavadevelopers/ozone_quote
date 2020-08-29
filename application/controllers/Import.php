<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
	}


	public function index()
	{
		$data['_title']		= "Import Products";
		$this->load->theme('import',$data);
	}

	public function getManufacturer()
	{
		$this->db->select('*');
	    $this->db->where("name like '%".$this->input->post('searchTerm')."%' ");
	    $fetched_records = $this->db->get('manufacturer');
	    $users = $fetched_records->result_array();
		$data = array();
		foreach($users as $user){
			$data[] = array("id"=>$user['id'], "text"=>$user['name']);
		}
	    echo json_encode($data);
	}

	public function read()
	{
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$spreadsheet = $reader->load($_FILES['file']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$totalRows = count($sheetData) - 4;
			unset($sheetData[0]);
			

			if($totalRows > 0){

				foreach ($sheetData as $key => $value) {

					$find = $this->db->get_where('products',['manufacturer' => $this->input->post('manufacturer'),'part_no' => $this->getData($value[4])]);

					if($find->num_rows() > 0){
						
						$updateData = [
							'price'						=> $this->getPricing($value[7]),
							'discount'					=> $this->getPricing($value[8]),
							'update_date'				=> $this->getUpdateDate($value[22])
						];

						$this->db->where('id' ,$find->row_array()['id'])->update('products',$updateData);

					}else{
						$insertData = [
							'manufacturer'				=> $this->input->post('manufacturer'),
							'manu_name'					=> $this->general_model->_getManufacturer($this->input->post('manufacturer'))['name'],
							'brand'						=> $this->getData($value[0]),
							'main_class'				=> $this->getData($value[1]),
							'sub_class'					=> $this->getData($value[2]),
							'group'						=> $this->getData($value[3]),
							'part_no'					=> $this->getData($value[4]),
							'description'				=> $this->getData($value[5]),
							'gross_prod'				=> $this->getData($value[6]),
							'price'						=> $this->getPricing($value[7]),
							'discount'					=> $this->getPricing($value[8]),
							'hs_code'					=> $this->getData($value[9]),
							'country'					=> $this->getData($value[10]),
							'moq'						=> $this->getData($value[11]),
							's_or_qty'					=> $this->getData($value[12]),
							'warranty'					=> $this->getData($value[13]),
							'gross_weight'				=> $this->getData($value[14]),
							'net_weight'				=> $this->getData($value[15]),
							'length'					=> $this->getData($value[16]),
							'width'						=> $this->getData($value[17]),
							'height'					=> $this->getData($value[18]),
							'unit_of_dimention'			=> $this->getData($value[19]),
							'volume'					=> $this->getData($value[20]),
							'volume_unit'				=> $this->getData($value[21]),
							'update_date'				=> $this->getUpdateDate($value[22])
						];

						$this->db->insert('products',$insertData);
					}
				}

				$this->session->set_flashdata('msg', 'Excel File Imported');
	        	redirect(base_url('import'));	

			}else{
				$this->session->set_flashdata('error', 'No Data Found in this file.');
	        	redirect(base_url('import'));	
			}


		}else{
			$this->session->set_flashdata('error', 'File Not Found.');
	        redirect(base_url('import'));
		}
	}

	public function getData($str)
	{
		return trim($str);
	}

	public function getUpdateDate($str)
	{
		if($str == ""){
			return date('Y-m-d');
		}else{
			return date('Y-m-d' ,strtotime($str));
		}
	}

	public function getPricing($str)
	{
		if($str == ""){
			return "0.00";
		}else{
			return $str;
		}
	}
}