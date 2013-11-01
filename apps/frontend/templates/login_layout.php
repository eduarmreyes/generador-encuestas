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
							<span><?php echo strftime("%A %d de %B del %Y"); ?></span>
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
