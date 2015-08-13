<?php
	session_start();

	define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])));
	require 'functions.php';

	function bddConnect(){

		$databases =array(

			'default' => array(
				'host'		=> 'localhost',
				'database'	=> 'muse',
				'login'		=> 'root',
				'password'	=> 'root',
			)
		);

		$thisConf = 'default';
		$conf = $databases[$thisConf];

		try{
			global $bdd;
			$bdd = new PDO(
				'mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
				$conf['login'],
				$conf['password'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
			);
			$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	bddConnect();
/*----------------------------------------------------------------------------------------------------------------------------*/
	function securite_bdd($string)
	{
		$databases =array(

			'default' => array(
				'host'		=> 'localhost',
				'database'	=> 'muse',
				'login'		=> 'root',
				'password'	=> 'root',
			)
		);

		$thisConf = 'default';
		$conf = $databases[$thisConf];

		try{
			global $bdd;
			$bdd = new PDO(
				'mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
				$conf['login'],
				$conf['password'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
			);
			$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
		}catch(PDOException $e){
			die($e->getMessage());
		}
		// On regarde si le type de string est un nombre entier (int)
		if(ctype_digit($string))
		{
			$string = intval($string);
		}
		// Pour tous les autres types
		else
		{
			
			$string = addcslashes($string, '%_');
		}
		
		return $string;
	}

	function escape($text)
		{
		return htmlspecialchars($text, ENT_QUOTES);
		}

/*----------------------------------------------------------------------------------------------------------------------------*/

	function showErrors($messages)
		{
        $messages = (array) $messages;
 
        //Count != 0 donc ça équivaut à un true pour php
        if(count($messages))
        	{
            foreach($messages AS $error)
            	{
?>

	<span class="error"><?= escape($error); ?></span>

<?php
                }
        	}
		}

/*----------------------------------------------------------------------------------------------------------------------------*/

	function isConnected()
		{ 
		return isset($_SESSION["userID"]) && $_SESSION["userID"];
		}

/*----------------------------------------------------------------------------------------------------------------------------*/

	function mssql_escape_string($string) {
    	return str_replace('\'', '\'\'', $string);
	}

	/*----------------------------------------------------------------------------------------------------------------------------*/

	function isadmin()
	{ 
		$bdd = new PDO('mysql:host=localhost;dbname=muse', 'root', 'root', [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if (!empty($_SESSION["userID"])) {
		$verifadmin = $bdd -> prepare("SELECT admin FROM users WHERE id =".$_SESSION["userID"]);
                $verifadmin -> execute();
                $numadmin = $verifadmin->fetch();
                if ($numadmin['admin'] == 1) {return TRUE;}
        }else{
        	return false;
        } 
	}

/*----------------------------------------------------------------------------------------------------------------------------*/

	function isverified()
	{ 
		$bdd = new PDO('mysql:host=localhost;dbname=muse', 'root', 'root', [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if (!empty($_SESSION["userID"])) {
		$verif = $bdd -> prepare("SELECT compteActif FROM users WHERE id =".$_SESSION["userID"]);
                $verif -> execute();
                $verified = $verif->fetch();
                if ($verified['compteActif'] == 1) {return TRUE;}
        }else{
        	return false;
        } 
	}

/*----------------------------------------------------------------------------------------------------------------------------*/

	function rrmdir($dir) {
   		if (is_dir($dir)) {
     	$objects = scandir($dir);
     	foreach ($objects as $object) {
       	if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   		}
 	}

/*----------------------------------------------------------------------------------------------------------------------------*/

 	function webroot($url) {
		trim($url,'/');
		return BASE_URL.'/'.$url;
	}

?>