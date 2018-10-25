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
			throw new Exception("Not in session. Editing gaps for poll requires login");
		}
		
		if (!isset($_GET["poll"])) {
			throw new Exception("id is mandatory");
		}
		$pollLink = $_GET['poll'];
		
		$gaps = $this->gapMapper->findGapsByIdPoll($poll);

		 if (isset($_POST["submit"])) { 
			try {
				$data = json_decode($_POST["data"]);

				if ($data == NULL){
					throw new Exception("3");
				}

				//$this->gappMapper->checkForUpdates($data);
				//var_dump(count($data));
				//var_dump($data[0]->date);
				
		 		$this->gapMapper->updateGaps($data, $poll, $gaps);
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