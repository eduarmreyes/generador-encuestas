<!doctype html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta charset="utf-8" />
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
				background-color: rgba(0,151,218,0.7);
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
	</head>
	<body>
		<!-- Part 1: Wrap all page content here -->
		<div id="wrap">

			<!-- Fixed navbar -->
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="#"><?php echo image_tag('rochi-logo.jpg') ?></a>
						<div style="margin-top:1em;">
							<span><?php echo date('d/m/Y'); ?></span>

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
		<?php include_javascripts() ?>
		<script>
			$(document).on("ready", fnLoginLayout());
		</script>
	</body>
</html>
