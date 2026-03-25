if (window.location.href == base_url + "usermaster") {
	$(".side-button:eq(0)").css({
		background: "black",
		color: "white",
	});
}

function fetchData() {
	let status=$('').val()??"";
	let search=$('').val()??"";
	let field=$('').val()??"id";
	let order=$('').val()??"asc";
	let limit=$('').val()??100;
	let page=$('').val()??1;
	let offset=(page-1)*limit;
	$.ajax({
		url: base_url + "/userfetch/",
		type: "POST",
		data:{
			status:status,
			search:search,
			field:field,
			order:order,
			limit:limit,
			offset:offset
		},
		success: function (data) {
			data = JSON.parse(data);
			if(data.data.length>0){

				let table = "";
				data.data.forEach(function (value, index) {
					table += "<tr>";
				table += `<td>${index + 1}</td>`;
				table += `<td class='text-center'>
				<button class="edit-btn box-shadow text-center update_form" data-uid="${value["id"]}">
				<i class="bi bi-pen-fill"></i>
				</button>         
				<button class=" delete-btn delete box-shadow text-center" id='delete' data-did="${value["id"]}">
				<i class="bi bi-trash3"></i>
				</button>         
				
                </td>`;
				table += `<td class='text-primary'><i class='update_form' data-uid='${value["id"]}'>${value["name"]}</i></td>`;
				table += `<td>${value["email"]}</td>`;
				table += `<td>${value["phone"]}</td>`;
				if (value["STATUS"] == 1) {
					var status =
					'<button class="edit-btn box-shadow w-75">Active</button>';
				} else {
					var status =
					'<button class="delete-btn  box-shadow w-75">Inactive</button>';
				}
				table += `<td>${status}</td>`;
				
				table += "</tr>";
			});
			$(".load_data").html(table);
		}
			else{
			table ="<tr><td class='text-center' colspan='6'><h1>No Users Found</h1></td></tr>"
			$(".load_data").html(table);
		}
		},
	});
}
fetchData();

$(document).on("click", "#submitForm", function () {
	let id = $("#id").val() ?? "";
	if (!id.trim() == "") {
		Swal.fire({
			title: "User Not Found?",
			text: "Some MissHappening Created By User",
			icon: "question",
		});
		return false;
	}
	let name = $("#name").val() ?? "";
	if (!validName(name)) {
		return;
	}
	let email = $("#email").val() ?? "";
	if (!validEmail(email)) {
		return;
	}
	let pass = $("#password").val() ?? "";
	if (!validPass(pass)) {
		return;
	}

	let phone = $("#phone").val() ?? "";
	if (!validNumber(phone)) {
		return;
	}
	let form = new FormData(myForm);
	$.ajax({
		url: base_url + "/userinsert",
		type: "POST",
		data: form,
		processData: false,
		contentType: false,

		success: function (data) {
			console.log(data);
			if (data.trim() == 0) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Data not Inserted!",
					footer: "<b>Why do I have this issue?</b>",
				});
			} else if (data.trim() == "<p>email_exists</p>") {
				Swal.fire({
					title: "This Email already exists!",
					text: "Try another email",
					icon: "question",
				});
			} else {
				$('.allusr').trigger('click')
				fetchData()
				Swal.fire({
					title: "Drag me!",
					icon: "success",
					draggable: true,
				});
			}
		},
	});
});

$(document).on("click", ".update_form", function () {
	
	$(".addusr").trigger("click");
	$(".addusr").text('Update User')
	$(".pss").html('')
	$(".submit_area").html('<button type="button" id="UpdateForm" class="btn btn-primary w-100">\Update\</button>')
	let id = $(this).data("uid");
	$.ajax({
		url: base_url + "/useredit/" + id,
		type: "POST",
		success: function (data) {
			data = JSON.parse(data);
			console.log(data);

			data.data.forEach(function (value) {
				$("#id").val(value["id"]);
				$("#name").val(value["name"]);
				$("#email").val(value["email"]);
				$("#phone").val(value["phone"]);
			});
		},
	});
});

$(document).on("click", "#UpdateForm", function () {
	let id = $("#id").val() ?? "";
	if (id.trim() == "") {
		Swal.fire({
			title: "User Not Found?",
			text: "Some MissHappening Created By User",
			icon: "question",
		});
		return false;
	}
	let name = $("#name").val() ?? "";
	if (!validName(name)) {
		return;
	}
	let email = $("#email").val() ?? "";
	if (!validEmail(email)) {
		return;
	}
	let phone = $("#phone").val() ?? "";
	if (!validNumber(phone)) {
		return;
	}
	let form = new FormData(myForm);
	$.ajax({
		url: base_url + "/userupdate/"+ id,
		type: "POST",
		data: form,
		processData: false,
		contentType: false,

		success: function (data) {
			console.log(data);
			if (data.trim() == 0) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Data not Inserted!",
					footer: "<b>Why do I have this issue?</b>",
				});
			} else if (data.trim() == "email_exists") {
				Swal.fire({
					title: "This Email already exists!",
					text: "Try another email",
					icon: "question",
				});
			} else {
				Swal.fire({
					title: "Drag me!",
					icon: "success",
					draggable: true,
				});
				fetchData()
				$(".allusr").trigger("click");

			}
		},
	});
});

$('.allusr').on('click',function(){
	$('.submit_area').html('<button type="button" id="submitForm" class="btn btn-primary w-100">Submit</button>')
	$('#myForm').trigger('reset')
	$('.addusr').text('Add User')
	$('.pss').html('<label class="form-label">Password</label>\
                <input type="password" name="password" id="password" class="form-control"\
                  required minlength="8" maxlength="20"\
                  pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=!])[^\s]{8,}$"\
                  oninput="this.value = this.value.replace(/\s/g, "")"\
                  title="8+ chars, uppercase, lowercase, number, special char, no spaces">\
                <div class="pass_valid text-danger"></div>')
})


$(document).on('click','.delete',function(){
	let id=$(this).data('did')
	Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed){ 
	
	$.ajax({
		url: base_url + "/userdelete/" + id,
		type: "POST",
		success:function(data){
			console.log(data)
if(data.trim()=='deleted'){
	fetchData()
				Swal.fire({
    title: "Deleted!",
    text: "Your file has been deleted.",
    icon: "success"
  })
}
else{
fetchData()
}
		}
	})
	

}
  else{
	fetchData()
  }
});



})
