<?php
    namespace Composants\ORM;

    /**
     * Interface RequestInterface
     * @package Composants\ORM
     */
    interface RequestInterface{
        public function getExecute();
        public function getRequest();
        public function setExecute($exec);
    }