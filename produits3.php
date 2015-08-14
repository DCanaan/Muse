<?php
    require_once("config.php"); 
    $q=$bdd->query("SELECT * FROM produits ORDER BY nbAjouts desc");
    $ligne = $q-> fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Produits - M'Effleure La Muse</title>

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
        <?php if(isset($_POST['messageActivation'])) { ?>
        <div class="alert alert-info non-verif" role="alert"><?php echo($_POST['messageActivation']);?></div>
        <?php } ?>
        <?php if(isset($_GET['mdp']) && $_GET['mdp']=='incorrect') { ?>
        <div class="alert alert-danger mdp" role="alert">Mot de passe incorrect</div>
        <?php } ?>
        <div class="row">

            <div class="col-md-3">
                <p class="lead">Boutique en ligne</p>
                <div class="list-group">
                    <a href="produits.php" class="list-group-item">Les nouveautés</a>
                    <a href="produits2.php" class="list-group-item">Les plus consultés</a>
                    <a href="#" class="list-group-item">Les best-seller</a>
                </div>
            </div>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="slider/Slider-1.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="slider/Slider-2.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="slider/Slider-3.jpg" alt="">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <?php $sql = $bdd->query("SELECT count(*) as nb from produits");
                    $data = $sql->fetch();
                    $nb = $data['nb'];
                    $i = 0;
                    while ($i < $nb){
                        ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="img/<?php echo($ligne["id"]);?>/<?php echo($ligne["titre"]);?>Cover.jpg" alt="" style="width:320px;height:150px;">
                            <div class="caption">
                                <h4 class="pull-right"><?php echo($ligne["prix"]);?>€</h4>
                                <h4><a href="produit.php?idProduit=<?php echo($ligne['id'])?>"><?php echo($ligne["titre"]);?></a>
                                </h4>
                                <p><?php echo($ligne["description"]);?></p>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">15 reviews</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php $ligne = $q->fetch(); $i++; } ?>
                    

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <h4><a href="#">Like this template?</a>
                        </h4>
                        <p>If you like this template, then check out <a target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">this tutorial</a> on how to build a working review system for your online store!</p>
                        <a class="btn btn-primary" target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">View Tutorial</a>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

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
