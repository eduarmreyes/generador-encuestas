<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('encuesta/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?enc_id='.$form->getObject()->getEncId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('encuesta/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'encuesta/delete?enc_id='.$form->getObject()->getEncId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['enc_nombre']->renderLabel() ?></th>
        <td>
          <?php echo $form['enc_nombre']->renderError() ?>
          <?php echo $form['enc_nombre'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['enc_descripcion']->renderLabel() ?></th>
        <td>
          <?php echo $form['enc_descripcion']->renderError() ?>
          <?php echo $form['enc_descripcion'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['enc_fecha_creacion']->renderLabel() ?></th>
        <td>
          <?php echo $form['enc_fecha_creacion']->renderError() ?>
          <?php echo $form['enc_fecha_creacion'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['enc_creado_por']->renderLabel() ?></th>
        <td>
          <?php echo $form['enc_creado_por']->renderError() ?>
          <?php echo $form['enc_creado_por'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['enc_fecha_modificacion']->renderLabel() ?></th>
        <td>
          <?php echo $form['enc_fecha_modificacion']->renderError() ?>
          <?php echo $form['enc_fecha_modificacion'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['enc_modificado_por']->renderLabel() ?></th>
        <td>
          <?php echo $form['enc_modificado_por']->renderError() ?>
          <?php echo $form['enc_modificado_por'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['enc_activo']->renderLabel() ?></th>
        <td>
          <?php echo $form['enc_activo']->renderError() ?>
          <?php echo $form['enc_activo'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
