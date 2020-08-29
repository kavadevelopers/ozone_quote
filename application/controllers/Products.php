<?php
class Products extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
	}

	public function index()
	{
		$data['_title']		= "Products";
		$this->load->theme('products',$data);
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
            1=>'manu_name',
            2=>'part_no',
            3=>'description',
            4=>'price',
            5=>'discount',
            6=>'update_date'
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
        $tableResult = $this->db->get("products");
        $data = array();	
        foreach($tableResult->result() as $rows)
        {

            $data[]= array(
                $rows->manu_name,
                $rows->part_no,
                $rows->description,
                $rows->price,
                $rows->discount,
                $rows->update_date
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
        $query = $this->db->select("COUNT(*) as num")->get("products");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }
}