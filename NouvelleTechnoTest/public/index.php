<?php

    use App\Autoloader;
    use App\Core\Main;
    //Nous définissons une constante qui contient le nom du dossier du projet

    define('ROOT', dirname(__DIR__));
    
    //Nous importons l'autoloader
    require_once(ROOT."/Autoloader.php");
    Autoloader::register();

    //Nous instancions la classe Main (qui est notre routeur)
    $application = new Main();

    //Nous démarrons l'application
    $application->start();

?>