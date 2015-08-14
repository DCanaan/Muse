<?php
// error_reporting(E_ALL); 
// // echo($message);
// ini_set('display_errors', 'On');

require_once("config.php");
$idAnnonce = $_GET['idAnnonce'];
$q=$bdd->query("SELECT * FROM produits WHERE id = '$idAnnonce'");
    $ligne = $q-> fetch(); 

    $prixSplit = explode(".", $ligne['prix']);

if(!isConnected() || !isadmin()){
    header('Location: index.php');
};


//Création des variables, ce qui va permettre de les récupèrer dans le HTML.
$messages= [];
 
$titreAnnonce = null;
$descriptifAnnonce = null;
$prixEuros = null;
$prixCentimes = null;

 
//Empty vérifie si la variable existe   mais elle doit être vide, ! devant un booléen l'inverse.
if(!empty($_POST))
    {
    //Isset vérifie qu'une ou plusieurs variables existe et ne sont pas null/false. 
    if(isset($_POST["titreAnnonce"], $_POST["descriptifAnnonce"], $_POST["prixEuros"], $_POST["prixCentimes"]))
        {
        //Récupération des valeurs, ça permet de mettre à jour les variables par défaut et réafficher le formulaire avec les bonnes valeurs, attention à TOUJOURS filtrer ce qui vient d'un utilisateur pour éviter des failles.
        $titreAnnonce = $_POST['titreAnnonce'];
        $descriptifAnnonce = $_POST['descriptifAnnonce'];
        $prixEuros = $_POST['prixEuros'];
        $prixCentimes = $_POST['prixCentimes'];
        
        //Test des variables.
        //Si pas alphanumérique ou si vide : erreur.
        if(mb_strlen($titreAnnonce) < 1)
            $messages[] = "Erreur dans le titre ou champ vide.";
              
        if(mb_strlen($descriptifAnnonce) < 1)
            $messages[] = "Erreur dans le descriptif ou champ vide.";


        if(!ctype_digit($prixEuros) || mb_strlen($prixEuros) < 1)
            $messages[] = "Erreur prix (caractères numériques) ou champ vide.";


        if(!ctype_digit($prixCentimes) || mb_strlen($prixCentimes) < 1)
            $messages[] = "Erreur prix (caractères numériques) ou champ vide.";

        //Check fini, si l'array $message est vide, aucun problème, sinon j'en ai une ou plusieurs.
        if(count($messages) === 0)
            {
                $prix = $prixEuros.".".$prixCentimes;
                try
                {
                    $register = $bdd->prepare("UPDATE produits SET titre = :titre, description = :description, prix = :prix WHERE id='$idAnnonce'");

                    $register->execute([
                        ":titre" => securite_bdd($titreAnnonce),
                        ":description" => securite_bdd($descriptifAnnonce),
                        ":prix" => securite_bdd($prix)
                        ]);

                    // $selectId = $bdd -> prepare("SELECT id FROM produits ORDER BY id DESC LIMIT 1");
                    // $selectId -> execute();


                    $messages = 'Mise en ligne réussie !';
                                        /************************************************************
                        * Definition des constantes / tableaux et variables
                        *************************************************************/
                        // Constantes
                        $target= dirname(__FILE__).'/img/'.$ligne['id'].'/'; // Repertoire cible
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
                                                $nomImage = $target.$titreAnnonce.'Cover.'. $extension;
                                                        // Si c'est OK, on teste l'upload
                                                if(move_uploaded_file($_FILES['fichier']['tmp_name'], $nomImage)) {
                                                    $message = 'Modification réussie'; }
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
                                                }       

                        catch(Exception $e)
                        {
                            if($e->getCode() == 23000)
                                $messages = 'Ce titre existe déjà';

                            else
                            {
                                $messages = 'Nous sommes incapables de procéder à votre demande. Veuillez réessayer plus tard.';
                            }
                        }
                    }
                }
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
            <div class="container">
                <div class="row">
                    <?php if(!empty($messages)) {?><div class="alert alert-info" role="alert" style="margin-top:20px;">
                    <?php echo($message); ?>
                    </div><?php } ?>
                    <section>
                        <div class="wizard">
                            <div class="wizard-inner">
                                <div class="connecting-line"></div>
                                <ul class="nav nav-tabs" role="tablist">

                                    <li role="presentation" class="active">
                                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                            <span class="round-tab">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="disabled">
                                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                            <span class="round-tab">
                                                <i class="glyphicon glyphicon-euro"></i>
                                            </span>
                                        </a>
                                    </li>
                                    <li role="presentation" class="disabled">
                                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                            <span class="round-tab">
                                                <i class="glyphicon glyphicon-picture"></i>
                                            </span>
                                        </a>
                                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <form role="form" method="post" enctype="multipart/form-data">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <h3>Titre et descriptif</h3>
                        <div class="row">
                                <div class="form-group">
                                    <input type="text" name="titreAnnonce" id="titreAnnonce" class="form-control input-md" value="<?php echo($ligne['titre']); ?>" placeholder="Titre" tabindex="1">
                                </div>
                                <div class="form-group">
                                    <textarea name="descriptifAnnonce" id="descriptifAnnonce" class="form-control input-md" placeholder="Descriptif de l'annonce" tabindex="2" rows="10"><?php echo($ligne['description']); ?></textarea>
                                </div>
                        </div>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-primary next-step">Sauvegarder et continuer</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h3>Prix</h3>
                        <input type="number" name="prixEuros" min="0" max="9999" size="4" title="Only numbers are allowed" value="<?php echo($prixSplit[0]); ?>" tabindex="3"/>
                        , 
                        <input type="number" name="prixCentimes" min="0" max="99" size="2" title="Only numbers are allowed" value="<?php echo($prixSplit[1]); ?>" tabindex="4"/> €
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Précédent</button></li>
                            <li><button type="button" class="btn btn-primary next-step">Sauvegarder et continuer</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h3>Image</h3>
                        <p>Sélectionnez l'image correspondante au produit. Pour un affichage optimal sur le site, il est conseillé d'utiliser des images de dimensions égales à 800x300px, ou 1600x600px afin de conserver le ratio d'affichage.</p>
                        <div class="form-group">
                            <span class="btn btn-default btn-file">
                            <input type="file" name="fichier" id="imageAnnonce" class="" value="" placeholder="Image de l'annonce" tabindex="5">
                        </span>
                        </div>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Précédent</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Sauvegarder et continuer</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Validation</h3>
                        <p>Assurez-vous d'avoir correctement rempli tous les champs du formulaire, puis cliquez sur Envoyer.</p>
                        <ul class="list-inline pull-right">
                            <li><button type="submit" class="btn btn-success prev-step">Envoyer</button></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
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

