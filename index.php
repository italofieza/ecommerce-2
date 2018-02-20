<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \RafaelaCampos\Page;
use \RafaelaCampos\PageAdmin;
use \RafaelaCampos\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page(); //vai adicionar o header;
	$page->setTpl("index"); //vai adicionar o conteúdo do html;
	//e quando limpar a memória vai passar o footer;
});

$app->get('/admin', function(){
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("index");
});

$app->get('/admin/login', function(){
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
		//Isso foi feito porque por padrão o método construtor e destrutor vão adicionar o header e o footer
		//E nesse caso, o header e o footer do login é diferente, portanto não deve ser habilitado.
	]);
	$page->setTpl("login");
});

$app->post('/admin/login', function(){

	//Criar o método estático pq não sabemos qual é o usuário 
	User::login($_POST["login"], $_POST["password"]);

	//Redireciona para a pag da administraçãao
	header("Location: /admin");
	exit;
});
$app->run();

 ?>