<?php

/**
 * CenTipoPreguntaOpcion filter form base class.
 *
 * @package    generador_encuestas
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCenTipoPreguntaOpcionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'tpo_tipo_etiqueta'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tpo_plantilla_html'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tpo_fecha_creacion'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'tpo_creado_por'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tpo_fecha_modificacion' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'tpo_modificado_por'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tpo_activo'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'tpo_tipo_etiqueta'      => new sfValidatorPass(array('required' => false)),
      'tpo_plantilla_html'     => new sfValidatorPass(array('required' => false)),
      'tpo_fecha_creacion'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'tpo_creado_por'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tpo_fecha_modificacion' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'tpo_modificado_por'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tpo_activo'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('cen_tipo_pregunta_opcion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenTipoPreguntaOpcion';
  }

  public function getFields()
  {
    return array(
      'tpo_id'                 => 'Number',
      'tpo_tipo_etiqueta'      => 'Text',
      'tpo_plantilla_html'     => 'Text',
      'tpo_fecha_creacion'     => 'Date',
      'tpo_creado_por'         => 'Number',
      'tpo_fecha_modificacion' => 'Date',
      'tpo_modificado_por'     => 'Number',
      'tpo_activo'             => 'Number',
    );
  }
}
