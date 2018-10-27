<?php
//file: controller/PollsController.php

require_once(__DIR__."/../model/Poll.php");
require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../model/AssignationMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");




class PollsController extends BaseController {

	private $pollMapper;
	private $gapMapper;
	private $assignationMapper;
	private $errors = array();

	public function __construct() {
		parent::__construct();

		$this->pollMapper = new PollMapper();
		$this->gapMapper = new GapMapper();
		$this->assignationMapper = new AssignationMapper();
	}


	public function index() {

		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger(i18n("Not in session. View polls requires login"));
			$this->view->redirect("users", "login");
		}

		$polls = $this->pollMapper->findAll($_SESSION["currentuser"]);
		$this->view->setVariable("polls", $polls);
		$this->view->render("polls", "index");
	}

	
	public function view(){

		if (!isset($this->currentUser)) {
			$_SESSION['BACK'] =  $_GET["poll"];
			$this->view->setFlashDanger(i18n("Not in session. View polls requires login"));
			$this->view->redirect("users", "login");
		} else {

			if (!isset($_GET["poll"]) || empty($_GET["poll"])) {
				$this->view->setFlashDanger(i18n("The poll id is mandatory"));
				$this->view->redirect("polls", "index");
			}
			$pollLink = $_GET["poll"];

			$poll = $this->pollMapper->findPollByLink($pollLink);
			if ($poll == NULL) {
				$this->view->setFlashDanger(i18n("This poll does not exit"));
				$this->view->redirect("polls", "index");
			} 

			$gap = $this->gapMapper->findGapsByIdPoll($poll->getId());
			$assignations = $this->assignationMapper->findUsersAssignationsInPoll($poll->getId());
			$participants = $this->assignationMapper->findUsersParticipansInPoll($poll->getId(), $this->currentUser->getUsername());
			$isParticipant = $this->assignationMapper->isParticipant($this->currentUser, $poll->getId());

			$this->view->setVariable("poll", $poll);
			$this->view->setVariable("gaps", $gap);
			$this->view->setVariable("assignations", $assignations);
			$this->view->setVariable("participants", $participants);
			$this->view->setVariable("isParticipant", $isParticipant);
			
			$this->view->render("polls", "view");	
		}

	}

	
	public function add() {
		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger(i18n("Not in session. Adding polls requires login"));
			$this->view->redirect("users", "login");
		}
		$poll = new Poll();

		if (isset($_POST["submit"])) { 

			$poll->setTitle($_POST["title"]);

			if(isset($_POST["ubication"])){
				$poll->setUbication($_POST["ubication"]);
			}
			$poll->setAuthor($this->currentUser);

			try {
				$poll->checkIsValidForCreate(); 
				$pollLink = $this->pollMapper->save($poll);
				$this->view->setFlash(sprintf(i18n("Poll \"%s\" successfully added."), $poll->getTitle()));
				$this->view->redirect("gaps", "add&poll=$pollLink");

			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
		}
		$this->view->render("polls", "add");

	}

	
	public function edit() {

		if (!isset($this->currentUser)) {
			$this->view->setFlashDanger(i18n("Not in session. Editing polls requires login"));
			$this->view->redirect("users", "login");
		}

		if (!isset($_REQUEST["poll"]) || empty($_GET["poll"])) {
			$this->view->setFlashDanger(i18n("The poll id is mandatory"));
			$this->view->redirect("polls", "index");
		}
		$pollLink = $_REQUEST["poll"];

		$poll = $this->pollMapper->findPollByLink($pollLink);
		if ($poll == NULL) {
			$this->view->setFlashDanger(i18n("This poll does not exist"));
			$this->view->redirect("polls", "index");
		}

		if ($poll->getAuthor() != $this->currentUser) {
			$this->view->setFlashDanger(i18n("Only the polls author can edit the poll"));
			$this->view->redirect("polls", "index");
		}

		if (isset($_POST["submit"])) { 

			$poll->setTitle($_POST["title"]);
			if(isset($_POST["ubication"])){
				$poll->setUbication($_POST["ubication"]);
			}

			try {
			
				$poll->checkIsValidForUpdate();
				$this->pollMapper->update($poll);
				$this->view->setFlash(sprintf(i18n("Poll \"%s\" successfully updated."),$poll ->getTitle()));
				$this->view->redirect("polls", "index");

			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
		}

		$this->view->setVariable("poll", $poll);
		$this->view->render("polls", "edit");
	}

}
