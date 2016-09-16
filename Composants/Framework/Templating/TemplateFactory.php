<?php
    namespace Composants\Framework\Templating;
    use Composants\Framework\Templating\View;

    class TemplateFactory{
        /**
         * @var string
         */
        private $bundle = '';

        /**
         * @var string
         */
        private $include = '';

        /**
         * @param string $bundle
         */
        public function init($bundle){
            $this->bundle = $bundle.'Bundle';
        }

        /**
         * @param string $file
         */
        public function includeView($file){
            $this->include = $file;
        }

        /**
         * @param string $file
         * @param array $param
         * @return \Composants\Framework\Templating\View
         */
        public function view($file, $param = []){
            $params = [
                'bundle' => $this->bundle,
                'include' => $this->include
            ];
            
            array_push($params, $param);

            return new View($file, $params);
        }
    }