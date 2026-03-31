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

<body class=''>
    <?php $this->load->view('include/navbar') ?>
    <?php $this->load->view('include/sidebar') ?>

</body>
<script>
    const base_url = '<?php echo base_url(); ?>';
</script>
<script src="./assets/javascript/jquery.js"></script>
<script src="./assets/javascript/bootstrap.js"></script>

</html>
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
    .cards-holder{
        width: 100%;
        white-space: nowrap;
        overflow-x: hidden;
    }
</style>

<body class='bg-light'>
    <?php $this->load->view('include/navbar') ?>
    <?php $this->load->view('include/sidebar') ?>
    <div class="content-area p-5">
        <div class="row ">
            <div class="col-12 box-shadow user_div p-5">
                <h1>Welcome User</h1>
                <p>You Have Logged In With <span class='user_logged text-white'></span></p>
            </div>
        </div>
        <div class="d-flex cards-holder">

            <div class="col-6 ">
                <div class="d-flex pt-5">
                    <div class="User_card col-5 ms-2 hover-cards me-5 border-top border-5 box-shadow border-danger p-3">
                        <h1 class="text-danger">Total Users</h1><b id="total_users"></b>
                    </div>
                    <div class="client_card col-5 ms-3 hover-cards border-top border-5 box-shadow border-danger p-3"><h1 class="text-danger">Total Clients</h1><b id="total_clients"></b></div>
                </div>
            </div>
            <div class="col-6 ">
                <div class="d-flex pt-5">
                    <div class="item_card col-5 ms-5 me-5 hover-cards border-top border-5 box-shadow border-danger p-3">
                        <h1 class="text-danger">Total Users</h1><b id="total_items"></b>
                    </div>
                    <div class="invoice_card col-5 ms-3 hover-cards border-top border-5 box-shadow border-danger p-3"><h1 class="text-danger">Total Clients</h1><b id="total_invoice"></b></div>
                </div>
            </div>
        </div>
        </div>
    </body>
    <script src="./assets/javascript/jquery.js"></script>
    <script>
        const user_email = '<?php echo $_SESSION['email'] ?>';
</script>
<script>
    $('.user_logged').text(user_email)
</script>
<script src="./assets/javascript/validations.js"></script>
<script src="./assets/javascript/bootstrap.js"></script>
<script src="./assets/javascript/sweetAlert.js"></script>
<script src="./assets/javascript/dashboard.js"></script>

</html>