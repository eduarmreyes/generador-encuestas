<?php

/**
 * CenEncuestas filter form base class.
 *
 * @package    generador_encuestas
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCenEncuestasFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'enc_nombre'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'enc_descripcion'        => new sfWidgetFormFilterInput(),
      'enc_fecha_creacion'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'enc_creado_por'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'enc_fecha_modificacion' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'enc_modificado_por'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'enc_activo'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'enc_nombre'             => new sfValidatorPass(array('required' => false)),
      'enc_descripcion'        => new sfValidatorPass(array('required' => false)),
      'enc_fecha_creacion'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'enc_creado_por'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'enc_fecha_modificacion' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'enc_modificado_por'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'enc_activo'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('cen_encuestas_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenEncuestas';
  }

  public function getFields()
  {
    return array(
      'enc_id'                 => 'Number',
      'enc_nombre'             => 'Text',
      'enc_descripcion'        => 'Text',
      'enc_fecha_creacion'     => 'Date',
      'enc_creado_por'         => 'Number',
      'enc_fecha_modificacion' => 'Date',
      'enc_modificado_por'     => 'Number',
      'enc_activo'             => 'Number',
    );
  }
}
