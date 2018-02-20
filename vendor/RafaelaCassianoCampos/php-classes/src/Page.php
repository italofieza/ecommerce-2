<?php

namespace RafaelaCampos;

use Rain\Tpl;

class Page {

    //Pra que tenha acesso a outros métodos é interessante que o $tpl seja um atributo
    private $tpl;
    private $options = [];
    private $defaults = [
        "header"=>true,
        "footer"=>true,
        "data"=>[
            "data"=>[]
        ]
    ];

    public function __construct($opts = array(), $tpl_dir = "/views/"){

        $this->defaults["data"]["session"] = $_SESSION;
        //O array_merge irá mesclar e substituir o primeiro parâmetro, que nesse caso é o $this->defaults pelo $opt
        $this->options = array_merge($this->defaults, $opts);
        $config = array(
            "tpl_dir" => $_SERVER["DOCUMENT_ROOT"] .$tpl_dir,
            "cache_dir" => $_SERVER["DOCUMENT_ROOT"] ."/views-cache/",
            "debug"     => false
        );

        Tpl::configure($config);

        $this->tpl = new Tpl;

        $this->setData($this->options["data"]);

        //Se o header estiver habilitado desenhe na tela
        if($this->options["header"] === true) $this->tpl->draw("header");
        //vai desenhar o header quando inicializar
    }

    private function setData($data = array()){

        foreach($data as $key => $value){
            $this->tpl->assign($key, $value);
        } 
        //depois vai desenhar o conteúdo da página
    }

    public function setTpl($name, $data = array(), $returnHTML = false){

        $this->setData($data);
        return $this->tpl->draw($name, $returnHTML);
    }

    public function __destruct(){
        //Se o header estiver habilitado desenhe na tela
        if($this->options["footer"] === true) $this->tpl->draw("footer");
        //e por último vai desenhar o footer
    }
}

?>