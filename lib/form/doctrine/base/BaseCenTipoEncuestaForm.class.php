<?php

/**
 * CenTipoEncuesta form base class.
 *
 * @method CenTipoEncuesta getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenTipoEncuestaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'tpe_id'                 => new sfWidgetFormInputHidden(),
      'tpe_nombre'             => new sfWidgetFormInputText(),
      'tpe_fecha_creacion'     => new sfWidgetFormDateTime(),
      'tpe_creado_por'         => new sfWidgetFormInputText(),
      'tpe_fecha_modificacion' => new sfWidgetFormDateTime(),
      'tpe_modificado_por'     => new sfWidgetFormInputText(),
      'tpe_activo'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'tpe_id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('tpe_id')), 'empty_value' => $this->getObject()->get('tpe_id'), 'required' => false)),
      'tpe_nombre'             => new sfValidatorString(array('max_length' => 50)),
      'tpe_fecha_creacion'     => new sfValidatorDateTime(),
      'tpe_creado_por'         => new sfValidatorInteger(),
      'tpe_fecha_modificacion' => new sfValidatorDateTime(),
      'tpe_modificado_por'     => new sfValidatorInteger(),
      'tpe_activo'             => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cen_tipo_encuesta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenTipoEncuesta';
  }

}
