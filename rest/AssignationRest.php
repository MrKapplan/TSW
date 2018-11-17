<?php

require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/../model/AssignationMapper.php");
require_once(__DIR__."/BaseRest.php");

/**
* ClassAssignationRest
*
* It contains operations for adding and check users credentials.
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*
*/

class AssignationRest extends BaseRest {
	private $pollMapper;
    private $gapMapper;
    private $assignationMapper;

	public function __construct() {
		parent::__construct();

        $this->gapMapper = new GapMapper();
        $this->pollMapper = new PollMapper();
        $this->assignationMapper = new AssignationMapper();
    }
    

    public function addAssignations($pollLink, $data) {
		$currentUser = parent::authenticateUser();
        $poll = $this->pollMapper->findPollByLink($pollLink);

        if($poll == NULL){
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
        }else {
			try {
				$this->assignationMapper->addAssignation($currentUser->getUsername(), $data, $poll->getId());
				header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
				//header('Location: /meetPoll_TSW/rest/poll/'.$pollLink);
				header('Content-Type: application/json');
				echo(json_encode(array(
					"pollid"=>$poll->getId(),
					"title"=>$poll->getTitle(),
					"ubication"=>$poll->getUbication(),
					"link"=>$poll->getLink(),
					"user"=>$currentUser->getUsername(),
					"assignation"=>$data
				)));
			} catch (ValidationException $e) {
				header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
				header('Content-Type: application/json');
				echo(json_encode($e->getErrors()));
			}
		}
	}


	public function editAssignations($pollLink, $data) {
		$currentUser = parent::authenticateUser();
        $poll = $this->pollMapper->findPollByLink($pollLink);

        if($poll == NULL){
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
        }else {
			try {
				$this->assignationMapper->update($currentUser->getUsername(), $data, $poll->getId());
				header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
				//header('Location: /meetPoll_TSW/rest/poll/'.$pollLink);
				header('Content-Type: application/json');
				echo(json_encode(array(
					"pollid"=>$poll->getId(),
					"title"=>$poll->getTitle(),
					"ubication"=>$poll->getUbication(),
					"link"=>$poll->getLink(),
					"user"=>$currentUser->getUsername(),
					"newAssignations"=>$data
				)));
			} catch (ValidationException $e) {
				header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
				header('Content-Type: application/json');
				echo(json_encode($e->getErrors()));
			}
		}
	}


	public function viewAssignations($pollLink) {
		$currentLogged = parent::authenticateUser();

		try{
			//$assignations = $this->assignationMapper->findAssignationsByLinkPoll($pollLink, $currentLogged->getUsername());
			$isParticipant = $this->assignationMapper->isParticipantByPollLink($currentLogged, $pollLink);
			$participants = $this->assignationMapper->findUsersParticipansInPollByLink($pollLink, $currentLogged->getUsername());

			$assignations = $this->assignationMapper->findAssignationUsers($pollLink,$currentLogged->getUsername());
			$assignations_array['assignations'] = array();


			foreach($assignations as $assignation){
				array_push($assignations_array['assignations'], $assignation);
			}
			

			$assignations_array['isParticipant'] = $isParticipant;
			//array_push($assignations_array['isParticipant'], $isParticipant);


			header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
			header('Content-Type: application/json');
			echo(json_encode($assignations_array));
			// $as = array();
			// array_push($as, $assignations_array);
			// array_push($as, $participations_array);
			// echo(json_encode($as));
		}catch(ValidationException $e){
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}

}

// URI-MAPPING for this Rest endpoint
$assignationRest = new AssignationRest();
URIDispatcher::getInstance()
->map("GET", "/assignation/$1", array($assignationRest, "viewAssignations"))
->map("POST", "/assignation/$1", array($assignationRest, "addAssignations"))
->map("PUT", "/assignation/$1", array($assignationRest, "editAssignations"));