<?php
namespace LFW\Framework\FileSystem;
use LFW\Framework\FileSystem\File;

/**
 * Class Json
 * @package LFW\Framework\FileSystem
 */
class Json{
    /**
     * @param mixed $json
     * @return string
     */
    public static function encode($json, string $type = ''): string{
        if($type == ''){
            return json_encode($json);
        } elseif($type == 'JSON_PRETTY_PRINT') {
            return json_encode($json, JSON_PRETTY_PRINT);
        }
    }

    /**
     * @param string $json
     * @return array|object
     */
    public static function decode(string $json, string $object = 'false'){
        if($object == 'false'){
            return json_decode($json, true);
        } elseif($object == 'true') {
            return json_decode($json);
        }
    }
}