<?php
    namespace LFW\Framework\Routing;
    use LFW\Framework\Exception\Exception;

    /**
     * Class DefineGet
     * @package LFW\Framework\Routing
     */
    class DefineGet{
        /**
         * @param array $routarr
         * @param array $list
         * @param int $racine
         * @return array|Exception
         */
        public static function defineNormal($routarr, $list, $racine){
            $count_expl = count($list) - 2;
            $get = [];

            if($racine == 0){
                for($i = 0; $i <= $count_expl; $i++){
                    $getc = $routarr[ $i ];
                    if(isset($getc)){
                        if($getc['fix'] == 'yes' && empty($list[ $i ])){ return new Exception('Get : Url incorrecte.'); }

                        if($getc['fix'] == 'yes'){
                            if($routarr[ $i ]['type'] == 'integer'){
                                if(!ctype_digit($list[ $i ])){ return new Exception('Get : Url incorrecte.'); }
                            }
                        }

                        $get[] = urldecode(htmlentities($list[ $i ]));
                    }
                }
            }
            elseif($racine == 1){
                for($i = 0; $i <= $count_expl; $i++){
                    if(isset($routarr[ $i ])){
                        if($routarr[ $i ]['fix'] == 'yes' && empty($list[ $i ])){ return new Exception('Get : Url incorrecte.'); }

                        if($routarr[ $i ]['fix'] == 'yes' || ($routarr[ $i ]['fix'] == 'no' && !empty($list[ $i ]))){
                            if($routarr[ $i ]['type'] == 'integer' && !ctype_digit($list[ $i ])){ return new Exception('Get : Url incorrecte.'); }
                            if($routarr[ $i ]['type'] == 'double' && !preg_match('/[^0-9(.{1})]/', $list[ $i ])){ return new Exception('Get : Url incorrecte.'); }
                        }

                        $get[] = urldecode(htmlentities($list[ $i ]));
                    }
                }
            }

            return $get;
        }

        /**
         * @param array $path
         * @param array $gets
         * @return array|Exception
         */
        public static function defineDev($path, $gets){
            $count = count($path) - 1;
            $get = [];

            for($i = 1; $i <= $count; $i++){
                $curr = $i - 1;
                $getc = $gets[ $curr ];

                if(isset($getc)){
                    if($getc['fix'] == 'yes' && empty($path[ $i ])){ return new Exception('Get : Url incorrecte.'); }

                    if($getc['fix'] == 'yes'){
                        if($gets[ $i ]['type'] == 'integer'){
                            if(!ctype_digit($path[ $i ])){ return new Exception('Get : Url incorrecte.'); }
                        }
                    }

                    $get[] = urldecode(htmlentities($path[ $i ]));
                }
            }

            return $get;
        }
    }