<?php

require_once dirname(__FILE__) . '/../lib/sfGuardUserGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/sfGuardUserGeneratorHelper.class.php';

/**
 * sfGuardUser actions.
 *
 * @package	sfGuardPlugin
 * @subpackage sfGuardUser
 * @author 	Fabien Potencier
 * @version	SVN: $Id: actions.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardUserActions extends autoSfGuardUserActions {

	public function executeIndex(sfWebRequest $request) {
		$this->getResponse()->setTitle("Users Administration");
		$this->form = new sfGuardUserForm();
		$this->users = Doctrine_Core::getTable("sfGuardUser")->findAll();
	}

	public function executeDoSave(sfWebRequest $request) {
		$this->forwardUnless($aFormField = $request->getParameter("sf_guard_user"), "sfGuardUser", "index");
		$aData = array();
		$aData["message_list"] = array();
		$oUserForm = new sfGuardUserForm();
		$oUserForm->setDefault("created_at", date("Y-m-d H:i:s", time()));
		$oUserForm->bind($aFormField);
		if ($request->isXmlHttpRequest()) {
			if ($oUserForm->isValid()) {
				$oDoctrineConnection = Doctrine_Manager::getInstance()->getCurrentConnection();
				$oDoctrineConnection->beginTransaction();
				try {
					$bNew = true;
					$bActive = isset($aFormField["is_active"]) && $aFormField["is_active"] == "on" ? "1" : "0";
					if (isset($aFormField["id"]) && $aFormField["id"] != "") {
						$bNew = false;
						$oSfGuardUser = Doctrine_Core::getTable("SfGuardUser")->find($aFormField["id"]);
					} else {
						$oSfGuardUser = new sfGuardUser();
						$oSfGuardUser->setCreatedAt(date("Y-m-d h:i:s"));
						$oSfGuardUser->setLastLogin(date("Y-m-d h:i:s"));
					}
					$oSfGuardUser->setEmailAddress($aFormField["email_address"]);
					$oSfGuardUser->setFirstName($aFormField["first_name"]);
					$oSfGuardUser->setLastName($aFormField["last_name"]);
					$oSfGuardUser->setUsername($aFormField["username"]);
					$oSfGuardUser->setIsActive($bActive);
					$oSfGuardUser->setPassword($aFormField["password"]);
					$oSfGuardUser->save();
					Doctrine_Core::getTable("sfGuardUserGroup")->doDeactiveSfGuardGroupByUserId($oSfGuardUser["id"]);
					Doctrine_Core::getTable("sfGuardUserPermission")->doDeactiveSfGuardPermissionByUserId($oSfGuardUser["id"]);
					$checkGroups = isset($aFormField["groups_list"]) ? TRUE : FALSE;
					if ($checkGroups) {
						$oUserGroupC = new Doctrine_Collection("sfGuardUserGroup");
						foreach ($aFormField["groups_list"] as $group) {
							$oGroups = Doctrine_Core::getTable("sfGuardUserGroup")->findByUserIdAndGroupId($oSfGuardUser["id"], $group);
							if (count($oGroups) == 0) {
								$oUserGroup = new sfGuardUserGroup();
								$oUserGroup->setUserId($oSfGuardUser["id"]);
								$oUserGroup->setGroupId($group);
								$oUserGroupC->add($oUserGroup);
							}
						}
						$oUserGroupC->save();
					}
					$checkPermissions = isset($aFormField["permissions_list"]) ? TRUE : FALSE;
					if ($checkPermissions) {
						$oUserPermissionsC = new Doctrine_Collection("sfGuardUserPermission");
						foreach ($aFormField["permissions_list"] as $permission) {
							$oPermissions = Doctrine_Core::getTable("sfGuardUserPermission")->findByUserIdAndPermissionId($oSfGuardUser["id"], $permission);
							if (count($oPermissions) == 0) {
								$oUserPermissions = new sfGuardUserPermission();
								$oUserPermissions->setUserId($oSfGuardUser["id"]);
								$oUserPermissions->setPermissionId($permission);
								$oUserPermissionsC->add($oUserPermissions);
							}
						}
						$oUserPermissionsC->save();
					}
					$oDoctrineConnection->commit();
					$aData["id"] = $oSfGuardUser->get("id");
					$aData["first_name"] = $oSfGuardUser->getFirstName();
					$aData["last_name"] = $oSfGuardUser->getLastName();
					$aData["username"] = $oSfGuardUser->getUsername();
					$aData["email_address"] = $oSfGuardUser->getEmailAddress();
					$aData["is_active"] = $oSfGuardUser->getIsActive() == 1 ? "Yes" : "No";
					$aData["last_login"] = strftime("%A %d de %B del %Y", strtotime(trim($oSfGuardUser->getLastLogin())));
					$aData["groups_list"] = Doctrine_Core::getTable("sfGuardGroup")->getActiveSfGuardGroupByUserId($oSfGuardUser->get("id"), Doctrine_Core::HYDRATE_ARRAY);
					$aData["permissions_list"] = Doctrine_Core::getTable("sfGuardPermission")->getActiveSfGuardPermissionByUserId($oSfGuardUser->get("id"), Doctrine_Core::HYDRATE_ARRAY);
					$aData["is_new"] = $bNew;
				} catch (Exception $exc) {
					$oDoctrineConnection->rollback();
					array_push($aData["message_list"], $exc->getMessage() . "::" . $exc->getCode());
				}
			} else {
				$aData["message_list"] = $oUserForm->getErrorList();
			}
		} else {
			$aData["message_list"] = UsefullVariables::FormIsNotXmlHttpRequest;
		}
		$content = json_encode($aData);
		$this->getResponse()->setContent($content);
		return sfView::NONE;
	}

	public function executeGetUserByUserId(sfWebRequest $request) {
		$this->forwardUnless($aFormField = $request->getParameter("user_id"), "sfGuardUser", "index");
		if ($request->isXmlHttpRequest()) {
			$aData = array();
			$aData["message_list"] = array();
			$sUserId = $request->getParameter("user_id");
			$aSfGuardUser = Doctrine_Core::getTable("SfGuardUser")->find($sUserId, Doctrine_Core::HYDRATE_ARRAY);
			if (count($aSfGuardUser) == 0) {
				array_push($aData["message_list"], "No record with the given ID was found");
			} else {
				$aData["record"] = $aSfGuardUser;
				// Getting all groups that the user belongs to
				$aSfGuardGroup = Doctrine_Core::getTable("SfGuardGroup")->findAll(Doctrine_Core::HYDRATE_ARRAY);
				foreach ($aSfGuardGroup as $group) {
					$oSfGuarUserGroup = Doctrine_Core::getTable("SfGuardUserGroup")->findOneByUserIdAndGroupId($aSfGuardUser["id"], $group["id"]);
					if ($oSfGuarUserGroup) {
						$aData["record"]["groups_list"][] = $group["id"];
					}
				}
				// Getting all the permissions that the user belongs to
				$aSfGuardPermission = Doctrine_Core::getTable("SfGuardPermission")->findAll(Doctrine_Core::HYDRATE_ARRAY);
				foreach ($aSfGuardPermission as $permission) {
					$oSfGuardUserPermission = Doctrine_Core::getTable("SfGuardUserPermission")->findOneByUserIdAndPermissionId($aSfGuardUser["id"], $permission["id"]);
					if ($oSfGuardUserPermission) {
						$aData["record"]["permissions_list"][] = $permission["id"];
					}
				}
			}
		} else {
			array_push($aData["message_list"], "The view has been accessed without ajax methods");
		}
		$content = json_encode($aData);
		$this->getResponse()->setContent($content);
		return sfView::NONE;
	}

}