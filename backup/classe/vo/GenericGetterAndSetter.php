<?php

/**
 * Created by PhpStorm.
 */

class GenericGetterAndSetter{
    function set($name, $value){
        $alterado = FALSO; 
        foreach($this as $key => $v) {
            if($key == $name){
                $this->$key = $value;
                $alterado = TRUE;
                break;
            }
        }
        if(!$alterado){
            $trace = debug_backtrace();
            trigger_error(
                'set: Atributo desconhecido = '.$name.' em '.$trace[0]['file'] .' na linha '. $trace[0]['line'],
                E_USER_NOTICE);
            die();
        }
    }
    function get($name){
        foreach ($this as $key => $value) {
            if($key == $name){
                return $value;
            }
        }
        $trace = debug_backtrace();
        trigger_error(
            'get: Atributo desconhecido = '.$name.' em '.$trace[0]['file'].' na linha '.$trace[0]['line'],
            E_USER_NOTICE);
        die();
    }
}
?>