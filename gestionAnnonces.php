<?php
error_reporting(E_ALL); 
ini_set('display_errors', 'On');

require_once("config.php"); 

if(!isConnected() || !isadmin()){
    header('Location: index.php');
};

$q=$bdd->query("SELECT * FROM produits ORDER BY id desc");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Interface d'administration - M'Effleure La Muse</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="gestion.php">
                        M'Effleure La Muse
                    </a>
                </li>
                <li>
                    <a href="gestionAnnonces.php">Gestion des annonces</a>
                </li>
                <li>
                    <a href="gestionAccueil.php">Gestion page d'accueil</a>
                </li>
                <li>
                    <a href="gestionUtilisateurs.php">Gestion des utilisateurs</a>
                </li>
                <li>
                    <a href="gestionFAQ.php">Gestion des questions</a>
                </li>
                <li>
                    <a href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Gestion des annonces</h1>
                        <a href="addProduct.php" class="btn btn-success" id="addProduct">Ajouter un nouveau produit</a>

                        <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Annonces en ligne actuellement</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtrer</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="ID" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Nom" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Prix" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Nombre de vues" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Modification" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Suppression" disabled></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($annonce = $q-> fetch()) {
                    echo("<tr>");
                        echo("<td>".$annonce['id']."</td>");
                        echo("<td>".$annonce['titre']."</td>");
                        echo("<td>".$annonce['prix']."</td>");
                        echo("<td>".$annonce['nbClicks']."</td>");
                        echo("<td><a href=\"modifAnnonce.php?idAnnonce=".$annonce['id']."\">Modifier ce produit</a>");
                        echo("<td><a href=\"#\" onClick=\"confirme('".$annonce['id']."')\">Supprimer ce produit</a>");
                    echo("</tr>");
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
                        <a href="logout.php" class="btn btn-danger" id="">Deconnexion</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/gestion.js"></script>


    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>

