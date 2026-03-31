<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Invoice extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('crud_model_four');
        $user = $this->session->userdata('user_id');
        if (!$user) {
            redirect(base_url('/login'));
        }
    }
    public function index()
    {
        $this->load->view('invoice');
    }
    public function fetch()
    {
        $search = $_POST['search'] ?? "";
        $field = $_POST['field'] ?? "Invoice_No";
        $order = $_POST['order'] ?? "asc";
        $limit = $_POST['limit'] ?? 20;
        $offset = $_POST['offset'] ?? 0;
        // $search,$field,$order,$limit,$offset
        $data['data'] = $this->crud_model_four->getAll('invoice', 'client', 'items',  $search, $field, $order, $limit, $offset);
        $data['pages'] = $this->crud_model_four->getAll('invoice', 'client', 'items', $search, $field, $order, 100, 0);


        echo json_encode($data);
    }
    public function invoiceClient($client)
    {
        $data = $this->crud_model_four->data('client', 'client_name', $client);
        $name = array_column($data, 'client_name');
        echo json_encode($name);
    }

    public function invoiceClientdata($client)
    {
        $data['data'] = $this->crud_model_four->data('client', 'client_name', $client);
        echo json_encode($data);
    }

 public function invoiceItem()
    {   
    $item=$_POST['itemSearch']??"";
    $data=$this->crud_model_four->itemName($item);
    $name=array_column($data,'item_name');
        echo json_encode($name);
    }
    public function invoiceItemdata(){
        $name = $this->input->post('item_name');

        $data = $this->crud_model_four->itemData($name);

        echo json_encode($data);
    }

    public function invNo(){
        $data=$this->crud_model_four->generateNo();
        echo json_encode($data);
    }

    public function insert(){

     $invoiceNo = $this->input->post('invoiceNo');
        $client    = $this->input->post('cli_id');

        $items     = $this->input->post('itm_id');
              // array
        $quantity  = $this->input->post('quantity');   // array
        
        $data = [
            'InvoiceNo' => $invoiceNo,
            'ClientABN'     => $client,
            'InvDate' => date('Y-m-d H:i:s')
        ];

        $result = $this->crud_model_four->insertInvoice($data,$items,$quantity);

        if($result)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    public function updateform($id){
    $data=$this->crud_model_four->updForm($id);
    echo json_encode($data);

    }

    public function update($id){
    
        $items     = $this->input->post('itm_id')??"";
        if(trim($items)==""){
            echo "Please Enter Items";
            return false;
        }        // array
        $quantity  = $this->input->post('quantity')??""; 
        if(trim($quantity)==""){
           echo "Please Enter Quantity";
           return false;
       }
        $result = $this->crud_model_four->UpdateInvoice($id,$items,$quantity);

        if($result)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    public function generateMail($id){
    $data=$this->crud_model_four->mailForm($id);
    echo json_encode($data);

    }

   
}
    
    // $autoload['helper'] = array('url' , 'form' , 'cookie');
    // $autoload['libraries'] = array('database' , 'session');