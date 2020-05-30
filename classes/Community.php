<?php
    include_once(__DIR__ . "/Db.php");

    class Community
    {
        private $id;
        private $userId;
        private $polygon1;
        private $crop1;
        private $crop2;
        private $name;

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        public function setUserId($userId)
        {
            $this->userId = $userId;

            return $this;
        }

        public function getPolygon1()
        {
            return $this->polygon1;
        }

        public function setPolygon1($polygon1)
        {
            $this->polygon1 = $polygon1;

            return $this;
        }

        public function getCrop1()
        {
            return $this->crop1;
        }

        public function setCrop1($crop1)
        {
            $this->crop1 = $crop1;

            return $this;
        }

        public function getCrop2()
        {
            return $this->crop2;
        }

        public function setCrop2($crop2)
        {
            $this->crop2 = $crop2;

            return $this;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;

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

        public function getNamedCommunities($param)
        {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from community where crop1 = :param or crop2 = :param or name LIKE :betweenparam ");
            $statement->bindParam(':param', $param);
            $searchparam = "%" . $param . "%";
            $statement->bindParam(':betweenparam', $searchparam);
            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function makeNewCommunity()
        {
            // connectie
            $conn = Db::getConnection();
            // query
            $statement = $conn->prepare("insert into community (userId1, polygon1, crop1, crop2, img, name) values (:userId, :polygon1, :crop1, :crop2, :img, :name)");
            // variabelen klaarzetten om te binden
            $userId = $this->getUserId();
            $polygon1 = $this->getPolygon1();
            $crop1 = $this->getCrop1();
            $crop2 = $this->getCrop2();
            $img = "comingsoon.jpg";
            $name = $this->getName();
 
            // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
            $statement->bindParam(":userId", $userId);
            $statement->bindParam(":polygon1", $polygon1);
            $statement->bindParam(":crop1", $crop1);
            $statement->bindParam(":crop2", $crop2);
            $statement->bindParam(":img", $img);
            $statement->bindParam(":name", $name);
 
            // als je geen execute doet dan wordt die query niet uitgevoerd
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
             
            return $result;
        }
    }
