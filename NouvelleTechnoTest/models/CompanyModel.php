<?php

    namespace App\models;


    class CompanyModel extends Model
    {
        //Création des variables correspondant aux champs dans la table
        protected $ID_COMPANY;
        protected $COMPANY_NAME;
        protected $ACTIVITY_SECTOR;
        protected $NUMBER_OF_STUDENTS;
        protected $NUM_SIRET;
        protected $NUM_SIREN;
        protected $TOWN_NAME;
        protected $STREET;
        protected $NUMBER;
        protected $POSTAL_CODE;
        protected $COMPLEMENT;

        public function __construct()
        {
            $this->table = 'company';
        }

        //Création des Getteurs
        public function getID_COMPANY()
        {
            return $this->ID_COMPANY;
        }

        public function getCOMPANY_NAME()
        {
            return $this->COMPANY_NAME;
        }

        public function getACTIVITY_SECTOR()
        {
            return $this->ACTIVITY_SECTOR;
        }

        public function getNUMBER_OF_STUDENTS()
        {
            return $this->NUMBER_OF_STUDENTS;
        }
        
        public function getNUM_SIRET()
        {
            return $this->NUM_SIRET;
        }
        
        public function getNUM_SIREN()
        {
            return $this->NUM_SIREN;
        }
        
        public function getSTREET()
        {
            return $this->STREET;
        }
        
        public function getNUMBER()
        {
            return $this->NUMBER;
        }
        
        public function getPOSTAL_CODE()
        {
            return $this->POSTAL_CODE;
        }
        
        public function getCOMPLEMENT()
        {
            return $this->COMPLEMENT;
        }
        
        public function getTOWN_NAME()
        {
            return $this->TOWN_NAME;
        }


        //Création des Setteurs

        public function setID_COMPANY($value)
        {
            $this->ID_COMPANY = $value;
            return $this;
        }

        public function setCOMPANY_NAME($value)
        {
            $this->COMPANY_NAME = $value;
            return $this;
        }

        public function setACTIVITY_SECTOR($value)
        {
            $this->ACTIVITY_SECTOR = $value;
            return $this;
        }

        public function setNUMBER_OF_STUDENTS($value)
        {
            $this->NUMBER_OF_STUDENTS = $value;
            return $this;
        }
        
        public function setNUM_SIRET($value)
        {
            $this->NUM_SIRET = $value;
            return $this;
        }
        
        public function setNUM_SIREN($value)
        {
            $this->NUM_SIREN = $value;
            return $this;
        }
        
        public function setSTREET($value)
        {
            $this->STREET = $value;
            return $this;
        }
        
        public function setNUMBER($value)
        {
            $this->NUMBER = $value;
            return $this;
        }
        
        public function setPOSTAL_CODE($value)
        {
            $this->POSTAL_CODE = $value;
            return $this;
        }
        
        public function setCOMPLEMENT($value)
        {
            $this->COMPLEMENT = $value;
            return $this;
        }
        
        public function setTOWN_NAME($value)
        {
            $this->TOWN_NAME = $value;
            return $this;
        }

    }

?>