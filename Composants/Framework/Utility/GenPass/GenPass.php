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
            $caract = '';
            $poss = 0;
            if($this->number === true){
                $caract .= '123456789';
                $poss += 9;
            }

            if($this->min === true){
                $caract .= 'abcdefghijklmnopqrstuvwxyz';
                $poss += 26;
            }

            if($this->maj === true){
                $caract .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $poss += 26;
            }

            if($this->otca === true){
                $caract .= '&#{([-_/@)]=}+$§?';
                $poss += 17;
            }

            $gener = '';
            for($i = 0; $i <= $this->size; $i++){
                $rand = mt_rand(0, $poss - 1);
                $gener .= $caract[ $rand ];
            }

            return $gener;
        }
    }