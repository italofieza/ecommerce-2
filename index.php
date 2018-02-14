<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \RafaelaCampos\Page;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page(); //vai adicionar o header;
	$page->setTpl("index"); //vai adicionar o conteúdo do html;
	//e quando limpar a memória vai passar o footer;
});

$app->run();

 ?>