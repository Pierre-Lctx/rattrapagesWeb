<?php
    //On utilise le Design patern Singleton

    namespace App\Core;

    //Importation de PDO
    use PDO;
    use PDOException;
    class Db extends PDO
    {
        //Nous créons une instance unique de la classe
        private static $DbInstance;

        //Nous allons maintenant gérer le fait que l'instance soit unique
        //Nous mettons en constante les informations de connexion à la base de données

        private const DBHOST = "localhost";
        private const DBUSER = 'root';
        private const DBPASS = '';
        private const DBNAME = 'gestionentreprise';

        //Nous allons faire un constructeur en private, nous ne pourrons pas instancier la classe car elle aura sa propre instance en instance unique
        private function __construct()
        {
            //DSN de connexion
            $dsn = 'mysql:dbname='.self::DBNAME.';host='.self::DBHOST;
            
            //On appelle le constructeur de la classe PDO
            try
            {
                parent::__construct($dsn,self::DBUSER, self::DBPASS);

                //Le this correspond à PDO
                $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,"SET NAMES utf8");
                $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        } 
        
        //Méthode permettant de récupérer l'instance unique de notre classe
        //On indique le type de retour avec self, car elle retourne un type Db qui est le nom de la classe
        public static function getInstance():self
        {
            //Dans le cas où notre instance est null, nous la recréons
            if (self::$DbInstance === null)
            {
                self::$DbInstance = new self();
            }
            return self::$DbInstance;
        }
    }

?>