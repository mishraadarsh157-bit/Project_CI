$(document).on('click','.login-btn',function(){
    let email=$('#email').val()??"";
    if(email.trim()==""){
        $('.email_valid').text("Enter Email")
        return false
    }
    else{
        $('.email_valid').hide()

    }
    let password=$('#password').val()??"";
    if(password.trim()==""){
        $('.pass_valid').text("Enter Password")
        return false
        
    }
    let fd=new FormData(loginForm);

    $.ajax({
        url:base_url+'logged_in',
        type:"POST",
        data:fd,
        success:function(data){
            
            if(data.trim()=='success'){
                window.location.href=base_url+'/dashboard'
            }
            else if(data.trim()=="invalid"){
                $('.pass_valid').text('Enter Valid Details')
            }            
        }

    })
})
