<?php include('login.php'); ?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">M'Effleure La Muse</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="produits.php">Produits</a>
                    </li>
                    <li>
                        <a href="#">Panier</a>
                    </li>
                    <li>
                        <a href="faq.php">FAQ</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    <?php
       
        if(!isConnected()) { 
                echo "<li><a href=\"inscription.php\">Inscription</a></li>";
                ?> <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Connexion</b> <span class="caret"></span></a>
            <ul id="login-dp" class="dropdown-menu">
                <li>
                     <div class="row">
                            <div class="col-md-12">
                                 <form class="form" role="form" method="post" action="login.php" accept-charset="UTF-8" id="login-nav">
                                        <div class="form-group">
                                             <label class="sr-only" for="exampleInputEmail2">Adresse email</label>
                                             <input type="email" class="form-control" name="exampleInputEmail2" id="exampleInputEmail2" placeholder="Adresse email" required>
                                        </div>
                                        <div class="form-group">
                                             <label class="sr-only" for="exampleInputPassword2">Mot de passe</label>
                                             <input type="password" class="form-control" name="exampleInputPassword2" id="exampleInputPassword2" placeholder="Mot de passe" required>
                                             <div class="help-block text-right"><a href="">Mot de passe oublié ?</a></div>
                                        </div>
                                        <div class="form-group">
                                             <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                                        </div>
                                 </form>
                            </div>
                            <div class="bottom text-center">
                                Pas encore de compte ? <a href="#"><b>Inscrivez-vous !</b></a>
                            </div>
                     </div>
                </li> <?php }
 
        else {
                echo "<li><a href=\"profil.php\">Mon profil</a></li>";

                if (isadmin()) { 
                    echo ("<li><a href=\"gestion.php\">Administration</a></li>");
                }
                

                echo "<li><a href=\"logout.php\">Déconnexion</a></li>";
                
        }
 
?>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <?php if(isConnected() && !isverified()) { ?>
    <div class="alert alert-danger non-verif" role="alert">Votre compte n'est pas activé. Veuillez cliquer sur le lien de validation que vous avez reçu par mail afin de pouvoir passer une commande.</div>
    <?php } ?>

