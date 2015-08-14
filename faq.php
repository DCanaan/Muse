<?php
    require_once("config.php"); 

    $c1=$bdd->query("SELECT * FROM faq WHERE categorie = '1' ORDER BY id asc");
    $c2=$bdd->query("SELECT * FROM faq WHERE categorie = '2' ORDER BY id asc");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FAQ - M'Effleure La Muse</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">
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
    <?php include("navbar.php");?>

    <!-- Page Content -->
    <div class="container">
        <br />
        <br />
        <br />



        <br />

        <div class="panel-group" id="accordion">
            <div class="faqHeader">Catégorie 1</div>
            <div class="panel panel-default">
                <?php while($ligne1 = $c1-> fetch()) { ?>
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo($ligne1['id']); ?>"><?php echo($ligne1['question']); ?></a>
                    </h4>
                </div>
                <div id="collapse<?php echo($ligne1['id']); ?>" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <?php echo($ligne1['reponse']); ?>
                    </div>
                </div> <?php } ?>
            </div>

            <div class="faqHeader">Catégorie 2</div>
            <div class="panel panel-default">
                <?php while($ligne2 = $c2-> fetch()) { ?>
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo($ligne2['id']); ?>"><?php echo($ligne2['question']); ?></a>
                    </h4>
                </div>
                <div id="collapse<?php echo($ligne2['id']); ?>" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <?php echo($ligne2['reponse']); ?>
                    </div>
                </div> <?php } ?>
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
                    <p>Copyright &copy; M'Effleure La Muse 2015</p>
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
