<?php

namespace RafaelaCampos\Model;
use \RafaelaCampos\Database\Sql;
use \RafaelaCampos\Model;

class User extends Model {

    const SESSION = "User";

    public static function login ($login, $password){

        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        if(count($results) === 0){
            throw new \Exception("Usuário inexistente ou senha inválida!");
        }

        $data = $results[0];

        if(password_verify($password, $data["despassword"])){

            $user = new User();
            $user->setData($data);
            //var_dump($user);
            //exit;
            $_SESSION[User::SESSION] = $user->getValues();

            return $user;
        }
        else{
            throw new \Exception("Usuário inexistente ou senha inválida");
        }
    }

    public static function verifyLogin($inadmin = true){

        //Se a sessão não foi definida
        //Se ela for falsa
        //Se o id do usuário não for mais que 0
        //Se não for um usuário da administração
        if(
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
        ){
            header("Location: /admin/login");
        }
    }

}
?>