<?php
use_stylesheet("vendor/bootstrap-wizard.css");
use_stylesheet("vendor/chosen.min.css");
use_javascript("vendor/bootstrap-wizard.min.js");
use_javascript("vendor/chosen.jquery.min.js");
?>
<style type="text/css">
	.wizard-modal p {
		margin: 0 0 10px;
		padding: 0;
	}

	#wizard-ns-detail-servers, .wizard-additional-servers {
		font-size:12px;
		margin-top:10px;
		margin-left:15px;
	}
	#wizard-ns-detail-servers > li, .wizard-additional-servers li {
		line-height:20px;
		list-style-type:none;
	}
	#wizard-ns-detail-servers > li > img {
		padding-right:5px;
	}

	.wizard-modal .chzn-container .chzn-results {
		max-height:150px;
	}
	.wizard-addl-subsection {
		margin-bottom:40px;
	}
</style>
<div class="wizard" id="some-wizard">
    <h1>Crear nueva encuesta</h1>
    <div class="wizard-card form-horizontal" data-cardname="enc_categoria">
		<h3>Seleccione o cree la categoría de la encuesta</h3>
		<div class="alert alert-info">
			Para crear una nueva categoría, dar click sobre el ícono <i class="icon-plus"></i>
		</div>
		<div class="control-group">
			<label for="categoria_id" class="control-label">Categoría: *</label>
			<div class="controls">
				<select name="categoria[cat_id]" id="categoria_id" data-placeholder="Seleccione una categoría" data-get_method="<?php echo url_for("categoria/getAll"); ?>" multiple>
				</select>
				<a id="addNewCategory" class="link_unstyled" href="#!NuevaCategoria" data-placement="left" data-title="Nueva categoría" data-new-category-url="<?php echo url_for("categoria/nuevo"); ?>" alt="Agregar otra categoría">
					<i style="margin-left: 3px;" class="icon-plus"></i>
				</a>
			</div>
		</div>
    </div>
    <div class="wizard-card" data-cardname="enc_datos_clasificacion">
        <h3>Datos de Clasificación</h3>
		<ul class="nav nav-tabs">
			<li><a href="#home" data-toggle="tab">Home</a></li>
			<li><a href="#profile" data-toggle="tab">Profile</a></li>
			<li><a href="#messages" data-toggle="tab">Messages</a></li>
			<li><a href="#settings" data-toggle="tab">Settings</a></li>
		</ul>    </div>
    <div class="wizard-card" data-cardname="enc_encuesta">
        <h3>Formularios de encuestas</h3>
        Some other content
    </div>
</div>
<script type="text/javascript">
	$(document).on("ready", fnGeneradorEncuestas);
	function fnGeneradorEncuestas() {
		$("#addNewCategory").popover({
			content: '<div><label for="categoria_cat_es_datos_clasificacion" style="display: inline-block; margin: 5px; vertical-align: middle;">Datos de clasificacion</label><?php echo $categoria["cat_es_datos_clasificacion"]; ?></div><div><?php echo $categoria["cat_nombre"]; ?></div>',
			html: true
		});
		// Send focus to the new category input
		$("#addNewCategory").on("shown", function() {
			$("#categoria_cat_es_datos_clasificacion").prop("checked", false);
			$("#categoria_cat_nombre").focus();
		});
		// $(document).on is like .live()
		$(document).on("keyup", "#categoria_cat_nombre", function(e) {
			if (!e)
				e = window.event;
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) {
				var category = $("#categoria_cat_nombre").val();
				if (category !== "") {
					Pace.restart();
					$.ajax({
						data: {
							"categoria[cat_nombre]": category,
							"categoria[cat_es_datos_clasificacion]": $("#categoria_cat_es_datos_clasificacion").val()
						},
						dataType: "json",
						error: function(oJsonData) {
							if (undefined !== oJsonData.responseText) {
								fnAddErrorNotify("Un error inesperado sucedió, contactar al administrador");
								console.log(oJsonData.responseText);
							} else {
								fnAddErrorNotify(oJsonData.message_list);
							}
							Pace.stop();
						},
						statusCode: fnStatusCodes(),
						success: function(oJsonData) {
							if (oJsonData.message_list.length === 0) {
								fnGetCategories("#categoria_id");
								$("#categoria_cat_nombre").val("");
								$("#addNewCategory").popover("hide");
								fnAddSuccessNotify("Categoría guardada.");
							} else {
								for (var i = 0; i < oJsonData.message_list.length; i++) {
									fnAddErrorNotify(oJsonData.message_list[i]);
								}
							}
							Pace.stop();
						},
						type: "post",
						url: $("#addNewCategory").attr("data-new-category-url")
					});
				} else {
					fnAddWarningNotify("Falta el nombre de la categoría");
				}
			}
		});
		$("#categoria_id").chosen({
			no_results_text: "No se encontró ninguna categoría",
			width: "20em",
		});
		fnGetCategories("#categoria_id");
		$(function() {
			var wizard = fnInitiateWizard("#some-wizard");
			wizard.cards["enc_categoria"].on("validate", function(card) {
				var input = card.el.find("select");
				var name = input.val();
				if (name === "" || name === null) {
					fnAddWarningNotify("Seleccione la categoría antes de seguir");
					return false;
				}
				return true;
			});
			wizard.show();
			$(".wizard-modal").on("hidden", function() {
				console.log("escondió");
			});
		});
		fnShowTooltip("#addNewCategory", "left");
		// Functions
		function fnGetCategories(cssSelector) {
			$(cssSelector + " > option").html("");
			Pace.restart();
			$.ajax({
				data: {"category": $(cssSelector).val()},
				dataType: "json",
				error: function(oJsonData) {
					if (undefined !== oJsonData.responseText) {
						fnAddErrorNotify("Un error inesperado sucedió, contactar al administrador");
						console.log(oJsonData.responseText);
					} else {
						fnAddErrorNotify(oJsonData.message_list);
					}
					Pace.stop();
				},
				statusCode: fnStatusCodes(),
				success: function(oJsonData) {
					$(oJsonData.record).each(function() {
						var sOption = "<option value='" + this.cat_id + "'>" + this.cat_nombre + "</option>";
						$(cssSelector).append(sOption);
					});
					$(cssSelector).trigger("chosen:updated");
					Pace.stop();
				},
				type: "post",
				url: $(cssSelector).attr("data-get_method")
			});
		}
	}
</script>
