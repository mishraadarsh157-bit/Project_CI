<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>
<style>
    *{
        font-size: .3cm;
    }
            .edit-btn {
            border-radius: 30px;
            padding-left: 10px;
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            color: white;
            border: none;
            
        }

        .edit-btn i {
            margin-right: 8px;
        }

        .edit-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            background: linear-gradient(45deg, #43e97b, #38f9d7);
        }

</style>
<body class='bg-grey'>
    <div class="row  m-0">
        <div class="col-2 bg-white full-height  border-end border-1 border-dark"></div>
        <div class="col-10 full-height m-0 p-0">

            <div class="container-fluid bg-white border-bottom border-1 border-dark">

                <h1>Users Table</h1>
            </div>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#home">All Users</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile">Add User</button>
                </li>
            </ul>

            <div class="tab-content mt-2  m-5">
                <div class="tab-pane fade show active" id="home">
                  
                </div>
                <div class="tab-pane fade" id="profile">


                    <h1>Insert data</h1>


                    <form id="myForm" novalidate>

                        <div class="row g-3">
                            <input type="text" name='id' id='id'>
                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name='name' class="form-control" id="name"
                                    minlength="3" maxlength="20"
                                    pattern="[A-Za-z ]+"
                                    required oninput="validateName()">
                                <div class="invalid-feedback">Only letters, 3–20 characters</div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name='password' class="form-control" id="password"
                                    minlength="6" maxlength="12"
                                    required oninput="validatePassword()">
                                <div class="invalid-feedback">6–12 characters required</div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name='email' class="form-control" id="email"
                                    required oninput="validateEmail()">
                                <div class="invalid-feedback">Enter valid email</div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="tel" name='phone' class="form-control" id="phone"
                                    pattern="[0-9]{10}" maxlength="10"
                                    required oninput="validatePhone(),
                       this.value = this.value.replace(/[^0-9]/g, '')">
                                <div class="invalid-feedback">Enter 10 digit number</div>
                            </div>

                        </div>

                        <button type="submit" name='submit' class="btn btn-primary mt-3" id="submitForm">Submit</button>
                        <button type="reset" class="btn btn-danger mt-3">Reset</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="./assets/javascript/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./assets/javascript/validations.js"></script>

<script>
    var base_url = "<?php echo base_url(); ?>";
</script>
<script src="./assets/javascript/script.js"></script>

</html>