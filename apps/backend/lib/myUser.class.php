<?php

class myUser extends sfGuardSecurityUser {

	public function signIn($user, $remember = false, $con = null) {
		parent::signIn($user, $remember, $con);
		$this->setAttribute("user_id", $this->getGuardUser()->get("id"));
		$oGroups = $this->getGroupNames();
		foreach ($oGroups as $group) {
			$this->addCredential($group);
		}
		$oPermissions = $this->getPermissionNames();
		foreach ($oPermissions as $permission) {
			$this->addCredential($permission);
		}
	}

}
