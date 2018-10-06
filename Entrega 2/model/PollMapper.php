<?php
// file: model/PollMapper.php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Poll.php");


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
		$stmt = $this->db->prepare("SELECT DISTINCT poll.id, poll.title, poll.ubication, poll.author, poll.link, user_selects_gap.username, gap.date, gap.timeStart, gap.timeEnd FROM poll, user_selects_gap, gap WHERE poll.id = '$pollid' AND gap.id = user_selects_gap.gap_id");
		$stmt->execute(array($pollid));
		$poll = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($poll != null) {
			return new Poll(
			$poll["id"],
			$poll["title"],
			new User($post["author"]),
			$poll["link"]
		);
		} else {
			return NULL;
		}
	}

	/**
	* Loads a Post from the database given its id
	*
	* It includes all the comments
	*
	* @throws PDOException if a database error occurs
	* @return Post The Post instances (without comments). NULL
	* if the Post is not found
	*/
	public function findByIdWithComments($postid){
		$stmt = $this->db->prepare("SELECT
			P.id as 'post.id',
			P.title as 'post.title',
			P.content as 'post.content',
			P.author as 'post.author',
			C.id as 'comment.id',
			C.content as 'comment.content',
			C.post as 'comment.post',
			C.author as 'comment.author'

			FROM posts P LEFT OUTER JOIN comments C
			ON P.id = C.post
			WHERE
			P.id=? ");

			$stmt->execute(array($postid));
			$post_wt_comments= $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (sizeof($post_wt_comments) > 0) {
				$post = new Post($post_wt_comments[0]["post.id"],
				$post_wt_comments[0]["post.title"],
				$post_wt_comments[0]["post.content"],
				new User($post_wt_comments[0]["post.author"]));
				$comments_array = array();
				if ($post_wt_comments[0]["comment.id"]!=null) {
					foreach ($post_wt_comments as $comment){
						$comment = new Comment( $comment["comment.id"],
						$comment["comment.content"],
						new User($comment["comment.author"]),
						$post);
						array_push($comments_array, $comment);
					}
				}
				$post->setComments($comments_array);

				return $post;
			}else {
				return NULL;
			}
		}

		/**
		* Saves a Post into the database
		*
		* @param Post $post The post to be saved
		* @throws PDOException if a database error occurs
		* @return int The mew post id
		*/
		public function save(Post $post) {
			$stmt = $this->db->prepare("INSERT INTO posts(title, content, author) values (?,?,?)");
			$stmt->execute(array($post->getTitle(), $post->getContent(), $post->getAuthor()->getUsername()));
			return $this->db->lastInsertId();
		}

		/**
		* Updates a Post in the database
		*
		* @param Post $post The post to be updated
		* @throws PDOException if a database error occurs
		* @return void
		*/
		public function update(Post $post) {
			$stmt = $this->db->prepare("UPDATE posts set title=?, content=? where id=?");
			$stmt->execute(array($post->getTitle(), $post->getContent(), $post->getId()));
		}

		/**
		* Deletes a Post into the database
		*
		* @param Post $post The post to be deleted
		* @throws PDOException if a database error occurs
		* @return void
		*/
		public function delete(Post $post) {
			$stmt = $this->db->prepare("DELETE from posts WHERE id=?");
			$stmt->execute(array($post->getId()));
		}

	}
