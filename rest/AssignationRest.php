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
        $gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());

        if($poll == NULL){
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
        }else if($gaps == NULL){
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            header('Content-Type: application/json');
        }else {
            
			try {
                
				// validate Gaps object
				//$this->gapMapper->checkForAdd_Updates($data);

				// save the Assignation object into the database
				$this->assignationMapper->addAssignation($currentUser->getUsername(), $data, $poll->getId());

				// response OK. Also send post in content
				header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
				//header('Location: /meetPoll_TSW/rest/poll/'.$pollLink);
				//header('Content-Type: application/json');
				// echo(json_encode(array(
				// 	"date"=>$postId,
				// 	"start"=>$post->getTitle(),
				// 	"end" => $post->getContent()
				// )));

			} catch (ValidationException $e) {
				header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
				header('Content-Type: application/json');
				echo(json_encode($e->getErrors()));
			}
		}
	}


	// public function edit($pollLink, $data) {
	// 	$currentUser = parent::authenticateUser();
    //     $poll = $this->pollMapper->findPollByLink($pollLink);

    //     if($poll == NULL){
    //         header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
	// 		header('Content-Type: application/json');
    //     } else if($currentUser->getUsername() != $poll->getAuthor()->getUsername()){
    //         header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	// 		echo("You are not authorized to add gap if you are not the poll's author");
    //     } else{
	// 		try {
	// 			$gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());

	// 			// validate Gaps object
	// 			$this->gapMapper->checkForAdd_Updates($data);

	// 			// save the Gaps object into the database
	// 			$this->gapMapper->updateGaps($data, $poll->getId(), $gaps);

	// 			// response OK. Also send post in content
	// 			header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
	// 			//header('Location: /meetPoll_TSW/rest/poll/'.$pollLink);
	// 			//header('Content-Type: application/json');
	// 			// echo(json_encode(array(
	// 			// 	"date"=>$postId,
	// 			// 	"start"=>$post->getTitle(),
	// 			// 	"end" => $post->getContent()
	// 			// )));

	// 		} catch (ValidationException $e) {
	// 			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
	// 			header('Content-Type: application/json');
	// 			echo(json_encode($e->getErrors()));
	// 		}
	// 	}
	// }

}

// URI-MAPPING for this Rest endpoint
$assignationRest = new AssignationRest();
URIDispatcher::getInstance()
->map("POST", "/assignation/$1", array($assignationRest, "add"));
// ->map("PUT", "/gap/$1", array($gapRest, "edit"));