<?php

/**
 * categoria actions.
 *
 * @package    generador_encuestas
 * @subpackage categoria
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoriaActions extends sfActions {

	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		echo "it's ok";
	}

	/*
	 * 
	 */

	public function executeNuevo(sfWebRequest $request) {
		$this->forwardUnless($category = $request->getParameter("categoria"), "encuesta", "index");
		$aData = array();
		$aData["message_list"] = array();
		$oCenCategoria = new CenCategoriaForm();
		$oCenCategoria->setDefault("cat_fecha_modificacion", date("Y-m-d H:i:s"));
		$oCenCategoria->bind($category);
		if ($request->isXmlHttpRequest()) {
			if ($oCenCategoria->isValid()) {
				$oDoctrineConnection = Doctrine_Manager::getInstance()->getCurrentConnection();
				$oDoctrineConnection->beginTransaction();
				try {
					$bNew = true;
					$category["cat_es_datos_clasificacion"] = (isset($category["cat_es_datos_clasificacion"]) && $category["cat_es_datos_clasificacion"] == "on") ? 1 : 0;
					$params = $request->getRequestParameters();
					if ($params["module"] == "categoria" && $params["action"] == "nuevo") {
						$bActivo = 1;
					} else {
						$bActivo = (isset($category["cat_activo"]) && $category["cat_activo"] == "on") ? 1 : 0;
					}
					if (isset($category["cat_id"]) && $category["cat_id"] != "") {
						$bNew = false;
						$oCenCategoria = Doctrine_Core::getTable("CenCategoria")->findOneBy("cat_id", $category["cat_id"]);
					} else {
						$oCenCategoria = new CenCategoria();
						$oCenCategoria->setCatCreadoPor($this->getUser()->getAttribute("user_id"));
						$oCenCategoria->setCatFechaCreacion(date("Y-m-d i:h:s"));
					}
					$oCenCategoria->setCatModificadoPor($this->getUser()->getAttribute("user_id"));
					$oCenCategoria->setCatFechaModificacion(date("Y-m-d i:h:s"));
					$oCenCategoria->setCatNombre($category["cat_nombre"]);
					$oCenCategoria->setCatEsDatosClasificacion($category["cat_es_datos_clasificacion"]);
					$oCenCategoria->setCatActivo($bActivo);
					$oCenCategoria->save();
					$oDoctrineConnection->commit();
					$aData["cat_id"] = $oCenCategoria->getCatId();
					$aData["cat_nombre"] = $oCenCategoria->getCatNombre();
					$aData["cat_es_datos_clasificacion"] = $oCenCategoria->getCatEsDatosClasificacion();
					$aData["cat_activo"] = $oCenCategoria->getCatActivo();
				} catch (Exception $exc) {
					$oDoctrineConnection->rollback();
					array_push($aData["message_list"], $exc->getMessage() . "::" . $exc->getCode());
				}
			} else {
				$aData["message_list"] = $oCenCategoria->getErrorList();
			}
		} else {
			$aData["message_list"] = UsefullVariables::FormIsNotXmlHttpRequest;
		}
		$content = json_encode($aData);
		$this->getResponse()->setContent($content);
		return sfView::NONE;
	}

	public function executeGetAll(sfWebRequest $request) {
		// $this->forward404Unless($request->isXmlHttpRequest(), "Es necesaria una petición ajax para ingresar a esta página");
		$aData["record"] = Doctrine_Core::getTable("CenCategoria")->getAllActiveCategories(Doctrine_Core::HYDRATE_ARRAY);
		$content = json_encode($aData);
		$this->getResponse()->setContent($content);
		return sfView::NONE;
	}

}
