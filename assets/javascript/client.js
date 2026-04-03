if (window.location.href == base_url + "clientmaster") {
	$(".side-button:eq(1)").css({
		background: "black",
		color: "white",
	});
}

$(document).on("click", ".sortable", function () {
	let newColumn = $(this).data("column");

	if ($(".field").val() === newColumn) {
		$(".order").val($(".order").val() === "ASC" ? "DESC" : "ASC");
	} else {
		$(".field").val(newColumn);
		$(".order").val("ASC");
	}

	$(".sortable").html(function () {
		return $(this).text().replace("⬆", "⬍").replace("⬇", "⬍");
	});

	let icon = $(".order").val() === "ASC" ? "⬆" : "⬇";
	$(this).html($(this).text().split(" ")[0] + " " + icon);
	$("#invis").val(1);
	fetchData();
});

function fetchData(page) {
	let status = $(".status").val() ?? "";
	let search = $(".search").val() ?? "";
	let field = $(".field").val();
	let order = $(".order").val();
	let limit = $(".limit").val() ?? 5;
	let offset = Number(page - 1) * limit ?? 0;
	$.ajax({
		url: base_url + "/clientfetch/",
		type: "POST",
		data: {
			status: status,
			search: search,
			field: field,
			order: order,
			limit: limit,
			offset: offset,
		},
		success: function (data) {
			data = JSON.parse(data);
			if (data.data.length > 0) {
				let page = $("#invis").val();
				let table = "";
				let total_records = data.pages.length;
				let total_pages = Math.ceil(total_records / limit);
				data.data.forEach(function (value, index) {
					ind = index + 1;
					index = (page - 1) * limit + ind;
					table += "<tr>";
					table += `<td>${index}</td>`;
					table += `<td class='text-center'>
				<button class="edit-btn box-shadow
				 text-center update_form" data-uid="${value["client_id"]}">
				<i class="bi bi-pen-fill"></i>
				</button>         
				<button class=" delete-btn delete box-shadow text-center" id='delete' data-did="${value["client_id"]}">
				<i class="bi bi-trash3"></i>
				</button>         
				
                </td>`;
					table += `<td class='text-primary'><i class='update_form' data-uid='${value["client_id"]}'>${value["client_name"]}</i></td>`;
					table += `<td>${value["client_email"]}</td>`;
					table += `<td class="text-end">${value["phone"]}</td>`;
					table += `<td class="">${value["address"]},${value["city"]} (${value["name"]})</td>`;
					table += `<td class="text-end">${value["pincode"]}</td>`;
					if (value["client_status"] == 1) {
						var status =
							'<button class="edit-btn box-shadow w-75">Active</button>';
					} else {
						var status =
							'<button class="delete-btn  box-shadow w-75">Inactive</button>';
					}
					table += `<td class="width-50">${status}</td>`;

					table += "</tr>";

					///////////////////////////////////////
					////////////////////////////
				});
				$(".load_data").html(table);
				let pagi = "";
				pagi += '<ul class="pagination ms-5 ms-auto d-flex">';

				if (page <= 1) {
					pagi +=
						' <li class="page-item disabled"><a class="page-link">Previous</a></li>';
				} else if (page > 1) {
					pagi +=
						"<li class='page-item'><button class='page-link' id='back'>Previous</button></li>";
				}
				if (total_records >= limit) {
					for (i = 1; i <= total_pages; i++) {
						if (i <= 1) {
							pagi += `<li class="page-item"><a class="page-link" id='${page}' href="#">${page}</a></li>`;
						} else {
							continue;
						}
					}
				}
				if (page < total_pages) {
					pagi +=
						'<li class="page-item"><button class="page-link" id="forward" href="#">Next</button></li>';
				} else if ((page = total_pages)) {
					pagi +=
						'<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
				}
				pagi += "</ul>";
				$(".page").html(pagi);
			} else {
				table =
					"<tr><td class='text-center' colspan='8'><h1>No Clients Found</h1></td></tr>";
				$(".load_data").html(table);
			}
		},
	});
}
fetchData();

$(document).on("click", "#pagination a", function (e) {
	e.preventDefault();

	var limit = $("#limit").val();
	var page = $(this).attr("id");
	fetchData(page, limit);
	$("#invis").val(page);
});

////////////back button<<<<<<<<<<

$(document).on("click", "#back", function (e) {
	e.preventDefault();

	var page = $("#invis").val();
	var page = Number(page) - 1;
	$("#invis").val(page);

	fetchData(page);
});

/////////////////forward button>>>>>>>>>>>>

$(document).on("click", "#forward", function (e) {
	e.preventDefault();

	var page = $("#invis ").val();
	var page = Number(page) + 1;
	$("#invis").val(page);
	fetchData(page);
});

function limit() {
	$("#invis").val(1);
	var page = $("#invis").val();
	fetchData(Number(page));
}

function search() {
	var val = 1;
	$("#invis").val(val);
	var page = $("#invis").val();
	fetchData(Number(page));
}
function resetBTN() {
	$(".search").val("");
	var val = 1;
	$("#invis").val(val);
	var page = $("#invis").val();
	fetchData(Number(page));
}

async function loadstates() {
	await $.ajax({
		url: base_url + "/fetchstates/",
		type: "POST",
		success: function (data) {
			data = JSON.parse(data);

		 let states =
				"<select id='state' name='state' class='selected_state form-select'>";
			states += `<option value=''>----Select State----</option>`;
			data.forEach(function (value) {
				states += `<option value='${value["id"]}'>${value["name"]}</option>`;
			});
			states += "</select>";
			$(".states_area").html(states);
		},
	});
}

$(document).on("change", ".selected_state", function () {
	let state = $(this).val();
	
	if (state.trim() == "") {
		$(".cities_area").html(`  <select name="" id="" class="form-select">
			<option value="">----select City----</option>
			</select>`);
		return false;
	} else {

		loadcity(state);
	}
});

function loadcity(state) {
	$.ajax({
		url: base_url + "/fetchcities/" + state,
		type: "POST",
		success: function (data) {
			data = JSON.parse(data);

			let states = "<select id='city' name='city' class='form-select'>";
			data.forEach(function (value) {
				states += `<option value='${value["id"]}'>${value["city"]}</option>`;
			});
			states += "</select>";
			$(".cities_area").html(states);
		},
	});
}

$(document).on("click", "#submitForm", function () {
	let id = $("#id").val() ?? "";
	if (!id.trim() == "") {
		Swal.fire({
			title: "Client Not Found?",
			text: "Some MissHappening Created By Client",
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
	let address = $("#address").val() ?? "";
	if (!validAddress(address)) {
		return;
	}
	let state = $("#state").val() ?? "";
	if (!validState(state)) {
		return;
	}
	let city = $("#city").val() ?? "";
	if (!validState(city)) {
		return;
	}

	let pincode = $("#pincode").val() ?? "";
	if (!validPincode(pincode)) {
		return;
	}

	let form = new FormData(myForm);
	$.ajax({
		url: base_url + "/clientinsert",
		type: "POST",
		data: form,
		processData: false,
		contentType: false,

		success: function (data) {
			let msg = data.toString().trim();

			msg = msg.replace(/<[^>]*>/g, "").trim();

			msg = msg.replace(/^"|"$/g, "");
			if (data.trim() == 0) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Data not Inserted!",
					footer: "<b>Why do I have this issue?</b>",
				});
			} else if (msg.toLowerCase().startsWith("valid")) {
				Swal.fire({
					title: "Enter valid details!",
					text: "Try again",
					icon: "error",
				});
				return false;
			} else {
				$(".allcli").trigger("click");
				fetchData();
				Swal.fire({
					title: "Inserted!",
					icon: "success",
					draggable: true,
				});
			}
		},
	});
});

$(document).on("click", ".update_form", async function () {
	// debugger;
	 await $(".addcli").trigger("click");
	$(".addcli").text("Update Client");
	$(".submit_area").html(
		'<button type="button" id="UpdateForm" class="btn btn-primary w-100">\Update\</button>',
	);
	let id = $(this).data("uid");
	$.ajax({
		url: base_url + "/clientedit/" + id,
		type: "POST",
		success: function (data) {
			data = JSON.parse(data);

			data.data.forEach(async function (value) {
				$("#id").val(value["client_id"]);
				$("#name").val(value["client_name"]);
				$("#email").val(value["client_email"]);
				$("#phone").val(value["phone"]);
				$("#state").val(Number(value["state_id"]));
				let state = $("#state").val();
				$("#address").val(value["address"]);
				$("#pincode").val(value["pincode"]);
				
				
				await $.ajax({
					url: base_url + "/fetchcities/" + state,
					type: "POST",
						data: {
							// state: state,
						},
						success: function (data) {
							data = JSON.parse(data);
							var row =
							"<select name='city' class='form-select' id='city' value''><option value=''>----Select City----</option>";
							data.forEach(function (value) {
								row += `<option  value='${value["id"]}'>${value["city"]}</option>`;
							});
							row += "</select>";
							$(".cities_area").html(row);
							
							$("#city").val(value["city_id"]);
						},
					});
					
					// loadCity(state);
					$("#state").val(Number(value["state_id"]));
				let status = (value["client_status"] == 1) ? "ACTIVE" : "INACTIVE";
				let other = (value["client_status"] == 0) ? "ACTIVE" : "INACTIVE";
				let other_val = (value["client_status"] == 0) ? 1 : 0;
				$(".status_area")
					.html(` <label class="form-label">Status</label><select id='client_status' name='status' class='form-select ' value='${value["client_status"]}'>
						
						<option value='${value["client_status"]}'>${status}</option>
						<option value='${other_val}'>${other}</option>
						
						</select>`);
			});
		},
	});
});

$(document).on("click", "#UpdateForm", function () {
	// debugger;
	let id = $("#id").val() ?? "";
	if (id.trim() == "") {
		Swal.fire({
			title: "Client Not Found?",
			text: "Some MissHappening Created By Client",
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
	let address = $("#address").val() ?? "";
	if (!validAddress(address)) {
		return;
	}
	let state = $("#state").val() ?? "";
	if (!validState(state)) {
		return;
	}
	let city = $("#city").val() ?? "";
	if (!validState(city)) {
		return;
	}

	let pincode = $("#pincode").val() ?? "";
	if (!validPincode(pincode)) {
		return;
	}

	let form = new FormData(myForm);
	$.ajax({
		url: base_url + "/clientupdate/" + id,
		type: "POST",
		data: form,
		processData: false,
		contentType: false,

		success: function (data) {
			if (data.trim() == 0) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Data not Updated!",
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
					title: "Updated!",
					icon: "success",
					draggable: true,
				});
				let page = $("#invis").val();
				fetchData(page);
				$(".allcli").trigger("click");
			}
		},
	});
});

$(".reset").on("click", function () {
	$(".cities_area").html(`  <select name="" id="" class="form-select">
      <option value="">----select City----</option>
    </select>`);
});

$(".allcli").on("click", function () {
	$(".submit_area").html(
		'  <button type="button" id="submitForm" class="btn btn-outline-primary">\
                       Submit\
                      </button>\
                      <button type="reset" class="reset btn btn-outline-danger">Reset</button>\
                  ',
	);
	$("#myForm").trigger("reset");
	$(".addcli").text("Add Client");
	$(".pss").html(
		'<label class="form-label">Password</label>\
                <input type="password" name="password" id="password" class="form-control"\
                  required minlength="8" maxlength="20"\
                  pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=!])[^\s]{8,}$"\
                  oninput="this.value = this.value.replace(/\s/g, "")"\
                  title="8+ chars, uppercase, lowercase, number, special char, no spaces">\
                <div class="pass_valid text-danger"></div>',
	);
	$(".name_valid").hide();
	$(".email_valid").hide();
	$(".number_valid").hide();
	$(".status_area").html("");
	$(".state_valid").html("");
	$(".city_valid").html("");
	$(".pincode_valid").html("");
	$(".address_valid").html("");
	$('.cities_area').html(' <select name="" id="" class="form-select">\
      <option value="">----select City----</option>\
    </select>')
});

$(document).on("click", ".delete", function () {
	let id = $(this).data("did");
	Swal.fire({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, delete it!",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: base_url + "/clientdelete/" + id,
				type: "POST",
				success: function (data) {
					if (data.trim() == "deleted") {
						fetchData();
						Swal.fire({
							title: "Deleted!",
							text: "Your file has been deleted.",
							icon: "success",
						});
						let page = $("#invis").val();
						fetchData(page);
					} else if (data.trim() == 0) {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Unable to delete this client!",
							footer: '<a href="#">This client Have some Incoices Left</a>',
						});

						let page = $("#invis").val();
						fetchData(page);
					} else {
					}
				},
			});
		} else {
		}
	});
});
