<?php 

namespace RafaelaCampos;

class PageAdmin extends Page {

    public function __construct($opts = array(), $tpl_dir = "/views/admin/"){

        //parent:: é da classe mãe
        parent::__construct($opts, $tpl_dir);
    }
    
}

?>