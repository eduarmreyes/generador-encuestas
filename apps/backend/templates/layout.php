<!doctype html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<?php include_http_metas() ?>
		<?php include_metas() ?>
		<?php include_title() ?>
		<link rel="icon" type="image/jpg" href="<?php echo image_path("favicon.ico"); ?>" />
		<?php include_stylesheets() ?>
		<style type="text/css">
			/* Sticky footer styles
			-------------------------------------------------- */

			html,
			body {
				height: 100%;
				background-color: #e5e5e5
					/* The html and body elements cannot have any padding or margin. */
			}

			/* Wrapper for page content to push down footer */
			#wrap {
				min-height: 100%;
				height: auto !important;
				height: 100%;
				/* Negative indent footer by it's height */
				margin: 0 auto -60px;
			}

			/* Set the fixed height of the footer here */
			#push,
			#footer {
				height: 60px;
			}
			#footer {
				background-color: #f5f5f5;
			}

			/* Lastly, apply responsive CSS fixes as necessary */
			@media (max-width: 767px) {
				#footer {
					margin-left: -20px;
					margin-right: -20px;
					padding-left: 20px;
					padding-right: 20px;
				}
			}
			/* Custom page CSS
			-------------------------------------------------- */
			#wrap > .container {
				padding-top: 60px;
			}
			.brand > img {
				width: 141px;
			}
			.container .credit {
				margin: 20px 0;
			}
			.form-signin {
				border: 1px solid #D8D8D8;
				border-bottom-width: 2px;
				border-top-width: 0;
				background-color: #FFF;
				max-width: 400px;
				min-width: 330px;
				padding: 19px 29px 29px;
				margin: 40px auto 20px;
				background-color: #fff;
				border: 1px solid #F5F5F5;
				-webkit-border-radius: 3px;
				-moz-border-radius: 3px;
				border-radius: 3px;
			}
			.form-signin .form-signin-heading {
				font-size: 24px;
				font-weight: 300;
			}
		</style>
		<!--[if IE 7]>
		<?php echo stylesheet_tag('/css/vendor/font-awesome-ie7.min.css') ?>
		<![endif]-->
		<?php include_javascripts() ?>
	</head>
	<body>
		<!-- Part 1: Wrap all page content here -->
		<div id="wrap">

			<!-- Fixed navbar -->
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="#"><?php echo image_tag('rochi-logo.jpg') ?></a>
						<div class="span3" style="margin-top:1em;">
							<span><?php echo utf8_encode(strftime("%A %d de %B del %Y")); ?></span>
						</div>
						<div class="pull-right" style="margin: 1em 2em 0 0;">
							<span class="logout">
								<a href="<?php echo url_for("sfGuardAuth/signout"); ?>" title="Cerrar sesión"><?php echo $sf_user; ?></a>
							</span>
						</div>
					</div>
                	<?php
                	/* Get menu options from MenuManager.php */
                	$menu = new MenuManager();
                	$mainMenu = $menu->getMainMenu("backend", sfContext::getInstance()->getUser()->getCredentials());
                	// $subMenu = $menu->getSecondaryMenu("frontend", include_slot("main_menu_option"));
                	?>
                	<div class="container">
                    	<div class="row">
                        	<div class="nav-collapse collapse" style="height: 0px;">
                            	<ul class="nav">
                                	<?php
                                	$selected = "active";
                                	$hasChild = "dropdown";
                                	foreach ($mainMenu as $option) { ?>
                                	<li class="<?php if (get_slot('main_menu_option') == $option['group']) { echo $selected; }?> <?php if ($option["hasChild"]) { echo $hasChild; } ?>">
                                        	<?php if ($option["hasChild"]) { ?>
                                        	<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $option["link_title"] ?><b class="caret"></b></a>
                                            	<?php if (count($option['options']) > 0) { ?>
                                                	<ul class="dropdown-menu">
                                                    	<?php foreach ($option['options'] as $opt) { ?>
                                                    	<li class="<?php if (get_slot('catalog_admin_active') == $opt['group']) { echo $selected; } ?>">
                                                        	<a href="<?php echo url_for($opt['module'] . '/' . $opt['action']); ?>"><?php echo $opt['link_title']; ?></a>
                                                    	</li>
                                                    	<?php } ?>
                                                	</ul>
                                            	<?php } ?>
                                        	<?php } else { ?>
                                            	<a href="<?php echo url_for($option['module'] . '/' . $option['action']); ?>"><?php echo $option['link_title']; ?></a>
                                        	<?php } ?>
                                    	</li>
                                	<?php } ?>
                            	</ul>
                        	</div><!--/.nav-collapse -->
                    	</div>
                	</div>
            	</div>
        	</div>

			<!-- Begin page content -->
			<div class="container">
				<?php echo $sf_content ?>
			</div>       	 
			<div id="push"></div>
		</div>

		<div id="footer">
			<div class="container">
				<p class="muted credit">All Right Reserved © <?php echo date('Y') ?> Rochi Consulting <?php echo date("Y") ?> - Developed by Eduardo Mejía & Carlos Monge.</p>
			</div>
		</div>
		<script>
			$(document).on("ready", function(){
				fnShowTooltip(".logout > a", "left");
			});
		</script>
	</body>
</html>
