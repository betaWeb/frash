<?php
    namespace LFW\Framework\Forms;

    /**
     * Interface FormTypeInterface
     * @package LFW\Framework\Forms
     */
    interface FormTypeInterface{
        public function __construct($spec);
        public function getInput();
    }