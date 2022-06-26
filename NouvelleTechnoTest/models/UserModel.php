<?php

    namespace App\models;

    class UserModel extends Model
    {
        //Création des variables correspondant aux champs dans la table
        protected $ID_USER;
        protected $EMAIL;
        protected $PASSWORD;

        public function __construct()
        {
            $class = str_replace(__NAMESPACE__.'\\','',__CLASS__);
            $this->table = strtolower(str_replace('Model','',$class));
        }

        //Méthode qui permet de créer une session
        public function creerSession()
        {
            //Nous mettons dans la sessions les paramètres de l'id utilisateur et l'email
            //Nous ne mettons pas le mot de passe pour pas que ces données soient volées
            $_SESSION['user'] = ['ID_USER' => $this->ID_USER, 'EMAIL' => $this->EMAIL];
        }

        //Cette méthode nous permet de récupérer un user à partir de son email
        public function findOneByEmail(string $email)
        {
            return $this->executer("SELECT * FROM " . $this->table . " WHERE EMAIL = ? ", [$email])->fetch();
        }

        //Création des Getters

        public function getID_USER()
        {
            return $this->ID_USER;
        }

        public function getEMAIL()
        {
            return $this->EMAIL;
        }

        public function getPASSWORD()
        {
            return $this->PASSWORD;
        }

        //Création des setters

        public function setID_USER($value)
        {
            $this->ID_USER = $value;
            return $this;
        }

        public function setEMAIL($value)
        {
            $this->EMAIL = $value;
            return $this;
        }

        public function setPASSWORD($value)
        {
            $this->PASSWORD = $value;
            return $this;
        }

    }

?>