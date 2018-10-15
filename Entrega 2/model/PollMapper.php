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
		
		$stmt = $this->db->query("SELECT DISTINCT poll.id, poll.title, poll.ubication, poll.author FROM poll, gap, user_selects_gap WHERE '$user' = poll.author OR '$user' = user_selects_gap.username AND user_selects_gap.gap_id = gap.id AND gap.poll_id = poll.id");
		$polls_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$polls = array();

		foreach ($polls_db as $poll) {
			$author = new User($poll["author"]);
			array_push($polls, new Poll($poll["id"], $poll["title"],  $poll["ubication"], $author));
		}

		return $polls;
	}

	
	public function findById($pollid){
		$stmt = $this->db->query("SELECT DISTINCT * FROM poll WHERE poll.id = '$pollid'");
		$stmt->execute(array($pollid));
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
			$link = "https://midominio.com/poll/" . substr(md5($poll_id, false), 0, 20);
			$stmt = $this->db->prepare("UPDATE poll set link=? where id=?");
			$stmt->execute(array($link, $poll_id));
			return $poll_id;

		}

		

		public function update(Poll $poll) {
			$stmt = $this->db->prepare("UPDATE poll set title=?, ubication=? where id=?");
			$stmt->execute(array($poll->getTitle(), $poll->getUbication(), $poll->getId()));
		}



		public function delete(Poll $poll) {
			$stmt = $this->db->prepare("DELETE from poll WHERE id=?");
			$stmt->execute(array($poll->getId()));
		}

	 }
