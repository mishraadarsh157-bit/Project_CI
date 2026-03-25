if (window.location.href == base_url + "usermaster") {
	$(".side-button:eq(0)").css({
		"background": "black",
		"color":"white"
	});
}

function fetchData() {
	$.ajax({
		url: base_url + "/userfetch",
		type: "POST",
		// 	beforeSend: function(){

		//   $('#spinner').show()
		//   $('.message_valid').hide()
		//   $('.subject_valid').hide()
		// },
		success: function (data) {
			data = JSON.parse(data);
			let table = "";
			data.product_details.forEach(function (value) {
				table += "<tr>";
				table += `<td>${value["id"]}</td>`;
				table += `<td>
                    <button class="edit-btn text-center" id='update_form' data-uid="${value["id"]}">
                    <i class="bi bi-pen-fill"></i>
                    </button>         
                    <button class=" delete-btn text-center" id='delete' data-did="${value["id"]}">
                    <i class="bi bi-trash3"></i>
                    </button>         
                          
                </td>`;
				table += `<td>${value["name"]}</td>`;
				table += `<td>${value["email"]}</td>`;
				table += `<td>${value["phone"]}</td>`;
				if (value["STATUS"] == 1) {
					var status = '<button class="edit-btn box-shadow w-75">Active</button>';
				} else {
					var status = '<button class="delete-btn w-75">Inactive</button>';
				}
				table += `<td>${status}</td>`;

				table += "</tr>";
			});
			$(".load_data").html(table);
		},
	});
}
fetchData();

$(document).on("click", "#submitForm", function () {
	let name = $("#name").val() ?? "";
	if (name.trim() == "") {
		return false;
	}
	let pass = $("#password").val() ?? "";
	if (pass.trim() == "") {
		return false;
	}
	let email = $("#email").val() ?? "";
	if (email.trim() == "") {
		return false;
	}
	let phone = $("#phone").val() ?? "";
	if (phone.trim() == "") {
		return false;
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
			} else {
				Swal.fire({
					title: "Drag me!",
					icon: "success",
					draggable: true,
				});
			}
		},
	});
});
