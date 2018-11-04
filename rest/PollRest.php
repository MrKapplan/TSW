<?php

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../model/Poll.php");
require_once(__DIR__."/../model/PollMapper.php");

require_once(__DIR__."/../model/Gap.php");
require_once(__DIR__."/../model/GapMapper.php");

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

	public function __construct() {
		parent::__construct();

		$this->pollMapper = new PollMapper();
		$this->gapMapper = new gapMapper();
	}

	public function getPolls() {
		$currentLogged = parent::authenticateUser();
		$polls = $this->pollMapper->findAll($currentLogged->getUsername());

		// json_encode Post objects.
		// since Post objects have private fields, the PHP json_encode will not
		// encode them, so we will create an intermediate array using getters and
		// encode it finally

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
	public function createPoll($data) {
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
				"link"=>$pollLink,
				"title"=>$poll->getTitle(),
				"ubication" => $poll->getUbication()
			)));

		} catch (ValidationException $e) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}
	public function readPoll($pollLink) {
		$currentLogged = parent::authenticateUser();
		$poll = $this->pollMapper->findPollByLink($pollLink);
		if ($poll == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Post with id ".$pollLink." not found");
			return;
		}
			$gaps = $this->gapMapper->findGapsByIdPoll($poll->getId());
			if(!empty($gaps)){
				$assignations = $this->assignationMapper->findUsersAssignationsInPoll($poll->getId());
				$participants = $this->assignationMapper->findUsersParticipansInPoll($poll->getId(), $currentLogged);
				$isParticipant = $this->assignationMapper->isParticipant($currentLogged, $poll->getId());
			}

		$poll_array = array(
			"id" => $poll->getId(),
			"title" => $poll->getTitle(),
			"ubication" => $poll->getUbication(),
			"author_id" => $poll->getAuthor()->getusername()

		);

		
		$poll_array["gaps"] = array();
		foreach ($gaps as $gap) {
			array_push($poll_array["gaps"], array(
				"id" => $gap->getId(),
				"date" => $gap->getDate(),
				"timeStart" => $gap->getTimeStart()
			));
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
			echo("Post with id ".$pollLink." not found");
			return;
		}

		// Check if the Post author is the currentUser (in Session)
		if ($poll->getAuthor() != $currentUser) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("you are not the author of this post");
			return;
		}
		$poll->setTitle($data->title);
		if (isset($data->ubication)) {
			
			$poll->setUbication($data->ubication);

		}

		try {
			// validate Post object
			$poll->checkIsValidForUpdate(); // if it fails, ValidationException
			$this->pollMapper->update($poll);
			header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
			header('Content-Type: application/json');
			
			$poll_array = array(
				"id" => $poll->getId(),
				"title" => $poll->getTitle(),
				"ubication" => $poll->getUbication(),
				"author_id" => $poll->getAuthor()->getusername()
	
			);
			echo(json_encode($poll_array));
		}catch (ValidationException $e) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}
/*
	public function createPost($data) {
		$currentUser = parent::authenticateUser();
		$post = new Post();

		if (isset($data->title) && isset($data->content)) {
			$post->setTitle($data->title);
			$post->setContent($data->content);

			$post->setAuthor($currentUser);
		}

		try {
			// validate Post object
			$post->checkIsValidForCreate(); // if it fails, ValidationException

			// save the Post object into the database
			$postId = $this->postMapper->save($post);

			// response OK. Also send post in content
			header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
			header('Location: '.$_SERVER['REQUEST_URI']."/".$postId);
			header('Content-Type: application/json');
			echo(json_encode(array(
				"id"=>$postId,
				"title"=>$post->getTitle(),
				"content" => $post->getContent()
			)));

		} catch (ValidationException $e) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}

	public function readPost($postId) {
		// find the Post object in the database
		$post = $this->postMapper->findByIdWithComments($postId);
		if ($post == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Post with id ".$postId." not found");
			return;
		}

		$post_array = array(
			"id" => $post->getId(),
			"title" => $post->getTitle(),
			"content" => $post->getContent(),
			"author_id" => $post->getAuthor()->getusername()

		);

		//add comments
		$post_array["comments"] = array();
		foreach ($post->getComments() as $comment) {
			array_push($post_array["comments"], array(
				"id" => $comment->getId(),
				"content" => $comment->getContent(),
				"author" => $comment->getAuthor()->getusername()
			));
		}

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($post_array));
	}

	public function updatePost($postId, $data) {
		$currentUser = parent::authenticateUser();

		$post = $this->postMapper->findById($postId);
		if ($post == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Post with id ".$postId." not found");
			return;
		}

		// Check if the Post author is the currentUser (in Session)
		if ($post->getAuthor() != $currentUser) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("you are not the author of this post");
			return;
		}
		$post->setTitle($data->title);
		$post->setContent($data->content);

		try {
			// validate Post object
			$post->checkIsValidForUpdate(); // if it fails, ValidationException
			$this->postMapper->update($post);
			header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		}catch (ValidationException $e) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}

	public function deletePost($postId) {
		$currentUser = parent::authenticateUser();
		$post = $this->postMapper->findById($postId);

		if ($post == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Post with id ".$postId." not found");
			return;
		}
		// Check if the Post author is the currentUser (in Session)
		if ($post->getAuthor() != $currentUser) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("you are not the author of this post");
			return;
		}

		$this->postMapper->delete($post);

		header($_SERVER['SERVER_PROTOCOL'].' 204 No Content');
	}

	public function createComment($postId, $data) {
		$currentUser = parent::authenticateUser();

		$post = $this->postMapper->findById($postId);
		if ($post == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Post with id ".$postId." not found");
			return;
		}

		$comment = new Comment();
		$comment->setContent($data->content);
		$comment->setAuthor($currentUser);
		$comment->setPost($post);

		try {
			$comment->checkIsValidForCreate(); // if it fails, ValidationException

			$this->commentMapper->save($comment);

			header($_SERVER['SERVER_PROTOCOL'].' 201 Created');

		}catch(ValidationException $e) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}
*/
}

// URI-MAPPING for this Rest endpoint
$pollRest = new PollRest();
URIDispatcher::getInstance()

->map("GET","/poll", array($pollRest,"getPolls"))

->map("GET","/poll/$1", array($pollRest,"readPoll"))
->map("POST", "/poll", array($pollRest,"createPoll"))
//->map("POST", "/post/$1/comment", array($postRest,"createComment"))
->map("PUT","/poll/$1", array($pollRest,"updatePoll"));
//->map("DELETE", "/post/$1", array($postRest,"deletePost"));



