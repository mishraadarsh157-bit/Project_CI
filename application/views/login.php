<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./assets/css/style.css">
</head>
<style>
    body {
            height: 100vh;
            display: flex;
        }
</style>
<body>

    <!-- IMAGE SECTION -->
    <div class="left-side"></div>

    <!-- LOGIN FORM -->
    <div class="right-side">
        <div class="login-container">
            <h2 class='h1'>Login</h2>

            <form id='loginForm'>
                <div class="form-group">
                    <label for='email'>Email</label>
                    <input type="email" id='email' name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for='password'>Password</label>
                    <input type="password" id='password' name="password" placeholder="Enter your password" required>
                </div>

                <button type="button" class="login-btn">Login</button>
            </form>

           
        </div>
    </div>

</body>
<script>
    const base_url='<?php echo base_url(); ?>';
   
</script>
<script src="./assets/javascript/jquery.js"></script>
<script src="./assets/javascript/login.js"></script>

</html>