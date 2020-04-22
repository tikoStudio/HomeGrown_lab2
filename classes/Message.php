<?php
	include_once(__DIR__ . "./Db.php");
	include_once(__DIR__ . "/User.php");

    class Message extends User {
		private $message;
		private $time;
		private $communityId;

		public function getMessage()
		{
			return $this->message;
		}

		public function setMessage($message)
		{
			$this->message = $message;

			return $this;
		}

		public function getTime()
		{
			return $this->time;
		}

		public function setTime($time)
		{
			$this->time = $time;

			return $this;
		}

		public function getCommunityId()
		{
			return $this->communityId;
		}

		public function setCommunityId($communityId)
		{
			$this->communityId = $communityId;

			return $this;
		}

		public function saveMessage() {
			$conn = Db::getConnection();
			$statement = $conn->prepare("insert into messages (userId, communityId, message, time) values (:userId, :communityId, :message, :time)");
			$id = $this->getId();
			$communityId = $this->getCommunityId();
			$message = $this->getMessage();
			$time = $this->getTime();

			$statement->bindParam(":userId", $id);
			$statement->bindParam(":communityId", $communityId);
			$statement->bindParam(":message", $message);
			$statement->bindParam(":time", $time);

			$statement->execute();
		}

		public function getMessagesFromDatabase() {
			$conn = Db::getConnection();
			$statement = $conn->prepare("select messages.userId, messages.message, messages.time, u1.name from users as u1, messages
			 where communityId = :communityId and userId = u1.id order by messages.id asc");
			$communityId = $this->getCommunityId();
			$statement->bindParam(":communityId", $communityId);

			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}

    }