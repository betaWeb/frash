<?php
    namespace Composants\Framework\Forms;

    /**
     * Interface FormTypeInterface
     * @package Composants\Framework\Forms
     */
    interface FormTypeInterface{
        public function __construct($spec);
        public function getInput();
    }