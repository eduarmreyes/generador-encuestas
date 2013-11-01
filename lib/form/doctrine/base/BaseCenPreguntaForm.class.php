<?php

/**
 * CenPregunta form base class.
 *
 * @method CenPregunta getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenPreguntaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'pre_id'                      => new sfWidgetFormInputHidden(),
      'pre_id_encuesta'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CenEncuestas'), 'add_empty' => false)),
      'pre_id_tipo_pregunta_opcion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CenTipoPreguntaOpcion'), 'add_empty' => false)),
      'pre_pregunta_text'           => new sfWidgetFormTextarea(),
      'pre_posicion'                => new sfWidgetFormInputText(),
      'pre_padre'                   => new sfWidgetFormInputText(),
      'pre_nota'                    => new sfWidgetFormTextarea(),
      'pre_descripcion'             => new sfWidgetFormTextarea(),
      'pre_fecha_creacion'          => new sfWidgetFormDateTime(),
      'pre_creado_por'              => new sfWidgetFormInputText(),
      'pre_fecha_modificacion'      => new sfWidgetFormDateTime(),
      'pre_modificado_por'          => new sfWidgetFormInputText(),
      'pre_activo'                  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'pre_id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('pre_id')), 'empty_value' => $this->getObject()->get('pre_id'), 'required' => false)),
      'pre_id_encuesta'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CenEncuestas'))),
      'pre_id_tipo_pregunta_opcion' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CenTipoPreguntaOpcion'))),
      'pre_pregunta_text'           => new sfValidatorString(),
      'pre_posicion'                => new sfValidatorInteger(),
      'pre_padre'                   => new sfValidatorInteger(),
      'pre_nota'                    => new sfValidatorString(),
      'pre_descripcion'             => new sfValidatorString(array('required' => false)),
      'pre_fecha_creacion'          => new sfValidatorDateTime(),
      'pre_creado_por'              => new sfValidatorInteger(),
      'pre_fecha_modificacion'      => new sfValidatorDateTime(),
      'pre_modificado_por'          => new sfValidatorInteger(),
      'pre_activo'                  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cen_pregunta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenPregunta';
  }

}
