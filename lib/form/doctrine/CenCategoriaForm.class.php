<?php

/**
 * CenCategoria form.
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CenCategoriaForm extends BaseCenCategoriaForm {

	public function configure() {
		// Configurar el formato del nombre del widget schema
		$this->widgetSchema->setNameFormat('categoria[%s]');
		// Widgets
		$this->widgetSchema["cat_nombre"] = new sfWidgetFormInput(array(), array("placeholder" => "Nombre de la categoría"));
		$this->widgetSchema["cat_es_datos_clasificacion"] = new sfWidgetFormInputCheckbox();
		// Validadores
		$this->validatorSchema["cat_es_datos_clasificacion"] = new sfValidatorBoolean(array("required" => false));
		$this->validatorSchema["cat_creado_por"] = new sfValidatorInteger(array("required" => false));
		$this->validatorSchema["cat_fecha_creacion"] = new sfValidatorDateTime(array("required" => false));
		$this->validatorSchema["cat_modificado_por"] = new sfValidatorInteger(array("required" => false));
		$this->validatorSchema["cat_fecha_modificacion"] = new sfValidatorDateTime(array("required" => false));
		$this->validatorSchema["cat_activo"] = new sfValidatorBoolean(array("required" => false));
		/* $this->setValidators(array(
		  'cat_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('cat_id')), 'empty_value' => $this->getObject()->get('cat_id'), 'required' => false)),
		  'cat_nombre' => new sfValidatorString(array('max_length' => 50)),
		  'cat_es_datos_clasificacion' => new sfValidatorInteger(array('required' => false)),
		  'cat_creado_por' => new sfValidatorInteger(),
		  'cat_fecha_creacion' => new sfValidatorDateTime(),
		  'cat_modificado_por' => new sfValidatorInteger(),
		  'cat_fecha_modificacion' => new sfValidatorDateTime(),
		  'cat_activo' => new sfValidatorInteger(),
		  )); */
		
		$this->validatorSchema->setPostValidator(new sfValidatorCallback(array("callback" => array($this, "validateCategoryName"))));
	}

	public function validateCategoryName($validator, $aValues) {
		$bValid = true;
		if (isset($aValues["cat_nombre"])) {
			$oCenCategory = Doctrine_Core::getTable("CenCategoria")->findOneByCatNombre($aValues["cat_nombre"]);
			if ($oCenCategory) {
				if ($aValues["cat_id"]) {
					$bValid = $aValues["cat_id"] == $oCenCategory->getCatId();
				} else {
					$bValid = false;
				}
			}
		}
		if (!$bValid) {
			$this->throwError($validator, "La categoría \"" . $aValues["cat_nombre"] . "\" ya existe.");
		}
		return $aValues;
	}

}
