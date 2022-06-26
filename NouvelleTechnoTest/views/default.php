<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rattrapages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="manifest" href="manifest.json">
    <script>
        //Nous attendons que la page soit chargée
        window.addEventListener('load', ()=>{
            if("serviceWorker" in navigator)
            {
                navigator.serviceWorker.register('sw.js')
            }
        })
    </script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/main">Rattrapages</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/company">Liste des entreprises</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php
                //Si nous avons un utilisateur
                if (isset($_SESSION['user']) && !empty($_SESSION['user']['ID_USER'])) :
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/logout">Deconnexion</a>
                    </li>
                <?php
                //Si nous n'en avons pas
                else :
                ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="/user/login">Connexion</a>
                    </li>
                <?php
                endif;
                ?>
            </ul>
        </div>
    </nav>
  
    <div class="container">
        <?php
        if (!empty($_SESSION['message'])) :
        ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message'];
                unset($_SESSION['message']) ?>
            </div>
        <?php
        endif;
        ?>
        <?php
        if (!empty($_SESSION['error'])) :
        ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']) ?>
            </div>
        <?php
        endif;
        ?>
        <?= $content ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>