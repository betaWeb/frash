<?php
    namespace LFW\Framework\Utility;

    /**
     * Class GenPass
     * @package LFW\Framework\Utility
     */
    class GenPass{
        /**
         * @param int $size
         * @param bool $number
         * @param bool $min
         * @param bool $maj
         * @param bool $otca
         * @return string
         */
        public static function getGenPass(int $size, bool $number, bool $min, bool $maj, bool $otca): string{
            $caract = '';
            $poss = 0;
            if($number === true){
                $caract .= '123456789';
                $poss += 9;
            }

            if($min === true){
                $caract .= 'abcdefghijklmnopqrstuvwxyz';
                $poss += 26;
            }

            if($maj === true){
                $caract .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $poss += 26;
            }

            if($otca === true){
                $caract .= '&#{([-_@)]=}+$?';
                $poss += 16;
            }

            $gener = '';
            for($i = 0; $i <= $size; $i++){
                $rand = mt_rand(0, $poss - 1);
                $gener .= $caract[ $rand ];
            }

            return $gener;
        }
    }