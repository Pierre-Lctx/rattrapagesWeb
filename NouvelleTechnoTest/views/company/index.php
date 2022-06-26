<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Liste des entreprises</title>

    <style>
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Roboto', sans-serif;
        }

        .table-responsive {
            margin: 30px 0;
        }

        .table-wrapper {
            min-width: 1000px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 10px;
            margin: 0 0 10px;
            min-width: 100%;
        }

        .table-title h2 {
            margin: 8px 0 0;
            font-size: 22px;
        }

        .search-box {
            position: relative;
            float: right;
        }

        .search-box input {
            height: 34px;
            border-radius: 20px;
            padding-left: 35px;
            border-color: #ddd;
            box-shadow: none;
        }

        .search-box input:focus {
            border-color: #3FBAE4;
        }

        .search-box i {
            color: #a0a5b1;
            position: absolute;
            font-size: 19px;
            top: 8px;
            left: 10px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }

        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child {
            width: 130px;
        }

        table.table td a {
            color: #a0a5b1;
            display: inline-block;
            margin: 0 5px;
        }

        table.table td a.view {
            color: #03A9F4;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #E34724;
        }

        table.table td i {
            font-size: 19px;
        }

        .pagination {
            float: right;
            margin: 0 0 5px;
        }

        .hint-text {
            float: left;
            margin-top: 6px;
            font-size: 95%;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h2>Liste des entreprises</h2>
                        </div>
                        <form action="/company/ajouter" class="ml-auto">
                            <button class="btn btn-success">Ajouter une entreprise</button>
                        </form>

                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Nom de l'entreprise</th>
                            <th>Secteur d'activité</i></th>
                            <th>Nombre d'étudiants ayant fait un stage</th>
                            <th>Adresse</th>
                            <th>Complément d'adresse</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($company as $row) :
                        ?>
                            <tr>
                                <td><?= $row->COMPANY_NAME; ?></td>
                                <td><?= $row->ACTIVITY_SECTOR; ?></td>
                                <td><?= $row->NUMBER_OF_STUDENTS; ?></td>
                                <td><?= $row->POSTAL_CODE . ", " . $row->TOWN_NAME . ", " . $row->NUMBER . " " . $row->STREET; ?></td>
                                <td><?= $row->COMPLEMENT; ?></td>
                                <td>
                                    <a href="/company/lire/<?= $row->ID_COMPANY ?>" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                                    <a href="/company/modifier/<?= $row->ID_COMPANY ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                    <a href="/company/supprimer/<?= $row->ID_COMPANY ?>" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text"><b><?= $page['firstData'] + 1 ?></b> données d'affichées sur <b><?= $page['totalData'] ?></b></div>
                    <ul class="pagination">
                        <?php
                        if ($page['currentPage'] > 1) :
                        ?>
                            <form action="/company"  method="post" class="ml-auto">
                                <button class="btn btn-primary" name="anciennePage" value="<?= $page['currentPage'] - 1 ?>">Page précédente</button>
                            </form>
                        <?php
                        endif;
                        if ($page['currentPage'] < $page['numberOfPage']) :
                        ?>
                            <form action="/company" method="post" class="ml-auto">
                                <button class="btn btn-primary" name="nouvellePage" value="<?= $page['currentPage'] + 1 ?>">Page suivante</button>
                            </form>
                        <?php
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>