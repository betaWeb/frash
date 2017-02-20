<?php
namespace Frash\Framework\Forms;

/**
 * Interface FormTypeInterface
 * @package Frash\Framework\Forms
 */
interface FormTypeInterface{
    public function __construct($spec);
    public function getInput();
}