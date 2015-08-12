<?php require_once("config.php");
require_once('PHPMailer/class.phpmailer.php');


//Création des variables, ce qui va permettre de les récupèrer dans le HTML.
$messages= [];
 
$prenom = null;
$nom = null;
$email = null;
$password = null;
$password_confirmation = null;
$dateNaissance = null;
$telephone = null;
$adresse = null;
$ville = null;
$zipcode = null;
$pays = null;
 
//Empty vérifie si la variable existe 	mais elle doit être vide, ! devant un booléen l'inverse.
if(!empty($_POST))
	{
  	//Isset vérifie qu'une ou plusieurs variables existe et ne sont pas null/false. 
    if(isset($_POST["prenom"], $_POST["nom"], $_POST["email"], $_POST["password"], $_POST["password_confirmation"], $_POST["dateNaissance"], $_POST["telephone"], $_POST["adresse"], $_POST["ville"], $_POST["zipcode"], $_POST["pays"]))
    	{
     	//Récupération des valeurs, ça permet de mettre à jour les variables par défaut et réafficher le formulaire avec les bonnes valeurs, attention à TOUJOURS filtrer ce qui vient d'un utilisateur pour éviter des failles.
    	$prenom = $_POST['prenom'];
    	$nom = $_POST['nom'];
    	$email = $_POST['email'];
	    $password = $_POST['password'];
	    $password_confirmation = $_POST['password_confirmation'];
	    $dateNaissance = $_POST["dateNaissance"];
 		$telephone = $_POST["telephone"];
 		$adresse = $_POST["adresse"];
 		$ville = $_POST["ville"];
 		$zipcode = $_POST["zipcode"];
 		$pays = $_POST["pays"];
 		$clefCompte = bin2hex(openssl_random_pseudo_bytes(10));
    	//Test des variables.
  		//Si pas alphanumérique ou si vide : erreur.
    	if(mb_strlen($prenom) < 1)
    	    $messages[] = "Erreur prénom (caractères alphanumériques) ou champ vide.";
              
    	if(mb_strlen($nom) < 1)
    	    $messages[] = "Erreur nom (caractères alphanumériques) ou champ vide.";

    	// if(!ctype_alnum($adresse) || mb_strlen($adresse) < 5)
    	//     $messages[] = "Erreur adresse (caractères alphanumériques) ou champ vide.";

    	if(mb_strlen($ville) < 1)
    	    $messages[] = "Erreur ville (caractères alphanumériques) ou champ vide.";

    	if(mb_strlen($pays) < 1)
    	    $messages[] = "Erreur pays (caractères alphanumériques) ou champ vide.";

    	// if (!DateTime::createFromFormat('d/m/Y', $dateNaissance))
    	//     $messages[] = "Erreur date ou champ vide.";

    	if(!ctype_digit($telephone) || mb_strlen($telephone) < 10)
    	    $telephone[] = "Erreur telephone (caractères numériques) ou champ vide.";


    	if(!ctype_digit($zipcode) || mb_strlen($zipcode) < 5)
    	    $telephone[] = "Erreur code postal (caractères numériques) ou champ invalide.";


		//Force un format email. 
    	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    	    $messages[] = "Erreur email (mauvais format).";
 		
 		//Force un minimum de 8 caractères.
    	if(mb_strlen($password) < 8)
    	    $messages[] = "Erreur mot de passe (8 caractères minimum).";

    	if(mb_strlen($password_confirmation) < 8)
    	    $messages[] = "Erreur vérification du mot de passe (8 caractères minimum).";

    	//Vérifie que les deux mots de passe concordent.
    	if($password != $password_confirmation)
    		$messages[] = "Les deux mots de passe sont différents.";
 
    	//Check fini, si l'array $message est vide, aucun problème, sinon j'en ai une ou plusieurs.
    	if(count($messages) === 0)
    		{
    	    $password = sha1($password);//on crypte le mdp rentré par sha1 afin de le rentrer en BDD
    
			try
                {
                $register = $bdd->prepare("INSERT INTO users (prenom, nom, email, password, dateNaissance, telephone, adresse, ville, zipcode, pays, clefCompte) VALUES (:prenom, :nom, :email, :password, :dateNaissance, :telephone, :adresse, :ville, :zipcode, :pays, :clefCompte)");

                $register->execute([
                    ":prenom" => securite_bdd($prenom),
                    ":nom" => securite_bdd($nom),
                    ":email" => securite_bdd($email),
                    ":password" => securite_bdd($password),
                    ":dateNaissance" => securite_bdd($dateNaissance),
                    ":telephone" => securite_bdd($telephone),
                    ":adresse" => securite_bdd($adresse),
                    ":ville" => securite_bdd($ville),
                    ":zipcode" => securite_bdd($zipcode),
                    ":pays" => securite_bdd($pays),
                    ":clefCompte" => $clefCompte
                    ]);
 
                $messages = 'Inscription réussie ! Veuilez cliquer sur le lien de validation que vous avez reçu par mail.';
                $mail = new PHPMailer();

				$mail->IsHTML(true);
				$mail->CharSet = "utf-8";
				$mail->From = 'contact@muse.com';
				$mail->FromName = 'M\'Effleure La Muse';
				$mail->Subject = 'Bienvenue sur M\'Effleure La Muse';
				$mail->Body = 
				'Bonjour '.$prenom.' '.$nom.', <br/>
				Vous venez de créer votre compte sur M\'Effleure La Muse. Afin de valider votre inscription, veuillez cliquer sur le lien suivant :
				<a href="http://localhost/Meffleure%20La%20Muse/validation.php?mail='.$email.'&clefCompte='.$clefCompte.'">valider mon adresse mail</a>
				';
				$mail->AddAddress($email);
	
    			$mail->Send();


                }    	

    		catch(Exception $e)
    			{
        		if($e->getCode() == 23000)
        			$messages = 'Ces identifiants existent déjà.';
        	
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

    <title>Inscription - M'Effleure La Muse</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->

    <?php include("navbar.php"); ?>

    <!-- Page Content -->
    <div class="container">
    	<div class="row formulaire_inscription">
    <div class="col-xs-12 col-sm-10 col-md-10 col-sm-offset-1 col-md-offset-1">
		<form role="form" method="post">
			<h2>Inscrivez-vous gratuitement</h2>
			<hr class="colorgraph">
			<?php if(!empty($messages)) {?><div class="alert alert-info" role="alert">
			  <?php showErrors($messages) ?>
			</div><?php } ?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
                        <input type="text" name="prenom" id="prenom" class="form-control input-md" value="<?= escape($prenom); ?>" placeholder="Prénom" tabindex="1">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="text" name="nom" id="nom" class="form-control input-md" value="<?= escape($nom); ?>" placeholder="Nom" tabindex="2">
					</div>
				</div>
			</div>

			<div class="form-group">
				<input type="email" name="email" id="email" class="form-control input-md" value="<?= escape($email); ?>" placeholder="Adresse email" tabindex="3">
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control input-md" placeholder="Mot de passe" tabindex="4">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-md" placeholder="Confirmation du mot de passe" tabindex="5">
					</div>
				</div>
			</div>
			<div class="form-group">
				<input type="tel" name="telephone" id="telephone" class="form-control input-md" value="<?= escape($telephone); ?>" placeholder="Télephone" tabindex="6">
			</div>
			<div class="form-group">
				<label>Date de naissance</label>
				<input type="date" name="dateNaissance" id="dateNaissance" class="form-control input-md" value="<?= escape($dateNaissance); ?>"placeholder="Date de naissance" tabindex="7">
			</div>

			<div class="form-group">
				<label>Adresse de livraison en cas de commande</label>
				<input type="text" name="adresse" id="adresse" class="form-control input-md" value="<?= escape($adresse); ?>" placeholder="Adresse" tabindex="8">
			</div>
			<div class="form-group">
				<input type="text" name="ville" id="ville" class="form-control input-md"value="<?= escape($ville); ?>" placeholder="Ville" tabindex="9">
			</div>
			<div class="form-group">
				<input type="text" name="zipcode" id="zipcode" class="form-control input-md" value="<?= escape($zipcode); ?>" placeholder="Code Postale" tabindex="10">
			</div>
			<div class="form-group">
				<input type="text" name="pays" id="pays" class="form-control input-md" value="<?= escape($pays); ?>" placeholder="Pays" tabindex="11">
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-md-12"><input type="submit" value="S'inscrire" class="btn btn-primary btn-block btn-md" tabindex="12"></div>
			</div>
		</form>
	</div>
</div>
    </div>
    

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Meffleure La Muse 2015</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

