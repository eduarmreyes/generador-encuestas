<?php use_helper('I18N') ?>

<?php echo form_tag('@sf_guard_signin', 'class=form-signin form-horizontal') ?>
	<h1 class="form-signin-heading">Iniciar sesión | Seguridad</h1>
	<div class="control-group">
    	<label for="signin_username" class="control-label">Usuario: *</label>
    	<div class="controls">
        	<?php echo $form['username']->render() ?>
    	</div>
	</div>
	<div class="control-group">
    	<label for="signin_password" class="control-label">Contraseña: *</label>
    	<div class="controls">
        	<?php echo $form['password']->render() ?>
    	</div>
	</div>
	<div class="control-group">
		<label for="signin_remember" class="control-label">¿Mantener la sesión?</label>
		<div class="controls">
			<?php echo $form['remember']->render() ?>
		</div>
	</div>
	<div class="control-group">
    	<div class="controls">
        	<button type="submit" class="btn btn-primary" data-loading-text="Iniciando sesión...">
            	<?php echo __('Iniciar sesión') ?>
            	<i class="icon-circle-arrow-right"></i>
        	</button>
    	</div>
	</div>
	<div><span class="muted">El símbolo * significa que es requerido.</span></div>
	<?php if ($form['username']->hasError()) : ?>
    	<div class="row-fluid">
        	<div class="alert alert-error">
            	<button type="button" class="close" data-dismiss="alert">&times;</button>
            	<strong>¡Cuidado!</strong>
            	<?php echo $form['username']->renderError(); ?>
        	</div>
    	</div>
	<?php endif; ?>
</form>
