<?php
namespace LFW\Framework\Controller;

/**
 * Class TraductionFactory
 * @package LFW\Framework\Controller
 */
class TraductionFactory{
    /**
     * @param string $lang
     * @return object
     */
    public function trad($lang){
        $class = (string) 'Traductions\\Trad'.ucfirst($lang);
        return new $class();
    }

    /**
     * @param string $string
     * @param array $search
     * @param string $lang
     * @return mixed
     */
    public function translate($string, $search, $lang){
        $class = (string) 'Traductions\\Trad'.ucfirst($lang);
        $trad = new $class();

        $str = (string) $string;

        foreach($search as $v){
            str_replace('%'.$v.'%', $trad->show($v), $str);
        }

        return $str;
    }

    /**
     * @param string $lang
     * @param array $array
     * @param string $spec
     * @return array|object
     */
    public function multiple($lang, $array, $spec = 'object'){
        $path = 'Traductions\\Trad'.ucfirst($lang);
        $arr_translate = (array) [];

        $class = new $path();
        foreach($array as $str){
            $arr_translate[ $str ] = $class->show($str);
        }

        if($spec == 'array'){
            return $arr_translate;
        } elseif($spec == 'object') {
            return (object) $arr_translate;
        }
    }
}