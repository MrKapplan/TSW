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
    

    public function add($pollLink, $data) {
		$currentUser = parent::authenticateUser();
        $poll = $this->pollMapper->findPollByLink($pollLink);

        if($poll == NULL){
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
        }else {
			try {
				// save the Assignation object into the database
				$this->assignationMapper->addAssignation($currentUser->getUsername(), $data, $poll->getId());

				// response CREATED. Also send post in content
				header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
				//header('Location: /meetPoll_TSW/rest/poll/'.$pollLink);
				header('Content-Type: application/json');
                //echo(($poll->getId()));
                echo(json_encode(array(
                    "gap"=>$data
                )));
			} catch (ValidationException $e) {
				header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
				header('Content-Type: application/json');
				echo(json_encode($e->getErrors()));
			}
		}
	}


	public function edit($pollLink, $data) {
		$currentUser = parent::authenticateUser();
        $poll = $this->pollMapper->findPollByLink($pollLink);

        if($poll == NULL){
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
        }else {
			try {
				// save the Assignation object into the database
				$this->assignationMapper->update($currentUser->getUsername(), $data, $poll->getId());

				// response OK. Also send post in content
				header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
				//header('Location: /meetPoll_TSW/rest/poll/'.$pollLink);
				header('Content-Type: application/json');
                //echo(($poll->getId()));
                echo(json_encode(array(
				 	"gap"=>$data
				)));
			} catch (ValidationException $e) {
				header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
				header('Content-Type: application/json');
				echo(json_encode($e->getErrors()));
			}
		}
	}

}

// URI-MAPPING for this Rest endpoint
$assignationRest = new AssignationRest();
URIDispatcher::getInstance()
->map("POST", "/assignation/$1", array($assignationRest, "add"))
->map("PUT", "/assignation/$1", array($assignationRest, "edit"));