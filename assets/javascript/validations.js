function validName(name) {            ////////////////////////////////name
  const pattern=/^([a-zA-Z ]){2,30}$/;

  if (name.trim() == "") {
    $(".name_valid").show();
    $(".name_valid").text("Enter name").css("color", "red");
    return false;
    
  }
  else if(pattern.test(name.trim())==false){

    $(".name_valid").show();
    $(".name_valid").text("Enter valid name").css("color", "red");
    return false;
    
  }
  else{
    
    $(".name_valid").hide();
    return true;
    }
}
 $('.zee').hide()
        $('.img').on('click',function(){
            $('.zee').toggle()
        })

        $('.zee').on('click',function(){
            $.ajax({
            url:base_url + "/logout",
            type:"POST",
            success:function(data){
                if(data==1){
                    window.location.href=base_url + "login"
                }
                else{
                    window.location.href=base_url;
                }
            }
            })
        })

function validPass(password) {
    const value = password.trim();
    const regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-+.])[a-zA-Z0-9!@#$%^&*()\-.+]{8,20}$/;

    if (value === "") {
        $(".pass_valid")
            .show()
            .text("Password is required")
            .css("color", "red");
        return false;
    }

    if (value.length < 8 || value.length > 20) {
        $(".pass_valid")
            .show()
            .text("Password must be 8–20 characters long")
            .css("color", "red");
        return false;
    }

    if (!regex.test(value)) {
        $(".pass_valid")
            .show()
            .html("Password must include:<br>• 1 uppercase<br>• 1 lowercase<br>• 1 number<br>• 1 special character")
            .css("color", "red");
        return false;
    }

    $(".pass_valid").hide()

    return true;
}

function validNumber(number){                          ///////////////////////number
  var phoneno = /[0-9]{10,10}$/;

  if (number.trim() == "") {
    $(".number_valid").show();
    $(".number_valid").text("Enter Number").css("color", "red");
    return false;
}else if(phoneno.test(number.trim())==false){
  $(".number_valid").show();
    $(".number_valid").text("Enter Valid Number").css("color", "red");
  return false;
}
else if(number.trim().length !==10){
 $(".number_valid").show();
    $(".number_valid").text("Enter 10 Digit number").css("color", "red");
  return false;
}
else{
    $(".number_valid").hide();
    return true;
  }

}

function validEmail(email){                          //////////////////email
 const regex = /^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/;
 if(email.trim()==''){
    $(".email_valid").show();
    $(".email_valid").text("Enter email").css("color", "red");
    return false
 }else if(regex.test(email.trim())==false){
    $(".email_valid").show();
    $(".email_valid").text("Enter valid email").css("color", "red");
return false
  }
  else if(email.trim().length>50 ){
    $(".email_valid").show();
    $(".email_valid").text("Enter 50 letter email").css("color", "red");
return false
  }
  else{
    $(".email_valid").hide();
    return true
  }
}
function validAddress(address)
{
  if (address.trim() == "") {
    $(".address_valid").show();
    $(".address_valid").text("enter address").css("color", "red");
  return false    
  }
  else if(address.trim().length<2 || address.trim().length>50 ){
$(".address_valid").show();
    $(".address_valid").text("enter address between 2-50 letters ").css("color", "red");
  return false    

  }
  else{
    
    $(".address_valid").hide();
    return true
  }
}
function validPincode(pincode){
  if (pincode.trim() == "") {
    $(".pincode_valid").show();
    $(".pincode_valid").text("enter pincode").css("color", "red");
    return false
  }
  else if (pincode.trim() < 100000 || pincode.trim() 
    > 999909) {
    $(".pincode_valid").show();
    $(".pincode_valid").text("Pincode Mush Have 6 digits").css("color", "red");
    return false
  }
  
  else{
    
    $(".pincode_valid").hide();
    return true
  }
}
function validPrice(price){
    if (price.trim() == "") {
    $(".price_valid").show();
    $(".price_valid").text("enter price").css("color", "red");
    return false
  }
  
  else if(price.trim()>99999999){
$(".price_valid").show();
    $(".price_valid").text("This Item Price Is too High").css("color", "red");
    return false
    
  }
  else if(price.trim()<1){
$(".price_valid").show();
    $(".price_valid").text("enter valid price").css("color", "red");
    return false
    
  }
  
  else{
    
    $(".price_valid").hide();
    return true
  }
}

function validDescription(des){
    if (des.trim() == "") {
    $(".des_valid").show();
    $(".des_valid").text("enter Description").css("color", "red");
    return false
  }
  
  else{
    
    $(".des_valid").hide();
    return true
  }
}

function validState(state){
  if(state.trim()==""){
    $(".state_valid").show()
    $(".state_valid").text("plese select state").css('color','red')
    return false
  }
  else if(state.trim()=="----Select State----"){
    $(".state_valid").show()
    $(".state_valid").text("plese select state").css('color','red')
    return false
  }
  else{
    $(".state_valid").hide()
    return true
    
  }
}

function validCity(city){
  if(city.trim()==""){
    $(".city_valid").show()
    $(".city_valid").text("plese select city").css('color','red')
    return false
  }
  else if(city.trim()=="----Select City----"){
    $(".city_valid").show()
    $(".city_valid").text("plese select city").css('color','red')
    return false
  }
  else{
    $(".city_valid").hide()
    return true

      }
}

$("#image").on("change", function () {

    let file = this.files[0];

    if (!file) return;

    let allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
    let maxSize = 2 * 1024 * 1024; // 2MB

    // Type check
    if (!allowedTypes.includes(file.type)) {
      $(".image_valid").show()
        $(".image_valid").text("Only JPG, JPEG, PNG allowed");
        this.value = "";
        return false;
    }

    // Size check
    if (file.size > maxSize) {
      $(".image_valid").show()
        $(".image_valid").text("Max size is 2MB");
        this.value = "";
        return false;
    }

    $(".image_valid").text(""); // clear error
});