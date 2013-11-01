<?php

/**
 * CenCategoria form base class.
 *
 * @method CenCategoria getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenCategoriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cat_id'                     => new sfWidgetFormInputHidden(),
      'cat_nombre'                 => new sfWidgetFormInputText(),
      'cat_es_datos_clasificacion' => new sfWidgetFormInputText(),
      'cat_creado_por'             => new sfWidgetFormInputText(),
      'cat_fecha_creacion'         => new sfWidgetFormDateTime(),
      'cat_modificado_por'         => new sfWidgetFormInputText(),
      'cat_fecha_modificacion'     => new sfWidgetFormDateTime(),
      'cat_activo'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'cat_id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('cat_id')), 'empty_value' => $this->getObject()->get('cat_id'), 'required' => false)),
      'cat_nombre'                 => new sfValidatorString(array('max_length' => 50)),
      'cat_es_datos_clasificacion' => new sfValidatorInteger(array('required' => false)),
      'cat_creado_por'             => new sfValidatorInteger(),
      'cat_fecha_creacion'         => new sfValidatorDateTime(),
      'cat_modificado_por'         => new sfValidatorInteger(),
      'cat_fecha_modificacion'     => new sfValidatorDateTime(),
      'cat_activo'                 => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('cen_categoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenCategoria';
  }

}
