<?php

/**
 * CenEncuestaMaster form base class.
 *
 * @method CenEncuestaMaster getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenEncuestaMasterForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'encm_id'                 => new sfWidgetFormInputHidden(),
      'encm_encuesta_id'        => new sfWidgetFormInputText(),
      'encm_creado_por'         => new sfWidgetFormInputText(),
      'encm_fecha_creacion'     => new sfWidgetFormDateTime(),
      'encm_modificado_por'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SfGuardUser'), 'add_empty' => false)),
      'encm_fecha_modificacion' => new sfWidgetFormDateTime(),
      'encm_activo'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'encm_id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('encm_id')), 'empty_value' => $this->getObject()->get('encm_id'), 'required' => false)),
      'encm_encuesta_id'        => new sfValidatorString(array('max_length' => 50)),
      'encm_creado_por'         => new sfValidatorInteger(),
      'encm_fecha_creacion'     => new sfValidatorDateTime(),
      'encm_modificado_por'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SfGuardUser'))),
      'encm_fecha_modificacion' => new sfValidatorDateTime(),
      'encm_activo'             => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('cen_encuesta_master[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenEncuestaMaster';
  }

}
