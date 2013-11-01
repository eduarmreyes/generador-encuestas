<?php

/**
 * encuesta actions.
 *
 * @package    generador_encuestas
 * @subpackage encuesta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class encuestaActions extends sfActions {

	public function executeIndex(sfWebRequest $request) {
		$this->encuesta = new CenEncuestaForm();
		$this->encuesta_categoria = new CenEncuestaCategoriaForm();
		$this->categoria = new CenCategoriaForm();
	}

	public function executeNew(sfWebRequest $request) {
		$this->form = new CenEncuestaForm();
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new CenEncuestaForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($cen_encuesta = Doctrine_Core::getTable('CenEncuesta')->find(array($request->getParameter('enc_id'))), sprintf('Object cen_encuesta does not exist (%s).', $request->getParameter('enc_id')));
		$this->form = new CenEncuestaForm($cen_encuesta);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($cen_encuesta = Doctrine_Core::getTable('CenEncuesta')->find(array($request->getParameter('enc_id'))), sprintf('Object cen_encuesta does not exist (%s).', $request->getParameter('enc_id')));
		$this->form = new CenEncuestaForm($cen_encuesta);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection();

		$this->forward404Unless($cen_encuesta = Doctrine_Core::getTable('CenEncuesta')->find(array($request->getParameter('enc_id'))), sprintf('Object cen_encuesta does not exist (%s).', $request->getParameter('enc_id')));
		$cen_encuesta->delete();

		$this->redirect('encuesta/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid()) {
			$cen_encuesta = $form->save();

			$this->redirect('encuesta/edit?enc_id=' . $cen_encuesta->getEncId());
		}
	}

}
