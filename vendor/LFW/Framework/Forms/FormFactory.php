<?php
    namespace LFW\Framework\Forms;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\Forms\VerifForm;
    use LFW\Framework\Forms\CreateForm;
    use LFW\Framework\Forms\CreateFormSql;

    /**
     * Class FormFactory
     * @package LFW\Framework\Forms
     */
    class FormFactory{
        const PATH = 'LFW\\Framework\\Forms\\Type\\';

        /**
         * @var Dic
         */
        private $dic;

        /**
         * FormFactory constructor.
         * @param Dic $dic
         */
        public function __construct(Dic $dic){
            $this->dic = $dic;
        }

        /**
         * @return \LFW\Framework\Forms\VerifForm
         */
        public function verif(){
            return new VerifForm;
        }

        /**
         * @return \LFW\Framework\Forms\CreateForm
         */
        public function create(){
            return new CreateForm(self::PATH, $this->dic);
        }

        /**
         * @return \LFW\Framework\Forms\CreateFormSql
         */
        public function createSql(){
            return new CreateFormSql(self::PATH, $this->dic);
        }

        /**
         * @return object
         */
        public function getPost(){
            return (object) $_POST;
        }
    }