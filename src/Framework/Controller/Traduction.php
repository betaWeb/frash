<?php
namespace Frash\Framework\Controller;
use Frash\Framework\DIC\Dic;

/**
 * Class Traduction
 * @package Frash\Framework\Controller
 */
class Traduction
{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * Traduction constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
    }

    /**
     * @param string $lang
     * @return object
     */
    public function trad(string $lang = 'lang'){
        $lang = ($lang == 'lang') ? $this->dic->lang : $lang;
        $class = (string) 'Traductions\\Trad'.ucfirst($lang);
        
        return new $class;
    }

    /**
     * @param string $string
     * @param array $search
     * @param string $lang
     * @return mixed
     */
    public function translate($string, $search, string $lang = 'lang'){
        $lang = ($lang == 'lang') ? $this->dic->lang : $lang;
        $class = (string) 'Traductions\\Trad'.ucfirst($lang);
        $trad = new $class;

        $str = (string) $string;

        foreach($search as $v){
            str_replace('%'.$v.'%', $trad->$v, $str);
        }

        return $str;
    }

    /**
     * @param string $lang
     * @param array $array
     * @param string $spec
     * @return array|object
     */
    public function multiple(string $lang = 'lang', array $array, string $spec = 'object'){
        $lang = ($lang == 'lang') ? $this->dic->lang : $lang;
        $path = 'Traductions\\Trad'.ucfirst($lang);
        $arr_translate = (array) [];

        $class = new $path;
        foreach($array as $str){
            $arr_translate[ $str ] = $class->$str;
        }

        if($spec == 'array'){
            return $arr_translate;
        } elseif($spec == 'object') {
            return (object) $arr_translate;
        }
    }
}