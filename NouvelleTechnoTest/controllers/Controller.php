<?php

    namespace App\controllers;

    abstract class Controller
    {

        //Dans cette méthode nous permettons le fait de ne pas avoir de données 
        public function render(string $path, array $data = [], string $template = 'default')
        {
            //Nous allons extraire le contenue des données en utilisant la méthode extract
            extract($data);

            //Nous démarrons le buffer de sortie
            //Le buffer de sortie sert à mettre en mémoire les données lorsque nous faisons un echo ou un html
            //puis il va mettre le contenu en mémoire dans une variable
            ob_start();

            $_SESSION['page'] = 1;

            //A partir de maintenant, toutes les sorties sont conservées en mémoire
            //Nous créons le chemin vers la vue
            require_once ROOT.'/views/'.$path.'.php';
            
            //Nous transfèrons le buffer dans le contenu
            $content = ob_get_clean(); 

            //Nous récupèrons le template de la page
            require_once ROOT . '/views/' . $template . '.php';
        }

    }

?>