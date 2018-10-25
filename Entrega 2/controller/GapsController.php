<?php
//file: controller/GapsController.php

require_once(__DIR__."/../model/Gap.php");
require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");


class GapsController extends BaseController {

	private $gapMapper;

	public function __construct() {
		parent::__construct();

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
		$pollid = $_GET['poll'];
		$gap->setPoll_id($pollid);

		 if (isset($_POST["submit"])) { 
			try {
				$dates = $_POST["dates"];
				if ($dates == NULL){
					throw new Exception("1");
				}
				
				$timesStart = $_POST['timesStart'];
				if ($timesStart == NULL){
					throw new Exception("2");
				}

				$timesEnd = $_POST['timesEnd'];
				if ($timesEnd == NULL){
					throw new Exception("3");
				}

		 		$gapId = $this->gapMapper->save($dates, $timesStart, $timesEnd, $pollid);
		 		$this->view->setFlash(sprintf(i18n("Gap \"%s\" successfully added."), $gapId));
		 		$this->view->redirect("polls", "view&poll=$pollid");
			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
		}
		$this->view->setVariable("gap", $gap);
		$this->view->render("gaps", "add");
	}



	public function edit() {

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Editing gaps for poll requires login");
		}
		
		if (!isset($_GET["poll"])) {
			throw new Exception("id is mandatory");
		}
		$poll = $_GET['poll'];
		$gaps = $this->gapMapper->findGapsByIdPoll($poll);

		 if (isset($_POST["submit"])) { 
			try {
				$dates = $_POST["dates"];
				
				var_dump($dates);
				// $timesStart = $_POST['timesStart'];
				// $timesEnd = $_POST['timesEnd'];

				// //$this->gappMapper->checkForUpdates($dates, $timesStart,$timesEnd);

		 		// $this->gapMapper->updateGaps($dates, $timesStart, $timesEnd, $poll, $gaps);
		 		// $this->view->setFlash(sprintf(i18n("Poll's gaps \"%s\" successfully edited."), $poll));
		 		// $this->view->redirect("polls", "view&poll=$poll");

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