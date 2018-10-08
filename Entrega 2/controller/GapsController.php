<?php
//file: controller/GapsController.php

require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");


class GapsController extends BaseController {

	private $gapMapper;

	public function __construct() {
		parent::__construct();

		//$this->pollMapper = new PollMapper();
		$this->gapMapper = new GapMapper();

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