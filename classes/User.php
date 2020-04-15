<?php
     include_once(__DIR__ . "./Db.php");

    class User {
        protected $id;
        protected $email;
        protected $name;
        protected $avatar;
        protected $password;

        public function setName($name) {

                if(empty($name)) {
                        throw new Exception("Name cannot be empty!");
                }

                if(!preg_match("/^[a-zA-Z ]*$/", $_POST['name'])) {
                        throw new Exception("Name contains invalid characters!");
                }

                $this->name = $name;

                return $this;
        }

        public function getName() {
                return $this->name;
        }

        public function getNameFromDatabase() {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT name FROM users WHERE id= :id");
            $id = $this->getId();
            $statement->bindParam(":id", $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

        public function setEmail($email) {

                if(empty($email)) {
                        throw new Exception("Email cannot be empty!");
                }

                $this->email = $email;

                return $this;
        }

        public function getEmail() {
                return $this->email;
        }

        public function validEmail($email) {
                $email = $_POST['email'];
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        return true;
                    } else {
                        return false;
                    }
        }

        public function availableEmail($email) {
                $conn = Db::getConnection();
                $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
                $statement->bindParam(":email", $email);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                if ($result == false) {
                        // Email available
                        return true;
                } else {
                        // Email not available
                        return false;
                }
        }

        public function setPassword($password) {

                if(empty($password)) {
                        throw new Exception("Password cannot be empty");
                }

                $options = ['cost' => 12];
                $password = password_hash($password, PASSWORD_DEFAULT, $options);

                $this->password = $password;

                return $this;
        }

        public function getPassword() {
                return $this->password;
        }

        public function save() {
                // connectie
                $conn = Db::getConnection();

                // query
                $statement = $conn->prepare("insert into users (name, email, password) values (:name, :email, :password)");
                
                // variabelen klaarzetten om te binden
                $name = $this->getName();
                $email = $this->getEmail();
                $password = $this->getPassword();
                
                // uitlezen wat er in de variabele zit en die zal op een veilige manier gekleefd worden
                $statement->bindParam(":name", $name);
                $statement->bindParam(":email", $email);
                $statement->bindParam(":password", $password);

                // als je geen execute doet dan wordt die query niet uitgevoerd
                $result = $statement->execute();

                return $result;
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

        public function getAvatar()
        {
            return $this->avatar;
        }
            
        public function setAvatar($avatar)
        {  
            $this->avatar = $avatar;

            return $this;
        }

        public function checkLogin($email, $password) {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindParam(":email", $email);

            //return result
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if(empty($result)) {
                return false;
            }
            $hash = $result[0]["password"];
            if(password_verify($password, $hash)) {
                return true;
            }else {
                echo "fail";
                return false;
            }
        }

        public function idFromSession($email) {
            //db conn
            $conn = Db::getConnection();
            //insert query
            $statement = $conn->prepare("select id from users where email = :email");
            $statement->bindParam(":email", $email);

            //return result
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

    }