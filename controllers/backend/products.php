<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct()
    {
	//$this: memanggil variabel global
        parent::__construct();   
        $this->load->model('Products_model','datamodel');
	
		//$this->load->library('table');
		$this->load->library('pagination');
    }
	   
	public function index()
	{
		$data['title']='List Of Products';	
		$data['array_products'] = $this->datamodel->get_products();
										//dibawah parameter 1 :nama file
		//$this->mytemplate->loadBackend('products',$data);
		    $jml = $this->db->get('products');
			//$config['first_link'] = '&lsaquo; First';
		    $config['base_url'] = base_url()."backend/products/index/";
            $config['total_rows'] = $jml->num_rows();
            $config['per_page'] = 5;
			$config['num_links'] = 2;
			$config['next_link']  = 'Next &raquo;';
			$config['full_tag_open']='<div class="pagination">';
			$config['full_tag_close']='</div>';
			$config['uri_segment']      = 4;
			$offset         = $this->uri->segment(4); 
			//$config ['use_page_numbers'] = TRUE;
			//$config['last_page'] = '';
			//$config['next_page'] = '&laquo;';
			//$config['prev_page'] = '&raquo;';

			//inissialisasi config
            $this->pagination->initialize($config);
          
            //tamppilkan data
			$data['array_products'] = $this->datamodel->load_table($config['per_page'], $offset);
			
			//buat page
			$data['halaman'] = $this->pagination->create_links();
			
			//$this->load->view->loadBackend('products',$data);
			$this->mytemplate->loadBackend('products',$data);
	}
	public function form($mode,$id='')
	{
		$data['title']=($mode=='insert')? 'Add Products' : 'Update Products';				
		$data['products'] = ($mode=='update') ? $this->datamodel->get_products_by_id($id) : '';
		$this->mytemplate->loadBackend('frmproducts',$data);	
	}

	public function process($mode,$id='')
	{
		
		if(($mode=='insert') || ($mode=='update'))
		{
			$result = ($mode=='insert') ? $this->datamodel->insert_entry() : $this->datamodel->update_entry();
		}else if(($mode=='carinama') || ($mode=='delete')){
			$result = ($mode=='carinama') ? $this->datamodel->carinama($id) : $this->datamodel->hapus($id);			
		}	
		if ($result) redirect(site_url('backend/products'),'location');
	}
	
	private function dependensi($id)
	{
		return $this->datamodel->cek_dependensi($id);
	}
	
	
	

	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

