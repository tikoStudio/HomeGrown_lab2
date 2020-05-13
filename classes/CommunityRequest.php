<?php
    include_once(__DIR__ . "/Db.php");

    class CommunityRequest
    {
        private $userId;
        private $communityId;
 
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
    }
