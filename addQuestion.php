<?php
error_reporting(E_ALL); 
// // echo($message);
ini_set('display_errors', 'On');

require_once("config.php");


if(!isConnected() || !isadmin()){
    header('Location: index.php');
};


//Création des variables, ce qui va permettre de les récupèrer dans le HTML.
$messages= [];
 
$question = null;
$reponse = null;
$categorie = null;
 
//Empty vérifie si la variable existe   mais elle doit être vide, ! devant un booléen l'inverse.
if(!empty($_POST))
    {
    //Isset vérifie qu'une ou plusieurs variables existe et ne sont pas null/false. 
    if(isset($_POST["question"], $_POST["reponse"], $_POST["categorie"]))
        {
        //Récupération des valeurs, ça permet de mettre à jour les variables par défaut et réafficher le formulaire avec les bonnes valeurs, attention à TOUJOURS filtrer ce qui vient d'un utilisateur pour éviter des failles.
        $question = $_POST['question'];
        $reponse = $_POST['reponse'];
        $categorie = $_POST['categorie'];
        
        //Test des variables.
        //Si pas alphanumérique ou si vide : erreur.
        if(mb_strlen($question) < 1)
            $messages[] = "Erreur dans la question ou champ vide.";
              
        if(mb_strlen($reponse) < 1)
            $messages[] = "Erreur dans la réponse ou champ vide.";


        if(!ctype_digit($categorie) || mb_strlen($categorie) < 1)
            $messages[] = "Erreur catégorie (caractères numériques) ou champ vide.";


        //Check fini, si l'array $message est vide, aucun problème, sinon j'en ai une ou plusieurs.
        if(count($messages) === 0)
            {
                
                    $modif = $bdd->prepare("INSERT INTO faq (question, reponse, categorie) VALUES (:question, :reponse, :categorie)");

                    $modif->execute([
                        ":question" => securite_bdd($question),
                        ":reponse" => securite_bdd($reponse),
                        ":categorie" => securite_bdd($categorie)
                        ]);
                    

                    // $selectId = $bdd -> prepare("SELECT id FROM produits ORDER BY id DESC LIMIT 1");
                    // $selectId -> execute();


                    $messages = 'Ajout réussi !';
                              

                        
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
                    <?php echo($messages); ?>
                    </div><?php } ?>
                    <section>
                        <div class="wizard">

                        <form role="form" method="post">
                            <h3>Modification FAQ</h3>
                            <div class="row">
                                    <div class="form-group">
                                        <label>Question</label>
                                        <textarea name="question" id="question" class="form-control input-md" placeholder="Question" tabindex="1"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Réponse</label>
                                        <textarea name="reponse" id="reponse" class="form-control input-md" placeholder="Descriptif de l'annonce" tabindex="2" rows="10"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Catégorie (1 ou 2)</label>
                                        <input type="number" name="categorie" min="0" max="15" size="2" title="Only numbers are allowed" value="" tabindex="3"/>
                                    </div>
                            </div>
                            <ul class="list-inline pull-right">
                                <li><button type="submit" class="btn btn-success prev-step">Envoyer</button></li>
                            </ul>
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

