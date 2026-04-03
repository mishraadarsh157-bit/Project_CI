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
    position: relative;
    height: 100vh;
    font-family: 'Segoe UI', sans-serif;
  }
</style>

<body class='bg-light'>
  <?php $this->load->view('include/navbar') ?>
  <?php $this->load->view('include/sidebar') ?>
  <div class="content-area pt-3 pe-3">
    <!-- <h1 class='m-5 mt-2'>Users</h1> -->
    <div class="content-div w-100  mx-2">

      <ul class="nav nav-tabs border ms-5 border-0">
        <li class="nav-item">
          <button class="allcli nav-link active" data-bs-toggle="tab" data-bs-target="#allUsers">All Clients</button>
        </li>
        <li class="nav-item">
          <button class="addcli nav-link" data-bs-toggle="tab" data-bs-target="#addUser" onclick="loadstates()">Add Client</button>
        </li>
      </ul>

      <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="allUsers">
          <div class="search_box d-flex mb-3 ">
            <div class="search_holder">
              <input type="text" class="search" name='search' onchange="search()">
              <button type="button" class='search_icon' onclick="search()"><i class="bi bi-search"></i></button>
            </div>
            <button type="reset" onclick="resetBTN()" class="btn"><i class="bi bi-arrow-repeat"></i></button>
            <select name="" id="" class="status" onchange="search()">
              <option value="">Status</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
            <input type="number" id="invis" value="1" hidden>
            <input type="text" class="field" value="client_id" hidden>
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
                  <th class="sortable" data-column='client_id'>Sr.No ⬍</th>
                  <th class='text-center'>Action</th>
                  <th class="sortable" data-column='client_name'>Name ⬍</th>
                  <th class="sortable" data-column='client_email'>Email ⬍</th>
                  <th class="sortable text-end" data-column='phone'>Phone ⬍</th>
                  <th>Address</th>
                  <th class="text-end">Pincode</th>
                  <th class="ps-4">Status</th>
                </tr>
              </thead>
              <tbody class="load_data">

                </tbody>
                
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="addUser">
            <form id="myForm" class="p-3">
            <div class="form-area container mx-4 row p-3 bg-white border">
              
             

  <input type="number" hidden  disabled name='id' id='id'>

  <!-- Name -->
  <div class="mb-3 col-6">
    <label class="form-label">Name  <sup class="text-danger">*</sup>:</label>
    <input type="text" name="name" id="name" class="form-control"
      required minlength="3" maxlength="30"
      pattern="^[A-Za-z ]+$"
      oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')"
      title="Only letters and spaces allowed (min 3 characters)">
    <div class="name_valid text-danger"></div>
  </div>

  <!-- Email -->
  <div class="mb-3 col-6">
    <label class="form-label">Email  <sup class="text-danger">*</sup>:</label>
    <input type="email" name="email" id="email" class="form-control"
      required maxlength="50"
      oninput="this.value = this.value.replace(/\s/g, '')"
      title="Enter a valid email without spaces">
    <div class="email_valid text-danger"></div>
  </div>

  <!-- Phone -->
  <div class="mb-3 col-6">
    <label class="form-label">Phone  <sup class="text-danger">*</sup>:</label>
    <input type="tel" name="phone" id="phone" class="form-control"
      required pattern="^[0-9]{10}$"
      maxlength="10"
      oninput="this.value = this.value.replace(/[^0-9]/g, '')"
      title="Enter 10 digit phone number (no spaces)">
    <div class="number_valid text-danger"></div>
  </div>

  <!-- Address -->
  <div class="mb-3 col-6">
    <label class="form-label">Address  <sup class="text-danger">*</sup>:</label>
    <textarea name="address" id="address" class="form-control"
      required minlength="10" maxlength="50"
      title="Enter full address (min 10 characters)"></textarea>
      <div class="address_valid"></div>
  </div>

  <!-- State -->
  <div class="mb-3 col-6">
    <label class="form-label">State  <sup class="text-danger">*</sup>:</label>
    <div class="states_area"></div>
    <div class="state_valid"></div>
  </div>

  <!-- City -->
  <div class="mb-3 col-6">
    <label class="form-label">City  <sup class="text-danger">*</sup>:</label>
   <div class="cities_area">
    <select name="" id="" class="form-select">
      <option value="">----select City----</option>
    </select>
   </div>
   <div class="city_valid"></div>
  </div>

  <!-- Pincode -->
  <div class="mb-3 col-6">
    <label class="form-label">Pincode  <sup class="text-danger">*</sup>:</label>
    <input type="text" name="pincode" id="pincode" class="form-control"
      required pattern="^[0-9]{6}$"
      maxlength="6"
      oninput="this.value = this.value.replace(/[^0-9]/g, '')"
      title="Enter 6 digit pincode">
      <div class="pincode_valid"></div>
  </div>
  <div class="mb-3 col-6 status_area">

  </div>

  <!-- Submit -->
    <div class="row">
                <div class="col-7"></div>
                   <div class="col-5 submit_area" align='right'>
                     <button type="button" id="submitForm" class="btn btn-outline-primary">
                       Submit
                      </button>
                      <button type="reset" class="reset btn btn-outline-danger">Reset</button>
                    </div>
                </div>
               

</div>
</form>
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
<script src="./assets/javascript/validations.js"></script>
<script src="./assets/javascript/bootstrap.js"></script>
<script src="./assets/javascript/sweetAlert.js"></script>
<script src="./assets/javascript/client.js"></script>

</html>