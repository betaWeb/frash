<?php
namespace Frash\Framework\Routing\Gets;
use Frash\Framework\Exception\Exception;

/**
 * Class GetRoute
 * @package Frash\Framework\Routing\Gets
 */
class GetRoute{
    /**
     * @param string $content
     * @param array $get_routing
     * @return bool
     */
    public static function define(string $content, array $get_routing): bool{
        if($get_routing['type'] == 'integer' && !ctype_digit($content)){ return false; }
        if($get_routing['type'] == 'double' && !preg_match('/[^0-9(.{1})]/', $content)){ return false; }

        return true;
    }
}