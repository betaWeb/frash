<?php
    namespace Composants\Framework\Utility\Forms;

    /**
     * Class CreateForm
     * @package Composants\Framework\Utility\Forms
     */
    class CreateForm{
        const PATH = 'Composants\\Framework\\Utility\\Forms\\Type\\';

        /**
         * @param string $type_form
         * @param array $spec
         * @return string
         */
        public function create($type_form, $spec){
            $routing = self::PATH.$type_form;
            $type = new $routing($spec);
            return $type->getInput();
        }
    }