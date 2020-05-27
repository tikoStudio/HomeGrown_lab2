<?php
    include_once(__DIR__ . "/Db.php");

    class MakeCommunity
    {
        private $userId;
        private $polygon1;
        private $crop1;
        private $crop2;
        private $img;
        private $name;

        /**
         * Get the value of userId
         */
        public function getUserId()
        {
            return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */
        public function setUserId($userId)
        {
            $this->userId = $userId;

            return $this;
        }

        /**
         * Get the value of polygon1
         */
        public function getPolygon1()
        {
            return $this->polygon1;
        }

        /**
         * Set the value of polygon1
         *
         * @return  self
         */
        public function setPolygon1($polygon1)
        {
            $this->polygon1 = $polygon1;

            return $this;
        }

        /**
         * Get the value of crop1
         */
        public function getCrop1()
        {
            return $this->crop1;
        }

        /**
         * Set the value of crop1
         *
         * @return  self
         */
        public function setCrop1($crop1)
        {
            $this->crop1 = $crop1;

            return $this;
        }

        /**
         * Get the value of crop2
         */
        public function getCrop2()
        {
            return $this->crop2;
        }

        /**
         * Set the value of crop2
         *
         * @return  self
         */
        public function setCrop2($crop2)
        {
            $this->crop2 = $crop2;

            return $this;
        }

        /**
         * Get the value of img
         */
        public function getImg()
        {
            return $this->img;
        }

        /**
         * Set the value of img
         *
         * @return  self
         */
        public function setImg($img)
        {
            $this->img = $img;

            return $this;
        }

        /**
         * Get the value of name
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * Set the value of name
         *
         * @return  self
         */
        public function setName($name)
        {
            $this->name = $name;

            return $this;
        }

        public function makeCom()
        {
            // connectie
            $conn = Db::getConnection();
            // query
            $statement = $conn->prepare("insert into communitiesmaking (userId1, polygon1, crop1, crop2, img, name) values (:userId, :polygon1, :crop1, :crop2, :img, :name)");
            // variabelen klaarzetten om te binden
            $userId = $this->getUserId();
            $polygon1 = $this->getPolygon1();
            $crop1 = $this->getCrop1();
            $crop2 = $this->getCrop2();
            $img = $this->getImg();
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
