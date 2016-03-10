<?php
    namespace Composants\Framework\Utility\GenPass;

    /**
     * Class GenPass
     * @package Composants\Framework\Utility\GenPass
     */
    class GenPass{
        /**
         * @var
         */
        private $size;

        /**
         * @var bool
         */
        private $number = false;

        /**
         * @var bool
         */
        private $min = false;

        /**
         * @var bool
         */
        private $maj = false;

        /**
         * @var bool
         */
        private $otca = false;

        /**
         * GenPass constructor.
         * @param $size
         * @param $number
         * @param $min
         * @param $maj
         * @param $otca
         */
        public function __construct($size, $number, $min, $maj, $otca){
            $this->size = $size;
            $this->number = $number;
            $this->min = $min;
            $this->maj = $maj;
            $this->otca = $otca;
        }

        /**
         * @return string
         */
        public function getGenPass(){
            $array = [];
            $poss = 0;
            if($this->number === true){
                $array[] = [ 1, 2, 3, 4, 5, 6, 7, 8, 9 ];
                $poss += 9;
            }

            if($this->min === true){
                $array[] = [ 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' ];
                $poss += 26;
            }

            if($this->maj === true){
                $array[] = [ 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' ];
                $poss += 26;
            }

            if($this->otca === true){
                $array[] = [ '&', '#', '{', '(', '[', '-', '_', '/', '@', ')', ']', '=', '}', '+', '$', '§', '?' ];
                $poss += 17;
            }

            $gener = '';
            for($i = 0; $i <= $this->size; $i++){
                $rand = rand(0, $poss - 1);
                $gener .= $array[ $rand ];
            }

            return $gener;
        }
    }