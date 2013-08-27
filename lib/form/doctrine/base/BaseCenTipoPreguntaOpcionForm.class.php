<?php

/**
 * CenTipoPreguntaOpcion form base class.
 *
 * @method CenTipoPreguntaOpcion getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenTipoPreguntaOpcionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'tpo_id'                 => new sfWidgetFormInputHidden(),
      'tpo_tipo_etiqueta'      => new sfWidgetFormInputText(),
      'tpo_plantilla_html'     => new sfWidgetFormInputText(),
      'tpo_fecha_creacion'     => new sfWidgetFormDateTime(),
      'tpo_creado_por'         => new sfWidgetFormInputText(),
      'tpo_fecha_modificacion' => new sfWidgetFormDateTime(),
      'tpo_modificado_por'     => new sfWidgetFormInputText(),
      'tpo_activo'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'tpo_id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('tpo_id')), 'empty_value' => $this->getObject()->get('tpo_id'), 'required' => false)),
      'tpo_tipo_etiqueta'      => new sfValidatorString(array('max_length' => 50)),
      'tpo_plantilla_html'     => new sfValidatorString(array('max_length' => 150)),
      'tpo_fecha_creacion'     => new sfValidatorDateTime(),
      'tpo_creado_por'         => new sfValidatorInteger(),
      'tpo_fecha_modificacion' => new sfValidatorDateTime(),
      'tpo_modificado_por'     => new sfValidatorInteger(),
      'tpo_activo'             => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cen_tipo_pregunta_opcion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenTipoPreguntaOpcion';
  }

}
