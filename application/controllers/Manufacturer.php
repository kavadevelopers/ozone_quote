<?php
class Manufacturer extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
	}

	public function index()
	{
		$data['_title']		= "Manufacturer";
		$this->load->theme('manufacturer',$data);
	}

	public function save()
	{
		$this->form_validation->set_error_delimiters('<div class="val-error">', '</div>');
		$this->form_validation->set_rules('name', 'Name','trim|required|callback_unique_name');
		if ($this->form_validation->run() == FALSE)
		{
			$data['_title']		= "Manufacturer";
			$this->load->theme('manufacturer',$data);
		}
		else
		{ 
			$data = [
				'name'		=> $this->input->post('name')
			];
			$this->db->insert('manufacturer',$data);
			$this->session->set_flashdata('msg', 'Manufacturer added');
	        redirect(base_url('manufacturer'));
		}
	}

	public function datatable()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }
        $valid_columns = array(
            0=>'id',
            1=>'name'
        );
        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }
        if($order !=null)
        {
            $this->db->order_by($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }
        $this->db->limit($length,$start);
        $this->db->where('df','');
        $tableResult = $this->db->get("manufacturer");
        $data = array();	
        foreach($tableResult->result() as $rows)
        {

            $data[]= array(
                $rows->name,
                '<a href="'.base_url('manufacturer/delete/').$rows->id.'" class="btn btn-danger btn-delete btn-mini">Delete</a>'
            );     
        }
        $total_employees = $this->totalRows();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_employees,
            "recordsFiltered" => $total_employees,
            "data" => $data
        );
        echo json_encode($output);
    }

    public function totalRows()
    {
        $query = $this->db->select("COUNT(*) as num")->get("manufacturer");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }

    public function delete($id = false)
    {
    	if($id){
    		if($this->general_model->getManufacturer($id)){

    			$this->db->where('id',$id)->update('manufacturer',['df' => 'yes']);
    			$this->session->set_flashdata('msg', 'Manufacturer deleted');
    			redirect(base_url('manufacturer'));

    		}else{
	    		redirect(base_url('manufacturer'));
	    	}
    	}else{
    		redirect(base_url('manufacturer'));
    	}
    }

    public function unique_name()
	{
		if($this->db->get_where('manufacturer',['name' => $this->input->post('name'),'df' => ''])->result_array()){
			$this->form_validation->set_message('unique_name', 'Name Already Exists');
        	return false;
		}else{
			return true;
		}
	}
}
?>