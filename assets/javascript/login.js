$(document).on('click','.login-btn',function(){
    let email=$('#email').val()??"";
    if(email.trim()==""){
        return
    }
    let password=$('#password').val()??"";
    if(password.trim()==""){
        return
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
        }

    })
})