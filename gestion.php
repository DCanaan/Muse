<?php
error_reporting(E_ALL); 
ini_set('display_errors', 'On');

require_once("config.php"); 

if(!isConnected() || !isadmin()){
    header('Location: index.php');
};
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
                    <a href="admin.php">
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
                        <h1>Bienvenu sur l'interface d'administration</h1>
                        <p>Veuillez sélectionner la partie que vous souhaitez modifier dans le menu situé sur la gauche.</p>
                        <p>N'oubliez pas de vous déconnecter lorsque les modifications seront terminées.</p>
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

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>

