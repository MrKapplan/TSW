<?php

require_once(__DIR__."/../model/Gap.php");
require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../model/Poll.php");
require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/BaseRest.php");

/**
* Class GapRest
*
* It contains operations for adding and check users credentials.
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*
*/

class GapRest extends BaseRest {
	private $gapMapper;

	public function __construct() {
		parent::__construct();

        $this->gapMapper = new GapMapper();
        $this->pollMapper = new PollMapper();
    }
    

    public function addGap($pollLink, $data) {
		$currentUser = parent::authenticateUser();
        $poll = $this->pollMapper->findPollByLink($pollLink);


        if($poll == NULL){
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
        }else if($currentUser->getUsername() != $poll->getAuthor()->getUsername()){
            header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("You are not authorized to add gap if you are not the poll's author");
        } else {
			try {
				$this->gapMapper->checkForAdd_Updates($data);
				$this->gapMapper->save($data, $poll->getId());

				header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
				//header('Location: /meetPoll_TSW/rest/poll/'.$pollLink);
				header('Content-Type: application/json');
				echo(json_encode(array(
					"pollid"=>$poll->getId(),
					"title"=>$poll->getTitle(),
					"ubication"=>$poll->getUbication(),
					"link"=>$poll->getLink(),
					"gaps"=>$data
				)));

			} catch (ValidationException $e) {
				header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
				header('Content-Type: application/json');
				echo(json_encode($e->getErrors()));
			}
		}
	}


	public function updateGap($pollLink, $data) {
		$currentUser = parent::authenticateUser();
        $poll = $this->pollMapper->findPollByLink($pollLink);

        if($poll == NULL){
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
        } else if($currentUser->getUsername() != $poll->getAuthor()->getUsername()){
            header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("You are not authorized to add gap if you are not the poll's author");
        } else{
			try {
				$gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());

				$this->gapMapper->checkForAdd_Updates($data);
				$this->gapMapper->updateGaps($data, $poll->getId(), $gaps);
				header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
				//header('Location: /meetPoll_TSW/rest/poll/'.$pollLink);
				header('Content-Type: application/json');
				echo(json_encode(array(
					"pollid"=>$poll->getId(),
					"title"=>$poll->getTitle(),
					"ubication"=>$poll->getUbication(),
					"link"=>$poll->getLink(),
					"gaps"=>$data
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
$gapRest = new GapRest();
URIDispatcher::getInstance()
->map("POST", "/gap/$1", array($gapRest, "addGap"))
->map("PUT", "/gap/$1", array($gapRest, "updateGap"));