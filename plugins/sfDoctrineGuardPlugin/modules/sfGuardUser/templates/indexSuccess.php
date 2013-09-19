<?php
slot("user", "active");
?>
<div class="card">
    <h3 class="card-heading simple">New User</h3>
    <div class="card-body">
        <form id="newUser" class="form-horizontal" action="<?php echo url_for('sfGuardUser/doSave') ?>" method="post">
            <div class="row">
				<?php echo $form->renderHiddenFields(); ?>
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_email_address">Email: *</label>
                        <div class="controls">
							<?php echo $form["email_address"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_first_name">Name: *</label>
                        <div class="controls">
							<?php echo $form["first_name"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_last_name">Last Name: *</label>
                        <div class="controls">
							<?php echo $form["last_name"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_username">Windows Login: *</label>
                        <div class="controls" class="showTooltip" title="Your windows login">
							<?php echo $form["username"]; ?>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_is_active">Active: *</label>
                        <div class="controls">
							<?php echo $form["is_active"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_groups_list">Groups:</label>
                        <div class="controls">
							<?php echo $form["groups_list"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_permissions_list">Permissions:</label>
                        <div class="controls">
							<?php echo $form["permissions_list"]; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <input type="reset" class="btn" value="Reset">
                <input type="submit" class="btn btn-info" value="Save" data-loading-text="Saving New User..." >
            </div>
        </form>
    </div>
</div>
<div class="card">
    <h3 class="card-heading simple">Users List</h3>
    <div class="card-body">
        <table id="users_table" class="table table-striped table-bordered table-hover dataTable" data-get_record_method="<?php echo url_for('sfGuardUser/getUserByUserId'); ?>">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>User</th>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>Last Login</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
				<?php
				foreach ($users as $user) {
					echo "<tr data-user_id='" . $user["id"] . "'><td>" . $user["email_address"] . "</td>
                        <td>" . $user["username"] . "</td>
                        <td>" . $user["first_name"] . "</td>
                        <td>" . $user["last_name"] . "</td>
                        <td>" . date('l\ d F, Y', strtotime($user["last_login"])) . "</td>
                        <td>";
					echo ($user["is_active"] == 1) ? "<span class='badge badge-success'>Active</span>" : "<span class='badge'>Not Active</span>";
					echo "</td>";
				}
				?>
            </tbody>
        </table>
    </div>
</div>
<script>
	var oTable;
	$(document).on("ready", usersBackend());
	function usersBackend() {
		var oVVhur = new LiveValidation("sf_guard_user_vhur", {
			validMessage: " "
		});
		addValidatePresence(oVVhur, {
			failureMessage: "Provide user vhur"
		});
		addValidateNumber(oVVhur, {
			onlyInteger: true
		});
		var oVName = new LiveValidation("sf_guard_user_first_name", {
			validMessage: " "
		});
		addValidatePresence(oVName, {
			failureMessage: "Provide user name"
		});
		var oVLName = new LiveValidation("sf_guard_user_last_name", {
			validMessage: " "
		});
		addValidatePresence(oVLName, {
			failureMessage: "Provide the user last name"
		});
		var oVUsername = new LiveValidation("sf_guard_user_username", {
			validMessage: " "
		});
		addValidatePresence(oVUsername, {
			failureMessage: "Windows Login required"
		});
		oTable = fnInitiateDatatable(".table.table-striped.table-bordered.table-hover.dataTable");
		$("#sf_guard_user_team_captain_id").chosen({
			allow_single_deselect: true
		});
		$("#sf_guard_user_groups_list").chosen();
		$("#sf_guard_user_permissions_list").chosen();
		$("input[type=reset]").click(function() {
			fnCleanUserForm();
			return false;
		});
		// seleccionar filas tabla de historico
		$(".dataTable tbody").delegate('tr', 'click', function() {
			var tr = $(this);
			var oTr = $(tr).get(0);
			removeSelectedRow();
			tr.addClass("row_selected");
		});

		$("#users_table tbody").on("click", function(event) {
			$(oTable.fnSettings().aoData).each(function() {
				$(this.nTr).removeClass("row_selected");
			});
			$(event.target.parentNode).addClass("row_selected");
			var user_id = $(event.target.parentNode).attr("data-user_id");
			if (typeof user_id !== "undefined") {
				$.ajax({
					data: {"user_id": user_id},
					dataType: "json",
					error: function(oJsonData) {
						fnAddErrorNotify(oJsonData.message_list);
					},
					success: function(oJsonData) {
						if (oJsonData.message_list.length === 0) {
							fnFillFormFromUserObject(oJsonData.record);
						} else {
							for (var c = 0; c < oJsonData.message_list.length; c++) {
								fnAddErrorNotify(oJsonData.message_list[c]);
							}
						}
					},
					statusCode: fnStatusCodes(),
					type: "post",
					url: $("#users_table").attr("data-get_record_method")
				});
			}
			$('html, body').animate({
				scrollTop: '0px'
			}, 1500);
		});
		$("#newUser").on("submit", function() {
			$.ajax({
				data: $("#newUser").serialize(),
				dataType: "json",
				error: function(oJsonData) {
					debugger;
					if (undefined !== oJsonData.responseText) {
						fnAddErrorNotify("An unexpected error has occurred, please contact the administrator");
						console.log(oJsonData.responseText);
					} else {
						fnAddErrorNotify(oJsonData.message_list);
					}
					$(".btn.btn-info-purple").button("reset");
				},
				success: function(oJsonData) {
					debugger;
					if (oJsonData.message_list.length === 0) {
						fnAddSuccessNotify("User was saved successfully.");
						if (oJsonData.is_active === "Yes") {
							is_active = '<span class="badge badge-success">Active</span>';
						} else {
							is_active = '<span class="badge">Not Active</span>';
						}
						if (oJsonData.is_new) {
							$("#users_table").dataTable().fnAddData([oJsonData.vhur, oJsonData.username, oJsonData.first_name, oJsonData.last_name, oJsonData.last_login, is_active]);
							var oRow = fnGetNewRowByCustomAttr(oTable, "data-user_id", oJsonData.id);
							$(oRow).attr("data-user_id", oJsonData.id);
						} else {
							var oRow = fnGetRowByCustomAttr(oTable, oJsonData.id, "data-user_id");
							$(oRow).children().eq(0).html(oJsonData.vhur);
							$(oRow).children().eq(1).html(oJsonData.username);
							$(oRow).children().eq(2).html(oJsonData.first_name);
							$(oRow).children().eq(3).html(oJsonData.last_name);
							$(oRow).children().eq(4).html(oJsonData.last_login);
							$(oRow).children().eq(5).html(is_active);
						}
					} else {
						for (var i = 0; i < oJsonData.message_list.length; i++) {
							fnAddErrorNotify(oJsonData.message_list[0]);
						}
					}
					fnCleanUserForm();
					$(".btn.btn-info-purple").button("reset");
				},
				statusCode: fnStatusCodes(),
				type: "post",
				url: $("#newUser").attr("action")
			});
			return false;
		});
	}
	function fnCleanUserForm() {
		$(oTable.fnSettings().aoData).each(function() {
			$(this.nTr).removeClass('row_selected');
		});
		$("#newUser").find("input[type=text]").each(function() {
			$(this).toggleClass("LV_invalid_field");
		});
		$("#sf_guard_user_is_active").prop("checked", true);
		$("#newUser").find("input[type=text], input[type=hidden]").val("");
		$('#sf_guard_user_groups_list option').prop('selected', false);
		$('#sf_guard_user_groups_list').trigger('chosen:updated');
		$('#sf_guard_user_permissions_list option').prop('selected', false);
		$("#sf_guard_user_permissions_list").trigger("chosen:updated");
		$("#sf_guard_user_team_captain_id").val("");
		$("#sf_guard_user_team_captain_id").trigger("chosen:updated");
		$(".LV_validation_message.LV_invalid").hide();
	}
	function fnFillFormFromUserObject(jsonObject) {
		debugger;
		fnCleanUserForm();
		$("#sf_guard_user_vhur").val(jsonObject.vhur);
		$("#sf_guard_user_id").val(jsonObject.id);
		$("#sf_guard_user_is_active").prop("checked", jsonObject.is_active === true);
		$("#sf_guard_user_first_name").val(jsonObject.first_name);
		$("#sf_guard_user_last_name").val(jsonObject.last_name);
		$("#sf_guard_user_username").val(jsonObject.username);
		if (typeof jsonObject.team_captain_id === "undefined" || jsonObject.team_captain_id === null) {
			$("#sf_guard_user_team_captain_id").val("");
			$("#sf_guard_user_team_captain_id").trigger("chosen:updated");
		} else {
			$.each($("#sf_guard_user_team_captain_id option"), function() {
				if ($(this).val() == jsonObject.team_captain_id) {
					$(this).prop("selected", true);
					$("#sf_guard_user_team_captain_id").trigger("chosen:updated");
				}
			});
		}
		if (typeof  jsonObject.groups_list !== "undefined") {
			$("#sf_guard_user_groups_list option").each(function(index, element) {
				$.each(jsonObject.groups_list, function(i) {
					if ($(element).val() == jsonObject.groups_list[i]) {
						$(element).prop("selected", true);
					}
				});
			});
			$("#sf_guard_user_groups_list").trigger("chosen:updated");
		}
		if (typeof  jsonObject.permissions_list !== "undefined") {
			$("#sf_guard_user_permissions_list option").each(function(index, element) {
				$.each(jsonObject.permissions_list, function(i) {
					if ($(element).val() == jsonObject.permissions_list[i]) {
						$(element).prop("selected", true);
					}
				});
			});
			$("#sf_guard_user_permissions_list").trigger("chosen:updated");
		}
	}
</script>
