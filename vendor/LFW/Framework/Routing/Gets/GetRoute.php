<?php
    namespace LFW\Framework\Routing\Gets;
    use LFW\Framework\Exception\Exception;

    /**
     * Class GetRoute
     * @package LFW\Framework\Routing\Gets
     */
    class GetRoute{
        /**
         * @param mixed $content
         * @param array $get_routing
         * @return bool
         */
        public static function define($content, array $get_routing){
            if($get_routing['fix'] == 'yes' && empty($content)){ return new Exception('Get : Url incorrecte.'); }

            if($get_routing['fix'] == 'yes' || ($get_routing['fix'] == 'no' && !empty($content))){
                if($get_routing['type'] == 'integer' && !ctype_digit($content)){ return new Exception('Get : Url incorrecte.'); }
                if($get_routing['type'] == 'double' && !preg_match('/[^0-9(.{1})]/', $content)){ return new Exception('Get : Url incorrecte.'); }
            }

            return true;
        }
    }