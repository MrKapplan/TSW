<?php
//file: controller/AssignationsController.php

require_once(__DIR__."/../model/AssignationMapper.php");
require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");


class AssignationsController extends BaseController {

	private $assignationMapper;
	private $gapMapper;
	private $pollMapper;

	public function __construct() {
		parent::__construct();

        $this->pollMapper = new PollMapper();
		$this->gapMapper = new GapMapper();
		$this->assignationMapper = new AssignationMapper();

	}



	public function add(){

        if (!isset($this->currentUser)) {
			$this->view->setFlashDanger(i18n("Not in session. Adding participation requires login"));
			$this->view->redirect("users", "login");
        }
        $user = $this->currentUser;

        if (!isset($_GET["poll"])) {
			$this->view->setFlashDanger(i18n("The poll id is mandatory"));
			$this->view->redirect("polls", "index");
        }
		$pollLink =  $_GET["poll"];
		
		$poll = $this->pollMapper->findPollByLink($pollLink);
		if ($poll == NULL) {
			$this->view->setFlashDanger(i18n("This poll does not exist"));
			$this->view->redirect("polls", "index");
        }
		
        $gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());
		if ($gaps == NULL) {
			$this->view->setFlashDanger(sprintf(i18n("There are no gaps for the poll \"%s\""), $poll->getTitle()));
			$this->view->redirect("polls", "view&poll=$pollLink");
        }

        $assignationsDB = $this->assignationMapper->findUsersAssignationsInPoll($poll->getId());
        $participantsDB = $this->assignationMapper->findUsersParticipansInPoll($poll->getId(), $user->getUsername());

        if (isset($_POST["submit"])) { 
			try {

				$assignations = json_decode($_POST["assignations"]);

				$this->assignationMapper->addAssignation($user->getUsername(), $assignations, $poll->getId());
				$this->view->setFlash(i18n("Assignations successfully added."));
				//$this->view->redirect("polls", "view&poll=$pollLink");
			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
        }
		$this->view->setVariable("poll", $poll);
		$this->view->setVariable("gaps", $gaps);
		$this->view->setVariable("assignations", $assignationsDB);
		$this->view->setVariable("participants", $participantsDB);
		$this->view->render("assignations", "add");
	}


	
	public function edit(){

        if (!isset($this->currentUser)) {
			$this->view->setFlashDanger(i18n("Not in session. Editing participation requires login"));
			$this->view->redirect("users", "login");
        }
        $user = $this->currentUser;

        if (!isset($_GET["poll"]) || empty($_GET['poll'])) {
			$this->view->setFlashDanger(i18n("The poll id is mandatory"));
			$this->view->redirect("polls", "index");
        }
		$pollLink =  $_GET["poll"];

		$poll = $this->pollMapper->findPollByLink($pollLink);
		if ($poll == NULL) {
			$this->view->setFlashDanger(i18n("This poll does not exist"));
			$this->view->redirect("polls", "index");
        }
        $gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());
		if ($gaps == NULL) {
			$this->view->setFlashDanger(sprintf(i18n("There are no gaps for the poll \"%s\""), $poll->getTitle()));
			$this->view->redirect("polls", "view&poll=$pollLink");
        }
        
        $assignations = $this->assignationMapper->findUsersAssignationsInPoll($poll->getId());
        if ( $assignations == NULL){
			$this->view->setFlashDanger(sprintf(i18n("You have not participated in the survey \"%s\" yet"), $poll->getTitle()));
			$this->view->redirect("polls", "view&poll=$pollLink");
		}

		$participants = $this->assignationMapper->findUsersParticipansInPoll($poll->getId(), $user->getUsername());

        if (isset($_POST["submit"])) { 
			try {

				$newAssignations = json_decode($_POST["assignations"]);
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