<?php
namespace Frash\DocGen;

/**
 * Class TreatmentList
 * @package Frash\DocGen
 */
class TreatmentList{
    /**
     * @var array
     */
    private static $exceptions = [
        '.git', '.idea', 'Storage', 'vendor/twig', 'console.php', 'index.php', 'vendor/autoload.php', 'vendor/composer', 'vendor/alixsperoza/frash/src/Console/listcommand.php'
    ];

    /**
     * @var array
     */
    private static $except_def = [];

    /**
     * @var array
     */
    private static $list = [];

    /**
     * @param string $except
     */
    public static function setExcept(string $except = ''){
        self::$except_def = ($except == '') ? [] : explode(';', $except);
    }

    /**
     * @param array $list
     * @return array;
     */
    public static function removeExcept(array $list){
        self::$list = $list;

        $count_for = count($list) - 1;
        for($i = 0; $i <= $count_for; $i++){
            self::defineNewList($list[ $i ], $i);
        }

        return self::$list;
    }

    /**
     * @param string $path
     * @param int $current
     */
    private static function defineNewList(string $path, int $current){
        $except = (!empty(self::$except_def)) ? array_merge(self::$exceptions, self::$except_def) : self::$exceptions;
        $count_for = (int) count($except) - 1;

        for($i = 0; $i <= $count_for; $i++){
            if(strstr($path, $except[ $i ]) !== false || substr($path, -2) == '..' || substr($path, -1) == '.' || substr($path, -4) != '.php'){
                unset(self::$list[ $current ]);
                break;
            }
        }
    }
}