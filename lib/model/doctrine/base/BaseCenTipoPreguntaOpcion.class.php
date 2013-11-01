<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CenTipoPreguntaOpcion', 'doctrine');

/**
 * BaseCenTipoPreguntaOpcion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $tpo_id
 * @property string $tpo_tipo_etiqueta
 * @property string $tpo_plantilla_html
 * @property timestamp $tpo_fecha_creacion
 * @property integer $tpo_creado_por
 * @property timestamp $tpo_fecha_modificacion
 * @property integer $tpo_modificado_por
 * @property integer $tpo_activo
 * @property Doctrine_Collection $CenPregunta
 * 
 * @method integer               getTpoId()                  Returns the current record's "tpo_id" value
 * @method string                getTpoTipoEtiqueta()        Returns the current record's "tpo_tipo_etiqueta" value
 * @method string                getTpoPlantillaHtml()       Returns the current record's "tpo_plantilla_html" value
 * @method timestamp             getTpoFechaCreacion()       Returns the current record's "tpo_fecha_creacion" value
 * @method integer               getTpoCreadoPor()           Returns the current record's "tpo_creado_por" value
 * @method timestamp             getTpoFechaModificacion()   Returns the current record's "tpo_fecha_modificacion" value
 * @method integer               getTpoModificadoPor()       Returns the current record's "tpo_modificado_por" value
 * @method integer               getTpoActivo()              Returns the current record's "tpo_activo" value
 * @method Doctrine_Collection   getCenPregunta()            Returns the current record's "CenPregunta" collection
 * @method CenTipoPreguntaOpcion setTpoId()                  Sets the current record's "tpo_id" value
 * @method CenTipoPreguntaOpcion setTpoTipoEtiqueta()        Sets the current record's "tpo_tipo_etiqueta" value
 * @method CenTipoPreguntaOpcion setTpoPlantillaHtml()       Sets the current record's "tpo_plantilla_html" value
 * @method CenTipoPreguntaOpcion setTpoFechaCreacion()       Sets the current record's "tpo_fecha_creacion" value
 * @method CenTipoPreguntaOpcion setTpoCreadoPor()           Sets the current record's "tpo_creado_por" value
 * @method CenTipoPreguntaOpcion setTpoFechaModificacion()   Sets the current record's "tpo_fecha_modificacion" value
 * @method CenTipoPreguntaOpcion setTpoModificadoPor()       Sets the current record's "tpo_modificado_por" value
 * @method CenTipoPreguntaOpcion setTpoActivo()              Sets the current record's "tpo_activo" value
 * @method CenTipoPreguntaOpcion setCenPregunta()            Sets the current record's "CenPregunta" collection
 * 
 * @package    generador_encuestas
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCenTipoPreguntaOpcion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cen_tipo_pregunta_opcion');
        $this->hasColumn('tpo_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('tpo_tipo_etiqueta', 'string', 50, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 50,
             ));
        $this->hasColumn('tpo_plantilla_html', 'string', 150, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 150,
             ));
        $this->hasColumn('tpo_fecha_creacion', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('tpo_creado_por', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('tpo_fecha_modificacion', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('tpo_modificado_por', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('tpo_activo', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '1',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('CenPregunta', array(
             'local' => 'tpo_id',
             'foreign' => 'pre_id_tipo_pregunta_opcion'));
    }
}