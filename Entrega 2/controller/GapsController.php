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
				//var_dump($timesStart);
				if ($timesStart == NULL){
					throw new Exception("2");
				}

				$timesEnd = $_POST['timesEnd'];
				//var_dump($timesEnd);
				if ($timesEnd == NULL){
					throw new Exception("3");
				}

		 		$this->gapMapper->save($dates, $timesStart, $timesEnd, $pollid);
		 		// POST-REDIRECT-GET
		 		//$this->view->setFlash(sprintf(i18n("Gap \"%s\" successfully added."),$gap ->getId()));
		 		//$this->view->redirect("poll", "index");

			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
		}

		$this->view->setVariable("gap", $gap);
		$this->view->render("gaps", "add");

	}


	// public function view(){
	// 	if (!isset($_GET["id"])) {
	// 		throw new Exception("id is mandatory");
	// 	}

	// 	$pollid = $_GET["id"];
	// 	$poll = $this->pollMapper->findById($pollid);
	// 	$gap = $this->gapMapper->findGapsByIdPoll($pollid);

	// 	$assignations = $this->assignationMapper->findUsersAssignationsInPoll($pollid);
	// 	$participants = $this->assignationMapper->findUsersParticipansInPoll($pollid);

	// 	if ($poll == NULL) {
	// 		throw new Exception("no such post with id: ".$pollid);
	// 	} else if ( $gap == NULL){
	// 		throw new Exception("no such gap with id: ".$pollid);
	// 	}else if ( $assignations == NULL){
	// 		throw new Exception("no such assignations with id: ".$pollid);
	// 	}

	// 	$this->view->setVariable("poll", $poll);
	// 	$this->view->setVariable("gap", $gap);
	// 	$this->view->setVariable("usersGaps", $assignations);
	// 	$this->view->setVariable("users", $participants);
	// 	$this->view->render("polls", "view");

	// }
}