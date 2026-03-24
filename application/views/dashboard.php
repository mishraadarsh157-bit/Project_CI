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