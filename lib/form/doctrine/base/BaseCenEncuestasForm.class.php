<?php

/**
 * CenEncuestas form base class.
 *
 * @method CenEncuestas getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenEncuestasForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'enc_id'                 => new sfWidgetFormInputHidden(),
      'enc_nombre'             => new sfWidgetFormInputText(),
      'enc_descripcion'        => new sfWidgetFormTextarea(),
      'enc_fecha_creacion'     => new sfWidgetFormDateTime(),
      'enc_creado_por'         => new sfWidgetFormInputText(),
      'enc_fecha_modificacion' => new sfWidgetFormDateTime(),
      'enc_modificado_por'     => new sfWidgetFormInputText(),
      'enc_activo'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'enc_id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('enc_id')), 'empty_value' => $this->getObject()->get('enc_id'), 'required' => false)),
      'enc_nombre'             => new sfValidatorString(array('max_length' => 50)),
      'enc_descripcion'        => new sfValidatorString(array('required' => false)),
      'enc_fecha_creacion'     => new sfValidatorDateTime(),
      'enc_creado_por'         => new sfValidatorInteger(),
      'enc_fecha_modificacion' => new sfValidatorDateTime(),
      'enc_modificado_por'     => new sfValidatorInteger(),
      'enc_activo'             => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cen_encuestas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenEncuestas';
  }

}
