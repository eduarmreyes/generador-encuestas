<?php
slot("admin_active", "active");
slot("group", "active");
?>
<div class="card">
	<h3 class="card-heading simple">New Group</h3>
	<div class="card-body">
    	<form id="newGroup" class="form-horizontal" action="<?php echo url_for('sfGuardGroup/doSave') ?>" method="post">
        	<div class="row">
            	<?php echo $form->renderHiddenFields(); ?>
            	<div class="span5">
                	<div class="control-group">
                    	<label class="control-label" for="sf_guard_group_name">Group Name: *</label>
                    	<div class="controls">
                        	<?php echo $form["name"]; ?>
                    	</div>
                	</div>
                	<div class="control-group">
                    	<label class="control-label" for="sf_guard_group_description">Description: </label>
                    	<div class="controls">
                        	<?php echo $form["description"]; ?>
                    	</div>
                	</div>
				</div>
				<div class="span6">
                	<div class="control-group">
                    	<label class="control-label" for="sf_guard_group_users_list">Users List:</label>
                    	<div class="controls">
                        	<?php echo $form["users_list"]; ?>
                    	</div>
                	</div>
                	<div class="control-group">
                    	<label class="control-label" for="sf_guard_group_permissions_list">Permissions List:</label>
                    	<div class="controls">
                        	<?php echo $form["permissions_list"]; ?>
                    	</div>
                	</div>
            	</div>
        	</div>
        	<div class="form-actions">
            	<input type="submit" class="btn btn-info" value="Save" data-loading-text="Saving New Group..." >
            	<input type="reset" class="btn" value="Reset">
        	</div>
    	</form>
	</div>
</div>
<div class="card">
	<h3 class="card-heading simple">Group List</h3>
	<div class="card-body">
    	<table id="group_table" class="table table-striped table-bordered table-hover dataTable" data-get_record_method="<?php echo url_for('sfGuardGroup/getGroupByGroupId'); ?>">
        	<thead>
            	<tr>
                	<th>Group</th>
                	<th>Description</th>
                	<th>Created at</th>
            	</tr>
        	</thead>
        	<tbody>
            	<?php
            	foreach ($groups as $group) {
                	echo "<tr data-group_id='" . $group["id"] . "'><td>" . $group["name"] . "</td>
                    	<td>" . $group["description"] . "</td>
                    	<td>" . date('l\ d F, Y', strtotime($group["created_at"])) . "</td>";
            	}
            	?>
        	</tbody>
    	</table>
	</div>
</div>
<script>
	var oTable;
	$(document).on("ready", groupsBackend());
	function groupsBackend() {
    	var oVGroupName = new LiveValidation("sf_guard_group_name", {
        	validMessage: " "
    	});
    	addValidatePresence(oVGroupName, {
        	failureMessage: "Provide group name"
    	});
    	oTable = fnInitiateDatatable(".table.table-striped.table-bordered.table-hover.dataTable");
    	$("#sf_guard_group_users_list").chosen();
    	$("#sf_guard_group_permissions_list").chosen();
    	$("input[type=reset]").click(function() {
        	fnCleanGroupForm();
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
    	$("#group_table tbody").on("click", function(event) {
        	$(oTable.fnSettings().aoData).each(function() {
            	$(this.nTr).removeClass("row_selected");
        	});
        	$(event.target.parentNode).addClass("row_selected");
        	var group_id = $(event.target.parentNode).attr("data-group_id");
        	if (typeof group_id !== "undefined") {
            	$.ajax({
                	data: {"group_id": group_id},
                	dataType: "json",
                	error: function(oJsonData) {
                    	fnAddErrorNotify(oJsonData.message_list);
                	},
                	success: function(oJsonData) {
                    	if (oJsonData.message_list.length === 0) {
                        	fnFillFormFromGroupObject(oJsonData.record);
                    	} else {
                        	for (var c = 0; c < oJsonData.message_list.length; c++) {
                            	fnAddErrorNotify(oJsonData.message_list[c]);
                        	}
                    	}
                	},
                	statusCode: fnStatusCodes(),
                	type: "post",
                	url: $("#group_table").attr("data-get_record_method")
            	});
        	}
        	$('html, body').animate({
            	scrollTop: '0px'
        	}, 1500);
    	});
    	$("#newGroup").on("submit", function() {
        	$.ajax({
            	data: $("#newGroup").serialize(),
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
                        	$("#group_table").dataTable().fnAddData([oJsonData.name, oJsonData.description, oJsonData.created_at]);
                        	var oRow = fnGetNewRowByCustomAttr(oTable, "data-group_id", oJsonData.id);
                        	$(oRow).attr("data-group_id", oJsonData.id);
                    	} else {
                        	var oRow = fnGetRowByCustomAttr(oTable, oJsonData.id, "data-group_id");
                        	$(oRow).children().eq(0).html(oJsonData.name);
                        	$(oRow).children().eq(1).html(oJsonData.description);
                        	$(oRow).children().eq(2).html(oJsonData.created_at);
                    	}
                	} else {
                    	for (var i = 0; i < oJsonData.message_list.length; i++) {
                        	fnAddErrorNotify(oJsonData.message_list[i]);
                    	}
                	}
                	fnCleanGroupForm();
            	},
            	statusCode: fnStatusCodes(),
            	type: "post",
            	url: $("#newGroup").attr("action")
        	});
        	return false;
    	});
	}
	function fnCleanGroupForm() {
    	$(oTable.fnSettings().aoData).each(function() {
        	$(this.nTr).removeClass('row_selected');
    	});
    	$("#newGroup").find("input[type=text]").each(function() {
        	$(this).toggleClass("LV_invalid_field");
    	});
    	$("#newGroup").find("input[type=text], input[type=hidden], textarea").val("");
    	$('#sf_guard_group_users_list option').prop('selected', false);
    	$('#sf_guard_group_users_list').trigger('chosen:updated');
    	$('#sf_guard_group_permissions_list option').prop('selected', false);
    	$('#sf_guard_group_permissions_list').trigger('chosen:updated');
    	$(".LV_validation_message.LV_invalid").hide();
	}
	function fnFillFormFromGroupObject(jsonObject) {
    	debugger;
    	fnCleanGroupForm();
    	$("#sf_guard_group_id").val(jsonObject.id);
    	$("#sf_guard_group_name").val(jsonObject.name);
    	$("#sf_guard_group_description").val(jsonObject.description);
    	if (typeof jsonObject.users_list !== "undefined") {
        	$("#sf_guard_group_users_list option").each(function(index, element) {
            	$.each(jsonObject.users_list, function(i) {
                	if ($(element).val() == jsonObject.users_list[i]) {
                    	$(element).prop("selected", true);
                	}
            	});
        	});
        	$("#sf_guard_group_users_list").trigger("chosen:updated");
    	}
    	if (typeof jsonObject.permissions_list !== "undefined") {
        	$("#sf_guard_group_permissions_list option").each(function(index, element) {
            	$.each(jsonObject.permissions_list, function(i) {
                	if ($(element).val() == jsonObject.permissions_list[i]) {
                    	$(element).prop("selected", true);
                	}
            	});
        	});
        	$("#sf_guard_group_permissions_list").trigger("chosen:updated");
    	}

	}
</script>
