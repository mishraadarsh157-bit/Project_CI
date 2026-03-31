if (window.location.href == base_url + "invoice") {
	$(".side-button:eq(3)").css({
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
		url: base_url + "/invoicefetch/",
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
				<button class="mailGen edit-btn box-shadow
				 text-center " data-bs-toggle="modal" data-bs-target="#sendMailModal" data-eid="${value["InvoiceNo"]}">
				<i class="bi bi-envelope-fill"></i>
				</button>         
				        <button class="makePdf delete-btn box-shadow text-center" id='pdf' data-did="${value["InvoiceNo"]}" >
				<i class="bi bi-file-earmark-pdf"></i>
				</button> 
				
                </td>`;
					table += `<td class='text-primary text-center'><i  class="update_form" data-uid='${value["InvoiceNo"]}'>#INVNO${value["InvoiceNo"]}</i></td>`;
					table += `<td class=''><i class='' >${value["client_name"]}</i></td>`;
					table += `<td>${value["client_email"]}</td>`;
					table += `<td>${value["phone"]}</td>`;
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

function addMore() {
	var row = "<tr class='border'>";
	row +=
		'<td class="pb-3 ps-2">Item Name <sup class="text-danger">*</sup><input type="text" name="itemName[]" id="item_s" class="item-name-invoice form-control" placeholder="Item Name"><div class="itemselect position-absolute "></div></td>\
<td class="pb-3"><input type="text" hidden name="itm_id[]" class="itm_Id">  Item Price<input disabled type="text" name="price[]" class="item-price-invoice form-control bg-white" placeholder="Item Price"></td>\
<td class="pb-3">\
Quantity<input min="1" type="number" onchange="changeAmt()" min="1" max="100" oninput="this.value = this.value < 1 ? 1 : this.value" class="item-quantity-invoice form-control" name="quantity[]" bg-white  border border-0" value="1">\
   </td>\
    <td class="pb-3">Amount<input type="number" disabled placeholder="Amount" name="rowTotal[]" class="rowTotal bg-white form-control"></td>\
    <td class="pb-3"><button type="button" onclick="changeAmt()" class="removeForm btn btn-outline-danger border border-0">X</button></td></tr>\
    ';
	$(".itemTable").append(row);
	cutBtn();
}

function fetchClientData() {
	var name = $(".client-name-invoice").val() ?? "";
	if (name.trim() == "") {
		return false;
	}
	$.ajax({
		url: base_url + "/invoiceClientdata/" + name,
		type: "POST",

		success: function (data) {
			if (data.trim() == "empty") {
				$(".client-email-invoice").val("no data").css("color", "red");
				$(".client-phone-invoice").val("no data").css("color", "red");
			} else {
				data = JSON.parse(data);
				data.data.forEach(function (value) {
					if (value == null) {
					} else {
						$(".cli_Id").val(value["client_id"]);
						$(".client-email-invoice")
							.val(`${value["client_email"]}`)
							.css("color", "black");
						$(".client-phone-invoice")
							.val(`${value["phone"]}`)
							.css("color", "black");
					}
				});
			}
		},
	});
}
///////client name invoice//////

$(document).on("keyup", ".client-name-invoice", function () {
	let value = $(this).val() ?? "";
	if (value == "") {
		value = "a";
	}
	$.ajax({
		url: base_url + "/invoiceClient/" + value,
		type: "POST",
		data: {
			clientSearch: value,
		},
		success: function (data) {
			data = JSON.parse(data);
			if (data == "") {
				let table = "no client found";

				$(".clientselect").html(table).css("color", "red");
				$(".invalidclint").text("");
			} else {
				$(function () {
					var availableclients = data;
					$("#automplete-1").autocomplete({
						source: availableclients,
						select: function (event, ui) {
							fetchClientData();
						},
					});
					$(".invalidclint").text("");

					$(".clientselect").html("");
				});
			}
		},
	});
});

$(document).on("keyup", ".item-name-invoice", function () {
	let value = $(this).val() ?? "";
	if (value == "") {
		value = "b";
	}
	let row = $(this).closest("tr");
	$.ajax({
		url: base_url + "/invoiceItem",
		type: "POST",
		data: {
			itemSearch: value,
		},
		success: function (data) {
			if (data.trim() == "empty") {
				let table = "no item found";
				row.find(".itemselect").html(table).css("color", "red");
			} else {
				data = JSON.parse(data);

				row.find(".itemselect").html("");
				$(function () {
					var availableitems = data;
					row.find("#item_s").autocomplete({
						source: availableitems,
						select: function (event, ui) {
							let value = $(this).val();
							let row = $(this).closest("tr");
							$.ajax({
								url: base_url + "/invoiceItemdata",
								type: "POST",
								data: {
									item_name: value,
								},
								success: function (data) {
									data = JSON.parse(data);

									row.find(".item-price-invoice").val(data.price);
									row.find(".itm_Id").val(data.item_id);
								},
							});
						},
					});
				});
			}
		},
	});
});

$(document).on("keyup", ".item-name-invoice", function () {
	let value = $(this).val() ?? "";
	let row = $(this).closest("tr");
	if (value.trim() == "") {
		row.find(".itm_Id").val("");
		row.find(".item-price-invoice").val("");
		row.find(".item-quantity-invoice").val(1);
	}
});

$(document).on("keyup", ".client-name-invoice", function () {
	let value = $(this).val() ?? "";
	if (value.trim() == "") {
		$(".cli_Id").val("");
		$(".client-email-invoice").val("");
		$(".client-phone-invoice").val("");
	}
});

function changeAmt() {
	let price = $("input[name='price[]']")
		.map(function () {
			return this.value;
		})
		.get();
	let quantity = $("input[name='quantity[]']")
		.map(function () {
			return this.value;
		})
		.get();
	let amount = [];
	price.forEach(function (value, index) {
		amount.push(value * quantity[index]);
	});
	amount.forEach(function (value, index) {
		if (value == null) {
		} else {
			$(".rowTotal").eq(index).val(value);
		}
		let total = 0;
		amount.forEach(function (value) {
			total += value;
		});
		$(".total-amount-invoice").val(total);
	});
}
$(document).on("click", ".removeForm", function () {
	$(this).closest("tr").remove();
	changeAmt();
	cutBtn();
});

function loadInvoice() {
	$(".itemTable").html("");
	$(".loadmoreForm").html("");
	addMore();

	$.ajax({
		url: base_url + "/InvoiceNo",
		type: "POST",
		success: function (data) {
			data = JSON.parse(data);
			$(".invoice_id").val(Number(data.InvoiceNo) + 1);
		},
	});
}

function addInvoic() {
	let invoiceNo = $(".invoice_id").val() ?? "";
	if (invoiceNo.trim() == "") {
		Swal.fire({
			title: "Error!",
			text: "Invoice Number Not Found?",
			icon: "error",
		});
		return false;
	}
	if ($(".client-email-invoice").val() == "no data") {
		$(".clientselect").html("");
		$(".invalidclint").text("enter valid clint name");
		return false;
	} else {
		$(".invalidclint").text("");
	}
	let client = $(".cli_Id").val() ?? "";
	if (client.trim() == "") {
		Swal.fire({
			title: "Error!",
			text: "Client Not Found?",
			icon: "error",
		});
		return false;
	}
	if (client == "") {
		$(".invalidclint").text("enter clint name");
		return false;
	} else {
		$(".invalidclint").hide();
	}
	let item = $("input[name='itm_id[]']")
		.map(function () {
			return this.value;
		})
		.get();
	if (item.some((element) => element == "")) {
		$(".insertall").text("insert proper items");
		return false;
	}
	let quantity = $("input[name='quantity[]']")
		.map(function () {
			return this.value;
		})
		.get();
	if (
		quantity.some(
			(element) => element == "" || quantity.some((element) => element < 1),
		)
	) {
		$(".quantityall").text("insert proper quantity");
		return false;
	}
	if (quantity.some((element) => Number(element) > 99999)) {
		$(".quantityall").text("Quantity Should Be Max 99999");
		return false;
	}
	let fd = new FormData(myForm);
	$.ajax({
		url: base_url + "/invoiceInsert",
		type: "POST",
		data: fd,
		processData: false,
		contentType: false,
		success: function (data) {
			if (data.trim() == 1) {
				$(".allusr").trigger("click");
				$(".addInvoice").trigger("reset");
				fetchData();
			} else if (data.trim() == "Please Enter Items") {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Please Enter Items!",
					footer: '<a href="#">Some Values Are incorrect?</a>',
				});
			} else if (data.trim() == "Please Enter Quantity") {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Please Enter Quantity!",
					footer: '<a href="#">Some Values Are incorrect?</a>',
				});
			} else {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Data Not Inserted!",
					footer: '<a href="#">Some Values Are incorrect?</a>',
				});
			}
		},
	});
}

$(document).on("click", ".update_form", function () {
	$("#add").tab("show");
	$("#add").text("Update Invoice");
	$(".add_inv").text("Update Invoice");
	let id = $(this).data("uid");
	$.ajax({
		url: base_url + "/invoiceUpdateForm/" + id,
		type: "POST",
		success: function (data) {
			data = JSON.parse(data);
			let input = "";
			data.forEach(function (value, index) {
				$(".invoice_id").val(value["InvoiceNo"]);
				$(".cli_Id").val(value["client_id"]);
				$(".client-name-invoice")
					.val(value["client_name"])
					.prop("disabled", true);
				$(".client-email-invoice").val(value["client_email"]);
				$(".client-phone-invoice").val(value["phone"]);
				input += "<tr class='w-100'>";
				input += `<td class=''><input type="text" class="item-name-invoice form-control"  onchange="fetchItemData(this)" onkeyup="changeAmt()" name='itemName[]'  value="${value["item_name"]}"><div class="itemselect position-absolute"></div>
					<input type="text" hidden name='itm_id[]' class='itm_Id' value="${value["item_id"]}">  </td>`;
				input += `<td><input type="text" disabled class="item-price-invoice bg-white form-control"  name="price[]"  value="${value["price"]}"></td>`;
				input += `<td><input min='1' type="number" class="item-quantity-invoice form-control"  onchange="changeAmt()" name='quantity[]'  value="${value["Quantity"]}"></td>`;
				let amount = Number(value["Quantity"]) * Number(value["price"]);
				input += `<td><input type="text" disabled class="rowTotal bg-white form-control"  name="rowTotal[]" value="${amount}"></td>`;
				input +=
					'<td><button type="button" class="removeForm btn btn-outline-danger border border-0">X</button></td>';
				input += "</tr>";
			});
			input += "</table>";
			$(".loadmoreForm").html(input);
			$(".loadButtons").html(
				' <div class="loadButtons col-5 mt-4" align="right">Total Amount<input type="text" disabled class="total-amount-invoice form-control bg-white mb-4" placeholder="Total Amount">\
            <button class="btn btn-outline-primary mb-4" id="UpdateForm" type="button">Update Invoice</button>\
			</div>',
			);
			changeAmt();
		},
	});
});

$(document).on("click", "#UpdateForm", function () {
	let invoiceNo = $(".invoice_id").val() ?? "";
	if (invoiceNo.trim() == "") {
		Swal.fire({
			title: "Error!",
			text: "Invoice Number Not Found?",
			icon: "error",
		});
		return false;
	}
	if ($(".client-email-invoice").val() == "no data") {
		$(".clientselect").html("");
		$(".invalidclint").text("enter valid clint name");
		return false;
	} else {
		$(".invalidclint").text("");
	}
	let client = $(".cli_Id").val() ?? "";
	if (client.trim() == "") {
		Swal.fire({
			title: "Error!",
			text: "Client Not Found?",
			icon: "error",
		});
		return false;
	}
	if (client == "") {
		$(".invalidclint").text("enter clint name");
		return false;
	} else {
		$(".invalidclint").hide();
	}
	let item = $("input[name='itm_id[]']")
		.map(function () {
			return this.value;
		})
		.get();
	if (item.length <= 0) {
		$(".insertall").text("insert proper items");
		return false;
	}
	if (item.some((element) => element == "")) {
		$(".insertall").text("insert proper items");
		return false;
	}
	let quantity = $("input[name='quantity[]']")
		.map(function () {
			return this.value;
		})
		.get();
	if (quantity.length <= 0) {
		$(".insertall").text("insert proper items");
		return false;
	}
	if (
		quantity.some(
			(element) => element == "" || quantity.some((element) => element < 1),
		)
	) {
		$(".quantityall").text("insert proper quantity");
		return false;
	}
	let fd = new FormData(myForm);
	$.ajax({
		url: base_url + "/invoiceUpdate/" + invoiceNo,
		type: "POST",
		data: fd,
		processData: false,
		contentType: false,
		success: function (data) {
			if (data.trim() == 1) {
				$(".allusr").trigger("click");
				Swal.fire({
					title: "Updated!",
					icon: "success",
					draggable: true,
				});
			}
		},
	});
});

$("#all").on("click", function () {
	$(".loadmoreForm").html("");
	$("#add").text("Add Invoice");
	$("#myForm").trigger("reset");
	$(".add_inv").text("Add Invoice");
	$(".itemTable").html("");
	$(".client-name-invoice").prop("disabled", false);
	$(".loadButtons").html(
		' <div class="loadButtons col-5 mt-4" align="right">Total Amount<input type="text" disabled class="total-amount-invoice form-control bg-white mb-4" placeholder="Total Amount">\
		<button onclick="addInvoic()" class="btn btn-outline-primary mb-4" type="button">Save Invoice</button><button type="reset" onclick="loadInvoice()" class="btn btn-outline-danger ms-3 mb-4">Clear Form</button>\
		</div>',
	);
});

function cutBtn() {
	let row = $(".item-name-invoice").length;
	if (row <= 1) {
		$(".removeForm").prop("disabled", true);
	} else {
		$(".removeForm").removeAttr("disabled");
	}
}

////pdf////

$(document).on("click", ".makePdf", async function () {
	let id = $(this).data("did");
	$("#pdfModal").modal("show");

	await $("#pdfFrame").attr("src", base_url + "/pdf/" + id);
});

$(document).on("click", ".mailGen", async function () {
	let id = $(this).data("eid");
	$.ajax({
		url: base_url + "/generateMail/" + id,
		type: "POST",
		success: function (data) {
			data = JSON.parse(data);
			$("#Invn").val(data.InvoiceNo);
			$("#client_no").val(data.client_name);
			$("#client_email").val(data.client_email);
			$("#subject").val(`Invoice #INVNO${data.InvoiceNo} from San Softwares`);
			$("#des").val(`Dear ${data.client_name},

Please find attached your invoice #INVNO${data.InvoiceNo}.
\n
If you have any questions, feel free to contact us.
\n
Thank you for your business.
\n
Best regards,  
\n
SAN SOFTWARE's Team`);
		},
	});
});

$(document).on("click", "#sendMail", function () {
	let fd = new FormData(mailForm);
	$.ajax({
		url: base_url + "/mail",
		type: "POST",
		data: fd,
		processData: false,
		contentType: false,
		success:function(data){
			data=JSON.parse(data);
			if(data.success==true){
				$('.btn-close').trigger('click');
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Mail Sent",
					showConfirmButton: false,
					timer: 1500
				});
			}
		}
	});
});
