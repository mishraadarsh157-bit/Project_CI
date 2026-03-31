<?php
defined('BASEPATH') or exit('No direct script access allowed');


class EmailController extends CI_Controller
{
     public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('crud_model_four');
    }

    public function mail()
    {
        
        $mailData = $this->input->post();

        // print_r($mailData);


        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_port'] = 587; // Port 587 is for STARTTLS
        $config['smtp_user'] = 'mishraadarsh1232@gmail.com';
        $config['smtp_pass'] = 'wncdhpwrvytadtdk'; // Replace with your Gmail App Password
        $config['smtp_crypto'] = 'tls';  // Enable STARTTLS
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['newline'] = "\r\n"; // Correct newline format
        
        // Optional debugging:
        $config['smtp_debug'] = 2; // This will give more detailed debugging output.
        


        $this->email->initialize($config);

        $this->email->from('mishraadarsh1232@gmail.com', "SANS");
        $this->email->to($mailData['clientemail']);
        


        if($mailData['invoiceNo']>0)
        {$this->load->library('fpdf');
        $id=$mailData['invoiceNo'];
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
        $total=0;
        foreach ($data as $row) {

            $this->fpdf->Cell(60, 10, $row['item_name'], 1);
            $this->fpdf->Cell(40, 10, $row['Quantity'], 1);
            $this->fpdf->Cell(40, 10, $row['price'], 1);
            $this->fpdf->Cell(40, 10, $row['price'] * $row['Quantity'], 1);
            $this->fpdf->Ln();
            $qty=$row['Quantity'];
            $price=$row['price'];
            $total +=$qty*$price;
        }
        $pdfPath = './uploads/Invoice_' . $mailData['invoiceNo'] . '.pdf';
         $this->fpdf->Cell(40, 10, '', 0);
                    $this->fpdf->Cell(60, 10, '',0);
                    $this->fpdf->Cell(40, 10, 'Balance Due :', 0);
                    $this->fpdf->Cell(40, 10, $total, 0);
        $this->fpdf->Output($pdfPath,'F');
    }

        $this->email->attach($pdfPath);

        $this->email->subject($mailData['subject']);
        $this->email->message($mailData['description']);

        if($this->email->send()){

            echo json_encode(['success'=>true]);

        }else{
            echo json_encode(['success'=>$this->email->print_debugger()]);
        }
    }



}