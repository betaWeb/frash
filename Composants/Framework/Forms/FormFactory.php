<?php
    namespace Composants\Framework\Forms;
    use Composants\Framework\DIC\Dic;
    use Composants\Framework\Forms\VerifForm;
    use Composants\Framework\Forms\CreateForm;

    /**
     * Class FormFactory
     * @package Composants\Framework\Forms
     */
    class FormFactory{
        /**
         * @var string
         */
        private $uri = '';

        /**
         * FormFactory constructor.
         * @param Dic $dic
         */
        public function __construct($dic){
            $this->uri = $dic->open('get')->get('uri');
        }

        /**
         * @return \Composants\Framework\Forms\VerifForm
         */
        public function verif(){
            return new VerifForm;
        }

        /**
         * @param string $uri
         * @return \Composants\Framework\Forms\CreateForm
         */
        public function create(){
            return new CreateForm($this->uri);
        }
    }