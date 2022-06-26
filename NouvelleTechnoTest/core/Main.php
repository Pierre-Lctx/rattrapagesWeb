<?php

    namespace App\Core;

    use App\controllers\mainController;

    //Routeur Principale

    class Main
    {

        public function start()
        {
            //Nous démarrons la session
            session_start();
            
            // Fonctionnement des route
            // http://stage.com/controller/methode/parametres
            // Exemple : http://stage.com/entrepriseModel/search/ISII-TECH
            // Réécriture de l'annonce : http://stage.com/index.php?p=entrepriseModel/search/ISII-TECH
            //Pour cela nous réutilison le système .htaccess d'apache
            
            //Nous retirons le "trailing slash" éventuelle de l'url (le dernier slash)
            //Nous récupèrons d'abord l'url
            $uri = $_SERVER['REQUEST_URI'];

            //Nous vérifions que l'uri n'est pas vide et qu'elle se termine par un slash
            if (!empty($uri) && $uri != '/' && $uri[-1] === '/')
            {
                echo $uri;
                //Nous enlevons le slash
                $uri = substr($uri, 0, -1);
                
                //Nous envoyons un code de redirection permanente
                http_response_code(301);

                //Nous redirigeons vers l'url sans le slash
                header('Location: '.$uri);
                exit;
            }

            //Nous gérons les paramètres
            //p=controller/methode/parametre
            //Nous séparons les paramtères et nous les mettons sous forme de tableau
            $params = [];
            if (isset($_GET['p']))
                $params = explode('/',$_GET['p']);

            //Nous vérifions si nous avons au moins un paramètre
            if ($params[0] != '')
            {
                //Nous avons au moins un paramètre
                //Nous allons maintenant traiter les paramètres
                //La première partie va être le controller
                //La deuxième partie va être la méthode
                //Les autres seront les parties des paramètres

                //Nous récupèrons le nom du controller à instancier
                $controller = '\\App\\controllers\\'.ucfirst(array_shift($params)).'Controller';

                //Nous instancions le controller
                $controller = new $controller();

                //Nous récupèrons la méthode (une action) qui est le deuxième paramètre de l'url
                $action = (isset($params[0])) ? array_shift($params) : 'index';

                //Nous vérifions que la méthode existe
                if (method_exists($controller, $action))
                {
                    //Dans le cas où la méthode existe
                    //Si il reste des paramètres, nous les passons sous forme de tableau dans le tableau
                    (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
                }
                else 
                {
                    //Dans le cas où la méthode n'existe pas
                    http_response_code(404);
                    echo "Cette page n'éxiste pas.";
                }
            }
            else 
            {
                //Nous n'avons pas de paramètre
                //Nous instancions le controller par défaut
                $controller = new mainController();

                //Nous appelons la méthode index
                $controller->index();
            }
        }

    }

?>