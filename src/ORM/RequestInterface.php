<?php
namespace Frash\ORM;

/**
 * Interface RequestInterface
 * @package Frash\ORM
 */
interface RequestInterface{
    public function getExecute();
    public function getRequest();
    public function setExecute(array $exec);
}