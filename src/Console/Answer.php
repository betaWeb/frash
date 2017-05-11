<?php
namespace Frash\Console;

/**
 * Class Answer
 * @package Frash\Console
 */
class Answer
{
    /**
     * @param string $text
     * @return mixed
     */
    public static function define(string $text)
    {
        fwrite(STDOUT, $text);
        return (string) trim(fgets(STDIN));
    }
}