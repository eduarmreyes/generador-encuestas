<?php
slot("admin_active", "active");
slot("permission", "active");
?>
<div class="card">
	<h3 class="card-heading simple">New Permission</h3>
	<div class="card-body">
    	<form id="newPermission" class="form-horizontal" action="<?php echo url_for('sfGuardPermission/doSave') ?>" method="post">
        	<div class="row">
            	<?php echo $form->renderHiddenFields(); ?>
            	<div class="span5">
                	<div class="control-group">
                    	<label class="control-label" for="sf_guard_permission_name">Permission Name: *</label>
                    	<div class="controls">
                        	<?php echo $form["name"]; ?>
                    	</div>
                	</div>
                	<div class="control-group">
                    	<label class="control-label" for="sf_guard_permission_description">Description: </label>
                    	<div class="controls">
                        	<?php echo $form["description"]; ?>
                    	</div>
                	</div>
				</div>
				<div class="span6">
					<div class="control-group">
                    	<label class="control-label" for="sf_guard_permission_users_list">Users List:</label>
                    	<div class="controls">
                        	<?php echo $form["users_list"]; ?>
                    	</div>
                	</div>
                	<div class="control-group">
                    	<label class="control-label" for="sf_guard_permission_groups_list">Groups List:</label>
                    	<div class="controls">
                        	<?php echo $form["groups_list"]; ?>
                    	</div>
                	</div>
            	</div>
        	</div>
        	<div class="form-actions">
            	<input type="submit" class="btn btn-info-purple" value="Save" data-loading-text="Saving New Permission..." >
            	<input type="reset" class="btn" value="Reset">
        	</div>
    	</form>
	</div>
</div>
<div class="card">
	<h3 class="card-heading simple">Permission List</h3>
	<div class="card-body">
    	<table id="permission_table" class="table table-striped table-bordered table-hover dataTable" data-get_record_method="<?php echo url_for('sfGuardPermission/getPermissionByPermissionId'); ?>">
        	<thead>
            	<tr>
                	<th>Permission</th>
                	<th>Description</th>
                	<th>Created at</th>
            	</tr>
        	</thead>
        	<tbody>
            	<?php
            	foreach ($permissions as $permission) {
                	echo "<tr data-permission_id='" . $permission["id"] . "'><td>" . $permission["name"] . "</td>
                    	<td>" . $permission["description"] . "</td>
                    	<td>" . date('l\ d F, Y', strtotime($permission["created_at"])) . "</td>";
            	}
            	?>
        	</tbody>
    	</table>
	</div>
</div>
<script>
	var oTable;
	$(document).on("ready", permissionsBackend());
	function permissionsBackend() {
    	var oVPermissionName = new LiveValidation("sf_guard_permission_name", {
        	validMessage: " "
    	});
    	addValidatePresence(oVPermissionName, {
        	failureMessage: "Provide permission name"
    	});
    	oTable = fnInitiateDatatable(".table.table-striped.table-bordered.table-hover.dataTable");
    	$("#sf_guard_permission_users_list").chosen();
    	$("#sf_guard_permission_groups_list").chosen();
    	$("input[type=reset]").click(function() {
        	fnCleanPermissionForm();
        	return false;
    	});
//    	// seleccionar filas tabla de historico
    	$(".dataTable tbody").delegate('tr', 'click', function() {
        	var tr = $(this);
        	var oTr = $(tr).get(0);
        	removeSelectedRow();
        	tr.addClass("row_selected");
    	});
//
    	$("#permission_table tbody").on("click", function(event) {
        	$(oTable.fnSettings().aoData).each(function() {
            	$(this.nTr).removeClass("row_selected");
        	});
        	$(event.target.parentNode).addClass("row_selected");
        	var permission_id = $(event.target.parentNode).attr("data-permission_id");
        	if (typeof permission_id !== "undefined") {
            	$.ajax({
                	data: {"permission_id": permission_id},
                	dataType: "json",
                	error: function(oJsonData) {
                    	fnAddErrorNotify(oJsonData.message_list);
                	},
                	success: function(oJsonData) {
                    	if (oJsonData.message_list.length === 0) {
                        	fnFillFormFromPermissionObject(oJsonData.record);
                    	} else {
                        	for (var c = 0; c < oJsonData.message_list.length; c++) {
                            	fnAddErrorNotify(oJsonData.message_list[c]);
                        	}
                    	}
                	},
                	statusCode: fnStatusCodes(),
                	type: "post",
                	url: $("#permission_table").attr("data-get_record_method")
            	});
        	}
        	$('html, body').animate({
            	scrollTop: '0px'
        	}, 1500);
    	});
    	$("#newPermission").on("submit", function() {
        	$.ajax({
            	data: $("#newPermission").serialize(),
            	dataType: "json",
            	error: function(oJsonData) {
                	debugger;
                	if (undefined !== oJsonData.responseText) {
                    	fnAddErrorNotify("Un error inesperado sucedió, contactar al administrador.");
                    	console.log(oJsonData.responseText);
                	} else {
                    	fnAddErrorNotify(oJsonData.message_list);
                	}
            	},
            	success: function(oJsonData) {
                	debugger;
                	if (oJsonData.message_list.length === 0) {
                    	fnAddSuccessNotify("Group was saved successfully.");
                    	if (oJsonData.is_new) {
                        	$("#permission_table").dataTable().fnAddData([oJsonData.name, oJsonData.description, oJsonData.created_at]);
                        	var oRow = fnGetNewRowByCustomAttr(oTable, "data-permission_id", oJsonData.id);
                        	$(oRow).attr("data-permission_id", oJsonData.id);
                    	} else {
                        	var oRow = fnGetRowByCustomAttr(oTable, oJsonData.id, "data-permission_id");
                        	$(oRow).children().eq(0).html(oJsonData.name);
                        	$(oRow).children().eq(1).html(oJsonData.description);
                        	$(oRow).children().eq(2).html(oJsonData.created_at);
                    	}
                	} else {
                    	for (var i = 0; i < oJsonData.message_list.length; i++) {
                        	fnAddErrorNotify(oJsonData.message_list[i]);
                    	}
                	}
                	fnCleanPermissionForm();
            	},
            	statusCode: fnStatusCodes(),
            	type: "post",
            	url: $("#newPermission").attr("action")
        	});
        	return false;
    	});
	}
	function fnCleanPermissionForm() {
    	$(oTable.fnSettings().aoData).each(function() {
        	$(this.nTr).removeClass('row_selected');
    	});
    	$("#newPermission").find("input[type=text]").each(function() {
        	$(this).toggleClass("LV_invalid_field");
    	});
    	$("#newPermission").find("input[type=text], input[type=hidden], textarea").val("");
    	$('#sf_guard_permission_users_list option').prop('selected', false);
    	$('#sf_guard_permission_users_list').trigger('chosen:updated');
    	$('#sf_guard_permission_groups_list option').prop('selected', false);
    	$('#sf_guard_permission_groups_list').trigger('chosen:updated');
    	$(".LV_validation_message.LV_invalid").hide();
	}
	function fnFillFormFromPermissionObject(jsonObject) {
    	debugger;
    	fnCleanPermissionForm();
    	$("#sf_guard_permission_id").val(jsonObject.id);
    	$("#sf_guard_permission_name").val(jsonObject.name);
    	$("#sf_guard_permission_description").val(jsonObject.description);
    	if (typeof jsonObject.users_list !== "undefined") {
        	$("#sf_guard_permission_users_list option").each(function(index, element) {
            	$.each(jsonObject.users_list, function(i) {
                	if ($(element).val() == jsonObject.users_list[i]) {
                    	$(element).prop("selected", true);
                	}
            	});
        	});
        	$("#sf_guard_permission_users_list").trigger("chosen:updated");
    	}
    	if (typeof jsonObject.groups_list !== "undefined") {
        	$("#sf_guard_permission_groups_list option").each(function(index, element) {
            	$.each(jsonObject.groups_list, function(i) {
                	if ($(element).val() == jsonObject.groups_list[i]) {
                    	$(element).prop("selected", true);
                	}
            	});
        	});
        	$("#sf_guard_permission_groups_list").trigger("chosen:updated");
    	}

	}
</script>
