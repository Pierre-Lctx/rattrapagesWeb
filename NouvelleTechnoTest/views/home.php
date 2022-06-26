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
    <style>
    h1
    {
        text-align: center;
        size : 200%;
        margin-top: 20%;
        margin-bottom: 5%;
    }
    div
    {
        text-align: center;
    }
</style>
<div>
    <h1>Site de gestion des entreprises</h1>
    <a href="/user/login" class="btn btn-primary">Me connecter</a>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>