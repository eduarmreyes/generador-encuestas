<?php

/**
 * sfGuardUser form.
 *
 * @package    generador_encuestas
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm {

	public function configure() {
		parent::setup();

		unset(
				$this['last_login'], $this['created_at'], $this['updated_at'], $this['salt'], $this['algorithm']
		);

		$this->widgetSchema['password'] = new sfWidgetFormInputPassword();
		$this->validatorSchema['password']->setOption('required', false);
		$this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
		$this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
		$this->widgetSchema['groups_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup'), array("data-placeholder" => "Seleccione grupos"));
		$this->widgetSchema['permissions_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission'), array("data-placeholder" => "Seleccione permisos"));
		$this->validatorSchema["id"] = new sfValidatorDoctrineChoice(array("model" => "sfGuardUser", "required" => false), array("invalid" => "ID aparentemente inválido"));

		$this->widgetSchema->moveField('password_again', 'after', 'password');

		$this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'Las contraseñas deben ser las mismas.')));

		$this->validatorSchema->setPostValidator(new sfValidatorCallback(array("callback" => array($this, "validateUsernameAndEmail"))));
	}

	public function validateUsernameAndEmail($validator, $aValues) {
		$bValid = true;
		if (isset($aValues["username"]) && isset($aValues["email_address"])) {
			$oSfGuardUser = Doctrine_Core::getTable("sfGuardUser")->findOneByEmailAddressOrUsername($aValues["email_address"], $aValues["username"]);
			if ($oSfGuardUser) {
				if ($aValues["id"]) {
					$bValid = $aValues["id"] == $oSfGuardUser->get("id");
				} else {
					$bValid = false;
				}
			}
		}
		if (!$bValid) {
			$this->throwError($validator, "El email o usuario está en uso, por favor cámbielo.");
		}
		return $aValues;
	}

}
