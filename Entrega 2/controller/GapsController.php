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
			throw new Exception("Not in session. Adding polls requires login");
		}
		$gap = new Gap();
		
		if (!isset($_GET["poll"])) {
			throw new Exception("id is mandatory");
		}

		$pollid = $_GET['poll'];
		$gap->setPoll_id($pollid);

		// if (isset($_POST["submit"])) { 

		// 	$poll->setTitle($_POST["title"]);
		// 	if(isset($_POST["ubication"])){
		// 		$poll->setUbication($_POST["ubication"]);
		// 	}
		// 	// The user of the Post is the currentUser(user in session)
		// 	$poll->setAuthor($this->currentUser);
		// 	$link = "https://midominio.com/poll/" . substr(md5($poll->getTitle(), false), 0, 20);
		// 	$poll->setLink($link);
			

		// 	try {
		// 		$poll->checkIsValidForCreate(); 
		// 		$this->pollMapper->save($poll);
		// 		// POST-REDIRECT-GET
		// 		$this->view->setFlash(sprintf(i18n("Poll \"%s\" successfully added."),$poll ->getTitle()));
		// 		$this->view->redirect("gaps", "add");

		// 	}catch(ValidationException $ex) {
		// 		$errors = $ex->getErrors();
		// 		$this->view->setVariable("errors", $errors);
		// 	}
		// }

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