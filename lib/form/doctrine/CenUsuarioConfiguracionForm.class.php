<?php

/**
 * CenUsuarioConfiguracion form.
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CenUsuarioConfiguracionForm extends BaseCenUsuarioConfiguracionForm
{
  public function configure()
  {
	  unset($this["usc_user_id"], $this["usc_creado_por"], $this["usc_fecha_creacion"], $this["usc_modificado_por"], $this["usc_fecha_modificacion"], $this["usc_activo"]);
	  $this->widgetSchema["usc_guider"] = new sfWidgetFormInputCheckbox(array(), array());
  }
  
//  public function validateUserConfiguration($validator, $aValues) {
//		$bValid = true;
//		if (isset($aValues["usc_user_id"]) && isset($aValues["usc_guider"])) {
//			$oCenUsuarioConfiguracion = Doctrine_Core::getTable("cenUsuarioConfiguracion")->findOneByUscUserIdAndUscGuider($aValues["usc_user_id"], $aValues["usc_guider"]);
//			if ($oCenUsuarioConfiguracion) {
//				if ($aValues["usc_id"]) {
//					$bValid = $aValues["usc_id"] == $oCenUsuarioConfiguracion->getUscId();
//				} else {
//					$bValid = false;
//				}
//			}
//		}
//		if (!$bValid) {
//			$this->throwError($validator, "La configuracion de guider .");
//		}
//		return $aValues;
//	}
}
