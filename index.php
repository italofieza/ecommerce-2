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

	//Redireciona para a pag da administração
	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function(){

	User::logout();
	header("Location: /admin/login");
	exit;
});

$app->get('/admin/users', function(){

	User::verifyLogin();
	$users = User::listAll();
	$page = new PageAdmin();
	$page->setTpl("users", array(
		"users"=>$users
	));

});

$app->get('/admin/users/create', function(){

	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("users-create");
});

$app->get("/admin/users/:iduser/delete", function($iduser){

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /admin/users");
	exit;
});

$app->get('/admin/users/:iduser', function($iduser){

	User::verifyLogin();
	$user = new User();
	$user->get((int)$iduser);
	$page = new PageAdmin();
	$page->setTpl("users-update", array(
		"user"=>$user->getValues()
	));
});

$app->post("/admin/users/create", function(){

	User::verifyLogin();
	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->setData($_POST);
	$user->save();

	header("Location: /admin/users");
	exit;

});

$app->get("/admin/users/:iduser", function($iduser){

	User::verifyLogin();
});

$app->post("/admin/users/:iduser", function($iduser){

	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit;
});



$app->run();

 ?>