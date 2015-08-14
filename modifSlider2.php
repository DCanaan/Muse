<?php
error_reporting(E_ALL); 
ini_set('display_errors', 'On');

require_once("config.php"); 

if(!isConnected() || !isadmin()){
    header('Location: index.php');
}



    /* Definition des constantes / tableaux et variables
*************************************************************/
// Constantes
$target= dirname(__FILE__).'/slider/'; // Repertoire cible
define('MAX_SIZE', 2000000); // Taille max en octets du fichier
define('WIDTH_MAX', 1600); // Largeur max de l'image en pixels
define('HEIGHT_MAX', 600); // Hauteur max de l'image en pixels
// Tableaux de donnees
$tabExt = array('jpg'/*,'gif','png','jpeg'*/); // Extensions autorisees
$infosImg = array();
// Variables
$extension = '';
$message = '';
$nomImage = '';
/************************************************************
* Creation du repertoire cible si inexistant
*************************************************************/
/*if( !is_dir(TARGET) ) {
if( !mkdir(TARGET, 0755) ) {
exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
}
}*/
if(!is_dir($target)){
 mkdir($target);
}

/************************************************************
* Script d'upload
*************************************************************/
if(!empty($_POST)) {
    // On verifie si le champ est rempli
    if( !empty($_FILES['fichier']['name']) ) {
        // Recuperation de l'extension du fichier
        $extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
            // On verifie l'extension du fichier
        if(in_array(strtolower($extension),$tabExt)) {
                // On recupere les dimensions du fichier
            $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
                    // On verifie le type de l'image
            if($infosImg[2] >= 1 && $infosImg[2] <= 14) {
                        // On verifie les dimensions et taille de l'image
                if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE)) {
                            // Erreurs
                    if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error']) {
                                // On renomme le fichier
                        $nomImage = $target.'Slider-2.'.$extension;
                                // Si c'est OK, on teste l'upload
                        if(move_uploaded_file($_FILES['fichier']['tmp_name'], $nomImage)) {
                            $message = 'Upload réussi !'; }
                            else {
                                    // Sinon on affiche une erreur
                                $message = 'Problème lors de l\'upload !'; }
                            }
                            else {
                                $message = 'Une erreur interne a empêché l\'uplaod de l\'image'; }
                            }
                            else {
                            // Sinon erreur sur les dimensions et taille de l'image
                                $message = 'Erreur dans les dimensions de l\'image !'; }
                            }
                            else {
                        // Sinon erreur sur le type de l'image
                                $message = 'Le fichier à uploader n\'est pas une image !'; }
                            }
                            else {
                // Sinon on affiche une erreur pour l'extension
                                $message = 'L\'extension du fichier est incorrecte !'; }
                            }
                            else {
        // Sinon on affiche une erreur pour le champ vide
                                $message = 'Veuillez remplir le formulaire svp !'; }
                            }
                        

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
                        <?php if(!empty($messages)) {?><div class="alert alert-info" role="alert" style="margin-top:20px;">
                    <?php echo($message); ?>
                    </div><?php } ?>
                        <h1>Gestion de l'Accueil - Modification Slider 2</h1>
                            <div class="row">
                            <form role="form" method="post" enctype="multipart/form-data">
                                <div class="tab-content">
                                        <h3>Image</h3>
                                        <p>Sélectionnez l'image correspondante au Slider 2. Pour un affichage optimal sur le site, il est conseillé d'utiliser des images de dimensions égales à 800x300px, ou 1600x600px afin de conserver le ratio d'affichage.</p>
                                        <div class="form-group">
                                            <span class="btn btn-default btn-file">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
                                                <input type="file" name="fichier" id="imageSlider" class="" value="" placeholder="Image de Slider" tabindex="1">
                                            </span>
                                        </div>
                                        <ul class="list-inline pull-left">
                                            <li><button type="submit" class="btn btn-success prev-step">Envoyer</button></li>
                                        </ul>
                                    </div>
                            </form>
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

