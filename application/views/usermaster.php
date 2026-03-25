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
  <div class="content-area pe-3">
    <h1 class='m-5 mt-2'>Users</h1>
    <div class="content-div w-100 m-5">

      <ul class="nav nav-tabs border border-0">
        <li class="nav-item">
          <button class="allusr nav-link active" data-bs-toggle="tab" data-bs-target="#allUsers">All Users</button>
        </li>
        <li class="nav-item">
          <button class="addusr nav-link" data-bs-toggle="tab" data-bs-target="#addUser">Add User</button>
        </li>
      </ul>

      <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="allUsers">
          <div class="table-data w-100 border ">
            <table class='table mb-5 table-light table-bordered table-striped table-hover '>
              <thead>
                <tr class="box-shadow">
                  <th>Sr. No</th>
                  <th class='text-center'>Action</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody class="load_data">

              </tbody>

            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="addUser">

          <div class="form-area p-3 bg-white border">

            <form id="myForm">
              <input type="number" hidden disabled name='id' id='id'>
              <!-- Name -->
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                  required minlength="3" maxlength="50"
                  pattern="^[A-Za-z]+$"
                  oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')"
                  title="Only letters allowed, no spaces (min 3 characters)">
                <div class="name_valid text-danger"></div>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                  required maxlength="100"
                  oninput="this.value = this.value.replace(/\s/g, '')"
                  title="Enter a valid email without spaces">
                <div class="email_valid text-danger"></div>
              </div>

              <!-- Password -->
              <div class="pss mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                  required minlength="8" maxlength="20"
                  pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=!])[^\s]{8,}$"
                  oninput="this.value = this.value.replace(/\s/g, '')"
                  title="8+ chars, uppercase, lowercase, number, special char, no spaces">
                <div class="pass_valid text-danger"></div>
              </div>

              <!-- Phone -->
              <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="tel" name="phone" id="phone" class="form-control"
                  required pattern="^[0-9]{10}$"
                  maxlength="10"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                  title="Enter 10 digit phone number (no spaces)">
                <div class="number_valid text-danger"></div>
              </div>

              <!-- Submit -->
              <div class="submit_area">
                <button type="button" id="submitForm" class="btn btn-primary w-100">
                  Submit
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>


    </div>
  </div>
</body>
<script>
  const base_url = '<?php echo base_url(); ?>';
</script>
<script src="./assets/javascript/jquery.js"></script>
<script src="./assets/javascript/validations.js"></script>
<script src="./assets/javascript/bootstrap.js"></script>
<script src="./assets/javascript/sweetAlert.js"></script>
<script src="./assets/javascript/user.js"></script>

</html>