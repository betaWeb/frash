<?php
    namespace LFW\Framework\Utility;

    /**
     * Class GenPass
     * @package LFW\Framework\Utility
     */
    class GenPass{
        /**
         * @var int
         */
        private static $size;

        /**
         * @var bool
         */
        private static $number = false;

        /**
         * @var bool
         */
        private static $min = false;

        /**
         * @var bool
         */
        private static $maj = false;

        /**
         * @var bool
         */
        private static $otca = false;

        /**
         * GenPass constructor.
         * @param int $size
         * @param bool $number
         * @param bool $min
         * @param bool $maj
         * @param bool $otca
         */
        public function __construct($size, $number, $min, $maj, $otca){
            self::$size = $size;
            self::$number = $number;
            self::$min = $min;
            self::$maj = $maj;
            self::$otca = $otca;
        }

        /**
         * @return string
         */
        public static function getGenPass(){
            $caract = '';
            $poss = 0;
            if(self::$number === true){
                $caract .= '123456789';
                $poss += 9;
            }

            if(self::$min === true){
                $caract .= 'abcdefghijklmnopqrstuvwxyz';
                $poss += 26;
            }

            if(self::$maj === true){
                $caract .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $poss += 26;
            }

            if(self::$otca === true){
                $caract .= '&#{([-_@)]=}+$§?';
                $poss += 17;
            }

            $gener = '';
            for($i = 0; $i <= self::$size; $i++){
                $rand = mt_rand(0, $poss - 1);
                $gener .= $caract[ $rand ];
            }

            return $gener;
        }
    }