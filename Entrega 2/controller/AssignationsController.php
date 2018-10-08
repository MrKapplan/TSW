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

	
	public function edit(){

        if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Editing participation requires login");
        }
        $user = $this->currentUser;

        if (!isset($_GET["poll"])) {
			throw new Exception("id is mandatory");
        }

        $pollid =  $_GET["poll"];
        $gaps = $this->gapMapper->findGapsByIdPoll($pollid);

       
		if ($gaps == NULL) {
			throw new Exception("no such gap for the poll with id: ".$pollid);
        }
        
        $poll = $this->pollMapper->findById($pollid);
        
        if ($poll == NULL) {
			throw new Exception("no such poll with id: ".$pollid);
        }
        
        $assignations = $this->assignationMapper->findUsersAssignationsInPoll($pollid);
        $participants = $this->assignationMapper->findUsersParticipansInPoll($pollid);

        if ( $assignations == NULL){
			throw new Exception("no such assignations for the poll with id: ".$pollid);
		}

        
        if (isset($_POST["submit"])) { // reaching via HTTP Post...

			try {
                
                $assignations = $_POST["assignations"];
                

                //update the Post object in the database
                
				$this->assignationMapper->update($user->getUsername(), $assignations);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Gap \"%s\" successfully updated.")));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				//$this->view->redirect("polls", "index");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
        }
        
 
		$this->view->setVariable("poll", $poll);
		$this->view->setVariable("gaps", $gaps);
		$this->view->setVariable("assignations", $assignations);
		$this->view->setVariable("participants", $participants);

		// render the view (/view/posts/add.php)
		$this->view->render("assignations", "edit");
	}

        


}