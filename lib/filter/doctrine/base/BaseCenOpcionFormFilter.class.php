<?php

/**
 * CenOpcion filter form base class.
 *
 * @package    generador_encuestas
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCenOpcionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'opc_id_pregunta'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CenPregunta'), 'add_empty' => true)),
      'opc_opcion'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'opc_creador_por'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'opc_fecha_creacion' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'opc_modificado_por' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'opc_activo'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'opc_id_pregunta'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CenPregunta'), 'column' => 'pre_id')),
      'opc_opcion'         => new sfValidatorPass(array('required' => false)),
      'opc_creador_por'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'opc_fecha_creacion' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'opc_modificado_por' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'opc_activo'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('cen_opcion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CenOpcion';
  }

  public function getFields()
  {
    return array(
      'opc_id'             => 'Number',
      'opc_id_pregunta'    => 'ForeignKey',
      'opc_opcion'         => 'Text',
      'opc_creador_por'    => 'Number',
      'opc_fecha_creacion' => 'Date',
      'opc_modificado_por' => 'Number',
      'opc_activo'         => 'Number',
    );
  }
}
