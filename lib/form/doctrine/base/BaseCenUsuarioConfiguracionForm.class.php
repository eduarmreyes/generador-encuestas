<?php

/**
 * CenUsuarioConfiguracion form base class.
 *
 * @method CenUsuarioConfiguracion getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenUsuarioConfiguracionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usc_id'                 => new sfWidgetFormInputHidden(),
      'usc_user_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SfGuardUser'), 'add_empty' => false)),
      'usc_guider'             => new sfWidgetFormInputText(),
      'usc_creado_por'         => new sfWidgetFormInputText(),
      'usc_fecha_creacion'     => new sfWidgetFormDateTime(),
      'usc_modificado_por'     => new sfWidgetFormInputText(),
      'usc_fecha_modificacion' => new sfWidgetFormDateTime(),
      'usc_activo'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'usc_id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('usc_id')), 'empty_value' => $this->getObject()->get('usc_id'), 'required' => false)),
      'usc_user_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SfGuardUser'))),
      'usc_guider'             => new sfValidatorInteger(),
      'usc_creado_por'         => new sfValidatorInteger(),
      'usc_fecha_creacion'     => new sfValidatorDateTime(),
      'usc_modificado_por'     => new sfValidatorInteger(),
      'usc_fecha_modificacion' => new sfValidatorDateTime(),
      'usc_activo'             => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('cen_usuario_configuracion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenUsuarioConfiguracion';
  }

}
