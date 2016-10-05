<?php
    namespace Composants\Framework\Controller\Annotations;

    /**
     * Class AnnotationFactory
     * @package Composants\Framework\Controller\Annotations
     */
    class AnnotationFactory{
        /**
         * @var string
         */
        private $class = '';

        /**
         * @var \ReflectionClass
         */
        private $reflection;

        /**
         * AnnotationFactory constructor.
         * @param string $class
         */
        public function __construct($class){
            $this->class = $class;
            $this->reflection = new \ReflectionClass($this->class);
        }

        public function annotObject(){
            $obj = new AnnotationObject;
            return $obj->determinate($this->reflection->getProperties());
        }
    }