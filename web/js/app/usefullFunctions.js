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
function fnInitiateDatatable(cssSelector) {
	var dataTable = $(cssSelector).dataTable({
    	"oLanguage": {
        	"sLengthMenu": "_MENU_ records per page",
        	"sInfo": "<span class='label'>Showings _START_ to _END_ of _TOTAL_</span>"
    	}
	});
	return dataTable;
}
function fnInitiateDatatableReport(cssSelector, swfPath) {
	var dataTable = $(cssSelector).dataTable({
    	"bDestroy": true,
    	"sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
    	"oTableTools": {
        	"sSwfPath": swfPath
    	},
    	"oLanguage": {
        	"sLengthMenu": "_MENU_ records per page",
        	"sInfo": "<span class='label'>Showings _START_ to _END_ of _TOTAL_</span>"
    	}
	});
	return dataTable;
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
function fnShowTooltip(placement) {
	$(".showTooltip").tooltip({
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
        	fnAddErrorNotify("No information send back from server.");
    	},
    	400: function() {
        	fnAddErrorNotify("Bad request from the client.");
    	},
    	401: function() {
        	fnAddInfoNotify("You're unathorized or the session has expired, please login again.");
    	},
    	403: function() {
        	fnAddWarningNotify("The session has expired, please refer to the login");
    	},
    	404: function() {
        	fnAddErrorNotify("Page not found.");
    	},
    	500: function() {
        	fnAddErrorNotify("Fatal errors has occurred, please advice the administrator.");
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
