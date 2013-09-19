<?php

require_once dirname(__FILE__) . '/../lib/sfGuardPermissionGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/sfGuardPermissionGeneratorHelper.class.php';

/**
 * sfGuardPermission actions.
 *
 * @package	sfGuardPlugin
 * @subpackage sfGuardPermission
 * @author 	Fabien Potencier
 * @version	SVN: $Id: actions.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardPermissionActions extends autosfGuardPermissionActions {

	public function executeIndex(sfWebRequest $request) {
    	$this->form = new sfGuardPermissionForm();
    	$this->permissions = Doctrine_Core::getTable("sfGuardPermission")->findAll();
	}

	public function executeDoSave(sfWebRequest $request) {
    	$this->forwardUnless($aFormField = $request->getParameter("sf_guard_permission"), "sfGuardPermission", "index");
    	$aData = array();
    	$aData["message_list"] = array();
    	$oPermissionForm = new sfGuardPermissionForm();
    	$oPermissionForm->setDefault("created_at", date("Y-m-d H:i:s", time()));
    	$oPermissionForm->bind($aFormField);
    	if ($request->isXmlHttpRequest()) {
        	if ($oPermissionForm->isValid()) {
            	$oDoctrineConnection = Doctrine_Manager::getInstance()->getCurrentConnection();
            	$oDoctrineConnection->beginTransaction();
            	try {
                	$bNew = true;
                	if ($aFormField["id"]) {
                    	$bNew = FALSE;
                    	$oSfGuardPermission = Doctrine_Core::getTable("sfGuardPermission")->find($aFormField["id"]);
                	} else {
                    	$oSfGuardPermission = new sfGuardPermission();
                	}
                	$oSfGuardPermission->setName($aFormField["name"]);
                	$oSfGuardPermission->setDescription($aFormField["description"]);
                	$oSfGuardPermission->save();
                	Doctrine_Core::getTable("sfGuardUserPermission")->doDeactiveSfGuardPermissionByPermissionId($oSfGuardPermission->getIncremented());
                	Doctrine_Core::getTable("sfGuardGroupPermission")->doDeactiveSfGuardGroupByPermissionId($oSfGuardPermission->getIncremented());
                	$checkUsers = isset($aFormField["users_list"]) ? TRUE : FALSE;
                	if ($checkUsers) {
                    	$oUserPermissionC = new Doctrine_Collection("sfGuardUserPermission");
                    	foreach ($aFormField["users_list"] as $user) {
                        	$oUsers = Doctrine_Core::getTable("sfGuardUserPermission")->findByPermissionIdAndUserId($oSfGuardPermission["id"], $user);
                        	if (count($oUsers) == 0) {
                            	$oUserPermission = new sfGuardUserPermission();
                            	$oUserPermission->setUserId($user);
                            	$oUserPermission->setPermissionId($oSfGuardPermission->getIncremented());
                            	$oUserPermissionC->add($oUserPermission);
                        	}
                    	}
                    	$oUserPermissionC->save();
                	}
                	$checkGroups = isset($aFormField["groups_list"]) ? TRUE : FALSE;
                	if ($checkGroups) {
                    	$oGroupPermissionC = new Doctrine_Collection("sfGuardGroupPermission");
                    	foreach ($aFormField["groups_list"] as $group) {
                        	$oGroup = Doctrine_Core::getTable("sfGuardGroupPermission")->findByPermissionIdAndGroupId($oSfGuardPermission["id"], $group);
                        	if (count($oGroup) == 0) {
                            	$oGroupPermission = new sfGuardGroupPermission();
                            	$oGroupPermission->setGroupId($group);
                            	$oGroupPermission->setPermissionId($oSfGuardPermission->getIncremented());
                            	$oGroupPermissionC->add($oGroupPermission);
                        	}
                    	}
                    	$oGroupPermissionC->save();
                	}
                	$oDoctrineConnection->commit();
                	$aData["name"] = $oSfGuardPermission->getName();
                	$aData["description"] = $oSfGuardPermission->getDescription();
                	$aData["users_list"] = Doctrine_Core::getTable("sfGuardUser")->getActiveSfGuardUserByPermissionId($oSfGuardPermission->get("id"), Doctrine_Core::HYDRATE_ARRAY);
                	$aData["groups_list"] = Doctrine_Core::getTable("sfGuardGroup")->getActiveSfGuardGroupByPermissionId($oSfGuardPermission->get("id"), Doctrine_Core::HYDRATE_ARRAY);
                	$aData["is_new"] = $bNew;
            	} catch (Exception $exc) {
                	array_push($aData["message_list"], $exc->getMessage() . "::" . $exc->getCode());
            	}
        	} else {
            	$aData["message_list"] = $oPermissionForm->getErrorList();
        	}
    	} else {
        	$aData["message_list"] = "You're trying to access this page incorrectly, please refer to the group backend administration";
    	}
    	$content = json_encode($aData);
    	$this->getResponse()->setContent($content);
    	return sfView::NONE;
	}
    
	public function executeGetPermissionByPermissionId(sfWebRequest $request) {
    	$this->forwardUnless($sPermissionId = $request->getParameter("permission_id"), "sfGuardPermission", "index");
    	if ($request->isXmlHttpRequest()) {
        	$aData = array();
        	$aData["message_list"] = array();
        	$aSfGuardPermission = Doctrine_Core::getTable("SfGuardPermission")->find($sPermissionId, Doctrine_Core::HYDRATE_ARRAY);
        	if (count($aSfGuardPermission) == 0) {
            	array_push($aData["message_list"], "No record with the give ID was found");
        	} else {
            	$aData["record"] = $aSfGuardPermission;
            	// Getting all the users that have the permissions
            	$aSfGuardUser = Doctrine_Core::getTable("sfGuardUser")->findAll(Doctrine_Core::HYDRATE_ARRAY);
            	foreach ($aSfGuardUser as $user) {
                	$oSfGuardUserPermission = Doctrine_Core::getTable("sfGuardUserPermission")->findOneByUserIdAndPermissionId($user["id"], $aSfGuardPermission["id"]);
                	if ($oSfGuardUserPermission) {
                    	$aData["record"]["users_list"][] = $user["id"];
                	}
            	}
            	// Getting all the groups that have the permission
            	$aSfGuardGroup = Doctrine_Core::getTable("sfGuardGroup")->findAll(Doctrine_Core::HYDRATE_ARRAY);
            	foreach ($aSfGuardGroup as $group) {
                	$oSfGuardGroupPermission = Doctrine_Core::getTable("sfGuardGroupPermission")->findOneByPermissionIdAndGroupId($aSfGuardPermission["id"], $group["id"]);
                	if ($oSfGuardGroupPermission) {
                    	$aData["record"]["groups_list"][] = $group["id"];
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
