<?php
//file: controller/AssignationsController.php

require_once(__DIR__."/../model/AssignationMapper.php");
require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");


class AssignationsController extends BaseController {

	private $assignationMapper;

	public function __construct() {
		parent::__construct();

        $this->pollMapper = new PollMapper();
		$this->gapMapper = new GapMapper();
		$this->assignationMapper = new AssignationMapper();

	}



	public function add(){

        if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Editing participation requires login");
        }
        $user = $this->currentUser;

        if (!isset($_GET["poll"])) {
			throw new Exception("id is mandatory");
        }
		$pollLink =  $_GET["poll"];
		
		$poll = $this->pollMapper->findPollByLink($pollLink);
		if ($poll == NULL) {
			throw new Exception("No such poll with id: ".$poll->getId());
		}
		
        $gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());
		if ($gaps == NULL) {
			throw new Exception("No such gap for the poll with id: ".$poll->getId());
        }


        $assignations = $this->assignationMapper->findUsersAssignationsInPoll($poll->getId());
        $participants = $this->assignationMapper->findUsersParticipansInPoll($poll->getId(), $user->getUsername());

        if (isset($_POST["submit"])) { 
			try {
				$assignations = $_POST["assignations"];
				$this->assignationMapper->addAssignation($user->getUsername(), $assignations, $poll->getId());
				$this->view->setFlash(i18n("Assignations successfully added."));
				$this->view->redirect("polls", "view&poll=$pollLink");
			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
        }
		$this->view->setVariable("poll", $poll);
		$this->view->setVariable("gaps", $gaps);
		$this->view->setVariable("assignations", $assignations);
		$this->view->setVariable("participants", $participants);
		$this->view->render("assignations", "add");
	}


	
	public function edit(){

        if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Editing participation requires login");
        }
        $user = $this->currentUser;

        if (!isset($_GET["poll"])) {
			throw new Exception("id is mandatory");
        }
		$pollLink =  $_GET["poll"];

		$poll = $this->pollMapper->findPollByLink($pollLink);
		if ($poll == NULL) {
			throw new Exception("No such poll with id: ".$pollid);
        }
	
        $gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());
		if ($gaps == NULL) {
			throw new Exception("No such gap for the poll with id: ".$poll->getId());
        }
        
        $assignations = $this->assignationMapper->findUsersAssignationsInPoll($poll->getId());
        if ( $assignations == NULL){
			throw new Exception("No such assignations for the poll with id: ".$poll->getId());
		}

		$participants = $this->assignationMapper->findUsersParticipansInPoll($poll->getId(), $user->getUsername());

        if (isset($_POST["submit"])) { 
			try {
				$newAssignations = $_POST["assignations"];
				$this->assignationMapper->update($user->getUsername(), $newAssignations, $poll->getId());
				$this->view->setFlash(i18n("Assignations successfully updated."));			
				$this->view->redirect("polls", "view&poll=$pollLink");
			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
        }
		$this->view->setVariable("poll", $poll);
		$this->view->setVariable("gaps", $gaps);
		$this->view->setVariable("assignations", $assignations);
		$this->view->setVariable("participants", $participants);
		$this->view->render("assignations", "edit");
	}






        


}