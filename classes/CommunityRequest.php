<?php
    include_once(__DIR__ . "/Db.php");

    class CommunityRequest
    {
        private $userId;
        private $communityId;
        private $id;
 
        public function getUserId()
        {
            return $this->userId;
        }

        public function setUserId($userId)
        {
            $this->userId = $userId;

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

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }

        public function makeRequest()
        {
            // connectie
            $conn = Db::getConnection();
            // query
            $statement = $conn->prepare("insert into communityrequest (userId, communityId) values (:userId, :communityId)");
            // variabelen klaarzetten om te binden
            $userId = $this->getUserId();
            $communityId = $this->getCommunityId();

            // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
            $statement->bindParam(":userId", $userId);
            $statement->bindParam(":communityId", $communityId);

            // als je geen execute doet dan wordt die query niet uitgevoerd
            $result = $statement->execute();

            return $result;
        }

        public function getMyrequest()
        {
            // connectie
            $conn = Db::getConnection();
            // query
            $statement = $conn->prepare("select * from communityrequest where userId= :userId and communityId= :communityId");
            // variabelen klaarzetten om te binden
            $userId = $this->getUserId();
            $communityId = $this->getCommunityId();

            // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
            $statement->bindParam(":userId", $userId);
            $statement->bindParam(":communityId", $communityId);

            // als je geen execute doet dan wordt die query niet uitgevoerd
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        }

        public function showRequests()
        {
            // connectie
            $conn = Db::getConnection();
            // query
            $statement = $conn->prepare("select * from communityrequest where communityId = :communityId");
            // variabelen klaarzetten om te binden
            $communityId = $this->getCommunityId();

            // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
            $statement->bindParam(":communityId", $communityId);

            // als je geen execute doet dan wordt die query niet uitgevoerd
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        }

        public function acceptRequest()
        {
            // connectie
            $conn = Db::getConnection();
            // query
            $statement = $conn->prepare("update communityrequest set accepted = 1 where id = :id");
            // variabelen klaarzetten om te binden
            $id = $this->getId();

            // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
            $statement->bindParam(":id", $id);

            // als je geen execute doet dan wordt die query niet uitgevoerd
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        }

        public function denyRequest()
        {
            // connectie
            $conn = Db::getConnection();
            // query
            $statement = $conn->prepare("update communityrequest set accepted = 0 where id = :id");
            // variabelen klaarzetten om te binden
            $id = $this->getId();

            // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
            $statement->bindParam(":id", $id);

            // als je geen execute doet dan wordt die query niet uitgevoerd
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        }

        public function showAnswered()
        {
            // connectie
            $conn = Db::getConnection();
            // query
            $statement = $conn->prepare("select * from communityrequest where userId = :userId and accepted is not null and seenResponse is null");
            // variabelen klaarzetten om te binden
            $userId = $this->getUserId();
 
            // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
            $statement->bindParam(":userId", $userId);
 
            // als je geen execute doet dan wordt die query niet uitgevoerd
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
             
            return $result;
        }

        public function setToSeen()
        {
            // connectie
            $conn = Db::getConnection();
            // query
            $statement = $conn->prepare("update communityrequest set seenResponse = 1 where id = :id");
            // variabelen klaarzetten om te binden
            $id = $this->getId();
 
            // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
            $statement->bindParam(":id", $id);
 
            // als je geen execute doet dan wordt die query niet uitgevoerd
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
             
            return $result;
        }
    }
