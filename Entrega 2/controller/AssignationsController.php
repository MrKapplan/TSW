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

        if (isset($_POST["submit"])) { 

			try {
                
				$newAssignations = $_POST["assignations"];
				
				if ( $assignations == NULL){
					throw new Exception("no such assignations for the poll with id: ".$pollid);
				}
        
				$this->assignationMapper->update($user->getUsername(), $newAssignations, $pollid);

				$this->view->setFlash(i18n("Gap successfully updated."));

				
				$this->view->redirect("polls", "view&poll=$pollid");

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