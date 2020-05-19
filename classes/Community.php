<?php
    include_once(__DIR__ . "/Db.php");

    class Community
    {
        private $id;

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }
        
        public function getcommunityData()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from community where id = :id");
            $id = $this->getId();
            $statement->bindParam(":id", $id);

            //return result
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getMyCommunities()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from community where userId1 = :id or userId2 = :id or userId3 = :id or userId4 = :id");
            $id = $this->getId();
            $statement->bindParam(":id", $id);

            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getMyLeadingCommunities()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from community where userId1 = :id");
            $id = $this->getId();
            $statement->bindParam(":id", $id);

            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function countMyCommunities()
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("select COUNT(*) from community where userId1 = :id or userId2 = :id or userId3 = :id or userId4 = :id");
            $id = $this->getId();
            $statement->bindParam(":id", $id);

            $result = $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getNearbyCommunities()
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from community where UPPER(address) like UPPER(:search) and (userId1 is NULL or userId1 != :id) and (userId2 is NULL or userId2 != :id) and (userId3 is NULL or userId3 != :id) and (userId4 is NULL or userId4 != :id)");
            $searchQuery = '%mechelen%';
            $id = $this->getId();
            $statement->bindParam(":search", $searchQuery);
            $statement->bindParam(":id", $id);
 
            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function countNearbyCommunities()
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("select COUNT(*) from community where UPPER(address) like UPPER(:search) and (userId1 is NULL or userId1 != :id) and (userId2 is NULL or userId2 != :id) and (userId3 is NULL or userId3 != :id) and (userId4 is NULL or userId4 != :id)");
            $searchQuery = '%mechelen%';
            $id = $this->getId();
            $statement->bindParam(":search", $searchQuery);
            $statement->bindParam(":id", $id);
        

            $result = $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function acceptMember($userId)
        {
            //db conn
            $conn = Db::getConnection();

            // check where to update
            $searchStatement = $conn->prepare("select * from community where id = :id");
            $id = $this->getId();
            $searchStatement->bindParam(":id", $id);
            $searchStatement->execute();
            $searchResult = $searchStatement->fetch(PDO::FETCH_ASSOC);
            
            if (empty($searchResult['userId1'])) {
                //insert query
                $statement = $conn->prepare("update community set userId1 = :userId where id = :id");
                $statement->bindParam(":userId", $userId);
                $statement->bindParam(":id", $id);

                //return result
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result;
            } elseif (empty($searchResult['userId2'])) {
                //insert query
                $statement = $conn->prepare("update community set userId2 = :userId where id = :id");
                $id = $this->getId();
                $statement->bindParam(":userId", $userId);
                $statement->bindParam(":id", $id);

                //return result
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result;
            } elseif (empty($searchResult['userId3'])) {
                //insert query
                $statement = $conn->prepare("update community set userId3 = :userId where id = :id");
                $id = $this->getId();
                $statement->bindParam(":userId", $userId);
                $statement->bindParam(":id", $id);

                //return result
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result;
            } elseif (empty($searchResult['userId4'])) {
                //insert query
                $statement = $conn->prepare("update community set userId4 = :userId where id = :id");
                $id = $this->getId();
                $statement->bindParam(":userId", $userId);
                $statement->bindParam(":id", $id);

                //return result
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result;
            }
        }

        public function getTaggedCommunities($crop)
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from community where crop1 = :crop or crop2 = :crop");
            $statement->bindParam(':crop', $crop);
 
            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
