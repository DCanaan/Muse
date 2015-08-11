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


	function mssql_escape_string($string) {
    	return str_replace('\'', '\'\'', $string);
	}

?>