<?php
namespace Frash\ORM;

/**
 * Interface RequestInterface
 * @package Frash\ORM
 */
interface RequestInterface{
    public function execute(array $exec);
    public function getExecute();
    public function getRequest();
}