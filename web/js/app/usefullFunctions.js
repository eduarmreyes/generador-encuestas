function fnAddErrorNotify(stringText) {
	$.pnotify({
		title: 'Error',
		text: stringText,
		type: 'error',
		history: false
	});
}

function fnAddSuccessNotify(stringText) {
	$.pnotify({
		title: 'Success',
		text: stringText,
		type: 'success',
		history: false
	});
}

function fnAddWarningNotify(stringText) {
	$.pnotify({
		title: 'Warning',
		text: stringText,
		history: false
	});
}
function fnAddInfoNotify(stringText) {
	$.pnotify({
		title: 'Info',
		text: stringText,
		type: 'info',
		history: false
	});
}
function fnGetRowByCustomAttr(oDataTable, value, customAttr) {
	var aReturn = new Array();
	var aTrs = oDataTable.fnGetNodes();
	for (var i = 0; i < aTrs.length; i++) {
		if ($(aTrs[i]).attr(customAttr) == value) {
			aReturn.push(aTrs[i]);
		}
	}
	return aReturn;
}

function fnGetNewRowByCustomAttr(oDataTable, customAttr) {
	var aReturn = new Array();
	var aTrs = oDataTable.fnGetNodes();
	for (var i = 0; i < aTrs.length; i++) {
		var newRow = $(aTrs[i]).attr(customAttr);
		if (typeof newRow == "undefined") {
			aReturn.push(aTrs[i]);
		}
	}
	return aReturn;
}
function addValidatePresence(oValidation, oKeyValues) {
	oValidation.add(Validate.Presence, oKeyValues);
}
function addValidateNumber(oValidation, oKeyValues) {
	oValidation.add(Validate.Numericality, oKeyValues);
}
function addValidateEmail(oValidation, oKeyValues) {
	oValidation.add(Validate.Email, oKeyValues);
}
function fnInitiateDatatable(cssSelector) {
	var dataTable = $(cssSelector).dataTable();
	return dataTable;
}
function fnInitiateDatatableReport(cssSelector, swfPath) {
	var dataTable = $(cssSelector).dataTable({
		"bDestroy": true,
		"sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
		"oTableTools": {
			"sSwfPath": swfPath
		},
	});
	return dataTable;
}
function fnInitiateWizard(cssSelector) {
	var wizard = $(cssSelector).wizard();
	return wizard;
}
function fnGetRowByCustomAttr(oDataTable, value, customAttr) {
	var aReturn = new Array();
	var aTrs = oDataTable.fnGetNodes();
	for (var i = 0; i < aTrs.length; i++) {
		if ($(aTrs[i]).attr(customAttr) == value) {
			aReturn.push(aTrs[i]);
		}
	}
	return aReturn;
}
function fnGetNewRowByCustomAttr(oDataTable, customAttr) {
	var aReturn = new Array();
	var aTrs = oDataTable.fnGetNodes();
	for (var i = 0; i < aTrs.length; i++) {
		var newRow = $(aTrs[i]).attr(customAttr);
		if (typeof newRow == "undefined") {
			aReturn.push(aTrs[i]);
		}
	}
	return aReturn;
}
function fnShowTooltip(selector, placement) {
	$(selector).tooltip({
		placement: placement
	});
}
// seleccionar filas
function removeSelectedRow() {
	$('.dataTable > tbody  > tr').each(function() {
		$(this).removeClass('row_selected');
	});
}
$("img.delete_record").bind('hover', function() {
	this.src = this.src.replace("_off", "_on");
});
$("img.delete_record").bind('mouseleave', function() {
	this.src = this.src.replace("_on", "_off");
});
// handle status codes from ajax
function fnStatusCodes() {
	return {
		204: function() {
			fnAddErrorNotify("El servidor no envió ninguna respuesta.");
		},
		400: function() {
			fnAddErrorNotify("Mal pedido desde el cliente.");
		},
		401: function() {
			fnAddInfoNotify("No estás autorizado a hacer la acción pedida.");
		},
		403: function() {
			fnAddWarningNotify("La sesión ha terminado, por favor ve a la pantalla de inicio de sesión");
		},
		404: function() {
			fnAddErrorNotify("Página no encontrada.");
		},
		500: function() {
			fnAddErrorNotify("Un error fatal ha ocurrido, por favor reportalo.");
		}
	};
}
// seleccionar filas tabla de historico
//$(".dataTable tbody").delegate('tr','click',function(){
//	var tr = $(this);
//	var oTr = $(tr).get(0);       	 
//	removeSelectedRow();
//	tr.addClass("row_selected");
//});
