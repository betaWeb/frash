<?php
    namespace LFW\Framework\Reflection\Annotations;

    /**
     * Class AnnotationObject
     * @package LFW\Framework\Reflection\Annotations
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

                    if($expl[0] == '@@auto_increment'){
                        $types['autoinc'][ $name ] = $expl[1];
                    }

                    if($expl[0] == '@@type' && !empty($expl[1])){
                        $types['type'][ $name ] = $expl[1];
                    }
                }
            }

            return $types;
        }
    }