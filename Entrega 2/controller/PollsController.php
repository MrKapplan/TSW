<?php
//file: controller/PollsController.php

require_once(__DIR__."/../model/Poll.php");
require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../model/AssignationMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
* Class pollsController
*
* Controller to make a CRUDL of polls entities
*
* @author lipido <lipido@gmail.com>
*/
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
		if (!isset($_GET["id"])) {
			throw new Exception("id is mandatory");
		}

		$pollid = $_GET["id"];
		$poll = $this->pollMapper->findById($pollid);
		$gap = $this->gapMapper->findGapsByIdPoll($pollid);

		$assignations = $this->assignationMapper->findUsersAssignationsInPoll($pollid);
		$participants = $this->assignationMapper->findUsersParticipansInPoll($pollid);

		if ($poll == NULL) {
			throw new Exception("no such post with id: ".$pollid);
		} else if ( $gap == NULL){
			throw new Exception("no such gap with id: ".$pollid);
		}else if ( $assignations == NULL){
			throw new Exception("no such assignations with id: ".$pollid);
		}

		$this->view->setVariable("poll", $poll);
		$this->view->setVariable("gap", $gap);
		$this->view->setVariable("usersGaps", $assignations);
		$this->view->setVariable("users", $participants);
		$this->view->render("polls", "view");

	}

	
	// public function add() {
	// 	if (!isset($this->currentUser)) {
	// 		throw new Exception("Not in session. Adding polls requires login");
	// 	}

	// 	$poll = new Post();

	// 	if (isset($_POST["submit"])) { // reaching via HTTP Post...

	// 		// populate the Post object with data form the form
	// 		$poll->setTitle($_POST["title"]);
	// 		$poll->setContent($_POST["content"]);

	// 		// The user of the Post is the currentUser (user in session)
	// 		$poll->setAuthor($this->currentUser);

	// 		try {
	// 			// validate Post object
	// 			$poll->checkIsValidForCreate(); // if it fails, ValidationException

	// 			// save the Post object into the database
	// 			$this->pollMapper->save($pollid);

	// 			// POST-REDIRECT-GET
	// 			// Everything OK, we will redirect the user to the list of polls
	// 			// We want to see a message after redirection, so we establish
	// 			// a "flash" message (which is simply a Session variable) to be
	// 			// get in the view after redirection.
	// 			$this->view->setFlash(sprintf(i18n("Poll \"%s\" successfully added."),$poll ->getTitle()));

	// 			// perform the redirection. More or less:
	// 			// header("Location: index.php?controller=polls&action=index")
	// 			// die();
	// 			$this->view->redirect("polls", "index");

	// 		}catch(ValidationException $ex) {
	// 			// Get the errors array inside the exepction...
	// 			$errors = $ex->getErrors();
	// 			// And put it to the view as "errors" variable
	// 			$this->view->setVariable("errors", $errors);
	// 		}
	// 	}

	// 	// Put the Post object visible to the view
	// 	$this->view->setVariable("post", $pollid);

	// 	// render the view (/view/polls/add.php)
	// 	$this->view->render("polls", "add");

	// }

	
	// public function edit() {
	// 	if (!isset($_REQUEST["id"])) {
	// 		throw new Exception("A post id is mandatory");
	// 	}

	// 	if (!isset($this->currentUser)) {
	// 		throw new Exception("Not in session. Editing polls requires login");
	// 	}


	// 	// Get the Post object from the database
	// 	$pollid = $_REQUEST["id"];
	// 	$poll = $this->pollMapper->findById($pollid);

	// 	// Does the post exist?
	// 	if ($poll == NULL) {
	// 		throw new Exception("no such post with id: ".$pollid);
	// 	}

	// 	// Check if the Post author is the currentUser (in Session)
	// 	if ($poll->getAuthor() != $this->currentUser) {
	// 		throw new Exception("logged user is not the author of the post id ".$pollid);
	// 	}

	// 	if (isset($_POST["submit"])) { // reaching via HTTP Post...

	// 		// populate the Post object with data form the form
	// 		$poll->setTitle($_POST["title"]);
	// 		$poll->setContent($_POST["content"]);

	// 		try {
	// 			// validate Post object
	// 			$poll->checkIsValidForUpdate(); // if it fails, ValidationException

	// 			// update the Post object in the database
	// 			$this->pollMapper->update($poll);

	// 			// POST-REDIRECT-GET
	// 			// Everything OK, we will redirect the user to the list of polls
	// 			// We want to see a message after redirection, so we establish
	// 			// a "flash" message (which is simply a Session variable) to be
	// 			// get in the view after redirection.
	// 			$this->view->setFlash(sprintf(i18n("Post \"%s\" successfully updated."),$poll ->getTitle()));

	// 			// perform the redirection. More or less:
	// 			// header("Location: index.php?controller=polls&action=index")
	// 			// die();
	// 			$this->view->redirect("polls", "index");

	// 		}catch(ValidationException $ex) {
	// 			// Get the errors array inside the exepction...
	// 			$errors = $ex->getErrors();
	// 			// And put it to the view as "errors" variable
	// 			$this->view->setVariable("errors", $errors);
	// 		}
	// 	}

	// 	// Put the Post object visible to the view
	// 	$this->view->setVariable("post", $poll);

	// 	// render the view (/view/polls/add.php)
	// 	$this->view->render("polls", "edit");
	// }

// 	/**
// 	* Action to delete a post
// 	*
// 	* This action should only be called via HTTP POST
// 	*
// 	* The expected HTTP parameters are:
// 	* <ul>
// 	* <li>id: Id of the post (via HTTP POST)</li>
// 	* </ul>
// 	*
// 	* The views are:
// 	* <ul>
// 	* <li>polls/index: If post was successfully deleted (via redirect)</li>
// 	* </ul>
// 	* @throws Exception if no id was provided
// 	* @throws Exception if no user is in session
// 	* @throws Exception if there is not any post with the provided id
// 	* @throws Exception if the author of the post to be deleted is not the current user
// 	* @return void
// 	*/
// 	public function delete() {
// 		if (!isset($_POST["id"])) {
// 			throw new Exception("id is mandatory");
// 		}
// 		if (!isset($this->currentUser)) {
// 			throw new Exception("Not in session. Editing polls requires login");
// 		}
		
// 		// Get the Post object from the database
// 		$pollid = $_REQUEST["id"];
// 		$poll = $this->pollMapper->findById($pollid);

// 		// Does the post exist?
// 		if ($poll == NULL) {
// 			throw new Exception("no such post with id: ".$pollid);
// 		}

// 		// Check if the Post author is the currentUser (in Session)
// 		if ($poll->getAuthor() != $this->currentUser) {
// 			throw new Exception("Post author is not the logged user");
// 		}

// 		// Delete the Post object from the database
// 		$this->pollMapper->delete($poll);

// 		// POST-REDIRECT-GET
// 		// Everything OK, we will redirect the user to the list of polls
// 		// We want to see a message after redirection, so we establish
// 		// a "flash" message (which is simply a Session variable) to be
// 		// get in the view after redirection.
// 		$this->view->setFlash(sprintf(i18n("Polls \"%s\" successfully deleted."),$poll ->getTitle()));

// 		// perform the redirection. More or less:
// 		// header("Location: index.php?controller=polls&action=index")
// 		// die();
// 		$this->view->redirect("polls", "index");

// 	}

}
