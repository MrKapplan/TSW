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

	public function __construct() {
		parent::__construct();

		$this->pollMapper = new PollMapper();
		$this->gapMapper = new GapMapper();
		$this->assignationMapper = new AssignationMapper();
	}


	public function index() {

		$polls = $this->pollMapper->findAll($_SESSION["currentuser"]);
		$this->view->setVariable("polls", $polls);
		$this->view->render("polls", "index");
	}

	
	public function view(){

		if (!isset($this->currentUser)) {
			$_SESSION['BACK'] =  $_GET["poll"];
			$this->view->redirect("users", "login");
		} else {

		if (!isset($_GET["poll"])) {
			//throw new Exception("id is mandatory");

		}
		$pollLink = $_GET["poll"];

		$poll = $this->pollMapper->findPollByLink($pollLink);
		if ($poll == NULL) {
			throw new Exception("no such post with id: ".$pollLink);
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
			throw new Exception("Not in session. Adding polls requires login");
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
			throw new Exception("Not in session. Editing polls requires login");
		}

		if (!isset($_REQUEST["poll"])) {
			throw new Exception("A poll id is mandatory");
		}
		$pollLink = $_REQUEST["poll"];

		$poll = $this->pollMapper->findPollByLink($pollLink);
		if ($poll == NULL) {
			throw new Exception("no such poll with id: ".$poll->getId());
		}

		if ($poll->getAuthor() != $this->currentUser) {
			throw new Exception("Logged user is not the author of the poll ".$poll->getId());
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
