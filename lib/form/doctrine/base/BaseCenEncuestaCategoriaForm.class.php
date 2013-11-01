<?php

/**
 * CenEncuestaCategoria form base class.
 *
 * @method CenEncuestaCategoria getObject() Returns the current form's model object
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCenEncuestaCategoriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'enc_id'                 => new sfWidgetFormInputHidden(),
      'enc_encuesta_id'        => new sfWidgetFormInputText(),
      'enc_categoria_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CenCategoria'), 'add_empty' => false)),
      'enc_creado_por'         => new sfWidgetFormInputText(),
      'enc_fecha_creacion'     => new sfWidgetFormDateTime(),
      'enc_modificado_por'     => new sfWidgetFormInputText(),
      'enc_fecha_modificacion' => new sfWidgetFormDateTime(),
      'enc_activo'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'enc_id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('enc_id')), 'empty_value' => $this->getObject()->get('enc_id'), 'required' => false)),
      'enc_encuesta_id'        => new sfValidatorString(array('max_length' => 50)),
      'enc_categoria_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CenCategoria'))),
      'enc_creado_por'         => new sfValidatorInteger(),
      'enc_fecha_creacion'     => new sfValidatorDateTime(),
      'enc_modificado_por'     => new sfValidatorInteger(),
      'enc_fecha_modificacion' => new sfValidatorDateTime(),
      'enc_activo'             => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('cen_encuesta_categoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenEncuestaCategoria';
  }

}
