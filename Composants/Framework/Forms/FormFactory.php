<?php
    namespace Composants\Framework\Forms;
    use Composants\Framework\DIC\Dic;
    use Composants\Framework\Forms\VerifForm;
    use Composants\Framework\Forms\CreateForm;
    use Composants\Framework\Forms\CreateFormSql;

    /**
     * Class FormFactory
     * @package Composants\Framework\Forms
     */
    class FormFactory{
        const PATH = 'Composants\\Framework\\Forms\\Type\\';

        /**
         * @return \Composants\Framework\Forms\VerifForm
         */
        public function verif(){
            return new VerifForm;
        }

        /**
         * @return \Composants\Framework\Forms\CreateForm
         */
        public function create(){
            return new CreateForm(self::PATH);
        }

        /**
         * @return \Composants\Framework\Forms\CreateFormSql
         */
        public function createSql(Dic $dic){
            return new CreateFormSql(self::PATH, $dic);
        }
    }