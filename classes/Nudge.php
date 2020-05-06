<?php
    include_once(__DIR__ . "./Db.php");

    class Nudge
    {
        private $myid;
        private $postId;
        private $userId1; //sender
        private $userId2; //receiver
        private $text;
        private $time;

        public function getUserId1()
        {
            return $this->userId1;
        }

        public function setUserId1($userId1)
        {
            $this->userId1 = $userId1;

            return $this;
        }

        public function getUserId2()
        {
            return $this->userId2;
        }

        public function setUserId2($userId2)
        {
            $this->userId2 = $userId2;

            return $this;
        }

        public function getText()
        {
            return $this->text;
        }

        public function setText($text)
        {
            $this->text = $text;

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

        public function getMyid()
        {
            return $this->myid;
        }

        public function setMyid($myid)
        {
            $this->myid = $myid;

            return $this;
        }

        public function getPostId()
        {
            return $this->postId;
        }

        public function setPostId($postId)
        {
            $this->postId = $postId;

            return $this;
        }

        public function saveNudge()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("insert into nudges (userId1, userId2, text, time) values (:userId1, :userId2, :text, :time)");
            $userId1 = $this->getUserId1();
            $userId2 = $this->getUserId2();
            $text = $this->getText();
            $time = $this->getTime();
            $statement->bindParam(":userId1", $userId1);
            $statement->bindParam(":userId2", $userId2);
            $statement->bindParam(":text", $text);
            $statement->bindParam(":time", $time);

            //return result
            $statement->execute();
        }

        public function showNudges()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from nudges where userId2 = :id and active = 1");
            $id = $this->getMyid();
            $statement->bindParam(":id", $id);

            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function markAsRead()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("update nudges set active= 0 where id= :id");
            $id = $this->getPostId();
            $statement->bindParam(":id", $id);

            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function unreadNudges()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select COUNT(*) from nudges where userId2= :id and active = 1");
            $id = $this->getUserId2();
            $statement->bindParam(":id", $id);
 
            //return result
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }
