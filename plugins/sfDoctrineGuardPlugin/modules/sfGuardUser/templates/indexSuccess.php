<?php
slot("user", "active");
?>
<div class="card">
    <h3 class="card-heading simple">Usuario Nuevo</h3>
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
                        <label class="control-label" for="sf_guard_user_first_name">Nombre: *</label>
                        <div class="controls">
							<?php echo $form["first_name"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_last_name">Apellido: *</label>
                        <div class="controls">
							<?php echo $form["last_name"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_username">Usuario: *</label>
                        <div class="controls" class="showTooltip" title="Usuario para ingresar a la herramienta.">
							<?php echo $form["username"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_password">Contraseña: *</label>
                        <div class="controls" class="showTooltip" title="Contraseña que desea usar">
							<?php echo $form["password"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_password_again">Confirmar contraseña: *</label>
                        <div class="controls" class="showTooltip" title="Confirmar contraseña.">
							<?php echo $form["password_again"]; ?>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_is_active">Activo: </label>
                        <div class="controls">
							<?php echo $form["is_active"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="">Guider: </label>
                        <div class="controls">
							<?php echo $user_conf["usc_guider"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_groups_list">Grupos:</label>
                        <div class="controls">
							<?php echo $form["groups_list"]; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sf_guard_user_permissions_list">Permisos:</label>
                        <div class="controls">
							<?php echo $form["permissions_list"]; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" class="btn btn-info" data-toggle="loading" value="Guardar" data-loading-text="Guardando Usuario..." >
                <input type="reset" class="btn" value="Reset">
            </div>
        </form>
    </div>
</div>
<div class="card">
    <h3 class="card-heading simple">Lista de Usuarios</h3>
    <div class="card-body">
        <table id="users_table" class="table table-striped table-bordered table-hover dataTable" data-get_record_method="<?php echo url_for('sfGuardUser/getUserByUserId'); ?>">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Última sesión iniciada</th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>
				<?php
				foreach ($users as $user) {
					echo "<tr data-user_id='" . $user["id"] . "'><td>" . $user["email_address"] . "</td>
                        <td>" . $user["username"] . "</td>
                        <td>" . $user["first_name"] . "</td>
                        <td>" . $user["last_name"] . "</td>
                        <td>" . strftime("%A %d de %B del %Y", strtotime(trim($user["last_login"]))) . "</td>
                        <td>";
					echo ($user["is_active"] == 1) ? "<span class='badge badge-success'>Activo</span>" : "<span class='badge'>No activo</span>";
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
		$("input[type=checkbox]").switchButton({
			labels_placement: "right",
			on_label: "sí",
			off_label: "no"
		});
		var oVName = new LiveValidation("sf_guard_user_first_name", {
			validMessage: " "
		});
		addValidatePresence(oVName, {
			failureMessage: "Falta su nombre"
		});
		var oVEmail = new LiveValidation("sf_guard_user_email_address", {
			validMessage: " "
		});
		addValidatePresence(oVEmail, {
			failureMessage: "Email requerido"
		});
		addValidateEmail(oVEmail, {
			failureMessage: "Email debe ser válido"
		});
		var oVLName = new LiveValidation("sf_guard_user_last_name", {
			validMessage: " "
		});
		addValidatePresence(oVLName, {
			failureMessage: "Su apellido falta"
		});
		var oVUsername = new LiveValidation("sf_guard_user_username", {
			validMessage: " "
		});
		addValidatePresence(oVUsername, {
			failureMessage: "Usuario es requerido"
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
			Pace.restart();
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
							fnCleanUserForm();
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
			Pace.restart();
			$.ajax({
				data: $("#newUser").serialize(),
				dataType: "json",
				error: function(oJsonData) {
					if (undefined !== oJsonData.responseText) {
						fnAddErrorNotify("Un error inesperado sucedió, contactar al administrador");
						console.log(oJsonData.responseText);
					} else {
						fnAddErrorNotify(oJsonData.message_list);
					}
					$(".btn.btn-info").button("reset");
				},
				success: function(oJsonData) {
					if (oJsonData.message_list.length === 0) {
						fnAddSuccessNotify("Usuario guardado.");
						if (oJsonData.is_active === "Yes") {
							is_active = '<span class="badge badge-success">Activo</span>';
						} else {
							is_active = '<span class="badge">No Activo</span>';
						}
						if (oJsonData.is_new) {
							$("#users_table").dataTable().fnAddData([oJsonData.email_address, oJsonData.username, oJsonData.first_name, oJsonData.last_name, oJsonData.last_login, is_active]);
							var oRow = fnGetNewRowByCustomAttr(oTable, "data-user_id", oJsonData.id);
							$(oRow).attr("data-user_id", oJsonData.id);
						} else {
							var oRow = fnGetRowByCustomAttr(oTable, oJsonData.id, "data-user_id");
							$(oRow).children().eq(0).html(oJsonData.email_address);
							$(oRow).children().eq(1).html(oJsonData.username);
							$(oRow).children().eq(2).html(oJsonData.first_name);
							$(oRow).children().eq(3).html(oJsonData.last_name);
							$(oRow).children().eq(4).html(oJsonData.last_login);
							$(oRow).children().eq(5).html(is_active);
						}
						fnCleanUserForm();
					} else {
						for (var i = 0; i < oJsonData.message_list.length; i++) {
							fnAddErrorNotify(oJsonData.message_list[i]);
						}
					}
					$(".btn.btn-info").button("reset");
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
		$("input[type=checkbox]").switchButton({
			checked: true
		});
		$("#newUser").find("input[type=text], input[type=hidden], input[type=password]").val("");
		$('#sf_guard_user_groups_list option').prop('selected', false);
		$('#sf_guard_user_groups_list').trigger('chosen:updated');
		$('#sf_guard_user_permissions_list option').prop('selected', false);
		$("#sf_guard_user_permissions_list").trigger("chosen:updated");
		$("#sf_guard_user_team_captain_id").val("");
		$("#sf_guard_user_team_captain_id").trigger("chosen:updated");
		$(".LV_validation_message.LV_invalid").hide();
	}
	function fnFillFormFromUserObject(jsonObject) {
		fnCleanUserForm();
		$("#sf_guard_user_id").val(jsonObject.id);
		$("#sf_guard_user_is_active").prop("checked", jsonObject.is_active === true);
		$("#cen_usuario_configuracion_usc_guider").prop("checked", jsonObject.guider === true);
		$("#sf_guard_user_is_active").switchButton({
			checked: jsonObject.is_active === true
		});
		$("#cen_usuario_configuracion_usc_guider").switchButton({
			checked: jsonObject.guider === true
		});
		$("#sf_guard_user_first_name").val(jsonObject.first_name);
		$("#sf_guard_user_last_name").val(jsonObject.last_name);
		$("#sf_guard_user_username").val(jsonObject.username);
		$("#sf_guard_user_email_address").val(jsonObject.email_address);
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
