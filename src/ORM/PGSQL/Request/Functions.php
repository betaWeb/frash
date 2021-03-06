<?php
namespace Frash\ORM\PGSQL\Request;

/**
 * Class Functions
 * @package Frash\ORM\PGSQL\Request
 */
class Functions{
    /**
     * @param $pdo
     * @param array $array
     * @return string
     */
    public static function concat($pdo, array $array): string{
        $arr = [];

        foreach($array as $v){
            $arr[] = self::defineType($pdo, $v);
        }

        return 'CONCAT('.implode(', ', $arr).')';
    }

    /**
     * @param $pdo
     * @param mixed $source
     * @param mixed $target
     * @return string
     */
    public static function leven($pdo, $source, $target): string{
        $sourc = self::defineType($pdo, $source);
        $targ = self::defineType($pdo, $target);

        return 'levenshtein('.$sourc.', '.$targ.')';
    }

    /**
     * @param $pdo
     * @param mixed $param
     * @return string
     */
    private static function defineType($pdo, $param): string{
        if(substr($param, 0, 2) == 'c '){
            $string = substr($param, 2);
            return "\"$string\"";
        } elseif(substr($param, 0, 1) == ':') {
            return "$param::text";
        } else {
            return $pdo->quote($param);
        }
    }
}