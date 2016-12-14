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
         * @return \LFW\Framework\Forms\VerifForm
         */
        public function verif(){
            return new VerifForm;
        }

        /**
         * @return \LFW\Framework\Forms\CreateForm
         */
        public function create(){
            return new CreateForm(self::PATH);
        }

        /**
         * @return \LFW\Framework\Forms\CreateFormSql
         */
        public function createSql(Dic $dic){
            return new CreateFormSql(self::PATH, $dic);
        }

        /**
         * @return object
         */
        public function getPost(){
            return (object) $_POST;
        }
    }