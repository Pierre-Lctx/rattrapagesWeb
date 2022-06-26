<?php

    namespace App\models;
    use App\Core\Db;
    use PDO;

    class Model extends Db
    {

        //Variable de la table de la base de données
        protected $table;

        //Instance de la classe Db
        private $db;

        //Méthode qui nous permet d'aller chercher tous les enregistrements d'une table
        public function findAll()
        {
            $query = $this->executer("SELECT * FROM " . $this->table);
            return $query->fetchAll();
        }

        //Méthode qui nous permet d'aller chercher tous les enregistrements d'une table
        public function findAllWithPagination(int $currentPage = 1, int $elementPerPages = 5)
        {
            //On récupère l'instance de Db
            $this->db = Db::getInstance();

            //Nous récupèrons la première valeur
            $first = ($currentPage * $elementPerPages) - $elementPerPages;

            //Nous préparons la requête
            $sql ="SELECT * FROM " . $this->table . " LIMIT :first , :elementPerPages";
            $query = $this->db->prepare($sql);
            $query->bindParam(':first', $first, PDO::PARAM_INT);
            $query->bindParam(':elementPerPages', $elementPerPages, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        }

        //Méthode qui nous permet d'aller chercher des éléments précis
        public function findBy(array $attributs)
        {
            $fields = [];
            $values = [];

            //Nous faisons une boucle pour éclater le tableau
            foreach($attributs as $field => $value)
            {
                //Nous cherchons à faire un SELECT * FROM table WHERE $fields = $values AND ...
                //Nous faisons ensuite un bindValue
                $fields[] = "$field = ?";
                $values[] = $value;
            }

            //Nous transformons le tableau $fields en une chaine de caractères pour gérer les cas ou nous avons plusieurs attributs
            $fieldList = implode(' AND ', $fields);

            //Execution de la requête
            return $this->executer('SELECT * FROM '. $this->table . ' WHERE ' . $fieldList, $values)->fetchAll();
        }

        //Méthode permettant de connaître le nombre de page
        public function getNumberOfData()
        {
            //On récupère l'instance de Db
            $this->db = Db::getInstance();

            //Nous cherchons dans un premier temps à connaître le nombre d'entreprise total
            $sql = "SELECT COUNT(*) AS N FROM company";

            $query = $this->db->query($sql);

            $result = $query->fetchAll();
            foreach($result as $row)
            {
                $nbData = (int) $row->N;
            }

            //Nous retournons le nombre de page
            return $nbData;
        }

        //Méthode permettant de connaître le nombre de page
        public function getNumberOfPages(int $elementPerPages = 5)
        {
            //Nous retournons le nombre de page
            return ceil($this->getNumberOfData() / $elementPerPages);
        }

        //Méthode de recherche pour un element en particulier avec l'id en paramètre et le nom du champs de l'ID
        public function find(string $champID, int $id)
        {
            return $this->executer("SELECT * FROM " . $this->table . " WHERE $champID = $id")->fetch();
        }

        //Méthode d'insertion de données dans la base de données
        public function create()
        {
            $fields = [];
            $inter = [];   //Nombre de points d'interrogation
            $values = [];

            //Nous faisons une boucle pour éclater le tableau
            foreach($this as $field => $value)
            {
                //Nous cherchons à faire un INSERT INTO table (champs,...) VALUES (?,...)
                if ($value !== null && $field != 'table' && $field != 'db')
                {
                    $fields[] = "$field";
                    $inter[] = "?";
                    $values[] = $value;
                }
            }

            //Nous transformons le tableau $fields en une chaine de caractères pour gérer les cas ou nous avons plusieurs attributs
            $fieldList = implode(', ', $fields);
            $listeInter = implode(', ', $inter);

            //Execution de la requête
            return $this->executer('INSERT INTO '. $this->table . ' ('. $fieldList.') VALUES (' . $listeInter .')', $values);
        }

        //Méthode de modification de données dans une table, prenant pour paramètre, l'id, le nom du champ de l'id, et l'objet
        public function update(int $id, string $champID)
        {
            $fields = [];
            $values = [];

            //Nous faisons une boucle pour éclater le tableau
            foreach($this as $field => $value)
            {
                //Nous cherchons à faire un UPDATE table SET champs = ?, ... WHERE id = ?
                if ($value !== null && $field != 'table' && $field != 'db')
                {
                    $fields[] = "$field = ?";
                    $values[] = $value;
                }
            }

            //Nous transformons le tableau $fields en une chaine de caractères pour gérer les cas ou nous avons plusieurs attributs
            $fieldList = implode(', ', $fields);

            //Execution de la requête
            return $this->executer('UPDATE '. $this->table . ' SET ' . $fieldList . "WHERE $champID = $id", $values);
        }

        //Méthode qui va vérifier dans notre model si nous avons un setter pour la propriété que nous lui donnons, si oui il éxecute la méthode
        public function hydrate($data)
        {
            foreach($data as $field => $value)
            {
                //Nous récuperons le nom du setter correspondant au champ
                $setter = 'set'.ucfirst($field);
                //Nous vérifions si le setter existe
                if (method_exists($this, $setter))
                {
                    //Dans le cas ou le setter existe
                    $this->$setter($value);
                }
            }
            return $this;
        }

        public function supprimerData(int $id, string $champID)
        {
            return $this->executer("DELETE FROM ". $this->table. " WHERE $champID = $id");
        }

        //Nous faisons une méthode principale qui va nous faire notre requête en fonction du cas de figure qui se présente
        public function executer(string $sql, array $attributs = null)
        {
            //On récupère l'instance de Db
            $this->db = Db::getInstance();

            //Vérification de la présence d'attributs
            if ($attributs !== null)
            {
                //Nous avons une requête préparée
                $query = $this->db->prepare($sql);
                $query->execute($attributs);
                return $query;
            }
            else 
            {
                //Nous avons une requête simple
                return $this->db->query($sql);
            }
        }

    }

?>