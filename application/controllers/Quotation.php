<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Quotation extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
	}

	public function index()
	{
		$data['_title']		= "Quotation";
		$this->load->theme('quotation/index',$data);
	}

	public function add()
	{
		$data['_title']		= "Add Quotation";
		$this->load->theme('quotation/add',$data);	
	}

    public function edit($id = false)
    {
        if($id){

            $quotation = $this->db->get_where('quotation',['id' => $id])->row_array();
            if($quotation){

                $data['_title']         = "Edit Quotation";
                $data['quotation']              = $this->db->get_where('quotation',['id' => $id])->row_array();
                $data['quotation_detail']       = $this->db->order_by('id','asc')->get_where('quotation_detail',['quotation' => $data['quotation']['id']])->result_array();
                $this->load->theme('quotation/edit',$data);  

            }else{
                redirect(base_url('quotation'));
            }

        }else{
            redirect(base_url('quotation'));
        }
    }

    public function delete($id = false)
    {
        $this->db->where('id',$this->input->post('id'))->delete('quotation');
        $this->db->where('quotation',$this->input->post('id'))->delete('quotation_detail');
    }

	public function save()
	{

		$year = date('Y');
		$countQuote = $this->db->get_where('quotation',['year' => $year])->num_rows();

		$data = [
			'quote'		=> $year.'_'.($countQuote + 1),
			'name'		=> $this->input->post('client'),
			'date'		=> dd($this->input->post('date')),
			'year'		=> $year
		];
		$this->db->insert('quotation',$data);
		$quotation = $this->db->insert_id();

		foreach ($this->input->post('product') as $key => $value) {
			$data = [
				'manufacturer'		=> $this->input->post('manufacturer')[$key],
				'product'			=> $this->input->post('product')[$key],
				'price'				=> $this->input->post('price')[$key],
				'discount'			=> $this->input->post('discount')[$key],
				'margin'			=> $this->input->post('margin')[$key],
				'unit_price'		=> $this->input->post('unitPrice')[$key],
				'qty'				=> $this->input->post('qty')[$key],
				'total'				=> $this->input->post('total')[$key],
				'udate'				=> dd($this->input->post('udate')[$key]),
				'quotation'			=> $quotation
			];	
			$this->db->insert('quotation_detail',$data);
		}

		$this->session->set_flashdata('msg', 'Quotation Saved');
	    redirect(base_url('quotation'));
	}

    public function update()
    {
        $data = [
            'name'      => $this->input->post('client'),
            'date'      => dd($this->input->post('date'))
        ];
        $this->db->where('id',$this->input->post('id'))->update('quotation',$data);
        $quotation = $this->input->post('id');


        $this->db->where('quotation',$this->input->post('id'))->delete('quotation_detail');

        foreach ($this->input->post('product') as $key => $value) {
            $data = [
                'manufacturer'      => $this->input->post('manufacturer')[$key],
                'product'           => $this->input->post('product')[$key],
                'price'             => $this->input->post('price')[$key],
                'discount'          => $this->input->post('discount')[$key],
                'margin'            => $this->input->post('margin')[$key],
                'unit_price'        => $this->input->post('unitPrice')[$key],
                'qty'               => $this->input->post('qty')[$key],
                'total'             => $this->input->post('total')[$key],
                'udate'             => dd($this->input->post('udate')[$key]),
                'quotation'         => $quotation
            ];  
            $this->db->insert('quotation_detail',$data);
        }

        $this->session->set_flashdata('msg', 'Quotation Updated');
        redirect(base_url('quotation'));
    }

	public function product_autocomplete()
	{
		if($this->input->post('search')){
       		$this->db->select('*');
       		$this->db->group_start();
       		$this->db->like('part_no',$this->input->post('search'));
       		$this->db->or_like('description',$this->input->post('search'));
       		$this->db->group_end();
       		$this->db->where('manufacturer',$this->input->post('manufacturer'));
       		$records = $this->db->get('products')->result();
       		$response = [];
       		foreach($records as $row ){
          		array_push($response, 
          			array(
          				"value" 	=> $row->part_no .' | '.$row->description,
          				"label" 	=> $row->part_no .' | '.$row->description,
          				"price" 	=> $row->price,
          				'discount'	=> $row->discount,
          				'date'		=> $row->update_date,
          				'id'		=> $row->id,
          			)
          		);
       		}

     	}
		echo json_encode($response);
	}


    public function download($id = false)
    {

        $quotation = $this->db->get_where('quotation',['id' => $id])->row_array();


        $fileName = $quotation['quote'].'-'.$quotation['date'].'.xlsx'; 
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->setTitle('Quotation');
        $sheet = $spreadsheet->getActiveSheet();
        $from = "A1"; $to = "Z1";
        
        $spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold( true )->setSize(16);
        $sheet->setCellValue('A1', 'Sr No.');
        $sheet->setCellValue('B1', 'Manufacturer');
        $sheet->setCellValue('C1', 'Part No.');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Pricing');
        $sheet->setCellValue('F1', 'Qty');
        $sheet->setCellValue('G1', 'Total');

        $sheet->setCellValue('H1', 'RReup');
        $sheet->setCellValue('I1', 'Discount');
        $sheet->setCellValue('J1', 'Buying price');
        $sheet->setCellValue('K1', 'Total buying price');
        $sheet->setCellValue('L1', 'Margin');

        $sheet->setCellValue('M1', 'Product Main Class');
        $sheet->setCellValue('N1', 'Product Sub  Clasiification');
        $sheet->setCellValue('O1', 'Product Group');
        $sheet->setCellValue('P1', 'HS Code');
        $sheet->setCellValue('Q1', 'Country of Origin');
        $sheet->setCellValue('R1', 'MOQ');
        $sheet->setCellValue('S1', 'Spike order qty');
        $sheet->setCellValue('T1', 'Warrantee (months)');
        $sheet->setCellValue('U1', 'Gross Weight');
        $sheet->setCellValue('V1', 'Net Weight');
        $sheet->setCellValue('W1', 'Length');
        $sheet->setCellValue('X1', 'Width');
        $sheet->setCellValue('Y1', 'Height');
        $sheet->setCellValue('Z1', 'Unit of Dimension');
        $sheet->setCellValue('AA1', 'Volume');
        $sheet->setCellValue('AB1', 'Volume Unit');

        $details = $this->db->order_by('id','asc')->get_where('quotation_detail',['quotation' => $quotation['id']])->result_array();
        $rows = 1;
        foreach ($details as $key => $value) {
            $product = $this->db->get_where('products',['id' => $value['product']])->row_array();
            $rows++;
            $sheet->setCellValue('A'.$rows, $key + 1);
            $sheet->setCellValue('B'.$rows, $product['manu_name']);
            $sheet->setCellValue('C'.$rows, $product['part_no']);
            $sheet->setCellValue('D'.$rows, $product['description']);
            $sheet->setCellValue('E'.$rows, $value['unit_price']);
            $sheet->setCellValue('F'.$rows, $value['qty']);
            $sheet->setCellValue('G'.$rows, $value['total']);
            $sheet->setCellValue('H'.$rows, $product['price']);
            $sheet->setCellValue('I'.$rows, $value['discount']);
            $buying_price = $product['price'] - (($product['price'] * $value['discount']) / 100);
            $sheet->setCellValue('J'.$rows, $buying_price);
            $sheet->setCellValue('K'.$rows, ($buying_price * $value['qty']));
            $sheet->setCellValue('L'.$rows, $value['margin']);

            $sheet->setCellValue('M'.$rows, $product['main_class']);
            $sheet->setCellValue('N'.$rows, $product['sub_class']);
            $sheet->setCellValue('O'.$rows, $product['group']);
            $sheet->setCellValue('P'.$rows, $product['hs_code']);
            $sheet->setCellValue('Q'.$rows, $product['country']);
            $sheet->setCellValue('R'.$rows, $product['moq']);
            $sheet->setCellValue('S'.$rows, $product['s_or_qty']);
            $sheet->setCellValue('T'.$rows, $product['warranty']);
            $sheet->setCellValue('U'.$rows, $product['gross_weight']);
            $sheet->setCellValue('V'.$rows, $product['net_weight']);
            $sheet->setCellValue('W'.$rows, $product['length']);
            $sheet->setCellValue('X'.$rows, $product['width']);
            $sheet->setCellValue('Y'.$rows, $product['height']);
            $sheet->setCellValue('Z'.$rows, $product['unit_of_dimention']);
            $sheet->setCellValue('AA'.$rows, $product['volume']);
            $sheet->setCellValue('AB'.$rows, $product['volume_unit']);
        }


        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $fileName); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output'); 
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
            1=>'quote',
            2=>'name',
            3=>'date'
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
        $tableResult = $this->db->get("quotation");
        $data = array();	
        foreach($tableResult->result() as $rows)
        {

            $data[]= array(
                $rows->quote,
                $rows->name,
                $rows->date,
                '<a href="'.base_url('quotation/download/').$rows->id.'" class="btn btn-success btn-mini" title="Download" target="_blank"><i class="fa fa-download"></i></a> <a href="'.base_url('quotation/edit/').$rows->id.'" class="btn btn-primary btn-mini" title="Edit" target=""><i class="fa fa-pencil"></i></a> <button data-id="'.$rows->id.'" class="btn btn-danger btn-mini btn-delete-quote" title="Edit" target=""><i class="fa fa-trash"></i></button>'
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
        $query = $this->db->select("COUNT(*) as num")->get("quotation");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }
}
?>