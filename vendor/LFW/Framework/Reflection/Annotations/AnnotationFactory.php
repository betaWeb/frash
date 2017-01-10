<?php
    namespace LFW\Framework\Reflection\Annotations;
    use LFW\Framework\Reflection\Annotations\AnnotationObject;

    /**
     * Class AnnotationFactory
     * @package LFW\Framework\Reflection\Annotations
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
        public function __construct(string $class){
            $this->class = $class;
            $this->reflection = new \ReflectionClass($this->class);
        }

        public function annotObject(){
            $obj = new AnnotationObject;
            return $obj->determinate($this->reflection->getProperties());
        }
    }