<?php
require_once("config.php");
$mail=$_GET['mail'];
$clefCompte=$_GET['clefCompte'];

$user_name = $bdd -> prepare("SELECT clefCompte, email FROM users WHERE email ='$mail'");
$user_name -> execute();
$user = $user_name->fetch();

if ($user['clefCompte'] == $clefCompte) { 
	$compteactive = $bdd -> prepare("UPDATE users SET compteActif='1' WHERE email ='$mail'");
	$compteactive -> execute();
	$messageActivation = "Votre compte a été validé avec succes. Vous pouvez désormais poursuivre pleinement votre navigation sur le site.";
}

else {
	$messageActivation = "Votre compte n'a pas pu être validé.";
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
			<h2><?php echo($messageActivation); ?></h2>
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