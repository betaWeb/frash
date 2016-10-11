<?php
    namespace LFW\ORM;

    /**
     * Interface RequestInterface
     * @package LFW\ORM
     */
    interface RequestInterface{
        public function getExecute();
        public function getRequest();
        public function setExecute($exec);
    }