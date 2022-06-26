<head>
    <link rel="stylesheet" href="CSS/style_lire.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
    <h2>Résumé de l'entreprise : <?= $company->COMPANY_NAME ?></h2>
    <section id="information">
            <div class="general_information"><b>Nom de l'entreprise :</b></div>
            <div class="specific_information"><?= $company->COMPANY_NAME ?></div>
            <div class="general_information"><b>Secteur d'activité :</b></div>
            <div class="specific_information"><?= $company->ACTIVITY_SECTOR ?></div>
            <div class="general_information"><b>Nombre d'étudiants :</b></div>
            <div class="specific_information"><?= $company->NUMBER_OF_STUDENTS?></div>
            <div class="general_information"><b>Numéro de Siret :</b></div>
            <div class="specific_information"><?= $company->NUM_SIRET ?></div>
            <div class="general_information"><b>Numéro de Siren :</b></div>
            <div class="specific_information"><?= $company->NUM_SIREN ?></div>
            <div class="general_information"><b>Ville :</b></div>
            <div class="specific_information"><?= $company->TOWN_NAME ?></div>
            <div class="general_information"><b>Rue :</b></div>
            <div class="specific_information"><?= $company->STREET?></div>
            <div class="general_information"><b>Numéro :</b></div>
            <div class="specific_information"><?= $company->NUMBER ?></div>
            <div class="general_information"><b>Code postal :</b></div>
            <div class="specific_information"><?= $company->POSTAL_CODE ?></div>
            <div class="general_information"><b>Complément d'adresse :</b></div>
            <div class="specific_information"><?= $company->COMPLEMENT ?></div>
            
    </section>  
    <br>
    <form id="button">
        <a href="/company" id="back">Retour à la liste des entreprises</a>
    </form>

</body>
</html>