<?php

/**
 * CenPais form base class.
 *
 * @method CenPais getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenPaisForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'pai_id'                 => new sfWidgetFormInputHidden(),
      'pai_nombre'             => new sfWidgetFormInputText(),
      'pai_fecha_creacion'     => new sfWidgetFormDateTime(),
      'pai_creado_por'         => new sfWidgetFormInputText(),
      'pai_fecha_modificacion' => new sfWidgetFormDateTime(),
      'pai_modificado_por'     => new sfWidgetFormInputText(),
      'pai_activo'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'pai_id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('pai_id')), 'empty_value' => $this->getObject()->get('pai_id'), 'required' => false)),
      'pai_nombre'             => new sfValidatorString(array('max_length' => 50)),
      'pai_fecha_creacion'     => new sfValidatorDateTime(),
      'pai_creado_por'         => new sfValidatorInteger(),
      'pai_fecha_modificacion' => new sfValidatorDateTime(),
      'pai_modificado_por'     => new sfValidatorInteger(),
      'pai_activo'             => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cen_pais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenPais';
  }

}
