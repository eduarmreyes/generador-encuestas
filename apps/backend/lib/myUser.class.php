<?php

class myUser extends sfGuardSecurityUser
{
	public function signIn($user, $remember = false, $con = null) {
		parent::signIn($user, $remember, $con);
		$this->setAttribute("user_id", $this->getGuardUser()->get("id"));
	}
}
