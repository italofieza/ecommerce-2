<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \RafaelaCampos\Page;
use \RafaelaCampos\PageAdmin;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page(); //vai adicionar o header;
	$page->setTpl("index"); //vai adicionar o conteúdo do html;
	//e quando limpar a memória vai passar o footer;
});

$app->get('/admin', function(){
	$page = new PageAdmin();
	$page->setTpl("index");
});

$app->run();

 ?>