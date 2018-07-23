<?php

namespace RafaelaCampos;

class Model {

    private $values = [];

    //call -> sabe quando um método foi chamado
    public function __call($name, $args){

        //o último campo significa quantidade
        $method = substr($name, 0, 3);
        $fieldName = substr($name,3,strlen($name)); //vai até a última posição

        switch ($method){

            case "get":
                return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
            break;
            case "set":
                $this->values[$fieldName] = $args[0];
            break;

        }
    }

    public function setData($data = array()){

        foreach($data as $key => $value){

            $this->{"set".$key}($value);
        }
    }

    public function getValues(){

        return $this->values;
    }
}

?>