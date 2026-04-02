if (window.location.href == base_url + "itemmaster") {
	$(".side-button:eq(2)").css({
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
		url: base_url + "/itemfetch/",
		type: "POST",
		data: {
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
				 text-center update_form" data-uid="${value["item_id"]}">
				<i class="bi bi-pen-fill"></i>
				</button>         
				<button class=" delete-btn delete box-shadow text-center" id='delete' data-did="${value["item_id"]}">
				<i class="bi bi-trash3"></i>
				</button>         
				
                </td>`;
					table += `<td class='text-primary'><img src='${base_url}${value["item_image"]}' height='30px' width='30px' class='itm_im me-3'><i class='update_form' data-uid='${value["item_id"]}'>${value["item_name"]}</i></td>`;
					table += `<td>${value["description"]}</td>`;
					table += `<td class='text-end'>₹${value["price"]}</td>`;

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
					"<tr><td class='text-center' colspan='6'><h1>No Items Found</h1></td></tr>";
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
//////////////>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

$(document).on("click", "#submitForm", function () {
	let id = $("#id").val() ?? "";
	if (!id.trim() == "") {
		Swal.fire({
			title: "Invalid Entries?",
			text: "Some MissHappening Created By Item",
			icon: "question",
		});
		return false;
	}
	let name = $("#name").val() ?? "";
	if (!validName(name)) {
		return;
	}
	let des = $("#description").val() ?? "";
	if (!validDescription(des)) {
		return;
	}

	let price = $("#price").val() ?? "";
	if (!validPrice(price)) {
		return;
	}

	let form = new FormData(myForm);
	$.ajax({
		url: base_url + "/iteminsert",
		type: "POST",
		data: form,
		processData: false,
		contentType: false,

		success: function (data) {
			if (data.trim() == "inserted") {
				$('.allusr').trigger('click')
				fetchData()
				Swal.fire({
					title: "Inserted!",
					icon: "success",
					draggable: true,
				});
				
			} else {
				Swal.fire({
					title: data,
					text: "Try again!",
					icon: "question",
				});
			}
		},
	});
});

function itmImg(event) {
	const imgPrieview = $(".itemImage");
	const files = event.target.files;
	if (files.length > 0) {
		const file = files[0];
		const tempUrl = URL.createObjectURL(file);
		$(".itemImage").attr("src", tempUrl);
		imgPrieview.onload = function () {
			URL.revokeObjectURL(this.src);
		};
	}
}

function resetImage() {
	$("#item_image").val("");
	$(".itemImage").attr("src", "");
	$('.image_holder').html(`<input type="file"  name='image' accept="image/png, image/jpeg, image/jpg" onchange="itmImg(event)" id="image" class='form-control w-75'><button class="btn border border-0 btn-outline-danger" type="button" onclick="resetImage()"><i class="bi bi-x-lg"></i></button>
                      `)
}

$(document).on("click", ".update_form", function () {
	$(".addusr").trigger("click");
	$(".addusr").text("Update Item");
	$(".submit_area").html(
		'<button type="button" id="UpdateForm" class="btn btn-primary w-100">\Update\</button>',
	);
	let id = $(this).data("uid");
	$.ajax({
		url: base_url + "/itemedit/" + id,
		type: "POST",
		success: function (data) {
			data = JSON.parse(data);

			data.data.forEach(function (value) {
				$("#id").val(value["item_id"]);
				$("#name").val(value["item_name"]);
				$("#description").val(value["description"]);
				$("#price").val(value["price"]);
				// $("#image").val(value["item_image"]);
				$(".itemImage").attr("src", `/project_CI/${value["item_image"]}`);
			});
			$(".itemSaver").html(
				' <button type="button" id="UpdateForm" name="" class="btn btn-outline-primary">UPADTE</button>',
			);
		},
	});
});

$(document).on("click", "#UpdateForm", function () {
	let id = $("#id").val() ?? "";
	if (id.trim() == "") {
		Swal.fire({
			title: "Item Not Found?",
			text: "Some MissHappening Created By Item",
			icon: "question",
		});
		return false;
	}
	let name = $("#name").val() ?? "";
	if (!validName(name)) {
		return;
	}
	let des = $("#description").val() ?? "";
	if (!validDescription(des)) {
		return;
	}

	let price = $("#price").val() ?? "";
	if (!validPrice(price)) {
		return;
	}
	let form = new FormData(myForm);
	$.ajax({
		url: base_url + "/itemupdate/" + id,
		type: "POST",
		data: form,
		processData: false,
		contentType: false,

		success: function (data) {
			if (data.trim() == "updated") {
				if (data.trim() == "updated") {
					Swal.fire({
						title: "Updated!",
						icon: "success",
						draggable: true,
					});
					let page = $("#invis").val();
					fetchData(page);
					$(".allusr").trigger("click");
				}
			} else {
				Swal.fire({
					title: data,
					text: "Try again!",
					icon: "question",
				});
			}
		},
	});
});

$(".allusr").on("click", function () {
	$(".submit_area").html(
		'<button type="button" id="submitForm" class="btn btn-primary w-100">Submit</button>',
	);
	$("#myForm").trigger("reset");
	$(".addusr").text("Add Item");
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
	$(".eamil_valid").hide();
	$(".pass_valid").hide();
	$(".number_valid").hide();
	$('.itemImage').attr('src',"")
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
				url: base_url + "/itemdelete/" + id,
				type: "POST",
				success: function (data) {
					if (data.trim() == "deleted") {
						let page = $("#invis").val();
						fetchData(page);

						Swal.fire({
							title: "Deleted!",
							text: "Your file has been deleted.",
							icon: "success",
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Unable to delete this item!",
							footer: '<a href="#">This item Have Some data in invoice?</a>',
						});
					}
				},
			});
		} else {
		}
	});
});
