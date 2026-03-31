$(document).ready(function(){
    dashboardData()
})

function dashboardData() {
  $.ajax({
    url: base_url + "/dashfetch",
    type: "POST",
    success: function (data) {
      data = JSON.parse(data);
      data.forEach( (value,index,arr)=> {
        $("#total_users").text(arr[0]);
        $("#total_clients").text(arr[1]);
        $("#total_items").text(arr[2]);
        $("#total_invoice").text(arr[3]);
        $("#total_active_users").text(arr[4]);
        $("#total_inactive_users").text(arr[5]);
        $("#total_active_client").text(arr[6]);
        $("#total_inactive_client").text(arr[7 ]);
      });
    },
  });
}

$(document).on("click",".User_card",function(){
  window.location.href=base_url + "usermaster";
})
$(document).on("click",".client_card",function(){
  window.location.href=base_url + "clientmaster";
})
$(document).on("click",".item_card",function(){
  window.location.href=base_url + "itemmaster";
})
$(document).on("click",".invoice_card",function(){
  window.location.href=base_url + "invoice";
})