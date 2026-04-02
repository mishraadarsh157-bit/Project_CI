<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf extends CI_Controller
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

    public function index() {}
    public function makePdf($id)
    {
        // echo "this is $id";
        $this->load->library('fpdf');

        $data = $this->crud_model_four->updForm($id);
        $this->fpdf->AddPage();

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->Image('./assets/images/sansoftwares-1-5.png', 60, 10, -300);
        $this->fpdf->Image('./assets/images/sansoftwares-watermark.png', 10, 50, 50);
        $this->fpdf->Ln();
        $this->fpdf->Ln();
        $this->fpdf->Ln();
        $this->fpdf->Cell(190, 50, "INVOICE", 0, 1, 'C');
        $this->fpdf->Ln();
        $row = $data[0];
        $this->fpdf->Cell(100, 10, 'San Softwares', 0);
        $this->fpdf->Cell(100, 10, $row['client_name'], 0);
        $this->fpdf->Ln();

        $this->fpdf->Cell(100, 10, 'mishraadarsh1232@gmail.com', 0);
        $this->fpdf->Cell(100, 10, $row['client_email'], 0);
        $this->fpdf->Ln();

        $this->fpdf->Cell(100, 10, 'Abcd', 0);
        $this->fpdf->Cell(40, 10, $row['address'], 0);
        $this->fpdf->Ln();

        $this->fpdf->Cell(100, 10, '8383005995', 0);
        $this->fpdf->Cell(100, 10, $row['phone'], 0);
        $this->fpdf->Ln();

        $this->fpdf->Ln(10);
        $this->fpdf->Cell(60, 10, 'Item', 1);
        $this->fpdf->Cell(40, 10, 'Qty', 1);
        $this->fpdf->Cell(40, 10, 'Price', 1);
        $this->fpdf->Cell(40, 10, 'Amount', 1);
        $this->fpdf->Ln();
        $total = 0;
        foreach ($data as $row) {

            $this->fpdf->Cell(60, 10, $row['item_name'], 1);
            $this->fpdf->Cell(40, 10, $row['Quantity'], 1);
            $this->fpdf->Cell(40, 10,"Rs. " . $row['price'], 1);
            $this->fpdf->Cell(40, 10, $row['price'] * $row['Quantity'], 1);
            $this->fpdf->Ln();
            $qty = $row['Quantity'];
            $price = $row['price'];
            $total += $qty * $price;
        }
        $this->fpdf->Cell(40, 10, '', 0);
        $this->fpdf->Cell(60, 10, '', 0);
        $this->fpdf->Cell(40, 10, 'Balance Due :', 0);
        $this->fpdf->Cell(40, 10,"Rs. " . $total, 0);
        $this->fpdf->Output();
    }
}
