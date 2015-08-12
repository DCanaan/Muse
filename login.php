<?php require_once("config.php"); 

$messages= [];

$email = null;
$password = null;
$user_info = null;
$user = null;

if(!empty($_POST)) {
    if(isset($_POST["exampleInputEmail2"], $_POST["exampleInputPassword2"])) {
        $email = $_POST['exampleInputEmail2'];
        $password = $_POST['exampleInputPassword2'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $messages[] = "Erreur email (mauvais format).";

        if(mb_strlen($password) < 8)
            $messages[] = "Erreur mot de passe (8 caractères minimum).";

        $user_info = $bdd -> prepare('SELECT id, email, password FROM users WHERE email=:email');
        $user_info -> execute([":email" => "$email"]);

        if($user_info -> rowCount() != 1)
            $messages[] = "Cet email n'est pas inscrit.";

        $user = $user_info -> fetch(); 
        $password = sha1($password);

        if($password != $user["password"]) {
            $messages[] = "Mot de passe incorrect.";
            header('Location: produits.php?mdp=incorrect'); }

        if(count($messages) === 0) {
            try {   
                $_SESSION["userID"] = $user["id"];
                header('Location: produits.php'); }

            catch(Exception $e) {
                $messages[] = 'Nous sommes incapables de procéder à votre demande. Veuillez réessayer plus tard.'; } 

        }
    }
}
?>