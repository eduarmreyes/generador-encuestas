<?php

require_once dirname(__FILE__) . '/../lib/sfGuardGroupGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/sfGuardGroupGeneratorHelper.class.php';

/**
 * sfGuardGroup actions.
 *
 * @package	sfGuardPlugin
 * @subpackage sfGuardGroup
 * @author 	Fabien Potencier
 * @version	SVN: $Id: actions.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardGroupActions extends autosfGuardGroupActions {

	public function executeIndex(sfWebRequest $request) {
    	$this->form = new sfGuardGroupForm();
    	$this->groups = Doctrine_Core::getTable("sfGuardGroup")->findAll();
	}

	public function executeDoSave(sfWebRequest $request) {
    	$this->forwardUnless($aFormField = $request->getParameter("sf_guard_group"), "sfGuardGroup", "index");
    	$aData = array();
    	$aData["message_list"] = array();
    	$oGroupForm = new sfGuardGroupForm();
    	$oGroupForm->setDefault("created_at", date("Y-m-d H:i:s", time()));
    	$oGroupForm->bind($aFormField);
    	if ($request->isXmlHttpRequest()) {
        	if ($oGroupForm->isValid()) {
            	$oDoctrineConnection = Doctrine_Manager::getInstance()->getCurrentConnection();
            	$oDoctrineConnection->beginTransaction();
            	try {
                	$bNew = true;
                	if ($aFormField["id"]) {
                    	$bNew = FALSE;
                    	$oSfGuardGroup = Doctrine_Core::getTable("SfGuardGroup")->find($aFormField["id"]);
                	} else {
                    	$oSfGuardGroup = new sfGuardGroup();
                	}
                	$oSfGuardGroup->setName($aFormField["name"]);
                	$oSfGuardGroup->setDescription($aFormField["description"]);
                	$oSfGuardGroup->save();
                	Doctrine_Core::getTable("sfGuardUserGroup")->doDeactiveSfGuardUserByGroupId($oSfGuardGroup->getIncremented());
                	Doctrine_Core::getTable("sfGuardGroupPermission")->doDeactiveSfGuardPermissionByGroupId($oSfGuardGroup->getIncremented());
                	$checkUsers = isset($aFormField["users_list"]) ? TRUE : FALSE;
                	if ($checkUsers) {
                    	$oUserGroupC = new Doctrine_Collection("sfguardUserGroup");
                    	foreach ($aFormField["users_list"] as $user) {
                        	$oUsers = Doctrine_Core::getTable("sfGuardUserGroup")->findByGroupIdAndUserId($oSfGuardGroup["id"], $user);
                        	if (count($oUsers) == 0) {
                            	$oUserGroup = new sfGuardUserGroup();
                            	$oUserGroup->setUserId($user);
                            	$oUserGroup->setGroupId($oSfGuardGroup->getIncremented());
                            	$oUserGroupC->add($oUserGroup);
                        	}
                    	}
                    	$oUserGroupC->save();
                	}
                	$checkPermissions = isset($aFormField["permissions_list"]) ? TRUE : FALSE;
                	if ($checkPermissions) {
                    	$oGroupPermissionC = new Doctrine_Collection("sfGuardGroupPermission");
                    	foreach ($aFormField["permissions_list"] as $permission) {
                        	$oPermission = Doctrine_Core::getTable("sfguardGroupPermission")->findByGroupIdAndPermissionId($oSfGuardGroup["id"], $permission);
                        	if (count($oPermission) == 0) {
                            	$oGroupPermission = new sfGuardGroupPermission();
                            	$oGroupPermission->setGroupId($oSfGuardGroup->getIncremented());
                            	$oGroupPermission->setPermissionId($permission);
                            	$oGroupPermissionC->add($oGroupPermission);
                        	}
                    	}
                    	$oGroupPermissionC->save();
                	}
                	$oDoctrineConnection->commit();
                	$aData["name"] = $oSfGuardGroup->getName();
                	$aData["description"] = $oSfGuardGroup->getDescription();
                	$aData["users_list"] = Doctrine_Core::getTable("sfGuardGroup")->getActiveSfGuardUserByGroupId($oSfGuardGroup->get("id"), Doctrine_Core::HYDRATE_ARRAY);
                	$aData["permissions_list"] = Doctrine_Core::getTable("sfGuardPermission")->getActiveSfGuardPermissionByGroupId($oSfGuardGroup->get("id"), Doctrine_Core::HYDRATE_ARRAY);
                	$aData["is_new"] = $bNew;
            	} catch (Exception $exc) {
                	array_push($aData["message_list"], $exc->getMessage() . "::" . $exc->getCode());
            	}
        	} else {
            	$aData["message_list"] = $oGroupForm->getErrorList();
        	}
    	} else {
        	$aData["message_list"] = "You're trying to access this page incorrectly, please refer to the user backend administration";
    	}
    	$content = json_encode($aData);
    	$this->getResponse()->setContent($content);
    	return sfView::NONE;
	}

	public function executeGetGroupByGroupId(sfWebRequest $request) {
    	$this->forwardUnless($sGroupId = $request->getParameter("group_id"), "sfGuardGroup", "index");
    	if ($request->isXmlHttpRequest()) {
        	$aData = array();
        	$aData["message_list"] = array();
        	$aSfGuardGroup = Doctrine_Core::getTable("SfGuardGroup")->find($sGroupId, Doctrine_Core::HYDRATE_ARRAY);
        	if (count($aSfGuardGroup) == 0) {
            	array_push($aData["message_list"], "No record with the given ID was found");
        	} else {
            	$aData["record"] = $aSfGuardGroup;
            	// Getting all the users that have joined the group
            	$aSfGuardUser = Doctrine_Core::getTable("SfGuardUser")->findAll(Doctrine_Core::HYDRATE_ARRAY);
            	foreach ($aSfGuardUser as $user) {
                	$oSfGuardUserGroup = Doctrine_Core::getTable("SfGuardUserGroup")->findOneByUserIdAndGroupId($user["id"], $aSfGuardGroup["id"]);
                	if ($oSfGuardUserGroup) {
                    	$aData["record"]["users_list"][] = $user["id"];
                	}
            	}
            	// Getting all the permissions that the group belongs to
            	$aSfGuardPermission = Doctrine_Core::getTable("SfGuardPermission")->findAll(Doctrine_Core::HYDRATE_ARRAY);
            	foreach ($aSfGuardPermission as $permission) {
                	$oSfGuardGroupPermission = Doctrine_Core::getTable("SfGuardGroupPermission")->findOneByGroupIdAndPermissionId($aSfGuardGroup["id"], $permission["id"]);
                	if ($oSfGuardGroupPermission) {
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



