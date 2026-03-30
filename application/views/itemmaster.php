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
    <!-- <h1 class='m-5 mt-2'>Users</h1> -->
    <div class="content-div w-100 mx-2">

      <ul class="nav nav-tabs ps-5 border border-0">
        <li class="nav-item">
          <button class="allusr nav-link active" data-bs-toggle="tab" data-bs-target="#allUsers">All Items</button>
        </li>
        <li class="nav-item">
          <button class="addusr nav-link" data-bs-toggle="tab" data-bs-target="#addUser">Add Item</button>
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
            <input type="text" class="field" value="item_id" hidden>
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
                  <th class="sortable" data-column='item_id'>Sr.No ⬍</th>
                  <th class='text-center'>Action</th>
                  <th class="sortable" data-column='item_name'>Item ⬍</th>
                  <th class="sortable" >Description </th>
                  <th class="sortable" data-column='price'>Price ⬍</th>
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
                <div class="row w-100  mx-0 mt-4 pt-4 px-4 pb-5  ">
                    <input type="text" name="id" disabled id="id">
                    <div class="col-6 mb-5 mt-4">
                        Item Name  <sup class="text-danger">*</sup>:
                        <input type="text" name='name' id="name" placeholder="Item name" class='item_name form-control '>
                        <div class="name_valid"></div>
                    </div>
                    <div class="col-6 mb-5 mt-4">
                        Item Price <sup class="text-danger">*</sup>
                        <input type="tel"  min='1' name='price' id="price" placeholder="Item Price" class='form-control ' oninput="this.value = this.value < 1 ? 1 : this.value" value="1">
                        <div class="price_valid"></div>
                    </div>
                    <div class="col-12 mb-5 p-2">
                        Item Description <sup class="text-danger">*</sup>
                        <input type="text" name='description' id="description" placeholder="Item Description" class='form-control '>
                        <div class="des_valid"></div>
                    </div>
                    <div class="col-6 mb-5 p-2">
                        Item Image <sup class="text-danger">*</sup>
                        <div class='image_holder'>
                            <input type="file"  name='image' accept="image/png, image/jpeg, image/jpg" onchange="itmImg(event)" id="image" class='form-control w-75'><button class="btn border border-0 btn-outline-danger" type="button" onclick="resetImage()"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <div class="image_valid text-danger"></div>
                    </div>
                    <div class="col-6 mb-5 p-2"><img src="" name='image' alt="" height="100px" class="itemImage"></div>
                    <div class="col-9 updItm">
                        <input type="text" name='submit_item' hidden value='submititem'>
                    </div>
                    <div class="col-3 text-end ps-5 itemSaver">
                        <div class="valid_item text-danger mb-3"></div>
                        <button type="button" id="submitForm" name='' class="btn btn-outline-primary">SUBMIT</button>
                        <!-- <input type="reset" class='btn btn-outline-danger' onclick="resetImage()" value='Reset'> -->
                    </div>
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
const user_email='<?php  echo $_SESSION['email']?>';
</script>
<script src="./assets/javascript/jquery.js"></script>
<script src="./assets/javascript/validations.js"></script>
<script src="./assets/javascript/bootstrap.js"></script>
<script src="./assets/javascript/sweetAlert.js"></script>
<script src="./assets/javascript/items.js"></script>

</html>