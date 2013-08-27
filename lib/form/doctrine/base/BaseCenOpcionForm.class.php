<?php

/**
 * CenOpcion form base class.
 *
 * @method CenOpcion getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenOpcionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'opc_id'             => new sfWidgetFormInputHidden(),
      'opc_id_pregunta'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CenPregunta'), 'add_empty' => false)),
      'opc_opcion'         => new sfWidgetFormInputText(),
      'opc_creador_por'    => new sfWidgetFormInputText(),
      'opc_fecha_creacion' => new sfWidgetFormDateTime(),
      'opc_modificado_por' => new sfWidgetFormInputText(),
      'opc_activo'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'opc_id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('opc_id')), 'empty_value' => $this->getObject()->get('opc_id'), 'required' => false)),
      'opc_id_pregunta'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CenPregunta'))),
      'opc_opcion'         => new sfValidatorString(array('max_length' => 50)),
      'opc_creador_por'    => new sfValidatorInteger(),
      'opc_fecha_creacion' => new sfValidatorDateTime(),
      'opc_modificado_por' => new sfValidatorInteger(),
      'opc_activo'         => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('cen_opcion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenOpcion';
  }

}
