<?php

/**
 * Base project form.
 *
 * @package	tsys_escalation
 * @subpackage form
 * @author 	Eduardo Mejía
 * @version	SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
	public function getErrorList() {
    	$aErrors = array();
    	foreach ($this as $formField) {
        	if ($formField->hasError()) {
            	$oError = $formField->getError();
            	$aErrors[] = $oError->getMessage();
        	}
    	}
    	foreach ($this->getGlobalErrors() as $oValidatorError) {
        	$aErrors[] = $oValidatorError->getMessage();
    	}
    	if ($aErrors == null || !isset($aErrors)) {
        	$aErrors = array();
    	}
    	return $aErrors;
	}

	public function throwError($validator, $aErrorsorMessage) {
    	$sfValidatorError = new sfValidatorError($validator, $aErrorsorMessage);
    	throw new sfValidatorErrorSchema($validator, array('app_exception' => $sfValidatorError));
	}

}

