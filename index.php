<?php 

require_once("vendor/autoload.php");

$app = new \Slim\Slim();

$app->config('debug', true);

use \RafaelaCampos\Database\Sql;

$app->get('/', function() {
    
	$sql = new Sql();
	$result = $sql->select("SELECT * FROM tb_persons");
	echo json_encode($result);

});

$app->run();

 ?>