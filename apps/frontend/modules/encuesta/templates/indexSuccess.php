<?php
use_stylesheet("vendor/bootstrap-wizard.css");
use_stylesheet("vendor/chosen.min.css");
use_javascript("vendor/bootstrap-wizard.min.js");
use_javascript("vendor/chosen.jquery.min.js");
use_javascript("vendor/jquery-ui-1.10.3.custom.min.js");
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
	#lista_preguntas_configuradas > li {
		/*background: #fff;*/
	}

	.wizard-modal .chzn-container .chzn-results {
		max-height:150px;
	}
	.wizard-addl-subsection {
		margin-bottom:40px;
	}
	.drop-area.ui-sortable {
		margin: 0;
		overflow: hidden;
		width: 100% !important;
	}
	.drop-area.ui-sortable > li {
		width: 99%;
	}
	.drop-area > li {
		background: #fff;
	}
	.drop-area.ui-sortable > li > div {
		margin-top: 0.7em;
	}
	.pregunta {
		display: inline-block;
		margin: auto 5px 5px auto;
		width: 10em;
		background: #ddd;
		padding: 10px;
		border-radius: 2px;
		border: 1px solid #b1b1b1;
		border-bottom: 1px solid #a5a5a5;
		border-top: 1px solid #cfcfcf;
		cursor: pointer;
	}
</style>
<div class="wizard" id="some-wizard">
    <h1>Crear nueva encuesta</h1>
    <div class="wizard-card form-horizontal" data-cardname="enc_categoria">
		<h3>Categorías</h3>
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
        <h3>Encuesta</h3>
		<ul id="categorias_panel" class="nav nav-pills">
			<li class="active"><a href="#DatosDeClasificacion" data-toggle="tab">Datos de clasificación</a></li>
		</ul>
		<div id="tab-content" class="tab-content">
			<div class="tab-pane active" id="DatosDeClasificacion">
				<ul id="lista_preguntas_configuradas" class="drop-area ui-sortable">
					<li>
						<div>Other options</div>
					</li>
					<li class="drag-here ui-droppable small" style="display: block;">
						<div>Arrastra y suelta las preguntas aquí</div>
					</li>
				</ul>
				<div style="position: absolute;">
					<ul id="lista_preguntas">
						<li class="pregunta">
							<div>Respuesta corta</div>
						</li>
						<li class="pregunta">
							<div>Varias respuestas</div>
						</li>
						<li class="pregunta">
							<div>Respuesas largas</div>
						</li>
						<li class="pregunta">
							<div>Sí / No</div>
						</li>
						<li class="pregunta">
							<div>Desplegable</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
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
		// Encuesta
		$("#categoria_id").chosen({
			no_results_text: "No se encontró ninguna categoría",
			width: "20em",
		});
		fnGetCategories("#categoria_id");
		/*
		 * JS Code to handle sortable lists
		 */
		$("#lista_preguntas, #lista_preguntas_configuradas").sortable({
			connectWith: ".drop-area",
			cursor: "move",
			forcePlaceholderSize: true,
			helper: "clone",
			opacity: 0.7
		});

		$("#lista_preguntas, #lista_preguntas_configuradas").disableSelection();
		$(function() {
			var wizard = fnInitiateWizard("#some-wizard");
			wizard.cards["enc_categoria"].on("validate", function(card) {
				var input = card.el.find("select");
				var name = input.val();
				if (name === "" || name === null) {
					fnAddWarningNotify("Seleccione la categoría antes de seguir");
					return false;
				}
				$("#categoria_id>option:selected").each(function() {
					var sPanelOption = "<li><a href='#" + $(this).text().split(" ").join("_") + "' data-toggle='tab'>" + $(this).text() + "</a></li>";
					var sTabContent = "<div class='tab-pane' id='" + $(this).text().split(" ").join("_") + "'></div>";
					$("#categorias_panel").append(sPanelOption);
					$("#tab-content").append(sTabContent);
				});
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
