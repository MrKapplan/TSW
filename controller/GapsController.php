<?php
//file: controller/GapsController.php

require_once(__DIR__."/../model/Gap.php");
require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");


class GapsController extends BaseController {

	private $gapMapper;

	public function __construct() {
		parent::__construct();

		$this->pollMapper = new PollMapper();
		$this->gapMapper = new GapMapper();
	}

	
	public function add() {

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding gaps for poll requires login");
		}
		$gap = new Gap();
		
		if (!isset($_GET["poll"])) {
			throw new Exception("id is mandatory");
		}
		$pollLink = $_GET['poll'];
		$poll = $this->pollMapper->findPollByLink($pollLink);

		 if (isset($_POST["submit"])) { 
			try {

				$data = json_decode($_POST["data"]);
				if ($data == NULL){
					$errors = "Date and times are mandatory";
					throw new ValidationException($errors, "dateTime is not valid");
				}
				
				$this->gapMapper->checkForAdd_Updates($data);
				
				$gapId = $this->gapMapper->save($data, $poll->getId());
		 		$this->view->setFlash(sprintf(i18n("Gap \"%s\" successfully added."), $gapId));
		 		$this->view->redirect("polls", "view&poll=$pollLink");
			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
		}
		$this->view->setVariable("poll", $poll);
		$this->view->render("gaps", "add");
	}


	public function edit() {

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Editing participation requires login");

		} 
		
		if (!isset($_GET["poll"]) || empty($_GET["poll"])) {
			throw new Exception("id is mandatory");
		} 
			$pollLink = $_GET['poll'];
			$poll = $this->pollMapper->findPollByLink($pollLink);
			$gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());

			if (isset($_POST["submit"])) { 
				try {
					$data = json_decode($_POST["data"]);

					$this->gapMapper->checkForAdd_Updates($data);
					$this->gapMapper->updateGaps($data, $poll->getId(), $gaps);
					$this->view->setFlash(sprintf(i18n("Poll's gaps \"%s\" successfully edited."), $poll->getId()));
					$this->view->redirect("polls", "view&poll=$pollLink");
				}catch(ValidationException $ex) {
					$errors = $ex->getErrors();
					$this->view->setVariable("errors", $errors);
				}
			}

			$this->view->setVariable("poll", $poll);
			$this->view->setVariable("gaps", $gaps);
			$this->view->render("gaps", "edit");
	}
	
	
}
