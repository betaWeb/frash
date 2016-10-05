<?php
    namespace Composants\Framework\Controller\Annotations;

    /**
     * Class AnnotationObject
     * @package Composants\Framework\Controller\Annotations
     */
    class AnnotationObject{
        /**
         * @param object $properties
         * @return array
         */
        public function determinate($properties){
            $types = [];

            foreach($properties as $object){
                $name = $object->name;
                $comm = explode("\n", $object->getDocComment());
                $count = count($comm);

                for($i = 1; $i <= $count - 2; $i++){
                    $comm[ $i ] = substr($comm[ $i ], strpos($comm[ $i ], '@'));
                }

                foreach($comm as $c){
                    $expl = explode(' ', $c);

                    if($expl[0] == '@@type' && !empty($expl[1])){
                        $types[ $name ] = $expl[1];
                    }
                }
            }

            return $types;
        }
    }