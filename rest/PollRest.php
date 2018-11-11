<?php


require_once(__DIR__."/../model/Poll.php");
require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/../model/Gap.php");
require_once(__DIR__."/../model/GapMapper.php");
require_once(__DIR__."/../model/Assignation.php");
require_once(__DIR__."/../model/AssignationMapper.php");
require_once(__DIR__."/BaseRest.php");


/* Class PostRest
*
* It contains operations for creating, retrieving, updating, deleting and
* listing posts, as well as to create comments to posts.
*
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*/

class PollRest extends BaseRest {
	private $pollMapper;
	private $gapMapper;
	private $assignationMapper;

	public function __construct() {
		parent::__construct();

		$this->pollMapper = new PollMapper();
		$this->gapMapper = new GapMapper();
		$this->assignationMapper = new AssignationMapper();
	}

	public function indexPolls() {
		$currentLogged = parent::authenticateUser();
		$polls = $this->pollMapper->findAll($currentLogged->getUsername());

		$polls_array = array();
		foreach($polls as $poll) {
			array_push($polls_array, array(
				"id" => $poll->getId(),
				"title" => $poll->getTitle(),
				"ubication" => $poll->getUbication(),
				"author" => $poll->getAuthor()->getUsername(),
				"link" => $poll->getLink()
			));
		}

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($polls_array));

	}

	public function addPoll($data) {
		$currentUser = parent::authenticateUser();
		$poll = new Poll();

		$poll->setTitle($data->title);
		$poll->setAuthor($currentUser);
		if (isset($data->ubication)) {
			$poll->setUbication($data->ubication);
		}

		try {
			$poll->checkIsValidForCreate(); 
			$pollLink = $this->pollMapper->save($poll);
			header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
			//header('Location: '.$_SERVER['REQUEST_URI']."/".$postId);
			header('Content-Type: application/json');
			echo(json_encode(array(
				"title"=>$poll->getTitle(),
				"ubication" => $poll->getUbication(),
				"link"=>$pollLink
			)));

		} catch (ValidationException $e) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}

	public function viewPoll($pollLink) {
		$currentLogged = parent::authenticateUser();
		$poll = $this->pollMapper->findPollByLink($pollLink);
		
		if ($poll == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Poll with id ".$pollLink." not found");
			return;
		} else {
			$poll_array = array(
				"id" => $poll->getId(),
				"title" => $poll->getTitle(),
				"ubication" => $poll->getUbication(),
				"author" => $poll->getAuthor()->getusername(),
				"link" => $poll->getLink()
			);
		}

		$gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());
		if($gaps != NULL){
			$assignations = $this->assignationMapper->findUsersAssignationsInPoll($poll->getId());
			$participants = $this->assignationMapper->findUsersParticipansInPoll($poll->getId(), $currentLogged->getUsername());

			$poll_array["gaps"] = array();
			foreach ($gaps as $gap) {
				array_push($poll_array["gaps"], array(
					"id" => $gap->getId(),
					"date" => $gap->getDate(),
					"timeStart" => $gap->getTimeStart()
				));
			}
		}

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($poll_array));
	}


	public function updatePoll($pollLink, $data) {
		$currentUser = parent::authenticateUser();
		$poll = $this->pollMapper->findPollByLink($pollLink);

		if ($poll == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Poll with id ".$pollLink." not found");
			return;
		} else if ($poll->getAuthor() != $currentUser) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("You are not the author of this poll");
			return;
		}else {
			$poll->setTitle($data->title);
			if (isset($data->ubication)) {
				$poll->setUbication($data->ubication);
			}

			try {
				$poll->checkIsValidForUpdate(); 
				$this->pollMapper->update($poll);
				header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
				header('Content-Type: application/json');
				
				$poll_array = array(
					"id" => $poll->getId(),
					"title" => $poll->getTitle(),
					"ubication" => $poll->getUbication(),
					"author" => $poll->getAuthor()->getusername(),
					"link" => $poll->getLink()
		
				);
				echo(json_encode($poll_array));
			}catch (ValidationException $e) {
				header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
				header('Content-Type: application/json');
				echo(json_encode($e->getErrors()));
			}
		}
	}

}

// URI-MAPPING for this Rest endpoint
$pollRest = new PollRest();
URIDispatcher::getInstance()

->map("GET","/poll", array($pollRest,"indexPolls"))
->map("GET","/poll/$1", array($pollRest,"viewPoll"))
->map("POST", "/poll", array($pollRest,"addPoll"))
->map("PUT","/poll/$1", array($pollRest,"updatePoll"));




