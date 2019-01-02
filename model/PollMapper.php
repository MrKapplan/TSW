<?php
// file: model/PollMapper.php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Poll.php");
require_once(__DIR__."/../model/Gap.php");


class PollMapper {

	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	public function findAll($user) {
		
		$stmt = $this->db->query("SELECT DISTINCT poll.id, poll.title, poll.ubication, poll.author, poll.link FROM poll, gap, user_selects_gap WHERE '$user' = poll.author OR poll.id = user_selects_gap.poll_id AND user_selects_gap.username = '$user'");
		$polls_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$polls = array();

		foreach ($polls_db as $poll) {
			$author = new User($poll["author"]);
			array_push($polls, new Poll($poll["id"], $poll["title"], $poll["ubication"], $author, $poll["link"]));
		}

		return $polls;
	}

	
	public function findPollByLink($pollLink){
		
		$stmt = $this->db->query("SELECT DISTINCT * FROM poll WHERE link = '$pollLink'");
		$poll = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($poll != null) {
			return new Poll(
			$poll["id"],
			$poll["title"],
			$poll["ubication"],
			new User($poll["author"]),
			$poll["link"]
		);
		} else {
			return NULL;
		}
	}

		public function save(Poll $poll) {
			
			$stmt = $this->db->prepare("INSERT INTO poll(title, ubication, author) values (?,?,?)");
			$stmt->execute(array($poll->getTitle(), $poll->getUbication(), $poll->getAuthor()->getUsername()));
			$poll_id = $this->db->lastInsertId();
			$link = $this->generateLink($poll_id);
			return $link;

		}

		public function update(Poll $poll) {
			$stmt = $this->db->prepare("UPDATE poll set title=?, ubication=? where id=?");
			$stmt->execute(array($poll->getTitle(), $poll->getUbication(), $poll->getId()));
		}

		public function generateLink($poll){
			$link = md5("pollid".$poll, false);
			$stmt = $this->db->prepare("UPDATE poll set link=? where id=?");
			$stmt->execute(array($link, $poll));

			return $link;
		}

		public function deletePoll(Poll $poll) {
			$stmt = $this->db->prepare("DELETE FROM poll set where id=?");
			$stmt->execute(array($poll->getId()));
		}

	 }
