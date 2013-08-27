<?php

/**
 * CenPregunta filter form base class.
 *
 * @package    generador_encuestas
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCenPreguntaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'pre_id_encuesta'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CenEncuestas'), 'add_empty' => true)),
      'pre_id_tipo_pregunta_opcion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CenTipoPreguntaOpcion'), 'add_empty' => true)),
      'pre_pregunta_text'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pre_posicion'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pre_nota'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pre_descripcion'             => new sfWidgetFormFilterInput(),
      'pre_fecha_creacion'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pre_creado_por'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pre_fecha_modificacion'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pre_modificado_por'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pre_activo'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'pre_id_encuesta'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CenEncuestas'), 'column' => 'enc_id')),
      'pre_id_tipo_pregunta_opcion' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CenTipoPreguntaOpcion'), 'column' => 'tpo_id')),
      'pre_pregunta_text'           => new sfValidatorPass(array('required' => false)),
      'pre_posicion'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pre_nota'                    => new sfValidatorPass(array('required' => false)),
      'pre_descripcion'             => new sfValidatorPass(array('required' => false)),
      'pre_fecha_creacion'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'pre_creado_por'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pre_fecha_modificacion'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'pre_modificado_por'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pre_activo'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('cen_pregunta_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenPregunta';
  }

  public function getFields()
  {
    return array(
      'pre_id'                      => 'Number',
      'pre_id_encuesta'             => 'ForeignKey',
      'pre_id_tipo_pregunta_opcion' => 'ForeignKey',
      'pre_pregunta_text'           => 'Text',
      'pre_posicion'                => 'Number',
      'pre_nota'                    => 'Text',
      'pre_descripcion'             => 'Text',
      'pre_fecha_creacion'          => 'Date',
      'pre_creado_por'              => 'Number',
      'pre_fecha_modificacion'      => 'Date',
      'pre_modificado_por'          => 'Number',
      'pre_activo'                  => 'Number',
    );
  }
}
