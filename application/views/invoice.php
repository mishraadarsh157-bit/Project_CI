<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php $this->load->view('include/cssLinks') ?>
</head>
<style>
  body {
    background: #f5f6f8;
    font-family: 'Segoe UI', sans-serif;
  }
</style>

<body class='bg-light'>
  <?php $this->load->view('include/navbar') ?>
  <?php $this->load->view('include/sidebar') ?>
  <div class="content-area pt-3 pe-3">
    <div class="content-div w-100 mx-2">

      <ul class="nav nav-tabs ps-5 border border-0">
        <li class="nav-item">
          <button class="allusr nav-link active" id="all" data-bs-toggle="tab" data-bs-target="#allUsers">All Invoices</button>
        </li>
        <li class="nav-item">
          <button class="addusr nav-link" id="add" data-bs-toggle="tab" data-bs-target="#addUser"  onclick="loadInvoice()">Add Invoice</button>
        </li>
      </ul>

      <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="allUsers">
          <div class="search_box d-flex mb-3 ">
            <div class="search_holder">
              <input type="text" class="search" name='search' onchange="search()">
              <button type="button" class='search_icon' onclick="search()"><i class="bi bi-search"></i></button>
              <button type="reset" ></button>
            </div>
            <input type="number" id="invis" value="1" hidden>
            <input type="text" class="field" value="InvoiceNo" hidden>
            <input type="text" class="order" value="desc" hidden>
            
            <nav class='page' aria-label="Page navigation example"></nav>
            <select name="" id="" class="limit" onchange="limit()">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
            </select>
            
          </div>
          <div class="table-data w-100 border ">
            <table class='table mb-5 table-light  table-striped table-hover '>
              <thead>
                <tr class="box-shadow">
                  <th class="sortable" data-column='InvoiceNo'>Sr.No ⬍</th>
                  <th class='text-center'>Action</th>
                  <th class='text-center sortable' data-column='InvoiceNo'>Invoice No ⬍</th>
                  <th class="sortable" data-column='client_name'>Client Name ⬍</th>
                  <th class="sortable" data-column='client_email'>Email ⬍</th>
                  <th class="sortable" data-column='phone'>Phone ⬍</th>
                </tr>
              </thead>
              <tbody class="load_data">

                </tbody>
                
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="addUser">
            
            <div class="form-area p-3 bg-white " style="overflow-y: auto;">






              
            <form class="addInvoice" id="myForm">

        <div class="invoice_form w-100 ms-1 row bg-white mt-3 px-3">
          <div class="col-9">
            <h1 class='add_inv pt-3'>Add Invoice</h1>
          </div>
          <div class="col-3 pt-3" align='right'><button type="button" class="btn btn-outline-primary" onclick="addMore()">Add More</button></div>
          <hr>
          <!-- invoice id  -->
          <div class="col-12">
            <input type="number" readonly name="invoiceNo" class='invoice_id bg-white form-control w-25'>
          </div>
          <!-- invoice date  -->
          <!-- client part -->

          <div class="col-4 mt-4">Client Name <sup class="text-danger">*</sup><input type="text" id='automplete-1' onchange="fetchClientData()" class="client-name-invoice form-control bg-white " placeholder="Client Name">
          <div class="clientselect"></div>
            <div class="invalidclint text-danger"></div>
          </div>
          <div class="col-4 mt-4">Client Email<input type="text" disabled class="client-email-invoice bg-white form-control  " placeholder="Client Email"></div>
          <div class="col-4 mt-4">Client Phone
            <input type="text" hidden name='cli_id' name='client_id' class='cli_Id'>
            <input disabled type="text" class="client-phone-invoice bg-white form-control  " placeholder="Client Phone">
          </div>

          <table class="w-100 itemTable mt-5">

          </table>
          <div class="loadmoreForm"></div>
          <div class="insertall text-danger mb-3 col-6"></div>
          <div class="quantityall text-danger mb-3 col-6"></div>
          <div class="col-7"></div>
          <div class="loadButtons col-5 mt-4" align="right">Total Amount<input type="text" disabled class="total-amount-invoice form-control bg-white mb-4" placeholder="Total Amount">
            <button onclick="addInvoic()" class="btn btn-outline-primary mb-4" type="button">Save Invoice</button><button type="reset" onclick="loadInvoice()" class="btn btn-outline-danger ms-3 mb-4">Clear Form</button>
          </div>


        </div>
      </form>

          </div>
        </div>
      </div>
      
    </div>
  </div>









<div class="modal fade" id="sendMailModal" data-bs-modal='false' tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title">Send Invoice Mail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <form id="mailForm">

          <!-- Invoice No -->
          <div class="mb-3">
            <label class="form-label">Invoice No</label>
            <input type="text" name="invoiceNo" id="Invn" class="form-control" required>
          </div>

          <!-- Name -->
          <div class="mb-3">
            <label class="form-label">Client Name</label>
            <input type="text" name="client_name"  id="client_no" class="form-control"
                   required minlength="3" pattern="[A-Za-z ]+">
          </div>

          <!-- Client Gmail -->
          <div class="mb-3">
            <label class="form-label">Client Email</label>
            <input type="email" name="clientemail" id="client_email" class="form-control" required>
          </div>

          <!-- Subject -->
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
          </div>

          <!-- Description -->
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" id="des"  class="form-control" rows="3" required></textarea>
          </div>

        </div>
        
        <!-- Footer -->
        <div class="modal-footer">
          <button type="close button"  class="btn btn-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="button" id="sendMail" class="btn btn-primary">
            Send Mail
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="pdfModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Invoice Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-0">
        <iframe id="pdfFrame"
                width="100%"
                height="600"
                style="border:none;">
        </iframe>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">
          Close
        </button>
      </div>

    </div>
  </div>
</div>

</body>
<script>
  const base_url = '<?php echo base_url(); ?>';
const user_email='<?php  echo $_SESSION['email']?>';
</script>
<script src="./assets/javascript/jquery.js"></script>
 <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="./assets/javascript/validations.js"></script>
<script src="./assets/javascript/bootstrap.js"></script>
<script src="./assets/javascript/sweetAlert.js"></script>
<script src="./assets/javascript/invoice.js"></script>

</html>